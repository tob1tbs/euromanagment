<?php

namespace App\Modules\Customers\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\Customers\Models\Customer;
use App\Modules\Customers\Models\CustomerCompany;
use App\Modules\Customers\Models\ReferalOrderLog;
use App\Modules\Customers\Models\Referal;
use App\Modules\Customers\Models\ReferalOrder;

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

            $Referal = new Referal();
            $ReferalList = $Referal::where('deleted_at_int', '!=', 0)->get();

            $data = [
                'referal_list' => $ReferalList,
            ];
            
            return view('customers.customers_loality', $data);
        } else {
            abort('404');
        }
    }

    public function actionCustomersLoalityView(Request $Request) {
        if (view()->exists('customers.customers_loality_view')) {

            $Referal = new Referal();
            $ReferalData = $Referal::find($Request->referal_id);

            $ReferalOrder = new ReferalOrder();
            $ReferalOrderList = $ReferalOrder::where('referal_id', $Request->referal_id)->where('referal_id', $Request->referal_id)->where('deleted_at_int', '!=', 0)->get();

            $Customer = new Customer();
            $CustomerList = $Customer::where('deleted_at_int', '!=', 0)->where('referal_id', $Request->referal_id)->orderBy('id', 'DESC')->orderBy('id', 'DESC')->get();

            $CustomerCompany = new CustomerCompany();
            $CustomerCompanyList = $CustomerCompany::where('deleted_at_int', '!=', 0)->orderBy('id', 'DESC')->get();

            $CustomerArray = [];

            foreach($CustomerList->toArray() as $CustomerItem) {
                if($CustomerItem['type'] == 1) {
                    $CustomerArray['type_1'][] = $CustomerItem;
                }

                if($CustomerItem['type'] == 2) {
                    $CustomerArray['type_2'][] = $CustomerItem;
                }
            }

            $CustomerArray['type_3'] = $CustomerCompanyList->toArray();

            $data = [
                'referal_data' => $ReferalData,
                'referal_order_list' => $ReferalOrderList,
                'customers_list' => $CustomerArray,
            ];
            
            return view('customers.customers_loality_view', $data);
        } else {
            abort('404');
        }
    }
}
