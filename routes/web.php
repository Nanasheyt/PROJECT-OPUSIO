<?php

use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PortfolioController::class, 'home'])->name('home');

// Information pages
Route::view('/about', 'pages.about')->name('about');
Route::view('/faq', 'pages.faq')->name('faq');
Route::view('/privacy', 'pages.privacy')->name('privacy');

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

// Download the portfolio as a PDF file
Route::get('/portfolios/{portfolio}/pdf', [PortfolioController::class, 'pdf'])->name('portfolios.pdf');

// The generated portfolio itself (public link)
Route::get('/p/{portfolio}', [PortfolioController::class, 'show'])->name('portfolios.show');
