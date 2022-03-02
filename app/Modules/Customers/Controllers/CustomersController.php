<?php

namespace App\Modules\Customers\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\Customers\Models\Customer;
use App\Modules\Customers\Models\Company;

class CustomersController extends Controller
{

    public function __construct() {
        //
    }

    public function actionCustomersIndex(Request $Request) {
        if (view()->exists('customers.customers_index')) {

            $Customer = new Customer();
            $CustomersList = $Customer::where('deleted_at_int', '!=', 0)->get();

            $Company = new Company();
            $CompanyList = $Company::where('deleted_at_int', '!=', 0)->get();

            $data = [
                'customers_list' => $CustomersList,
                'company_list' => $CompanyList,
            ];

            return view('customers.customers_index', $data);
        } else {
            abort('404');
        }
    }

    public function actionCustomersAdd() {
        if (view()->exists('customers.customers_add')) {

            $data = [];

            return view('customers.customers_add', $data);
        } else {
            abort('404');
        }
    }

    public function actionCustomersEdit(Request $Request) {
        if (view()->exists('customers.customers_edit')) {

            $data = [];

            return view('customers.customers_edit', $data);
        } else {
            abort('404');
        }
    }
}
