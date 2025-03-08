<?php

namespace App\Http\Controllers\api;

use App\Models\Post;
use App\Models\Catagory;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;


class ApiController extends Controller
{
    public function index() {
        $data = DB::table('post')
            ->join('catagoris', 'post.category_id', '=', 'catagoris.id')
            ->where('catagoris.status', '=', 1)
            ->where('post.status', '=', 1)
            ->select(
                'post.id',
                'post.category_id',
                'catagoris.name',
                'post.post_name',
                'post.meta_title',
                'post.image',
                'post.Post_keywords',
                'post.post_content'
            )
            ->orderBy('post.id', 'desc') // Order by post.id in descending order
            ->get();

        return response()->json(['data' => $data], 200);
    }

    public function getPosts() {
        $data = DB::table('post')
            ->join('catagoris', 'post.category_id', '=', 'catagoris.id')
            ->where('catagoris.status', '=', 1)
            ->where('post.status', '=', 1)
            ->select(
                'post.id',
                'post.category_id',
                'catagoris.name',
                'post.post_name',
                'post.meta_title',
                'post.image',
                'post.Post_keywords',
                'post.post_content'
            )
            ->orderBy('post.id')
            ->get();

        return response()->json(['data' => $data], 200);
    }


    public function postData($category_id)
    {
        $posts = Post::where('status', '=', 1)
            ->where('category_id', '=', $category_id)
            ->select(
                'id',
                'category_id',
                'post_name',
                'meta_title',
                'image',
                'Post_keywords',
                'post_content'
            )
            ->get();

        if ($posts->isEmpty()) {

            return response()->json(['message' => 'No posts found for the given category.'], 404);
        }
        // $posts = $posts->orderBy('id', 'desc')->get();

        return response()->json(['Posts' => $posts], 200);
    }


    public function comment(Request $request){

       $data = $request->validate([
            'user_name' => 'required|string|max:255',
            'user_email' => 'required|string|max:255',
            'comment' => 'required|string',
        ]);

        $comment = new Comment;
        $comment->user_name = $data['user_name'];
        $comment->user_email = $data['user_email'];
        $comment->comment = $data['comment'];

        // Save the comment
        $comment->save();

        // Optionally, you can return a response
        return response()->json(
            [
            'message' => 'Comment added successfully', 'data' => $comment
            ], 201);
    }


    public function catagoryList($id=null){
        $catagorys = $id?Catagory::where('status','=',1)->select('id',
        'name',
        'mata_title',
        'image',
        'c_keywords',
        )->find($id):Catagory::where('status','=',1)->select(
            'id',
            'name',
            'mata_title',
            'image',
            // 'c_keywords',
            )->get();
        return response()->json(['catagorys' => $catagorys], 200);
        // return response()->json($catagorys, 200);
    }

    public function postList($id = null) {
        $posts = Post::where('status', '=', 1)
            ->select(
                'id',
                'category_id',
                'post_name',
                'meta_title',
                'image',
                'Post_keywords',
                'post_content',
            );

        if ($id) {
            // If $id is provided, retrieve a single post by ID
            $post = $posts->find($id);
            return response()->json(['Posts' => $post], 200);
        }

        // Retrieve all posts in descending order based on their IDs
        $posts = $posts->orderBy('id', 'desc')->get();

        return response()->json(['Posts' => $posts], 200);
    }

    public function search($name = null) {
        $result = Post::where('status', '=', 1)
        ->select(
            'id',
            'category_id',
            'meta_title',
            'post_name',
            'image',
            'post_content',
        );


        if ($name) {
            // If $name is provided, add a condition for partial match on post_name
            $result->where('post_name', 'like', '%' . $name . '%')
            ->select(
                    'id',
                    'category_id',
                    'meta_title',
                    'post_name',
                    'image',
                    'Post_keywords',
                    'post_content',
                    );
        }
        $result = $result->get();

        return response()->json(['data' => $result], 200);
    }

    // public function hedePosts($id = null) {
    //     $posts = Post::where('status', '=', 1)
    //         ->select(
    //             'id',
    //             'category_id',
    //             'post_name',
    //             'meta_title',
    //             'image',
    //             'Post_keywords',
    //             'post_content',
    //         );

    //     if ($id) {
    //         // If $id is provided, retrieve a single post by ID
    //         $post = $posts->find($id);
    //         return response()->json(['Posts' => $post], 200);
    //     }

    //     // Retrieve the most recent 5 posts in descending order based on their IDs
    //     $posts = $posts->orderBy('id', 'desc')->take(5)->get();

    //     return response()->json(['Posts' => $posts], 200);
    // }

    public function hedePosts() {
        $data = DB::table('post')
            ->join('catagoris', 'post.category_id', '=', 'catagoris.id')
            ->where('catagoris.status', '=', 1)
            ->where('post.status', '=', 1)
            ->select(
                'post.id',
                'post.category_id',
                'catagoris.name',
                'post.post_name',
                'post.meta_title',
                'post.image',
                'post.Post_keywords',
                'post.post_content'
            )
            ->orderBy('post.id', 'desc')->take(5) // Order by post.id in descending order
            ->get();

        return response()->json(['data' => $data], 200);


    }
}
