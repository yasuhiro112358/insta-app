<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\CategoriesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    // Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Suggested Users
    Route::get('/suggested-users', [HomeController::class, 'suggestedUsers'])
        ->name('suggested-users');

    Route::get('/post/create', [PostController::class, 'create'])
        ->name('post.create');

    Route::post('/post/store', [PostController::class, 'store'])
        ->name('post.store');
    Route::get('/post/{id}/show', [PostController::class, 'show'])
        ->name('post.show');
    Route::get('/post/{id}/edit', [PostController::class, 'edit'])
        ->name('post.edit');
    Route::patch('/post/{id}/update', [PostController::class, 'update'])
        ->name('post.update');
    Route::delete('/post/{id}/destroy', [PostController::class, 'destroy'])
        ->name('post.destroy');

    // comments
    Route::post('/comment/{post_id}/store', [CommentController::class, 'store'])
        ->name('comment.store');
    Route::delete('/comment/{post_id}/destroy', [CommentController::class, 'destroy'])
        ->name('comment.destroy');

    // Profiles
    Route::patch('/profile/update', [ProfileController::class, 'update'])
        ->name('profile.update');
    // あとで->where()の追加
    Route::get('/profile/{id}/show', [ProfileController::class, 'show'])
        ->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::get('/profile/{id}/followers', [ProfileController::class, 'followers'])
        ->name('profile.followers');
    Route::get('/profile/{id}/following', [ProfileController::class, 'following'])
        ->name('profile.following');
    Route::patch('/profile/update-password', [ProfileController::class, 'updatePassword'])
        ->name('profile.updatePassword');

    // Like
    Route::post('/like/{post_id}/store', [LikeController::class, 'store'])
        ->name('like.store');
    Route::delete('/like/{post_id}/destroy', [LikeController::class, 'destroy'])
        ->name('like.destroy');

    // Follows
    Route::post('/follow/{user_id}/store', [FollowController::class, 'store'])
        ->name('follow.store');
    Route::delete('/follow/{user_id}/destroy', [FollowController::class, 'destroy'])
        ->name('follow.destroy');

    // Admin
    Route::group(['middleware' => 'admin'], function () {
        // Users
        Route::get('/admin/users', [UsersController::class, 'index'])
            ->name('admin.users');
        Route::delete('/admin/users/{id}/deactivate', [UsersController::class, 'deactivate'])
            ->name('admin.users.deactivate');
        Route::patch('/admin/users/{id}/activate', [UsersController::class, 'activate'])
            ->name('admin.users.activate');

        // Posts
        Route::get('/admin/posts', [PostsController::class, 'index'])
            ->name('admin.posts');
        Route::delete('/admin/posts/{id}/deactivate', [PostsController::class, 'deactivate'])
            ->name('admin.posts.deactivate');
        Route::patch('/admin/posts/{id}/activate', [PostsController::class, 'activate'])
            ->name('admin.posts.activate');

        // Categories
        Route::get('/admin/categories', [CategoriesController::class, 'index'])
            ->name('admin.categories');
        Route::post('/admin/categories/store', [CategoriesController::class, 'store'])
            ->name('admin.categories.store');
        Route::delete('/admin/categories/{id}/destroy', [CategoriesController::class, 'destroy'])
            ->name('admin.categories.destroy');
        Route::patch('/admin/categories/{id}/update', [CategoriesController::class, 'update'])
            ->name('admin.categories.update');
    });
});
