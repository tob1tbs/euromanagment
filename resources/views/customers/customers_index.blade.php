@extends('layout.layout')

@section('css')

@endsection

@section('content')
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-inner">
            <div class="nk-block-head">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h4 class="nk-block-title font-neue">მომხმარებელთა ჩამონათვალი</h4>
                    </div>    
                    <div class="nk-block-head-content">
                        <ul class="nk-block-tools g-3">
                            <li>
                                <a href="{{ route('actionCustomersAdd') }}" class="btn btn-white btn-outline-light">
                                    <em class="icon ni ni-plus"></em>
                                    <span class="font-helvetica-regular">ახალი მომხმარებელი</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="nk-content-body">
                <div class="card card-preview">
                    <div class="card-inner">
                        <ul class="nav nav-tabs">
                            <li class="nav-item"><a class="nav-link active font-neue" data-toggle="tab" href="#customers_list">ფიზიკური პირები</a></li>
                            <li class="nav-item"><a class="nav-link font-neue" data-toggle="tab" href="#company_list">იურიდიული პირები</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="customers_list">
                                <table class="datatable-init nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                                    <thead>
                                        <tr class="nk-tb-item nk-tb-head font-helvetica-regular">
                                            <th class="nk-tb-col"><span class="sub-text">კლიენტი</span></th>
                                            <th class="nk-tb-col tb-col-mb"><span class="sub-text">ტელეფონის ნომერი</span></th>
                                            <th class="nk-tb-col tb-col-md"><span class="sub-text">ელ-ფოსტა</span></th>
                                            <th class="nk-tb-col tb-col-lg"><span class="sub-text">ვერიფიკაცია</span></th>
                                            <th class="nk-tb-col tb-col-lg"><span class="sub-text">ბოლოს შემოვიდა</span></th>
                                            <th class="nk-tb-col tb-col-md"><span class="sub-text">სტატუსი</span></th>
                                            <th class="nk-tb-col nk-tb-col-tools text-right">
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($customers_list as $customer_item)
                                        <tr class="nk-tb-item">
                                            <td class="nk-tb-col">
                                                <div class="user-card">
                                                    <div class="user-info">
                                                        <span class="tb-lead">{{ $customer_item->name }} {{ $customer_item->lastname }}
                                                            <span class="dot dot-success d-md-none ml-1"></span></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="nk-tb-col tb-col-mb">
                                                <span class="tb-amount">{{ $customer_item->phone }}</span>
                                            </td>
                                            <td class="nk-tb-col tb-col-md">
                                                <span>{{ $customer_item->email }}</span>
                                            </td>
                                            <td class="nk-tb-col tb-col-lg" data-order="Email Verified - Kyc Unverified">
                                                <ul class="list-status">
                                                    <li><em class="icon text-success ni ni-check-circle"></em> <span>Email</span></li>
                                                    <li><em class="icon ni ni-alert-circle"></em> <span>KYC</span></li>
                                                </ul>
                                            </td>
                                            <td class="nk-tb-col tb-col-lg">
                                                <span>{{ $customer_item->last_login }}</span>
                                            </td>
                                            <td class="nk-tb-col tb-col-md">
                                                <div class="form-group">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input" name="reg-public" id="customer_{{ $customer_item->id }}" value="1" @if($customer_item->active == 1) checked @endif onclick="CustomersActiveChange({{ $customer_item->id}}, this)">
                                                        <label class="custom-control-label" for="customer_{{ $customer_item->id }}"></label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="nk-tb-col nk-tb-col-tools">
                                                <ul class="nk-tb-actions gx-1">
                                                    <li>
                                                        <div class="drodown">
                                                            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <ul class="link-list-opt no-bdr">
                                                                    <li><a href="#"><em class="icon ni ni-activity-round"></em><span>Activities</span></a></li>
                                                                    <li class="divider"></li>
                                                                    <li><a href="#"><em class="icon ni ni-shield-star"></em><span>Reset Pass</span></a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="company_list">
                                <table class="datatable-init nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                                    <thead>
                                        <tr class="nk-tb-item nk-tb-head font-helvetica-regular">
                                            <th class="nk-tb-col"><span class="sub-text">კომპანიის დასახელება</span></th>
                                            <th class="nk-tb-col tb-col-mb"><span class="sub-text">საიდენტიფიკაციო კოდი</span></th>
                                            <th class="nk-tb-col tb-col-md"><span class="sub-text">საკონტაქტო პირი</span></th>
                                            <th class="nk-tb-col tb-col-md"><span class="sub-text">სტატუსი</span></th>
                                            <th class="nk-tb-col nk-tb-col-tools text-right">
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($company_list as $company_item)
                                        <tr class="nk-tb-item">
                                            <td class="nk-tb-col">
                                                <div class="user-card">
                                                    <div class="user-info">
                                                        <span class="tb-lead">{{ $company_item->name }}
                                                            <span class="dot dot-success d-md-none ml-1"></span></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="nk-tb-col tb-col-mb">
                                                <span class="tb-amount">{{ $company_item->code }}</span>
                                            </td>
                                            <td class="nk-tb-col tb-col-md">
                                                <div class="user-info">
                                                    <span class="tb-lead">{{ $company_item->companyCustomer->name }} {{ $company_item->companyCustomer->lastname }}<span class="dot dot-success d-md-none ml-1"></span></span>
                                                    <span>{{ $company_item->companyCustomer->phone }}</span>
                                                </div>
                                            </td>
                                            <td class="nk-tb-col tb-col-md">
                                                <div class="form-group">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input" name="reg-public" id="company_{{ $company_item->id }}" value="1" @if($company_item->active == 1) checked @endif onclick="CompanyActiveChange({{ $company_item->id}}, this)">
                                                        <label class="custom-control-label" for="company_{{ $company_item->id }}"></label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="nk-tb-col nk-tb-col-tools">
                                                <ul class="nk-tb-actions gx-1">
                                                    <li>
                                                        <div class="drodown">
                                                            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <ul class="link-list-opt no-bdr">
                                                                    <li><a href="#"><em class="icon ni ni-activity-round"></em><span>Activities</span></a></li>
                                                                    <li class="divider"></li>
                                                                    <li><a href="#"><em class="icon ni ni-shield-star"></em><span>Reset Pass</span></a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
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
<script src="{{ url('assets/scripts/customers_scripts.js') }}"></script>
@endsection