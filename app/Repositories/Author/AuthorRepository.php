<?php

namespace App\Repositories\Author;

use App\Contracts\Author\AuthorInterface;
use App\Events\Author\LibrarianRecordEventAuthor;
use App\Http\Requests\Author\AuthorStoreRequest;
use App\Http\Requests\Author\AuthorUpdateRequest;
use App\Models\Author;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AuthorRepository implements AuthorInterface {

    /**
     * @return [type]
     */
    public function paginate() {

        return Author::with(['avatar', 'books'])->paginate(12);
    }

    /**
     * @param Author $author
     *
     * @return [type]
     */
    public function show(Author $author) {

        return $author->load(['avatar', 'books']);
    }

    /**
     * @param AuthorStoreRequest $request
     *
     * @return [type]
     */
    public function store(AuthorStoreRequest $request) {
        $author = Author::create([
            'name' => $request->get('name'),
            'surname' => $request->get('surname'),
        ]);
        $path = '/author/avatar/';
        $file = $request->file('avatar');
        $this->authorFileUpload($file, $path, $author);
        event(new LibrarianRecordEventAuthor(auth()->user(), $author));
        return $author->load(['avatar', 'books']);
    }

    /**
     * @param AuthorUpdateRequest $request
     * @param Author $author
     *
     * @return [type]
     */
    public function update(AuthorUpdateRequest $request, Author $author) {
        $author->fill([
            'name' => $request->get('name'),
            'surname' => $request->get('surname'),
        ]);
        $author->update();
        $path = '/user/avatar/';
        $file = $request->file('avatar');
        $oldAvatar = $author->avatar->org_filename;
        Storage::disk('local')->delete($path . $oldAvatar);
        $author->avatar()->delete();
        $this->authorFileUpload($file, $path, $author);
    }

    /**
     * @param Author $author
     *
     * @return [type]
     */
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

