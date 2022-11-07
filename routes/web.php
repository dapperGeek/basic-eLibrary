<?php

use App\Custom\Utilities;
use App\Mail\ReaderReminderMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Login page
Route::get('/login', [UserController::class, 'login'])->middleware('guest')->name('login');

//Registration page
Route::get('/register', [UserController::class, 'register'])->middleware('guest')->name('register');

//Register new user
Route::post('/registerUser', [UserController::class, 'registerUser']);

//Landing libray view page. Authenticated access
Route::get('/', [BookController::class, 'index'])->middleware('auth')->name('home');

Route::get('/home', [BookController::class, 'index'])->middleware('auth')->name('home');

//Logs in user
Route::post('authenticateUser', [UserController::class, 'authenticateUser']);

//Logs out user
Route::get('/logout', [UserController::class, 'logoutUser'])->middleware('auth');

//Displays form to add new book to library
Route::get('/book', [BookController::class, 'newBook'])->middleware('auth');

//Adds new book to library
Route::post('/addBook', [BookController::class, 'addBook'])->name('create_book');

//Displays selected book to view
Route::get('/book/{id}', [BookController::class, 'displayBook'])->middleware('auth');

//Shows form to update book
Route::get('/book/{id}/edit', [BookController::class, 'edit'])->middleware('auth');

//Updates book
Route::put('/updateBook', [BookController::class, 'updateBook'])->middleware('auth');

//Checks out book
Route::post('/check-out', [BookController::class, 'checkOutBook'])->middleware('auth');

//Check In Book
Route::post('/check-in', [BookController::class, 'checkInBook'])->middleware('auth');

//Displays checked out books
Route::get('/books/checked-out', [BookController::class, 'checkedOutBooks'])->middleware('auth');

//User view own profile
Route::get('/my-profile', [UserController::class, 'ownProfile'])->middleware('auth');

//Update profile form
Route::get('/my-profile/update', [UserController::class, 'updateForm'])->middleware('auth');

//Update user profile
Route::put('/update-profile', [UserController::class, 'updateProfile'])->middleware('auth');

//Admin view users page
Route::get('/users/{id}', [UserController::class, 'viewUser'])->middleware('auth');

//Display documentation
Route::get('/docs', function () {
    return view('docs');
});

//Preview email
Route::get('/reader-mail', function () {
    $reminder = DB::table('check_outs')
        ->join('users', 'check_outs.user_id', '=', 'users.id')
        ->join('books', 'check_outs.book_id', '=', 'books.id')
        ->where('check_outs.check_out_status', '!=', 1)
        ->first();

    // dd($reminder);
    return new \App\Mail\ReaderReminderMail($reminder);
});

//Test email sending 
Route::get('/check-mail', function () {
    
    $reminders = DB::table('check_outs')
    ->join('users', 'check_outs.user_id', '=', 'users.id')
    ->join('books', 'check_outs.book_id', '=', 'books.id')
    ->where('check_outs.check_out_status', '!=', 1)
    ->get();

    if ($reminders != null) {

        foreach ($reminders as $reminder) {
            $checkOutDate = $reminder->check_out_date;
            $expectedDate = $reminder->expected_date;
            $checkInDate = $reminder->check_in_date;
            $currentDate = date(Utilities::DATE_FORMAT, time());

            if ($currentDate < $expectedDate && Utilities::confirmToSend($expectedDate, $currentDate)) {
                Mail::to($reminder->email)->send(new ReaderReminderMail($reminder));
            }
        }
    }

});