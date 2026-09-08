<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BookController extends Controller
{
    /**
     * Display all books.
     */
    public function index(Request $request)
    {
        $query = Book::with([
            'category',
            'subcategory',
            'copies',
        ]);

        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(
                function ($q) use ($search) {

                    $q->where(
                        'title',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'book_code',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'author',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'isbn',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'shelf_location',
                        'like',
                        "%{$search}%"
                    );

                }
            );

        }

        $books = $query
            ->latest()
            ->get();

        return view(
            'books.index',
            compact('books')
        );
    }


    /**
     * Show create book form.
     */
    public function create()
    {
        $categories = Category::query()
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();

        $subcategories = Category::query()
            ->whereNotNull('parent_id')
            ->orderBy('name')
            ->get();

        return view(
            'books.create',
            compact(
                'categories',
                'subcategories'
            )
        );
    }


    /**
     * Show book import form.
     */
    public function showImportForm()
    {
        return view(
            'books.import'
        );
    }


    /**
     * Download the CSV import template.
     */
    public function downloadTemplate(): StreamedResponse
    {
        $fileName = 'books-import-template.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' =>
                'attachment; filename="' . $fileName . '"',
        ];

        $columns = [
            'title',
            'book code',
            'category',
            'subcategory',
            'shelf',
            'author',
            'copies',
        ];

        /*
        |--------------------------------------------------------------------------
        | SAMPLE DATA
        |--------------------------------------------------------------------------
        |
        | These are example rows only.
        | The category and subcategory names must exist in your database
        | before importing the file.
        |
        */

        $sampleRows = [
            [
                'Example Book Title',
                'BOOK-001',
                'Example Category',
                'Example Subcategory',
                'Shelf A1',
                'John Doe',
                '3',
            ],
            [
                'Another Book',
                'BOOK-002',
                'Example Category',
                'Example Subcategory',
                'Shelf A2',
                'Jane Doe',
                '2',
            ],
        ];

        return response()->stream(
            function () use (
                $columns,
                $sampleRows
            ) {

                $output = fopen(
                    'php://output',
                    'w'
                );

                /*
                |--------------------------------------------------------------------------
                | UTF-8 BOM
                |--------------------------------------------------------------------------
                |
                | Helps Microsoft Excel display UTF-8 correctly.
                |
                */

                fwrite(
                    $output,
                    "\xEF\xBB\xBF"
                );

                fputcsv(
                    $output,
                    $columns
                );

                foreach (
                    $sampleRows
                    as $row
                ) {

                    fputcsv(
                        $output,
                        $row
                    );

                }

                fclose(
                    $output
                );

            },
            200,
            $headers
        );
    }


    /**
     * Import books from CSV or Excel file.
     */
    public function import(Request $request)
    {
        $request->validate([

            'file' => [
                'required',
                'file',
                'mimes:csv,txt,xlsx,xls',
                'max:10240',
            ],

        ]);

        $file = $request->file(
            'file'
        );

        $extension = strtolower(
            $file->getClientOriginalExtension()
        );

        try {

            /*
            |--------------------------------------------------------------------------
            | READ FILE
            |--------------------------------------------------------------------------
            */

            if (
                $extension === 'csv'
                ||
                $extension === 'txt'
            ) {

                $rows = $this->readCsvFile(
                    $file->getRealPath()
                );

            } else {

                return back()
                    ->with(
                        'error',
                        'Excel import requires an Excel reader package. Please install PhpSpreadsheet or Laravel Excel first.'
                    );

            }

            if (
                count($rows) < 2
            ) {

                return back()
                    ->with(
                        'error',
                        'The import file does not contain any book records.'
                    );

            }


            /*
            |--------------------------------------------------------------------------
            | NORMALIZE HEADERS
            |--------------------------------------------------------------------------
            */

            $headers = array_map(
                function ($header) {

                    return strtolower(
                        trim(
                            preg_replace(
                                '/^\xEF\xBB\xBF/',
                                '',
                                $header
                            )
                        )
                    );

                },
                array_shift(
                    $rows
                )
            );


            /*
            |--------------------------------------------------------------------------
            | REQUIRED HEADERS
            |--------------------------------------------------------------------------
            */

            $requiredHeaders = [

                'title',

                'book code',

                'category',

                'subcategory',

                'shelf',

                'author',

                'copies',

            ];


            foreach (
                $requiredHeaders
                as $requiredHeader
            ) {

                if (
                    !in_array(
                        $requiredHeader,
                        $headers
                    )
                ) {

                    return back()
                        ->with(
                            'error',
                            'Missing required column: ' .
                            $requiredHeader
                        );

                }

            }


            /*
            |--------------------------------------------------------------------------
            | HEADER INDEXES
            |--------------------------------------------------------------------------
            */

            $titleIndex =
                array_search(
                    'title',
                    $headers
                );

            $bookCodeIndex =
                array_search(
                    'book code',
                    $headers
                );

            $categoryIndex =
                array_search(
                    'category',
                    $headers
                );

            $subcategoryIndex =
                array_search(
                    'subcategory',
                    $headers
                );

            $shelfIndex =
                array_search(
                    'shelf',
                    $headers
                );

            $authorIndex =
                array_search(
                    'author',
                    $headers
                );

            $copiesIndex =
                array_search(
                    'copies',
                    $headers
                );


            /*
            |--------------------------------------------------------------------------
            | VALIDATE ALL ROWS BEFORE IMPORT
            |--------------------------------------------------------------------------
            */

            $importData = [];

            $bookCodesInFile = [];

            $rowNumber = 1;


            foreach (
                $rows
                as $row
            ) {

                $rowNumber++;


                /*
                |--------------------------------------------------------------------------
                | SKIP EMPTY ROWS
                |--------------------------------------------------------------------------
                */

                $rowIsEmpty = true;


                foreach (
                    $row
                    as $value
                ) {

                    if (
                        trim(
                            (string) $value
                        )
                        !== ''
                    ) {

                        $rowIsEmpty = false;

                        break;

                    }

                }


                if ($rowIsEmpty) {

                    continue;

                }


                /*
                |--------------------------------------------------------------------------
                | GET VALUES
                |--------------------------------------------------------------------------
                */

                $title =
                    trim(
                        $row[$titleIndex]
                        ?? ''
                    );


                $bookCode =
                    trim(
                        $row[$bookCodeIndex]
                        ?? ''
                    );


                $categoryName =
                    trim(
                        $row[$categoryIndex]
                        ?? ''
                    );


                $subcategoryName =
                    trim(
                        $row[$subcategoryIndex]
                        ?? ''
                    );


                $shelf =
                    trim(
                        $row[$shelfIndex]
                        ?? ''
                    );


                $author =
                    trim(
                        $row[$authorIndex]
                        ?? ''
                    );


                $copies =
                    $row[$copiesIndex]
                    ?? '';


                /*
                |--------------------------------------------------------------------------
                | REQUIRED FIELD VALIDATION
                |--------------------------------------------------------------------------
                */

                if (
                    $title === ''
                    ||
                    $bookCode === ''
                    ||
                    $categoryName === ''
                    ||
                    $subcategoryName === ''
                    ||
                    $shelf === ''
                    ||
                    $copies === ''
                ) {

                    return back()
                        ->with(
                            'error',
                            'Row ' .
                            $rowNumber .
                            ' contains missing required information.'
                        );

                }


                /*
                |--------------------------------------------------------------------------
                | VALIDATE COPIES
                |--------------------------------------------------------------------------
                */

                if (
                    !is_numeric(
                        $copies
                    )
                    ||
                    (int) $copies < 1
                ) {

                    return back()
                        ->with(
                            'error',
                            'Row ' .
                            $rowNumber .
                            ' must have at least 1 copy.'
                        );

                }


                /*
                |--------------------------------------------------------------------------
                | CHECK DUPLICATE BOOK CODE IN FILE
                |--------------------------------------------------------------------------
                */

                if (
                    in_array(
                        $bookCode,
                        $bookCodesInFile
                    )
                ) {

                    return back()
                        ->with(
                            'error',
                            'Row ' .
                            $rowNumber .
                            ': Duplicate Book Code "' .
                            $bookCode .
                            '" found in the import file.'
                        );

                }


                $bookCodesInFile[] =
                    $bookCode;


                /*
                |--------------------------------------------------------------------------
                | CHECK BOOK CODE IN DATABASE
                |--------------------------------------------------------------------------
                */

                if (
                    Book::where(
                        'book_code',
                        $bookCode
                    )->exists()
                ) {

                    return back()
                        ->with(
                            'error',
                            'Row ' .
                            $rowNumber .
                            ': Book Code "' .
                            $bookCode .
                            '" already exists.'
                        );

                }


                /*
                |--------------------------------------------------------------------------
                | CHECK MAIN CATEGORY
                |--------------------------------------------------------------------------
                */

                $category = Category::query()
                    ->where(
                        'name',
                        $categoryName
                    )
                    ->whereNull(
                        'parent_id'
                    )
                    ->first();


                if (!$category) {

                    return back()
                        ->with(
                            'error',
                            'Row ' .
                            $rowNumber .
                            ': Main category "' .
                            $categoryName .
                            '" does not exist.'
                        );

                }


                /*
                |--------------------------------------------------------------------------
                | CHECK SUBCATEGORY
                |--------------------------------------------------------------------------
                */

                $subcategory = Category::query()
                    ->where(
                        'name',
                        $subcategoryName
                    )
                    ->where(
                        'parent_id',
                        $category->id
                    )
                    ->first();


                if (!$subcategory) {

                    return back()
                        ->with(
                            'error',
                            'Row ' .
                            $rowNumber .
                            ': Subcategory "' .
                            $subcategoryName .
                            '" does not belong to category "' .
                            $categoryName .
                            '".'
                        );

                }


                /*
                |--------------------------------------------------------------------------
                | STORE VALIDATED ROW
                |--------------------------------------------------------------------------
                */

                $importData[] = [

                    'title' =>
                        $title,

                    'book_code' =>
                        $bookCode,

                    'category_id' =>
                        $category->id,

                    'subcategory_id' =>
                        $subcategory->id,

                    'shelf_location' =>
                        $shelf,

                    'author' =>
                        $author !== ''
                        ? $author
                        : null,

                    'copies' =>
                        (int) $copies,

                ];

            }


            if (
                count(
                    $importData
                ) === 0
            ) {

                return back()
                    ->with(
                        'error',
                        'No valid book records were found in the file.'
                    );

            }


            /*
            |--------------------------------------------------------------------------
            | IMPORT ALL BOOKS
            |--------------------------------------------------------------------------
            */

            DB::transaction(
                function () use (
                    $importData
                ) {

                    foreach (
                        $importData
                        as $data
                    ) {

                        $book = Book::create([

                            'title' =>
                                $data['title'],

                            'book_code' =>
                                $data['book_code'],

                            'author' =>
                                $data['author'],

                            'category_id' =>
                                $data['category_id'],

                            'subcategory_id' =>
                                $data['subcategory_id'],

                            'isbn' =>
                                null,

                            'publisher' =>
                                null,

                            'publication_year' =>
                                null,

                            'total_copies' =>
                                $data['copies'],

                            'available_copies' =>
                                $data['copies'],

                            'shelf_location' =>
                                $data['shelf_location'],

                        ]);


                        /*
                        |--------------------------------------------------------------------------
                        | CREATE PHYSICAL COPIES
                        |--------------------------------------------------------------------------
                        */

                        for (
                            $number = 1;
                            $number <= $data['copies'];
                            $number++
                        ) {

                            BookCopy::create([

                                'book_id' =>
                                    $book->id,

                                'accession_number' =>
                                    $this->generateAccessionNumber(),

                                'copy_number' =>
                                    $book->book_code
                                    .
                                    '-COPY-'
                                    .
                                    str_pad(
                                        $number,
                                        3,
                                        '0',
                                        STR_PAD_LEFT
                                    ),

                                'status' =>
                                    'available',

                            ]);

                        }

                    }

                }
            );


            return redirect()
                ->route(
                    'books.index'
                )
                ->with(
                    'success',
                    count(
                        $importData
                    ) .
                    ' book(s) imported successfully.'
                );

        } catch (
            \Exception $exception
        ) {

            return back()
                ->with(
                    'error',
                    'Import failed: ' .
                    $exception->getMessage()
                );

        }

    }


    /**
     * Read CSV import file.
     */
    private function readCsvFile(
        string $filePath
    )
    {
        $rows = [];

        $handle = fopen(
            $filePath,
            'r'
        );

        if (!$handle) {

            throw new \Exception(
                'Unable to read the CSV file.'
            );

        }

        while (
            (
                $row = fgetcsv(
                    $handle
                )
            )
            !== false
        ) {

            $rows[] = $row;

        }

        fclose(
            $handle
        );

        return $rows;
    }


    /**
     * Return subcategories for selected category.
     */
    public function subcategories(Category $category)
    {
        if ($category->parent_id !== null) {

            return response()->json([]);

        }

        $subcategories = Category::query()
            ->where(
                'parent_id',
                $category->id
            )
            ->orderBy('name')
            ->get([
                'id',
                'name',
                'parent_id',
            ]);

        return response()->json(
            $subcategories
        );
    }


    /**
     * Generate accession number.
     */
    private function generateAccessionNumber()
    {
        $lastCopy = BookCopy::orderByDesc(
            'id'
        )->first();

        $nextNumber = $lastCopy
            ? $lastCopy->id + 1
            : 1;

        return 'ACC/' .
            str_pad(
                $nextNumber,
                6,
                '0',
                STR_PAD_LEFT
            );
    }


    /**
     * Recalculate book totals.
     */
    private function recalculateBookTotals(Book $book)
    {
        $totalCopies = $book
            ->copies()
            ->count();

        $availableCopies = $book
            ->copies()
            ->where(
                'status',
                'available'
            )
            ->count();

        $book->update([

            'total_copies' =>
                $totalCopies,

            'available_copies' =>
                $availableCopies,

        ]);
    }


    /**
     * Store a new book.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'book_code' => [
                'required',
                'string',
                'max:100',
                'unique:books,book_code',
            ],

            'category_id' => [
                'required',
                'exists:categories,id',
            ],

            'subcategory_id' => [
                'required',
                'exists:categories,id',
            ],

            'shelf_location' => [
                'required',
                'string',
                'max:255',
            ],

            'author' => [
                'nullable',
                'string',
                'max:255',
            ],

            'isbn' => [
                'nullable',
                'string',
                'max:255',
                'unique:books,isbn',
            ],

            'publisher' => [
                'nullable',
                'string',
                'max:255',
            ],

            'publication_year' => [
                'nullable',
                'integer',
                'min:1000',
                'max:' . date('Y'),
            ],

            'total_copies' => [
                'required',
                'integer',
                'min:1',
            ],

            'copy_numbers' => [
                'required',
                'array',
                'min:1',
            ],

            'copy_numbers.*' => [
                'required',
                'string',
                'max:255',
                'distinct',
                'unique:book_copies,copy_number',
            ],

        ]);


        $mainCategory = Category::query()
            ->where(
                'id',
                $validated['category_id']
            )
            ->whereNull(
                'parent_id'
            )
            ->first();


        if (!$mainCategory) {

            return back()
                ->withInput()
                ->withErrors([

                    'category_id' =>
                        'Please select a valid main category.',

                ]);

        }


        $validSubcategory = Category::query()
            ->where(
                'id',
                $validated['subcategory_id']
            )
            ->where(
                'parent_id',
                $validated['category_id']
            )
            ->exists();


        if (!$validSubcategory) {

            return back()
                ->withInput()
                ->withErrors([

                    'subcategory_id' =>
                        'The selected subcategory does not belong to the selected category.',

                ]);

        }


        if (
            count(
                $validated['copy_numbers']
            )
            !==
            (int) $validated['total_copies']
        ) {

            return back()
                ->withInput()
                ->withErrors([

                    'copy_numbers' =>
                        'The number of copy numbers must match Total Copies.',

                ]);

        }


        DB::transaction(
            function () use ($validated) {

                $book = Book::create([

                    'title' =>
                        trim(
                            $validated['title']
                        ),

                    'book_code' =>
                        trim(
                            $validated['book_code']
                        ),

                    'author' =>
                        !empty(
                            $validated['author']
                        )
                        ? trim(
                            $validated['author']
                        )
                        : null,

                    'category_id' =>
                        $validated['category_id'],

                    'subcategory_id' =>
                        $validated['subcategory_id'],

                    'isbn' =>
                        !empty(
                            $validated['isbn']
                        )
                        ? trim(
                            $validated['isbn']
                        )
                        : null,

                    'publisher' =>
                        !empty(
                            $validated['publisher']
                        )
                        ? trim(
                            $validated['publisher']
                        )
                        : null,

                    'publication_year' =>
                        $validated['publication_year']
                        ?? null,

                    'total_copies' =>
                        $validated['total_copies'],

                    'available_copies' =>
                        $validated['total_copies'],

                    'shelf_location' =>
                        trim(
                            $validated['shelf_location']
                        ),

                ]);


                foreach (
                    $validated['copy_numbers']
                    as $copyNumber
                ) {

                    BookCopy::create([

                        'book_id' =>
                            $book->id,

                        'accession_number' =>
                            $this->generateAccessionNumber(),

                        'copy_number' =>
                            trim(
                                $copyNumber
                            ),

                        'status' =>
                            'available',

                    ]);

                }

            }
        );


        return redirect()
            ->route('books.index')
            ->with(
                'success',
                'Book and physical copies created successfully.'
            );
    }


    /**
     * Display a book.
     */
    public function show(Book $book)
    {
        $book->load([

            'category',

            'subcategory',

            'copies' => function ($query) {

                $query->orderBy(
                    'id'
                );

            },

            'borrowings' => function ($query) {

                $query
                    ->with([
                        'bookCopy',
                        'borrower',
                    ])
                    ->latest(
                        'borrowed_date'
                    );

            },

        ]);


        return view(
            'books.show',
            compact('book')
        );
    }


    /**
     * Show edit form.
     */
    public function edit(Book $book)
    {
        $categories = Category::query()
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();

        $subcategories = Category::query()
            ->whereNotNull('parent_id')
            ->orderBy('name')
            ->get();

        $book->load([

            'category',

            'subcategory',

            'copies' => function ($query) {

                $query->orderBy(
                    'id'
                );

            },

        ]);


        return view(
            'books.edit',
            compact(
                'book',
                'categories',
                'subcategories'
            )
        );
    }


    /**
     * Update book information.
     */
    public function update(
        Request $request,
        Book $book
    ) {

        $validated = $request->validate([

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'book_code' => [
                'required',
                'string',
                'max:100',
                'unique:books,book_code,' . $book->id,
            ],

            'category_id' => [
                'required',
                'exists:categories,id',
            ],

            'subcategory_id' => [
                'required',
                'exists:categories,id',
            ],

            'shelf_location' => [
                'required',
                'string',
                'max:255',
            ],

            'author' => [
                'nullable',
                'string',
                'max:255',
            ],

            'isbn' => [
                'nullable',
                'string',
                'max:255',
                'unique:books,isbn,' . $book->id,
            ],

            'publisher' => [
                'nullable',
                'string',
                'max:255',
            ],

            'publication_year' => [
                'nullable',
                'integer',
                'min:1000',
                'max:' . date('Y'),
            ],

            'total_copies' => [
                'required',
                'integer',
                'min:1',
            ],

        ]);


        $mainCategory = Category::query()
            ->where(
                'id',
                $validated['category_id']
            )
            ->whereNull(
                'parent_id'
            )
            ->exists();


        if (!$mainCategory) {

            return back()
                ->withInput()
                ->withErrors([

                    'category_id' =>
                        'Please select a valid main category.',

                ]);

        }


        $validSubcategory = Category::query()
            ->where(
                'id',
                $validated['subcategory_id']
            )
            ->where(
                'parent_id',
                $validated['category_id']
            )
            ->exists();


        if (!$validSubcategory) {

            return back()
                ->withInput()
                ->withErrors([

                    'subcategory_id' =>
                        'The selected subcategory does not belong to the selected category.',

                ]);

        }


        try {

            DB::transaction(
                function () use (
                    $validated,
                    $book
                ) {

                    $borrowedCopies = $book
                        ->copies()
                        ->where(
                            'status',
                            'borrowed'
                        )
                        ->count();


                    if (
                        $validated['total_copies']
                        <
                        $borrowedCopies
                    ) {

                        throw new \Exception(
                            'Total copies cannot be less than currently borrowed copies.'
                        );

                    }


                    $currentCopies = $book
                        ->copies()
                        ->count();


                    $book->update([

                        'title' =>
                            trim(
                                $validated['title']
                            ),

                        'book_code' =>
                            trim(
                                $validated['book_code']
                            ),

                        'author' =>
                            !empty(
                                $validated['author']
                            )
                            ? trim(
                                $validated['author']
                            )
                            : null,

                        'category_id' =>
                            $validated['category_id'],

                        'subcategory_id' =>
                            $validated['subcategory_id'],

                        'isbn' =>
                            !empty(
                                $validated['isbn']
                            )
                            ? trim(
                                $validated['isbn']
                            )
                            : null,

                        'publisher' =>
                            !empty(
                                $validated['publisher']
                            )
                            ? trim(
                                $validated['publisher']
                            )
                            : null,

                        'publication_year' =>
                            $validated['publication_year']
                            ?? null,

                        'shelf_location' =>
                            trim(
                                $validated['shelf_location']
                            ),

                    ]);


                    if (
                        $validated['total_copies']
                        >
                        $currentCopies
                    ) {

                        $copiesToAdd =
                            $validated['total_copies']
                            -
                            $currentCopies;


                        for (
                            $number = 1;
                            $number <= $copiesToAdd;
                            $number++
                        ) {

                            BookCopy::create([

                                'book_id' =>
                                    $book->id,

                                'accession_number' =>
                                    $this->generateAccessionNumber(),

                                'copy_number' =>
                                    $book->book_code
                                    .
                                    '-COPY-'
                                    .
                                    str_pad(
                                        $currentCopies + $number,
                                        3,
                                        '0',
                                        STR_PAD_LEFT
                                    ),

                                'status' =>
                                    'available',

                            ]);

                        }

                    }


                    if (
                        $validated['total_copies']
                        <
                        $currentCopies
                    ) {

                        $copiesToRemove =
                            $currentCopies
                            -
                            $validated['total_copies'];


                        $copies = $book
                            ->copies()
                            ->where(
                                'status',
                                'available'
                            )
                            ->orderByDesc(
                                'id'
                            )
                            ->take(
                                $copiesToRemove
                            )
                            ->get();


                        if (
                            $copies->count()
                            <
                            $copiesToRemove
                        ) {

                            throw new \Exception(
                                'Not enough available copies can be removed.'
                            );

                        }


                        foreach (
                            $copies
                            as $copy
                        ) {

                            $copy->delete();

                        }

                    }


                    $this->recalculateBookTotals(
                        $book
                    );

                }
            );

        } catch (\Exception $exception) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    $exception->getMessage()
                );

        }


        return redirect()
            ->route(
                'books.edit',
                $book
            )
            ->with(
                'success',
                'Book updated successfully.'
            );
    }


    /**
     * Add an individual physical copy.
     */
    public function storeCopy(
        Request $request,
        Book $book
    ) {

        $validated = $request->validate([

            'copy_number' => [
                'required',
                'string',
                'max:255',
                'unique:book_copies,copy_number',
            ],

            'status' => [
                'required',
                'in:available,lost,damaged',
            ],

        ]);


        DB::transaction(
            function () use (
                $validated,
                $book
            ) {

                BookCopy::create([

                    'book_id' =>
                        $book->id,

                    'accession_number' =>
                        $this->generateAccessionNumber(),

                    'copy_number' =>
                        trim(
                            $validated['copy_number']
                        ),

                    'status' =>
                        $validated['status'],

                ]);


                $this->recalculateBookTotals(
                    $book
                );

            }
        );


        return redirect()
            ->route(
                'books.edit',
                $book
            )
            ->with(
                'success',
                'New physical copy added successfully.'
            );
    }


    /**
     * Update an individual physical copy.
     */
    public function updateCopy(
        Request $request,
        Book $book,
        BookCopy $copy
    ) {

        if (
            $copy->book_id
            !==
            $book->id
        ) {

            abort(404);

        }


        $validated = $request->validate([

            'accession_number' => [
                'nullable',
                'string',
                'max:255',
                'unique:book_copies,accession_number,' . $copy->id,
            ],

            'copy_number' => [
                'required',
                'string',
                'max:255',
                'unique:book_copies,copy_number,' . $copy->id,
            ],

            'status' => [
                'required',
                'in:available,borrowed,lost,damaged',
            ],

        ]);


        if (
            $copy->status === 'borrowed'
            &&
            $validated['status'] !== 'borrowed'
        ) {

            return back()
                ->with(
                    'error',
                    'A borrowed copy must be returned through the borrowing system.'
                );

        }


        DB::transaction(
            function () use (
                $validated,
                $book,
                $copy
            ) {

                $copy->update([

                    'accession_number' =>
                        !empty(
                            $validated['accession_number']
                        )
                        ? trim(
                            $validated['accession_number']
                        )
                        : $copy->accession_number,

                    'copy_number' =>
                        trim(
                            $validated['copy_number']
                        ),

                    'status' =>
                        $validated['status'],

                ]);


                $this->recalculateBookTotals(
                    $book
                );

            }
        );


        return redirect()
            ->route(
                'books.edit',
                $book
            )
            ->with(
                'success',
                'Book copy updated successfully.'
            );
    }


    /**
     * Delete an individual copy.
     */
    public function destroyCopy(
        Book $book,
        BookCopy $copy
    ) {

        if (
            $copy->book_id
            !==
            $book->id
        ) {

            abort(404);

        }


        if (
            $copy->status === 'borrowed'
        ) {

            return back()
                ->with(
                    'error',
                    'A borrowed copy cannot be deleted.'
                );

        }


        DB::transaction(
            function () use (
                $book,
                $copy
            ) {

                $copy->delete();


                $this->recalculateBookTotals(
                    $book
                );

            }
        );


        return redirect()
            ->route(
                'books.edit',
                $book
            )
            ->with(
                'success',
                'Book copy deleted successfully.'
            );
    }


    /**
     * Delete a book.
     */
    public function destroy(Book $book)
    {
        $hasBorrowedCopies = $book
            ->copies()
            ->where(
                'status',
                'borrowed'
            )
            ->exists();


        if ($hasBorrowedCopies) {

            return redirect()
                ->route(
                    'books.index'
                )
                ->with(
                    'error',
                    'This book cannot be deleted because one or more copies are currently borrowed.'
                );

        }


        DB::transaction(
            function () use ($book) {

                $book
                    ->copies()
                    ->delete();


                $book->delete();

            }
        );


        return redirect()
            ->route(
                'books.index'
            )
            ->with(
                'success',
                'Book deleted successfully.'
            );
    }
}