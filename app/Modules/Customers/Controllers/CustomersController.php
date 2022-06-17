<?php

namespace App\Modules\Customers\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\Customers\Models\Customer;
use App\Modules\Customers\Models\CustomerCompany;

class CustomersController extends Controller
{

    public function __construct() {
        //
    }

    public function actionCustomersIndex(Request $Request) {
        if (view()->exists('customers.customers_index')) {

            $Customer = new Customer();
            $CustomerList = $Customer::where('deleted_at_int', '!=', 0)->orderBy('id', 'DESC')->get();

            $CustomerCompany = new CustomerCompany();
            $CustomerCompanyList = $CustomerCompany::where('deleted_at_int', '!=', 0)->orderBy('id', 'DESC')->get();
            
            $CustomerArray = [];

            foreach($CustomerList as $CustomerItem) {
                if($CustomerItem->type == 1) {
                    $CustomerArray['type_1'][] = $CustomerItem;
                }

                if($CustomerItem->type == 2) {
                    $CustomerArray['type_2'][] = $CustomerItem;
                }
            }

            $CustomerArray['type_3'] = $CustomerCompanyList;

            $data = [
                'customers_list' => $CustomerArray  
            ];
            
            return view('customers.customers_index', $data);
        } else {
            abort('404');
        }
    }

    public function actionCustomerView(Request $Request) {
        if (view()->exists('customers.customers_view')) {

            $Customer = new Customer();
            $CustomerData = $Customer::findOrFail($Request->customer_id);

            $data = [
                'customer_data' => $CustomerData,  
            ];
            
            return view('customers.customers_view', $data);
        } else {
            abort('404');
        }
    }

    public function actionCustomersAdd(Request $Request) {
        if (view()->exists('customers.customers_add')) {

            $data = [
                'customers_fields' => $this->customerFields(),
            ];
            
            return view('customers.customers_add', $data);
        } else {
            abort('404');
        }
    }

    public function actionCustomersLoality(Request $Request) {
        if (view()->exists('customers.customers_loality')) {

            $data = [
                
            ];
            
            return view('customers.customers_loality', $data);
        } else {
            abort('404');
        }
    }
}
