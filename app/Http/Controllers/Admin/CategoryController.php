<?php

namespace App\Http\Controllers\Admin;

use App\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = Category::orderBy('id','desc')->get();
        $active = Category::where('status',1)->get()->count();
        return view('admin.category',compact('categories','active'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|unique:categories,name|max:50',
            'category_serial'=>'nullable|numeric',
            'category_image' => 'required|mimes:svg|max:5000',
        ]);

        $file = $request['category_image'];
        $ext = strtolower($file->getClientOriginalExtension());
        $file_full_name = 'category-' . date('YmdHis') . '.' . $ext;
        $file->storeAs('category_image', $file_full_name, 'public');

        Category::firstOrCreate([
            'name' => $request->category_name,
            'serial' => $request->category_serial,
            'image' => $file_full_name,
            'admin_id' => $request->insert_by,
        ]);
        return redirect()->back()->with('notification','New category is added successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'update_category_name' => 'required|max:50|unique:categories,name,'.$id.',id',
            'update_category_serial'=>'nullable|numeric',
            'update_status'=>'required',
            'update_category_image' => 'mimes:svg|max:5000',
        ]);

        $cat = Category::find($id);
        $file_full_name = $cat->image;

        if(isset($request['update_category_image']))
        {
            Storage::delete('/public/category_image/'.$file_full_name);

            $file = $request['update_category_image'];
            $ext = strtolower($file->getClientOriginalExtension());
            $file_full_name = 'category-' . date('YmdHis') . '.' . $ext;
            $file->storeAs('category_image', $file_full_name, 'public');
        }

        $cat->update([
            'name' => $request->update_category_name,
            'serial' => $request->update_category_serial,
            'status' => $request->update_status,
            'image' => $file_full_name,
            'admin_id' => $request->update_by,
        ]);
        return redirect()->back()->with('notification','Category is updated successfully!');
    }

    public function delete($id)
    {
        try {
            $cate = Category::find($id);
            Storage::delete('/public/category_image/'.$cate['image']);
            $cate->delete();
            return redirect()->back()->with('notification','Category is deleted successfully!');
        }
        catch(\Illuminate\Database\QueryException $e)
        {
            return redirect()->back()->with('notification','Category is not deleted!');
        }
    }
}
