<?php

namespace App\Repositories;

use App\Http\Requests\Author\AuthorStoreRequest;
use App\Http\Requests\Author\AuthorUpdateRequest;
use App\Models\Author;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AuthorRepository {

    public function all() {

        try{
            return response()->json([
                'success' => true,
                'authors' => Author::with(['avatar', 'books'])->paginate(12)
            ]);
        }catch(\Exception $e) {
            Log::info($e->getMessage());
        }
    }

    public function show(Author $author) {

        try{
            return response()->json([
                'success' => true,
                'author' => $author->load(['avatar', 'books'])
            ]);
        }catch(\Exception $e) {
            Log::info($e->getMessage());
        }

    }

    public function store(AuthorStoreRequest $request) {
        try {
            $author = Author::create([
                'name' => $request->get('name'),
                'surname' => $request->get('surname'),
            ]);
            if ($request->file('avatar') && $request->file('avatar')->isValid()) {
                    $path = '/author/avatar/';
                    $file = $request->file('avatar');
                    $this->authorFileUpload($file, $path, $author);
                }
                return response()->json(['success' => true, 'message' => 'Author has been successfully created.']);
            } catch (\Exception $e) {
                Log::info($e->getMessage());
        }
    }

    public function update(AuthorUpdateRequest $request, Author $author) {
        try {
            $author->fill([
                'name' => $request->get('name'),
                'surname' => $request->get('surname'),
            ]);
            $author->update();
            if ($request->file('avatar') && $request->file('avatar')->isValid()) {
                    $path = '/user/avatar/';
                    if ($author->avatar()->exists()) {
                        $file = $request->file('avatar');
                        $oldAvatar = $author->avatar->org_filename;
                        $deleteAvatar = Storage::disk('local')->delete($path . $oldAvatar);
                        $author->avatar()->delete();
                        if ($deleteAvatar === true) {
                            $this->authorFileUpload($file, $path, $author);
                        }else {
                            $this->authorFileUpload($file, $path, $author);
                        }
                    }
                }
                    return response()->json(['success' => true, 'message' => 'Author has been successfully updated.']);
            } catch (\Exception $e) {
                    Log::info($e->getMessage());
            }
    }

    public function destroy(Author $author) {
        try{
            $author->delete();
            $author->avatar()->delete();
            return response()->json(['success' => true, 'message' => 'Author has been successfully deleted.']);
        }catch(\Exception $e) {
            Log::info($e->getMessage());
        }
    }

    private function authorFileUpload($file, $path, $author) {
        $orgFilename = Str::random(20) . '.' . $file->getClientOriginalExtension();
        $filename = $file->getClientOriginalName();
        Storage::disk('local')->put($path . $orgFilename, file_get_contents($file->getRealPath()));
        Storage::disk('local')->setVisibility($path . $orgFilename, 'public');
        $author->avatar()->create(['image_name' => $filename, 'org_filename' => $orgFilename]);
    }
}

