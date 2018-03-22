<?php
namespace App\Http\Controllers\Api\V1;

use Dingo\Api\Contract\Http\Request;
use Dingo\Api\Http\Response;
use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;


class adminController extends Controller
{

    use Helpers;

    function __construct(){
        $this->checkIfAdmin();
    }
    private function checkIfAdmin(){
        $userAdmin = \Auth::user()->users_admin;
        if($userAdmin != 1){
            \Log::error("ID: (".\Auth::user()->users_id.") tried to access an admin ressource");
            abort(403, 'Action non autorisée.');
        }
    }
}
