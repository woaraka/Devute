<?php

namespace App\Http\Controllers;

use App\Page;
use App\PageUser;
use App\User;
use Illuminate\Http\Request;

class PageUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = Page::all();
        $user = User::all();

        return view('Admin.page_assign',compact('page','user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee' => 'unique:page_users,user_id',
            'PageSelect' => 'required',
        ]);

        foreach ($request->PageSelect as $select)
        {
            PageUser::create([
                'user_id' => $request->employee,
                'page_id' => $select,
            ]);
        }
        $emp = User::find($request->employee);

        return redirect(route('PageAssignEmp'))->with('notification', $emp->name . ' pages are assigned!');
    }

    public function update(Request $request)
    {
        $id = $request->hiddenEmpID;
        $emp = User::find($id);

        //if all page unselect
        if(!$request->pageCheck)
        {
            $UserPage = PageUser::where('user_id',$id)->get();
            $UserPage->each->delete();
            return redirect(route('PageAssignEmp'))->with('notification', $emp->name . ' all pages are deleted!');
        }

        $pages = Page::all();

        foreach($pages as $page)
        {
            $haspage = PageUser::where('user_id',$id)->where('page_id',$page->id)->first();

            //if page is not assigned before
            if(!$haspage)
            {
                foreach($request->pageCheck as $reqPage)
                {
                    //if page request match
                    if($reqPage == $page->id)
                    {
                        PageUser::create([
                            'user_id' => $id,
                            'page_id' => $reqPage,
                        ]);
                        break;
                    }
                }
            }
            else
            {
                $i = 0;
                foreach($request->pageCheck as $reqPage)
                {
                    if($reqPage == $page->id)
                    {
                        $i = 1;
                        break;
                    }
                }
                //if did not check page
                if($i == 0)
                {
                    $haspage->delete();
                }
            }
        }
        return redirect(route('PageAssignEmp'))->with('notification', $emp->name . ' pages are updated!');
    }
}
