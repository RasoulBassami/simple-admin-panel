<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\UpdateImageRequest;
use App\Image;
use App\Post;
use App\Repositories\ImageRepositoryInterface;
use App\Utilities\ImageUploader;
use Illuminate\Support\Facades\File;

class ImageController extends Controller
{
    protected $imageRepository;
    public function __construct(ImageRepositoryInterface $imageRepository)
    {
        $this->imageRepository = $imageRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Post $post)
    {
        $images = $this->imageRepository->postImages($post);

        return view('posts.images.all', ['post' => $post, 'images' => $images]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Post $post)
    {
        return view('posts.images.create', ['post' => $post]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Post $post, StoreImageRequest $request)
    {
        if ($request->file('images')) {

            $destination_path = '/images/posts/' . $post->id . '/';

            $images_paths = ImageUploader::uploadMany($destination_path, $request->file('images'));

            for ($i = 0; $i < sizeof($images_paths); $i++) {
                $this->imageRepository->store($post, [
                    'image' => $images_paths[$i],
                    'alt' => $request->images[$i]['alt']
                ]);
            }
        }
        return redirect(route('posts.images.index', ['post' => $post->id]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post, Image $image)
    {
        return view('posts.images.edit', ['post' => $post, 'image' => $image]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateImageRequest $request, Post $post, Image $image)
    {
        $data['alt'] = $request['alt'];

        if($request->file('image')) {
            $destination_path = '/images/posts/' . $post->id . '/';
            $data['image'] = ImageUploader::update($destination_path, $image, $request->file('image'));
        }

        $this->imageRepository->update($image, $data);

        $images = $this->imageRepository->postImages($post);

        return view('posts.images.all', compact('post', 'images'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post, Image $image)
    {
        ImageUploader::delete($image);

        $this->imageRepository->delete($image);
        $images = $this->imageRepository->postImages($post);
//        return view('posts.images.all', ['post' => $post, 'images' => $images]);
        return back();
    }
}
