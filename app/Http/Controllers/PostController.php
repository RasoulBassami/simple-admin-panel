<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Post;
use App\Services\PostService;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = $this->postService->getAllPostsWithQueryString();

        $filtered = $this->postService->filterThroughTheGate('view', $posts);

        $paginated = $this->postService->paginatePosts($filtered);

        return view('posts.all', ['posts' => $paginated]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Post::class);
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(StorePostRequest $request)
    {
        if ($request->has('active')) {
            $request['is_active'] = 1;
        }

        $this->postService->storePost($request);

        alert()->success('پست موردنظر با موفقیت ایجاد شد.', 'تبریک')->persistent('بسیار خب');
        return redirect(route('posts.index'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        if(Gate::denies('update', $post)) {
            return view('dashboard')->withError('شما به این بخش دسترسی ندارید!');
        }

        $images = $post->images;
        return view('posts.edit', ['post' => $post, 'images' => $images]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        if(Gate::denies('update', $post)) {
            return view('dashboard')->withError('شما به این بخش دسترسی ندارید!');
        }

        $request['is_active'] = $request->has('active') ? 1 : 0;

        $this->postService->updatePost($request, $post);

        alert()->success('پست موردنظر با موفقیت ویرایش شد.', 'تبریک')->persistent('بسیار خب');
        return redirect(route('posts.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if(Gate::denies('delete', $post)) {
            return view('dashboard')->withError('شما به این بخش دسترسی ندارید!');
        }

        $this->postService->removePost($post);

        alert()->success('پست موردنظر با موفقیت حذف شد.', 'تبریک')->persistent('بسیار خب');
        return back();
    }
}
