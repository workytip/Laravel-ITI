<?php

namespace App\Http\Controllers;

use App\Jobs\PruneOldPostsJob;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Rules\Postsnumber;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{

    public function index(Request $request)
    {

        // PruneOldPostsJob::dispatch();
        
        $posts = Post::select("*")->paginate(5);

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
    'title'=>['required','unique:posts','min:3','max:50'],
    'description'=>['required','min:10'],
    'post_creator'=>['exists:users,id',new Postsnumber],
    'image' => 'image|mimes:png,jpg|max:4048',

        ]);
        if ($image = request()->file('image')) {

         $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
         $path = request()->file('image')->storeAs('public/images',$profileImage);
         request()->image = "$profileImage";

        }
        $Post =new Post();
        //insert data
        $data = request()->all();
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

    ################# Update ###################

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

            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $path = request()->file('image')->storeAs('public/images',$profileImage);
   
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

    ####################### End Update #####################

    public function destroy($postId)
    {
        $post=Post::find($postId);
        
        if(isset($post->image))
        {
            Storage::delete('public/images/' . $post->image);

        }
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
