<?php

namespace App\Modules\Dashboard\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\Dashboard\Models\Dashboard;
use App\Modules\Customers\Models\CustomerField;

use Response;

class DashboardAjaxController extends Controller
{

	public function __construct() {

	}

	public function ajaxGetCustomerFields(Request $Request) {
		if($Request->isMethod('GET') && !empty($Request->type_id)) {

			$CustomerField = new CustomerField();
			$CustomerFieldList = $CustomerField::where('type_id', $Request->type_id)->where('deleted_at_int', '!=', 0)->where('active', 1)->first();

			$Customer = new Customer();
			$CustomerList = $Customer::where('type_id', $Request->type_id)->where('deleted_at_int', '!=', 0)->where('active', 1)->get();

			return Response::json([
				'status' => true, 
				'CustomerFieldList' => $CustomerFieldList,
				'CustomerList' => $CustomerList,
			]);

		} else {
			return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!'], 200);
		}
	}

	public function ajaxGetCustomerData(Request $Request) {
		if($Request->isMethod('GET') && !empty($Request->customer_id)) {
			
			$Customer = new Customer();
			$CustomerData = $Customer::find($Request->customer_id);

			return Response::json([
				'status' => true, 
				'CustomerData' => $CustomerData,
			]);

		} else {
			return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!'], 200);
		}
	}

	public function ajaxGetProductByFields(Request $Request) {
		if($Request->isMethod('GET')) {
			$Product = new Product();
			$ProductList = $Product::where('deleted_at_int', '!=', 0)->where('active', 1);

			if($Request->has('category_id') && $Request->category_id > 0) {
				$ProductList = $ProductList->where('category_id', $Request->category_id);
			}

			if($Request->has('brand_id') && $Request->brand_id > 0) {
				$ProductList = $ProductList->where('brand_id', $Request->brand_id);
			}

			if($Request->has('vendor_id') && $Request->vendor_id > 0) {
				$ProductList = $ProductList->where('vendor_id', $Request->vendor_id);
			}

			$ProductList = $ProductList->get();

			return Response::json(['status' => true, 'ProductList' => $ProductList]);
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
