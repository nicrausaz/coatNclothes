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
use Lang;
use App\Http\Controllers\Api\V1\Mail\MailController;

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
            throw new StoreResourceFailedException(lang::get('auth.dataValidationFailed'), $validator->errors());
        }

        $user = $this->create($request->all());

        if($user){

            //dispatch(new SendVerificationEmail($user));
            if(MailController::sendRegistration($user->users_fsname, $user->users_name,$user->users_login, $user->users_email)==true) $sent=1; else $sent=0;

            $token = JWTAuth::fromUser($user);
            return $this->response->array([
                "token" => $token,
                'users_id' => $user->users_id,
                'users_name'=> $user->users_name,
                'users_fsname' => $user->users_fsname,
                'users_login' => $user->users_login,
                'users_email' => $user->users_email,
                'users_admin' => 0,
                'start_mail' => $sent,
                "message" => lang::get('auth.userCreatedSuccess'),
                "status_code" => 201
            ]);
        }else{
            return $this->response->error("Utilisateur introuvable", 404);
        }
    }

    protected function validator(array $data)
    {

        return Validator::make($data, [
            'users_login' => 'required|max:30|unique:TB_Users',
            'users_email' => 'required|email|max:255|unique:TB_Users',
            'users_pass' => 'required|min:6',
            'users_name' => 'required|max:80',
            'users_fsname' => 'required|max:80'
        ]);
    }
    private function recapcha(Request $request){

        $input = $request->all();

        $data=array([
          'secret'=>Config::get('app.recapchav2_secret'),
            'url'=>Config::get('app.recapchav2_url'),
            'remoteip'=>Request::ip(),
            'response'=>$input['g-recaptcha-response']
        ]);
        $recapcha = json_decode(file_get_contents($data['url']."?secret=".$data['secret']."&response=".$data['response']."&remoteip=".$data['remoteip']));

        if($recapcha->success)return true; else return false;
    }

    protected function create(array $data)
    {
        return User::create([
            'users_login' => $data['users_login'],
            'users_email' => $data['users_email'],
            'users_pass' => bcrypt($data['users_pass']),
            'users_name' => $data['users_name'],
            'users_fsname' => $data['users_fsname']
        ]);
    }
}
