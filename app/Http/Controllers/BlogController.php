<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\User;

class BlogController extends Controller
{
    public function store(Request $request)
    {
        // get name of authenticated user
        $user = Auth::user();
        $username = $user->name;


        $validate_data = $request->validate([
            'blog_title' => 'required|string|max:255',
            'blog_description' => 'required|string'
        ]);

        $validate_data['user_id'] = $user->id;
        $blog = Blog::create($validate_data);

        return response()->json([
            'username' => $username,
            'blog_title' => $blog->blog_title,
            'blog_description' => $blog->blog_description,
            'success' => true
        ]);
    }

    public function display()
    {
        $blogs = Blog::with('user')->get();

        return view('dashboard', ['blogs' => $blogs]);
    }
}
