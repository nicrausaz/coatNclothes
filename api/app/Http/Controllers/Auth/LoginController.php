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
use Lang;


class LoginController extends Controller
{
    use AuthenticatesUsers;
    use Helpers;

    public function login(Request $request)
    {
        // Dans notre cas, comme l'on souhaite pouvoir se connecter soit en rentrant l'email, soit le pseudo, je rajoute une condition à ma requête
        $user = User::where('users_email', $request->users_login)->orWhere('users_login', $request->users_login)->first();

        if ($user && Hash::check($request->get('users_pass'), $user->users_pass)) {
            $token = JWTAuth::fromUser($user);
            //$token= JWTAuth::attempt($user);
            return $this->sendLoginResponse($request, $token, $user);
        }

        return $this->sendFailedLoginResponse($request);
    }

    public function sendLoginResponse(Request $request, $token, $user)
    {
        $this->clearLoginAttempts($request);

        return $this->authenticated($token, $user);
    }

    public function authenticated($token, $user)
    {
        return $this->response->array([
            'token' => $token,
            'users_id' => $user->users_id,
            'users_name'=> $user->users_name,
            'users_fsname' => $user->users_fsname,
            'users_login' => $user->users_login,
            'users_email' => $user->users_email,
            'users_admin' => $user->users_admin,
            'status_code' => 200,
            'message' => lang::get('auth.connectedWithSuccess')
        ]);
    }

    public function sendFailedLoginResponse()
    {
        abort(401, lang::get('auth.failed'));
    }

    public function logout()
    {
        $this->guard()->logout();
        return $this->response->array([
            'status_code' => 200,
            'message' => lang::get('auth.logout')
        ]);
    }
}
