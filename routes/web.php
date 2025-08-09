<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StudentController;
use Faker\Guesser\Name;

Route::get('/', [LoginController::class, 'index'])->name('login.index');


Route::get('/dashboard', function () {
    return view('main.index');
})->name('dashboard.index');

Route::post('/login', [LoginController::class, 'login'])->name('login.login');

Route::get('/Students', [StudentController::class, 'index'])->name('students.index');

Route::post('/Students', [StudentController::class, 'store'])->name('students.store');

Route::put('/Students', [StudentController::class, 'update'])->name('students.update');

Route::delete('/Students', [StudentController::class, 'destroy'])->name('students.destroy');

Route::get('/tables.html', function () {
    return view('template.tables');
})->name('tables.index');