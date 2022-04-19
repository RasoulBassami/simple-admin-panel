<?php

namespace App\Repositories;

use App\Image;
use App\Post;

interface ImageRepositoryInterface
{
    public function postImages(Post $post);

    public function store(Post $post, $data);

    public function update(Image $image, $data);

    public function delete(Image $image);
}
