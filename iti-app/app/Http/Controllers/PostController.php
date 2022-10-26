<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{

    public function index(Request $request)
    {

        $posts = Post::select("*")->paginate(5);
        // $posts->created_at= $posts->created_at->toDateString();

        if ($request->has('view_deleted')) 
        {
            $posts = Post::onlyTrashed()->paginate(5);

        }
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
        $post = Post::find($postId);
        return view('posts.show',['post' => $post]);
    }

    public function store()
    {
        request()->validate([
            'title'=>['required','unique:posts','min:3'],
            'description'=>['required','min:10'],
            'post_creator'=>['exists:posts,user_id'],
            'image' => 'required|image|mimes:png,jpg|max:2048',

        ]);
        if ($image = request()->file('image')) {

            $destinationPath = 'images/';

            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();

            $image->move($destinationPath, $profileImage);

            request()->image = "$profileImage";

        }
        $Post =new Post();
        //insert data
        $data = request()->all();
        $user=User::find($data['post_creator']);
            $Post->create([
                'title' => request()->title,
                'description' => $data['description'],
                'user_id' => $data['post_creator'],
                'image'=>request()->image
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
        if(request()->title == $post->title )
        {
            request()->validate([
                'title'=>['required','min:3'],
                'description'=>['required','min:10'],
                'post_creator'=>['exists:posts,user_id']
    
            ]);
        }
        else{
            request()->validate([
                'title'=>['required','unique:posts','min:3'],
                'description'=>['required','min:10'],
                'post_creator'=>['exists:posts,user_id']
            ]);
        }

        if ($image = request()->file('image')) {

            $destinationPath = 'images/';

            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();

            $image->move($destinationPath, $profileImage);

            request()->image = "$profileImage";
            if ($post->image) {
                Storage::delete('public/images/' . $post->image);
              }

        }
        else
        {
            request()->image =$post->image ;
        }
            $post->title = request()->title;
            $post->description = request()->description;
            $post->user_id = request()->post_creator;
            $post->image  =request()->image;
            $post->save();

        return to_route('posts.index');
    }


    public function delete($postId)
    {
        $post=Post::find($postId);
        Storage::delete('public/images/'.$post->image);
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
