<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\PostService;
use App\Models\Tag;
use App\Services\RssFeed;
use App\Services\SiteMap;

class BlogController extends Controller
{
    public function index($page=1, Request $request)
    {
        $tag = $request->get('tag');
        $postService = new PostService($page, $tag);
        $data = $postService->postLists();
        //var_dump($data);exit;
        //$layout = $tag ? Tag::layout($tag) : 'blog.layouts.index';
        //return view($layout, $data);
        return $data;
    }

    public function post($slug, Request $request)
    {
        $post = Post::with('tags')->where('slug', $slug)->firstOrFail();
        $tag = $request->get('tag');
        if ($tag) {
            $tag = Tag::where('tag', $tag)->firstOrFail();
        }
        //var_dump($post->toArray());exit;
        return $post->toArray();
    }

    public function rss(RssFeed $feed)
    {
        $rss = $feed->getRSS();

        return response($rss)
            ->header('Content-type', 'application/rss+xml');
    }

    public function siteMap(SiteMap $siteMap)
    {
        $map = $siteMap->getSiteMap();

        return response($map)
            ->header('Content-type', 'text/xml');
    }
}
