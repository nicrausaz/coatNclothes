<?php
/**
 * Created by PhpStorm.
 * User: mbrugger
 * Date: 18.04.2018
 * Time: 15:32
 */

namespace App\Http\Controllers\Api\V1;

use http\Env\Request;
use Lang;
Use Illuminate\Support\Facades\Auth;


class Controller extends \Illuminate\Routing\Controller
{
    /*
     * Commuted intern functions
     */
    public function checkTokenFromId($id){
        $tokennedId = \Auth::user()->users_id;

        if(self::checkIfAdmin()) return true;
        if($id != $tokennedId){
            \Log::error("ID: ($tokennedId) tried to access an unauthorized users ressource User ID:($id)");
            abort(403, lang::get('errors.notAuthorized'));
        }
        return true;
    }
    public function checkIfAdmin(){
        $admin = \Request::segment(2);

        if($admin=='admin') {
            if (!Auth::check()) {
                abort(401, lang::get('auth.tokenNotProvided'));
            }
            $userAdmin = \Auth::user()->users_admin;

            if ($userAdmin != 1) {
                \Log::error("ID: (" . \Auth::user()->users_id . ") tried to access an admin ressource");
                abort(403, lang::get('errors.notAuthorized'));
            } else {
                return true;
            }
        }else{
            return false;
        }
    }
    public static function getTranslation($array){
        $description=json_decode($array, true);
        if(!is_array($description)){
            \Log::error('Error in database, bad translation');
            abort(403, lang::get('errors.uknError'));
        }
        if(key_exists(\App::getLocale(), $description))$description=$description[\App::getLocale()];
        else {
            if(isset($description['en']))$description =$description['en'];
            else$description = NULL;
        }
        return $description;
    }
    public function getLangageInterface(){
        $array = Lang::get('interface');
        return $array;
    }
}