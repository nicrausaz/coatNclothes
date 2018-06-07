<?php
namespace App\Http\Controllers\Api\V1;

use Dingo\Api\Contract\Http\Request;
use Dingo\Api\Http\Response;
use Dingo\Api\Routing\Helpers;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Lang;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;


class usersController extends Controller
{

    use Helpers;
    use ValidatesRequests;

    /**
     * Gender
     */
    public function getAllGender(){
        $gender =\DB::select('SELECT * FROM TB_Gender');
        foreach ($gender as $key => $value){
            $gender[$key]->gender_sex=$this->getTranslation($value->gender_sex);
        }
        return $gender;
    }
    public function changeUserGender($id, $genderID){
        $this->checkTokenFromId($id);
        $allGender = self::getAllGender();

        $valid=false;
        foreach ($allGender as $item) {
            if($item->gender_id == $genderID)$valid = true;
        }
        if(!$valid){
            \Log::error('trying to change to an non existent gender | user: '.$id);
            abort(403, lang::get('errors.notFound'));
        }
        try {
            \DB::update('UPDATE `TB_Users` SET `fk_gender_id` = ? WHERE `TB_Users`.`users_id` = ?; ', [$genderID, $id]);
        }
        catch (\PDOException $e) {
            \Log::error($e->getMessage());
            abort(403, lang::get('errors.uknError'));
        }
        return $this->response->array([
            'status_code' => 200,
            'message' => lang::get('auth.genderChangedSuccess')
        ]);
    }

    /**
     * Profile
     */
    public function getUserInfo($id){
        $this->checkTokenFromId($id);
        $user = \DB::select('SELECT users_id, users_name, users_fsname, users_email, users_login, users_createDate, users_enabled, users_admin, fk_gender_id FROM TB_Users WHERE users_id = ?', [$id]);
        if(!empty($user[0])){

            $user = $user[0];
        }else{

            \Log::error('User not found');
            abort(403, lang::get('auth.userNotFound'));
        }

        $gender_id=$user->fk_gender_id;
        if (isset($gender_id)){

            $gender = \DB::select('SELECT * FROM `TB_Gender` WHERE `gender_id` =  ?', [$gender_id]);
            $user->gender=$this->getTranslation($gender[0]->gender_sex);
            $user->genderAbrev=$gender[0]->gender_abreviation;

        }
        $pic = \DB::select('SELECT usersPics_path FROM TB_UsersPics WHERE fk_users_id = ? AND usersPics_dlDate IS NULL', [$id]);

        if(isset($pic)) {
            if(!empty($pic[0])){
                $user->users_pic=$pic[0]->usersPics_path;
            }
        }

        return json_encode($user);
    }
    public function changeUserPassword(Request $request, $id){
        $this->checkTokenFromId($id);
        $user = \Auth::user();
        $input =$request->all();
        if(empty($input['users_pass'])AND empty($input['users_newpass'])){
            \Log::error('missing argument for password update | user: '.$id);
            abort(403, lang::get('auth.missingArgument'));
        }
        $request->users_login=$user->users_login;
        $login = new LoginController();
        $login->login($request);
        $request->user()->fill([
            'users_pass' => Hash::make($request->users_newpass)
        ])->save();
        return $this->response->array([
            'status_code' => 200,
            'message' => lang::get('auth.passChangedSuccess')
        ]);

    }
    public function changeUserInfo(Request $request, $id){
        $this->checkTokenFromId($id);

        $input = $request->all();
        if((!isset($input['users_name']))AND(!isset($input['users_fsname']))AND(!isset($input['users_login']))AND(!isset($input['users_email']))){
            \Log::error('missing argument for changing info | user: '.$id);
            abort(403, lang::get('auth.missingArgument'));
        }

        $user = \DB::select('SELECT users_name, users_login, users_fsname, users_email FROM TB_Users WHERE users_id =?', [$id]);
        $user = $user[0];

        if((!empty($input['users_name'])AND !preg_match('#[^A-Za-z]#', $input['users_name']))) $name = $input['users_name']; else $name = $user->users_name;
        if((!empty($input['users_login'])AND !preg_match('#[^A-Za-z]#', $input['users_login']))) $login = $input['users_login']; else $login = $user->users_login;
        if((!empty($input['users_fsname'])AND !preg_match('#[^A-Za-z]#', $input['users_fsname']))) $fsname = $input['users_fsname']; else $fsname = $user->users_fsname;
        if((!empty($input['users_email']))AND (filter_var($input['users_email'], FILTER_VALIDATE_EMAIL))) $email = $input['users_email']; else $email = $user->users_email;

        try {
            \DB::update('UPDATE `TB_Users` SET `users_email` = ?, `users_login` = ?, `users_fsname` = ?, `users_name`=? WHERE `TB_Users`.`users_id` = ?;', [$email, $login, $fsname, $name, $id]);
        }
        catch (\PDOException $e) {
            \Log::error($e->getMessage());
            abort(403, lang::get('errors.uknError'));
        }
        return $this->response->array([
            'status_code' => 200,
            'message' => lang::get('auth.infoChangedSuccess')
        ]);
    }
    public function deleteUserProfile($id){
        $this->checkTokenFromId($id);

    }

