<?php

namespace App\Http\Controllers;

use App\Helpers\PaginationHelper;
use App\Post;
use Illuminate\Http\Request;
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

//        $posts = $query->latest()->paginate(10);
//        return view('posts.all', compact('posts'));

        $posts = $query->latest()->get();
        $filtered = $posts->filter(function ($post) {
            if(Gate::allows('view-post', $post)){
                return $post;
            }
        });
        $paginated = PaginationHelper::paginate($filtered, 10);
        return view('posts.all', ['posts' => $paginated]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Gate::denies('update-post', $post)) {
            return view('home')->withErrors('You cannot do that');
        } else {
            return view('post/edit')->with('post', $post);
        }
//        @can('update-post', $post)
//        <a href="{{ action('PostsController@edit', [$post->id]) }}">Edit</a>
//    @endcan

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
