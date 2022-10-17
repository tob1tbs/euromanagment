<?php

namespace App\Modules\Dashboard\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\Dashboard\Models\Dashboard;
use App\Modules\Dashboard\Models\DashboardOrder;
use App\Modules\Customers\Models\CustomerType;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

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
            $DashboardOrderList = $DashboardOrder->with(['customerType']);

            if($Request->has('order_year') && !empty($Request->order_year)) {
                $DashboardOrderList = $DashboardOrderList->whereYear('created_at', $Request->order_year);
            }

            if($Request->has('order_month') && !empty($Request->order_month)) {
                $DashboardOrderList = $DashboardOrderList->whereMonth('created_at', $Request->order_month);
            }

            if($Request->has('order_status') && !empty($Request->order_status)) {
                $DashboardOrderList = $DashboardOrderList->where('status', $Request->order_status);
            }

            if($Request->has('rs_status') && !empty($Request->rs_status)) {
                $DashboardOrderList = $DashboardOrderList->where('rs_send', $Request->rs_status);
            }

            if($Request->has('order_search_query') && !empty($Request->order_search_query)) {
                $DashboardOrderList->where(function($query) use ($Request) {
                    $query->where('id', 'like', '%'.$Request->order_search_query.'%');
                });
            }

            if($Request->has('order_search_number') && !empty($Request->order_search_number)) {
                $DashboardOrderList = $DashboardOrderList->whereRelation('customerType', 'personal_id', 'like', '%'.$Request->order_search_number.'%');
            }

            $DashboardOrderList = $DashboardOrderList->orderBy('id', 'DESC')->get();

            $data = [
                'year_list' => $this->yearList(),   
                'month_list' => $this->monthList(),   
                'order_status' => $this->orderStatus(),   
                'rs_status' => $this->rsStatus(),   
                'order_list' => $DashboardOrderList,
                'overhead_type' => $this->overheadType(),
                'overhead_category' => $this->overheadCategory(),
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
            $DashboardOrderList = $DashboardOrder::where('deleted_at_int', '!=', 0);

            $DashboardOrderList = $DashboardOrderList->get();

            $OrderStatistic = [
                'canceled' => $DashboardOrderList->where('status', 4)->sum('id'),
                'in_progres' => $DashboardOrderList->where('status', 2)->sum('id'),
                'complated' => $DashboardOrderList->where('status', 3)->sum('id'),
            ];

            $data = [
                'year_list' => $this->yearList(),   
                'month_list' => $this->monthList(),   
                'order_status' => $this->orderStatus(),
                'OrderStatistic' => json_encode(array_values($OrderStatistic), true),
                'order_list' => $DashboardOrderList,
                'current_date' => Carbon::now()->locale('ka_GE'),
            ];
            
            return view('dashboard.dashboard_reports', $data);
        } else {
            abort('404');
        }
    }

    public function actionDashboardOrdersPrint(Request $Request) {
        if (view()->exists('dashboard.dashboard_print')) {

            $DashboardOrder = new DashboardOrder();
            $DashboardOrderData = $DashboardOrder->find($Request->order_id);

            $data = [
                'order_data' => $DashboardOrderData,
            ];
            
            return view('dashboard.dashboard_print', $data);
        } else {
            abort('404');
        }
    }
}
