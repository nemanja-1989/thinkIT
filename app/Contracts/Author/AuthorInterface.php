<?php

namespace App\Contracts\Author;

use App\Http\Requests\Author\AuthorStoreRequest;
use App\Http\Requests\Author\AuthorUpdateRequest;
use App\Models\Author;

interface AuthorInterface {

    public function paginate();
    public function show(Author $author);
    public function store(AuthorStoreRequest $request);
    public function update(AuthorUpdateRequest $request, Author $author);
    public function destroy(Author $author);
}
