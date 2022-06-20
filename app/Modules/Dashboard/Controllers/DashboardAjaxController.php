<?php

namespace App\Modules\Dashboard\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\Dashboard\Models\Dashboard;
use App\Modules\Customers\Models\Customer;
use App\Modules\Customers\Models\CustomerCompany;

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

			dd("asdasdasd");

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
			
			switch ($Request->customer_type) {
				case '1':
					$Customer = new Customer();
					$CustomerData = $Customer::where('type', 1)->where('personal_id', $Request->customer_code)->first();

					if(!empty($CustomerData)) {
						return Response::json(['status' => true, 'type' => 1, 'CustomerData' => $CustomerData]);
					} else {
						return Response::json(['status' => true, 'errors' => true, 'message' => [0 => 'კლიენტი აღნიშნული პირადი ნომრით ან საიდენტიფიკაციო კოდით ვერ მოიძებნა.']]);
					}
				break;
				case '2':
					if(strlen($Request->customer_code) == 11) {
						$Customer = new Customer();
						$CustomerData = $Customer::where('type', 2)->where('personal_id', $Request->customer_code)->first();

						if(!empty($CustomerData)) {
							return Response::json(['status' => true, 'type' => 2, 'CustomerData' => $CustomerData]);
						} else {
							return Response::json(['status' => true, 'errors' => true, 'message' => [0 => 'კლიენტი აღნიშნული პირადი ნომრით ან საიდენტიფიკაციო კოდით ვერ მოიძებნა.']]);
						}
					} 

					else if(strlen($Request->customer_code) == 9) {
						$CustomerCompany = new CustomerCompany();
						$CustomerData = $CustomerCompany::where('code', $Request->customer_code)->first();

						if(!empty($CustomerData)) {
							return Response::json(['status' => true, 'type' => 3, 'CustomerData' => $CustomerData]);
						} else {
							return Response::json(['status' => true, 'errors' => true, 'message' => [0 => 'კლიენტი აღნიშნული პირადი ნომრით ან საიდენტიფიკაციო კოდით ვერ მოიძებნა.']]);
						}
					}
				break;
			}

		} else {
			return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!'], 200);
		}
	} 

	public function ajaxCartRemove(Request $Request) {
		if($Request->isMethod('POST')) {
			Cart::remove($Request->item_id);

			return Response::json(['status' => true, 'CartData' => Cart::getContent()]);
		} else {
			return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!'], 200);
		}
	}

	public function ajaxCartUpdateQuantity(Request $Request) {
		if($Request->isMethod('POST')) {

			Cart::update($Request->item_id, array(
			  	'quantity' => array(
			      	'relative' => false,
			      	'value' => $Request->quantity,
			  	),
			));

			return Response::json(['status' => true, 'CartData' => Cart::getContent()]);
		} else {
			return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!'], 200);
		}
	}

	public function ajaxDashboardSubmit(Request $Request) {
		if($Request->isMethod('POST')) {
			dd($Request->all());
		} else {
			return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!'], 200);
		}
	}
}
