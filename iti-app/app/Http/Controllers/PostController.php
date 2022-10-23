<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Collection;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;

class PostController extends Controller
{

    public function index(Request $request)
    {

        $posts = Post::select("*");

        if ($request->has('view_deleted')) {

            $posts = $posts->onlyTrashed();

        }
        $posts = $posts->paginate(10);
        return view('posts.index', compact('posts'));

    }

    public function create()
    {
        $allUsers = User::all();

        return view('posts.create',[
            'allUsers' => $allUsers
        ]);
    }

    public function show($postId)
    {
        //select * from posts where id  = $postId
        $post = Post::find($postId);
        $user = User::find($post->user_id);
        // $post = Post::where('id', $postId)->first();

        return view('posts.show',['post' => $post ,'user'=>$user]);
    }

    public function store()
    {
        //insert data
        $data = request()->all();
        Post::create([
            'title' => request()->title,
            'description' => $data['description'],
            'user_id' => $data['post_creator'],
        ]); 

        return to_route('posts.index');
    }

    public function edit($postId)
    {
        $post=Post::find($postId);
        $allUsers = User::all();

        return view('posts.edit',['post'=>$post ,'allUsers' => $allUsers]);
    }

    public function update($postId)
    {
        $post =Post::find($postId);

        $post->title = request()->title;
        $post->description = request()->description;
        $post->user_id = request()->post_creator;

        $post->save();
        return back();
    }

    // public function destroy($postId)
    // {
    //     $post=Post::find($postId);
    //     $post->delete();
    //     return back();
    // }
    public function delete($postId)
    {
        // dd(request()->all());
        $post=Post::find($postId);
        $post->delete();
        return back();
    }

    public function restore($id)

    {

        Post::withTrashed()->find($id)->restore();
        return back();

    }  
    public function restoreAll()

    {

        Post::onlyTrashed()->restore();
        return back();

    }

}
