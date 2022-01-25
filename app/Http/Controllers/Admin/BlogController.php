<?php

namespace App\Http\Controllers\Admin;

use App\Blog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
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
        $blogs = Blog::orderBy('id','desc')->get();
        $active = Blog::where('status',1)->get()->count();
        return view('admin.blog',compact('blogs','active'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'blog_title' => 'required|max:500',
            'blog_category' => 'required|max:100',
            'blog_description' => 'required',
            'blog_serial'=>'nullable|numeric',
            'blog_image' => 'required|mimes:png,jpg,jpeg|max:5000',
        ]);

        $file = $request['blog_image'];
        $ext = strtolower($file->getClientOriginalExtension());
        $file_full_name = 'blog-' . date('YmdHis') . '.' . $ext;
        $file->storeAs('blog_image', $file_full_name, 'public');

        Blog::firstOrCreate([
            'title' => $request->blog_title,
            'category' => $request->blog_category,
            'description' => $request->blog_description,
            'serial' => $request->blog_serial,
            'image' => $file_full_name,
            'admin_id' => $request->insert_by,
        ]);
        return redirect()->back()->with('notification','New blog is added successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'update_blog_title' => 'required|max:500',
            'update_blog_category' => 'required|max:100',
            'update_blog_description' => 'required',
            'update_blog_serial'=>'nullable|numeric',
            'update_status' => 'required',
            'update_blog_image' => 'nullable|mimes:png,jpg,jpeg|max:5000',
        ]);

        $blog = Blog::find($id);
        $file_full_name = $blog->image;

        if(isset($request['update_blog_image']))
        {
            Storage::delete('/public/blog_image/'.$file_full_name);

            $file = $request['update_blog_image'];
            $ext = strtolower($file->getClientOriginalExtension());
            $file_full_name = 'blog-' . date('YmdHis') . '.' . $ext;
            $file->storeAs('blog_image', $file_full_name, 'public');
        }

        $blog->update([
            'title' => $request->update_blog_title,
            'category' => $request->update_blog_category,
            'description' => $request->update_blog_description,
            'serial' => $request->update_blog_serial,
            'status' => $request->update_status,
            'image' => $file_full_name,
            'admin_id' => $request->update_by,
        ]);
        return redirect()->back()->with('notification','Blog is updated successfully!');
    }

    public function delete($id)
    {
        try {
            $blog = Blog::find($id);
            Storage::delete('/public/blog_image/'.$blog['image']);
            $blog->delete();
            return redirect()->back()->with('notification','Blog is deleted successfully!');
        }
        catch(\Illuminate\Database\QueryException $e)
        {
            return redirect()->back()->with('notification','Blog is not deleted!');
        }
    }
}
