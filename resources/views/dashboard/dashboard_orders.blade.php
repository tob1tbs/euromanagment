@extends('layout.layout')

@section('css')

@endsection

@section('content')
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-fmg">
                    <div class="nk-fmg-body">
                        <div class="nk-fmg-body-content">
                            <div class="nk-fmg-listing nk-block-lg">
                                <div class="nk-block-head-xs">
                                    <div class="nk-block-between g-2">
                                        <div class="nk-block-head-content">
                                            <h6 class="nk-block-title title font-neue">შეკვეთების ჩამონათვალი</h6>
                                        </div>
                                    </div>
                                </div>
                                <form action="#">
                                    <div class="row g-4">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="form-label" for="order_year">წელი</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-control" id="order_year" name="order_year">
                                                        @foreach($year_list as $year_item)
                                                        <option value="{{ $year_item }}" @if(empty(request()->order_year)) @if($current_date->format('Y') == $year_item) selected @endif @else @if(request()->order_year == $year_item) selected @endif @endif>{{ $year_item }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="form-label" for="order_month">თვე</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-control" id="order_month" name="order_month">
                                                        @foreach($month_list as $month_key => $month_item)
                                                        <option value="{{ $month_key }}" @if(empty(request()->order_month)) @if($current_date->format('m') == $month_key) selected @endif @else @if(request()->order_month == $month_key) selected @endif @endif>{{ $month_item }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="form-label" for="order_status">შეკვეთის სტატუსი</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-control" id="order_status" name="order_status">
                                                        <option></option>
                                                        @foreach($order_status as $k => $v)
                                                        <option value="{{ $k }}" @if($k == request()->order_status) selected @endif)>{{ $v }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="form-label" for="rs_status">ზედნადების სტატუსი</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-control" id="rs_status" name="rs_status">
                                                        <option value="0"></option>
                                                        @foreach($rs_status as $rs_key => $rs_item)
                                                        <option value="{{ $rs_key }}" @if(request()->rs_status == $rs_key) selected @endif>{{ $rs_item }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="form-label" for="order_search_query">სწრაფი ძებნა</label>
                                                <div class="form-control-wrap ">
                                                    <input type="text" class="form-control" id="order_search_query" name="order_search_query" value="{{ request()->order_search_query }}" placeholder="შეკვეთს ნომერი">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-1">
                                            <div class="form-group">
                                                <label class="form-label" for="pay-amount-1">&nbsp;</label>
                                                <div class="form-control-wrap text-center">
                                                    <button type="submit" class="btn btn-success font-neue w-100">გაფილტვრა</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="tab-content">
                                    <div class="card card-bordered card-preview mt-4">
                                        @if(count($order_list) > 0)
                                        <table class="table table-orders">
                                            <thead class="tb-odr-head">
                                                <tr class="tb-odr-item font-neue">
                                                    <th class="tb-odr-info">
                                                        <span class="tb-odr-date">შეკვეთის ნომერი</span>
                                                    </th>
                                                    <th class="tb-odr-info">
                                                        <span class="tb-odr-date">თარიღი</span>
                                                    </th>
                                                    <th class="tb-odr-info">
                                                        <span class="tb-odr-date">მომხმარებელი</span>
                                                    </th>
                                                    <th class="tb-odr-info">
                                                        <span class="tb-odr-date">ღირებულება</span>
                                                    </th>
                                                    <th class="tb-odr-info">
                                                        <span class="tb-odr-date">ზედნადები</span>
                                                    </th>
                                                    <th class="tb-odr-info">
                                                        <span class="tb-odr-date">სტატუსი</span>
                                                    </th>
                                                    <th class="tb-odr-action">&nbsp;</th>
                                                </tr>
                                            </thead>
                                            <tbody class="tb-odr-body">
                                                @foreach($order_list as $order_item)
                                                <tr class="tb-odr-item font-helvetica-regular">
                                                    <td class="tb-odr-info">
                                                        <span class="tb-odr-id"><a href="#">#{{ $order_item->id }}</a></span>
                                                    </td>
                                                    <td class="tb-odr-info">
                                                        <span class="tb-odr-date">{{ \Carbon\Carbon::parse($order_item->created_at)->format('Y-m-d') }}</span>
                                                    </td>
                                                    <td class="tb-odr-info">
                                                        <span class="tb-odr-date">
                                                            @switch($order_item->customer_type)
                                                            @case(1)
                                                                <span class="badge badge-primary font-helvetica-regular mr-1">ფ/პ</span>{{ $order_item->customerType->name }} {{ $order_item->customerType->lastname }}
                                                            @break
                                                            @case(2)
                                                                <span class="badge badge-success font-helvetica-regular mr-1">ი/მ</span>{{ $order_item->customerType->name }} {{ $order_item->customerType->lastname }}
                                                            @break
                                                            @case(3)
                                                                <span class="badge badge-warning font-helvetica-regular mr-1">შპს</span>{{ $order_item->customerCompany->name }} ({{ $order_item->customerCompany->code }})
                                                            @break
                                                            @endswitch
                                                        </span>
                                                    </td>
                                                    <td class="tb-odr-info">
                                                        <span class="tb-odr-total">
                                                            <span class="amount">{{ number_format($order_item->total_price / 100, 2) }} ₾</span>
                                                        </span>
                                                    </td>
                                                    <td class="tb-odr-info">
                                                        <span class="tb-odr-status">
                                                            @switch($order_item->status)
                                                                @case(1)
                                                                <span class="badge badge-dot badge-primary font-helvetica-regular">ახალი შეკვეთა</span>
                                                                @break
                                                                @case(2)
                                                                <span class="badge badge-dot badge-warning font-helvetica-regular">მიმდინარე შეკვეთა</span>
                                                                @break
                                                                @case(3)
                                                                <span class="badge badge-dot badge-success font-helvetica-regular">დასრულებული</span>
                                                                @break
                                                                @case(4)
                                                                <span class="badge badge-dot badge-danger font-helvetica-regular">გაუქმებული</span>
                                                                @break
                                                            @endswitch
                                                        </span>
                                                    </td>
                                                    <td class="tb-odr-info">
                                                        <span class="tb-odr-status">
                                                            @switch($order_item->rs_send)
                                                                @case(1)
                                                                <span class="badge badge-outline-success font-helvetica-regular">ზედნადები ატვირთულია</span>
                                                                @break
                                                                @case(2)
                                                                <span class="badge badge-outline-danger font-helvetica-regular">ზედნადები გაუქმებულია</span>
                                                                @break
                                                                @case(3)
                                                                <span class="badge badge-outline-warning font-helvetica-regular">ზედნადები არ არის ატვირთული</span>
                                                                @break
                                                            @endswitch
                                                        </span>
                                                    </td>
                                                    <td class="tb-odr-action">
                                                        @if($order_item->deleted_at_int != 0 && $order_item->status != 4)
                                                        <div class="tb-odr-btns d-none d-md-inline">
                                                            <a href="javascript:;" onclick="OrderModal({{ $order_item->id }})" class="btn btn-sm btn-primary font-helvetica-regular">შეკვეთის ნახვა</a>
                                                        </div>
                                                        <div class="dropdown">
                                                            <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown" data-offset="-8,0"><em class="icon ni ni-more-h"></em></a>
                                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-xs">
                                                                <ul class="link-list-plain">
                                                                    <li><a href="{{ route('actionDashboardOrdersEdit', $order_item->id) }}" class="text-primary font-helvetica-regular">რედაქტირება</a></li>
                                                                    <li><a href="javascript:;" onclick="RejectOrder({{ $order_item->id }})" class="text-danger font-helvetica-regular">გაუქმება</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @else 
                                        <div class="example-alert">
                                            <div class="alert alert-info alert-icon">
                                                <em class="icon ni ni-alert-circle"></em> <strong class="font-helvetica-regular">შეკვეთები ვერ მოიძებნა</strong></div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
<div class="modal fade" tabindex="-1" id="OrderModal">
    <div class="modal-dialog modal-xl modal-dialog-top" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>
            <div class="modal-header">
                <h5 class="modal-title font-neue">შეკვეთის დეტალები</h5>
            </div>
            <div class="modal-body py-0">
                <div class="invoice invoice-print">
                    <div class="invoice-wrap">
                        <div class="invoice-head">
                            <div class="invoice-contact">
                                <span class="overline-title font-neue">მომხმარებელი</span>
                                <div class="invoice-contact-info">
                                    <h4 class="title font-helvetica-regular order-customer" style="font-size: 16px;"></h4>
                                </div>
                            </div>
                            <div class="invoice-desc" style="width: 300px;">
                                <ul class="list-plain">
                                    <li class="invoice-id font-helvetica-regular"><span>შეკვეთის ნომერი:</span><span class="modal-order-number"></span></li>
                                    <li class="invoice-date font-helvetica-regular"><span>თარიღი:</span><span class="modal-order-date"></span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="invoice-bills">
                            <div class="table-responsive" style="overflow-x: hidden;">
                                <form id="order_form_data">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr class="font-neue">
                                                <th class="w-150px">კოდი</th>
                                                <th class="w-60">დასახელება</th>
                                                <th>ღირებულება</th>
                                                <th>ერთეული</th>
                                                <th>რეოდენობა</th>
                                                <th>ჯამი</th>
                                                <th>RS</th>
                                            </tr>
                                        </thead>
                                        <tbody id="order_form">
                                            
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4"></td>
                                                <td colspan="1" class="font-neue">ჯამური ღირებულება:</td>
                                                <td class="order_total"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <div class="row send-overhead-form">
                                        
                                    </div>
                                    <input type="hidden" name="order_id" id="order_id">
                                </form>
                            </div>
                            <div class="card card-bordered card-full">
                                <div class="card-inner border-bottom">
                                    <div class="card-title-group">
                                        <div class="card-title">
                                            <h6 class="title font-neue">ზედნადებები</h6>
                                        </div>
                                    </div>
                                </div>
                                <table class="table table-tranx">
                                    <thead class="font-helvetica-regular">
                                        <tr class="tb-tnx-head">
                                            <th class="tb-tnx-id"><span class="">ზედნადების #</span></th>
                                            <th class="tb-tnx-info text-center">
                                                <span>ატვირთვის თარიღი / ატვირთა</span>
                                            </th>
                                            <th class="tb-tnx-info text-center">
                                                <span>გაუქმების თარიღი / გააუქმა</span>
                                            </th>
                                            <th class="tb-tnx-amount is-alt text-center">
                                                <span class="tb-tnx-total">სტატუსი</span>
                                            </th>
                                            <th class="tb-tnx-action">
                                                <span>&nbsp;</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="overhead-list">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light order-buttons">
                
            </div>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" id="OrderOverheadModal">
    <div class="modal-dialog modal-xl modal-dialog-top" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>
            <div class="modal-header">
                <h5 class="modal-title font-neue">ზედნადები #<span class="view_overhead_number"></span> <span class="view_overhead_status ml-2"></span></h5>
            </div>
            <div class="modal-body py-0">
                <div class="invoice invoice-print">
                    <div class="invoice-wrap">
                        <div class="invoice-bills">
                            <div class="row">
                                <div class="col-3">
                                    <span class="font-neue"><b>ზედნადების ტიპი:</b></span>
                                    <br>
                                    <span class="font-neue overhead-type"></span>
                                </div>
                                <div class="col-3">
                                    <span class="font-neue"><b>ზედნადების კატეგორია:</b></span>
                                    <br>
                                    <span class="font-neue overhead-category"></span>
                                </div>
                                <div class="col-3">
                                    <span class="font-neue"><b>ზედნადების ნომერი:</b></span>
                                    <br>
                                    <span class="font-neue overhead-number"></span>
                                </div>
                                <div class="col-3">
                                    <span class="font-neue"><b>ატვირთვის თარიღი:</b></span>
                                    <br>
                                    <span class="font-neue overhead-date"></span>
                                </div>
                                <div class="col-3 overhead-driver mt-4">
                                    
                                </div>
                                <div class="col-3 overhead-car mt-4">
                                    
                                </div>
                                <div class="col-3 address-line-start mt-4">
                                    
                                </div>
                                <div class="col-3 address-line-end mt-4">
                                    
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped" style="margin-top: 15px;">
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
                                    <tbody id="overheads_form">
                                        
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td  colspan="3"></td>
                                            <td class="font-neue">ჯამური ღირებულება:</td>
                                            <td colspan="2" class="overhead-total-sum"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ url('assets/scripts/dashboard_scripts.js') }}"></script>
@endsection