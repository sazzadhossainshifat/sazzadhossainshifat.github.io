<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\AdminController;

Route::get('/', [PortfolioController::class, 'index'])->name('portfolio.index');
Route::get('/projects', [PortfolioController::class, 'projects'])->name('portfolio.projects');

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');

    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::post('/hero/update', [AdminController::class, 'updateHero'])->name('admin.hero.update');

        // Project Management Routes
        Route::post('/projects/store', [AdminController::class, 'storeProject'])->name('admin.projects.store');
        Route::post('/projects/{id}/update', [AdminController::class, 'updateProject'])->name('admin.projects.update');
        Route::delete('/projects/{id}', [AdminController::class, 'deleteProject'])->name('admin.projects.delete');
        Route::post('/projects/reorder', [AdminController::class, 'reorderProjects'])->name('admin.projects.reorder');

        // Category Management Routes
        Route::post('/categories/store', [AdminController::class, 'storeCategory'])->name('admin.categories.store');
        Route::post('/categories/{id}/update', [AdminController::class, 'updateCategory'])->name('admin.categories.update');
        Route::delete('/categories/{id}', [AdminController::class, 'deleteCategory'])->name('admin.categories.delete');

        // Experience Management Routes
        Route::post('/experiences/store', [AdminController::class, 'storeExperience'])->name('admin.experiences.store');
        Route::post('/experiences/{id}/update', [AdminController::class, 'updateExperience'])->name('admin.experiences.update');
        Route::delete('/experiences/{id}', [AdminController::class, 'deleteExperience'])->name('admin.experiences.delete');
        Route::post('/experiences/reorder', [AdminController::class, 'reorderExperiences'])->name('admin.experiences.reorder');
    });
});
