<?php

namespace App\Modules\Dashboard\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\Dashboard\Models\Dashboard;
use App\Modules\Customers\Models\Customer;

use App\Modules\Products\Models\Product;

use Validator;
use Response;
use Cart;

class DashboardAjaxController extends Controller
{

	public function __construct() {

	}

	public function ajaxGetCustomerFields(Request $Request) {
		if($Request->isMethod('GET') && !empty($Request->customer_type)) {

			$Customer = new Customer();
			$CustomerList = $Customer::where('type_id', $Request->customer_type)->where('deleted_at_int', '!=', 0)->where('active', 1)->get();

			return Response::json([
				'status' => true, 
				'CustomerFieldList' => $CustomerFieldList,
				'CustomerList' => $CustomerList,
			]);

		} else {
			return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!'], 200);
		}
	}

	public function ajaxGetProductsList(Request $Request) {
		if($Request->isMethod('GET')) {
			
			if($Request->has('search_query') && !empty($Request->search_query)) {
				$Product = new Product();
				$ProductList = $Product::where('deleted_at_int', '!=', 0)->where('active', 1);
			
			 	$ProductList->where(function($query) use ($Request) {
               		$query->where('id', 'like', '%'.$Request->search_query.'%');
                	$query->orWhere('name', 'like', '%'.$Request->search_query.'%');
            	});

				$ProductList = $ProductList->get()
				->load('productPrice')
				->load('productUnit');
            }

			return Response::json(['status' => true, 'ProductList' => $ProductList]);
		} else {
			return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!'], 200);
		}
	}

	public function ajaxGetProductData(Request $Request) {
		if($Request->isMethod('GEt') && !empty($Request->product_id)) {
			$Product = new Product();
			$ProductData = $Product::find($Request->product_id)->load('productPrice')->load('productUnit');

			return Response::json(['status' => true, 'ProductData' => $ProductData]);
		} else {
			return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!'], 200);
		}
	}

	public function ajaxAddToCart(Request $Request) {
		if($Request->isMethod('POST')) {
			$Product = new Product();
			$ProductData = $Product::find($Request->product_id)->load('productPrice')->load('productUnit');
			Cart::add([
				'id' => $ProductData->id,
				'name' => $ProductData->name,
				'price' => $ProductData->productPrice[0]->retail_price,
				'quantity' => 1,
				'attributes' => [
					'unit' => $ProductData->productUnit->name,
					'wholesale_price' => $ProductData->productPrice[0]->wholesale_price,
				],
			]);

			$CartData = Cart::getContent();
			return Response::json(['status' => true, 'CartData' => Cart::getContent()]);
		} else {
			return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!'], 200);
		}
	}

	public function ajaxCartClear(Request $Request) {
		if($Request->isMethod('POST')) {

			Cart::clear();

			return Response::json(['status' => true]);

		} else {
			return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!'], 200);
		}
	}

	public function ajaxGetCustomerData(Request $Request) {
		if($Request->isMethod('GET')) {
			$messages = array(
                'required' => 'გთხოვთ აირჩიოთ ყველა აუცილებელი ველი.',
                'customer_type.not_in' => 'გთხოვთ აირჩიოთ ყველა აუცილებელი ველი.',
            );
            $validator = Validator::make($Request->all(), [
                'customer_type' => 'required|max:255|not_in:0',
                'customer_code' => 'required|max:255',
            ], $messages);

            if ($validator->fails()) {
                return Response::json(['status' => true, 'errors' => true, 'message' => $validator->getMessageBag()->toArray()], 200);
            } else {

            	$Customer = new Customer();
            	$CustomerData = $Customer::where('code', $Request->customer_code)->where('type', $Request->customer_type)->where('active', 1)->where('deleted_at_int', '!=', 0)->first();

            	if(empty($CustomerData)) {
            		return Response::json(['status' => true, 'errors' => true, 'message' => [0 => 'აღნიშნული მომხმარებელი ვერ მოიძებნა.']]);
            	} else {
            		return Response::json(['status' => true, 'errors' => false, 'CustomerData' => $CustomerData]);
            	}

            }
		} else {
			return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!'], 200);
		}
	} 

	public function ajaxDashboardSubmit(Request $Request) {
		if($Request->isMethod('POST')) {

		} else {
			return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!'], 200);
		}
	}
}
