<?php
namespace App\Http\Controllers\Api\V1\Mail;

use App\Mail\Registration;
use Illuminate\Support\Facades\Mail;
use \App\Http\Controllers\Api\V1\Controller;
Use Illuminate\Support\Facades\Auth;
Use Lang;


class MailController extends Controller
{
    public static function sendRegistration($users_fsname, $users_name, $users_login, $users_email)
    {

        $objDemo = new \stdClass();

        $objDemo->urlToProfile = 'https://coatandclothes.shop/#/user';
        $objDemo->urlToProducts='https://coatandclothes.shop/#/';

        $objDemo->fsname=$users_fsname;

        $objDemo->name=$users_name;
        $objDemo->email=$users_email;
        $objDemo->login=$users_login;

        $products = \DB::select('SELECT * FROM `TB_Products` prod LEFT JOIN `TB_ProductsPics` pic ON pic.`fk_products_id` = prod.products_id WHERE prod.products_dlDate IS NULL AND pic.productsPics_id IS NOT NULL GROUP BY prod.products_id order by `prod`.`products_crDate` DESC limit 2 ');


        $objDemo->product1=self::getTranslation($products[0]->products_name);

        $objDemo->product1_id=$products[0]->products_id;
        $objDemo->product1_url=$products[0]->productsPics_path ;

        $objDemo->product2=self::getTranslation($products[1]->products_name);
        $objDemo->product2_id=$products[1]->products_id;
        $objDemo->product2_url=$products[1]->productsPics_path ;

        $objDemo->sender='CoatNClothes';
        $objDemo->receiver = $users_fsname.' '.$users_name;

        $array['html'] = 'mails.lang.'.\App::getLocale().'.registration';
        $array['plain']='mails.lang.'.\App::getLocale().'.registration_plain';
        $array['subject']= lang::get('mail.registration');
        Mail::to($users_email)->queue(new Registration($objDemo, $array));

        return true;
    }
}