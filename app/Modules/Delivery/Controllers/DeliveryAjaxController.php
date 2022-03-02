<?php

namespace App\Modules\Delivery\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Modules\Delivery\Models\DeliveryDistrict;
use App\Modules\Delivery\Models\DeliveryStreet;

use Response;

class DeliveryAjaxController extends Controller
{
    //
    public function ajaxGetDeliveryStreets(Request $Request) {
        if($Request->isMethod('GET')) {
            $DeliveryStreet = new DeliveryStreet();
            $DeliveryStreetList = $DeliveryStreet::where('district_id', $Request->district_id)->where('deleted_at_int', '!=', 0)->get();

            return Response::json(['status' => true, 'DeliveryStreetList' => $DeliveryStreetList]);
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxUpdateDeliveryPrice(Request $Request) {
        if($Request->isMethod('POST')) {
            $DeliveryDistrict = new DeliveryDistrict();
            $DeliveryDistrict::find($Request->district_id)->update(
                ['delivery_price' => $Request->delivery_price * 100]
            );

            return Response::json(['status' => true, 'message' => 'ფასი წარმატებით განახლდა']);
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxGetDeliveryStreetsActive(Request $Request) {
        if($Request->isMethod('POST') && !empty($Request->street_id)) {
            $DeliveryStreet = new DeliveryStreet();
            $DeliveryStreet::find($Request->street_id)->update([
                'active' => $Request->street_active,
            ]);
            return Response::json(['status' => true]);
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }
}
