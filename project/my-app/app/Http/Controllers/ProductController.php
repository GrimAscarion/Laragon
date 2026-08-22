<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Category;
 
class ProductController extends Controller
{
    public function index()
    {
        $product = Product::get();
 
        return view('products.index', ['data' => $product]);
    }
 
    public function add()
    {
        $category = Category::get();
     
        return view('products.form', ['category' => $category]);
    }
 
    public function save(Request $request)
    {
        $data = [
            'item_code' => $request->item_code,
            'productname' => $request->productname,
            'category' => $request->id_category,
            'price' => $request->price
        ];
 
        Product::create($data);
 
        return redirect()->route('products');
    }
 
    public function edit($id)
    {
        $product = Product::find($id);
        $category = Category::get();
 
        return view('products.form', ['product' => $product, 'category' => $category]);
    }
 
    public function update($id, Request $request)
    {
        $data = [
            'item_code' => $request->item_code,
            'productname' => $request->productname,
            'category' => $request->id_category,
            'price' => $request->price
        ];
 
        Product::find($id)->update($data);
 
        return redirect()->route('products');
    }
 
    public function delete($id)
    {
        Product::find($id)->delete();
 
        return redirect()->route('products');
    }
}