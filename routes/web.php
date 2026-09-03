<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LearnerController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\ReportController;

use App\Models\BookCopy;
use App\Models\Borrowing;
use App\Models\Learner;
use App\Models\Staff;
use App\Models\Teacher;

use Carbon\Carbon;


/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| Show Login Form
|--------------------------------------------------------------------------
*/

Route::get(
    '/login',
    [AuthController::class, 'showLoginForm']
)->name('login');


/*
|--------------------------------------------------------------------------
| Process Login
|--------------------------------------------------------------------------
*/

Route::post(
    '/login',
    [AuthController::class, 'login']
)->name('login.submit');


/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/

Route::post(
    '/logout',
    [AuthController::class, 'logout']
)->name('logout');


/*
|--------------------------------------------------------------------------
| Protected Library System Routes
|--------------------------------------------------------------------------
|
| Everything inside this group requires a librarian to log in.
|
*/

Route::middleware('auth')->group(function () {


    /*
    |--------------------------------------------------------------------------
    | Password Confirmation
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/confirm-password',
        [AuthController::class, 'showConfirmPasswordForm']
    )->name('password.confirm');


    Route::post(
        '/confirm-password',
        [AuthController::class, 'confirmPassword']
    )->name('password.confirm.submit');


    /*
    |--------------------------------------------------------------------------
    | Change Password
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/change-password',
        [AuthController::class, 'showChangePasswordForm']
    )->name('password.change');


    Route::post(
        '/change-password',
        [AuthController::class, 'changePassword']
    )->name('password.change.update');


    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/', function () {


        /*
        |--------------------------------------------------------------------------
        | UPDATE OVERDUE BORROWINGS AUTOMATICALLY
        |--------------------------------------------------------------------------
        */

        Borrowing::where(
            'status',
            'borrowed'
        )
            ->whereNotNull('due_date')
            ->whereDate(
                'due_date',
                '<',
                Carbon::today()
            )
            ->update([
                'status' => 'overdue',
            ]);


        /*
        |--------------------------------------------------------------------------
        | BOOK STATISTICS
        |--------------------------------------------------------------------------
        */

        $totalBooks = BookCopy::count();


        $availableBooks = BookCopy::where(
            'status',
            'available'
        )->count();


        $borrowedBooks = BookCopy::where(
            'status',
            'borrowed'
        )->count();


        $damagedBooks = BookCopy::where(
            'status',
            'damaged'
        )->count();


        $overdueBooks = Borrowing::where(
            'status',
            'overdue'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | PEOPLE STATISTICS
        |--------------------------------------------------------------------------
        */

        $learnersCount = Learner::count();


        $teachersCount = Teacher::count();


        $staffCount = Staff::count();


        /*
        |--------------------------------------------------------------------------
        | TODAY'S ACTIVITY
        |--------------------------------------------------------------------------
        */

        $borrowedToday = Borrowing::whereDate(
            'borrowed_date',
            Carbon::today()
        )->count();


        $returnedToday = Borrowing::whereDate(
            'returned_date',
            Carbon::today()
        )->count();


        /*
        |--------------------------------------------------------------------------
        | THIS WEEK'S ACTIVITY
        |--------------------------------------------------------------------------
        */

        $borrowedThisWeek = Borrowing::whereBetween(
            'borrowed_date',
            [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek(),
            ]
        )->count();


        /*
        |--------------------------------------------------------------------------
        | THIS MONTH'S ACTIVITY
        |--------------------------------------------------------------------------
        */

        $borrowedThisMonth = Borrowing::whereMonth(
            'borrowed_date',
            Carbon::now()->month
        )
            ->whereYear(
                'borrowed_date',
                Carbon::now()->year
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | RECENT BORROWING ACTIVITY
        |--------------------------------------------------------------------------
        */

        $recentBorrowings = Borrowing::with([
            'book',
            'bookCopy',
            'borrower',
        ])
            ->orderByDesc('borrowed_date')
            ->orderByDesc('id')
            ->limit(8)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | OVERDUE BORROWINGS
        |--------------------------------------------------------------------------
        */

        $overdueBorrowings = Borrowing::with([
            'book',
            'bookCopy',
            'borrower',
        ])
            ->where(
                'status',
                'overdue'
            )
            ->orderBy('due_date')
            ->limit(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | MOST BORROWED BOOKS
        |--------------------------------------------------------------------------
        */

        $popularBooks = Borrowing::select(
            'book_id',
            DB::raw(
                'COUNT(*) as borrowing_count'
            )
        )
            ->with('book')
            ->groupBy('book_id')
            ->orderByDesc('borrowing_count')
            ->limit(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | RETURN DASHBOARD
        |--------------------------------------------------------------------------
        */

        return view(
            'dashboard',
            compact(
                'totalBooks',
                'availableBooks',
                'borrowedBooks',
                'damagedBooks',
                'overdueBooks',
                'learnersCount',
                'teachersCount',
                'staffCount',
                'borrowedToday',
                'returnedToday',
                'borrowedThisWeek',
                'borrowedThisMonth',
                'recentBorrowings',
                'overdueBorrowings',
                'popularBooks'
            )
        );

    })->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | Category Management
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'categories',
        CategoryController::class
    );


    /*
    |--------------------------------------------------------------------------
    | Book Management
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'books',
        BookController::class
    );


    /*
    |--------------------------------------------------------------------------
    | Individual Physical Book Copies
    |--------------------------------------------------------------------------
    */


    /*
    |--------------------------------------------------------------------------
    | Add Individual Copy
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/books/{book}/copies',
        [BookController::class, 'storeCopy']
    )->name('books.copies.store');


    /*
    |--------------------------------------------------------------------------
    | Update Individual Copy
    |--------------------------------------------------------------------------
    */

    Route::put(
        '/books/{book}/copies/{copy}',
        [BookController::class, 'updateCopy']
    )->name('books.copies.update');


    /*
    |--------------------------------------------------------------------------
    | Delete Individual Copy
    |--------------------------------------------------------------------------
    */

    Route::delete(
        '/books/{book}/copies/{copy}',
        [BookController::class, 'destroyCopy']
    )->name('books.copies.destroy');


    /*
    |--------------------------------------------------------------------------
    | Book Copies By Status
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/books/status/{status}',
        [BookController::class, 'statusList']
    )->name('books.status');


    /*
    |--------------------------------------------------------------------------
    | Teacher Management
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'teachers',
        TeacherController::class
    );


    /*
    |--------------------------------------------------------------------------
    | Staff Management
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'staff',
        StaffController::class
    );


    /*
    |--------------------------------------------------------------------------
    | Learner Import
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/learners/import',
        [LearnerController::class, 'showImportForm']
    )->name('learners.import.form');


    Route::post(
        '/learners/import',
        [LearnerController::class, 'import']
    )->name('learners.import');


    /*
    |--------------------------------------------------------------------------
    | Download Learner Import Template
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/learners/template/download',
        [LearnerController::class, 'downloadTemplate']
    )->name('learners.template.download');


    /*
    |--------------------------------------------------------------------------
    | Learner Management
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'learners',
        LearnerController::class
    );


    /*
    |--------------------------------------------------------------------------
    | Borrowing Management
    |--------------------------------------------------------------------------
    */


    /*
    |--------------------------------------------------------------------------
    | Display All Borrowings
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/borrowings',
        [BorrowingController::class, 'index']
    )->name('borrowings.index');


    /*
    |--------------------------------------------------------------------------
    | Issue Book Form
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/borrowings/create',
        [BorrowingController::class, 'create']
    )->name('borrowings.create');


    /*
    |--------------------------------------------------------------------------
    | Store New Borrowing
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/borrowings',
        [BorrowingController::class, 'store']
    )->name('borrowings.store');


    /*
    |--------------------------------------------------------------------------
    | View Borrowing Record
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/borrowings/{borrowing}',
        [BorrowingController::class, 'show']
    )->name('borrowings.show');


    /*
    |--------------------------------------------------------------------------
    | Return Book
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/borrowings/{borrowing}/return',
        [BorrowingController::class, 'returnBook']
    )->name('borrowings.return');


    /*
    |--------------------------------------------------------------------------
    | Reports Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/reports',
        [ReportController::class, 'index']
    )->name('reports.index');


    /*
    |--------------------------------------------------------------------------
    | General Borrowings Report
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/reports/borrowings',
        [ReportController::class, 'borrowings']
    )->name('reports.borrowings');


    /*
    |--------------------------------------------------------------------------
    | General Borrowings Report Preview
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/reports/borrowings/preview',
        [ReportController::class, 'borrowingsPreview']
    )->name('reports.borrowings.preview');


    /*
    |--------------------------------------------------------------------------
    | Book Borrowing Details
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/reports/borrowings/book/{book}',
        [ReportController::class, 'borrowingBookDetails']
    )->name('reports.borrowings.book-details');


    /*
    |--------------------------------------------------------------------------
    | Overdue Books Report
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/reports/overdue',
        [ReportController::class, 'overdue']
    )->name('reports.overdue');


    /*
    |--------------------------------------------------------------------------
    | Overdue Books Report Preview
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/reports/overdue/preview',
        [ReportController::class, 'overduePreview']
    )->name('reports.overdue.preview');


    /*
    |--------------------------------------------------------------------------
    | Returned Books Report
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/reports/returned',
        [ReportController::class, 'returned']
    )->name('reports.returned');


    /*
    |--------------------------------------------------------------------------
    | Returned Books Report Preview
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/reports/returned/preview',
        [ReportController::class, 'returnedPreview']
    )->name('reports.returned.preview');


    /*
    |--------------------------------------------------------------------------
    | Damaged Books Report
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/reports/damaged',
        [ReportController::class, 'damaged']
    )->name('reports.damaged');


    /*
    |--------------------------------------------------------------------------
    | Damaged Books Report Preview
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/reports/damaged/preview',
        [ReportController::class, 'damagedPreview']
    )->name('reports.damaged.preview');


    /*
    |--------------------------------------------------------------------------
    | Library Inventory Report
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/reports/inventory',
        [ReportController::class, 'inventory']
    )->name('reports.inventory');


    /*
    |--------------------------------------------------------------------------
    | Library Inventory Report Preview
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/reports/inventory/preview',
        [ReportController::class, 'inventoryPreview']
    )->name('reports.inventory.preview');


    /*
    |--------------------------------------------------------------------------
    | Most Borrowed Books Report
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/reports/popular-books',
        [ReportController::class, 'popularBooks']
    )->name('reports.popular-books');


    /*
    |--------------------------------------------------------------------------
    | Borrower Activity Report
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/reports/borrower-activity',
        [ReportController::class, 'borrowerActivity']
    )->name('reports.borrower-activity');


    /*
    |--------------------------------------------------------------------------
    | Borrower Activity Report Preview
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/reports/borrower-activity/preview',
        [ReportController::class, 'borrowerActivityPreview']
    )->name('reports.borrower-activity.preview');


});