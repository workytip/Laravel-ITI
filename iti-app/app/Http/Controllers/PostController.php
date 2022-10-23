<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;

class PostController extends Controller
{
    public function index()
    {
        //write query to get the data from posts table
        //one user has many posts
        //one post belongs to user
        $allPosts = Post::all();//SELECT * from posts
        // dd($allPosts); //collection object that contains small objects of Post model class
        // $allPosts = [
        //     ['id' => 1 , 'title' => 'laravel is cool', 'posted_by' => 'Ahmed', 'creation_date' => '2022-10-22'],
        //     ['id' => 2 , 'title' => 'PHP deep dive', 'posted_by' => 'Mohamed', 'creation_date' => '2022-10-15'],
        // ];

        return view('posts.index', [
          'posts' => $allPosts
        ]);
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
        $arr = [
            ['id' => 1 , 'category' => 'test']
        ];
        // dd($arr);
        //select * from posts where id  = $postId
        $post = Post::find($postId);
        // $post = Post::where('id', $postId)->first();

        //select * from posts where title = 'laravel' limit 1;
        //Post::where('title', 'Laravel For Beginners')->first()
        // $posts = Post::where('title', 'Laravel For Beginners')->get();

        return 'we are in show now';
    }

    public function store()
    {
        //here we will put the logic to store in db

        //- create the db (Done)
        //- create the needed tables (Done)
        //- make connection to the db (Done)
        //- write query to store the data in db (Done)
        //- modify input names in the create.blade.php
        //- close the connection of db (Done)
        //- redirection to the index page

        // $data = $_POST;
        $data = request()->all();

        // request()->title
        // request()->description
        // request()->post_creator
        // dd($data, request()->title, request()->post_creator);

        Post::create([
            'title' => request()->title,
            'description' => $data['description'],
            'user_id' => $data['post_creator'],
        ]); //insert into posts ('ahmed','asdasd')

        return to_route('posts.index');
    }
}
