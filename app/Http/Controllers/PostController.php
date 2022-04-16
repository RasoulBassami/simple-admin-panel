<?php

namespace App\Http\Controllers;

use App\Helpers\PaginationHelper;
use App\Http\Requests\PostRequest;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

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
     */
    public function create()
    {
        if (Gate::denies('create-post')) {
            abort(403);
        }
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255', 'unique:posts'],
            'description' => ['required','string', 'min:3', 'max:1000'],
            'body' => ['required', 'string', 'min:3'],
        ]);

        if ($request->has('active')) {
            $data['is_active'] = 1;
        }

        auth()->user()->posts()->create($data);

        alert()->success('پست موردنظر با موفقیت ایجاد شد.', 'تبریک')->persistent('بسیار خب');

        return redirect(route('posts.index'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        if(Gate::denies('update-post', $post)) {
            return view('/dashboard')->withErrors('شما به این بخش دسترسی ندارید!');
        }

        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function update(Request $request, Post $post)
    {

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255', Rule::unique('posts')->ignore($post->id)],
            'description' => ['required','string', 'min:3', 'max:1000'],
            'body' => ['required', 'string', 'min:3'],
        ]);

        $data['is_active'] = $request->has('active') ? 1 : 0;

        $post->update($data);

        alert()->success('پست موردنظر با موفقیت ویرایش شد.', 'تبریک')->persistent('بسیار خب');

        return redirect(route('posts.index'));
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