    /**
     * Pics
     */
    public function updateUserPic(Request $request, $id){

        $this->checkTokenFromId($id);


        $this->validate($request, [
            'users_pic' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);


        $image = $request->file('users_pic');


        $input['imagename'] = hash('sha256',time().rand(11111, 99999)).'.'.$image->getClientOriginalExtension();

        $destinationPath = public_path('/profilePics');

        $image->move($destinationPath, $input['imagename']);

        $actualUserPic = \DB::select('SELECT * FROM TB_UsersPics WHERE usersPics_dlDate IS NULL AND fk_users_id = ?', [$id]);

        if(isset($actualUserPic)) {
            if (!empty($actualUserPic[0])) {
                try {
                    \DB::update('UPDATE `TB_UsersPics` SET `usersPics_dlDate` = NOW() WHERE `TB_UsersPics`.`usersPics_id` = ?', [$actualUserPic[0]->usersPics_id]);
                } catch (\PDOException $e) {
                    \Log::error($e->getMessage());
                    abort(403, lang::get('errors.uknError'));
                }
            }
        }
        try {
            \DB::insert('INSERT INTO `TB_UsersPics` (`usersPics_id`, `usersPics_path`, `usersPics_creationDate`, `usersPics_dlDate`, `fk_users_id`) VALUES (NULL, ?, NOW(), NULL, ?);', ['https://'.request()->getHost().'/public/profilePics/'.$input['imagename'], $id]);
        } catch (\PDOException $e) {
            \Log::error($e->getMessage());
            abort(403, lang::get('errors.uknError'));
        }

        return $this->response->array([
            'status_code' => 200,
            'message' => lang::get('auth.updatePicSuccess')
        ]);

    }
    public function deleteUserPic($id){
        $this->checkTokenFromId($id);
        $actualPath = public_path('/profilePics');
        $newPath = public_path('/profilePics/OLD');


        $actualUserPic = \DB::select('SELECT * FROM TB_UsersPics WHERE usersPics_dlDate IS NULL AND fk_users_id = ?', [$id]);

        if(isset($actualUserPic)) {
            if (!empty($actualUserPic[0])) {
                try {
                    \DB::update('UPDATE `TB_UsersPics` SET `usersPics_dlDate` = NOW() WHERE `TB_UsersPics`.`usersPics_id` = ?', [$actualUserPic[0]->usersPics_id]);
                } catch (\PDOException $e) {
                    \Log::error($e->getMessage());
                    abort(403, lang::get('errors.uknError'));
                }
            }else{
                abort(404, lang::get('auth.noContentToDelete'));
            }
        }else{
            abort(404, lang::get('auth.noContentToDelete'));
        }

        $GetFileName = explode('/', $actualUserPic[0]->usersPics_path);
        if(file_exists($actualPath.'/'.$GetFileName[5])){
            rename($actualPath.'/'.$GetFileName[5], $newPath.'/'.$GetFileName[5]);
        }else{
            \Log::error('Trying to move an non existent picture');
            abort(404, lang::get('errors.uknError'));
        }
        return $this->response->array([
            'status_code' => 200,
            'message' => lang::get('auth.remPicSuccess')
        ]);
    }

    /**
     * Adresse
     */
    public function getUserAdresses($id){
        $this->checkTokenFromId($id);
        $adresses = \DB::select('SELECT * FROM TB_Adresses WHERE fk_users_id = ? AND  adresses_dlDate IS NULL', [$id]);
        return $adresses;
    }
    public function addAdresse(Request $request, $id){
        $this->checkTokenFromId($id);
        $input =$request->all();

        if(empty($input['adresses_street'])OR empty($input['adresses_state'])OR empty($input['adresses_npa'])OR empty($input['adresses_locality'])){
            \Log::error('missing argument for adding adresse | user: '.$id);
            abort(403, lang::get('auth.missingArgument'));
        }
        $validator = $this->validator($request->all());
        if($validator->fails()){
            \Log::error('missing argument for adding adresse | user: '.$id);
            abort(403, $validator->errors());
        }
        if(isset($input['adresses_main'])){
            $main =1;
            $mainAdresse = \DB::select('SELECT adresses_id FROM TB_Adresses WHERE adresses_main = 1 AND fk_users_id = ?', [$id]);
            foreach($mainAdresse as $value){
                \DB::update('UPDATE `TB_Adresses` SET `adresses_main` = 0 WHERE `TB_Adresses`.`adresses_id` = ?', [$value->adresses_id]);
            }
        }else $main =0;

        try {
            \DB::table('TB_Adresses')->insert([
                ['adresses_street' => $input['adresses_street'],'adresses_state' => $input['adresses_state'], 'adresses_npa' => $input['adresses_npa'], 'adresses_locality'=>$input['adresses_locality'], 'adresses_main'=>$main, 'fk_users_id'=>$id]
            ]);
        }
        catch (\PDOException $e) {
            \Log::error($e->getMessage());
            abort(403, lang::get('errors.uknError'));
        }
        return $this->response->array([
            'status_code' => 200,
            'message' => lang::get('auth.addadresseSuccess')
        ]);

    }
    public function remAdresse($id, $addrID){
        $this->checkTokenFromId($id);

        if(empty($addrID)){
            \Log::error('missing adresses_id for delete adresse | user: '.$id);
            abort(403, lang::get('auth.missingArgument'));
        }else if(!is_numeric($addrID)){
            \Log::error('id not numeric for delete adresse | user: '.$id);
            abort(403, lang::get('errors.charNotAuthorized'));
        }
        $getAdresse = \DB::select('SELECT * FROM TB_Adresses WHERE adresses_id = ? AND fk_users_id = ? AND adresses_dlDate IS NULL', [$addrID, $id]);
        if(empty($getAdresse[0])){
            \Log::error('trying to edit a not authorized adresse: '.$addrID.' | user: '.$id);
            abort(403, lang::get('errors.notAuthorized'));
        }
        try {
            \DB::update('UPDATE `TB_Adresses` SET `adresses_dlDate` = NOW() WHERE `adresses_id` = ? AND fk_users_id = ?', [$addrID, $id]);
        }
        catch (\PDOException $e) {
            \Log::error($e->getMessage());
            abort(403, lang::get('errors.uknError'));
        }
        return $this->response->array([
            'status_code' => 200,
            'message' => lang::get('auth.remAdressSuccess')
        ]);


    }
    public function editAdresse(Request $request, $id, $addrID){
        $this->checkTokenFromId($id);
        $input =$request->all();



        $getAdresse = \DB::select('SELECT * FROM TB_Adresses WHERE adresses_id = ? AND fk_users_id = ? AND adresses_dlDate IS NULL', [$addrID, $id]);
        if(empty($getAdresse[0])){
            \Log::error('trying to edit a not authorized adresse: '.$addrID.' | user: '.$id);
            abort(403, lang::get('errors.notAuthorized'));
        }
        if(empty($input['adresses_street'])AND empty($input['adresses_npa'])AND empty($input['adresses_locality'])AND empty($input['adresses_main'])){
            \Log::error('missing argument for editing adresse | user: '.$id);
            abort(403, lang::get('auth.missingArgument'));
        }else{
            $validator = $this->validator($request->all());
            if($validator->fails()){
                \Log::error('missing argument for editing adresse | user: '.$id);
                abort(403, $validator->errors());
            }
            if(!empty($input['adresses_state'])){
                $state = $input['adresses_state'];
            }else{
                $state = $getAdresse[0]->adresses_state;
            }
            if(!empty($input['adresses_street'])){
                $street = $input['adresses_street'];
            }else{
                $street = $getAdresse[0]->adresses_street;
            }
            if(!empty($input['adresses_npa'])){
                $npa = $input['adresses_npa'];
            }else{
                $npa = $getAdresse[0]->adresses_npa;
            }
            if(!empty($input['adresses_locality'])){
                $locality = $input['adresses_locality'];
            }else{
                $locality = $getAdresse[0]->adresses_locality;
            }
        }
        if(isset($input['adresses_main'])){
            $main =1;
            $mainAdresse = \DB::select('SELECT adresses_id FROM TB_Adresses WHERE adresses_main = 1 AND fk_users_id = ?', [$id]);
            $array=array();
            foreach($mainAdresse as $value){
                \DB::update('UPDATE `TB_Adresses` SET `adresses_main` = 0 WHERE `TB_Adresses`.`adresses_id` = ?', [$value->adresses_id]);
            }
        }else{
            $mainAdresse = \DB::select('SELECT adresses_main FROM TB_Adresses WHERE fk_users_id = ? AND adresses_id = ?', [$id, $addrID]);
            if(isset($mainAdresse)){
                if($mainAdresse[0]->adresses_main==1) {
                    $main = 1;
                }else $main=0;
            }else $main =0;

        }
        try {
            \DB::table('TB_Adresses')->where([['adresses_id', '=', $addrID],['fk_users_id', '=', $id]])->update(
                ['adresses_street' => $street, 'adresses_state' => $state, 'adresses_npa' => $npa, 'adresses_locality'=>$locality, 'adresses_main'=>$main, 'fk_users_id'=>$id]
            );
        }
        catch (\PDOException $e) {
            \Log::error($e->getMessage());
            abort(403, lang::get('errors.uknError'));
        }
        return $this->response->array([
            'status_code' => 200,
            'message' => lang::get('auth.updateAdressSuccess')
        ]);
    }

    /**
     * Internal job
     */
    protected function validator(array $data)
    {

        return Validator::make($data, [
            'adresses_street' => 'regex:/(^[A-Za-z0-9âàéèïäç\'.üö\- ]+$)+/|max:255',
            'adresses_state' => 'regex:/(^[A-Za-zâàéèïäçüö\- ]+$)+/|max:40',
            'adresses_locality' => 'regex:/(^[A-Za-zâàéèïäçüö\- ]+$)+/|max:40',
            'adresses_npa' => 'regex:/(^[0-9 ]+$)+/|max:4'
        ]);
    }

}
