<?php

use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
Route::delete('posts/{id}', [PostController::class, 'delete'])->name('posts.delete');
Route::get('posts/restore/one/{id}', [PostController::class, 'restore'])->name('posts.restore');
Route::get('restoreAll', [PostController::class, 'restoreAll'])->name('posts.restore.all');

// comments routing
Route::post('comment/{id}',[PostController::class,'storeComment'])->name('comment.store');
Route::delete('comment/{id}',[PostController::class,'DeleteComment'])->name('comment.delete');


Route::resource('posts',PostController::class);

Auth::routes();


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
