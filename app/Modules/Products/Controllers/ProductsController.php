<?php

namespace App\Modules\Products\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\Products\Models\Product;
use App\Modules\Products\Models\ProductCategory;
use App\Modules\Products\Models\ProductVendor;
use App\Modules\Products\Models\ProductBrand;
use App\Modules\Products\Models\ProductUnit;
use App\Modules\Products\Models\ProductCountLog;
use App\Modules\Products\Models\ProductCountLogItem;

use App\Modules\Company\Models\Branch;     

class ProductsController extends Controller
{

    public function __construct() {
        //
    }

    public function actionProductsIndex(Request $Request) {
        if (view()->exists('products.products_index')) {

            $Product = new Product();
            $ProductList = $Product::where('deleted_at_int', '!=', 0)->get();

            $data = [
                'product_list' => $ProductList,
            ];
            
            return view('products.products_index', $data);
        } else {
            abort('404');
        }
    }

    public function actionProductsAdd(Request $Request) {
        if (view()->exists('products.products_add')) {

            $Product = new Product();
            $ParentProduct = $Product::where('parent_id', 0)->where('deleted_at_int', '!=', 0)->where('active', 1)->get();

            $ProductCategory = new ProductCategory();
            $ProductCategoryList = $ProductCategory::where('deleted_at_int', '!=', 0)->get();

            $ProductBrand = new ProductBrand();
            $ProductBrandList = $ProductBrand::where('deleted_at_int', '!=', 0)->get();

            $ProductVendor = new ProductVendor();
            $ProductVendorList = $ProductVendor::where('deleted_at_int', '!=', 0)->get();

            $ProductUnit = new ProductUnit();
            $ProductUnitList = $ProductUnit::where('deleted_at_int', '!=', 0)->get();

            $Branch = new Branch();
            $BranchList = $Branch::where('deleted_at_int', '!=', 0)->where('parent_id', 0)->where('is_warehouse', 0)->get();

            $data = [
                'parent_products' => $ParentProduct,
                'categories_list' => $ProductCategoryList,
                'brand_list' => $ProductBrandList,
                'vendor_list' => $ProductVendorList,
                'branch_list' => $BranchList,
                'unit_list' => $ProductUnitList,
            ];
            
            return view('products.products_add', $data);
        } else {
            abort('404');
        }
    }

    public function actionProductsCategory(Request $Request) {
        if (view()->exists('products.products_categories')) {

            $ProductCategory = new ProductCategory();
            $ProductCategoryList = $ProductCategory::where('deleted_at_int', '!=', 0)->get();

            $data = [
                'categories_list' => $ProductCategoryList,
            ];
            
            return view('products.products_categories', $data);
        } else {
            abort('404');
        }
    }

    public function actionProductsVendor(Request $Request) {
        if (view()->exists('products.products_vendors')) {

            $ProductVendor = new ProductVendor();
            $ProductVendorList = $ProductVendor::where('deleted_at_int', '!=', 0)->get();

            $data = [
                'vendor_list' => $ProductVendorList,
            ];
            
            return view('products.products_vendors', $data);
        } else {
            abort('404');
        }
    }

    public function actionUsersBrands(Request $Request) {
        if (view()->exists('products.products_brands')) {

            $ProductBrand = new ProductBrand();
            $ProductBrandList = $ProductBrand::where('deleted_at_int', '!=', 0)->get();

            $data = [
                'brand_list' => $ProductBrandList,
            ];
            
            return view('products.products_brands', $data);
        } else {
            abort('404');
        }
    }

    public function actionProductsBalanceHistory(Request $Request) {
        if (view()->exists('products.products_balance_history')) {

            $ProductCountLog = new ProductCountLog();
            $ProductCountLogData = $ProductCountLog::where('deleted_at_int', '!=', 0)->get();

            $data = [
                'product_count_log_list' => $ProductCountLogData,
            ];

            return view('products.products_balance_history', $data);
        } else {
            abort('404');
        }
    }

    public function actionProductsBalanceHistoryList(Request $Request) {
        if (view()->exists('products.products_balance_history_items')) {

            $ProductCountLog = new ProductCountLog();
            $ProductCountLogData = $ProductCountLog::find($Request->id);

            $LogArray = [];

            $ProductCountLogItem = new ProductCountLogItem();
            $ProductCountLogItemList = $ProductCountLogItem::where('log_id', $Request->id)->get();

            $data = [
                'product_count_log' => $ProductCountLogData,
                'product_count_log_item_list' => $ProductCountLogItemList,
            ];

            return view('products.products_balance_history_items', $data);
        } else {
            abort('404');
        }
    }
}
