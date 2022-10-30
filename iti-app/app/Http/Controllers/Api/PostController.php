<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class PostController extends Controller
{
    //
    public function index(){
        // $post= Post::all();
        $post = Post::with('user')->paginate(5);// eager
        return  PostResource::collection($post);



    }

    public function show($id){
        $post= Post::find($id);
        return new PostResource($post);

    }

    public function store(StorePostRequest $request)
    {
        $validated = $request->validated();

        $post =Post::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'user_id' => $validated['post_creator'],
        ]); 

        return new PostResource($post);
    }
     
}
