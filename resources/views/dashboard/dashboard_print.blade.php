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
<body class="bg-white" onload="printPromot()">
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
                        <div class="invoice-contact-info">
                            <h4 class="title font-neue">შპს "ევრო-ვაგონკა"</h4>
                            <ul class="list-plain">
                                <li><em class="icon ni ni-chevron-right-circle fs-18px"></em><span class=" font-helvetica-regular">ს/კ: 430030708</span></li>
                            </ul>
                        </div>
                    </div>
                </div><!-- .invoice-head -->
                <div class="invoice-bills">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="w-150px">Item ID</th>
                                    <th class="w-60">Description</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>24108054</td>
                                    <td>Dashlite - Conceptual App Dashboard - Regular License</td>
                                    <td>$40.00</td>
                                    <td>5</td>
                                    <td>$200.00</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2"></td>
                                    <td colspan="2">Subtotal</td>
                                    <td>$435.00</td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td colspan="2">Processing fee</td>
                                    <td>$10.00</td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td colspan="2">TAX</td>
                                    <td>$43.50</td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td colspan="2">Grand Total</td>
                                    <td>$478.50</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div><!-- .invoice-bills -->
            </div><!-- .invoice-wrap -->
        </div><!-- .invoice -->
    </div><!-- .nk-block -->
    <script src="{{ url('/assets/js/bundle.js') }}"></script>
    <script src="{{ url('/assets/js/scripts.js') }}"></script>
    <script>
        function printPromot() {
            window.print();
        }
    </script>
</body>
</html>