<?php

namespace App\Http\Controllers;

use App\Helpers\PermissionConstants;
use App\Helpers\RoleConstants;
use App\Http\Requests\Book\BookStoreRequest;
use App\Http\Requests\Book\BookUpdateRequest;
use App\Models\Book;
use App\Repositories\BookRepository;

class BooksApiController extends Controller
{

    public function __construct(private BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
        $this->middleware([
            'role_or_permission:' .
            RoleConstants::LIBRARIAN['name'] . '|' .
            RoleConstants::READER['name'] . '|' .
            PermissionConstants::BOOK_PRIVILEGES_VIEW_ONLY['name'] . '|' .
            PermissionConstants::BOOK_PRIVILEGES_CREATE['name'] . '|' .
            PermissionConstants::BOOK_PRIVILEGES_EDIT['name'] . '|' .
            PermissionConstants::BOOK_PRIVILEGES_DELETE['name']
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->bookRepository->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookStoreRequest $request)
    {
        return $this->bookRepository->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return $this->bookRepository->show($book);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BookUpdateRequest $request, Book $book)
    {
        return $this->bookRepository->update($request, $book);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        return $this->bookRepository->destroy($book);
    }
}
