<?php

namespace App\Repositories\Author;

use App\Contracts\Author\AuthorInterface;
use App\Http\Requests\Author\AuthorStoreRequest;
use App\Http\Requests\Author\AuthorUpdateRequest;
use App\Models\Author;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AuthorRepository implements AuthorInterface {

    public function paginate() {

        return Author::with(['avatar', 'books'])->paginate(12);
    }

    public function show(Author $author) {

        return $author->load(['avatar', 'books']);
    }

    public function store(AuthorStoreRequest $request) {
        $author = Author::create([
            'name' => $request->get('name'),
            'surname' => $request->get('surname'),
        ]);
        if ($request->file('avatar') && $request->file('avatar')->isValid()) {
                $path = '/author/avatar/';
                $file = $request->file('avatar');
                $this->authorFileUpload($file, $path, $author);
        }
        return $author->load(['avatar', 'books']);
    }

    public function update(AuthorUpdateRequest $request, Author $author) {
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
    }

    public function destroy(Author $author) {
        $author->delete();
        $author->avatar()->delete();
    }

    private function authorFileUpload($file, $path, $author) {
        $orgFilename = Str::random(20) . '.' . $file->getClientOriginalExtension();
        $filename = $file->getClientOriginalName();
        Storage::disk('local')->put($path . $orgFilename, file_get_contents($file->getRealPath()));
        Storage::disk('local')->setVisibility($path . $orgFilename, 'public');
        $author->avatar()->create(['image_name' => $filename, 'org_filename' => $orgFilename]);
    }
}

