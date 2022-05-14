<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
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

        $this->authorize('viewAny', Post::class);

        $paginated = $this->postService->paginatePosts($posts);

        return view('admin.posts.all', ['posts' => $paginated]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        if(Gate::denies('update', $post)) {
            alert()->error('شما دسترسی لازم برای ویرایش این پست را ندارید!', 'خطای دسترسی')->persistent('بسیار خب');
            return redirect(route('admin.dashboard'));
        }

        $images = $post->images;
        return view('admin.posts.edit', ['post' => $post, 'images' => $images]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        if(Gate::denies('update', $post)) {
            alert()->error('شما دسترسی لازم برای ویرایش این پست را ندارید!', 'خطای دسترسی')->persistent('بسیار خب');
            return redirect(route('admin.dashboard'));
        }

        $request['is_active'] = $request->has('active') ? 1 : 0;

        $this->postService->updatePost($request, $post);

        alert()->success('پست موردنظر با موفقیت ویرایش شد.', 'تبریک')->persistent('بسیار خب');
        return redirect(route('admin.posts.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if(Gate::denies('delete', $post)) {
            alert()->error('شما دسترسی لازم برای حذف این پست را ندارید!', 'خطای دسترسی')->persistent('بسیار خب');
            return redirect(route('admin.dashboard'));
        }

        $this->postService->removePost($post);

        alert()->success('پست موردنظر با موفقیت حذف شد.', 'تبریک')->persistent('بسیار خب');
        return back();
    }
}
