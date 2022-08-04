@extends('layout.layout')

@section('css')

@endsection

@section('content')
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block">
                    <div class="card card-bordered">
                        <div class="card-aside-wrap">
                            <div class="card-inner card-inner-lg" style="padding: 0">
                                <div class="nk-block-head nk-block-head-lg" style="padding: 1.5rem !important;">
                                    <div class="nk-block-between">
                                        <div class="nk-block-head-content">
                                            <h4 class="nk-block-title font-neue">ლოიალობის პროგრამა</h4>
                                            <div class="nk-block-des font-helvetica-regular">
                                                <p>ლოიალობის პროგრამის ფარგლებში დარიცხული სარგებელი.</p>
                                            </div>
                                        </div>
                                        <div class="nk-block-head-content align-self-start d-lg-none">
                                            <a href="#" class="toggle btn btn-icon btn-trigger mt-n1" data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="nk-block">
                                    <ul class="nav nav-tabs font-neue" style="padding: 0 15px;">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#tabItem1">სარგებელი</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#tabItem2">რეფერალების სია</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" style="margin-top: 0">
                                        <div class="tab-pane active" id="tabItem1">
                                            <table class="table table-orders">
                                                <thead class="tb-odr-head">
                                                    <tr class="tb-odr-item font-neue">
                                                        <th class="tb-odr-info">
                                                            <span class="tb-odr-id">თარიღი</span>
                                                        </th>
                                                        <th class="tb-odr-info">
                                                            <span class="tb-odr-id">შეკვეთის #</span>
                                                        </th>
                                                        <th class="tb-odr-amount">
                                                            <span class="tb-odr-total">შეკვეთის ღირებულება</span>
                                                        </th>
                                                        <th class="tb-odr-amount">
                                                            <span class="tb-odr-total">დარიცხული სარგებელი</span>
                                                        </th>
                                                        <th class="tb-odr-amount">
                                                            <span class="tb-odr-total">დაარიცხა</span>
                                                        </th>
                                                        <th class="tb-odr-amount">
                                                            <span class="tb-odr-total">სტატუსი</span>
                                                        </th>
                                                        <th class="tb-odr-action">&nbsp;</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="tb-odr-body">
                                                    @foreach($referal_order_list as $item)
                                                    <tr class="tb-odr-item font-helvetica-regular">
                                                        <td class="tb-odr-info">
                                                            <span class="tb-odr-id"><a href="#">{{ \Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}</a></span>
                                                        </td>
                                                        <td class="tb-odr-info">
                                                            <span class="tb-odr-id"><a href="#">#{{ $item->order_id }}</a></span>
                                                        </td>
                                                        <td class="tb-odr-amount">
                                                            <span class="tb-odr-total">
                                                                <span class="amount">{{ number_format($item->order_amount / 100, 2) }} ₾</span>
                                                            </span>
                                                        </td>
                                                        <td class="tb-odr-amount">
                                                            <span class="tb-odr-total">
                                                                <span class="amount">{{ number_format($item->amount / 100, 2) }} ₾</span>
                                                            </span>
                                                        </td>
                                                        <td class="tb-odr-amount">
                                                            <span class="tb-odr-total">
                                                                <span class="amount">
                                                                    @if(!empty($item->pay_by))
                                                                    {{ $item->payBy->name }} {{ $item->payBy->lastname }}
                                                                    @else
                                                                    -
                                                                    @endif
                                                                </span>
                                                            </span>
                                                        </td>
                                                        <td class="tb-odr-amount">
                                                            <span class="tb-odr-status">
                                                                @switch($item->status) 
                                                                @case(0)   
                                                                <span class="badge badge-dot badge-danger font-helvetica-regular">გადაუხდელი</span>
                                                                @break
                                                                @case(1)   
                                                                <span class="badge badge-dot badge-success font-helvetica-regular">გადახდილი</span>
                                                                @break
                                                                @endswitch
                                                            </span>
                                                        </td>
                                                        <td class="tb-odr-action">
                                                            <div class="dropdown">
                                                                <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown" data-offset="-8,0"><em class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-md">
                                                                    <ul class="link-list-plain font-helvetica-regular">
                                                                        @if($item->status == 0)
                                                                        <li><a href="javascript:;" onclick="PayMoney({{ $item->id }})" class="text-primary">თანხის დარიცხვა</a></li>
                                                                        @else
                                                                        <li><a href="javascript:;" onclick="RemovePayMoney({{ $item->id }})" class="text-danger">გადახდის წაშლა</a></li>
                                                                        @endif
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="tab-pane" id="tabItem2">
                                            <table class="table table-orders">
                                                <thead class="tb-odr-head">
                                                    <tr class="tb-odr-item font-neue">
                                                        <th class="tb-odr-info">
                                                            <span class="tb-odr-id">რეგისტრაციის თარიღი</span>
                                                        </th>
                                                        <th class="tb-odr-info">
                                                            <span class="tb-odr-id">სამართლებრივი ფორმა</span>
                                                        </th>
                                                        <th class="tb-odr-amount">
                                                            <span class="tb-odr-total">ორგანიზაციის / პირის დასახელება</span>
                                                        </th>
                                                        <th class="tb-odr-amount">
                                                            <span class="tb-odr-total">სტატუსი</span>
                                                        </th>
                                                        <th class="tb-odr-action">&nbsp;</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($customers_list as $key => $customer_types)
                                                        @foreach($customer_types as $customer_item)
                                                        <tr class="tb-odr-item font-helvetica-regular">
                                                            <td class="tb-odr-info">
                                                                <span class="tb-odr-id"><a href="#">{{ \Carbon\Carbon::parse($customer_item['created_at'])->format('Y-m-d') }}</a></span>
                                                            </td>
                                                            <td class="tb-odr-info">
                                                                @if($key == 'type_1')
                                                                <span class="badge badge-success font-helvetica-regular">ფ/პ</span> 
                                                                @elseif($key == 'type_2')
                                                                <span class="badge badge-warning font-helvetica-regular">ი/მ</span> 
                                                                @else
                                                                <span class="badge badge-primary font-helvetica-regular">შპს</span> 
                                                                @endif
                                                            </td>
                                                            <td class="tb-odr-amount">
                                                                <span class="tb-odr-total">
                                                                    @if($key == 'type_1' OR $key == 'type_2')
                                                                    <span class="amount">{{ $customer_item['name'] }} {{ $customer_item['lastname'] }} ({{ $customer_item['personal_id'] }})</span>
                                                                    @else
                                                                    <span class="amount">{{ $customer_item['name'] }} ({{ $customer_item['code'] }})</span>
                                                                    @endif
                                                                </span>
                                                            </td>
                                                            <td class="tb-odr-amount">
                                                                <span class="tb-odr-total">
                                                                    @if($customer_item['active'] == 1)
                                                                    <span class="badge badge-dot badge-success font-helvetica-regular">აქტიური</span> 
                                                                    @else
                                                                    <span class="badge badge-dot badge-danger font-helvetica-regular">არააქტიური</span> 
                                                                    @endif
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-aside card-aside-left user-aside toggle-slide toggle-slide-left toggle-break-lg" data-content="userAside" data-toggle-screen="lg" data-toggle-overlay="true">
                                <div class="card-inner-group" data-simplebar>
                                    <div class="card-inner">
                                        <div class="user-card">
                                            <div class="user-info">
                                                <span class="lead-text font-neue">{{ $referal_data->name }} {{ $referal_data->lastname }}</span>
                                                <span class="sub-text font-helvetica-regular">{{ $referal_data->email }} / {{ $referal_data->phone }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-inner">
                                        <div class="user-account-info py-0">
                                            <h6 class="overline-title-alt font-neue">ჩასარიცხი თანხა</h6>
                                            <div class="user-balance">{{ $referal_order_list->where('status', 0)->sum('amount') / 100 }} <small class="currency currency-btc">₾</small></div>
                                            <div class="user-balance-sub font-helvetica-regular">ჯამურად ჩარიცხული თანხა <span>{{ $referal_order_list->where('status', 1)->sum('amount') / 100 }} <span class="currency currency-btc">₾</span></span></div>
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
</div>
@endsection

@section('js')
<script src="{{ url('assets/scripts/customers_scripts.js') }}"></script>
@endsection