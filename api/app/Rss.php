<?php
/**
 * Created by PhpStorm.
 * User: mbrugger
 * Date: 03.05.2018
 * Time: 01:11
 */

namespace App;

use Illuminate\Database\Eloquent\Model;


class Rss extends Model
{
    protected $table = 'TB_Products';
    public $timestamps = TRUE;
    protected $fillable = [
        'products_id',
        'products_name',
        "products_description",
        'products_price',
    ];

}