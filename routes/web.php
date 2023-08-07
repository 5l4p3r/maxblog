<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/create_blog',[HomeController::class,'CreateBlog']);
Route::post('/create_blog',[BlogController::class,'CreateBlog']);
Route::get('/edit_blog',[BlogController::class,'EditBlog']);
Route::post('/edit_blog',[BlogController::class,'PostEditBlog']);
Route::get('/delete_blog',[BlogController::class,'DeleteBlog']);
Route::get('/delete_comment',[CommentController::class,'DeleteComment']);
Route::get('/blog',[BlogController::class,'Blog']);
Route::post('/add_comment',[CommentController::class,'CreateComment']);

