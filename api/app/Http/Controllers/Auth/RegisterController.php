<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Routing\Helpers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    use Helpers;

    public function register(Request $request){

        $validator = $this->validator($request->all());
        if($validator->fails()){
            throw new StoreResourceFailedException("Validation Error", $validator->errors());
        }

        $user = $this->create($request->all());

        if($user){

            $token = JWTAuth::fromUser($user);

            return $this->response->array([
                "token" => $token,
                "message" => "User created",
                "status_code" => 201
            ]);
        }else{
            return $this->response->error("User Not Found...", 404);
        }
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'users_login' => 'required|unique:users',
            'users_email' => 'required|email|max:255|unique:users',
            'users_pass' => 'required|min:6',
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'users_login' => $data['users_login'],
            'users_email' => $data['users_email'],
            'users_pass' => bcrypt($data['users_pass']),
        ]);
    }
}
