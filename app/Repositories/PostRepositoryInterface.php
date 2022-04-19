<?php

namespace App\Repositories;

interface PostRepositoryInterface
{
    public function getAllPostsWithQueryString();

    public function filterThroughTheGate(string $ability, $posts);

    public function create($data);

    public function update($post, $data);

    public function delete($post);
}
