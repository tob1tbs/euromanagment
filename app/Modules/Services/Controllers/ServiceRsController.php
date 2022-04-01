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
        $soap_url = "https://services.rs.ge/WayBillService/WayBillService.asmx?op=get_waybill_by_number";
        $post_fields = '<?xml version="1.0" encoding="utf-8"?>
                            <soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
                              <soap12:Body>
                                <get_waybill_by_number xmlns="http://tempuri.org/">
                                  <su>'.$soap_user.'</su>
                                  <sp>'.$soap_password.'</sp>
                                  <waybill_number>'.$waybill_number.'</waybill_number>
                                </get_waybill_by_number>
                              </soap12:Body>
                            </soap12:Envelope>';
        return self::sendSoap($soap_url, $post_fields);
    }

    public function serviceRsGetWaybillUnits() {
        $soap_url = "https://services.rs.ge/WayBillService/WayBillService.asmx?op=get_waybill_units";
        $post_fields = '<?xml version="1.0" encoding="utf-8"?>
                    <soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
                      <soap12:Body>
                        <get_waybill_units xmlns="http://tempuri.org/">
                          <su>'.$soap_user.'</su>
                          <sp>'.$soap_password.'</sp>
                        </get_waybill_units>
                      </soap12:Body>
                    </soap12:Envelope>';
        return self::sendSoap($soap_url, $post_fields);
    }
}
