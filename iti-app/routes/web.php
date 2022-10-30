<?php

use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('posts', [PostController::class, 'index'])->name('posts.index');
// Route::get('posts/create',[PostController::class, 'create'])->name('posts.create');
// Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
// Route::post('/posts', [PostController::class, 'store'])->name('posts.store');


// Route::get('test',function(){
//     $user = User::find(1);

//     dd($user->posts);
// });
// delete and restore routing
// Route::delete('posts/{id}', [PostController::class, 'delete'])->name('posts.delete');
Route::get('posts/restore/one/{id}', [PostController::class, 'restore'])->name('posts.restore');
Route::get('restoreAll', [PostController::class, 'restoreAll'])->name('posts.restore.all');

// comments routing
Route::post('comment/{id}',[PostController::class,'storeComment'])->name('comment.store');
Route::delete('comment/{id}',[PostController::class,'DeleteComment'])->name('comment.delete');
Route::get('comment/{id}/edit',[PostController::class,'EditComment'])->name('comment.edit');
Route::put('comment/{id}',[PostController::class,'UpdateComment'])->name('comment.update');


Route::resource('posts',PostController::class)->middleware('auth');

Auth::routes();


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/profile/{id}/edit', [App\Http\Controllers\HomeController::class, 'edit'])->name('profile.edit');
Route::put('/profile/{id}', [App\Http\Controllers\HomeController::class, 'update'])->name('profile.update');



################ SOCIALITE ROUTING ##################

 
Route::get('/auth/redirect/github', function () {
    return Socialite::driver('github')->redirect();
})->name('auth.github');
 
Route::get('/auth/callback/github', function () {
    // $user = Socialite::driver('github')->user();
    

    $githubUser = Socialite::driver('github')->user();
    //  dd($githubUser);

    $user = User::where('email', $githubUser->email)->first();
    if($user) {
        $user->update([
            'name' => $githubUser->nickname,
        ]);
    } else {
        $user = User::create([
            'email' => $githubUser->email,
            'name' => $githubUser->nickname,
        ]);
    }
 
    // $user = User::updateOrCreate(
    //     [
    //     'github_id' => $githubUser->id|1,
    //     ], 
    //      [
    //     'name' => $githubUser->nickname,
    //     'email' => $githubUser->email,
    //     // 'github_token' => $githubUser->token,
    //     // 'github_refresh_token' => $githubUser->refreshToken,
    //  ]);
 
    Auth::login($user);
    return redirect('posts');
 
    // $user->token
});

######################## Google Routes ############
Route::get('/auth/redirect/google', function () {
    return Socialite::driver('google')->redirect();
})->name('auth.google');
 
Route::get('/auth/callback/google', function () {
    // $user = Socialite::driver('github')->user();
    

    $googleUser = Socialite::driver('google')->user();
    //   dd($googleUser);

    $user = User::where('email', $googleUser->email)->first();
    if($user) {
        $user->update([
            'name' => $googleUser->name,
        ]);
    } else {
        $user = User::create([
            'email' => $googleUser->email,
            'name' => $googleUser->name,
        ]);
    }

 
    Auth::login($user);
    return redirect('posts');
 
});