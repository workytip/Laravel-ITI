<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $allPosts = [
            ['id' => 1 , 'title' => 'laravel is cool', 'posted_by' => 'Ahmed', 'creation_date' => '2022-10-22'],
            ['id' => 2 , 'title' => 'PHP deep dive', 'posted_by' => 'Mohamed', 'creation_date' => '2022-10-15'],
        ];

        return view('posts.index', [
          'posts' => $allPosts
        ]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function show($postId)
    {
        $arr = [
            ['id' => 1 , 'category' => 'test']
        ];
        // dd($arr);

        return 'we are in show now';
    }

    public function store()
    {
        dd('we are storing the data');
    }


    public function edit($id)
    {
        $id = 1;
        return view('posts.edit', ['id'=>$id]);
    }

    public function update($id)
    {
        //dd('we are updating the data');
        return redirect('posts')->with('success', 'post updated.');
    }

    public function delete($id)
    {
        //dd('we are deleting the data');
        return redirect('posts')->with('success', 'post deleted.');
        
    }
}
