<?php
namespace App\Repositories;
use App\Helpers\PaginationHelper;
use App\Image;
use \App\Post;
use Illuminate\Support\Facades\Gate;

class ImageRepository implements ImageRepositoryInterface
{
    public function postImages(Post $post, $perPage = 20)
    {
        return $post->images()->latest()->paginate($perPage);
    }

    public function store(Post $post, $data)
    {
        $post->images()->create($data);
    }

    public function update(Image $image, $data)
    {
        $image->update($data);
    }

    public function delete(Image $image)
    {
        $image->forceDelete();
    }
}
