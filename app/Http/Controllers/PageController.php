<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $pages = Page::all();

        return view('Admin.page',compact('pages'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'unique:pages,name',
            'route' => 'required',
        ]);
        Page::create([
            'name' => $request['name'],
            'route' => $request['route'],
        ]);
        return redirect()->back()->with('notification','New page is created successfully!');
    }

    public function update(Request $request, Page $id)
    {
        $id->update([
            'name' => $request['update_name'],
            'route' => $request['update_route'],
        ]);
        return redirect()->back()->with('notification','page is updated successfully!');
    }
}
