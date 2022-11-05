<?php

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
Route::get('/login', [UserController::class, 'login'])->name('login');

//Registration page
Route::get('/register', [UserController::class, 'register'])->name('register');

//Register new user
Route::post('/registerUser', [UserController::class, 'registerUser']);

//Landing libray view page. Authenticated access
Route::get('/', [BookController::class, 'index'])->middleware('auth');

//Logs in user
Route::post('authenticateUser', [UserController::class, 'authenticateUser']);

//Logs out user
Route::get('/logout', [UserController::class, 'logoutUser'])->middleware('auth');

//Displays form to add new book to library
Route::get('/book', [BookController::class, 'book'])->middleware('auth');

//Adds new book to library
Route::post('/addBook', [BookController::class, 'addBook'])->name('create_book');