<?php
namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
public function transform($array) : array
{
return [
    'id'=>$array->id,
    'name'=>$array->name
];
}
}

