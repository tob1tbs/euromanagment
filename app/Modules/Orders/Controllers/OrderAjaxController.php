<?php

namespace App\Modules\Orders\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\Orders\Models\Order;
use App\Modules\Orders\Models\OrderItem;

class OrdersAjaxController extends Controller
{

    public function __construct() {
        //
    }

    public function ajaxOrderDelete(Request $Request) {
        
    }
}
