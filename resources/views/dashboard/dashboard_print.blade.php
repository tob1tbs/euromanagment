<!DOCTYPE html>
<html lang="ka" class="js">
<head>
    <title>WMS Software V 1.0</title>
    <meta charset="utf-8">
    <meta name="author" content="Foxes">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="stylesheet" href="{{ url('/assets/css/dashlite.css') }}">
    <link rel="stylesheet" href="{{ url('/assets/css/theme.css') }}">
    <link rel="stylesheet" href="{{ url('/assets/css/custom.css') }}">

    @yield('css')
</head>
<body class="bg-white" onload="printPromot()" >
    <div class="nk-block">
        <div class="invoice invoice-print">
            <div class="invoice-wrap">
                <div class="invoice-brand text-center">
                    <img src="{{ asset('assets/logotype_evro.jpg') }}" srcset="{{ asset('assets/logotype_evro.jpg') }}" alt="">
                    <br>
                    <span class="font-neue text-center" style="font-size: 40px; width: 100%; margin-top: 20px;">ინვოისი #2123123</span>
                </div>
                <div class="invoice-head">
                    <div class="invoice-contact">
                        <span class="overline-title font-neue">მომწოდებელი</span>
                        <div class="invoice-contact-info">
                            <h4 class="title font-neue">შპს "ევრო-ვაგონკა"</h4>
                            <ul class="list-plain">
                                <li><em class="icon ni ni-chevron-right-circle fs-18px"></em><span class=" font-helvetica-regular">ს/კ: 430030708</span></li>
                                <li><em class="icon ni ni-map-pin-fill fs-18px"></em><span class=" font-helvetica-regular">მისამართი: თბილისი, მექანიზაციის ქ.№ 1</span></li>
                                <li><em class="icon ni ni-building fs-14px"></em><span class=" font-helvetica-regular">თიბისი ბანკი TBCBGE22</span></li>
                                <li><em class="icon ni ni-master-card fs-14px"></em><span class=" font-helvetica-regular"><b>ანგარიშის ნომერი:</b> GE67TB7744036080100003</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="invoice-contact">
                        <span class="overline-title font-neue">დამკვეთი</span>
                        @if($order_data->customer_type == 1)
                        <div class="invoice-contact-info">
                            <h4 class="title font-neue">ფ/პ {{ $order_data->customerType->name }} {{ $order_data->customerType->lastname }}</h4>
                            <ul class="list-plain">
                                <li><em class="icon ni ni-chevron-right-circle fs-18px"></em><span class=" font-helvetica-regular">პ/ნ: {{ $order_data->customerType->personal_id }}</span></li>
                                <li><em class="icon ni ni-map-pin-fill fs-18px"></em><span class=" font-helvetica-regular">მისამართი: {{ $order_data->customerType->lastname }}</span></li>
                            </ul>
                        </div>
                        @elseif($order_data->customer_type == 2)
                        <div class="invoice-contact-info">
                            <h4 class="title font-neue">ი/მ {{ $order_data->customerType->name }} {{ $order_data->customerType->lastname }}</h4>
                            <ul class="list-plain">
                                <li><em class="icon ni ni-chevron-right-circle fs-18px"></em><span class=" font-helvetica-regular">ს/კ: {{ $order_data->customerType->personal_id }}</span></li>
                                <li><em class="icon ni ni-map-pin-fill fs-18px"></em><span class=" font-helvetica-regular">მისამართი: {{ $order_data->customerType->address }}</span></li>
                            </ul>
                        </div>
                        @elseif($order_data->customer_type == 3)
                        <div class="invoice-contact-info">
                            <h4 class="title font-neue">{{ $order_data->customerCompany->name }}</h4>
                            <ul class="list-plain">
                                <li><em class="icon ni ni-chevron-right-circle fs-18px"></em><span class=" font-helvetica-regular">ს/კ: {{ $order_data->customerCompany->code }}</span></li>
                                <li><em class="icon ni ni-map-pin-fill fs-18px"></em><span class=" font-helvetica-regular">მისამართი: {{ $order_data->customerCompany->address }}</span></li>
                            </ul>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="invoice-bills">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr class="font-neue">
                                    <th class="w-150px">კოდი</th>
                                    <th class="w-60">დასახელება</th>
                                    <th>ღირებულება</th>
                                    <th>ერთეული</th>
                                    <th>რეოდენობა</th>
                                    <th>ჯამი</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order_data->orderItems as $OrderItem)
                                <tr class="font-helvetica-regular">
                                    <td>{{ $OrderItem->orderItemData->id }}</td>
                                    <td>{{ $OrderItem->orderItemData->name }}</td>
                                    <td>₾{{ $OrderItem->price / 100}}</td>
                                    <td>{{ $OrderItem->orderItemData->productUnit->name }}</td>
                                    <td>{{ $OrderItem->quantity }}</td>
                                    <td>₾{{ $OrderItem->quantity * ($OrderItem->price / 100) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="font-neue">
                                    <td colspan="3"></td>
                                    <td colspan="2"><strong>ჯამური ღირებულება:</strong></td>
                                    <td>₾{{ $order_data->total_price / 100 }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <span>
                        <img src="{{ asset('assets/shtamp_evro.png') }}" alt="" class="float-right">
                    </span>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ url('/assets/js/bundle.js') }}"></script>
    <script src="{{ url('/assets/js/scripts.js') }}"></script>
    <script>
        function printPromot() {
            window.print();
        }
    </script>
</body>
</html>