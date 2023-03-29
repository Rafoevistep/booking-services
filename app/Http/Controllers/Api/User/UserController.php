<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateRequest;
use App\Http\Requests\User\UpdatePasswordRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $users = User::role('writer')->get();

        return $this->ResponseJson($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $user->assignRole('writer');

        return $this->ResponseJson($user);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $user = User::find($id);

        return $this->ResponseJson($user);
    }

    /**
     * Update the user profile details.
     */
    public function update_profile(UpdateRequest $request): JsonResponse
    {
        $user = auth()->user();

        User::find($user['id']);

        $user->update($request->only(['name', 'email']));

        return $this->ResponseJson($user);
    }

    /**
     * Update the user password.
     */
    public function update_password(UpdatePasswordRequest $request): JsonResponse
    {
        $user = auth()->user();

        User::find($user['id']);

        if (Hash::check($request->old_password, $user->password)) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
            return $this->ResponseJson('Password Updated');
        }
        return $this->ErrorResponseJson('Old password is wrong');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $user = User::destroy($id);

        return $this->ResponseJson(['User Successfully Deleted', $user]);

    }
}
