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

    public function orderStatus() {
        $OrderStatus = [
            '1' => 'ახალი შეკვეთა',
            '2' => 'ნანახი შეკვეთა',
            '3' => 'მიმდინარე შეკვეთა',
            '4' => 'დასრულებული',
            '5' => 'გაუქმებული',
        ];

        return $OrderStatus;
    }

    public function rsStatus() {
        $rsStatus = [
            '1' => 'ზედნადები ატვირთულია',
            '2' => 'ზედნადები გაუქმებულია',
            '3' => 'ზედნადები არ არის ატვირთული',
        ];
        return $rsStatus;
    }

    public function overheadType() {
        $type = [
            '1' => 'ტრანსპორტირებით', 
            '2' => 'ტრანსპორტირების გარეშე', 
            '3' => 'შიდა გადაზიდვა', 
            '4' => 'დისტრიბუცია', 
            '5' => 'უკან დაბრუნება', 
        ];

        return $type;
    }

    public function overheadCategory() {
        $type = [
            '1' => 'ჩვეულებრივი', 
            '2' => 'ხე-ტყე', 
        ];

        return $type;
    }

    public function customerFields() {
        $FieldList = [
            'customer_type' => [
                '1' => 'ფიზიკური პირი',
                '2' => 'იურიდიული პირი',
            ],
            'company_type' => [
                'type' => 'select',
                'label' => 'სამართლებრივი ფორმა',
                'values' => [
                    '1' => 'შეზღუდული პასუხისმგებლობის საზოგადოება',
                    '2' => 'ინდივიდუალური მეწარმე',
                ]
            ],
            'fields' => [
                'type_1' => [
                    [
                        'label' => 'სახელი',
                        'type' => 'text',
                        'name' => 'customer_name',
                    ], 
                    [
                        'label' => 'გვარი',
                        'type' => 'text',
                        'name' => 'customer_lastname',
                    ], 
                    [
                        'label' => 'პირადი ნომერი',
                        'type' => 'text',
                        'name' => 'customer_personal_id',
                    ], 
                    [
                        'label' => 'ტელეფონის ნომერი',
                        'type' => 'text',
                        'name' => 'customer_phone',
                    ],
                    [
                        'label' => 'ელ-ფოსტა',
                        'type' => 'text',
                        'name' => 'customer_email',
                    ],
                    [
                        'label' => 'მისამართი',
                        'type' => 'text',
                        'name' => 'customer_address',
                    ],
                    [
                        'label' => 'რეფერალი',
                        'type' => 'select',
                        'name' => 'customer_referal',
                    ],
                    [
                        'label' => 'კონსიგნაციის ლიმიტი',
                        'type' => 'number',
                        'name' => 'company_consignation_limit',
                    ],
                ],
                'type_2' => [
                    'customer_type_1' => [
                        [
                            'label' => 'კომპანიის დასახელება',
                            'type' => 'text',
                            'name' => 'company_name',
                        ],
                        [
                            'label' => 'კომპანიის საიდენტიფიკაციო კოდი',
                            'type' => 'text',
                            'name' => 'company_code',
                        ],
                        [
                            'label' => 'მისამართი',
                            'type' => 'text',
                            'name' => 'company_address',
                        ],
                        [
                            'label' => 'საკონტაქტო პირი',
                            'type' => 'text',
                            'name' => 'company_contact',
                        ],
                        [
                            'label' => 'საკონტაქტო ელ-ფოსტა',
                            'type' => 'text',
                            'name' => 'company_email',
                        ],
                        [
                            'label' => 'საკონტაქტო ტელეფონის ნომერი',
                            'type' => 'text',
                            'name' => 'company_phone',
                        ],
                        [
                            'label' => 'რეფერალი',
                            'type' => 'select',
                            'name' => 'customer_referal',
                        ],
                        [
                            'label' => 'კონსიგნაციის ლიმიტი',
                            'type' => 'number',
                            'name' => 'customer_consignation_limit',
                        ],
                    ],
                    'customer_type_2' => [
                        [
                            'label' => 'სახელი',
                            'type' => 'text',
                            'name' => 'customer_name',
                        ], 
                        [
                            'label' => 'გვარი',
                            'type' => 'text',
                            'name' => 'customer_lastname',
                        ], 
                        [
                            'label' => 'პირადი ნომერი',
                            'type' => 'text',
                            'name' => 'customer_personal_id',
                        ], 
                        [
                            'label' => 'ტელეფონის ნომერი',
                            'type' => 'text',
                            'name' => 'customer_phone',
                        ],
                        [
                            'label' => 'ელ-ფოსტა',
                            'type' => 'text',
                            'name' => 'customer_email',
                        ],
                        [
                            'label' => 'მისამართი',
                            'type' => 'text',
                            'name' => 'customer_address',
                        ],
                        [
                            'label' => 'რეფერალი',
                            'type' => 'select',
                            'name' => 'customer_referal',
                        ],
                        [
                            'label' => 'კონსიგნაციის ლიმიტი',
                            'type' => 'number',
                            'name' => 'customer_consignation_limit',
                        ],
                    ],
                ],
            ]
        ];  
      return $FieldList;
    }
}
