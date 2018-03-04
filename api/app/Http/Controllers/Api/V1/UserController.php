<?php
namespace App\Http\Controllers\Api\V1;

use Dingo\Api\Contract\Http\Request;
use Dingo\Api\Http\Response;
use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;
use App\Http\Transformers\UserTransformer;


class UserController extends Controller
{
    use Helpers;

    public function index(){
        return User::all();
    }
}
