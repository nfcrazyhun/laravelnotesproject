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
     * Handle an incoming authentication request.
     *
     * @bodyParam login string required Username or email. Example: admin || admin@admin.com
     * @bodyParam password string required Password for login. Example: password
     *
     * @response 200 {
        "response": {
            "data": {
                "token": "7|3ihejDPajw9kcEckvImF7fs8Zp4FIQdQRTWOcyvV",
                "username": "admin",
                "email": "admin@admin.com"
            },
            "status_code": 200
        }
    }
     *
     * @response 404 {
        "error": {
            "message": "Authentication failed.",
            "status_code": 404
        }
    }
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
     * Destroy an authenticated session.
     *
     * @authenticated
     *
     * @response 200 {
        "response": {
            "message": "Tokens Revoked",
            "status_code": 200
        }
    }
     *
     * @response 500 {
        "error": {
            "message": "Something went wrong. Token may have been revoked.",
            "status_code": 500
        }
    }
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
     * Handle an incoming registration request.
     *
     * @response 200 {
        "response": {
            "data": {
                "token": "10|kxifJJ2a4nzgafwD1Ucq24mFT1vXEesnr1PBQsP8",
                "username": "apiusaer1aa"
            },
            "status_code": 200
        }
    }
     *
     * @response 422 {
        "error": {
            "message": [
                "The name field is required.",
                "The username field is required.",
                "The email field is required.",
                "The password field is required.",
                "The invitation code field is required."
            ],
            "status_code": 422
        }
    }
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
