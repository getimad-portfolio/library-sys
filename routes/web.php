<?php

use App\Enums\UserRole;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\LibrarianDashboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\LogController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// General Routes for all type of users
Route::middleware(['auth', 'role:' . UserRole::ADMIN->value . ',' . UserRole::LIBRARIAN->value])->group(function () {
    Route::controller(MemberController::class)->prefix('/members')->name('members.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::get('/{id}', 'show')->name('show');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });

    Route::controller(BookController::class)->prefix('/books')->name('books.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::get('/{id}', 'show')->name('show');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });

    Route::controller(CategoryController::class)->prefix('/categories')->name('categories.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });

    Route::controller(BorrowController::class)->prefix('/borrows')->name('borrows.')->group(function () {
        Route::get('/borrows','index')->name('index');
        Route::get('/create','create')->name('create');
        Route::post('/','store')->name('store');
        Route::put('/{id}','update')->name('update');
    });

    Route::controller(ProfileController::class)->prefix('/profile')->name('profile.')->group(function () {
        Route::get('/', 'edit')->name('edit');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('destroy');
    });
});

// Admin Route
Route::middleware('auth', 'role:' . UserRole::ADMIN->value)->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    Route::controller(LogController::class)->prefix('/logs')->name('logs.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::delete('/', 'destroyAll')->name('destroyAll');
    });
});

// Librarian Route
Route::middleware('auth', 'role:' . UserRole::LIBRARIAN->value)->group(function () {
    Route::get('/librarian/dashboard', [LibrarianDashboardController::class, 'index'])->name('librarian.dashboard');
});

require __DIR__.'/auth.php';
