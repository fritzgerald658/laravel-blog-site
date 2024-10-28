<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;

class TestController extends Controller
{
    public function getData()
    {
        // $blog = Blog::where('id', '1')->value('is_private');
        $blog_descriptions = Blog::pluck("blog_description", "blog_title");
        return view('test', ['blog_descriptions' => $blog_descriptions]);
    }
}
