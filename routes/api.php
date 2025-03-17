<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('signup', [AuthController::class, 'signup']);
Route::post('login', [AuthController::class, 'login']);

Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/books', [BookController::class, 'index']);
    
    // Create new book (POST)
    Route::post('/books', [BookController::class, 'store']);
    
    // Get single book (GET)
    Route::get('/books/{book}', [BookController::class, 'show']);
    
    // Update book (PUT/PATCH)
    Route::put('/books/{book}', [BookController::class, 'update']);
    Route::patch('/books/{book}', [BookController::class, 'update']);
    
    // Delete book (DELETE)
    Route::delete('/books/{book}', [BookController::class, 'destroy']);