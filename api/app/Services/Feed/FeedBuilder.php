<?php
/**
 * Created by PhpStorm.
 * User: mbrugger
 * Date: 03.05.2018
 * Time: 01:24
 */

namespace App\Services\Feed;
use Illuminate\Support\Facades\App;
use App\Rss;
use App\Http\Controllers\Api\V1\Controller;
use Lang;

class FeedBuilder extends Controller
{
    private $config;

    public function __construct()
    {
        $this->config = config()->get('feed');

    }

    public function render($type)
    {
        $feed = App::make("feed");
        if ($this->config['use_cache']) {
            $feed->setCache($this->config['cache_duration'], $this->config['cache_key']);
        }

        if (!$feed->isCached()) {
            $posts = $this->getFeedData();
            //print_r($posts);
            $feed->title = $this->config['feed_title'];
            $feed->description = $this->config['feed_description'];
            $feed->logo = $this->config['feed_logo'];
            $feed->link = $this->config['feed_link'];
            $feed->setDateFormat('datetime');
            $feed->lang = \App::getLocale();
            $feed->setShortening(true);
            $feed->setTextLimit(250);

            if (!empty($posts)) {
                $feed->pubdate = $posts[0]->products_crDate;
                foreach ($posts as $post) {
                    // set item's title, author, url, pubdate, description, content, enclosure (optional)*
                    $feed->add(Controller::getTranslation($post->products_name), 'CoatNClothes', 'https://coatandclothes.shop/#/product/'.$post->products_id, $post->products_crDate, Controller::getTranslation($post->products_description), lang::get('orders.price').' '.$post->products_price);
                }
            }
        }

        return $feed->render($type);
    }

    /**
     * Creating rss feed with our most recent posts.
     * The size of the feed is defined in feed.php config.
     *
     * @return mixed
     */
    private function getFeedData()
    {
        $maxSize = $this->config['max_size'];
        $posts =  Rss::all();
        return $posts;
    }
}