<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

// store blog
Route::post('/dashboard/store', [BlogController::class, 'store'])->name('blog.store');
Route::get('/dashboard', [BlogController::class, 'display'])->name('blog.dashboard');

// go to my profile
Route::get('/dashboard/profile', [BlogController::class, 'myProfile'])->name('blog.profile');

// see all post
Route::get('/dashboard/blog-posts', [BlogController::class, 'allPost'])->name('blog.post');

// udpate your post
Route::put('/dashboard/profile/update/{id}', [BlogController::class, 'update'])->name('blog.update');

Route::delete('/dashboard/profile/delete/{id}', [BlogController::class, 'delete'])->name('blog.delete');

// like post
Route::post('/dashboard/blog-posts/like/', [BlogController::class, 'like'])->name('blog.like');


Route::get('/dashboard/profile/filter/', [BlogController::class, 'filterByPrivacy'])->name('blog.filter');

//test
Route::get('/test', [TestController::class, 'getData'])->name('test');
