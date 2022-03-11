<?php

namespace App\Modules\Company\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\Company\Models\Branch;

use Validator;
use Response;
use \Carbon\Carbon;

class CompanyAjaxController extends Controller
{

    public function __construct() {
        
    }

    public function ajaxCompanyBranchSubmit(Request $Request) {
        if($Request->isMethod('POST')) {
            $messages = array(
                'required' => 'გთხოვთ შეავსოთ ყველა აუცილებელი ველი',
            );
            $validator = Validator::make($Request->all(), [
                'branch_name' => 'required|max:255',
            ], $messages);

            if ($validator->fails()) {
                return Response::json(['status' => true, 'errors' => true, 'message' => $validator->getMessageBag()->toArray()], 200);
            } else {
                $Branch = new Branch();
                $Branch::updateOrCreate(
                    ['id' => $Request->branch_id],
                    [
                        'id' => $Request->branch_id,
                        'name' => $Request->branch_name,
                        'parent_id' => $Request->branch_parent,
                    ],
                );

                return Response::json(['status' => true, 'errors' => false, 'message' => 'ფილიალი / განყოფილება წარმატებით დაემატა'], 200);
            }
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

}
