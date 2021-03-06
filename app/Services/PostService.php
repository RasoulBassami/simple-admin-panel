<?php
namespace App\Services;

use App\Models\Post;
use App\Repositories\ImageRepositoryInterface;
use App\Repositories\PostRepositoryInterface;
use App\Utilities\ImageUploader;

class PostService
{
    protected $postRepository;
    protected $imageRepository;


    public function __construct(PostRepositoryInterface $postRepository, ImageRepositoryInterface $imageRepository)
    {
        $this->postRepository = $postRepository;
        $this->imageRepository = $imageRepository;
    }

    public function getAllPostsWithQueryString()
    {
        return $this->postRepository->getAllPostsWithQueryString();
    }

    public function filterThroughTheGate(string $ability, $posts)
    {
        return $this->postRepository->filterThroughTheGate($ability, $posts);
    }

    public function paginatePosts($posts, $perPage = 10)
    {
        return $this->postRepository->paginatePosts($posts);
    }

    public function storePost($request)
    {
        $post = $this->postRepository->create($request->all());

        if ($request->file('images')) {

            $destination_path = '/images/posts/' . $post->id . '/';

            $uploaded_images = ImageUploader::uploadMany($destination_path, $request->file('images'));

            $this->imageRepository->createMany($post, $uploaded_images);
        }
    }

    public function updatePost($request, Post $post)
    {
        $this->postRepository->update($post, $request->all());

        if ($request->deletingImages[0]){
            $deleting_ids = explode(',', $request->deletingImages[0]);

            $deleting_ids = array_unique($deleting_ids);
            $results = $this->imageRepository->whereIn($deleting_ids);
            if($results->count() !== count($deleting_ids)){
                throw new \Exception("All records don't exist");
            }

            $this->imageRepository->removeImages($post, $deleting_ids);
            ImageUploader::deleteMany($results);
        }

        if ($request->file('images')) {

            $destination_path = '/images/posts/' . $post->id . '/';

            $uploaded_images = ImageUploader::uploadMany($destination_path, $request->file('images'));

            $this->imageRepository->createMany($post, $uploaded_images);
        }
    }

    public function removePost(Post $post)
    {
        return $this->postRepository->delete($post);
    }
}
