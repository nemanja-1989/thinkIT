<?php

namespace App\Contracts\User;

use App\Http\Requests\User\UserRegisterRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\User;

interface UserInterface {

    public function paginate();
    public function show(User $user);
    public function store(UserRegisterRequest $request);
    public function update(UserUpdateRequest $request, User $user);
    public function destroy(User $user);
}
