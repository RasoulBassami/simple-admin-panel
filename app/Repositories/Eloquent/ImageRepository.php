<?php
namespace App\Repositories\Eloquent;
use App\Image;
use \App\Post;
use App\Repositories\ImageRepositoryInterface;

class ImageRepository extends BaseRepository implements ImageRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param Post $model
     */
    public function __construct(Image $model)
    {
        parent::__construct($model);
    }


    public function postImages(Post $post, $perPage = 20)
    {
        return $post->images()->latest()->paginate($perPage);
    }

    public function store(Post $post, $data)
    {
        $post->images()->create($data);
    }

    public function createMany(Post $post, $images)
    {
        foreach ($images as $image) {
            $this->store($post, $image);
        }
    }

    public function update(Image $image, $data)
    {
        $image->update($data);
    }

    public function delete(Image $image)
    {
        $image->forceDelete();
    }

    public function removeImages($post, $images)
    {
        foreach ($images as $image) {
            $post->images()->find($image)->forceDelete($image);
        }
        $post->touch();
    }
}
