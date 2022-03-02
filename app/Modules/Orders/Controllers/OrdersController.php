<?php

namespace App\Modules\Orders\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\Orders\Models\Order;
use App\Modules\Orders\Models\OrderStatus;
use App\Modules\Orders\Models\OrderItem;
use App\Modules\Orders\Models\OrderAction;

class OrdersController extends Controller
{

    public function __construct() {
        //
    }

    public function actionOrdersIndex(Request $Request) {
        if (view()->exists('orders.orders_index')) {

            $OrderAction = new OrderAction();
            $OrderActionList = $OrderAction::where('deleted_at_int', '!=', 0)->where('active', 1)->get();

            $Order = new Order();
            $OrderList = $Order::where('deleted_at_int', '!=', 0)->get();

            $data = [
                'order_list' => $OrderList,
                'order_action_list' => $OrderActionList,
            ];

            return view('orders.orders_index', $data);
        } else {
            abort('404');
        }
    }

    public function actionOrdersAdd() {
        if (view()->exists('orders.orders_add')) {

            $data = [
            ];

            return view('orders.orders_add', $data);
        } else {
            abort('404');
        }
    }

    public function actionOrdersEdit(Request $Request) {
        if (view()->exists('orders.orders_edit')) {

            $Order = new Order();
            $OrderData = $Order::find($Request->order_id);

            $data = [
            ];

            return view('orders.orders_edit', $data);
        } else {
            abort('404');
        }
    }

    public function actionOrdersView(Request $Request) {
        if (view()->exists('orders.orders_view')) {

            $Order = new Order();
            $OrderData = $Order::find($Request->order_id);

            $data = [
            ];

            return view('orders.orders_view', $data);
        } else {
            abort('404');
        }
    }
}
