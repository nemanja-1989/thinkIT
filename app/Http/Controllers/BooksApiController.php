<?php

namespace App\Http\Controllers;

use App\Contracts\Book\BookFilterInterface;
use App\Contracts\Book\BookInterface;
use App\Http\Requests\Book\BooksFilterRequest;
use App\Http\Requests\Book\BookStoreRequest;
use App\Http\Requests\Book\BookUpdateRequest;
use App\Models\Book;
use Illuminate\Support\Facades\Log;

class BooksApiController extends Controller
{

    public function __construct(
        private BookInterface $bookRepositoryInterface,
    )
    {
        $this->bookRepositoryInterface = $bookRepositoryInterface;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            return response()->json([
                'success' => true,
                'books' => $this->bookRepositoryInterface->paginate()
            ]);
        }catch(\Exception $e) {
            Log::info($e->getMessage());
        }
    }

     /**
     * Display a listing of the resource with filters.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filterBooks(BooksFilterRequest $request, BookFilterInterface $bookRepository) {
        try{
            return response()->json([
                'success' => true,
                'books' => $bookRepository->filterBooks($request)
            ]);
        }catch(\Exception $e) {
            Log::info($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookStoreRequest $request)
    {
        try {
            $book = $this->bookRepositoryInterface->store($request);
            return response()->json([
                'success' => true,
                'message' => 'Book' . $book->title . ' has been successfully created.',
                'book' => $book->load(['author'])
            ]);
            } catch (\Exception $e) {
                Log::info($e->getMessage());
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        try{
            return response()->json([
                'success' => true,
                'book' => $this->bookRepositoryInterface->show($book)
            ]);
        }catch(\Exception $e) {
            Log::info($e->getMessage());
        }
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
        try {
            $this->bookRepositoryInterface->update($request, $book);
            return response()->json([
                'success' => true,
                'message' => 'Book ' . $book->title . ' has been successfully updated.',
                'book' => $book->load(['author'])
            ]);
            } catch (\Exception $e) {
                Log::info($e->getMessage());
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        try{
            $this->bookRepositoryInterface->destroy($book);
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
