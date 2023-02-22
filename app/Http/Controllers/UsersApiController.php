<?php

namespace App\Http\Controllers;

use App\Contracts\User\UserInterface;
use App\Helpers\PermissionConstants;
use App\Helpers\RoleConstants;
use App\Http\Requests\User\UserRegisterRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UsersApiController extends Controller
{

    public function __construct(private UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->middleware([
            'role_or_permission:' .
            RoleConstants::LIBRARIAN['name'] . '|' .
            PermissionConstants::USER_PRIVILEGES['name']
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
                'users' => $this->userRepository->paginate()
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
    public function store(UserRegisterRequest $request)
    {
        try {
            $user = $this->userRepository->store($request);
            return response()->json([
                'success' => true,
                'token_type' => 'Bearer',
                'token' => $user->createToken(env('API_TOKEN'))->plainTextToken,
                'message' => 'User has been successfully created',
                'user' => $user->load(['roles', 'permissions'])
            ], 201);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        try{
            return response()->json([
                'success' => true,
                'author' => $this->userRepository->show($user)
            ]);
        }catch(\Exception $e) {
            Log::info($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        try {
            $this->userRepository->update($request, $user);
            return response()->json([
                'success' => true,
                'message' => 'User has been successfully updated.',
                'user' => $user->load(['roles', 'permissions'])
            ], 204);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try{
            $this->userRepository->destroy($user);
            return response()->json([
                'success' => true,
                'message' =>
                'User has been successfully deleted.'
            ]);
        }catch(\Exception $e) {
            Log::info($e->getMessage());
        }
    }
}
