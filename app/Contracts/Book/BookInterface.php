<?php

namespace App\Contracts\Book;

use App\Http\Requests\Book\BookStoreRequest;
use App\Http\Requests\Book\BookUpdateRequest;
use App\Models\Book;

interface BookInterface {

    /**
     * @return [type]
     */
    public function paginate();
    /**
     * @param Book $book
     *
     * @return [type]
     */
    public function show(Book $book);
    /**
     * @param BookStoreRequest $request
     *
     * @return [type]
     */
    public function store(BookStoreRequest $request);
    /**
     * @param BookUpdateRequest $request
     * @param Book $book
     *
     * @return [type]
     */
    public function update(BookUpdateRequest $request, Book $book);
    /**
     * @param Book $book
     *
     * @return [type]
     */
    public function destroy(Book $book);
}
