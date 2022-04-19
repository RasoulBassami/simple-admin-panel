<?php
namespace App\Repositories;
use \App\Post;
use Illuminate\Support\Facades\Gate;

class PostRepository implements PostRepositoryInterface
{
    public function searchQuery($query, string $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('title', 'LIKE', "%{$keyword}%")
                ->orWhere('id', 'LIKE', "%{$keyword}%");
        });
    }

    public function activeQuery($query)
    {
        return $query->where(function ($q){
            $q->where('is_active', 1);
        });
    }

    public function getAllPostsWithQueryString()
    {
        $query = Post::query();

        if ($keyword = request('search')) {
            $query = $this->searchQuery($query, $keyword);
        }

        if (request('active')) {
            $query = $this->activeQuery($query);
        }
        return $query->latest()->get();
    }

    public function filterThroughTheGate(string $ability, $posts)
    {
        return $posts->filter(function ($post) use ($ability) {
            if(Gate::allows( $ability, $post)){
                return $post;
            }
        });
    }

    public function create($data)
    {
        auth()->user()->posts()->create($data);
    }

    public function update($post, $data)
    {
        $post->update($data);
    }

    public function delete($post)
    {
        $post->delete($post);
    }
}
