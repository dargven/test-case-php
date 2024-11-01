<?php

use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', [OrderController::class, 'showForm'])->name('home');
Route::post('/book', [OrderController::class, 'book'])->name('order.book');
Route::post('/approve', [OrderController::class, 'approve'])->name('order.approve');
