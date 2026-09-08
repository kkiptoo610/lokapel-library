<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Borrowing;
use App\Models\Learner;
use App\Models\Staff;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BorrowingController extends Controller
{
    /**
     * Automatically update overdue borrowings.
     */
    private function updateOverdueBorrowings(): void
    {
        Borrowing::where('status', 'borrowed')
            ->whereNotNull('due_date')
            ->whereDate('due_date', '<', Carbon::today())
            ->update([
                'status' => 'overdue',
            ]);
    }


    /**
     * Create a system notification for the currently logged-in user.
     */
    private function createSystemNotification(
        string $title,
        string $message,
        string $type = 'info',
        ?string $url = null
    ): void {
        $user = auth()->user();

        if (!$user) {
            return;
        }

        $user->notifications()->create([

            'id' => (string) Str::uuid(),

            'type' => 'App\\Notifications\\LibrarySystemNotification',

            'data' => [

                'title' => $title,

                'message' => $message,

                /*
                |--------------------------------------------------------------------------
                | Notification Type
                |--------------------------------------------------------------------------
                |
                | Keep both keys so existing notification views/components that
                | use either "type" or "notification_type" continue to work.
                |
                */

                'type' => $type,

                'notification_type' => $type,

                'url' => $url,

            ],

        ]);
    }


    /**
     * Display all borrowing records.
     */
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | UPDATE OVERDUE RECORDS
        |--------------------------------------------------------------------------
        */

        $this->updateOverdueBorrowings();


        /*
        |--------------------------------------------------------------------------
        | MAIN QUERY
        |--------------------------------------------------------------------------
        */

        $query = Borrowing::with([
            'book',
            'bookCopy',
            'borrower',
        ]);


        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($query) use ($search) {

                /*
                |------------------------------------------------------------------
                | SEARCH BOOK
                |------------------------------------------------------------------
                */

                $query->whereHas(
                    'book',
                    function ($bookQuery) use ($search) {

                        $bookQuery
                            ->where(
                                'title',
                                'like',
                                '%' . $search . '%'
                            )
                            ->orWhere(
                                'book_code',
                                'like',
                                '%' . $search . '%'
                            )
                            ->orWhere(
                                'author',
                                'like',
                                '%' . $search . '%'
                            );

                    }
                );


                /*
                |------------------------------------------------------------------
                | SEARCH LEARNERS
                |------------------------------------------------------------------
                */

                $query->orWhereHasMorph(
                    'borrower',
                    [
                        Learner::class,
                    ],
                    function ($learnerQuery) use ($search) {

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


                /*
                |------------------------------------------------------------------
                | SEARCH TEACHERS
                |------------------------------------------------------------------
                */

                $query->orWhereHasMorph(
                    'borrower',
                    [
                        Teacher::class,
                    ],
                    function ($teacherQuery) use ($search) {

                        $teacherQuery
                            ->where(
                                'name',
                                'like',
                                '%' . $search . '%'
                            )
                            ->orWhere(
                                'phone_number',
                                'like',
                                '%' . $search . '%'
                            );

                    }
                );


                /*
                |------------------------------------------------------------------
                | SEARCH STAFF
                |------------------------------------------------------------------
                */

                $query->orWhereHasMorph(
                    'borrower',
                    [
                        Staff::class,
                    ],
                    function ($staffQuery) use ($search) {

                        $staffQuery
                            ->where(
                                'name',
                                'like',
                                '%' . $search . '%'
                            )
                            ->orWhere(
                                'phone_number',
                                'like',
                                '%' . $search . '%'
                            );

                    }
                );

            });

        }


        /*
        |--------------------------------------------------------------------------
        | BORROWER TYPE FILTER
        |--------------------------------------------------------------------------
        */

        if ($request->filled('borrower_type')) {

            $borrowerType = match ($request->borrower_type) {

                'learner' => Learner::class,

                'teacher' => Teacher::class,

                'staff' => Staff::class,

                default => null,

            };


            if ($borrowerType) {

                $query->where(
                    'borrower_type',
                    $borrowerType
                );

            }

        }


        /*
        |--------------------------------------------------------------------------
        | STATUS FILTER
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );

        }


        /*
        |--------------------------------------------------------------------------
        | CLASS FILTER
        |--------------------------------------------------------------------------
        */

        if ($request->filled('grade_class')) {

            $query
                ->where(
                    'borrower_type',
                    Learner::class
                )
                ->whereHasMorph(
                    'borrower',
                    [
                        Learner::class,
                    ],
                    function ($learnerQuery) use ($request) {

                        $learnerQuery->where(
                            'grade_class',
                            $request->grade_class
                        );

                    }
                );

        }


        /*
        |--------------------------------------------------------------------------
        | STREAM FILTER
        |--------------------------------------------------------------------------
        */

        if ($request->filled('stream')) {

            $query
                ->where(
                    'borrower_type',
                    Learner::class
                )
                ->whereHasMorph(
                    'borrower',
                    [
                        Learner::class,
                    ],
                    function ($learnerQuery) use ($request) {

                        $learnerQuery->where(
                            'stream',
                            $request->stream
                        );

                    }
                );

        }


        /*
        |--------------------------------------------------------------------------
        | GET BORROWINGS
        |--------------------------------------------------------------------------
        */

        $borrowings = $query
            ->orderByDesc('borrowed_date')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | LEARNER BORROWINGS
        |--------------------------------------------------------------------------
        */

        $learnerBorrowings = $borrowings
            ->filter(function ($borrowing) {

                return $borrowing->borrower_type === Learner::class;

            })
            ->sortBy(function ($borrowing) {

                return
                    ($borrowing->borrower?->grade_class ?? '')
                    . '|'
                    . ($borrowing->borrower?->stream ?? '')
                    . '|'
                    . ($borrowing->borrower?->name ?? '');

            })
            ->values();


        /*
        |--------------------------------------------------------------------------
        | TEACHER BORROWINGS
        |--------------------------------------------------------------------------
        */

        $teacherBorrowings = $borrowings
            ->filter(function ($borrowing) {

                return $borrowing->borrower_type === Teacher::class;

            })
            ->sortBy(function ($borrowing) {

                return $borrowing->borrower?->name ?? '';

            })
            ->values();


        /*
        |--------------------------------------------------------------------------
        | STAFF BORROWINGS
        |--------------------------------------------------------------------------
        */

        $staffBorrowings = $borrowings
            ->filter(function ($borrowing) {

                return $borrowing->borrower_type === Staff::class;

            })
            ->sortBy(function ($borrowing) {

                return $borrowing->borrower?->name ?? '';

            })
            ->values();


        /*
        |--------------------------------------------------------------------------
        | OVERDUE COUNT
        |--------------------------------------------------------------------------
        */

        $overdueCount = Borrowing::where(
            'status',
            'overdue'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'borrowings.index',
            compact(
                'learnerBorrowings',
                'teacherBorrowings',
                'staffBorrowings',
                'overdueCount'
            )
        );
    }


    /**
     * Show the issue book form.
     */
    public function create()
    {
        $this->updateOverdueBorrowings();


        /*
        |--------------------------------------------------------------------------
        | BOOKS WITH AVAILABLE PHYSICAL COPIES
        |--------------------------------------------------------------------------
        */

        $books = Book::with([
            'copies' => function ($query) {

                $query
                    ->where(
                        'status',
                        'available'
                    )
                    ->orderBy('id');

            },
        ])
        ->whereHas(
            'copies',
            function ($query) {

                $query->where(
                    'status',
                    'available'
                );

            }
        )
        ->orderBy('title')
        ->get();


        /*
        |--------------------------------------------------------------------------
        | LEARNERS
        |--------------------------------------------------------------------------
        */

        $learners = Learner::orderBy('grade_class')
            ->orderBy('stream')
            ->orderBy('name')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | TEACHERS
        |--------------------------------------------------------------------------
        */

        $teachers = Teacher::orderBy('name')->get();


        /*
        |--------------------------------------------------------------------------
        | STAFF
        |--------------------------------------------------------------------------
        */

        $staff = Staff::orderBy('name')->get();


        return view(
            'borrowings.create',
            compact(
                'books',
                'learners',
                'teachers',
                'staff'
            )
        );
    }


    /**
     * Store a new borrowing.
     */
    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'book_id' => [
                'required',
                'exists:books,id',
            ],

            'book_copy_id' => [
                'required',
                'exists:book_copies,id',
            ],

            'borrower_type' => [
                'required',
                'in:learner,teacher,staff',
            ],

            'borrower_id' => [
                'required',
                'integer',
            ],

            'borrowed_date' => [
                'required',
                'date',
            ],

            'due_date' => [
                'nullable',
                'date',
                'after_or_equal:borrowed_date',
            ],

        ]);


        $this->updateOverdueBorrowings();


        /*
        |--------------------------------------------------------------------------
        | FIND BORROWER
        |--------------------------------------------------------------------------
        */

        $borrower = match ($validated['borrower_type']) {

            'learner' => Learner::findOrFail(
                $validated['borrower_id']
            ),

            'teacher' => Teacher::findOrFail(
                $validated['borrower_id']
            ),

            'staff' => Staff::findOrFail(
                $validated['borrower_id']
            ),

        };


        $issuedBorrowing = null;


        try {

            DB::transaction(function () use (
                $validated,
                $borrower,
                &$issuedBorrowing
            ) {

                /*
                |------------------------------------------------------------------
                | LOCK BOOK
                |------------------------------------------------------------------
                */

                $book = Book::lockForUpdate()
                    ->findOrFail(
                        $validated['book_id']
                    );


                /*
                |------------------------------------------------------------------
                | LOCK BOOK COPY
                |------------------------------------------------------------------
                */

                $bookCopy = BookCopy::lockForUpdate()
                    ->findOrFail(
                        $validated['book_copy_id']
                    );


                /*
                |------------------------------------------------------------------
                | VERIFY COPY BELONGS TO BOOK
                |------------------------------------------------------------------
                */

                if ($bookCopy->book_id !== $book->id) {

                    throw new \Exception(
                        'The selected physical copy does not belong to the selected book.'
                    );

                }


                /*
                |------------------------------------------------------------------
                | CHECK AVAILABILITY
                |------------------------------------------------------------------
                */

                if ($bookCopy->status !== 'available') {

                    throw new \Exception(
                        'The selected book copy is no longer available.'
                    );

                }


                /*
                |------------------------------------------------------------------
                | CREATE BORROWING
                |------------------------------------------------------------------
                */

                $issuedBorrowing = Borrowing::create([

                    'book_id' => $book->id,

                    'book_copy_id' => $bookCopy->id,

                    'borrower_id' => $borrower->id,

                    'borrower_type' => get_class(
                        $borrower
                    ),

                    'borrowed_date' =>
                        $validated['borrowed_date'],

                    'due_date' =>
                        $validated['due_date'] ?? null,

                    'status' => 'borrowed',

                ]);


                /*
                |------------------------------------------------------------------
                | UPDATE BOOK COPY
                |------------------------------------------------------------------
                */

                $bookCopy->update([

                    'status' => 'borrowed',

                ]);


                /*
                |------------------------------------------------------------------
                | UPDATE BOOK STOCK
                |------------------------------------------------------------------
                */

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

            });

        } catch (\Exception $exception) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    $exception->getMessage()
                );

        }


        /*
        |--------------------------------------------------------------------------
        | CREATE ISSUE NOTIFICATION
        |--------------------------------------------------------------------------
        */

        if ($issuedBorrowing) {

            /*
            |----------------------------------------------------------------------
            | LOAD RELATIONSHIPS
            |----------------------------------------------------------------------
            */

            $issuedBorrowing->load([
                'book',
                'bookCopy',
                'borrower',
            ]);


            /*
            |----------------------------------------------------------------------
            | EXACT PHYSICAL COPY NUMBER
            |----------------------------------------------------------------------
            */

            $copyNumber =
                $issuedBorrowing->bookCopy?->copy_number
                ?? 'Unknown Copy';


            /*
            |----------------------------------------------------------------------
            | ACCESSION NUMBER
            |----------------------------------------------------------------------
            */

            $accessionNumber =
                $issuedBorrowing->bookCopy?->accession_number;


            /*
            |----------------------------------------------------------------------
            | BORROWER NAME
            |----------------------------------------------------------------------
            */

            $borrowerName =
                $issuedBorrowing->borrower?->name
                ?? $borrower->name
                ?? 'the selected borrower';


            /*
            |----------------------------------------------------------------------
            | BOOK TITLE
            |----------------------------------------------------------------------
            */

            $bookTitle =
                $issuedBorrowing->book?->title
                ?? 'Selected Book';


            /*
            |----------------------------------------------------------------------
            | BUILD COPY DESCRIPTION
            |----------------------------------------------------------------------
            */

            $copyDescription =
                'Physical copy: '
                . $copyNumber;


            if ($accessionNumber) {

                $copyDescription .=
                    ' | Accession: '
                    . $accessionNumber;

            }


            /*
            |----------------------------------------------------------------------
            | CREATE NOTIFICATION
            |----------------------------------------------------------------------
            */

            $this->createSystemNotification(

                title: 'Book Issued Successfully',

                message:
                    'The book "'
                    . $bookTitle
                    . '" '
                    . '('
                    . $copyDescription
                    . ') '
                    . 'has been issued to '
                    . $borrowerName
                    . '.',

                type: 'success',

                url: route(
                    'borrowings.show',
                    $issuedBorrowing
                )

            );

        }


        return redirect()
            ->route('borrowings.index')
            ->with(
                'success',
                'Book issued successfully.'
            );
    }


    /**
     * Display one borrowing record.
     */
    public function show(Borrowing $borrowing)
    {
        $borrowing->load([

            'book',

            'bookCopy',

            'borrower',

        ]);


        return view(
            'borrowings.show',
            compact('borrowing')
        );
    }


    /**
     * Return a borrowed or overdue physical copy.
     */
    public function returnBook(
        Request $request,
        Borrowing $borrowing
    )
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDATION
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'return_condition' => [
                'required',
                'in:good,damaged',
            ],

            'damage_description' => [
                'nullable',
                'string',
                'required_if:return_condition,damaged',
            ],

        ], [

            'return_condition.required' =>
                'Please select the condition of the returned book.',

            'return_condition.in' =>
                'Please select a valid return condition.',

            'damage_description.required_if' =>
                'Please describe the damage to the book.',

        ]);


        $returnedBorrowing = null;


        try {

            DB::transaction(function () use (
                $borrowing,
                $validated,
                &$returnedBorrowing
            ) {

                /*
                |------------------------------------------------------------------
                | LOCK BORROWING
                |------------------------------------------------------------------
                */

                $lockedBorrowing = Borrowing::lockForUpdate()
                    ->with([

                        'book',

                        'bookCopy',

                        'borrower',

                    ])
                    ->findOrFail(
                        $borrowing->id
                    );


                /*
                |------------------------------------------------------------------
                | CHECK IF ALREADY RETURNED
                |------------------------------------------------------------------
                */

                if ($lockedBorrowing->status === 'returned') {

                    throw new \Exception(
                        'This book has already been returned.'
                    );

                }


                /*
                |------------------------------------------------------------------
                | LOCK BOOK COPY
                |------------------------------------------------------------------
                */

                $bookCopy = BookCopy::lockForUpdate()
                    ->findOrFail(
                        $lockedBorrowing->book_copy_id
                    );


                /*
                |------------------------------------------------------------------
                | DETERMINE BOOK COPY STATUS
                |------------------------------------------------------------------
                */

                $newCopyStatus =
                    $validated['return_condition'] === 'damaged'
                        ? 'damaged'
                        : 'available';


                /*
                |------------------------------------------------------------------
                | MARK BORROWING AS RETURNED
                |------------------------------------------------------------------
                */

                $lockedBorrowing->update([

                    'status' => 'returned',

                    'returned_date' =>
                        Carbon::today(),

                    'return_condition' =>
                        $validated['return_condition'],

                    'damage_description' =>
                        $validated['return_condition'] === 'damaged'
                            ? trim(
                                $validated['damage_description']
                            )
                            : null,

                ]);


                /*
                |------------------------------------------------------------------
                | UPDATE PHYSICAL BOOK COPY
                |------------------------------------------------------------------
                */

                $bookCopy->update([

                    'status' =>
                        $newCopyStatus,

                ]);


                /*
                |------------------------------------------------------------------
                | LOCK BOOK
                |------------------------------------------------------------------
                */

                $book = Book::lockForUpdate()
                    ->findOrFail(
                        $lockedBorrowing->book_id
                    );


                /*
                |------------------------------------------------------------------
                | RECALCULATE STOCK
                |------------------------------------------------------------------
                */

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


                /*
                |------------------------------------------------------------------
                | SAVE RETURNED BORROWING
                |------------------------------------------------------------------
                */

                $returnedBorrowing = $lockedBorrowing;

            });

        } catch (\Exception $exception) {

            return back()
                ->with(
                    'error',
                    $exception->getMessage()
                );

        }


        /*
        |--------------------------------------------------------------------------
        | CREATE RETURN NOTIFICATION
        |--------------------------------------------------------------------------
        */

        if ($returnedBorrowing) {

            /*
            |----------------------------------------------------------------------
            | LOAD ALL REQUIRED RELATIONSHIPS
            |----------------------------------------------------------------------
            */

            $returnedBorrowing->load([
                'book',
                'bookCopy',
                'borrower',
            ]);


            /*
            |----------------------------------------------------------------------
            | BOOK TITLE
            |----------------------------------------------------------------------
            */

            $bookTitle =
                $returnedBorrowing->book?->title
                ?? 'Selected Book';


            /*
            |----------------------------------------------------------------------
            | EXACT PHYSICAL COPY NUMBER
            |----------------------------------------------------------------------
            */

            $copyNumber =
                $returnedBorrowing->bookCopy?->copy_number
                ?? 'Unknown Copy';


            /*
            |----------------------------------------------------------------------
            | ACCESSION NUMBER
            |----------------------------------------------------------------------
            */

            $accessionNumber =
                $returnedBorrowing->bookCopy?->accession_number;


            /*
            |----------------------------------------------------------------------
            | BORROWER NAME
            |----------------------------------------------------------------------
            */

            $borrowerName =
                $returnedBorrowing->borrower?->name
                ?? 'Unknown borrower';


            /*
            |----------------------------------------------------------------------
            | COPY DESCRIPTION
            |----------------------------------------------------------------------
            */

            $copyDescription =
                'Physical copy: '
                . $copyNumber;


            if ($accessionNumber) {

                $copyDescription .=
                    ' | Accession: '
                    . $accessionNumber;

            }


            /*
            |----------------------------------------------------------------------
            | RETURN CONDITION
            |----------------------------------------------------------------------
            */

            if (
                $validated['return_condition'] === 'damaged'
            ) {

                $conditionMessage =
                    'The book was returned with damage.';


            } else {

                $conditionMessage =
                    'The book was returned in good condition.';

            }


            /*
            |----------------------------------------------------------------------
            | DAMAGE DESCRIPTION
            |----------------------------------------------------------------------
            */

            $damageDescription =
                '';


            if (
                $validated['return_condition'] === 'damaged'
                &&
                !empty($validated['damage_description'])
            ) {

                $damageDescription =
                    ' Damage description: '
                    . trim(
                        $validated['damage_description']
                    )
                    . '.';

            }


            /*
            |----------------------------------------------------------------------
            | CREATE NOTIFICATION
            |----------------------------------------------------------------------
            */

            $this->createSystemNotification(

                title: 'Book Returned',

                message:
                    'The book "'
                    . $bookTitle
                    . '" '
                    . '('
                    . $copyDescription
                    . ') '
                    . 'has been returned by '
                    . $borrowerName
                    . ' successfully. '
                    . $conditionMessage
                    . $damageDescription,

                type:
                    $validated['return_condition'] === 'damaged'
                        ? 'warning'
                        : 'success',

                url: route(
                    'borrowings.show',
                    $returnedBorrowing
                )

            );

        }


        return redirect()
            ->route('borrowings.index')
            ->with(
                'success',
                'Book returned successfully.'
            );
    }
}