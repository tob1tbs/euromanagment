<?php

namespace App\Modules\Products\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Modules\Products\Models\ProductCategory;
use App\Modules\Products\Models\ProductOption;
use App\Modules\Products\Models\ProductOptionValue;
use App\Modules\Products\Models\ProductBrand;
use App\Modules\Products\Models\Product;
use App\Modules\Products\Models\ProductMeta;
use App\Modules\Products\Models\ProductPrice;
use App\Modules\Products\Models\ProductVendor;
use App\Modules\Products\Models\ProductOptionItem;

use App\Imports\ProductBalanceImport;

use Validator;
use Response;
use Excel;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

use App\Exports\ProductBalanceExport;

class ProductsAjaxController extends Controller
{
    //

    public function ajaxCategoriesAdd(Request $Request) {
        if($Request->isMethod('POST')) {
            $messages = array(
                'required' => 'გთხოვთ შეიყვანოთ ყველა აუცილებელი ველი',
            );
            $validator = Validator::make($Request->all(), [
                'category_name_ge' => 'required|max:255',
                'category_keywords_ge' => 'required|max:255',
            ], $messages);

            if ($validator->fails()) {
                return Response::json(['status' => true, 'errors' => true, 'message' => $validator->getMessageBag()->toArray()], 200);
            } else {

                $Array = ['ge' => $Request->category_name_ge, 'en' => $Request->category_name_en];
                $ArrayMeta = ['ge' => $Request->category_keywords_ge, 'en' => $Request->category_keywords_en];

                $ProductCategory = new ProductCategory();
                $ProductCategory::updateOrCreate(
                    ['id' => $Request->category_id],
                    [
                        'id' => $Request->category_id, 
                        'name' => json_encode($Array),
                        'meta' => json_encode($ArrayMeta),
                        'parent_id' => 0,
                    ],
                );
                return Response::json(['status' => true, 'errors' => false, 'message' => 'კატეგორია წარმატებით დაემატა']);
            }
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxCategoriesSortable(Request $Request) {
        if($Request->isMethod('POST')) {
            foreach($Request->category_item as $key => $Item) {
                $Sortable = $key + 1;
                $ProductCategory = new ProductCategory();
                $ProductCategory::where('id', intval($Item))->update(['sortable' => intval($Sortable)]);
            }
            return Response::json(['status' => true]);
        } else {
            return Response::json(['status' => false]);
        }
    }

    public function ajaxCategoriesActive(Request $Request) {
        if($Request->isMethod('POST') && !empty($Request->category_id)) {

            if($Request->category_id != 1){
                $ProductCategory = new ProductCategory();
                $ProductCategory::find($Request->category_id)->update([
                    'active' => $Request->category_active,
                ]);

                return Response::json(['status' => true, 'errors' => false]);
            } else {
                return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!']);
            }

        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxCategoriesDelete(Request $Request) {
        if($Request->isMethod('POST') && !empty($Request->category_id)) {

            if($Request->category_id != 1) {
                $ProductCategory = new ProductCategory();
                $ProductCategory::find($Request->category_id)->update([
                    'active' => 0,
                    'deleted_at' => Carbon::now(),
                    'deleted_at_int' => 0,
                ]);

                $Product = new Product();
                $Product::where('category_id', $Request->category_id)->update([
                    'category_id' => 1,
                ]);

                $ProductBrand = new ProductBrand();
                $ProductBrand::where('category_id', $Request->category_id)->update([
                    'category_id' => 1,
                ]);

                return Response::json(['status' => true, 'errors' => false, 'message' => 'მომხმარებელი წარმატებით წაიშალა']);
            } else {
                return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!']);
            }

        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxCategoriesEdit(Request $Request) {
        if($Request->isMethod('GET')) {
            if($Request->category_id != 1) {
                $ProductCategory = new ProductCategory();
                $ProductCategoryData = $ProductCategory::findOrFail($Request->category_id);

                return Response::json(['status' => true, 'errors' => false, 'ProductCategoryData' => $ProductCategoryData]);
            } else {
                return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!']);
            }
        } else {
                return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxCategoriesChild(Request $Request) {
        if($Request->isMethod('GET') && !empty($Request->category_id)) {
            $ProductCategory = new ProductCategory();
            $ProductChildCategoryList = $ProductCategory::where('parent_id', $Request->category_id)
                                                    ->where('deleted_at_int', '!=', 0)
                                                    ->orderBy('sortable', 'ASC')
                                                    ->get();

            return Response::json(['status' => true, 'ProductChildCategoryList' => $ProductChildCategoryList]);
        } else {
            return Response::json(['status' => false]);
        }
    }

    public function ajaxCategoriesChildAdd(Request $Request) {
        if($Request->isMethod('POST')) {
            $messages = array(
                'required' => 'გთხოვთ შეიყვანოთ ყველა აუცილებელი ველი',
            );
            $validator = Validator::make($Request->all(), [
                'child_category_name_ge' => 'required|max:255',
                'child_category_keywords_ge' => 'required|max:255',
            ], $messages);

            if ($validator->fails()) {
                return Response::json(['status' => true, 'errors' => true, 'message' => $validator->getMessageBag()->toArray()], 200);
            } else {
                $Array = ['ge' => $Request->child_category_name_ge, 'en' => $Request->child_category_name_en];
                $ArrayMeta = ['ge' => $Request->child_category_keywords_ge, 'en' => $Request->child_category_keywords_en];

                $ProductCategory = new ProductCategory();
                $ProductCategory::updateOrCreate(
                    ['id' => $Request->child_category_id],
                    [
                        'id' => $Request->child_category_id, 
                        'name' => json_encode($Array),
                        'meta' => json_encode($ArrayMeta),
                        'parent_id' => $Request->child_category_parent_id,
                    ],
                );

                $ProductChildCategoryList = $ProductCategory::where('parent_id', $Request->child_category_parent_id)->where('deleted_at_int', '!=', 0)->get();

                return Response::json(['status' => true, 'errors' => false, 'ProductChildCategoryList' => $ProductChildCategoryList, 'message' => 'კატეგორია წარმატებით დაემატა']);
            }
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxCategoriesChildDelete(Request $Request) {
        if($Request->isMethod('POST') && !empty($Request->child_category_id)) {

            $ProductCategory = new ProductCategory();
            $ProductCategoryData = $ProductCategory::find($Request->child_category_id);

            $ProductCategoryData->update([
                'active' => 0,
                'deleted_at' => Carbon::now(),
                'deleted_at_int' => 0,
            ]);

            $Product = new Product();
            $Product::where('child_category_id', $Request->child_category_id)->update([
                'child_category_id' => 2,
            ]);

            $ProductBrand = new ProductBrand();
            $ProductBrand::where('category_id', $Request->category_id)->update([
                'child_category_id' => 2,
            ]);

            $ProductChildCategoryList = $ProductCategory::where('parent_id', $ProductCategoryData->parent_id)->where('deleted_at_int', '!=', 0)->get();

            return Response::json(['status' => true, 'errors' => false, 'message' => 'მომხმარებელი წარმატებით წაიშალა', 'ProductChildCategoryList' => $ProductChildCategoryList]);

        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxCategoriesChildSortable(Request $Request) {
        if($Request->isMethod('POST')) {
            foreach($Request->child_category_item as $key => $Item) {
                $Sortable = $key + 1;
                $ProductCategory = new ProductCategory();
                $ProductCategory::where('id', intval($Item))->update(['sortable' => intval($Sortable)]);
            }
        } else {
            return Response::json(['status' => false]);
        }
    }

    public function ajaxBrandFormSubmit(Request $Request) {
        if($Request->isMethod('POST')) {
            $messages = array(
                'required' => 'გთხოვთ შეიყვანოთ ყველა აუცილებელი ველი',
            );
            $validator = Validator::make($Request->all(), [
                'brand_name_ge' => 'required|max:255',
            ], $messages);

            if ($validator->fails()) {
                return Response::json(['status' => true, 'errors' => true, 'message' => $validator->getMessageBag()->toArray()], 200);
            } else {
                $Array = ['ge' => $Request->brand_name_ge, 'en' => $Request->brand_name_en];

                $ProductBrand = new ProductBrand();
                $ProductBrand::updateOrCreate(
                    ['id' => $Request->brand_id],
                    [
                        'id' => $Request->brand_id,
                        'name' => json_encode($Array),
                        'category_id' => $Request->brand_category_id,
                        'child_category_id' => $Request->brand_child_category_id,
                    ],
                );

                return Response::json(['status' => true, 'errors' => false, 'message' => 'ბრენდი წარმატებით დაემატა']);
            }
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxGetSubCategoryList(Request $Request) {
        if($Request->isMethod('GET') && !empty($Request->category_id)) {
            $ProductCategory = new ProductCategory();
            $ProductChildCategoryList = $ProductCategory::where('parent_id', $Request->category_id)
                                                    ->where('deleted_at_int', '!=', 0)
                                                    ->orderBy('sortable', 'ASC')
                                                    ->get();

            return Response::json(['status' => true, 'ProductChildCategoryList' => $ProductChildCategoryList]);
        } else {
            return Response::json(['status' => false]);
        }
    }


    public function ajaxBrandActiveChange(Request $Request) {
        if($Request->isMethod('POST') && !empty($Request->brand_id) && $Request->brand_id > 1) {

            $ProductBrand = new ProductBrand();
            $ProductBrand::find($Request->brand_id)->update([
                'active' => $Request->brand_active,
            ]);

            return Response::json(['status' => true, 'errors' => false]);

        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxBrandDelete(Request $Request) {
        if($Request->isMethod('POST') && !empty($Request->brand_id) && $Request->brand_id > 1) {

            $ProductBrand = new ProductBrand();
            $ProductBrand::find($Request->brand_id)->update([
                'active' => 0,
                'deleted_at' => Carbon::now(),
                'deleted_at_int' => 0,
            ]);

            $Product = new Product();
            $Product::where('brand_id', $Request->brand_id)->update([
                'brand_id' => 1,
            ]);

            return Response::json(['status' => true, 'errors' => false, 'message' => 'ბრენდი წარმატებით წაიშალა !!!']);

        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxBrandSort(Request $Request) {
        if($Request->isMethod('POST')) {
            foreach($Request->brand_item as $key => $Item) {
                $Sortable = $key + 1;
                $ProductBrand = new ProductBrand();
                $ProductBrand::where('id', intval($Item))->update(['sortable' => intval($Sortable)]);
            }
        } else {
            return Response::json(['status' => false]);
        }
    }

    public function ajaxBrandEdit(Request $Request) {
        if($Request->isMethod('GET') && !empty($Request->brand_id)  && $Request->brand_id > 1) {
            $ProductBrand = new ProductBrand();
            $ProductBrandData = $ProductBrand::findOrFail($Request->brand_id);

            $ProductCategory = new ProductCategory();
            $ChildCategoryList = $ProductCategory::where('parent_id', $ProductBrandData->category_id)->where('deleted_at_int', '!=', 0)->where('active', 1)->get();

            return Response::json(['status' => true, 'errors' => false, 'ProductBrandData' => $ProductBrandData, 'ChildCategoryList' => $ChildCategoryList]);
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!']);
        }
    }


    // OPTIONS
    public function ajaxOptionSubmit(Request $Request) {
        if($Request->isMethod('POST')) {
            $messages = array(
                'required' => 'გთხოვთ შეიყვანოთ ყველა აუცილებელი ველი',
                'option_key.unique' => 'მოცემული KEY დაკავებულია',
            );
            $validator = Validator::make($Request->all(), [
                'option_name_ge' => 'required|max:255',
                'option_key' => 'required|unique:new_product_options,key,'.$Request->option_id.'|max:50',
                'option_category' => 'required|max:255',
                'option_type' => 'required|max:255',
            ], $messages);

            if ($validator->fails()) {
                return Response::json(['status' => true, 'errors' => true, 'message' => $validator->getMessageBag()->toArray()], 200);
            } else {
                $Array = ['ge' => $Request->option_name_ge, 'en' => $Request->option_name_en];

                $ProductOption = new ProductOption();
                $ProductOption::updateOrCreate(
                    ['id' => $Request->option_id],
                    [
                        'id' => $Request->option_id,
                        'name' => json_encode($Array),
                        'key' => $Request->option_key,
                        'category_id' => $Request->option_category,
                        'child_category_id' => $Request->option_child_category,
                        'type' => $Request->option_type,
                    ],
                );

                return Response::json(['status' => true, 'message' => 'პარამეტრი წარმატებით დაემატა']);
            }
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxOptionActive(Request $Request) {
        if($Request->isMethod('POST') && $Request->option_id > 0) {
            $ProductOption = new ProductOption();
            $ProductOption::find($Request->option_id)->update([
                'active' => $Request->option_active,
            ]);

            return Response::json(['status' => true, 'errors' => false]);
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxOptionDelete(Request $Request) {
        if($Request->isMethod('POST') && !empty($Request->option_id)) {

            $ProductOption = new ProductOption();
            $ProductOption::find($Request->option_id)->update([
                'active' => 0,
                'deleted_at' => Carbon::now(),
                'deleted_at_int' => 0,
            ]);

            return Response::json(['status' => true, 'errors' => false, 'message' => 'ბრენდი წარმატებით წაიშალა !!!']);

        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxOptionOptions(Request $Request) {
        if($Request->isMethod('GET') && !empty($Request->option_id)) {

            $ProductOption = new ProductOption();
            $ProductOptionData = $ProductOption::find($Request->option_id);

            $ProductCategory = new ProductCategory();
            $ProductChildCategoryList = $ProductCategory::where('parent_id', $ProductOptionData->category_id)
                                                    ->where('deleted_at_int', '!=', 0)
                                                    ->where('active', 1)
                                                    ->orderBy('sortable', 'ASC')
                                                    ->get();

            return Response::json(['status' => true, 'errors' => false, 'ProductOptionData' => $ProductOptionData, 'ProductChildCategoryList' => $ProductChildCategoryList]);

        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxOptionSortable(Request $Request) {
        if($Request->isMethod('POST')) {
            foreach($Request->option_item as $key => $Item) {
                $Sortable = $key + 1;
                $ProductOption = new ProductOption();
                $ProductOption::where('id', intval($Item))->update(['sortable' => intval($Sortable)]);
            }
            return Response::json(['status' => true]);
        } else {
            return Response::json(['status' => false]);
        }
    }

    public function ajaxOptionValue(Request $Request) {
        if($Request->isMethod('GET') && !empty($Request->option_id)) {
            $ProductOptionValue = new ProductOptionValue();
            $ProductOptionValueList = $ProductOptionValue::where('deleted_at_int', '!=', 0)->where('option_id', $Request->option_id)->orderBy('sortable', 'ASC')->get();

            return Response::json(['status' => true, 'ProductOptionValueList' => $ProductOptionValueList]);
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxOptionValueSubmit(Request $Request) {
        if($Request->isMethod('POST') && !empty($Request->value_option_id)) {
            $messages = array(
                'required' => 'გთხოვთ შეიყვანოთ ყველა აუცილებელი ველი',
                'option_value_key.unique' => 'აღნიშნული KEY დაკავებულია',
            );
            $validator = Validator::make($Request->all(), [
                'option_value_name_ge' => 'required|max:255',
                'option_value_key' => Rule::unique('new_product_option_value', 'key')->where(function ($query) use ($Request) {
                   return $query->where('option_id', $Request->value_option_id)
                                ->where('deleted_at_int', 1)
                                ->whereNull('deleted_at');
                }),
            ], $messages);

            if ($validator->fails()) {
                return Response::json(['status' => true, 'errors' => true, 'message' => $validator->getMessageBag()->toArray()], 200);
            } else {
                $Array = ['ge' => $Request->option_value_name_ge, 'en' => $Request->option_value_name_en];

                $ProductOption = new ProductOption();
                $ProductOptionData = $ProductOption::find($Request->value_option_id);

                $ProductOptionValue = new ProductOptionValue();
                $ProductOptionValueData = $ProductOptionValue::updateOrCreate(
                    ['id' => $Request->option_value_id],
                    [
                        'id' => $Request->option_value_id,
                        'name' => json_encode($Array),
                        'option_key' => $ProductOptionData->key,
                        'option_id' => $ProductOptionData->id,
                    ],
                );

                $ProductOptionValueList = $ProductOptionValue::where('option_id', $ProductOptionValueData->option_id)
                                                                ->where('deleted_at_int', '!=', 0)
                                                                ->orderBy('sortable', 'ASC')
                                                                ->get();

                return Response::json(['status' => true, 'errors' => false, 'ProductOptionValueList' => $ProductOptionValueList]);
            }
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxOptionValueActive(Request $Request) {
        if($Request->isMethod('POST') && !empty($Request->option_value_id)) {

            $ProductOptionValue = new ProductOptionValue();
            $ProductOptionValue::find($Request->option_value_id)->update([
                'active' => $Request->option_value_active,
            ]);

            return Response::json(['status' => true, 'errors' => false]);

        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxOptionValueDelete(Request $Request) {
        if($Request->isMethod('POST') && !empty($Request->option_value_id)) {

            $ProductOptionValue = new ProductOptionValue();
            $ProductOptionValueData = $ProductOptionValue::find($Request->option_value_id);

            $ProductOptionValueData->update([
                'active' => 0,
                'deleted_at' => Carbon::now(),
                'deleted_at_int' => 0,
            ]);

            $ProductOptionValueList = $ProductOptionValue::where('option_id', $ProductOptionValueData->option_id)->where('deleted_at_int', '!=', 0)->get();

            return Response::json(['status' => true, 'errors' => false, 'message' => 'მომხმარებელი წარმატებით წაიშალა', 'ProductOptionValueList' => $ProductOptionValueList]);

        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxOptionValueSortable(Request $Request) {
        if($Request->isMethod('POST')) {
            foreach($Request->option_value_item as $key => $Item) {
                $Sortable = $key + 1;
                $ProductOptionValue = new ProductOptionValue();
                $ProductOptionValue::where('id', intval($Item))->update(['sortable' => intval($Sortable)]);
            }

            return Response::json(['status' => true]);
        } else {
            return Response::json(['status' => false]);
        }
    }

    public function ajaxOptionValueEdit(Request $Request) {
        if($Request->isMethod('GET') && !empty($Request->option_value_id)) {
            $ProductOptionValue = new ProductOptionValue();
            $ProductOptionValueData = $ProductOptionValue::find($Request->option_value_id);

            return Response::json(['status' => true, 'ProductOptionValueData' => $ProductOptionValueData]);
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxOptionValueUpdate(Request $Request) {
        if($Request->isMethod('POST') && !empty($Request->option_value_id)) {
            $messages = array(
                'required' => 'გთხოვთ შეიყვანოთ ყველა აუცილებელი ველი',
            );
            $validator = Validator::make($Request->all(), [
                'name_ge' => 'required|max:255',
            ], $messages);

            if ($validator->fails()) {
                return Response::json(['status' => true, 'errors' => true, 'message' => $validator->getMessageBag()->toArray()], 200);
            } else {
                $Array = ['ge' => $Request->name_ge, 'en' => $Request->name_en];

                $ProductOptionValue = new ProductOptionValue();
                $ProductOptionValue::find($Request->option_value_id)->update([
                    'name' => json_encode($Array),
                ]);
                return Response::json(['status' => true, 'errors' => false, 'message' => 'სახელი წარმატებით შეიცვალა !!!']);
            }
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxGetSubCategoryAndBrandList(Request $Request) {
        if($Request->isMethod('GET') && !empty($Request->category_id)) {
            $ProductCategory = new ProductCategory();
            $ProductChildCategoryList = $ProductCategory::where('parent_id', $Request->category_id)
                                                    ->orWhere('parent_id', 1)
                                                    ->where('deleted_at_int', '!=', 0)
                                                    ->orderBy('id', 'ASC')
                                                    ->get();

            $ProductBrand = new ProductBrand();
            $ProductBrandList = $ProductBrand::where('category_id', $Request->category_id)
                                                ->orWhere('category_id', 1)
                                                ->where('active', 1)
                                                ->where('deleted_at_int', '!=', 0)
                                                ->get();

            $ProductOption = new ProductOption();
            $ProductOptionList = $ProductOption::where('category_id', $Request->category_id)->where('active', 1)->where('deleted_at_int', '!=', 0)->get();

            $OptionArray = [];

            foreach($ProductOptionList as $ProductOptionItem) {
                $ProductOptionValue = new ProductOptionValue();
                $ProductOptionValueList = $ProductOptionValue::where('option_id', $ProductOptionItem->id)->where('active', 1)->where('deleted_at_int', '!=', 0)->get();

                $OptionArray[$ProductOptionItem->key] = [
                    'id' => $ProductOptionItem->id,
                    'type' => $ProductOptionItem->type,
                    'name' => json_decode($ProductOptionItem->name)->ge,
                    'options' => [],
                ];

                foreach($ProductOptionValueList as $ProductOptionValueItem) {
                    if($ProductOptionValueItem->type != 'input') {
                        $OptionArray[$ProductOptionItem->key]['options'][$ProductOptionValueItem->id] = [
                            'name' => json_decode($ProductOptionValueItem->name)->ge,
                        ];
                    }
                }
            } 

            return Response::json([
                'status' => true, 
                'ProductChildCategoryList' => $ProductChildCategoryList, 
                'ProductBrandList' => $ProductBrandList,
                'ProductOptionArray' => $OptionArray,
            ]);
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxGetBrandByChildCategory(Request $Request) {
        if($Request->isMethod('GET') && !empty($Request->child_category_id)) {
            $ProductBrand = new ProductBrand();
            $ProductBrandList = $ProductBrand::where('child_category_id', $Request->child_category_id)->where('active', 1)->where('deleted_at_int', '!=', 0)->get();

            return Response::json([
                'status' => true, 
                'ProductBrandList' => $ProductBrandList
            ]);
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxProductBalanceUpdate(Request $Request) {
        if($Request->isMethod('POST')) {
            $messages = array(
                'required' => 'გთხოვთ აირჩიოთ ასატვირთი ფაილი',
            );

            $validator = Validator::make($Request->all(), [
                'excel_file' => 'required|max:255',
            ], $messages);

            if ($validator->fails()) {
                return Response::json(['status' => true, 'errors' => true, 'message' => $validator->getMessageBag()->toArray()], 200);
            } else {
                Excel::import(new ProductBalanceImport, $Request->excel_file);
                return Response::json(['status' => true, 'message' => 'ნაშთები წარმატებით განახლდა']);
            }
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxGetProductBalance(Request $Request) {
        if($Request->isMethod('GET') && !empty($Request->product_id)) {
            $Product = new Product();
            $ProductBalance = $Product::find($Request->product_id);

            if(!empty($ProductBalance)) {
                return Response::json([
                    'status' => true, 
                    'errors' => false, 
                    'ProductBalance' => $ProductBalance, 
                ]);
            } else {
                return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!']);
            }
        }
    }

    public function ajaxProductBaalanceUpdate(Request $Request) {
        if($Request->isMethod('POST') && !empty($Request->product_id) && $Request->product_id > 0) {
            $Product = new Product();
            $ProductBalance = $Product::find($Request->product_id)->update([
                'count' => $Request->product_count,
            ]);

            return Response::json([
                'status' => true, 
                'errors' => false, 
                'message' => 'პროდუქციის რაოდენობა წარმატებით შეიცვალა', 
            ]);
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxProductBalanceExport(Request $Request) {
        if($Request->isMethod('GET')) {
            return (new ProductBalanceExport())->download('balance.xlsx');
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxProductParentImport(Request $Request) {
        if($Request->isMethod('GET') && $Request->parent_id > 0) {
            $Product = new Product();
            $ProductData = $Product::find($Request->parent_id);

            $ProductCategory = new ProductCategory();
            $ProductChildCategoryList = $ProductCategory::where('parent_id', $ProductData->category_id)
                                                    ->where('deleted_at_int', '!=', 0)
                                                    ->orderBy('sortable', 'ASC')
                                                    ->get();

            $ProductBrand = new ProductBrand();
            $ProductBrandList = $ProductBrand::where('category_id', $ProductData->category_id)
                                                ->orWhere('category_id', 1)
                                                ->where('active', 1)
                                                ->where('deleted_at_int', '!=', 0)
                                                ->get();

            $ProductPrice = new ProductPrice();
            $ProductPriceData = $ProductPrice::where('product_id', $ProductData->id)->orderBy('id', 'DESC')->first();

            $ProductMeta = new ProductMeta();
            $ProductMetaData = $ProductMeta::where('product_id', $ProductData->id)->first();

            $ProductOption = new ProductOption();
            $ProductOptionList = $ProductOption::where('category_id', $ProductData->id)->orWhere('category_id', 1)
                                                ->where('active', 1)
                                                ->where('deleted_at_int', '!=', 0)
                                                ->get();

            $ProductOptionArray = [];

            foreach($ProductOptionList as $Key => $Value) {
                $ProductOptionValue = new ProductOptionValue();
                $ProductOptionValueList = $ProductOptionValue::where('option_id', $Value->id)->where('active', 1)
                                                ->where('deleted_at_int', '!=', 0)
                                                ->get();

                $ProductOptionItem = new ProductOptionItem();
                $ProductOptionItemList = $ProductOptionItem::where('product_id', $ProductData->id)->get();

                $ProductOptionArray[$Value->key] = [
                    'id' => $Value->id,
                    'type' => $Value->type,
                    'name' => $Value->name,
                    'options' => [],
                    'value' => [],
                ];

                foreach($ProductOptionValueList as $OptionValueItem) {
                    if($OptionValueItem->option_key == $Value->key) {
                        $ProductOptionArray[$Value->key]['options'][] = [
                            'id' => $OptionValueItem->id,
                            'name' => $OptionValueItem->name,
                            'option_key' => $OptionValueItem->option_key,
                            'option_id' => $OptionValueItem->option_id,
                        ];
                    }
                }

                foreach($ProductOptionItemList as $OptionItem) {
                    if($OptionItem->key == $Value->key) {
                        $ProductOptionArray[$Value->key]['value'] = $OptionItem->value;
                    }
                }
            }

            if(!empty($ProductData)) {
                return Response::json([
                    'status' => true, 
                    'ProductData' => $ProductData, 
                    'ProductChildCategoryList' => $ProductChildCategoryList,
                    'ProductBrandList' => $ProductBrandList,
                    'ProductPriceData' => $ProductPriceData,
                    'ProductMetaData' => $ProductMetaData,
                    'ProductOptionArray' => $ProductOptionArray,
                ]);
            } else {
                return Response::json(['status' => false, 'message' => 'პროდუქტი ვერ მოიძებნა']);
            }
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxProductSubmit(Request $Request) {
        if($Request->isMethod('POST')) {
            $messages = array(
                'required' => 'გთხოვთ შეიყვანოთ ყველა აუცილებელი ველი',
            );

            $validator = Validator::make($Request->all(), [
                'product_photo' => 'required|max:255',
            ], $messages);

            if ($validator->fails()) {
                return Response::json(['status' => true, 'errors' => true, 'message' => $validator->getMessageBag()->toArray()], 200);
            } else {

                $Product = new Product();
                $ProductData = $Product::updateOrCreate(
                    ['id' => $Request->product_id],
                    [
                        'id' => $Request->product_id,
                        'parent_id' => $Request->product_parent,
                        'name_ge' => $Request->product_name_ge,
                        'name_en' => $Request->product_name_en,
                        'category_id' => $Request->product_category,
                        'photo' => $Request->product_photo,
                        'child_category_id' => $Request->product_child_category,
                        'discount_price' => $Request->product_discount_price * 100,
                        'discount_percent' => $Request->product_discount_percent,
                        'brand_id' => $Request->product_brand,
                        'count' => $Request->product_count,
                        'stock' => $Request->product_in_stock,
                        'preorder' => $Request->product_preorder,
                    ],
                );

                $ProductMeta = new ProductMeta();
                $ProductMeta->product_id = $ProductData->id;

                $MetaKeywordsArray = [
                    'ge' => $Request->product_meta_keywords_ge,
                    'en' => $Request->product_meta_keywords_en,
                ];

                $MetaDescriptionArray = [
                    'ge' => $Request->product_meta_description_ge,
                    'en' => $Request->product_meta_description_en,
                ];

                $ProductMeta->keywords = json_encode($MetaKeywordsArray);
                $ProductMeta->description = json_encode($MetaDescriptionArray);
                $ProductMeta->save();

                $ProductPrice = new ProductPrice();
                $ProductPrice->product_id = $ProductData->id;
                $ProductPrice->price = $Request->product_price * 100;
                $ProductPrice->save();


                foreach($Request->product_option as $OptionKey => $OptionItem) {
                    $ProductOptionItem = new ProductOptionItem();
                    $ProductOptionItem->updateOrCreate(
                        [
                            'id' => $Request->product_option_id[$OptionKey]
                        ],
                        [
                            'id' => $Request->product_option_id[$OptionKey], 
                            'product_id' => $ProductData->id, 
                            'key' => $OptionKey, 
                            'value' => $OptionItem
                        ],
                    );
                }

                return Response::json(['status' => true, 'message' => 'პროდუქტი წარმატებით დაემატა']);
            }

        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxVendorsSubmit(Request $Request) {
        if($Request->isMethod('POST')) {
            $messages = array(
                'required' => 'გთხოვთ შეიყვანოთ ყველა აუცილებელი ველი',
            );
            $validator = Validator::make($Request->all(), [
                'vendor_name' => 'required|max:255',
                'vendor_code' => 'required|unique:new_product_vendors,code,'.$Request->vendor_id.'|max:50',
                'vendor_address' => 'required|max:255',
                'vendor_phone' => 'required|max:255',
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
                        'phone' => $Request->vendor_phone,
                        'address' => $Request->vendor_address,
                    ],
                );

                return Response::json(['status' => true, 'errors' => false, 'message' => 'მომწოდებელი წარმატებით შეინახა']);
            }
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxVendorsActive(Request $Request) {
        if($Request->isMethod('POST') && !empty($Request->vendor_id)) {

            if($Request->vendor_id != 1){
                $ProductVendor = new ProductVendor();
                $ProductVendor::find($Request->vendor_id)->update([
                    'active' => $Request->vandor_active,
                ]);

                return Response::json(['status' => true, 'errors' => false]);
            } else {
                return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!']);
            }

        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxVendorsDelete(Request $Request) {
        if($Request->isMethod('POST') && !empty($Request->vendor_id)) {

            if($Request->vendor_id != 1) {
                $ProductVendor = new ProductVendor();
                $ProductVendor::find($Request->vendor_id)->update([
                    'active' => 0,
                    'deleted_at' => Carbon::now(),
                    'deleted_at_int' => 0,
                ]);

                $Product = new Product();
                $Product::where('vendor_id', $Request->vendor_id)->update([
                    'vendor_id' => 1,
                ]);

                return Response::json(['status' => true, 'errors' => false, 'message' => 'მომწოდებელი წარმატებით წაიშალა']);
            } else {
                return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!']);
            }

        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxVendorsEdit(Request $Request) {
        if($Request->isMethod('GET') && $Request->vendor_id > 1) {

            $ProductVendor = new ProductVendor();
            $ProductVendorData = $ProductVendor::find($Request->vendor_id);

            return Response::json(['status' => true, 'errors' => false, 'ProductVendorData' => $ProductVendorData]);
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!']);
        }
    }
}
