<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/create-student', [App\Http\Controllers\StudentController::class, 'create'])->name('register-student');
Route::post('/store', [App\Http\Controllers\StudentController::class, 'store'])->name('store-student');
Route::get('/edit/{id}', [App\Http\Controllers\StudentController::class, 'edit'])->name('edit-student');
Route::patch('/update/{id}', [App\Http\Controllers\StudentController::class, 'update'])->name('update-student');
Route::delete('/delete/{id}', [App\Http\Controllers\StudentController::class, 'destroy'])->name('delete-student');
Route::any('/search-student', [App\Http\Controllers\StudentController::class, 'studentSearch'])->name('search');
Route::get('/suspend/{id}', [App\Http\Controllers\StudentController::class, 'suspend'])->name('suspend');
Route::get('/activate/{id}', [App\Http\Controllers\StudentController::class, 'activate'])->name('activate');
Route::get('/subjects', [App\Http\Controllers\SubjectController::class, 'index'])->name('subjects');
Route::post('/subjects', [App\Http\Controllers\SubjectController::class, 'store'])->name('subjects.post');
