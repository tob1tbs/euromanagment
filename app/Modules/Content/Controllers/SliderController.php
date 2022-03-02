<?php

namespace App\Modules\Content\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Modules\Content\Models\Slider;

class SliderController extends Controller
{
    //

    public function __construct() {

    }

    public function actionSliderIndex() {
        if (view()->exists('content.slider_index')) {

            $Slider = new Slider();
            $SliderList = $Slider::where('deleted_at_int', '!=', 0)->get();

            $data = [
                'slider_list' => $SliderList,
            ];

            return view('content.slider_index', $data);
        } else {
            abort('404');
        }
    }
}
