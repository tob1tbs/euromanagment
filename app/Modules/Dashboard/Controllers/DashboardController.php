<?php

namespace App\Modules\Dashboard\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\Dashboard\Models\Dashboard;
use App\Modules\Customers\Models\CustomerType;

class DashboardController extends Controller
{

    public function __construct() {
        //
    }

    public function actionDashboardIndex(Request $Request) {
        if (view()->exists('dashboard.dashboard_index')) {

            $CustomerType = new CustomerType();
            $CustomerTypeList = $CustomerType::where('deleted_at_int', '!=', 0)->where('active', 1)->get();

            $data = [
                'customer_type' => $CustomerTypeList,
            ];
            
            return view('dashboard.dashboard_index', $data);
        } else {
            abort('404');
        }
    }
}
