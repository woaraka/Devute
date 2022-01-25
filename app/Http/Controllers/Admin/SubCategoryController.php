<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Division;
use App\Http\Controllers\Controller;
use App\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubCategoryController extends Controller
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
        $sub_cates = SubCategory::all();
        $active = SubCategory::where('status',1)->get()->count();
        $divisions = Division::all();
        return view('admin.sub_category',compact('categories','sub_cates', 'divisions','active'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required',
            'sub_category_name'=>'required',
            'reviewtic_id' => 'required|unique:sub_categories,reviewtic_id|max:50',
            'address'=>'required',
            'division' => 'required',
            'district'=>'required',
            'thana' => 'required',
            'post_office'=>'required',
            'post_code'=>'required',
            'latitude'=>'required',
            'longitude'=>'required',
            'description'=>'required',
            'website'=>'nullable|url',
            'email'=>'nullable|email',
            'phone'=>'nullable',
            'facebook'=>'nullable|url',
            'instagram'=>'nullable|url',
            'twitter'=>'nullable|url',
            'google_plus'=>'nullable|url',
            'category_serial'=>'nullable|numeric',
            'logo' => 'required|mimes:png,jpg,jpeg|max:5000',
        ]);

        $file = $request['logo'];
        $ext = strtolower($file->getClientOriginalExtension());
        $file_full_name = 'sub_category-' . date('YmdHis') . '.' . $ext;
        $file->storeAs('sub-category_image', $file_full_name, 'public');

        SubCategory::firstOrCreate([
            'category_id' => $request->category,
            'name' => $request->sub_category_name,
            'reviewtic_id' => $request->reviewtic_id,
            'address' => $request->address,
            'division_id' => $request->division,
            'district_id' => $request->district,
            'upazila_id' => $request->thana,
            'post_office' => $request->post_office,
            'post_code' => $request->post_code,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'description' => $request->description,
            'website' => $request->website,
            'email' => $request->email,
            'phone' => $request->phone,
            'facebook' => $request->facebook,
            'instagram' => $request->instagram,
            'twitter' => $request->twitter,
            'google_plus' => $request->google_plus,
            'serial' => $request->category_serial,
            'logo' => $file_full_name,
            'admin_id' => $request->insert_by,
        ]);
        return redirect()->back()->with('notification','New Sub-Category is added successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'update_category' => 'required',
            'update_sub_category_name'=>'required',
            'update_reviewtic_id' => 'required|max:50|unique:sub_categories,reviewtic_id,'.$id.',id',
            'update_address'=>'required',
            'update_division' => 'required',
            'update_district'=>'required',
            'update_thana' => 'required',
            'update_post_office'=>'required',
            'update_post_code'=>'required',
            'update_latitude'=>'required',
            'update_longitude'=>'required',
            'update_description'=>'required',
            'update_website'=>'nullable|url',
            'update_email'=>'nullable|email',
            'update_phone'=>'nullable',
            'update_facebook'=>'nullable|url',
            'update_instagram'=>'nullable|url',
            'update_twitter'=>'nullable|url',
            'update_google_plus'=>'nullable|url',
            'update_category_serial'=>'nullable|numeric',
            'update_status'=>'required',
            'update_logo' => 'nullable|mimes:png,jpg,jpeg|max:5000',
        ]);

        $cat = SubCategory::find($id);
        $file_full_name = $cat->logo;

        if(isset($request['update_logo']))
        {
            Storage::delete('/public/sub-category_image/'.$file_full_name);

            $file = $request['update_logo'];
            $ext = strtolower($file->getClientOriginalExtension());
            $file_full_name = 'sub_category-' . date('YmdHis') . '.' . $ext;
            $file->storeAs('sub-category_image', $file_full_name, 'public');
        }

        $cat->update([
            'category_id' => $request->update_category,
            'name' => $request->update_sub_category_name,
            'reviewtic_id' => $request->update_reviewtic_id,
            'address' => $request->update_address,
            'division_id' => $request->update_division,
            'district_id' => $request->update_district,
            'upazila_id' => $request->update_thana,
            'post_office' => $request->update_post_office,
            'post_code' => $request->update_post_code,
            'latitude' => $request->update_latitude,
            'longitude' => $request->update_longitude,
            'description' => $request->update_description,
            'website' => $request->update_website,
            'email' => $request->update_email,
            'phone' => $request->update_phone,
            'facebook' => $request->update_facebook,
            'instagram' => $request->update_instagram,
            'twitter' => $request->update_twitter,
            'google_plus' => $request->update_google_plus,
            'serial' => $request->update_category_serial,
            'status' => $request->update_status,
            'logo' => $file_full_name,
            'admin_id' => $request->update_by,
        ]);
        return redirect()->back()->with('notification','Sub-Category is updated successfully!');
    }

    public function delete($id)
    {
        try {
            $cate = SubCategory::find($id);
            Storage::delete('/public/sub-category_image/'.$cate['image']);
            $cate->delete();
            return redirect()->back()->with('notification','Sub category is deleted successfully!');
        }
        catch(\Illuminate\Database\QueryException $e)
        {
            return redirect()->back()->with('notification','Sub category is not deleted!');
        }
    }
}
