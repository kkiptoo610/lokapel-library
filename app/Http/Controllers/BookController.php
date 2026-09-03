<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        /*
        |--------------------------------------------------------------------------
        | MAIN CATEGORIES
        |--------------------------------------------------------------------------
        |
        | Main categories have parent_id = NULL.
        |
        */

        $categories = Category::query()
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | SUBCATEGORIES
        |--------------------------------------------------------------------------
        |
        | Subcategories have parent_id filled.
        |
        */

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
     * Return subcategories for selected category.
     */
    public function subcategories(Category $category)
    {
        /*
        |--------------------------------------------------------------------------
        | ENSURE CATEGORY IS A MAIN CATEGORY
        |--------------------------------------------------------------------------
        */

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

            'author' => [
                'required',
                'string',
                'max:255',
            ],

            /*
            |--------------------------------------------------------------------------
            | MAIN CATEGORY
            |--------------------------------------------------------------------------
            */

            'category_id' => [
                'required',
                'exists:categories,id',
            ],

            /*
            |--------------------------------------------------------------------------
            | SUBCATEGORY
            |--------------------------------------------------------------------------
            */

            'subcategory_id' => [
                'nullable',
                'exists:categories,id',
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

            'shelf_location' => [
                'nullable',
                'string',
                'max:255',
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


        /*
        |--------------------------------------------------------------------------
        | ENSURE SELECTED CATEGORY IS MAIN CATEGORY
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | ENSURE SUBCATEGORY BELONGS TO MAIN CATEGORY
        |--------------------------------------------------------------------------
        */

        if (
            !empty(
                $validated['subcategory_id']
            )
        ) {

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

        }


        /*
        |--------------------------------------------------------------------------
        | ENSURE COPY COUNT MATCHES
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | CREATE BOOK
        |--------------------------------------------------------------------------
        */

        DB::transaction(
            function () use ($validated) {

                $book = Book::create([

                    'title' =>
                        $validated['title'],

                    'book_code' =>
                        trim(
                            $validated['book_code']
                        ),

                    'author' =>
                        $validated['author'],

                    'category_id' =>
                        $validated['category_id'],

                    'subcategory_id' =>
                        $validated['subcategory_id']
                        ?? null,

                    'isbn' =>
                        $validated['isbn']
                        ?? null,

                    'publisher' =>
                        $validated['publisher']
                        ?? null,

                    'publication_year' =>
                        $validated['publication_year']
                        ?? null,

                    'total_copies' =>
                        $validated['total_copies'],

                    'available_copies' =>
                        $validated['total_copies'],

                    'shelf_location' =>
                        $validated['shelf_location']
                        ?? null,

                ]);


                /*
                |--------------------------------------------------------------------------
                | CREATE PHYSICAL COPIES
                |--------------------------------------------------------------------------
                */

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
        /*
        |--------------------------------------------------------------------------
        | MAIN CATEGORIES
        |--------------------------------------------------------------------------
        */

        $categories = Category::query()
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | ALL SUBCATEGORIES
        |--------------------------------------------------------------------------
        */

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

            'author' => [
                'required',
                'string',
                'max:255',
            ],

            'category_id' => [
                'required',
                'exists:categories,id',
            ],

            'subcategory_id' => [
                'nullable',
                'exists:categories,id',
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

            'shelf_location' => [
                'nullable',
                'string',
                'max:255',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | ENSURE CATEGORY IS A MAIN CATEGORY
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | ENSURE SUBCATEGORY BELONGS TO CATEGORY
        |--------------------------------------------------------------------------
        */

        if (
            !empty(
                $validated['subcategory_id']
            )
        ) {

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


                    /*
                    |--------------------------------------------------------------------------
                    | UPDATE BOOK
                    |--------------------------------------------------------------------------
                    */

                    $book->update([

                        'title' =>
                            $validated['title'],

                        'book_code' =>
                            trim(
                                $validated['book_code']
                            ),

                        'author' =>
                            $validated['author'],

                        'category_id' =>
                            $validated['category_id'],

                        'subcategory_id' =>
                            $validated['subcategory_id']
                            ?? null,

                        'isbn' =>
                            $validated['isbn']
                            ?? null,

                        'publisher' =>
                            $validated['publisher']
                            ?? null,

                        'publication_year' =>
                            $validated['publication_year']
                            ?? null,

                        'shelf_location' =>
                            $validated['shelf_location']
                            ?? null,

                    ]);


                    /*
                    |--------------------------------------------------------------------------
                    | ADD COPIES
                    |--------------------------------------------------------------------------
                    */

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


                    /*
                    |--------------------------------------------------------------------------
                    | REMOVE AVAILABLE COPIES
                    |--------------------------------------------------------------------------
                    */

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


                    /*
                    |--------------------------------------------------------------------------
                    | RECALCULATE TOTALS
                    |--------------------------------------------------------------------------
                    */

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


        /*
        |--------------------------------------------------------------------------
        | PROTECT BORROWED COPY
        |--------------------------------------------------------------------------
        */

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