<?php

namespace App\Modules\Services\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\Services\Models\Service;

class ServiceRsController extends Controller
{

    protected $soap_user;
    protected $soap_password;

    public function __construct() {
        //
        $this->soap_user = 'arbo:205273498';
        $this->soap_password = 'Madart2020';
    }

    public function serviceRsSendSoap($soap_url, $post_fields) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $soap_url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $post_fields,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: text/xml; charset=utf-8'
          ),
        ));

        $response = curl_exec($curl);
        $clean_xml = str_ireplace(['SOAP-ENV:', 'SOAP:'], '', $response);
        $xml = simplexml_load_string($clean_xml);
        return $xml;
    }

    public function serviceRsGetWaybillByNumber($waybill_number) {
        $soap_url = "https://services.rs.ge/WayBillService/WayBillService.asmx?op=is_vat_payer_tin";
        $post_fields = '<?xml version="1.0" encoding="utf-8"?>
                            <soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
                              <soap12:Body>
                                <is_vat_payer_tin  xmlns="http://tempuri.org/">
                                  <su>'.$this->soap_user.'</su>
                                  <sp>'.$this->soap_password.'</sp>
                                  <un_id>404425083</un_id>
                                </is_vat_payer_tin >
                              </soap12:Body>
                            </soap12:Envelope>';
        return self::serviceRsSendSoap($soap_url, $post_fields);
    }
}
