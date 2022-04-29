<?php

namespace App\Http\Controllers\Api\v1;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;
use Illuminate\Validation\Rules;


class AuthController extends ApiController
{

    public function login(Request $request)
    {
        if(Auth::attempt(['username' => $request->username, 'password' => $request->password])){
            $auth = Auth::user();
            $success['token'] =  $auth->createToken('LaravelSanctumAuth')->plainTextToken;
            $success['username'] =  $auth->username;

            return $this->respondWithData($success);
        }
        else{
            return $this->responseNotFound('Authentication failed.');
        }
    }

    public function logout()
    {
        $this->currentUser();

        return $this->respondWithMessage('Tokens Revoked');
    }

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
            return $this->setStatusCode(422)->respond([
                'response' => [
                    'validation_error' => $validator->errors()->all(),
                    'status_code' => $this->getStatusCode(),
                ]
            ]);
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

        return $this->respond($success);
    }

}
