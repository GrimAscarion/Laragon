<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Models\Category;
 
class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::get();
 
        return view('category/index', ['category' => $category]);
    }
 
    public function add()
    {
        return view('category.form');
    }
 
    public function save(Request $request)
    {
        Category::create(['name' => $request->name]);
 
        return redirect()->route('category');
    }
 
    public function edit($id)
    {
        $category = Category::find($id);
        return view('category.form', ['category' => $category]);
    }
 
    public function update($id, Request $request)
    {
        Category::find($id)->update(['name' => $request->name]);
 
        return redirect()->route('category');
    }
 
    public function delete($id)
    {
        Category::destroy($id);
        return redirect()->route('category'); 
    }
}