<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index(){
        $pageTitle = 'All Categories';
        $categories = Category::orderBy('id','desc')->paginate(getPaginate(12));
        return view('admin.category.index',compact('categories','pageTitle'));
     }

     public function store(Request $request)
     {
             $request->validate([
                 'name' => 'required|max:191|unique:categories',
                 'icon' => 'required',
             ]);

             $category = new Category();
             $category->name = $request->name;
             $category->icon = $request->icon;
             $category->status = 1;
             $category->save();

             $notify[] = ['success', 'Category has been created successfully'];
             return back()->withNotify($notify);

     }

     public function update(Request $request)
     {
             $request->validate([
                 'name' => 'required',
                 'icon' => 'required',
             ]);

             $category = Category::find($request->id);
             $category->name = $request->name;
             $category->icon = $request->icon;
             $category->status = $request->status ? 1 : 0;
             $category->save();

             $notify[] = ['success', 'Category has been Updated successfully'];
             return back()->withNotify($notify);

    }
}
