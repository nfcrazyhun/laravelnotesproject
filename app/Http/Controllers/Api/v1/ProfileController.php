<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ApiController;
use App\Http\Transformers\UserTransformer;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends ApiController
{
    protected $userTransformer;

    function __construct(UserTransformer $userTransformer)
    {
        $this->userTransformer = $userTransformer;
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show()
    {
        $user = auth('sanctum')->user()->toArray();

        return $this->respondWithData(
            $this->userTransformer->transform($user)
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        //validation
        $validator = Validator::make($request->all(), [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'username' => ['sometimes', 'required', 'max:32', Rule::unique('users')->ignore(Auth::user())],
            'email' => ['sometimes', 'required', 'email', 'string', 'max:255', Rule::unique('users')->ignore(Auth::user())],
            'password' => ['nullable', 'string', 'confirmed', 'min:8'],
        ]);

        if($validator->fails()){
            return $this->respondInvalidRequest($validator->errors()->all());
        }

        $user = auth('sanctum')->user();

        $user->update($validator->getData());

        return $this->respondWithData(
            $this->userTransformer->transform( $user->toArray() )
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(UserService $userService)
    {
        // Get the user
        $user = auth('sanctum')->user();

        // Log the user out
        $user->tokens()->delete();

        // Delete the user (note that softDeleteUser() should return a boolean for below)
        $deleted = $userService->GDPRdelete($user);

        if (! $deleted) {
            return $this->respondWithError('Failed to delete your profile');
        }

        return $this->respondWithMessage('Profile deleted successfully. Bye-bye!');
    }
}
