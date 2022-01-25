<?php

namespace App\Http\Controllers\Admin;

use App\District;
use App\Division;
use App\Http\Controllers\Controller;
use App\Upazila;
use Illuminate\Http\Request;

class LocationController extends Controller
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
        $divisions = Division::all();
        $districts = District::all();
        $upazillas = Upazila::all();
        return view('admin.location',compact('divisions','districts', 'upazillas'));
    }

    public function add_division(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:divisions,name|max:50',
        ]);

        Division::firstOrCreate([
            'name' => $request['name'],
        ]);

        return redirect()->back()->with('notification','New division is created successfully!');
    }

    public function update_division(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:50|unique:divisions,name,'.$id.',id',
        ]);

        Division::where('id', $id)->update([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('notification','Division name is updated successfully!');
    }

    public function add_district(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50',
        ]);

        District::firstOrCreate([
            'division_id' => $request['division'],
            'name' => $request['name'],
        ]);

        return redirect()->back()->with('notification','New district is created successfully!');
    }

    public function update_district(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:50',
        ]);

        District::where('id', $id)->update([
            'division_id' => $request->division,
            'name' => $request->name,
        ]);

        return redirect()->back()->with('notification','District is updated successfully!');
    }

    public function add_upazilla(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50',
        ]);

        Upazila::firstOrCreate([
            'district_id' => $request['district'],
            'name' => $request['name'],
        ]);

        return redirect()->back()->with('notification','New upazilla is created successfully!');
    }

    public function update_upazilla(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:50',
        ]);

        Upazila::where('id', $id)->update([
            'district_id' => $request->district,
            'name' => $request->name,
        ]);

        return redirect()->back()->with('notification','Upazilla is updated successfully!');
    }
    public function get_district(Request $request)
    {
        if($request->division_id != null)
        {
            $district = District::where('status',1)->where('division_id',$request->division_id)->orderBy('name','ASC')->get();
            /*return response()->json([
                'output' => $district
            ]);*/
            return response()->json($district);
        }
    }

    public function get_upazilla(Request $request)
    {
        if($request->district_id != null)
        {
            $upazilla = Upazila::where('status',1)->where('district_id',$request->district_id)->orderBy('name','ASC')->get();
            return response()->json($upazilla);
        }
    }
}
