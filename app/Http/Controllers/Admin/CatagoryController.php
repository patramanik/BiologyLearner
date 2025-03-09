<?php

namespace App\Http\Controllers\Admin;


use App\Models\Catagory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Requests\Admin\CategoryFormRequest;
use App\Models\Post;

class CatagoryController extends Controller
{
    public function index()
    {
        $catagorys = Catagory::all();
        $c_data = compact('catagorys');
        return view('admin.category.category')->with($c_data);
    }

    public function create()
    {
        return view('admin.category.addcategory');
    }

    public function store(CategoryFormRequest $request)
    {
        $data = $request->validated();

        $category = new Catagory;
        $category->name = $data['name'];
        $category->mata_title = $data['mataTile'];


        if ($request->hasFile('image')) // Corrected the method name to hasFile
        {
            $file = $request->file('image'); // Corrected the variable name from $data to $request
            $filename = time() . '.' . $file->getClientOriginalExtension(); // Used getClientOriginalExtension() method
            $file->move('uploads/category/', $filename);
            $url = asset('uploads/category/' . $filename);
            $category->image = $url;
        }

        $category->meta_description = $data['description'];
        $category->c_keywords = $data['keywords'];
        $category->created_by = Auth::user()->id;
        // dd($category);
        $category->save();

        return redirect('admin/category')->with('message', 'Category added Successfully');
    }

    public function edit($id)
    {
        $category = Catagory::find($id);
        // dd($category);
        return view('admin.category.edit', compact('category'));
    }

    public function update(CategoryFormRequest $request, $id)
    {

        $data = $request->validated();

        $category = Catagory::find($id);
        $category->name = $data['name'];
        $category->mata_title = $data['mataTile'];


        if ($request->hasFile('image')) {
            // Delete old image if exists
            $oldImage = $category->image;
            if ($oldImage) {
                $path = public_path(str_replace(asset('/'), '', $oldImage)); // Convert URL to local path
                if (File::exists($path)) {
                    File::delete($path);
                }
            }

            // Upload new image
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/category/', $filename);
            $category->image = asset('uploads/category/' . $filename);
        } else {
            // Keep old image if no new one is uploaded
            $category->image = $request->old_image;
        }
        // dd($category);  

        $category->meta_description = $data['description'];
        $category->c_keywords = $data['keywords'];
        $category->created_by = Auth::user()->id;
        $category->save();

        return redirect('admin/category')->with('message', 'Category update Successfully');
    }

    public function destroy($id)
    {
        $category = Catagory::find($id);
        if ($category) {
            $url = $category->image;
            $path = pathinfo($url, PATHINFO_BASENAME);
            $imgLocation = 'uploads/category/' . $path;
            if (File::exists($imgLocation)) {
                File::delete($imgLocation);
            }
            $category->delete();
            return redirect('admin/category')->with('message', 'Category deleted Successfully');
        } else {
            return redirect('admin/category')->with('message', ' No Category id Found.');
        }
    }

    public function approval()
    {
        $catagorys = Catagory::where('status', '0')->get();
        $approval = Catagory::where('status', '1')->get();
        return view('admin.category.category-publish', compact('catagorys', 'approval'));
    }

    public function publish($id)
    {
        $catagory = Catagory::find($id);

        $catagory->status = 1;
        $catagory->update();

        return redirect()->back()->with('message', 'Category now Public on your App');
    }

    public function hide($id)
    {
        $catagory = Catagory::find($id);

        $catagory->status = 0;
        $catagory->update();

        return redirect()->back()->with('message', 'Category now Hide on your App');
    }
    public function DeleteCategory($id)
    {
        $categoryInUse = Post::where('category_id', $id)->exists();

        if ($categoryInUse) {
            if (request()->ajax()) {
                return response()->json(['error' => 'Cannot delete category. Posts exist under this category.'], 400);
            }
            return redirect()->back()->with('error', 'Cannot delete category. Posts exist under this category.');
        }

        $catagory = Catagory::find($id);

        $catagory->delete();

        if (request()->ajax()) {
            return response()->json(['message' => 'Category Deleted Successfully']);
        }
        return redirect()->back()->with('message', 'Category Deleted Successfully');
    }
}
