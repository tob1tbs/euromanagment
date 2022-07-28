<?php

namespace App\Modules\Dashboard\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\Dashboard\Models\Dashboard;
use App\Modules\Dashboard\Models\DashboardOrder;
use App\Modules\Dashboard\Models\DashboardOrderOverhead;
use App\Modules\Dashboard\Models\DashboardOrderItem;
use App\Modules\Customers\Models\Customer;
use App\Modules\Customers\Models\CustomerCompany;

use App\Modules\Products\Models\Product;

use App\Modules\Services\Controllers\ServiceMailController;
use App\Modules\Services\Controllers\ServiceRsController;

use \Carbon\Carbon;
use Validator;
use Response;
use Cart;
use Auth;

class DashboardAjaxController extends Controller
{

	public function __construct() {

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

			return Response::json(['status' => true, 'CartData' => Cart::getContent(), 'total_quantity' => Cart::getTotalQuantity(), 'cart_total' => Cart::getTotal() / 100]);
		} else {
			return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!'], 200);
		}
	}

	public function ajaxCartClear(Request $Request) {
		if($Request->isMethod('POST')) {

			Cart::clear();

			return Response::json(['status' => true, 'total_quantity' => Cart::getTotalQuantity()]);

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

			return Response::json(['status' => true, 'CartData' => Cart::getContent(), 'total_quantity' => Cart::getTotalQuantity(), 'cart_total' => Cart::getTotal() / 100]);
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

			$Product = new Product();
			$ProductData = $Product::find($Request->item_id)->load('productPrice')->load('productUnit');

			return Response::json(['status' => true, 'item_total_price' => ($Request->quantity * $ProductData->productPrice[0]->retail_price) / 100, 'quantity' => $Request->quantity, 'total_quantity' => Cart::getTotalQuantity(), 'cart_total' => Cart::getTotal() / 100]);
		} else {
			return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!'], 200);
		}
	}

	public function ajaxDashboardSubmit(Request $Request) {
		if($Request->isMethod('POST')) {
			if($Request->has('customer_id') && empty($Request->customer_id)) {
				return Response::json(['status' => true, 'errors' => true, 'message' => [0 => 'გთხოვთ აირჩიოთ მომხმარებელი!']]);
			}

			else if(Cart::getTotalQuantity() < 1) {
				return Response::json(['status' => true, 'errors' => true, 'message' => [0 => 'გთხოვთ აირჩიოთ პროდუქცია!']]);
			}

			else {
				$DashboardOrder = new DashboardOrder();
				$DashboardOrderData = $DashboardOrder::updateOrCreate(
					['id' => $Request->order_id],
					[
						'id' => $Request->order_id,
						'customer_type' => $Request->customer_type,
						'customer_id' => $Request->customer_id,
						'total_price' => Cart::getTotal(),
						'created_by' => Auth::user()->id,
					],
				);

				foreach(Cart::getContent() as $v) {
					$DashboardOrderItem = new DashboardOrderItem();
					$DashboardOrderItem->item_id = $v->id;
					$DashboardOrderItem->order_id = $DashboardOrderData->id;
					$DashboardOrderItem->price = $v->price;
					$DashboardOrderItem->quantity = $v->quantity;
					$DashboardOrderItem->save();

					$Product = new Product();
					$ProductData = $Product::find($v->id);
					$ProductCount = $ProductData->count;
					$ProductData->update(['count' => $ProductCount - $v->quantity]);
				}

				Cart::clear();

				return Response::json(['status' => true, 'errors' => false, 'message' => [0 => 'შეკვეთა წარმატებით გაფორმდა'], 'redirect_url' => route('actionDashboardOrders')]);
			}
		} else {
			return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!'], 200);
		}
	}

	public function ajaxOrderReject(Request $Request, ServiceRsController $ServiceRsController) {
		if($Request->isMethod('POST') && !empty($Request->order_id)) {
			$DashboardOrder = new DashboardOrder();
			$DashboardOrderData = $DashboardOrder::find($Request->order_id)->update([
				'status' => 5,
				'deleted_at_int' => 0,
				'rs_send' => 2,
				'deleted_at' => Carbon::now(),
			]);

			$DashboardOrderItem = new DashboardOrderItem();
			$DashboardOrderItemList = $DashboardOrderItem::where('order_id', $Request->order_id)->get();

			foreach($DashboardOrderItemList as $Item) {
				$DashboardOrderItem::find($Item->id)->update([
					'deleted_at_int' => 0,
					'deleted_at' => Carbon::now(),
				]);

				$Product = new Product();
				$ProductData = $Product::find($Item->item_id);
				$ProductCount = $ProductData->count;
				$ProductData->update(['count' => $ProductCount + $Item->quantity]);
			}


			$DashboardOrderOverhead = new DashboardOrderOverhead();
			$DashboardOrderOverhead::where('order_id', $Request->order_id)->update([
				'status' => 2,
				'deleted_at' => Carbon::now(),
				'deleted_by' => Auth::user()->id,
			]);

			$DashboardOrderOverheadData = $DashboardOrderOverhead::where('order_id', $Request->order_id)->get();
			
			foreach($DashboardOrderOverheadData as $Item) {
				$ServiceRsController->serviceRsCancelOverhead($Item->rs_id);
			}

			return Response::json(['status' => true, 'errors' => false, 'message' => 'შეკვეთა წარმატებით გაუქმდა']);
		} else {
			return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!'], 200);
		}
	}

	public function ajaxOrderGet(Request $Request) {
		if($Request->isMethod('GET') && !empty($Request->order_id)) {
			$DashboardOrder = new DashboardOrder();
			$DashboardOrderData = $DashboardOrder::find($Request->order_id);

			if($DashboardOrderData->status == 1) {
				$DashboardOrderData->update(['status' => 2]);
			}

			$DashboardOrderData = $DashboardOrder::find($Request->order_id)->load('orderItems.orderItemData')->load('orderItems.orderItemData.productUnit')->load('customerType')->load('customerCompany');

			$DashboardOrderOverhead = new DashboardOrderOverhead();
			$DashboardOrderOverheadList = $DashboardOrderOverhead->where('order_id', $Request->order_id)->get()->load(['deletedBy', 'createdBy']);

			if(!empty($DashboardOrderData)) {
				return Response::json([
					'status' => true,  
					'DashboardOrderData' => $DashboardOrderData, 
					'DashboardOrderOverheadList' => $DashboardOrderOverheadList
				]);
			}
		}
	}

	public function ajaxOrderOveheadSend(Request $Request, ServiceRsController $ServiceRsController) {

		if($Request->isMethod('POST')) {

			if(empty($Request->item_rs)) {
				return Response::json(['status' => true, 'errors' => true, 'message' => 'გთხოვთ აირჩიოთ ზედნადებში ასატვირთი პროდუქცია.'], 200);
			}

			$OverheadItems = [];

			$DashboardOrder = new DashboardOrder();
			$DashboardOrderData = $DashboardOrder::find($Request->order_id)->load('customerType')->load('customerCompany');
			
			foreach($Request->item_rs as $key => $item) {
				$DashboardOrderItem = new DashboardOrderItem();
				$DashboardOrderItemData = $DashboardOrderItem::where('order_id', $Request->order_id)->where('id', $key)->first();

				$OverheadItems[$key] = [
					'name' => $DashboardOrderItemData->orderItemData->name,
					'quantity' => $DashboardOrderItemData->quantity,
					'price' => $DashboardOrderItemData->price / 100,
					'unit' => $DashboardOrderItemData->orderItemData->productUnit->name,
				];
			}

			if(empty($Request->send_overhead_type)) {
				return Response::json(['status' => true, 'errors' => true, 'message' => 'გთხოვთ აირჩიოთ ზედნადებში ტიპი.'], 200);
			}

			if(empty($Request->send_overhead_category) OR $Request->send_overhead_category == 0) {
				return Response::json(['status' => true, 'errors' => true, 'message' => 'გთხოვთ აირჩიოთ ზედნადების კატეგორია.'], 200);
			} 

			$DashboardOrderOverhead = new DashboardOrderOverhead();

			if($Request->send_overhead_category == 1) {

				switch ($Request->send_overhead_type) {
					case '1':
						
						if(empty($Request->send_overhead_start_address)) {
							return Response::json(['status' => true, 'errors' => true, 'message' => 'გთხოვთ შეიყვანოთ ტრანსპორტირების დაწყების ადგილი.'], 200);
						} 

						else if(empty($Request->send_overhead_end_address)) {
							return Response::json(['status' => true, 'errors' => true, 'message' => 'გთხოვთ შეიყვანოთ ტრანსპორტირების დასრულების ადგილი.'], 200);
						} 

						else if(empty($Request->send_overhead_driver)) {
							return Response::json(['status' => true, 'errors' => true, 'message' => 'გთხოვთ შეიყვანოთ მძღოლის პირადი ნომერი.'], 200);
						} 

						else if(empty($Request->send_overhead_car)) {
							return Response::json(['status' => true, 'errors' => true, 'message' => 'გთხოვთ შეიყვანოთ ავტომანქანის.'], 200);
						} 

						else {

							$AddressData = ['start' => $Request->send_overhead_start_address, 'end' => $Request->send_overhead_end_address];
							$DriverData = ['driver_personal_number' => $Request->send_overhead_driver, 'driver_data' => '', 'car_number' => $Request->send_overhead_car];

							$DashboardOrderOverhead->address = json_encode($AddressData);
							$DashboardOrderOverhead->driver_data = json_encode($DriverData);

							$RsData = $ServiceRsController->serviceSendRsOverheadTransporter(
								json_encode($OverheadItems, JSON_UNESCAPED_UNICODE), 
								json_encode($AddressData, JSON_UNESCAPED_UNICODE), 
								json_encode($DriverData, JSON_UNESCAPED_UNICODE), 
								json_encode($DashboardOrderData, JSON_UNESCAPED_UNICODE), 
							);
							$OverheadId = $RsData->Body->save_waybillResponse->save_waybillResult->RESULT->ID;
							$RsResponse = $ServiceRsController->serviceRsSendWaybillTransporter($OverheadId);
							$OverheadNumber = $RsResponse->Body->send_waybillResponse->send_waybillResult;
						}
					break;
					case '2':
						$RsData = $ServiceRsController->serviceSendRsOverhead(
							json_encode($OverheadItems, JSON_UNESCAPED_UNICODE), 
							json_encode($DashboardOrderData, JSON_UNESCAPED_UNICODE), 
						);
						$OverheadId = $RsData->Body->save_waybillResponse->save_waybillResult->RESULT->ID;
						$RsResponse = $ServiceRsController->serviceRsSendWaybillTransporter($OverheadId);
						$OverheadNumber = $RsResponse->Body->send_waybillResponse->send_waybillResult;
					break;
					case '4':
						if(empty($Request->send_overhead_start_address)) {
							return Response::json(['status' => true, 'errors' => true, 'message' => 'გთხოვთ შეიყვანოთ ტრანსპორტირების დაწყების ადგილი.'], 200);
						} 

						else if(empty($Request->send_overhead_end_address)) {
							return Response::json(['status' => true, 'errors' => true, 'message' => 'გთხოვთ შეიყვანოთ ტრანსპორტირების დასრულების ადგილი.'], 200);
						} 

						else if(empty($Request->send_overhead_driver)) {
							return Response::json(['status' => true, 'errors' => true, 'message' => 'გთხოვთ შეიყვანოთ მძღოლის პირადი ნომერი.'], 200);
						} 

						else if(empty($Request->send_overhead_car)) {
							return Response::json(['status' => true, 'errors' => true, 'message' => 'გთხოვთ შეიყვანოთ ავტომანქანის.'], 200);
						} 

						else {

							$AddressData = ['start' => $Request->send_overhead_start_address, 'end' => $Request->send_overhead_end_address];
							$DriverData = ['driver_personal_number' => $Request->send_overhead_driver, 'driver_data' => '', 'car_number' => $Request->send_overhead_car];

							$DashboardOrderOverhead->address = json_encode($AddressData);
							$DashboardOrderOverhead->driver_data = json_encode($DriverData);

							$RsData = $ServiceRsController->serviceSendRsOverheadReturn(
								json_encode($OverheadItems, JSON_UNESCAPED_UNICODE), 
								json_encode($AddressData, JSON_UNESCAPED_UNICODE), 
								json_encode($DriverData, JSON_UNESCAPED_UNICODE), 
								json_encode($DashboardOrderData, JSON_UNESCAPED_UNICODE), 
							);
							$OverheadId = $RsData->Body->save_waybillResponse->save_waybillResult->RESULT->ID;
							$RsResponse = $ServiceRsController->serviceRsSendWaybillTransporter($OverheadId);
							$OverheadNumber = $RsResponse->Body->send_waybillResponse->send_waybillResult;
						}
					break;
				}
			}

			$DashboardOrderOverhead->overhead_id = $OverheadNumber;
			$DashboardOrderOverhead->order_id = $Request->order_id;
			$DashboardOrderOverhead->data = json_encode($OverheadItems);
			$DashboardOrderOverhead->status = 1;
			$DashboardOrderOverhead->type = $Request->send_overhead_type;
			$DashboardOrderOverhead->rs_id = $OverheadId;
			$DashboardOrderOverhead->response = $RsResponse;
			$DashboardOrderOverhead->category = $Request->send_overhead_category;
			$DashboardOrderOverhead->created_by = Auth::user()->id;

			$DashboardOrderOverhead->save();

			$DashboardOrder = new DashboardOrder();
			$DashboardOrderData = $DashboardOrder::find($Request->order_id)->update([
				'rs_send' => 1,
				'status' => 3,
			]);

			return Response::json(['status' => true, 'errors' => false, 'message' => 'ზედნადები აიტვირთა.']);
		} else {
			return Response::json(['status' => false, 'errors' => true, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!'], 200);
		}
	}

	public function ajaxOrderOveheadCancel(Request $Request, ServiceRsController $ServiceRsController) {
		if($Request->isMethod('POST')) {

			$DashboardOrder = new DashboardOrder();
			$DashboardOrderData = $DashboardOrder::find($Request->order_id)->update(['rs_send' => 2]);


			$DashboardOrderOverhead = new DashboardOrderOverhead();
			$DashboardOrderOverhead::where('overhead_id', 'LIKE', '%'.$Request->overhead_id.'%')->update([
				'status' => 2,
				'deleted_at' => Carbon::now(),
				'deleted_by' => Auth::user()->id,
			]);

			$DashboardOrderOverheadData = $DashboardOrderOverhead::where('overhead_id', 'LIKE', '%'.$Request->overhead_id.'%')->first();
			$ServiceRsController->serviceRsCancelOverhead($DashboardOrderOverheadData->rs_id);


			return Response::json(['status' => true, 'message' => 'ზედნადები გაუქმდა.']);

		} else {
			return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!'], 200);
		}
	}

	public function ajaxViewSendOverhead(Request $Request) {
		if($Request->isMethod('GET')) {

			$DashboardOrderOverhead = new DashboardOrderOverhead();
			$DashboardOrderOverheadData = $DashboardOrderOverhead::find($Request->overhead_id);

			if(!empty($DashboardOrderOverheadData)) {
				return Response::json([
					'status' => true, 
					'OverheadData' => $DashboardOrderOverheadData, 
					'OverheadType' => $this->overheadType(), 
					'OverheadCategory' => $this->overheadCategory(),
				]);
			} else {
				return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!'], 200);
			}

		} else {
			return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!'], 200);
		}
	}

	public function ajaxOrderClose(Request $Request) {
		if($Request->isMethod('POST') && !empty($Request->order_id)) {
			$DashboardOrder = new DashboardOrder();
			$DashboardOrderData = $DashboardOrder::find($Request->order_id);

			$DashboardOrderOverhead = new DashboardOrderOverhead();
			$DashboardOrderOverheadData = $DashboardOrderOverhead::where('order_id', $Request->order_id)->first();

			dd($DashboardOrderOverheadData);

			if($DashboardOrderData->rs_send == 2 OR $DashboardOrderData->rs_send == 0) {
				return Response::json(['status' => false, 'message' => 'აღნიშნულ შეკვეთაზე ზედნადები გაუქმებულია ან არ არის ატვირთული!!!']);
			}

			$DashboardOrderData->update(['status' => 4]);
			
			return Response::json(['status' => true, 'message' => 'შეკვეთა წარმატებით დაიხურა !!!'], 200);
		} else {
			return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!'], 200);
		}
	}
}
