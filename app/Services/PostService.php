<?php
namespace App\Services;

use App\Models\Post;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator as Paginator;
//use Illuminate\Pagination\LengthAwarePaginator as Paginator;


class PostService
{
    protected $tag;
    protected $page;
    protected $pageSize;

    /**
     * 控制器
     *
     * @param string|null $tag
     */
    public function __construct($page, $tag)
    {
        $this->tag = $tag;
        $this->page = $page;
        $this->pageSize = config('blog.posts_per_page');
    }

    public function lists()
    {
        if ($this->tag) {
            return $this->tagIndexData($this->tag);
        }
        return $this->normalIndexData();
    }

    public function postLists()
    {
        if ($this->tag) {
            return $this->tagDataList($this->tag);
        }
        return $this->normalDataList();
    }

    /**
     * Return data for normal index page
     *
     * @return array
     */
    protected function normalDataList()
    {

        $posts = Post::with('tags')
            ->where('published_at', '<=', Carbon::now())
            ->where('is_draft', 0)
            ->orderBy('published_at', 'desc')
            //->simplePaginate(config('blog.posts_per_page'));
            ->offset(($this->page-1) * $this->pageSize)
            ->limit($this->pageSize)
            ->get();
        $posts = new Paginator($posts, $this->pageSize, $this->page);

        return [
            'title' => config('blog.title'),
            'subtitle' => config('blog.subtitle'),
            'posts' => $posts,
            'page_image' => config('blog.page_image'),
            'meta_description' => config('blog.description'),
            'reverse_direction' => false,
            'tag' => null,
        ];
    }

    /**
     * Return data for normal index page
     *
     * @return array
     */
    protected function normalIndexData()
    {
        $posts = Post::with('tags')
            ->where('published_at', '<=', Carbon::now())
            ->where('is_draft', 0)
            ->orderBy('published_at', 'desc')
            ->simplePaginate(config('blog.posts_per_page'));

        return [
            'title' => config('blog.title'),
            'subtitle' => config('blog.subtitle'),
            'posts' => $posts,
            'page_image' => config('blog.page_image'),
            'meta_description' => config('blog.description'),
            'reverse_direction' => false,
            'tag' => null,
        ];
    }

    /**
     * Return data for a tag index page
     *
     * @param string $tag
     * @return array
     */
    protected function tagDataList($tag)
    {
        $tag = Tag::where('tag', $tag)->firstOrFail();
        $reverse_direction = (bool)$tag->reverse_direction;

        $posts = Post::where('published_at', '<=', Carbon::now())
            ->whereHas('tags', function ($q) use ($tag) {
                $q->where('tag', '=', $tag->tag);
            })
            ->where('is_draft', 0)
            ->orderBy('published_at', $reverse_direction ? 'asc' : 'desc')
            ->simplePaginate(config('blog.posts_per_page'));
        $posts->appends('tag', $tag->tag);

        $page_image = $tag->page_image ? : config('blog.page_image');

        return [
            'title' => $tag->title,
            'subtitle' => $tag->subtitle,
            'posts' => $posts,
            'page_image' => $page_image,
            'tag' => $tag,
            'reverse_direction' => $reverse_direction,
            'meta_description' => $tag->meta_description ?: config('blog.description'),
        ];
    }

    /**
     * Return data for a tag index page
     *
     * @param string $tag
     * @return array
     */
    protected function tagIndexData($tag)
    {
        $tag = Tag::where('tag', $tag)->firstOrFail();
        $reverse_direction = (bool)$tag->reverse_direction;

        $posts = Post::where('published_at', '<=', Carbon::now())
            ->whereHas('tags', function ($q) use ($tag) {
                $q->where('tag', '=', $tag->tag);
            })
            ->where('is_draft', 0)
            ->orderBy('published_at', $reverse_direction ? 'asc' : 'desc')
            ->simplePaginate(config('blog.posts_per_page'));
        $posts->appends('tag', $tag->tag);

        $page_image = $tag->page_image ? : config('blog.page_image');

        return [
            'title' => $tag->title,
            'subtitle' => $tag->subtitle,
            'posts' => $posts,
            'page_image' => $page_image,
            'tag' => $tag,
            'reverse_direction' => $reverse_direction,
            'meta_description' => $tag->meta_description ?: config('blog.description'),
        ];
    }
}