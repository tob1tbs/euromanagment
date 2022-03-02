<?php

namespace App\Modules\Orders\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\Orders\Models\Order;
use App\Modules\Orders\Models\OrderAction;
use App\Modules\Products\Models\Product;

use Validator;
use Cart;
use Response;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class OrdersAjaxController extends Controller
{

    public function __construct() {
        //
    }

    public function ajaxAddToCart(Request $Request) {
        if($Request->isMethod('POST')) {

            if(empty($Request->product_id) OR $Request->product_id > 1) {
                return Response::json(['status' => true, 'errors' => false, 'notfound' => true, 'message' => 'გთხოვთ აირჩიოთ პროდუქტი !!!', 'CartCount' => count(Cart::getContent())]);
            } else {
                $Product = new Product();
                $ProductData = $Product::find($Request->product_id);

                if(empty($ProductData)) {
                    return Response::json(['status' => 'false', 'message' => 'პროდუქტი ვერ მოიძებნა']);
                } else {
                    
                }
            }
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxRemoveFromCart(Request $Request) {
        if($Request->isMethod('POST') AND !empty($Request->product_id) OR $Request->product_id > 0) {

            Cart::remove($Request->product_id);

            return Response::json([
                'status' => true, 
                'Cart' => Cart::getContent(), 
                'CartCount' => count(Cart::getContent()), 
                'CartTotal' => Cart::getTotal(), 
            ]);

        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxUpdateCart(Request $Request) {
        if($Request->isMethod('POST')) {

        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxCartClear(Request $Request) {
        if($Request->isMethod('POST')) {

        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxCustomerDataImport(Request $Request) {
        if($Request->isMethod('POST')) {

            $Customer = new Customer();
            $CustomerData = $Customer::find($Request->customer_id);

        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxOrderSubmit(Request $Request) {
        if($Request->isMethod('POST')) {

            $messages = array(
                'order_user_id.required' => 'გთხოვთ აირჩიოთ მომხმარებელი',
            );
            $validator = Validator::make($Request->all(), [
                'order_user_id' => 'required|max:10',
            ], $messages);

            if ($validator->fails()) {
                return Response::json(['status' => true, 'errors' => true, 'message' => $validator->getMessageBag()->toArray()]);
            }

            else if(count(Cart::getContent()) == 0) {
                return Response::json(['status' => true, 'errors' => true, 'message' => ['გთხოვთ აირჩიოთ პროდუქტი']]);
            }

            else {
                $Order = new Order();

                foreach(Cart::getContent() as $CartItem) {
                    $OrderItem = new OrderItem();
                }
                // TO DO
                Cart::clear();
                return Response::json(['status' => true, 'errors' => false, 'message' => 'შეკვეთა წარმატებით დაემატა !!!']);
            }

        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxOrderDelete(Request $Request) {
        if($Request->isMethod('POST') && !empty($Request->order_id)) {

            $Order = new Order();
            $Order::find($Request->order_id)->update([
                'deleted_at' => Carbon::now(),
                'deleted_at_int' => 0,
            ]);

            return Response::json(['status' => true, 'message' => 'შეკვეთა წარმატებით წაიშალა']);

        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxOrderStatusChange(Request $Request) {
        if($Request->isMethod('POST') && !empty($Request->order_id)) {

            $Order = new Order();
            $Order::find($Request->order_id)->update([
                'status' => $Request->order_status,
            ]);

            return Response::json(['status' => true, 'message' => 'შეკვეთა წარმატებით წაიშალა']);

        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxActionSubmit(Request $Request) {
        if($Request->isMethod('POST')) {

            $OrderAction = new OrderAction();
            $OrderActionData = $OrderAction::find($Request->action_id);

            switch ($OrderActionData->key) {
                case 'inner_transportation_overhead_import':
                dd("inner_transportation_overhead_import");
                break;                
                case 'send_to_courier':
                dd("send_to_courier");
                break;               
                case 'send_to_courier_2':
                dd("send_to_courier_2");
                break;
            default:
                return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
                break;
            }
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }
}
