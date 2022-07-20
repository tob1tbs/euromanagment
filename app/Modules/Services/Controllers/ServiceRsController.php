<?php

namespace App\Modules\Services\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceRsController extends Controller
{

    public function __construct() {
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

    public function serviceSendRsOverheadTransporter($data, $address_data, $driver_data, $order_data) {
        
        $order_data = json_decode($order_data);

        if(!empty($order_data->customer_type)) {
            $customer_code = $order_data->customer_type->personal_id; 
        }

        if(!empty($order_data->customer_company)) {
            $customer_code = $order_data->customer_company->code;
        }

        $date = date("Y-m-d").'T'.date("H:i:s");
        $soap_url = "https://services.rs.ge/WayBillService/WayBillService.asmx?op=save_waybill";
        $post_fields = '<?xml version="1.0" encoding="utf-8"?>
                        <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
                            <soap:Body>
                              <save_waybill xmlns="http://tempuri.org/">
                                <su>INFINATI:206322102</su>
                                <sp>123456</sp>
                                <waybill>
                                    <WAYBILL>
                                    <GOODS_LIST>';
        foreach (json_decode($data) as $key => $item) {
            $post_fields .= '<GOODS>
              <ID>0</ID>
              <W_NAME>'.$item->name.'</W_NAME>
              <UNIT_ID>1</UNIT_ID>
              <UNIT_TXT>'.$item->unit.'</UNIT_TXT>
              <QUANTITY>'.$item->quantity.'</QUANTITY>
              <PRICE>'.$item->price.'</PRICE>
              <AMOUNT>'.$item->quantity * $item->price.'</AMOUNT>
              <BAR_CODE>'.$key.'</BAR_CODE>
              <A_ID>0</A_ID>
              <VAT_TYPE>0</VAT_TYPE>
            </GOODS>';
        };

        $post_fields .= '</GOODS_LIST>
                    <ID>0</ID>
                    <TYPE>2</TYPE>
                    <BUYER_TIN>12345678910</BUYER_TIN>
                    <SELER_UN_ID>731937</SELER_UN_ID>
                    <S_USER_ID>113183</S_USER_ID>
                    <STATUS>0</STATUS>
                    <CHEK_BUYER_TIN>1</CHEK_BUYER_TIN>
                    <BEGIN_DATE>'.$date.'</BEGIN_DATE>
                    <START_ADDRESS>'.json_decode($address_data)->start.'</START_ADDRESS>
                    <END_ADDRESS>'.json_decode($address_data)->end.'</END_ADDRESS>
                    <CHEK_DRIVER_TIN>1</CHEK_DRIVER_TIN>
                    <DRIVER_TIN>'.json_decode($driver_data)->driver_personal_number.'</DRIVER_TIN>
                    <CAR_NUMBER>'.json_decode($driver_data)->car_number.'</CAR_NUMBER>
                    <TRANS_ID>1</TRANS_ID>
                    <TRANSPORT_COAST>0</TRANSPORT_COAST>
                    <TRAN_COST_PAYER>2</TRAN_COST_PAYER>
                    <COMMENT></COMMENT>
                    </WAYBILL>
                    </waybill>
                </save_waybill>
            </soap:Body>
        </soap:Envelope>';
        // dd($post_fields);
        return self::serviceRsSendSoap($soap_url, $post_fields);
    }

    public function serviceRsSendWaybillTransporter($waybill_id) {
        $date = date("Y-m-d").'T'.date("H:i:s");
        $soap_url = "https://services.rs.ge/WayBillService/WayBillService.asmx?op=send_waybill";
        $post_fields = '<?xml version="1.0" encoding="utf-8"?>
                        <soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
                          <soap12:Body>
                            <send_waybill xmlns="http://tempuri.org/">
                                <su>INFINATI:206322102</su>
                                <sp>123456</sp>
                                <waybill_id>'.$waybill_id.'</waybill_id>
                            </send_waybill>
                          </soap12:Body>
                        </soap12:Envelope>';
        return self::serviceRsSendSoap($soap_url, $post_fields);

    }

    public function serviceRsCancelOverhead($waybill_id) {
        $date = date("Y-m-d").'T'.date("H:i:s");
        $soap_url = "https://services.rs.ge/WayBillService/WayBillService.asmx?op=ref_waybill";
        $post_fields = '<?xml version="1.0" encoding="utf-8"?>
                        <soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
                          <soap12:Body>
                            <ref_waybill xmlns="http://tempuri.org/">
                                <su>INFINATI:206322102</su>
                                <sp>123456</sp>
                                <waybill_id>'.$waybill_id.'</waybill_id>
                            </ref_waybill>
                          </soap12:Body>
                        </soap12:Envelope>';
        return self::serviceRsSendSoap($soap_url, $post_fields);

    }

    public function serviceCheckServiceUser() {
        $soap_url = "https://services.rs.ge/WayBillService/WayBillService.asmx?op=chek_service_user";
        $post_fields = '<?xml version="1.0" encoding="utf-8"?>
                            <soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
                              <soap12:Body>
                                <chek_service_user xmlns="http://tempuri.org/">
                                  <su>INFINATI:206322102</su>
                                  <sp>123456</sp>
                                </chek_service_user>
                              </soap12:Body>
                            </soap12:Envelope>';
        return self::serviceRsSendSoap($soap_url, $post_fields);

    }
}
