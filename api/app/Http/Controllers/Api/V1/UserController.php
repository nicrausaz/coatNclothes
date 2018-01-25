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

    public function index()
    {
        $array = \DB::select('select * from TB_Users where users_id = 2', array(1));
        //var_dump($array);

        return json_encode($array);
    }
}
