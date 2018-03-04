<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Dingo\Api\Routing\Helpers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    use Helpers;

    public function login(Request $request)
    {
        //print_r($request);
        // $request->email correspond à la valeur de l'input entré par l'utilisateur
        // Dans notre cas, comme l'on souhaite pouvoir se connecter soit en rentrant l'email, soit le pseudo, je rajoute une condition à ma requête
        $user = User::where('users_email', $request->users_login)->orWhere('users_login', $request->users_login)->first();

        if ($user && Hash::check($request->get('users_pass'), $user->users_pass)) {
            $token = JWTAuth::fromUser($user);
            return $this->sendLoginResponse($request, $token);
        }

        return $this->sendFailedLoginResponse($request);
    }

    public function sendLoginResponse(Request $request, $token)
    {
        $this->clearLoginAttempts($request);

        return $this->authenticated($token);
    }

    public function authenticated($token)
    {
        return $this->response->array([
            'token' => $token,
            'status_code' => 200,
            'message' => 'User Authenticated'
        ]);
    }

    public function sendFailedLoginResponse()
    {
        throw new UnauthorizedHttpException("Bad Credentials");
    }

    public function logout()
    {
        $this->guard()->logout();
    }
}
