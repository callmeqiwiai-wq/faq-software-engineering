<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TestStatisticsController;
use App\Http\Controllers\TestResultController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('search', [SearchController::class, 'index'])->name('search');

// Knowledge base (sections & articles) - public
// Keep legacy `faq` route name used in some views — alias to sections index
Route::get('faq', [SectionController::class, 'index'])->name('faq.index');

Route::get('knowledge', [SectionController::class, 'index'])->name('knowledge.index');
Route::get('sections/{slug}', [SectionController::class, 'show'])->name('sections.show');
Route::get('articles/{slug}', [ArticleController::class, 'show'])->name('articles.show');

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // Comment routes
    Route::post('articles/{article}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::put('comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Test routes
    Route::get('tests', [TestController::class, 'index'])->name('tests.index');
    Route::get('tests/statistics', [TestStatisticsController::class, 'index'])->name('tests.statistics');
    // NOTE: legacy 'diagnostic' route removed — use tests.index/tests.statistics instead
    Route::get('tests/{test}', [TestController::class, 'show'])->name('tests.show');
    Route::get('tests/{test}/start', [TestController::class, 'start'])->name('tests.start');
    // Backwards-compatible alias used in some views: singular 'test.start'
    Route::get('tests/{test}/start', [TestController::class, 'start'])->name('test.start');
    Route::post('tests/{test}/submit', [TestController::class, 'submit'])->name('tests.submit');
    
    // Test results routes
    Route::get('test-results', [TestResultController::class, 'index'])->name('test-results.index');
    Route::get('test-results/{result}', [TestResultController::class, 'show'])->name('test-results.show');

    // Protected admin/moderator routes
    Route::middleware('role:admin,moderator')->group(function () {
        Route::get('test-results/user/{user}', [TestResultController::class, 'userResults'])
            ->name('test-results.user');
        Route::resource('sections', SectionController::class)->except(['index', 'show']);
        Route::resource('articles', ArticleController::class)->except(['show']);
        Route::resource('tests', TestController::class)->except(['index', 'show']);
    });
});
