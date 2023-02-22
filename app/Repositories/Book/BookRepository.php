<?php

namespace App\Repositories\Book;

use App\Contracts\Book\BookInterface;
use App\Http\Requests\Book\BooksFilterRequest;
use App\Http\Requests\Book\BookStoreRequest;
use App\Http\Requests\Book\BookUpdateRequest;
use App\Models\Book;


class BookRepository implements BookInterface  {

    /**
     * @return [type]
     */
    public function paginate() {

        return Book::with(['author'])->paginate(12);
    }

    /**
     * @param Book $book
     *
     * @return [type]
     */
    public function show(Book $book) {

        return $book->load(['author']);
    }

    /**
     * @param BookStoreRequest $request
     *
     * @return [type]
     */
    public function store(BookStoreRequest $request) {

        return Book::create([
            'author_id' => $request->get('author_id'),
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'book_number' => $request->get('book_number'),
        ]);
    }

    /**
     * @param BookUpdateRequest $request
     * @param Book $book
     *
     * @return [type]
     */
    public function update(BookUpdateRequest $request, Book $book) {
        $book->fill([
            'author_id' => $request->get('author_id'),
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'book_number' => $request->get('book_number'),
        ]);
        $book->update();
    }

    /**
     * @param Book $book
     *
     * @return [type]
     */
    public function destroy(Book $book) {
        $book->delete();
    }
}
