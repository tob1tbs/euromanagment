<?php

namespace App\Modules\Products\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\Products\Models\Product;

class ProductsController extends Controller
{

    public function __construct() {
        //
    }

    public function actionProductsIndex(Request $Request) {
        if (view()->exists('products.products_index')) {

            $data = [
                
            ];
            
            return view('products.products_index', $data);
        } else {
            abort('404');
        }
    }

    public function actionProductsAdd(Request $Request) {
        if (view()->exists('products.products_add')) {

            $data = [
                
            ];
            
            return view('products.products_add', $data);
        } else {
            abort('404');
        }
    }

    public function actionProductCategory(Request $Request) {
        if (view()->exists('products.products_categories')) {

            $data = [
                
            ];
            
            return view('products.products_categories', $data);
        } else {
            abort('404');
        }
    }

    public function actionProductVendor(Request $Request) {
        if (view()->exists('products.products_vendors')) {

            $data = [
                
            ];
            
            return view('products.products_vendors', $data);
        } else {
            abort('404');
        }
    }

    public function actionUsersBrands(Request $Request) {
        if (view()->exists('products.products_vendors')) {

            $data = [
                
            ];
            
            return view('products.products_vendors', $data);
        } else {
            abort('404');
        }
    }

    public function actionProductBalance(Request $Request) {
        if (view()->exists('products.products_balance')) {

            $data = [
                
            ];
            
            return view('products.products_balance', $data);
        } else {
            abort('404');
        }
    }
}
