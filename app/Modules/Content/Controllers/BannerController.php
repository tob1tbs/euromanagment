<?php

namespace App\Modules\Content\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Modules\Content\Models\Banner;
use App\Modules\Content\Models\BannerItem;

class BannerController extends Controller
{
    //
    public function __construct() {

    }

    public function actionBannerIndex() {
        if (view()->exists('content.banner_index')) {

            $Banner = new Banner();
            $BannerList = $Banner::where('deleted_at_int', '!=', 0)->get();

            $BannerArray = [];

            foreach($Banner as $Item) {
                $BannerItem = new BannerItem();
                $BannerItemData = $BannerItem::where('position_id', $Item->id)->get();
            }

            $data = [
                'slider_list' => $SliderList,
            ];

            return view('content.banner_index', $data);
        } else {
            abort('404');
        }
    }
}
