@extends('layout.layout')

@section('css')

@endsection

@section('content')
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block nk-block-lg">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <ul class="nav nav-tabs">
                                @foreach($category_list as $category_item)
                                <li class="nav-item"><a class="nav-link @if($loop->first) active @endif font-neue" data-toggle="tab" href="#category_{{ $category_item['id'] }}">{{ $category_item['name'] }}</a></li>
                                @endforeach
                            </ul>
                            <div class="tab-content">
                                @foreach($category_list as $category_item)
                                <div class="tab-pane @if($loop->first) active @endif" id="category_{{ $category_item['id'] }}">
                                    <table class="datatable-init nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                                        <thead>
                                            <tr class="nk-tb-item nk-tb-head font-helvetica-regular">
                                                <th class="nk-tb-col"><span class="sub-text">დასახელება</span></th>
                                                <th class="nk-tb-col tb-col-md"><span class="sub-text">სტატუსი</span></th>
                                                <th class="nk-tb-col nk-tb-col-tools text-right">
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($category_item['payments'] as $payment_item)
                                            <tr class="nk-tb-item">
                                                <td class="nk-tb-col">
                                                    <div class="user-card">
                                                        <div class="user-info">
                                                            <span class="tb-lead font-helvetica-regular">{{ $payment_item['name_ge'] }}                                                                
                                                                <span class="dot dot-success d-md-none ml-1"></span></span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col tb-col-md">
                                                    <div class="form-group">
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input" name="reg-public" id="customer_{{ $payment_item['id'] }}" value="1" @if($payment_item['active'] == 1) checked @endif onclick="PaymentActiveChange({{ $payment_item['id'] }}, this)">
                                                            <label class="custom-control-label" for="customer_{{ $payment_item['id'] }}"></label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col nk-tb-col-tools">
                                                    <ul class="nk-tb-actions gx-1">
                                                        <li>
                                                            <div class="drodown">
                                                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <ul class="link-list-opt no-bdr font-helvetica-regular">
                                                                        <li><a href="javascript:;" onclick="GetPaymentParameters({{ $payment_item['id'] }})"><em class="icon ni ni-activity-round" ></em><span>პარამეტრები</span></a></li>
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
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>            
            </div>
        </div>
    </div>
</div>  
<div class="modal fade" id="payment_parameters" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-center modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-neue">გადახდის პარამეტრები</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" class="form-validate is-alter" id="payment_parameters_form">
                    <div class="row payment-parameter-data">
                        
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <button class="btn btn-success font-helvetica-regular" type="button" onclick="PaymentParametersSubmit()">შენახვა</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ url('assets/scripts/parameters_scripts.js') }}"></script>
@endsection