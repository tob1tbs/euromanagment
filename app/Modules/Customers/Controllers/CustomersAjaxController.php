<?php

namespace App\Modules\Customers\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator;
use Response;
use Hash;

use App\Modules\Customers\Models\Customer;
use App\Modules\Customers\Models\Company;


class CustomersAjaxController extends Controller
{
    //
    public function ajaxCustomersSubmit(Request $Request) {
        if($Request->isMethod('POST')) {
            $messages = array(
                'required' => 'გთხოვთ შეავსოთ ყველა აუცილებელი ველი',
            );

            $customer_required = [
                'customer_name' => 'required|max:255',
                'customer_lastname' => 'required|max:255',
                'customer_personal_number' => 'required|unique:new_customers,personal_number,'.$Request->customer_id.'|max:11',
                'customer_bdate' => 'required|max:255',
                'customer_phone' => 'required|max:255',
                'customer_email' => 'required|max:255',
            ];

            $company_required = [
                'company_name' => 'required|max:255',
                'company_code' => 'required|max:255',
                'company_address' => 'required|max:255',
            ];

            $rule = [];

            $rule = array_merge($rule, $customer_required);

            if($Request->customer_type == 2) {
                $rule = array_merge($rule, $company_required);
            }

            $validator = Validator::make($Request->all(), $rule, $messages);

            if ($validator->fails()) {
                return Response::json(['status' => true, 'errors' => true, 'message' => $validator->getMessageBag()->toArray()], 200);
            } else {

                $Customer = new Customer();
                $CustomerData = $Customer::updateOrCreate(
                    ['id' => $Request->customer_id],
                    [
                        'id' => $Request->customer_id,
                        'name' => $Request->customer_name,
                        'lastname' => $Request->customer_lastname,
                        'personal_number' => $Request->customer_personal_number,
                        'bdate' => $Request->customer_bdate,
                        'phone' => $Request->customer_phone,
                        'email' => $Request->customer_email,
                        'type' => $Request->customer_type,
                        'password' => Hash::make('Password'),
                    ],
                );

                if($Request->customer_type == 2) {
                    $Company = new Company();
                    $Company::updateOrCreate(
                        ['id' => $Request->company_id],
                        [
                            'id' => $Request->company_id,        
                            'name' => $Request->company_name,        
                            'code' => $Request->company_code,        
                            'address' => $Request->company_address,        
                            'customer_id' => $CustomerData->id,        
                        ],
                    );
                }
                    
                return Response::json(['status' => true, 'message' => 'კლიენტი წარმატებით დაემატა', 'redirect' => route('actionCustomersIndex')]);
            }
        }
    }

    public function ajaxCustomersActiveChange(Request $Request) {
        if($Request->isMethod('POST') && !empty($Request->customer_id)) {
            $Customer = new Customer();
            $Customer::find($Request->customer_id)->update([
                'active' => $Request->customer_active,
            ]);
            return Response::json(['status' => true]);
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxCompanyActiveChange(Request $Request) {
        if($Request->isMethod('POST') && !empty($Request->company_id)) {
            $Company = new Company();
            $Company::find($Request->company_id)->update([
                'active' => $Request->company_active,
            ]);
            return Response::json(['status' => true]);
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }
}
