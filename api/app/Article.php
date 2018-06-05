<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'posts';
    public $timestamps = TRUE;
    protected $fillable = [
        'id',
        'user_id',
        "title",
        'content',
        "excerpt",
    ];


}
