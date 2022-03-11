<?php

namespace App\Modules\Company\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\Company\Models\Branch;

class CompanyController extends Controller
{

    public function __construct() {
        
    }

    public function GetData() {
        $url = 'https://technoshop.ge/data/dealer_products.json';
        $json = file_get_contents($url);
        $result = json_decode($json, true);
        return $result;
   }

    public function actionCompanyBranch(Request $Request) {
        if (view()->exists('company.company_branch')) {

            $BranchArray = [];

            $Branch = new Branch();
            $BranchList = $Branch::where('deleted_at_int', '!=', 0)->where('parent_id', 0)->get();

            foreach($BranchList as $BranchItem) {
                $BranchArray[$BranchItem->id] = [
                    'id' => $BranchItem->id,
                    'name' => $BranchItem->name,
                    'active' => $BranchItem->active,
                    'departaments' => [],
                ];

                $BranchChild = $Branch::where('parent_id', $BranchItem->id)->where('deleted_at_int', '!=', 0)->get();

                foreach($BranchChild as $BranchChildItem) {
                    $BranchArray[$BranchItem->id]['departaments'][] = $BranchChildItem;
                }
            }

            $data = [
                'branch_list' => $BranchArray,
            ];
            
            return view('company.company_branch', $data);
        } else {
            abort('404');
        }
    }
}
