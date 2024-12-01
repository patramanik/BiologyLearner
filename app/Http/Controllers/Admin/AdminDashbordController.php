<?php

namespace App\Http\Controllers\admin;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Catagory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminDashbordController extends Controller
{
    public function index(){
        $catagorys = Catagory::count();
        $posts = Post::count();
        $commend = Comment::all();
        $catagoryStatus = Catagory::where('status','0')->count();
        $postStatus = post::where('status','0')->count();
        return view('dashboard',compact('catagorys','posts','commend','catagoryStatus','postStatus'));
    }

    public function deletCommend($id){
        $commend = Comment::find($id);

        if($commend)
        {
            $commend->delete();
            return redirect('dashboard')->with('message','Commend deleted Successfully');
        }else{
            return redirect('dashboard')->with('message','Commend is not Found.');
        }
    }
}
