<?php

namespace App\Http\Controllers;

use App\Helpers\Discord;
use App\Helpers\InvisionAPI;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;

class HomePageController extends Controller
{
    protected $forumInstance;

    public function __construct()
    {
        $this->forumInstance = InvisionAPI::getInstance();
    }

    /**
     * Displays our home page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $threads = collect($this->forumInstance->findLatestTopics(config('forum.HOMEPAGE_BOARD'), config('forum.HOMEPAGE_TOPIC_LIMIT')))
            ->map(function ($thread) {
                $thread['firstPost'] = $this->forumInstance->findPosts($thread['tid'])[0];
                $thread['post_body_unmodified'] = $thread['firstPost']['post'];
                $thread['post_body'] = preg_replace("/<iframe[^>]+\>+<\/iframe>/i", "", $thread['post_body_unmodified']);
                $thread['post_body'] = preg_replace("/<img[^>]+\>/i", "", $thread['post_body']);
                $thread['post_body'] = preg_replace("/<br \/>/i", "", $thread['post_body']);
                $thread['seo_name'] = Str::slug($thread['firstPost']['author_name']);
                return $thread;
            });
        $discord = new Discord(config('homepage.discordID'));
        $discord->fetch();
        return view('homepage.index', [
            'threads' => $threads,
            'discordCount' => $discord->getMemberCount(),
        ]);
    }
}