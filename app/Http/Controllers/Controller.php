<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function monthList() {
        $MonthList = [ '01' => 'იანვარი', '02' => 'თებერვალი', '03' => 'მარტი', '04' => 'აპრილი', '05' => 'მაისი', '06' => 'ივნისი', '07' => 'ივლისი', '08' => 'აგვისტო', '09' => 'სექტემბერი', '10' => 'ოქტომბერი', '11' => 'ნოემბერი', '12' => 'დეკემბერი'];
        return $MonthList;
    }

    public function yearList() {
        $YearList = ['2021', '2022', '2023'];

        return $YearList;
    }
}
