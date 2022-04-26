<?php
namespace App\Repositories\Eloquent;
use App\Helpers\PaginationHelper;
use \App\Post;
use App\Repositories\PostRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param Post $model
     */
    public function __construct(Post $model)
    {
        parent::__construct($model);
    }

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
        $query = $this->model->query();

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

    public function paginatePosts($posts, $perPage = 10)
    {
        return PaginationHelper::paginate($posts, $perPage);
    }

    public function create($data)
    {
        return auth()->user()->posts()->create($data);
    }

    public function saveImages($post, $images)
    {
        foreach ($images as $image) {
            $post->images()->create($image);
        }
    }

    public function removeImages($post, $images)
    {
        foreach ($images as $image) {
            $post->images()->find($image)->forceDelete($image);
        }
        $post->touch();
    }

    public function update($post, $data)
    {
        $post->update($data);
    }

    public function delete($post)
    {
        $deleted_title = $post->title . '_deleted_' . $post->id;
        $post->update([
            'title' => $deleted_title
        ]);
        $post->delete($post);
    }
}
