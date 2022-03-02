<?php

namespace App\Modules\Products\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\Products\Models\Product;
use App\Modules\Products\Models\ProductCategory;
use App\Modules\Products\Models\ProductBrand;
use App\Modules\Products\Models\ProductVendor;
use App\Modules\Products\Models\ProductOption;
use App\Modules\Products\Models\ProductCountLog;
use App\Modules\Products\Models\ProductCountLogItem;
use App\Modules\Products\Models\ProductStatus;

class ProductsController extends Controller
{

    public function __construct() {

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

            $ProductCategory = new ProductCategory();
            $ProductCategoryList = $ProductCategory::where('deleted_at_int', '!=', 0)
                                                    ->where('parent_id', 0)
                                                    ->where('active', 1)
                                                    ->orderBy('sortable', 'ASC')
                                                    ->get();
            $ProductVendor = new ProductVendor();
            $ProductVendorList = $ProductVendor::where('deleted_at_int', '!=', 0)->get();

            $Product = new Product();
            $ProductList = $Product::where('deleted_at_int', '!=', 0)
                                    ->where('parent_id', 0)
                                    ->where('active', 1)
                                    ->orderBy('sortable', 'ASC')
                                    ->get();

            $ProductStatus = new ProductStatus();
            $ProductStatusList = $ProductStatus::where('deleted_at_int', '!=', 0)
                                    ->where('active', 1)
                                    ->get();


            $data = [
                'product_category_list' => $ProductCategoryList,
                'product_vendor_list' => $ProductVendorList,
                'product_list' => $ProductList,
                'product_status' => $ProductStatusList,
            ];

            return view('products.products_add', $data);
        } else {
            abort('404');
        }
    }

    public function actionProductsEdit(Request $Request) {
        if (view()->exists('products.products_edit')) {

            $data = [
            ];

            return view('products.products_edit', $data);
        } else {
            abort('404');
        }
    }

    public function actionProductsCategories(Request $Request) {
        if (view()->exists('products.products_categories')) {

            $ProductCategory = new ProductCategory();
            $ProductCategoryList = $ProductCategory::where('deleted_at_int', '!=', 0)->where('parent_id', 0)->orderBy('sortable', 'ASC')->get();

            $data = [
                'product_category_list' => $ProductCategoryList,
            ];

            return view('products.products_categories', $data);
        } else {
            abort('404');
        }
    }

    public function actionProductsBrands(Request $Request) {
        if (view()->exists('products.products_brands')) {

            $ProductCategory = new ProductCategory();
            $ProductCategoryList = $ProductCategory::where('deleted_at_int', '!=', 0)->where('parent_id', 0)->where('active', 1)->get();

            $ProductBrand = new ProductBrand();
            $ProductBrandList = $ProductBrand::where('deleted_at_int', '!=', 0);

            if($Request->isMethod('GET')) {
                if($Request->has('search_query') && !empty($Request->search_query)) {
                    $ProductBrandList = $ProductBrandList->where('name_ge', 'like', '%'.$Request->search_query.'%')->orWhere('name_en', 'like', '%'.$Request->search_query.'%');
                }

                if($Request->has('brand_active') && !empty($Request->brand_active)) {
                    $ProductBrandList = $ProductBrandList->where('active', $Request->brand_active);
                }

                if($Request->has('sort_by') && !empty($Request->sort_by)) {
                    if($Request->sort_by == 'DESC' OR $Request->sort_by == 'ASC') {
                        $ProductBrandList = $ProductBrandList->orderBy('id', $Request->sort_by);
                    } else {
                        $ProductBrandList = $ProductBrandList->orderBy('sortable', 'ASC');
                    }
                } else {
                    $ProductBrandList = $ProductBrandList->orderBy('sortable', 'ASC');
                }

                if($Request->has('count') && !empty($Request->count)) {
                    $ProductBrandList = $ProductBrandList->paginate($Request->count)->appends(request()->query());
                } else {
                    $ProductBrandList = $ProductBrandList->paginate(10)->appends(request()->query());
                }
            }

            $data = [
                'product_category_list' => $ProductCategoryList,
                'product_brand_list' => $ProductBrandList,
            ];

            return view('products.products_brands', $data);
        } else {
            abort('404');
        }
    }

    public function actionProductsVendors(Request $Request) {
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

    public function actionProductsOptions(Request $Request) {
        if (view()->exists('products.products_options')) {

            $ProductOption = new ProductOption();
            $ProductOptionList = $ProductOption::where('deleted_at_int', '!=', 0)->orderBy('sortable', 'ASC')->get();

            $ProductCategory = new ProductCategory();
            $ProductCategoryList = $ProductCategory::where('deleted_at_int', '!=', 0)->where('parent_id', 0)->where('active', 1)->get();

            $data = [
                'product_category_list' => $ProductCategoryList,
                'product_option_list' => $ProductOptionList,
                'product_option_type_list' => $ProductOption->optionTypeList(),
            ];

            return view('products.products_options', $data);
        } else {
            abort('404');
        }
    }

    public function actionProductsFacebook(Request $Request) {
        if (view()->exists('products.products_facebook')) {

            $data = [
            ];

            return view('products.products_facebook', $data);
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
