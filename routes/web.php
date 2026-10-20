<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PortfolioController::class, 'home'])->name('home');

// Information pages
Route::view('/about', 'pages.about')->name('about');
Route::view('/faq', 'pages.faq')->name('faq');
Route::view('/privacy', 'pages.privacy')->name('privacy');

// Accounts
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:10,1');

    // Forgot / reset password
    Route::get('/forgot-password', [AuthController::class, 'showForgot'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->middleware('throttle:5,1')->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showReset'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->middleware('throttle:10,1')->name('password.update');
});
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// The generated portfolio itself. Anyone with the link can VIEW it; it has no editing controls at all.
Route::get('/p/{portfolio}', [PortfolioController::class, 'show'])->name('portfolios.show');

// Everything below needs a login, and each portfolio can only be opened by the account that owns it.
Route::middleware('auth')->group(function () {
    // Manage (list / edit / delete)
    Route::get('/portfolios', [PortfolioController::class, 'index'])->name('portfolios.index');

    // Create + enter information
    Route::get('/portfolios/create', [PortfolioController::class, 'create'])->name('portfolios.create');
    Route::post('/portfolios', [PortfolioController::class, 'store'])->name('portfolios.store');

    // Edit / delete
    Route::get('/portfolios/{portfolio}/edit', [PortfolioController::class, 'edit'])->name('portfolios.edit');
    Route::put('/portfolios/{portfolio}', [PortfolioController::class, 'update'])->name('portfolios.update');
    Route::delete('/portfolios/{portfolio}', [PortfolioController::class, 'destroy'])->name('portfolios.destroy');

    // Template selection + preview
    Route::get('/portfolios/{portfolio}/templates', [PortfolioController::class, 'templates'])->name('portfolios.templates');
    Route::post('/portfolios/{portfolio}/template', [PortfolioController::class, 'selectTemplate'])->name('portfolios.select');
    Route::get('/portfolios/{portfolio}/preview', [PortfolioController::class, 'preview'])->name('portfolios.preview');

    // Save (keeps the previewed template) and the "Saved" page
    Route::post('/portfolios/{portfolio}/save', [PortfolioController::class, 'save'])->name('portfolios.save');
    Route::get('/portfolios/{portfolio}/saved', [PortfolioController::class, 'saved'])->name('portfolios.saved');

    // Download the portfolio as a PDF file
    Route::get('/portfolios/{portfolio}/pdf', [PortfolioController::class, 'pdf'])->name('portfolios.pdf');
});
