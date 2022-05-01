<?php

namespace App\Http\Controllers\Api\v1;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Validation\Rules;

/**
 * @group Authentication
 *
 * APIs to manage Authentication
 */
class AuthController extends ApiController
{

    /**
     * Login
     *
     * @bodyParam
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        //Find the user form database
        $user = User::where('username', $request->get('login'))
            ->orWhere('email', $request->get('login'))
            ->first();

        // Check if user exist and password hash is matches
        if ( !$user || !Hash::check($request->get('password'), $user->password) ) {
            return $this->responseNotFound('Authentication failed.');
        }

        // If everything when ok, prepare success response
        $success['token'] =  $user->createToken('LaravelSanctumAuth')->plainTextToken;
        $success['username'] =  $user->username;
        $success['email'] =  $user->email;

        return $this->respondWithData($success);
    }

    /**
     * Logout
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        try {
            $this->currentUser()->tokens()->delete();
        } catch (\Exception $e) {
            return $this->respondInternalError('Something went wrong. Token may have been revoked.');
        }

        return $this->respondWithMessage('Tokens Revoked');
    }

    /**
     * Register
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        // Almost Same validation rules as
        // app/Http/Controllers/Auth/RegisteredUserController.php @ store()
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'max:32', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', Rules\Password::defaults()],
            'invitation_code' => ['required', 'exists:users'],
        ]);


        if($validator->fails()){
            return $this->respondInvalidRequest($validator->errors()->all());
        }


        $input = $validator->validated();

        $user = User::where('invitation_code',$input['invitation_code'])->first();

        $user->update([
            'name' => $input['name'],
            'username' => $input['username'],
            'email' => $input['email'],
            'password' => bcrypt($input['password']),
            'invitation_code' => null,
        ]);

        $success['token'] =  $user->createToken('LaravelSanctumAuth')->plainTextToken;
        $success['username'] = $user->username;

        return $this->respondWithData($success);
    }

}
