<?php

namespace App\Modules\Customers\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\Customers\Models\Customer;
use App\Modules\Customers\Models\CustomerCompany;

use Response;
use Validator;

class CustomersAjaxController extends Controller
{

    public function __construct() {
        //
    }

    public function ajaxGetFields(Request $Request) {
        if($Request->isMethod('GET')) {
        	$customer_fields = $this->customerFields();
        	
        	if(!empty($Request->customer_type_id) && $Request->customer_type_id == 1) {
    			return Response::json(['status' => true,  'customer_type_id' => 1, 'customer_fields' => $customer_fields['fields']['type_1']]);
        	}

    		else if(!empty($Request->customer_type_id) && $Request->customer_type_id == 2) {
    			return Response::json(['status' => true, 'customer_type_id' => 2, 'customer_fields' => $customer_fields['company_type']]);
    		}

        } else {
        	return Response::json(['status' => false]);
        }
    }

    public function ajaxGetFieldsLegal(Request $Request) {
        if($Request->isMethod('GET')) {
            $customer_fields = $this->customerFields();
            
            if(!empty($Request->customer_type_id) && $Request->customer_type_id == 2) {
                return Response::json(['status' => true,  'customer_type_id' => 1, 'customer_fields' => $customer_fields['fields']['type_2']['customer_type_'.$Request->customer_type_legal_id]]);
            }

        } else {
            return Response::json(['status' => false]);
        }
    }

    public function ajaxSubmit(Request $Request) {
        if($Request->isMethod('POST')) {
            if($Request->customer_type > 0) {
                switch ($Request->customer_type) {
                    case '1':
                    $messages = array(
                        'required' => 'გთხოვთ შეავსოთ ყველა აუცილებელი ველი',
                        'customer_personal_id.unique' => 'კლიენტი აღნიშნული პირადი ნომრით უკვე არსებობს.',
                        'customer_phone.unique' => 'კლიენტი აღნიშნული ტელეფონის ნომრით უკვე არსებობს.',
                        'customer_email.unique' => 'კლიენტი აღნიშნული ელფოსტით უკვე არსებობს.',
                    );
                    $validator = Validator::make($Request->all(), [
                        'customer_name' => 'required|max:255',
                        'customer_lastname' => 'required|max:255',
                        'customer_personal_id' => 'required|unique:new_customers,personal_id,'.$Request->customer_id.'|max:255',
                        'customer_phone' => 'required|unique:new_customers,phone,'.$Request->customer_id.'|max:255',
                        'customer_email' => 'required|unique:new_customers,email,'.$Request->customer_id.'|max:255',
                        'customer_address' => 'required|max:255',
                    ], $messages);

                    if ($validator->fails()) {
                        return Response::json(['status' => true, 'errors' => true, 'message' => $validator->getMessageBag()->toArray()], 200);
                    } else {
                        $Customer = new Customer();
                        $Customer::updateOrCreate(
                            ['id' => $Request->customer_id],
                            [
                                'id' => $Request->customer_id,
                                'type' => $Request->customer_type,
                                'name' => $Request->customer_name,
                                'lastname' => $Request->customer_lastname,
                                'personal_id' => $Request->customer_personal_id,
                                'phone' => $Request->customer_phone,
                                'email' => $Request->customer_email,
                                'address' => $Request->customer_address,
                            ],
                        );
                        return Response::json(['status' => true , 'message' => [0 => 'კლიენტის მონაცემები შენახულია'], 'redirect_url' => route('actionCustomersIndex')]);
                    }
                    break;
                    case '2':
                        if($Request->customer_type_legal > 0) {
                            if($Request->customer_type_legal == 1) {
                                $messages = array(
                                    'required' => 'გთხოვთ შეავსოთ ყველა აუცილებელი ველი',
                                    'company_code.required' => 'კომპანია აღნიშნული საიდენტიფიკაციო კოდით უკვე არსებობს.',
                                );
                                $validator = Validator::make($Request->all(), [
                                    'company_name' => 'required|max:255',
                                    'company_code' => 'required|unique:new_customer_companies,code,'.$Request->company_id.'|max:255',
                                    'company_address' => 'required|max:255',
                                    'company_contact' => 'required|max:255',
                                    'company_email' => 'required|max:255',
                                    'company_phone' => 'required|max:255',
                                ], $messages);

                                if ($validator->fails()) {
                                    return Response::json(['status' => true, 'errors' => true, 'message' => $validator->getMessageBag()->toArray()], 200);
                                } else {
                                    $CustomerCompany = new CustomerCompany();
                                    $CustomerCompany::updateOrCreate(
                                        ['id' => $Request->company_id],
                                        [
                                            'id' => $Request->company_id,
                                            'name' => $Request->company_name,
                                            'code' => $Request->company_code,
                                            'address' => $Request->company_address,
                                            'contact' => $Request->company_contact,
                                            'email' => $Request->company_email,
                                            'phone' => $Request->company_phone,
                                        ],
                                    );

                                    return Response::json(['status' => true , 'message' => [0 => 'კლიენტის მონაცემები შენახულია'], 'redirect_url' => route('actionCustomersIndex')]);
                                }
                            } else {
                                $messages = array(
                                    'required' => 'გთხოვთ შეავსოთ ყველა აუცილებელი ველი',
                                    'customer_personal_id.unique' => 'კლიენტი აღნიშნული პირადი ნომრით უკვე არსებობს.',
                                    'customer_phone.unique' => 'კლიენტი აღნიშნული ტელეფონის ნომრით უკვე არსებობს.',
                                    'customer_email.unique' => 'კლიენტი აღნიშნული ელფოსტით უკვე არსებობს.',
                                );
                                $validator = Validator::make($Request->all(), [
                                    'customer_name' => 'required|max:255',
                                    'customer_lastname' => 'required|max:255',
                                    'customer_personal_id' => 'required|unique:new_customers,personal_id,'.$Request->customer_id.'|max:255',
                                    'customer_phone' => 'required|unique:new_customers,phone,'.$Request->customer_id.'|max:255',
                                    'customer_email' => 'required|unique:new_customers,email,'.$Request->customer_id.'|max:255',
                                    'customer_address' => 'required|max:255',
                                ], $messages);

                                if ($validator->fails()) {
                                    return Response::json(['status' => true, 'errors' => true, 'message' => $validator->getMessageBag()->toArray()], 200);
                                } else {
                                    $Customer = new Customer();
                                    $Customer::updateOrCreate(
                                        ['id' => $Request->customer_id],
                                        [
                                            'id' => $Request->customer_id,
                                            'type' => $Request->customer_type,
                                            'name' => $Request->customer_name,
                                            'lastname' => $Request->customer_lastname,
                                            'personal_id' => $Request->customer_personal_id,
                                            'phone' => $Request->customer_phone,
                                            'email' => $Request->customer_email,
                                            'address' => $Request->customer_address,
                                        ],
                                    );
                                    return Response::json(['status' => true , 'message' => [0 => 'კლიენტის მონაცემები შენახულია'], 'redirect_url' => route('actionCustomersIndex')]);
                                }
                            }
                        } else {
                            return Response::json(['status' => true, 'errors' => true, 'message' => [0 => 'გთხოვთ აირჩიოთ სამართლებრივი ფორმა']]);
                        }
                    break;
                }
            } else {
                return Response::json(['status' => true, 'errors' => true, 'message' => [0 => 'გთხოვთ აირჩიოთ მომხმარებლის ტიპი']]);
            }
        } else {
            return Response::json(['status' => false]);
        }
    }
}
