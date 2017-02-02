<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Response;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::paginate(3);

        if ($request->ajax()) {
            return Response::json($posts, 200);
        }

        return view('blog.index', compact('posts'));
    }
}
