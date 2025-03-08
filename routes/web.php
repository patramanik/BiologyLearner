<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\BlogPostController;
use App\Http\Controllers\Admin\CatagoryController;
use App\Http\Controllers\Admin\AdminDashbordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider, and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::controller(CatagoryController::class)->group(function () {});


Route::controller(CatagoryController::class)->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/category', 'index')->name('admin.category.category');
        Route::get('/addcategory', 'create')->name('admin.category.addcategory');
        Route::Post('/addcategory', 'store');
        Route::get('/edit/{id}', 'edit')->name('admin.category.edit');
        Route::put('/update/{id}', 'update');
        Route::get('/destroy/{id}', 'destroy');
        Route::get('/publisg_catagory/{id}', 'publish');
        Route::get('/publish', 'approval')->name('admin.category.category-publish');
        Route::get('/not_publisg_catagory/{id}', 'hide');
        Route::delete('/delete-category/{id}', 'DeleteCategory');
    });
})->middleware('auth');

// BlogPost
Route::controller(BlogPostController::class)->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/posts', 'show')->name('admin.blogPost.posts');
        Route::get('/addpost', 'create')->name('admin.blogPost.addPost');
        Route::post('/addpost', 'submit');
        Route::post('/upload', 'upload')->name('admin.blogPost.upload');
        Route::get('/editPost/{id}', 'edit')->name('admin.blogPost.editPost');
        Route::put('/updatepost/{id}', 'update');
        Route::get('/destroypost/{id}', 'destroy');
        Route::get('/post-publish', 'approval')->name('admin.blogPost.publish-post');
        Route::get('/publish_post/{id}', 'publish');
        Route::get('/not_publish_post/{id}', 'hide');
        Route::get('/delet_commend/{id}', 'deletCommend');
        Route::delete('/delete-post/{id}', 'DeletePost');
    });
    Route::get('/dashbord/catagory', 'catagory');
})->middleware('auth');


// Admin Routes
Route::get('dashboard', [AdminDashbordController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
