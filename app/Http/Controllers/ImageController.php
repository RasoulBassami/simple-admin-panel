<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\UpdateImageRequest;
use App\Image;
use App\Post;
use Illuminate\Support\Facades\File;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Post $post)
    {
        $images = $post->images()->latest()->paginate(20);
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
        $destination_path = '/images/posts/' . $post->id . '/';
        foreach ($request->file('images') as $file) {
            $upload_path = $destination_path . $file['image']->getClientOriginalName();
            $path = $file['image']->store($upload_path, ['disk' => 'public']);
            $images_paths[] = $path;
        }

        for ($i = 0; $i < sizeof($images_paths); $i++) {
            $post->images()->create([
                'image' => $images_paths[$i],
                'alt' => $request->images[$i]['alt']
            ]);
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

        if($request->file('image')){
            if(File::exists(public_path($image->image))){
                File::delete(public_path($image->image));
            }

            $destination_path = '/images/posts/' . $post->id . '/';
            $upload_path = $destination_path . $request->file('image')->getClientOriginalName();
            $path = $request->file('image')->store($upload_path, ['disk' => 'public']);

            $data['image'] = $path;
        }

        $image->update($data);

        $images = $post->images()->latest()->paginate(20);
        return view('posts.images.all', compact('post', 'images'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post, Image $image)
    {
        if(File::exists(public_path($image->image))){
            File::delete(public_path($image->image));
        }
        $image->forceDelete();
        $images = $post->images()->latest()->paginate(20);
        return view('posts.images.all', ['post' => $post, 'images' => $images]);
    }
}
