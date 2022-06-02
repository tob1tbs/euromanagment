<?php

namespace App\Modules\Dashboard\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\Dashboard\Models\Dashboard;
use App\Modules\Dashboard\Models\DashboardOrder;
use App\Modules\Customers\Models\CustomerType;

use Carbon\Carbon;

use App\Modules\Services\Controllers\ServiceRsController;

class DashboardController extends Controller
{

    public function __construct() {
        //
    }

    public function actionDashboardIndex(Request $Request, ServiceRsController $ServiceRsController) {
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

    public function actionDashboardOrders(Request $Request) {
        if (view()->exists('dashboard.dashboard_orders')) {

            $DashboardOrder = new DashboardOrder();
            $DashboardOrderList = $DashboardOrder::where('deleted_at_int', '!=', 0)->get();

            $data = [
                'year_list' => $this->yearList(),   
                'month_list' => $this->monthList(),   
                'order_list' => $DashboardOrderList,
                'current_date' => Carbon::now()->locale('ka_GE'),
            ];
            
            return view('dashboard.dashboard_orders', $data);
        } else {
            abort('404');
        }
    }

    public function actionDashboardReports(Request $Request) {
        if (view()->exists('dashboard.dashboard_reports')) {

            $DashboardOrder = new DashboardOrder();
            $DashboardOrderList = $DashboardOrder::where('deleted_at_int', '!=', 0)->get();

            $data = [
                'order_list' => $DashboardOrderList,
            ];
            
            return view('dashboard.dashboard_reports', $data);
        } else {
            abort('404');
        }
    }
}
