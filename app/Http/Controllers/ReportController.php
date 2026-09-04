<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Borrowing;
use App\Models\Category;
use App\Models\Learner;
use App\Models\Staff;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ReportController extends Controller
{


    /**
     * --------------------------------------------------------------
     * UPDATE OVERDUE BORROWINGS
     * --------------------------------------------------------------
     */
    private function updateOverdueBorrowings(): void
    {

        Borrowing::where(
            'status',
            'borrowed'
        )
            ->whereNotNull(
                'due_date'
            )
            ->whereDate(
                'due_date',
                '<',
                Carbon::today()
            )
            ->update([
                'status' => 'overdue',
            ]);

    }



    /**
     * --------------------------------------------------------------
     * GET BORROWER MODEL CLASS
     * --------------------------------------------------------------
     */
    private function getBorrowerModelClass(
        ?string $borrowerType
    ): ?string {

        return match ($borrowerType) {

            'learner' => Learner::class,

            'teacher' => Teacher::class,

            'staff' => Staff::class,

            default => null,

        };

    }



    /**
     * --------------------------------------------------------------
     * GET BORROWER TYPE NAME
     * --------------------------------------------------------------
     */
    private function getBorrowerTypeName(
        ?string $borrowerType
    ): string {

        return match ($borrowerType) {

            Learner::class => 'Learner',

            Teacher::class => 'Teacher',

            Staff::class => 'Staff',

            default => 'Borrower',

        };

    }



    /**
     * --------------------------------------------------------------
     * APPLY BORROWER SEARCH
     * --------------------------------------------------------------
     */
    private function applyBorrowerSearch(
        $query,
        string $search
    ) {

        $query->orWhereHasMorph(
            'borrower',
            [
                Learner::class,
                Teacher::class,
                Staff::class,
            ],
            function (
                $borrowerQuery,
                $type
            ) use (
                $search
            ) {


                /*
                |------------------------------------------------------
                | LEARNERS
                |------------------------------------------------------
                */

                if (
                    $type === Learner::class
                ) {

                    $borrowerQuery
                        ->where(
                            'name',
                            'like',
                            '%' . $search . '%'
                        )
                        ->orWhere(
                            'admission_number',
                            'like',
                            '%' . $search . '%'
                        );

                    return;

                }



                /*
                |------------------------------------------------------
                | TEACHERS AND STAFF
                |------------------------------------------------------
                */

                $borrowerQuery->where(
                    'name',
                    'like',
                    '%' . $search . '%'
                );

            }
        );


        return $query;

    }



    /**
     * --------------------------------------------------------------
     * APPLY COMMON BORROWING FILTERS
     * --------------------------------------------------------------
     */
    private function applyBorrowingFilters(
        $query,
        Request $request
    ) {


        /*
        |--------------------------------------------------------------
        | DATE FILTERS
        |--------------------------------------------------------------
        */

        if (
            $request->filled(
                'from_date'
            )
        ) {

            $query->whereDate(
                'borrowed_date',
                '>=',
                $request->from_date
            );

        }


        if (
            $request->filled(
                'to_date'
            )
        ) {

            $query->whereDate(
                'borrowed_date',
                '<=',
                $request->to_date
            );

        }



        /*
        |--------------------------------------------------------------
        | STATUS FILTER
        |--------------------------------------------------------------
        */

        if (
            $request->filled(
                'status'
            )
        ) {

            $query->where(
                'status',
                $request->status
            );

        }



        /*
        |--------------------------------------------------------------
        | BORROWER TYPE FILTER
        |--------------------------------------------------------------
        */

        if (
            $request->filled(
                'borrower_type'
            )
        ) {

            $borrowerType =
                $this->getBorrowerModelClass(
                    $request->borrower_type
                );


            if (
                $borrowerType
            ) {

                $query->where(
                    'borrower_type',
                    $borrowerType
                );

            }

        }



        /*
        |--------------------------------------------------------------
        | CATEGORY FILTER
        |--------------------------------------------------------------
        */

        if (
            $request->filled(
                'category_id'
            )
        ) {

            $categoryId =
                $request->category_id;


            $query->whereHas(
                'book',
                function (
                    $bookQuery
                ) use (
                    $categoryId
                ) {

                    $bookQuery->where(
                        function (
                            $categoryQuery
                        ) use (
                            $categoryId
                        ) {


                            /*
                            |------------------------------------------
                            | DIRECT CATEGORY
                            |------------------------------------------
                            */

                            $categoryQuery->where(
                                'category_id',
                                $categoryId
                            );


                            /*
                            |------------------------------------------
                            | SUBCATEGORY
                            |------------------------------------------
                            */

                            $categoryQuery->orWhereHas(
                                'subcategory',
                                function (
                                    $subcategoryQuery
                                ) use (
                                    $categoryId
                                ) {

                                    $subcategoryQuery->where(
                                        'parent_id',
                                        $categoryId
                                    );

                                }
                            );

                        }
                    );

                }
            );

        }



        /*
        |--------------------------------------------------------------
        | SUBCATEGORY FILTER
        |--------------------------------------------------------------
        */

        if (
            $request->filled(
                'subcategory_id'
            )
        ) {

            $query->whereHas(
                'book',
                function (
                    $bookQuery
                ) use (
                    $request
                ) {

                    $bookQuery->where(
                        'subcategory_id',
                        $request->subcategory_id
                    );

                }
            );

        }



        /*
        |--------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------
        */

        if (
            $request->filled(
                'search'
            )
        ) {

            $search =
                trim(
                    (string) $request->search
                );


            $query->where(
                function (
                    $q
                ) use (
                    $search
                ) {


                    /*
                    |----------------------------------------------
                    | BOOK SEARCH
                    |----------------------------------------------
                    */

                    $q->whereHas(
                        'book',
                        function (
                            $bookQuery
                        ) use (
                            $search
                        ) {

                            $bookQuery
                                ->where(
                                    'title',
                                    'like',
                                    '%' . $search . '%'
                                )
                                ->orWhere(
                                    'author',
                                    'like',
                                    '%' . $search . '%'
                                )
                                ->orWhere(
                                    'book_code',
                                    'like',
                                    '%' . $search . '%'
                                )
                                ->orWhere(
                                    'isbn',
                                    'like',
                                    '%' . $search . '%'
                                );

                        }
                    );



                    /*
                    |----------------------------------------------
                    | PHYSICAL COPY SEARCH
                    |----------------------------------------------
                    */

                    $q->orWhereHas(
                        'bookCopy',
                        function (
                            $copyQuery
                        ) use (
                            $search
                        ) {

                            $copyQuery
                                ->where(
                                    'accession_number',
                                    'like',
                                    '%' . $search . '%'
                                )
                                ->orWhere(
                                    'copy_number',
                                    'like',
                                    '%' . $search . '%'
                                );

                        }
                    );



                    /*
                    |----------------------------------------------
                    | BORROWER SEARCH
                    |----------------------------------------------
                    */

                    $this->applyBorrowerSearch(
                        $q,
                        $search
                    );

                }
            );

        }


        return $query;

    }



    /**
     * --------------------------------------------------------------
     * BUILD INVENTORY QUERY
     * --------------------------------------------------------------
     */
    private function buildInventoryQuery(
        Request $request
    ) {


        $search =
            trim(
                (string) $request->input(
                    'search',
                    ''
                )
            );


        $categoryId =
            $request->input(
                'category_id'
            );


        $subcategoryId =
            $request->input(
                'subcategory_id'
            );


        $query =
            Book::with([

                'category',

                'subcategory.parent',

                'copies' => function (
                    $copyQuery
                ) {

                    $copyQuery->orderBy(
                        'id'
                    );

                },

            ]);



        /*
        |--------------------------------------------------------------
        | CATEGORY FILTER
        |--------------------------------------------------------------
        */

        if (
            $categoryId
        ) {

            $query->where(
                function (
                    $categoryQuery
                ) use (
                    $categoryId
                ) {

                    $categoryQuery
                        ->where(
                            'category_id',
                            $categoryId
                        )
                        ->orWhereHas(
                            'subcategory',
                            function (
                                $subcategoryQuery
                            ) use (
                                $categoryId
                            ) {

                                $subcategoryQuery->where(
                                    'parent_id',
                                    $categoryId
                                );

                            }
                        );

                }
            );

        }



        /*
        |--------------------------------------------------------------
        | SUBCATEGORY FILTER
        |--------------------------------------------------------------
        */

        if (
            $subcategoryId
        ) {

            $query->where(
                'subcategory_id',
                $subcategoryId
            );

        }



        /*
        |--------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------
        */

        if (
            $search !== ''
        ) {

            $query->where(
                function (
                    $query
                ) use (
                    $search
                ) {

                    $query
                        ->where(
                            'title',
                            'like',
                            '%' . $search . '%'
                        )
                        ->orWhere(
                            'author',
                            'like',
                            '%' . $search . '%'
                        )
                        ->orWhere(
                            'book_code',
                            'like',
                            '%' . $search . '%'
                        )
                        ->orWhere(
                            'isbn',
                            'like',
                            '%' . $search . '%'
                        )
                        ->orWhere(
                            'publisher',
                            'like',
                            '%' . $search . '%'
                        )
                        ->orWhere(
                            'shelf_location',
                            'like',
                            '%' . $search . '%'
                        );


                    $query->orWhereHas(
                        'category',
                        function (
                            $categoryQuery
                        ) use (
                            $search
                        ) {

                            $categoryQuery->where(
                                'name',
                                'like',
                                '%' . $search . '%'
                            );

                        }
                    );


                    $query->orWhereHas(
                        'subcategory',
                        function (
                            $subcategoryQuery
                        ) use (
                            $search
                        ) {

                            $subcategoryQuery->where(
                                'name',
                                'like',
                                '%' . $search . '%'
                            );

                        }
                    );


                    $query->orWhereHas(
                        'copies',
                        function (
                            $copyQuery
                        ) use (
                            $search
                        ) {

                            $copyQuery
                                ->where(
                                    'accession_number',
                                    'like',
                                    '%' . $search . '%'
                                )
                                ->orWhere(
                                    'copy_number',
                                    'like',
                                    '%' . $search . '%'
                                );

                        }
                    );

                }
            );

        }


        return $query
            ->orderBy(
                'title'
            );

    }



    /**
     * --------------------------------------------------------------
     * REPORTS DASHBOARD
     * --------------------------------------------------------------
     */
    public function index()
    {

        $this->updateOverdueBorrowings();


        $totalCopies =
            Book::sum(
                'total_copies'
            );


        $availableCopies =
            Book::sum(
                'available_copies'
            );


        $borrowedCopies =
            Borrowing::whereIn(
                'status',
                [
                    'borrowed',
                    'overdue',
                ]
            )
            ->count();


        $overdueCount =
            Borrowing::where(
                'status',
                'overdue'
            )
            ->count();


        $returnedCount =
            Borrowing::where(
                'status',
                'returned'
            )
            ->count();


        $totalBorrowings =
            Borrowing::count();


        $mostBorrowedBooks =
            Borrowing::select(
                'book_id',
                DB::raw(
                    'COUNT(*) as borrowing_count'
                )
            )
            ->with([
                'book',
            ])
            ->groupBy(
                'book_id'
            )
            ->orderByDesc(
                'borrowing_count'
            )
            ->limit(5)
            ->get();


        $recentBorrowings =
            Borrowing::with([
                'book',
                'bookCopy',
                'borrower',
            ])
            ->orderByDesc(
                'borrowed_date'
            )
            ->orderByDesc(
                'id'
            )
            ->limit(10)
            ->get();


        return view(
            'reports.index',
            compact(
                'totalCopies',
                'availableCopies',
                'borrowedCopies',
                'overdueCount',
                'returnedCount',
                'totalBorrowings',
                'mostBorrowedBooks',
                'recentBorrowings'
            )
        );

    }



    /**
     * --------------------------------------------------------------
     * GENERAL BORROWING REPORT
     * --------------------------------------------------------------
     */
    public function borrowings(
        Request $request
    ) {

        $this->updateOverdueBorrowings();


        $categories =
            Category::whereNull(
                'parent_id'
            )
            ->with(
                'children'
            )
            ->orderBy(
                'name'
            )
            ->get();


        $subcategories =
            Category::whereNotNull(
                'parent_id'
            )
            ->with(
                'parent'
            )
            ->orderBy(
                'name'
            )
            ->get();


        $query =
            Borrowing::with([

                'book.category',

                'book.subcategory.parent',

                'bookCopy',

                'borrower',

            ]);


        $query =
            $this->applyBorrowingFilters(
                $query,
                $request
            );


        $borrowings =
            $query
                ->orderByDesc(
                    'borrowed_date'
                )
                ->orderByDesc(
                    'id'
                )
                ->get();


        $totalRecords =
            $borrowings
                ->count();



        /*
        |--------------------------------------------------------------
        | GROUP BORROWINGS BY BOOK
        |--------------------------------------------------------------
        */

        $bookGroups =
            $borrowings
                ->groupBy(
                    'book_id'
                )
                ->map(
                    function (
                        $bookBorrowings
                    ) {

                        $book =
                            $bookBorrowings
                                ->first()
                                ->book;


                        $uniqueBorrowers =
                            $bookBorrowings
                                ->map(
                                    function (
                                        $borrowing
                                    ) {

                                        return
                                            $borrowing->borrower_type
                                            . '-'
                                            . $borrowing->borrower_id;

                                    }
                                )
                                ->unique()
                                ->count();


                        $currentlyBorrowed =
                            $bookBorrowings
                                ->whereIn(
                                    'status',
                                    [
                                        'borrowed',
                                        'overdue',
                                    ]
                                )
                                ->count();


                        $overdue =
                            $bookBorrowings
                                ->where(
                                    'status',
                                    'overdue'
                                )
                                ->count();


                        $returned =
                            $bookBorrowings
                                ->where(
                                    'status',
                                    'returned'
                                )
                                ->count();


                        return [

                            'book' =>
                                $book,

                            'book_id' =>
                                $book
                                    ? $book->id
                                    : null,

                            'total_borrowings' =>
                                $bookBorrowings
                                    ->count(),

                            'unique_borrowers' =>
                                $uniqueBorrowers,

                            'currently_borrowed' =>
                                $currentlyBorrowed,

                            'overdue' =>
                                $overdue,

                            'returned' =>
                                $returned,

                        ];

                    }
                );


        $totalBooks =
            $bookGroups
                ->count();



        /*
        |--------------------------------------------------------------
        | GROUP BOOKS BY CATEGORY
        |--------------------------------------------------------------
        */

        $groupedBorrowings =
            $bookGroups
                ->groupBy(
                    function (
                        $item
                    ) {

                        $book =
                            $item['book'];


                        if (
                            $book
                            &&
                            $book->subcategory
                            &&
                            $book->subcategory->parent
                        ) {

                            return
                                $book
                                    ->subcategory
                                    ->parent
                                    ->name;

                        }


                        if (
                            $book
                            &&
                            $book->category
                        ) {

                            return
                                $book
                                    ->category
                                    ->name;

                        }


                        return
                            'Uncategorized';

                    }
                )
                ->sortKeys();


        $totalCategories =
            $groupedBorrowings
                ->count();


        return view(
            'reports.borrowings',
            compact(
                'borrowings',
                'groupedBorrowings',
                'categories',
                'subcategories',
                'totalRecords',
                'totalBooks',
                'totalCategories'
            )
        );

    }



    /**
     * --------------------------------------------------------------
     * BOOK BORROWING DETAILS
     * --------------------------------------------------------------
     */
    public function borrowingBookDetails(
        Request $request,
        Book $book
    ) {

        $this->updateOverdueBorrowings();


        $query =
            Borrowing::with([
                'bookCopy',
                'borrower',
            ])
            ->where(
                'book_id',
                $book->id
            );


        if (
            $request->filled(
                'from_date'
            )
        ) {

            $query->whereDate(
                'borrowed_date',
                '>=',
                $request->from_date
            );

        }


        if (
            $request->filled(
                'to_date'
            )
        ) {

            $query->whereDate(
                'borrowed_date',
                '<=',
                $request->to_date
            );

        }


        if (
            $request->filled(
                'status'
            )
        ) {

            $query->where(
                'status',
                $request->status
            );

        }


        if (
            $request->filled(
                'borrower_type'
            )
        ) {

            $modelClass =
                $this->getBorrowerModelClass(
                    $request->borrower_type
                );


            if (
                $modelClass
            ) {

                $query->where(
                    'borrower_type',
                    $modelClass
                );

            }

        }


        if (
            $request->filled(
                'search'
            )
        ) {

            $search =
                trim(
                    (string) $request->search
                );


            $query->where(
                function (
                    $q
                ) use (
                    $search
                ) {

                    $q->whereHasMorph(
                        'borrower',
                        [
                            Learner::class,
                        ],
                        function (
                            $borrowerQuery
                        ) use (
                            $search
                        ) {

                            $borrowerQuery
                                ->where(
                                    'name',
                                    'like',
                                    '%' . $search . '%'
                                )
                                ->orWhere(
                                    'admission_number',
                                    'like',
                                    '%' . $search . '%'
                                );

                        }
                    );


                    $q->orWhereHasMorph(
                        'borrower',
                        [
                            Staff::class,
                            Teacher::class,
                        ],
                        function (
                            $borrowerQuery
                        ) use (
                            $search
                        ) {

                            $borrowerQuery->where(
                                'name',
                                'like',
                                '%' . $search . '%'
                            );

                        }
                    );

                }
            );

        }


        $bookBorrowings =
            $query
                ->orderByDesc(
                    'borrowed_date'
                )
                ->orderByDesc(
                    'id'
                )
                ->get();


        $borrowers =
            $bookBorrowings
                ->groupBy(
                    function (
                        $borrowing
                    ) {

                        return
                            $borrowing->borrower_type
                            . '-'
                            . $borrowing->borrower_id;

                    }
                )
                ->map(
                    function (
                        $borrowerBorrowings
                    ) {

                        $latest =
                            $borrowerBorrowings
                                ->first();


                        return [

                            'borrower' =>
                                $latest
                                    ->borrower,

                            'borrower_type' =>
                                $this
                                    ->getBorrowerTypeName(
                                        $latest
                                            ->borrower_type
                                    ),

                            'borrower_model' =>
                                $latest
                                    ->borrower_type,

                            'total_borrowings' =>
                                $borrowerBorrowings
                                    ->count(),

                            'active_borrowings' =>
                                $borrowerBorrowings
                                    ->whereIn(
                                        'status',
                                        [
                                            'borrowed',
                                            'overdue',
                                        ]
                                    )
                                    ->count(),

                            'latest_borrowing' =>
                                $latest,

                            'borrowings' =>
                                $borrowerBorrowings
                                    ->values(),

                        ];

                    }
                );


        $borrowerOrder = [

            Learner::class => 1,

            Staff::class => 2,

            Teacher::class => 3,

        ];


        $borrowers =
            $borrowers
                ->sort(
                    function (
                        $first,
                        $second
                    ) use (
                        $borrowerOrder
                    ) {

                        $firstTypeOrder =
                            $borrowerOrder[
                                $first['borrower_model']
                            ]
                            ?? 99;


                        $secondTypeOrder =
                            $borrowerOrder[
                                $second['borrower_model']
                            ]
                            ?? 99;


                        if (
                            $firstTypeOrder !==
                            $secondTypeOrder
                        ) {

                            return
                                $firstTypeOrder <=>
                                $secondTypeOrder;

                        }


                        $firstName =
                            strtolower(
                                $first['borrower']
                                    ->name
                                ?? ''
                            );


                        $secondName =
                            strtolower(
                                $second['borrower']
                                    ->name
                                ?? ''
                            );


                        return
                            $firstName <=>
                            $secondName;

                    }
                )
                ->values();


        return view(
            'reports.borrowing-book-details',
            compact(
                'book',
                'borrowers',
                'bookBorrowings'
            )
        );

    }



    /**
     * --------------------------------------------------------------
     * BORROWING REPORT PRINT PREVIEW
     * --------------------------------------------------------------
     */
    public function borrowingsPreview(
        Request $request
    ) {

        $this->updateOverdueBorrowings();


        $query =
            Borrowing::with([

                'book.category',

                'book.subcategory.parent',

                'bookCopy',

                'borrower',

            ]);


        $query =
            $this->applyBorrowingFilters(
                $query,
                $request
            );


        $borrowings =
            $query
                ->orderByDesc(
                    'borrowed_date'
                )
                ->orderByDesc(
                    'id'
                )
                ->get();


        $reportDate =
            Carbon::now();


        $category =
            $request->filled(
                'category_id'
            )
                ? Category::find(
                    $request->category_id
                )
                : null;


        $subcategory =
            $request->filled(
                'subcategory_id'
            )
                ? Category::with(
                    'parent'
                )->find(
                    $request->subcategory_id
                )
                : null;


        return view(
            'reports.borrowings-preview',
            compact(
                'borrowings',
                'reportDate',
                'category',
                'subcategory'
            )
        );

    }



    /**
     * --------------------------------------------------------------
     * OVERDUE BOOKS REPORT
     * --------------------------------------------------------------
     */
    public function overdue(
        Request $request
    ) {

        $this->updateOverdueBorrowings();


        $query =
            Borrowing::with([
                'book',
                'bookCopy',
                'borrower',
            ])
            ->where(
                'status',
                'overdue'
            );


        if (
            $request->filled(
                'borrower_type'
            )
        ) {

            $borrowerType =
                $this->getBorrowerModelClass(
                    $request->borrower_type
                );


            if (
                $borrowerType
            ) {

                $query->where(
                    'borrower_type',
                    $borrowerType
                );

            }

        }


        $borrowings =
            $query
                ->orderBy(
                    'due_date'
                )
                ->orderByDesc(
                    'id'
                )
                ->get();


        return view(
            'reports.overdue',
            compact(
                'borrowings'
            )
        );

    }



    /**
     * --------------------------------------------------------------
     * OVERDUE BOOKS PRINT PREVIEW
     * --------------------------------------------------------------
     */
    public function overduePreview(
        Request $request
    ) {

        $this->updateOverdueBorrowings();


        $query =
            Borrowing::with([
                'book',
                'bookCopy',
                'borrower',
            ])
            ->where(
                'status',
                'overdue'
            );


        if (
            $request->filled(
                'borrower_type'
            )
        ) {

            $borrowerType =
                $this->getBorrowerModelClass(
                    $request->borrower_type
                );


            if (
                $borrowerType
            ) {

                $query->where(
                    'borrower_type',
                    $borrowerType
                );

            }

        }


        $borrowings =
            $query
                ->orderBy(
                    'due_date'
                )
                ->orderByDesc(
                    'id'
                )
                ->get();


        $reportDate =
            Carbon::now();


        return view(
            'reports.overdue-preview',
            compact(
                'borrowings',
                'reportDate'
            )
        );

    }



    /**
     * --------------------------------------------------------------
     * RETURNED BOOKS REPORT
     * --------------------------------------------------------------
     */
    public function returned(
        Request $request
    ) {

        $query =
            Borrowing::with([
                'book',
                'bookCopy',
                'borrower',
            ])
            ->where(
                'status',
                'returned'
            );


        if (
            $request->filled(
                'from_date'
            )
        ) {

            $query->whereDate(
                'returned_date',
                '>=',
                $request->from_date
            );

        }


        if (
            $request->filled(
                'to_date'
            )
        ) {

            $query->whereDate(
                'returned_date',
                '<=',
                $request->to_date
            );

        }


        $borrowings =
            $query
                ->orderByDesc(
                    'returned_date'
                )
                ->orderByDesc(
                    'id'
                )
                ->get();


        return view(
            'reports.returned',
            compact(
                'borrowings'
            )
        );

    }



    /**
     * --------------------------------------------------------------
     * RETURNED BOOKS PRINT PREVIEW
     * --------------------------------------------------------------
     */
    public function returnedPreview(
        Request $request
    ) {

        $query =
            Borrowing::with([
                'book',
                'bookCopy',
                'borrower',
            ])
            ->where(
                'status',
                'returned'
            );


        if (
            $request->filled(
                'from_date'
            )
        ) {

            $query->whereDate(
                'returned_date',
                '>=',
                $request->from_date
            );

        }


        if (
            $request->filled(
                'to_date'
            )
        ) {

            $query->whereDate(
                'returned_date',
                '<=',
                $request->to_date
            );

        }


        $borrowings =
            $query
                ->orderByDesc(
                    'returned_date'
                )
                ->orderByDesc(
                    'id'
                )
                ->get();


        $reportDate =
            Carbon::now();


        return view(
            'reports.returned-preview',
            compact(
                'borrowings',
                'reportDate'
            )
        );

    }



    /**
     * --------------------------------------------------------------
     * DAMAGED BOOKS REPORT
     * --------------------------------------------------------------
     */
    public function damaged(
        Request $request
    ) {

        $query =
            BookCopy::with([
                'book.category',
                'book.subcategory.parent',
            ])
            ->where(
                'status',
                'damaged'
            );


        /*
        |--------------------------------------------------------------
        | CATEGORY FILTER
        |--------------------------------------------------------------
        */

        if (
            $request->filled(
                'category_id'
            )
        ) {

            $categoryId =
                $request->category_id;


            $query->whereHas(
                'book',
                function (
                    $bookQuery
                ) use (
                    $categoryId
                ) {

                    $bookQuery->where(
                        function (
                            $categoryQuery
                        ) use (
                            $categoryId
                        ) {

                            $categoryQuery
                                ->where(
                                    'category_id',
                                    $categoryId
                                )
                                ->orWhereHas(
                                    'subcategory',
                                    function (
                                        $subcategoryQuery
                                    ) use (
                                        $categoryId
                                    ) {

                                        $subcategoryQuery->where(
                                            'parent_id',
                                            $categoryId
                                        );

                                    }
                                );

                        }
                    );

                }
            );

        }



        /*
        |--------------------------------------------------------------
        | SUBCATEGORY FILTER
        |--------------------------------------------------------------
        */

        if (
            $request->filled(
                'subcategory_id'
            )
        ) {

            $query->whereHas(
                'book',
                function (
                    $bookQuery
                ) use (
                    $request
                ) {

                    $bookQuery->where(
                        'subcategory_id',
                        $request->subcategory_id
                    );

                }
            );

        }



        /*
        |--------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------
        */

        if (
            $request->filled(
                'search'
            )
        ) {

            $search =
                trim(
                    (string) $request->search
                );


            $query->where(
                function (
                    $copyQuery
                ) use (
                    $search
                ) {

                    $copyQuery
                        ->where(
                            'accession_number',
                            'like',
                            '%' . $search . '%'
                        )
                        ->orWhere(
                            'copy_number',
                            'like',
                            '%' . $search . '%'
                        )
                        ->orWhereHas(
                            'book',
                            function (
                                $bookQuery
                            ) use (
                                $search
                            ) {

                                $bookQuery
                                    ->where(
                                        'title',
                                        'like',
                                        '%' . $search . '%'
                                    )
                                    ->orWhere(
                                        'author',
                                        'like',
                                        '%' . $search . '%'
                                    )
                                    ->orWhere(
                                        'book_code',
                                        'like',
                                        '%' . $search . '%'
                                    )
                                    ->orWhere(
                                        'isbn',
                                        'like',
                                        '%' . $search . '%'
                                    );

                            }
                        );

                }
            );

        }


        $copies =
            $query
                ->orderBy(
                    'accession_number'
                )
                ->orderBy(
                    'copy_number'
                )
                ->get();


        $categories =
            Category::whereNull(
                'parent_id'
            )
            ->with(
                'children'
            )
            ->orderBy(
                'name'
            )
            ->get();


        $subcategories =
            Category::whereNotNull(
                'parent_id'
            )
            ->with(
                'parent'
            )
            ->orderBy(
                'name'
            )
            ->get();


        // The damaged-books Blade view uses $damagedCopies.
        // Keep $copies too for backward compatibility with any other code.
        $damagedCopies = $copies;

        return view(
            'reports.damaged-books',
            compact(
                'copies',
                'damagedCopies',
                'categories',
                'subcategories'
            )
        );

    }



    /**
     * --------------------------------------------------------------
     * DAMAGED BOOKS PRINT PREVIEW
     * --------------------------------------------------------------
     */
    public function damagedPreview(
        Request $request
    ) {

        $query =
            BookCopy::with([
                'book.category',
                'book.subcategory.parent',
            ])
            ->where(
                'status',
                'damaged'
            );


        if (
            $request->filled(
                'category_id'
            )
        ) {

            $categoryId =
                $request->category_id;


            $query->whereHas(
                'book',
                function (
                    $bookQuery
                ) use (
                    $categoryId
                ) {

                    $bookQuery->where(
                        function (
                            $categoryQuery
                        ) use (
                            $categoryId
                        ) {

                            $categoryQuery
                                ->where(
                                    'category_id',
                                    $categoryId
                                )
                                ->orWhereHas(
                                    'subcategory',
                                    function (
                                        $subcategoryQuery
                                    ) use (
                                        $categoryId
                                    ) {

                                        $subcategoryQuery->where(
                                            'parent_id',
                                            $categoryId
                                        );

                                    }
                                );

                        }
                    );

                }
            );

        }


        if (
            $request->filled(
                'subcategory_id'
            )
        ) {

            $query->whereHas(
                'book',
                function (
                    $bookQuery
                ) use (
                    $request
                ) {

                    $bookQuery->where(
                        'subcategory_id',
                        $request->subcategory_id
                    );

                }
            );

        }


        if (
            $request->filled(
                'search'
            )
        ) {

            $search =
                trim(
                    (string) $request->search
                );


            $query->where(
                function (
                    $copyQuery
                ) use (
                    $search
                ) {

                    $copyQuery
                        ->where(
                            'accession_number',
                            'like',
                            '%' . $search . '%'
                        )
                        ->orWhere(
                            'copy_number',
                            'like',
                            '%' . $search . '%'
                        )
                        ->orWhereHas(
                            'book',
                            function (
                                $bookQuery
                            ) use (
                                $search
                            ) {

                                $bookQuery
                                    ->where(
                                        'title',
                                        'like',
                                        '%' . $search . '%'
                                    )
                                    ->orWhere(
                                        'author',
                                        'like',
                                        '%' . $search . '%'
                                    )
                                    ->orWhere(
                                        'book_code',
                                        'like',
                                        '%' . $search . '%'
                                    )
                                    ->orWhere(
                                        'isbn',
                                        'like',
                                        '%' . $search . '%'
                                    );

                            }
                        );

                }
            );

        }


        $copies =
            $query
                ->orderBy(
                    'accession_number'
                )
                ->orderBy(
                    'copy_number'
                )
                ->get();


        $reportDate =
            Carbon::now();


        $category =
            $request->filled(
                'category_id'
            )
                ? Category::find(
                    $request->category_id
                )
                : null;


        $subcategory =
            $request->filled(
                'subcategory_id'
            )
                ? Category::with(
                    'parent'
                )->find(
                    $request->subcategory_id
                )
                : null;


        return view(
            'reports.damaged-preview',
            compact(
                'copies',
                'reportDate',
                'category',
                'subcategory'
            )
        );

    }



    /**
     * --------------------------------------------------------------
     * BOOK INVENTORY REPORT
     * --------------------------------------------------------------
     */
    public function inventory(
        Request $request
    ) {

        $categories =
            Category::whereNull(
                'parent_id'
            )
            ->with(
                'children'
            )
            ->orderBy(
                'name'
            )
            ->get();


        $subcategories =
            Category::whereNotNull(
                'parent_id'
            )
            ->with(
                'parent'
            )
            ->orderBy(
                'name'
            )
            ->get();


        $books =
            $this
                ->buildInventoryQuery(
                    $request
                )
                ->get();


        return view(
            'reports.inventory',
            compact(
                'books',
                'categories',
                'subcategories'
            )
        );

    }



    /**
     * --------------------------------------------------------------
     * INVENTORY REPORT PRINT PREVIEW
     * --------------------------------------------------------------
     */
    public function inventoryPreview(
        Request $request
    ) {

        $books =
            $this
                ->buildInventoryQuery(
                    $request
                )
                ->get();


        $search =
            trim(
                (string) $request->input(
                    'search',
                    ''
                )
            );


        $categoryId =
            $request->input(
                'category_id'
            );


        $subcategoryId =
            $request->input(
                'subcategory_id'
            );


        $category =
            null;


        if (
            $categoryId
        ) {

            $category =
                Category::find(
                    $categoryId
                );

        }


        $subcategory =
            null;


        if (
            $subcategoryId
        ) {

            $subcategory =
                Category::with(
                    'parent'
                )
                ->find(
                    $subcategoryId
                );

        }


        $reportDate =
            Carbon::now();


        return view(
            'reports.inventory-preview',
            compact(
                'books',
                'reportDate',
                'search',
                'category',
                'subcategory'
            )
        );

    }



    /**
     * --------------------------------------------------------------
     * MOST BORROWED BOOKS
     * --------------------------------------------------------------
     */
    public function popularBooks(
        Request $request
    ) {

        $query =
            Borrowing::select(
                'book_id',
                DB::raw(
                    'COUNT(*) as borrowing_count'
                )
            )
            ->with([
                'book',
            ])
            ->groupBy(
                'book_id'
            );


        if (
            $request->filled(
                'from_date'
            )
        ) {

            $query->whereDate(
                'borrowed_date',
                '>=',
                $request->from_date
            );

        }


        if (
            $request->filled(
                'to_date'
            )
        ) {

            $query->whereDate(
                'borrowed_date',
                '<=',
                $request->to_date
            );

        }


        $books =
            $query
                ->orderByDesc(
                    'borrowing_count'
                )
                ->get();


        return view(
            'reports.popular-books',
            compact(
                'books'
            )
        );

    }



    /**
     * --------------------------------------------------------------
     * BORROWER ACTIVITY REPORT
     * --------------------------------------------------------------
     */
    public function borrowerActivity(
        Request $request
    ) {

        $this->updateOverdueBorrowings();


        $borrowings =
            collect();


        $borrower =
            null;


        if (
            $request->filled(
                'borrower_type'
            )
            &&
            $request->filled(
                'borrower_id'
            )
        ) {

            $modelClass =
                $this->getBorrowerModelClass(
                    $request->borrower_type
                );


            if (
                $modelClass
            ) {

                $borrower =
                    $modelClass::find(
                        $request->borrower_id
                    );


                if (
                    $borrower
                ) {

                    $borrowings =
                        Borrowing::with([
                            'book',
                            'bookCopy',
                        ])
                        ->where(
                            'borrower_type',
                            $modelClass
                        )
                        ->where(
                            'borrower_id',
                            $borrower->id
                        )
                        ->orderByDesc(
                            'borrowed_date'
                        )
                        ->orderByDesc(
                            'id'
                        )
                        ->get();

                }

            }

        }



        /*
        |--------------------------------------------------------------
        | LEARNERS FIRST
        |--------------------------------------------------------------
        */

        $learners =
            Learner::orderBy(
                'grade_class'
            )
            ->orderBy(
                'stream'
            )
            ->orderBy(
                'name'
            )
            ->get();



        /*
        |--------------------------------------------------------------
        | STAFF SECOND
        |--------------------------------------------------------------
        */

        $staff =
            Staff::orderBy(
                'name'
            )
            ->get();



        /*
        |--------------------------------------------------------------
        | TEACHERS THIRD
        |--------------------------------------------------------------
        */

        $teachers =
            Teacher::orderBy(
                'name'
            )
            ->get();


        return view(
            'reports.borrower-activity',
            compact(
                'borrower',
                'borrowings',
                'learners',
                'teachers',
                'staff'
            )
        );

    }



    /**
     * --------------------------------------------------------------
     * BORROWER ACTIVITY PRINT PREVIEW
     * --------------------------------------------------------------
     */
    public function borrowerActivityPreview(
        Request $request
    ) {

        $this->updateOverdueBorrowings();


        $borrowings =
            collect();


        $borrower =
            null;


        $borrowerType =
            null;


        if (
            $request->filled(
                'borrower_type'
            )
            &&
            $request->filled(
                'borrower_id'
            )
        ) {

            $borrowerType =
                $request->borrower_type;


            $modelClass =
                $this->getBorrowerModelClass(
                    $borrowerType
                );


            if (
                $modelClass
            ) {

                $borrower =
                    $modelClass::find(
                        $request->borrower_id
                    );


                if (
                    $borrower
                ) {

                    $borrowings =
                        Borrowing::with([
                            'book',
                            'bookCopy',
                        ])
                        ->where(
                            'borrower_type',
                            $modelClass
                        )
                        ->where(
                            'borrower_id',
                            $borrower->id
                        )
                        ->orderByDesc(
                            'borrowed_date'
                        )
                        ->orderByDesc(
                            'id'
                        )
                        ->get();

                }

            }

        }


        $reportDate =
            Carbon::now();


        return view(
            'reports.borrower-activity-preview',
            compact(
                'borrower',
                'borrowings',
                'borrowerType',
                'reportDate'
            )
        );

    }




    
    /**
     * --------------------------------------------------------------
     * CLASS BORROWING REPORT
     * --------------------------------------------------------------
     */
    public function classBorrowing(
        Request $request
    ) {

        $this->updateOverdueBorrowings();


        $classes =
            Learner::query()
                ->select(
                    'grade_class',
                    'stream'
                )
                ->whereNotNull(
                    'grade_class'
                )
                ->where(
                    'grade_class',
                    '!=',
                    ''
                )
                ->whereNotNull(
                    'stream'
                )
                ->where(
                    'stream',
                    '!=',
                    ''
                )
                ->distinct()
                ->orderBy(
                    'grade_class'
                )
                ->orderBy(
                    'stream'
                )
                ->get();


        $borrowings =
            collect();


        $selectedClass =
            null;


        $gradeClass =
            null;


        $stream =
            null;


        $classValue =
            $request->input(
                'class'
            );


        if (
            is_string(
                $classValue
            )
            &&
            $classValue !== ''
        ) {

            $decodedClass =
                json_decode(
                    $classValue,
                    true
                );


            if (
                is_array(
                    $decodedClass
                )
            ) {

                $gradeClass =
                    trim(
                        (string) (
                            $decodedClass['grade_class']
                            ?? ''
                        )
                    );


                $stream =
                    trim(
                        (string) (
                            $decodedClass['stream']
                            ?? ''
                        )
                    );

            }

        }


        if (
            !$gradeClass
            &&
            $request->filled(
                'grade_class'
            )
        ) {

            $gradeClass =
                trim(
                    (string) $request->input(
                        'grade_class'
                    )
                );

        }


        if (
            !$stream
            &&
            $request->filled(
                'stream'
            )
        ) {

            $stream =
                trim(
                    (string) $request->input(
                        'stream'
                    )
                );

        }


        if (
            $gradeClass !== ''
            &&
            $stream !== ''
        ) {

            $selectedClass =
                trim(
                    $gradeClass
                    . ' '
                    . $stream
                );


            $query =
                Borrowing::with([
                    'book',
                    'bookCopy',
                    'borrower',
                ])
                ->where(
                    'borrower_type',
                    Learner::class
                );


            $query->whereHasMorph(
                'borrower',
                [
                    Learner::class,
                ],
                function (
                    $learnerQuery
                ) use (
                    $gradeClass,
                    $stream
                ) {

                    $learnerQuery
                        ->where(
                            'grade_class',
                            $gradeClass
                        )
                        ->where(
                            'stream',
                            $stream
                        );

                }
            );


            if (
                $request->filled(
                    'status'
                )
            ) {

                $query->where(
                    'status',
                    $request->input(
                        'status'
                    )
                );

            }


            if (
                $request->filled(
                    'from_date'
                )
            ) {

                $query->whereDate(
                    'borrowed_date',
                    '>=',
                    $request->input(
                        'from_date'
                    )
                );

            }


            if (
                $request->filled(
                    'to_date'
                )
            ) {

                $query->whereDate(
                    'borrowed_date',
                    '<=',
                    $request->input(
                        'to_date'
                    )
                );

            }


            if (
                $request->filled(
                    'search'
                )
            ) {

                $search =
                    trim(
                        (string) $request->input(
                            'search'
                        )
                    );


                $query->where(
                    function (
                        $searchQuery
                    ) use (
                        $search
                    ) {

                        $searchQuery->whereHasMorph(
                            'borrower',
                            [
                                Learner::class,
                            ],
                            function (
                                $learnerQuery
                            ) use (
                                $search
                            ) {

                                $learnerQuery
                                    ->where(
                                        'name',
                                        'like',
                                        '%' . $search . '%'
                                    )
                                    ->orWhere(
                                        'admission_number',
                                        'like',
                                        '%' . $search . '%'
                                    );

                            }
                        );


                        $searchQuery->orWhereHas(
                            'book',
                            function (
                                $bookQuery
                            ) use (
                                $search
                            ) {

                                $bookQuery
                                    ->where(
                                        'title',
                                        'like',
                                        '%' . $search . '%'
                                    )
                                    ->orWhere(
                                        'author',
                                        'like',
                                        '%' . $search . '%'
                                    )
                                    ->orWhere(
                                        'book_code',
                                        'like',
                                        '%' . $search . '%'
                                    )
                                    ->orWhere(
                                        'isbn',
                                        'like',
                                        '%' . $search . '%'
                                    );

                            }
                        );

                    }
                );

            }


            $borrowings =
                $query
                    ->orderByDesc(
                        'borrowed_date'
                    )
                    ->orderByDesc(
                        'id'
                    )
                    ->get();

        }


        $totalRecords =
            $borrowings
                ->count();


        $totalLearners =
            $borrowings
                ->map(
                    function (
                        $borrowing
                    ) {

                        return
                            $borrowing->borrower_id;

                    }
                )
                ->unique()
                ->count();


        $currentlyBorrowed =
            $borrowings
                ->whereIn(
                    'status',
                    [
                        'borrowed',
                        'overdue',
                    ]
                )
                ->count();


        $returnedCount =
            $borrowings
                ->where(
                    'status',
                    'returned'
                )
                ->count();


        return view(
            'reports.class-borrowing',
            compact(
                'classes',
                'selectedClass',
                'gradeClass',
                'stream',
                'borrowings',
                'totalRecords',
                'totalLearners',
                'currentlyBorrowed',
                'returnedCount'
            )
        );

    }



    /**
     * --------------------------------------------------------------
     * CLASS BORROWING REPORT PRINT PREVIEW
     * --------------------------------------------------------------
     */
    public function classBorrowingPreview(
        Request $request
    ) {

        $this->updateOverdueBorrowings();


        $borrowings =
            collect();


        $selectedClass =
            null;


        $gradeClass =
            null;


        $stream =
            null;


        $classValue =
            $request->input(
                'class'
            );


        if (
            is_string(
                $classValue
            )
            &&
            $classValue !== ''
        ) {

            $decodedClass =
                json_decode(
                    $classValue,
                    true
                );


            if (
                is_array(
                    $decodedClass
                )
            ) {

                $gradeClass =
                    trim(
                        (string) (
                            $decodedClass['grade_class']
                            ?? ''
                        )
                    );


                $stream =
                    trim(
                        (string) (
                            $decodedClass['stream']
                            ?? ''
                        )
                    );

            }

        }


        if (
            !$gradeClass
            &&
            $request->filled(
                'grade_class'
            )
        ) {

            $gradeClass =
                trim(
                    (string) $request->input(
                        'grade_class'
                    )
                );

        }


        if (
            !$stream
            &&
            $request->filled(
                'stream'
            )
        ) {

            $stream =
                trim(
                    (string) $request->input(
                        'stream'
                    )
                );

        }


        if (
            $gradeClass !== ''
            &&
            $stream !== ''
        ) {

            $selectedClass =
                trim(
                    $gradeClass
                    . ' '
                    . $stream
                );


            $query =
                Borrowing::with([
                    'book',
                    'bookCopy',
                    'borrower',
                ])
                ->where(
                    'borrower_type',
                    Learner::class
                );


            $query->whereHasMorph(
                'borrower',
                [
                    Learner::class,
                ],
                function (
                    $learnerQuery
                ) use (
                    $gradeClass,
                    $stream
                ) {

                    $learnerQuery
                        ->where(
                            'grade_class',
                            $gradeClass
                        )
                        ->where(
                            'stream',
                            $stream
                        );

                }
            );


            if (
                $request->filled(
                    'status'
                )
            ) {

                $query->where(
                    'status',
                    $request->input(
                        'status'
                    )
                );

            }


            if (
                $request->filled(
                    'from_date'
                )
            ) {

                $query->whereDate(
                    'borrowed_date',
                    '>=',
                    $request->input(
                        'from_date'
                    )
                );

            }


            if (
                $request->filled(
                    'to_date'
                )
            ) {

                $query->whereDate(
                    'borrowed_date',
                    '<=',
                    $request->input(
                        'to_date'
                    )
                );

            }


            if (
                $request->filled(
                    'search'
                )
            ) {

                $search =
                    trim(
                        (string) $request->input(
                            'search'
                        )
                    );


                $query->where(
                    function (
                        $searchQuery
                    ) use (
                        $search
                    ) {

                        $searchQuery->whereHasMorph(
                            'borrower',
                            [
                                Learner::class,
                            ],
                            function (
                                $learnerQuery
                            ) use (
                                $search
                            ) {

                                $learnerQuery
                                    ->where(
                                        'name',
                                        'like',
                                        '%' . $search . '%'
                                    )
                                    ->orWhere(
                                        'admission_number',
                                        'like',
                                        '%' . $search . '%'
                                    );

                            }
                        );


                        $searchQuery->orWhereHas(
                            'book',
                            function (
                                $bookQuery
                            ) use (
                                $search
                            ) {

                                $bookQuery
                                    ->where(
                                        'title',
                                        'like',
                                        '%' . $search . '%'
                                    )
                                    ->orWhere(
                                        'author',
                                        'like',
                                        '%' . $search . '%'
                                    )
                                    ->orWhere(
                                        'book_code',
                                        'like',
                                        '%' . $search . '%'
                                    )
                                    ->orWhere(
                                        'isbn',
                                        'like',
                                        '%' . $search . '%'
                                    );

                            }
                        );

                    }
                );

            }


            $borrowings =
                $query
                    ->orderByDesc(
                        'borrowed_date'
                    )
                    ->orderByDesc(
                        'id'
                    )
                    ->get();

        }


        $reportDate =
            Carbon::now();


        return view(
            'reports.class-borrowing-preview',
            compact(
                'borrowings',
                'reportDate',
                'selectedClass',
                'gradeClass',
                'stream'
            )
        );

    }


}
