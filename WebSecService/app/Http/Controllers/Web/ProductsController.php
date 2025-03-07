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
   }