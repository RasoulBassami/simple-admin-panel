<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Post;
use App\Repositories\PostRepositoryInterface;
use App\Utilities\ImageUploader;
use Illuminate\Support\Facades\Gate;

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

        $filtered = $this->postRepository->filterThroughTheGate('view', $posts);

        $paginated = $this->postRepository->paginatePosts($filtered);

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

        $post = $this->postRepository->create($request->all());

        if ($request->file('images')) {

            $destination_path = '/images/posts/' . $post->id . '/';

            $uploaded_images = ImageUploader::uploadMany($destination_path, $request->file('images'));

            $this->postRepository->saveImages($post, $uploaded_images);
        }

        alert()->success('پست موردنظر با موفقیت ایجاد شد.', 'تبریک')->persistent('بسیار خب');
        return redirect(route('posts.index'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        if(Gate::denies('update', $post)) {
            return view('dashboard')->withErrors('شما به این بخش دسترسی ندارید!');
        }

        if(Gate::denies('update', $post)) {
            return view('dashboard')->withErrors('شما به این بخش دسترسی ندارید!');
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
            return view('dashboard')->withErrors('شما به این بخش دسترسی ندارید!');
        }

        $request['is_active'] = $request->has('active') ? 1 : 0;

        $this->postRepository->update($post, $request->all());

        if ($request->deletingImages[0]){
            $deleting_ids = explode(',', $request->deletingImages[0]);
            $this->postRepository->removeImages($post, $deleting_ids);
        }

        if ($request->file('images')) {

            $destination_path = '/images/posts/' . $post->id . '/';

            $uploaded_images = ImageUploader::uploadMany($destination_path, $request->file('images'));

            $this->postRepository->saveImages($post, $uploaded_images);
        }

        alert()->success('پست موردنظر با موفقیت ویرایش شد.', 'تبریک')->persistent('بسیار خب');
        return redirect(route('posts.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if(Gate::denies('delete', $post)) {
            return view('dashboard')->withErrors('شما به این بخش دسترسی ندارید!');
        }

        $this->postRepository->delete($post);
        alert()->success('پست موردنظر با موفقیت حذف شد.', 'تبریک')->persistent('بسیار خب');
        return back();
    }
}
