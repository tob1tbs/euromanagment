<?php

namespace App\Modules\Content\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Modules\Content\Models\Slider;

use Response;

class SliderAjaxController extends Controller
{
    //
    public function __construct() {

    }

    public function ajaxViewPhoto(Request $Request) {
        if($Request->isMethod('POST') && !empty($Request->photo_id)) {
            $Slider = new Slider();
            $SliderPhoto = $Slider::find($Request->photo_id);

            retun Response::json(['status' => true, 'SliderPhoto' => $SliderPhoto]);
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxSliderUploadPhoto(Request $Request) {
        if($Request->isMethod('POST')) {
            $Slider = new Slider();
            $SliderPhoto = $Slider::updateOrCreate(
                ['id' => $Request->photo_id],
                [
                    'id' => $Request->photo_id,
                    'name' => $PhotoName,
                ],
            );

            return Response::json(['status' => true, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxSliderDeletePhoto(Request $Request) {
        if($Request->isMethod('POST') && !empty($Request->photo_id))) {
            $Slider = new Slider();
            $Slider::find($Request->photo_id)->update([
                'deleted_at' => Carbon::now();
                'deleted_at_int' => 0;
            ]);
            return Response::json(['status' => true, 'message' => 'სურათები წარმატებით წაიშლა !!!']);
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxSliderActiveChange(Request $Request) {
        if($Request->isMethod('POST') && !empty($Request->photo_id))) {
            $Slider = new Slider();
            $Slider::find($Request->photo_id)->update([
                'active' => $Request->photo_active;
            ]);
            return Response::json(['status' => true]);
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }
}
