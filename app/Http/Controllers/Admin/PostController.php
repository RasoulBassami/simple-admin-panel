<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\PostRepositoryInterface;

class PostController extends Controller
{
    protected $postRepository;
    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = $this->postRepository->getAllPostsWithQueryString();

        $paginated = $this->postRepository->paginatePosts($posts);

        return view('admin.posts.all', ['posts' => $paginated]);
    }

}
