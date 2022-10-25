<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;


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
        request()->validate([
            'title'=>['required','unique:posts','min:3'],
            'description'=>['required','min:10'],

        ]);
        $Post =new Post();
        //insert data
        $data = request()->all();
        $user=User::find($data['post_creator']);
        if($user){
            $Post->create([
                'title' => request()->title,
                'description' => $data['description'],
                'user_id' => $data['post_creator'],
            ]); 
    
        }
        else{
            return redirect()->back()->withErrors('user not exists!');
        }

        
        
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
        $user=User::find(request()->post_creator);

        $post =Post::find($postId);
       
        if(request()->title == $post->title )
        {
            request()->validate([
                'title'=>['required','min:3'],
                'description'=>['required','min:10'],
    
            ]);
        }
        else{
            request()->validate([
                'title'=>['required','unique:posts','min:3'],
                'description'=>['required','min:10'],
    
            ]);
        }
        
        if($user)
        {
            $post->title = request()->title;
            $post->description = request()->description;
            $post->user_id = request()->post_creator;
            $post->save();
        }
        else
        {
            return redirect()->back()->withErrors('user not exists!');

        }
       
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
