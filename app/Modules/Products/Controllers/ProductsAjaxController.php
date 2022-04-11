<?php

namespace App\Modules\Products\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\Products\Models\Product;
use App\Modules\Products\Models\ProductVendor;
use App\Modules\Products\Models\ProductCategory;
use App\Modules\Products\Models\ProductBrand;
use App\Modules\Products\Models\ProductPrice;

use App\Modules\Company\Models\Branch;   

use Validator;
use Response;
use \Carbon\Carbon;

class ProductsAjaxController extends Controller
{

    public function __construct() {
        
    }

    public function ajaxProductCategoriesSubmit(Request $Request) {
        if($Request->isMethod('POST')) {
            $messages = array(
                'required' => 'გთხოვთ შეავსოთ ყველა აუცილებელი ველი',
            );
            $validator = Validator::make($Request->all(), [
                'category_name' => 'required|max:255',
            ], $messages);

            if ($validator->fails()) {
                return Response::json(['status' => true, 'errors' => true, 'message' => $validator->getMessageBag()->toArray()], 200);
            } else {

                $ProductCategory = new ProductCategory();
                $ProductCategory::updateOrCreate(
                    ['id' => $Request->category_id],
                    [
                        'id' => $Request->category_id,
                        'name' => $Request->category_name,
                    ],
                );
            }

            return Response::json(['status' => true, 'message' => 'კატეგორია წარმატებით დაემატა']);
        } else {
            return Response::json(['status' => true, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან.']);
        }
    }

    public function ajaxProductCategoriesActive(Request $Request) {
        if($Request->isMethod('POST') && !empty($Request->category_id) && $Request->category_id != 1) {
            $ProductCategory = new ProductCategory();
            $ProductCategory::find($Request->category_id)->update([
                'active' => $Request->category_active,
            ]);
            return Response::json(['status' => true]);
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxProductCategoriesDelete(Request $Request) {
        if($Request->isMethod('POST') && !empty($Request->category_id) && $Request->category_id != 1) {
            $ProductCategory = new ProductCategory();
            $ProductCategory::find($Request->category_id)->update([
                'deleted_at' => Carbon::now(),
                'deleted_at_int' => 0,
                'active' => 0,
            ]);
            return Response::json(['status' => true, 'message' => 'კატეგორია წარმატებით წაიშლა !!!']);
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxProductCategoriesGet(Request $Request) {
        if($Request->isMethod('GET') && !empty($Request->category_id) && $Request->category_id != 1) {
            $ProductCategory = new ProductCategory();
            $ProductCategoryData = $ProductCategory::find($Request->category_id);

            if(!empty($ProductCategoryData)) {
                return Response::json(['status' => true, 'ProductCategoryData' => $ProductCategoryData]);
            } else {
                return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!'], 200);
            }
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxProductVendorSubmit(Request $Request) {
        if($Request->isMethod('POST')) {
            $messages = array(
                'required' => 'გთხოვთ შეავსოთ ყველა აუცილებელი ველი',
                'unique' => 'მომწოდებელი აღნიშნული კოდით უკვე დამატებულია',
            );
            $validator = Validator::make($Request->all(), [
                'vendor_name' => 'required|max:255',
                'vendor_code' => 'required|max:255|unique:new_product_vendors,code,'.$Request->vendor_id.'',
            ], $messages);

            if ($validator->fails()) {
                return Response::json(['status' => true, 'errors' => true, 'message' => $validator->getMessageBag()->toArray()], 200);
            } else {

                $ProductVendor = new ProductVendor();
                $ProductVendor::updateOrCreate(
                    ['id' => $Request->vendor_id],
                    [
                        'id' => $Request->vendor_id,
                        'name' => $Request->vendor_name,
                        'code' => $Request->vendor_code,
                    ],
                );
            }

            return Response::json(['status' => true, 'message' => 'კატეგორია წარმატებით დაემატა']);
        } else {
            return Response::json(['status' => true, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან.']);
        }
    }

    public function ajaxProductVendorActive(Request $Request) {
        if($Request->isMethod('POST') && !empty($Request->vendor_id) && $Request->vendor_id != 1) {
            $ProductVendor = new ProductVendor();
            $ProductVendor::find($Request->vendor_id)->update([
                'active' => $Request->vendor_active,
            ]);
            return Response::json(['status' => true]);
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxProductVendorDelete(Request $Request) {
        if($Request->isMethod('POST') && !empty($Request->vendor_id) && $Request->vendor_id != 1) {
            $ProductVendor = new ProductVendor();
            $ProductVendor::find($Request->vendor_id)->update([
                'deleted_at' => Carbon::now(),
                'deleted_at_int' => 0,
                'active' => 0,
            ]);
            return Response::json(['status' => true]);
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxProductVendorGet(Request $Request) {
        if($Request->isMethod('GET') && !empty($Request->vendor_id) && $Request->vendor_id != 1) {
            $ProductVendor = new ProductVendor();
            $ProductVendorData = $ProductVendor::find($Request->vendor_id);

            if(!empty($ProductVendorData)) {
                return Response::json(['status' => true, 'ProductVendorData' => $ProductVendorData]);
            } else {
                return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!'], 200);
            }
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxProductBrandSubmit(Request $Request) {
        if($Request->isMethod('POST')) {
            $messages = array(
                'required' => 'გთხოვთ შეავსოთ ყველა აუცილებელი ველი',
            );
            $validator = Validator::make($Request->all(), [
                'brand_name' => 'required|max:255',
            ], $messages);

            if ($validator->fails()) {
                return Response::json(['status' => true, 'errors' => true, 'message' => $validator->getMessageBag()->toArray()], 200);
            } else {

                $ProductBrand = new ProductBrand();
                $ProductBrand::updateOrCreate(
                    ['id' => $Request->brand_id],
                    [
                        'id' => $Request->brand_id,
                        'name' => $Request->brand_name,
                    ],
                );
            }

            return Response::json(['status' => true, 'message' => 'კატეგორია წარმატებით დაემატა']);
        } else {
            return Response::json(['status' => true, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან.']);
        }
    }

    public function ajaxProductBrandActive(Request $Request) {
        if($Request->isMethod('POST') && !empty($Request->brand_id) && $Request->brand_id != 1) {
            $ProductBrand = new ProductBrand();
            $ProductBrand::find($Request->brand_id)->update([
                'active' => $Request->brand_active,
            ]);
            return Response::json(['status' => true]);
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxProductBrandDelete(Request $Request) {
        if($Request->isMethod('POST') && !empty($Request->brand_id) && $Request->brand_id != 1) {
            $ProductBrand = new ProductBrand();
            $ProductBrand::find($Request->brand_id)->update([
                'deleted_at' => Carbon::now(),
                'deleted_at_int' => 0,
                'active' => 0,
            ]);
            return Response::json(['status' => true]);
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxProductBrandGet(Request $Request) {
        if($Request->isMethod('GET') && !empty($Request->brand_id) && $Request->brand_id != 1) {
            $ProductBrand = new ProductBrand();
            $ProductBrandData = $ProductBrand::find($Request->brand_id);

            if(!empty($ProductBrandData)) {
                return Response::json(['status' => true, 'ProductBrandData' => $ProductBrandData]);
            } else {
                return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!'], 200);
            }
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxProductWarehouseGet(Request $Request) {
        if($Request->isMethod('GET') && !empty($Request->branch_id)) {
            $Branch = new Branch();
            $WarehouseList = $Branch::where('deleted_at_int', '!=', 0)->where('parent_id', $Request->branch_id)->where('is_warehouse', 1)->get();

            if(!empty($WarehouseList)) {
                return Response::json(['status' => true, 'WarehouseList' => $WarehouseList]);
            }
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxProductSubmit(Request $Request) {
        if($Request->isMethod('POST')) {
            $messages = array(
                'required' => 'გთხოვთ შეავსოთ ყველა აუცილებელი ველი',
            );
            $validator = Validator::make($Request->all(), [
                'product_name' => 'required|max:255',
                // 'product_unit' => 'required|max:255',
                'product_vendor_price' => 'required|max:255',
                'product_retail_price' => 'required|max:255',
                'product_wholesale_price' => 'required|max:255',
            ], $messages);

            if ($validator->fails()) {
                return Response::json(['status' => true, 'errors' => true, 'message' => $validator->getMessageBag()->toArray()], 200);
            } else {
                $Product = new Product();
                $InsertProduct = $Product::updateOrCreate(
                    ['id' => $Request->product_id],
                    [
                        'id' => $Request->product_id,
                        'parent_id' => $Request->parent_product,
                        'name' => $Request->product_name,
                        'category_id' => $Request->product_category,
                        'brand_id' => $Request->product_brand,
                        'vendor_id' => $Request->product_vendor,
                        'count' => $Request->product_count,
                        'unit_id' => 1,
                        'warehouse_id' => $Request->product_warehouse,
                    ],
                );

                $ProductPrice = new ProductPrice();
                $ProductPrice::updateOrCreate(
                    [
                        'id' => $Request->product_price_id,
                        'product_id' => $InsertProduct->id,
                        'vendor_price' => $Request->product_vendor_price,
                        'retail_price' => $Request->product_retail_price,
                        'wholesale_price' => $Request->product_wholesale_price,
                    ]
                );

                return Response::json(['status' => true, 'message' => 'პროდუქტი წარმატებით დაემატა !!!']);
            }
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }
}
