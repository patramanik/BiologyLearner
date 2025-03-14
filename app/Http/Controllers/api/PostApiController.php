<?php

namespace App\Http\Controllers\api;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostApiController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::orderBy('id', 'desc')->paginate($request->get('per_page', 20));
        
        return response()->json([
            'status' => true,
            'message' => 'Paginated Post List',
            'data' => $posts
        ]);
    }
}
