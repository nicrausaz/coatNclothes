<?php
/**
 * Created by PhpStorm.
 * User: mbrugger
 * Date: 03.05.2018
 * Time: 01:18
 */

namespace App\Http\Controllers\Api\V1;
use App\Services\Feed\FeedBuilder;


class feedController extends Controller
{
    private $builder;

    public function __construct(FeedBuilder $builder)
    {
        $this->builder = $builder;
    }

    //We're making atom default type
    public function getFeed($type='atom')
    {
        if ($type === "rss" || $type === "atom") {
            return $this->builder->render($type);
        }

    }
}