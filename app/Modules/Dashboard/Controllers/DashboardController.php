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

            $data = [
                'customer_type' => $this->customerFields(),
            ];
            
            return view('dashboard.dashboard_index', $data);
        } else {
            abort('404');
        }
    }

    public function actionDashboardOrders(Request $Request) {
        if (view()->exists('dashboard.dashboard_orders')) {

            $DashboardOrder = new DashboardOrder();
            $DashboardOrderList = $DashboardOrder;

            if($Request->has('order_year') && !empty($Request->order_year)) {
                $DashboardOrderList = $DashboardOrderList->whereYear('created_at', $Request->order_year);
            }

            if($Request->has('order_month') && !empty($Request->order_month)) {
                $DashboardOrderList = $DashboardOrderList->whereMonth('created_at', $Request->order_month);
            }

            if($Request->has('order_status') && !empty($Request->order_status)) {
                $DashboardOrderList = $DashboardOrderList->where('status', $Request->order_status);
            }

            if($Request->has('order_search_query') && !empty($Request->order_search_query)) {
                $DashboardOrderList->where(function($query) use ($Request) {
                    $query->where('id', 'like', '%'.$Request->order_search_query.'%');
                    // $query->orWhere('user_lastname', 'like', '%'.$Request->order_search_query.'%');
                });
            }

            $DashboardOrderList = $DashboardOrderList->orderBy('id', 'DESC')->get();

            $data = [
                'year_list' => $this->yearList(),   
                'month_list' => $this->monthList(),   
                'order_status' => $this->orderStatus(),   
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
