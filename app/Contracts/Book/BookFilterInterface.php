<?php

namespace App\Contracts\Book;

use App\Http\Requests\Book\BooksFilterRequest;
use Illuminate\Support\Collection;

interface BookFilterInterface {

    /**
     * @param BooksFilterRequest $request
     *
     * @return [type]
     */
    public function filterBooks(BooksFilterRequest $request);
}
