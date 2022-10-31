<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function edit($userId)
    {
        $user=User::find($userId);

        return view('auth.edit',['user'=>$user]);
    }
    public function update($userId)
    {

        $user=User::find($userId);
       
        if(request()->email == $user->email ){
            request()->validate([
                'name'=>['required','min:3'],
                'email'=>['required','email'],
                'password'=>['required','min:8']
            ]);
        }
        else{
            request()->validate([
                'name'=>['required','min:3'],
                'email'=>['required','unique:users,email','email'],
                'password'=>['required','min:8']
            ]);
        }
        
        // request()->validate([
        //     'name'=>['required','min:3'],
        //     'email'=>['required','unique:users,email,'.$userId,'email'],
        //     'password'=>['required','min:8']
        // ]);
        

        // if ($image = request()->file('image')) {

        //     $destinationPath = 'images/';

        //     $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();

        //     $image->move($destinationPath, $profileImage);

        //     request()->image = "$profileImage";
        //     if ($post->image) {
        //         Storage::delete('public/images/' . $post->image);
        //       }

        // }
        // else
        // {
        //     request()->image =$post->image ;
        // }
            $user->name = request()->name;
            $user->email = request()->email;
            $user->password = request()->password;
            // $user->image  =request()->image;
            $user->save();

        return to_route('posts.index');
    }
}
