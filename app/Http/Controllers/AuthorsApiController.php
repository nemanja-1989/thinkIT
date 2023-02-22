<?php

namespace App\Http\Controllers;

use App\Contracts\Author\AuthorInterface;
use App\Helpers\PermissionConstants;
use App\Helpers\RoleConstants;
use App\Http\Requests\Author\AuthorStoreRequest;
use App\Http\Requests\Author\AuthorUpdateRequest;
use App\Models\Author;
use Illuminate\Support\Facades\Log;

class AuthorsApiController extends Controller
{

    public function __construct(private AuthorInterface $authorRepository)
    {
        $this->authorRepository = $authorRepository;
        $this->middleware([
            'role_or_permission:' .
            RoleConstants::LIBRARIAN['name'] . '|' .
            PermissionConstants::AUTHOR_PRIVILEGES['name']
        ]);
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
                'authors' => $this->authorRepository->paginate()
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
    public function store(AuthorStoreRequest $request)
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'Author ' . $this->authorRepository->store($request)->name . ' has been successfully created.',
                'author' => $this->authorRepository->store($request)
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
    public function show(Author $author)
    {
        try{
            return response()->json([
                'success' => true,
                'author' => $this->authorRepository->show($author)
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
    public function update(AuthorUpdateRequest $request, Author $author)
    {
        try {
            $this->authorRepository->update($request, $author);
            return response()->json([
                'success' => true,
                'message' => 'Author ' . $author->name . ' has been successfully updated.',
                'author' => $author->load(['avatar', 'books'])
            ]);
        }catch(\Exception $e) {
            Log::info($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Author $author)
    {
        try{
            $this->authorRepository->destroy($author);
            return response()->json([
                'success' => true,
                'message' => 'Author has been successfully deleted.'
            ]);
        }catch(\Exception $e) {
            Log::info($e->getMessage());
        }
    }
}
