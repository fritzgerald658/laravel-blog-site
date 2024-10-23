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
            'blog_description' => 'required|string',
            'is_private' => 'boolean'
        ]);

        $validate_data['user_id'] = $user->id;
        $validate_data['is_private'] = $request->input('is_private', false);
        $blog = Blog::create($validate_data);

        return response()->json([
            'is_private' => $blog->is_private,
            'username' => $username,
            'blog_title' => $blog->blog_title,
            'blog_description' => $blog->blog_description,
            'created_at' => $blog->created_at,
            'success' => true
        ]);
    }

    public function display()
    {
        $blogs = Blog::with('user')
            ->where('is_private', false)
            ->orWhere('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard', ['blogs' => $blogs]);
    }

    public function myProfile()
    {
        $blogs = Blog::with('user')
            ->where('user_id', Auth::id())
            ->get();

        return view('blog-profile', ['blogs' => $blogs]);
    }
}
