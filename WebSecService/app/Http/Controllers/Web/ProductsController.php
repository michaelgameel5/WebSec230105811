<?php
namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\Web\ProductsController;
use App\Http\Controllers\Controller;
use App\Models\Product;


class ProductsController extends Controller{

    public function list(Request $request) {
        
        $products = Product::all();    # all() is a static method provided by Laravel's Eloquent ORM (Object-Relational Mapper).

        return view("products.list", compact('products'));
        }

    public function edit(Request $request, Product $product = null) {
            
        $product = $product??new Product();
            
        return view("products.edit", compact('product'));
        }
           
    public function save(Request $request, Product $product = null) {

        $product = $product??new Product();
        $product->fill($request->all());
        $product->save();

        return redirect()->route('products_list');
        }

    public function delete(Request $request, Product $product) {

        $product->delete();

        return redirect()->route('products_list');
        }
    
    public function search(Request $request)
    {
            $keywords = $request->input('keywords');
            $minPrice = $request->input('min_price');
            $maxPrice = $request->input('max_price');
            $orderBy = $request->input('order_by');
            $orderDirection = $request->input('order_direction');
    
            $products = Product::query(); 
    
            if ($keywords) {
                $products->where('name', 'like', '%' . $keywords . '%'); // 
            }
    
            if ($minPrice) {
                $products->where('price', '>=', $minPrice);
            }
    
            if ($maxPrice) {
                $products->where('price', '<=', $maxPrice);
            }
    
            if ($orderBy && $orderDirection) {
                $products->orderBy($orderBy, $orderDirection);
            }
    
            $products = $products->get(); 
    
            return view('products.list', compact('products'));
        }
    }    
   