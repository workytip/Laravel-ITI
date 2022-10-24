<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;

class PostController extends Controller
{

    public function index(Request $request)
    {

        $posts = Post::select("*")->paginate(5);
        // $posts->created_at= $posts->created_at->toDateString();

        if ($request->has('view_deleted')) 
        {

            $posts = $posts->onlyTrashed();

        }
        // $posts = $posts->paginate(5);

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

        // $post = Post::where('id', $postId)->first();
        return view('posts.show',['post' => $post]);
    }

    public function store()
    {
        //insert data
        $data = request()->all();
        $Post =new Post();
        $Post->create([
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
        return to_route('posts.index');
    }


    public function delete($postId)
    {
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

    //////////// for comment section
    public function storeComment($id)
    {
        //insert data
        Comment::create([
            'body' => request()->body,
            'commentable_type' => Post::class,
            'commentable_id' => $id,

        ]); 
        return redirect(route('posts.show',$id));

    }
    
    public function DeleteComment($Id)
    {
       
        $comment=Comment::find($Id);
        $comment->delete();
        return redirect(route('posts.show',$comment->commentable_id));
    }


    public function EditComment($Id)
    {
        $comment=Comment::find($Id);
        return redirect(route('posts.show',$comment->commentable_id));


    }

    public function UpdateComment($Id)
    {
        $comment=Comment::find($Id);
        $comment->body = request()->body;
        $comment->save();
        return redirect(route('posts.show',$comment->commentable_id));
    }


}
