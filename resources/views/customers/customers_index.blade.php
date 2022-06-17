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
                        <h4 class="nk-block-title font-neue">კლიენტების ჩამონათვალი</h4>
                    </div>        
                    <div class="nk-block-head-content">
                        <ul class="nk-block-tools g-3">
                            <li>
                                <a href="{{ route('actionCustomersAdd') }}" class="btn btn-white btn-outline-light">
                                    <em class="icon ni ni-plus"></em>
                                    <span class="font-helvetica-regular">ახალი კლიენტის დამატება</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="nk-content-body">
                <div class="nk-block nk-block-lg">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <ul class="nav nav-tabs">
                            	<li class="nav-item">
                                    <a class="nav-link font-neue active" data-toggle="tab" href="#client_item_1">იურიდიული პირები</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link font-neue" data-toggle="tab" href="#client_item_2">ფიზიკური პირები</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link font-neue" data-toggle="tab" href="#client_item_3">კომპანიები</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                            	<div class="tab-pane active" id="client_item_1">
                                    <table class="datatable-init nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                                        <thead>
                                            <tr class="nk-tb-item nk-tb-head font-neue">
                                                <th class="nk-tb-col"><span class="sub-text">სახელი გვერი</span></th>
                                                <th class="nk-tb-col"><span class="sub-text">ტელეფონის ნომერი</span></th>
                                                <th class="nk-tb-col"><span class="sub-text">ელ-ფოსტა</span></th>
                                                <th class="nk-tb-col"><span class="sub-text">რეგისტრაციის თარიღი</span></th>
                                                <th class="nk-tb-col"><span class="sub-text">სტატუსი</span></th>
                                                <th class="nk-tb-col nk-tb-col-tools text-right"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($customers_list['type_2'] as $customer_item)
                                            <tr class="nk-tb-item font-helvetica-regular">
                                                <td class="nk-tb-col">
                                                    <div class="user-card">
                                                        <div class="user-info">
                                                            <span class="tb-lead">
                                                                <span class="badge badge-success font-helvetica-regular">ი/მ</span> 
                                                                {{ $customer_item->name }} {{ $customer_item->lastname }}
                                                            </span>
                                                            <span>{{ $customer_item->personal_id }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col tb-col-mb">
                                                    <span class="tb-amount">{{ $customer_item->phone }}</span>
                                                </td>
                                                <td class="nk-tb-col tb-col-lg">
                                                    <span class="tb-amount">{{ $customer_item->email }}</span>
                                                </td>
                                                <td class="nk-tb-col tb-col-md">
                                                    <span>{{ \Carbon\Carbon::parse($customer_item->created_at)->format('Y-m-d') }}</span>
                                                </td>
                                                <td class="nk-tb-col tb-col-md">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input" id="user_active_{{ $customer_item->id }}" onclick="CustomerActiveChange({{ $customer_item->id }}, this)" @if($customer_item->active == 1) checked @endif>
                                                        <label class="custom-control-label" for="user_active_{{ $customer_item->id }}"></label>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col nk-tb-col-tools">
                                                    <ul class="nk-tb-actions gx-1">
                                                        <li>
                                                            <div class="drodown">
                                                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <ul class="link-list-opt no-bdr">
                                                                        <li><a href="{{ route('actionCustomerView', $customer_item->id) }}"><em class="icon ni ni-focus"></em><span>პროფილი</span></a></li>
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
                            	<div class="tab-pane" id="client_item_2">
                                    <table class="datatable-init nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                                        <thead>
                                            <tr class="nk-tb-item nk-tb-head font-neue">
                                                <th class="nk-tb-col"><span class="sub-text">სახელი გვერი</span></th>
                                                <th class="nk-tb-col"><span class="sub-text">ტელეფონის ნომერი</span></th>
                                                <th class="nk-tb-col"><span class="sub-text">ელ-ფოსტა</span></th>
                                                <th class="nk-tb-col"><span class="sub-text">რეგისტრაციის თარიღი</span></th>
                                                <th class="nk-tb-col"><span class="sub-text">სტატუსი</span></th>
                                                <th class="nk-tb-col nk-tb-col-tools text-right"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($customers_list['type_1'] as $customer_item)
                                            <tr class="nk-tb-item font-helvetica-regular">
                                                <td class="nk-tb-col">
                                                    <div class="user-card">
                                                        <div class="user-info">
                                                            <span class="tb-lead">{{ $customer_item->name }} {{ $customer_item->lastname }}</span>
                                                            <span>{{ $customer_item->personal_id }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col tb-col-mb">
                                                    <span class="tb-amount">{{ $customer_item->phone }}</span>
                                                </td>
                                                <td class="nk-tb-col tb-col-lg">
                                                    <span class="tb-amount">{{ $customer_item->email }}</span>
                                                </td>
                                                <td class="nk-tb-col tb-col-md">
                                                    <span>{{ \Carbon\Carbon::parse($customer_item->created_at)->format('Y-m-d') }}</span>
                                                </td>
                                                <td class="nk-tb-col tb-col-md">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input" id="user_active_{{ $customer_item->id }}" onclick="CustomerActiveChange({{ $customer_item->id }}, this)" @if($customer_item->active == 1) checked @endif>
                                                        <label class="custom-control-label" for="user_active_{{ $customer_item->id }}"></label>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col nk-tb-col-tools">
                                                    <ul class="nk-tb-actions gx-1">
                                                        <li>
                                                            <div class="drodown">
                                                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <ul class="link-list-opt no-bdr">
                                                                        <li><a href="{{ route('actionCustomerView', $customer_item->id) }}"><em class="icon ni ni-focus"></em><span>პროფილი</span></a></li>
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
                                <div class="tab-pane" id="client_item_3">
                                    <table class="datatable-init nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                                        <thead>
                                            <tr class="nk-tb-item nk-tb-head font-neue">
                                                <th class="nk-tb-col"><span class="sub-text">დასახელება</span></th>
                                                <th class="nk-tb-col"><span class="sub-text">საკონტაქტო პირი</span></th>
                                                <th class="nk-tb-col"><span class="sub-text">ტელეფონის ნომერი</span></th>
                                                <th class="nk-tb-col"><span class="sub-text">ელ-ფოსტა</span></th>
                                                <th class="nk-tb-col"><span class="sub-text">რეგისტრაციის თარიღი</span></th>
                                                <th class="nk-tb-col"><span class="sub-text">სტატუსი</span></th>
                                                <th class="nk-tb-col nk-tb-col-tools text-right"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($customers_list['type_3'] as $company_item)
                                            <tr class="nk-tb-item font-helvetica-regular">
                                                <td class="nk-tb-col">
                                                    <div class="user-card">
                                                        <div class="user-info">
                                                            <span class="tb-lead">{{ $company_item->name }}</span>
                                                            <span>{{ $company_item->code }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col tb-col-mb">
                                                    <span class="tb-amount">{{ $company_item->contact }}</span>
                                                </td>
                                                <td class="nk-tb-col tb-col-mb">
                                                    <span class="tb-amount">{{ $company_item->phone }}</span>
                                                </td>
                                                <td class="nk-tb-col tb-col-lg">
                                                    <span class="tb-amount">{{ $company_item->email }}</span>
                                                </td>
                                                <td class="nk-tb-col tb-col-md">
                                                    <span>{{ \Carbon\Carbon::parse($company_item->created_at)->format('Y-m-d') }}</span>
                                                </td>
                                                <td class="nk-tb-col tb-col-md">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input" id="user_active_{{ $company_item->id }}" onclick="CustomerActiveChange({{ $company_item->id }}, this)" @if($company_item->active == 1) checked @endif>
                                                        <label class="custom-control-label" for="user_active_{{ $company_item->id }}"></label>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col nk-tb-col-tools">
                                                    <ul class="nk-tb-actions gx-1">
                                                        <li>
                                                            <div class="drodown">
                                                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <ul class="link-list-opt no-bdr">
                                                                        <li><a href="{{ route('actionCustomerView', $company_item->id) }}"><em class="icon ni ni-focus"></em><span>პროფილი</span></a></li>
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
</div>
@endsection

@section('js')

@endsection