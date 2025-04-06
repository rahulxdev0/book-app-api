<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('signup', [AuthController::class, 'signup']);
Route::post('login', [AuthController::class, 'login']);
Route::get('user', [AuthController::class, 'getAuthUser'])->middleware('auth:sanctum');

Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Route::get('/books', [BookController::class, 'index']);
    
// // Create new book (POST)
// Route::post('/books', [BookController::class, 'store']);
    
// // Get single book (GET)
// Route::get('/books/{book}', [BookController::class, 'show']);
    
// // Update book (PUT/PATCH)
// Route::put('/books/{book}', [BookController::class, 'update']);
// Route::patch('/books/{book}', [BookController::class, 'update']);
    
// // Delete book (DELETE)
// Route::delete('/books/{book}', [BookController::class, 'destroy']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/books', [BookController::class, 'index']);        // List all books (authenticated users only)
    Route::post('/books', [BookController::class, 'store']);       // Create a book (authenticated users only)
    Route::get('/books/{book}', [BookController::class, 'show']);  // Show a book (optional auth)
    Route::put('/books/{book}', [BookController::class, 'update']); // Update a book (authenticated users only)
    Route::delete('/books/{book}', [BookController::class, 'destroy']); // Delete a book (authenticated users only)
});