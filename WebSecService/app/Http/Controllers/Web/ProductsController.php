<?php
namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\Web\ProductsController;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Foundation\Validation\ValidatesRequests;


class ProductsController extends Controller{
    use ValidatesRequests;

    public function __construct()
    {
    $this->middleware('auth:web')->except('list');   // the "web" part is the default here, but we also wrote it.
    }


    public function list(Request $request) {
        
        $products = Product::all();    # all() is a static method provided by Laravel's Eloquent ORM (Object-Relational Mapper).

        return view("products.list", compact('products'));
        }

    public function edit(Request $request, Product $product = null) {
            
        // if(!auth()->check()) return redirect()->route('login');  // No need the middleware is enabled
            
        $product = $product??new Product();
            
        return view("products.edit", compact('product'));
        }
           
    public function save(Request $request, Product $product = null) {

        $this->validate($request, [
            'code' => ['required', 'string', 'max:32'],
            'name' => ['required', 'string', 'max:128'],
            'model' => ['required', 'string', 'max:256'],
            'description' => ['required', 'string', 'max:1024'],
            'price' => ['required', 'numeric'],
            ]);
            
            $product = $product??new Product();
            $product->fill($request->all());
            $product->save();

        return redirect()->route('products_list');
        }

    public function delete(Request $request, Product $product) {

        if (!auth()->user()->hasPermissionTo('delete_products')) {
            abort(401);
        }
        
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


        public function favorite($id)
            {
                if (!auth()->user()->can('select_favorite')) {
                        abort(403, 'Unauthorized action.');
                    }
                $product = Product::findOrFail($id);
                $product->favorite = true;
                $product->save();

                return redirect()->back()->with('success', 'Product added to favorites.');
            }

    }    
   