<?php

namespace App\Modules\Parameters\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\Parameters\Models\Parameter;
use App\Modules\Parameters\Models\ParameterInfo;
use App\Modules\Parameters\Models\ParameterSocial;
use App\Modules\Parameters\Models\ParameterPlugin;
use App\Modules\Parameters\Models\ParameterPaymentCategory;
use App\Modules\Parameters\Models\ParameterPayment;
use App\Modules\Parameters\Models\ParameterTranslate;

class ParametersController extends Controller
{

    public function __construct() {
        //
    }

    public function actionParametersIndex() {
        if (view()->exists('parameters.parameters_index')) {

            $Parameter = new Parameter();
            $ParameterList = $Parameter::where('deleted_at_int', '!=', 0)->where('active', 1)->get();

            $ParameterInfo = new ParameterInfo();
            $ParameterInfoList = $ParameterInfo::where('deleted_at_int', '!=', 0)->where('active', 1)->get();

            $ParameterSocial = new ParameterSocial();
            $ParameterSocialList = $ParameterSocial::where('deleted_at_int', '!=', 0)->where('active', 1)->get();

            $ParameterPlugin = new ParameterPlugin();
            $ParameterPluginList = $ParameterPlugin::where('deleted_at_int', '!=', 0)->where('active', 1)->get();

            $data = [
                'parameter_list' => $ParameterList,
                'parameter_info_list' => $ParameterInfoList,
                'parameter_social_list' => $ParameterSocialList,
                'parameter_plugin_list' => $ParameterPluginList,
            ];

            return view('parameters.parameters_index', $data);
        } else {
            abort('404');
        }
    }

    public function actionParametersPayments(Request $Request) {
        if (view()->exists('parameters.parameters_payments')) {

            $ParameterPaymentCategory = new ParameterPaymentCategory();
            $ParameterPaymentCategoryList = $ParameterPaymentCategory::where('deleted_at_int', '!=', 0)->get();

            $CategoryArray = [];

            foreach($ParameterPaymentCategoryList as $CategoryItem) {

                $ParameterPayment = new ParameterPayment();
                $ParameterPaymentList = $ParameterPayment::where('category_id', $CategoryItem->id)->where('deleted_at_int', '!=', 0)->get();

                $CategoryArray[$CategoryItem->id] = [
                    'id' => $CategoryItem->id,
                    'name' => $CategoryItem->name_ge,
                    'active' => $CategoryItem->active,
                    'payments' => [],
                ];

                foreach($ParameterPaymentList as $PaymentItem) {
                    if($PaymentItem->category_id == $CategoryItem->id) {
                        $CategoryArray[$CategoryItem->id]['payments'][] = $PaymentItem;
                    }
                }
            }

            $data = [
                'category_list' => $CategoryArray,
            ];

            return view('parameters.parameters_payments', $data);
        } else {
            abort('404');
        }
    }

    public function actionParametersTranslate(Request $Request) {
        if (view()->exists('parameters.parameters_translate')) {

            $ParameterTranslate = new ParameterTranslate();
            $ParameterTranslateList = $ParameterTranslate::where('deleted_at_int', '!=', 0)->get();

            $data = [
                'parameters_translate_list' => $ParameterTranslateList,
            ];

            return view('parameters.parameters_translate', $data);
        } else {
            abort('404');
        }
    }
}
