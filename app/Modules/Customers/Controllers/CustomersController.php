<?php

namespace App\Modules\Customers\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\Customers\Models\Customer;

class CustomersController extends Controller
{

    public function __construct() {
        //
    }

    public function actionCustomersIndex(Request $Request) {
        if (view()->exists('customers.customers_index')) {

            $data = [
                
            ];
            
            return view('customers.customers_index', $data);
        } else {
            abort('404');
        }
    }

    public function actionCustomersAdd(Request $Request) {
        if (view()->exists('customers.customers_add')) {

            $data = [
                
            ];
            
            return view('customers.customers_add', $data);
        } else {
            abort('404');
        }
    }
}
