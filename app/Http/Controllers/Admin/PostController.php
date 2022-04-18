<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\PaginationHelper;
use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Post::query();

        if ($keyword = request('search')) {
            $query = $query->where(function ($q) use ($keyword){
                $q->where('title', 'LIKE', "%{$keyword}%")
                    ->orWhere('id', 'LIKE', "%{$keyword}%");
            });
        }
        if (request('active')) {
            $query = $query->where(function ($q){
                $q->where('is_active', 1);
            });
        }

        $posts = $query->latest()->paginate(10);

        return view('admin.posts.all', ['posts' => $posts]);
    }

}
