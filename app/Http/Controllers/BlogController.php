<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\User;
use App\Models\Likes;

class BlogController extends Controller
{
    public function store(Request $request)
    {
        try {
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

            // date of creation
            $created_today = $blog->created_at->isToday();
            $created_yesterday = $blog->created_at->isYesterday();
            $created_minutes_ago = floor($blog->created_at->diffInMinutes());
            $created_hours_ago = floor($blog->created_at->diffInHours());
            $created_days_ago = $blog->created_at->format('l');
            $created_long_ago = $blog->created_at->format('l, F, d, Y');


            return response()->json([
                'is_private' => $blog->is_private,
                'username' => $username,
                'blog_title' => $blog->blog_title,
                'blog_description' => $blog->blog_description,
                'created_at' => $blog->created_at,
                'created_minutes_ago' => $created_minutes_ago,
                'created_hours_ago' => $created_hours_ago,
                'created_days_ago' => $created_days_ago,
                'created_today' => $created_today,
                'created_yesterday' => $created_yesterday,
                'created_long_ago' => $created_long_ago,
                'success' => true
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation error occured',
                'errors' => $e->errors(),
                'success' => false,
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occured: ' . $e->getMessage(),
                'success' => false,
            ], 500);
        }
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
            ->orderBy('created_at', 'desc')
            ->get();
        return view('blog-profile', ['blogs' => $blogs]);
    }

    public function allPost()
    {
        $blogs = Blog::with('user')
            ->where('is_private', false)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('blog-posts', ['blogs' => $blogs]);
    }


    public function update(Request $request, $id)
    {

        $validate_data = $request->validate([
            'blog_title' => 'required|string|max:255',
            'blog_description' => 'required|string|max:255'
        ]);

        $blog = Blog::findOrFail($id);

        $blog->blog_title = $validate_data['blog_title'];
        $blog->blog_description = $validate_data['blog_description'];

        $blog->save();

        return response()->json([
            'message' => 'Update Succesful',
            'success' => true
        ]);
    }

    public function delete($id)
    {

        $blog = Blog::find($id);

        $blog->delete();
    }
}
