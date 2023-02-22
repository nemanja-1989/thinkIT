<?php

namespace App\Contracts;

use App\Http\Requests\Book\BookStoreRequest;
use App\Http\Requests\Book\BookUpdateRequest;
use App\Models\Book;

interface BookInterface {

    public function paginate();
    public function show(Book $book);
    public function store(BookStoreRequest $request);
    public function update(BookUpdateRequest $request, Book $book);
    public function destroy(Book $book);
}
