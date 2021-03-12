<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostTagsController;

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

// Route::get('/', function () {
//     return view('posts.index');
// });

Auth::routes();

//  Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/myPost',[PostController::class,'myPost'])->name('posts.myPost');
Route::get('/',[PostController::class,'index'])->name('posts.index');
Route::get('/archive',[PostController::class,'archive'])->name('archive');
Route::get('/all',[PostController::class,'all'])->name('all');
Route::get('/search/{tab}/',[PostController::class,'search'])->name('search');
// secreted the route authorize
Route::get('/secret',[HomeController::class,'secret'])
    ->name('secret')
    ->middleware('can:secret.page');

Route::get('/restore/{id}',[PostController::class,'restore'])->name('restore');
Route::delete('/forcedelete/{id}',[PostController::class,'forcedelete'])->name('forcedelete');
// Route::resource('/archive',PostController::class)->name('archive','archive');

Route::resource('posts', PostController::class)->except('index');
Route::resource('posts.comments', PostCommentController::class)->only(['store','show']);

Route::get('tags.index/{id}',[PostTagsController::class,'index'])->name('tags');

Route::resource('comments',CommentController::class);
Route::resource('users', UserController::class)->only(['edit','show','update']);
