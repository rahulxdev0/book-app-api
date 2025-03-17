<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $books = auth()->user()->books()->latest()->get();
        $books = Book::all();
         return response()->json($books);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'caption' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Store image
        $imagePath = $request->file('image')->store('books', 'public');

        $book = Book::create([
            'title' => $request->title,
            'caption' => $request->caption,
            'image' => $imagePath,
            'rating' => $request->rating,
        ]);

        return response()->json($book, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return response()->json($book);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'caption' => 'sometimes|string',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'rating' => 'sometimes|integer|min:1|max:5',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = $request->only(['title', 'caption', 'rating']);

        if ($request->hasFile('image')) {
            // Delete old image
            Storage::disk('public')->delete($book->image);
            // Store new image
            $data['image'] = $request->file('image')->store('books', 'public');
        }

        $book->update($data);

        return response()->json($book);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        // Delete associated image
        Storage::disk('public')->delete($book->image);
        
        $book->delete();
        return response()->json(null, 204);
    }
}
