<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\QuestionController as AdminQuestionController;
use App\Http\Controllers\Admin\QuestionImportController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

// Frontend routes (public)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/category/{category:slug}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/search', [SearchController::class, 'index'])->name('search');

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('login', [AuthenticatedSessionController::class, 'store']);
    });

    Route::middleware('auth')->group(function () {
        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

        Route::get('dashboard', DashboardController::class)->name('dashboard');

        Route::resource('categories', AdminCategoryController::class)->except('show');
        Route::patch('categories/{category}/toggle-status', [AdminCategoryController::class, 'toggleStatus'])
            ->name('categories.toggle-status');

        Route::resource('questions', AdminQuestionController::class)->except('show');
        Route::patch('questions/{question}/toggle-status', [AdminQuestionController::class, 'toggleStatus'])
            ->name('questions.toggle-status');

        Route::get('import', [QuestionImportController::class, 'create'])->name('import.create');
        Route::post('import', [QuestionImportController::class, 'store'])->name('import.store');
    });
});
