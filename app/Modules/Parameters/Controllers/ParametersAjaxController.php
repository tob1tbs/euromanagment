<?php

namespace App\Modules\Parameters\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Modules\Parameters\Models\ParameterPayment;
use App\Modules\Parameters\Models\ParameterTranslate;

use Response;
use Validator;

class ParametersAjaxController extends Controller
{
    //
    public function __construct() {

    }

    // PAYMENTS
    public function ajaxParameterPaymentOptions(Request $Request) {
        if($Request->isMethod('GET') && $Request->payment_id) {
            $ParameterPayment = new ParameterPayment();
            $ParameterOptions = $ParameterPayment::select('options')->where('id', $Request->payment_id)->get();

            return Response::json(['status' => true, 'ParameterOptions' => $ParameterOptions]);
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxParameterPaymentActive(Request $Request) {
        if($Request->isMethod('POST') && !empty($Request->payment_id)) {
            $ParameterPayment = new ParameterPayment();
            $ParameterPayment::find($Request->payment_id)->update([
                'active' => $Request->payment_active,
            ]);

            return Response::json(['status' => true]);
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxParameterPaymentSubmit(Request $Request) {
        if($Request->isMethod('POST')) {
            if($Request->key = 'tbc_payment') {
                $json = '{"key": {"label":"Payment Key","value":"tbc_payment","secret":false,"disabled":true},"api_key":{"label":"Api key","value":"'.$Request->api_key.'","secret":true,"disabled":false},"api_secret":{"label":"Api secret","value":"'.$Request->api_secret.'","secret":true,"disabled":false},"merchant_key":{"label":"Merchant key","value":"'.$Request->merchant_key.'","secret":false,"disabled":false}}';

                $ParameterPayment = new ParameterPayment();
                $ParameterPayment::where('key', $Request->key)->update(['options' => $json]);

                return Response::json(['status' => true, 'message' => 'პარამეტრები წარმატებით შეიცვალა !!!']);
            }
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    // TRANSLATE
    public function ajaxParameterTranslateUpdate(Request $Request) {
        if($Request->isMethod('POST')) {
            $Translate = [
                'ge' => $Request->translate_ge,
                'en' => $Request->translate_en,
            ];

            $ParameterTranslate = new ParameterTranslate();
            $ParameterTranslate::find($Request->translate_id)->update([
                'value' => json_encode($Translate),
            ]);

            return Response::json(['status' => true]);

        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxParameterTranslateAdd(Request $Request) {
        if($Request->isMethod('POST')) {
            $messages = array(
                'required' => 'გთხოვთ შეავსოთ ყველა აუცილებელი ველი!!!',
                'unique' => 'მოცემული KEY დაკავებულია!!!',
            );

            $validator = Validator::make($Request->all(), [
                'translate_key' => 'required|unique:new_translate_parameters,key|max:100',
                'translate_value_ge' => 'required|max:255',
            ], $messages);

            if ($validator->fails()) {
                return Response::json(['status' => true, 'errors' => true, 'message' => $validator->getMessageBag()->toArray()], 200);
            } else {
                $Translate = [
                    'ge' => $Request->translate_value_ge,
                    'en' => $Request->translate_value_en,
                ];

                $ParameterTranslate = new ParameterTranslate();
                $ParameterTranslate->key = $Request->translate_key;
                $ParameterTranslate->value = json_encode($Translate);
                $ParameterTranslate->save();

                return Response::json(['status' => true, 'message' => 'თარგამნი წარმატებით დაემატა !!!']);
            }
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }
}
