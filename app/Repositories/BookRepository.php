<?php

namespace App\Repositories;

use App\Http\Requests\Book\BookStoreRequest;
use App\Http\Requests\Book\BookUpdateRequest;
use App\Models\Book;
use Illuminate\Support\Facades\Log;


class BookRepository {

    public function all() {

        try{
            return response()->json([
                'success' => true,
                'books' => Book::with(['author'])->paginate(12)
            ]);
        }catch(\Exception $e) {
            Log::info($e->getMessage());
        }
    }

    public function show(Book $book) {

        try{
            return response()->json([
                'success' => true,
                'book' => $book->load(['author'])
            ]);
        }catch(\Exception $e) {
            Log::info($e->getMessage());
        }

    }

    public function store(BookStoreRequest $request) {
        try {
            $book = Book::create([
                'author_id' => $request->get('name'),
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'book_number' => $request->get('book_number'),
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Book' . $book->title . ' has been successfully created.',
                'book' => $book->load(['author'])
            ]);
            } catch (\Exception $e) {
                Log::info($e->getMessage());
        }
    }

    public function update(BookUpdateRequest $request, Book $book) {
        try {
            $book->fill([
                'author_id' => $request->get('name'),
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'book_number' => $request->get('book_number'),
            ]);
            $book->update();
            return response()->json([
                'success' => true,
                'message' => 'Book ' . $book->title . ' has been successfully updated.',
                'book' => $book->load(['author'])
            ]);
            } catch (\Exception $e) {
                    Log::info($e->getMessage());
            }
    }

    public function destroy(Book $book) {
        try{
            $book->delete();
            return response()->json([
                'success' => true,
                'message' =>
                'Book has been successfully deleted.'
            ]);
        }catch(\Exception $e) {
            Log::info($e->getMessage());
        }
    }
}
