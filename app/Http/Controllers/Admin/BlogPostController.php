<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\Catagory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Requests\admin\PostFormRequest;


class BlogPostController extends Controller
{
    public function create()
    {
        $catagorys = Catagory::all();
        $c_data = compact('catagorys');
        return view('admin.blogPost.addPost')->with($c_data);
    }


    // public function postshow(){

    //     return Catagory::all();
    // }
    // public function pshow()
    // {

    //     $result = Catagory::join('Catagory', 'Catagory.id', '=', 'post.catagory_id')
    //         ->select('Catagory.name')
    //         ->get();

    //     return $result;
    // }

    public function show()
    {
        $post = Post::all();
        $catagorys = Catagory::all();
        $posts = compact('post', 'catagorys');
        // if ($catagorys->id == $post->category_id) {
        //     dd($catagorys->name);
        // }
        // dd($posts);
        return view('admin.blogPost.posts')->with($posts);
    }

    public function view()
    {
        $post = Post::all();
        $posts = compact('post');
        //  dd($post);
        return view('admin.blogPost.view')->with($posts);
    }


    public function submit(Request $request)
    {
        $data = $request->validate([
            'catagory_id'   => 'required|exists:catagoris,id',
            'post_name' => 'required|string|max:200',
            'metaTile' => 'max:200',
            'image' => 'required|mimes:jpeg,jpg,png',
            'Post_keywords' => 'max:200',
            'Post_Content' => 'required|string',
        ]);

        $post = new Post;
        $post->category_id = $data['catagory_id'];
        $post->post_name = $data['post_name'];
        $post->meta_title = $data['metaTile'];

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/post/', $filename);
            $url = asset('uploads/post/' . $filename);
            $post->image = $url;
        }

        $post->Post_keywords = $data['Post_keywords'];
        $post->post_content = $data['Post_Content'];
        $post->created_by = Auth::user()->id;
        $post->save();

        return redirect('admin/posts')->with('message', 'Post added successfully');
    }


    // public function store(Request $request){
    //     dd($request->all());
    //     return view('admin.blogPost.posts');
    // }

    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload'); // Get the uploaded file
            $filename = time() . '.' . $file->getClientOriginalExtension(); // Generate a unique filename
            $file->move('uploads/post/upload/', $filename); // Move the file to the desired directory
            $url = asset('uploads/post/upload/' . $filename); // Generate the URL for the uploaded file

            return response()->json(['fileName' => $filename, 'uploaded' => 1, 'url' => $url]);
        }
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id); // Use findOrFail to handle not found cases.
        return view('admin.blogPost.editPost', compact('post'));
    }

    public function update(Request $request, $id)
    {
        // Remove the $request->validated() and use validate() method
        $request->validate([
            'catagory_id' => 'required',
            'post_name' => 'required|string|max:200',
            'metaTile' => 'required|string|max:200',
            'image' => 'nullable|mimes:jpeg,jpg,png',
            'Post_keywords' => 'required|string',
            'Post_Content' => 'required|string',
        ]);

        $post = Post::find($id);
        $post->category_id = $request->input('catagory_id');
        $post->post_name = $request->input('post_name');
        $post->meta_title = $request->input('metaTile');

        if ($request->hasFile('image')) {
            $url = $post->image;
            $path = pathinfo($url, PATHINFO_BASENAME);
            $imgLocation = 'uploads/post/' . $path;
            if (File::exists($imgLocation)) {
                File::delete($imgLocation);
            }
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/post/', $filename);
            $url = asset('uploads/post/' . $filename);
            $post->image = $url;
        }

        $post->Post_keywords = $request->input('Post_keywords');
        $post->post_content = $request->input('Post_Content');
        $post->created_by = Auth::user()->id;
        $post->update(); // Use save() instead of update()

        return redirect('/admin/posts')->with('message', 'Post updated successfully');
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        if ($post) {
            $url = $post->image;
            $path = pathinfo($url, PATHINFO_BASENAME);
            $imgLocation = 'uploads/post/' . $path;

            if (File::exists($imgLocation)) {
                File::delete($imgLocation); // Fixed typo in variable name
            }

            $post->delete();
            return redirect('/admin/posts')->with('message', 'Post deleted Successfully'); // Updated the success message
        } else {
            return redirect('/admin/posts')->with('message', 'No Post with the given ID found'); // Updated the error message
        }
    }


    public function approval()
    {
        $post = Post::where('status', '0')->get();
        $approval = Post::where('status', '1')->get();
        return view('admin.blogPost.publish-post', compact('post', 'approval'));
    }

    public function publish($id)
    {
        $post = Post::find($id);

        $post->status = 1;
        $post->update();

        return redirect()->back()->with('message', 'Now Post is Public on your App');
    }

    public function hide($id)
    {
        $post = Post::find($id);

        $post->status = 0;
        $post->update();

        return redirect()->back()->with('message', 'Now post is Hide on your App');
    }
    public function DeletePost($id)
    {
        $post = Post::find($id);
        if($post){
            $url = $post->image;
            $path = pathinfo($url, PATHINFO_BASENAME);
            $imgLocation = 'uploads/post/' . $path;

            if (File::exists($imgLocation)) {
                File::delete($imgLocation);
            }
        $post->delete();

        if (request()->ajax()) {
            return response()->json(['message' => 'Post Deleted Successfully']);
        }
        return redirect()->back()->with('message', 'Post Deleted Successfully');
    }
    }
}