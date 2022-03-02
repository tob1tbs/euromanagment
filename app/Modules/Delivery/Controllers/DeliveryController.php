<?php

namespace App\Modules\Delivery\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\Delivery\Models\DeliveryParameter;
use App\Modules\Delivery\Models\DeliveryCity;
use App\Modules\Delivery\Models\DeliveryDistrict;

class DeliveryController extends Controller
{

    public function __construct() {
        //
    }

    public function actionDeliveryParameters() {
        if (view()->exists('delivery.delivery_parameters')) {

            $DeliveryParameter = new DeliveryParameter();
            $DeliveryParametersList = $DeliveryParameter::where('deleted_at_int', '!=', 0)->where('active', 1)->get();

            $data = [
                'parameter_list' => $DeliveryParametersList,
            ];

            return view('delivery.delivery_parameters', $data);
        } else {
            abort('404');
        }
    }

    public function actionDeliveryAddress() {
        if (view()->exists('delivery.delivery_address')) {

            $DeliveryCity = new DeliveryCity();
            $DeliveryCityList = $DeliveryCity::where('deleted_at_int', '!=', 0)->get();

            $AddressArray = [];

            foreach($DeliveryCityList as $Key => $CityItem) {
                $AddressArray[$CityItem->id] = [
                    'city_id' => $CityItem->id,
                    'city_name' => $CityItem->name_ge,
                    'districts' => [],
                ];

                $DeliveryDistrict = new DeliveryDistrict();
                $DeliveryDistrictList = $DeliveryDistrict::where('city_id', $CityItem->id)->where('deleted_at_int', '!=', 0)->get();

                foreach($DeliveryDistrictList as $DistrictItem) {
                    if($CityItem->id == $DistrictItem->city_id) {
                        $AddressArray[$CityItem->id]['districts'][] = $DistrictItem;
                    }
                }
                
            }

            $data = [
                'address_array' => $AddressArray,
            ];

            return view('delivery.delivery_address', $data);
        } else {
            abort('404');
        }
    }
}
