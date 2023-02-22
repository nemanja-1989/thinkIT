<?php

namespace App\Repositories\Book;

use App\Contracts\Book\BookFilterInterface;
use App\Http\Requests\Book\BooksFilterRequest;
use App\Models\Book;

class BookFilterRepository implements BookFilterInterface {

    public function filterBooks(BooksFilterRequest $request) {

        return Book::hasAllData($request->all())->paginate(12);
    }
}
