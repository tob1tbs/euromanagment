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
                                <li class="nav-item"><a class="nav-link active font-neue" data-toggle="tab" href="#delivery_parameters">მიწოდების პარამეტრები</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="delivery_parameters">
                                    <form action="#" class="gy-3" id="delivery_parameters_form">
                                        @foreach($parameter_list as $parameter_item)
                                        @switch($parameter_item->type)
                                        @case('input')
                                        <div class="row g-3 align-center">
                                            <div class="col-lg-5">
                                                <div class="form-group">
                                                    <label class="form-label" for="{{ $parameter_item->key }}">{{ $parameter_item->label }}</label>
                                                    <span class="form-note font-helvetica-regular">{{ $parameter_item->snippet }}</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-7">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="{{ $parameter_item->key }}" name="{{ $parameter_item->key }}" value="{{ $parameter_item->value }}" {{ $parameter_item->disabled == 1 ? 'disabled' : '' }}>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @break
                                        @case('number')
                                        <div class="row g-3 align-center">
                                            <div class="col-lg-5">
                                                <div class="form-group">
                                                    <label class="form-label" for="{{ $parameter_item->key }}">{{ $parameter_item->label }}</label>
                                                    <span class="form-note font-helvetica-regular">{{ $parameter_item->snippet }}</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-7">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <input type="number" class="form-control" id="{{ $parameter_item->key }}" name="{{ $parameter_item->key }}" value="{{ $parameter_item->value }}" {{ $parameter_item->disabled == 1 ? 'disabled' : '' }}>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @break
                                        @case('checkbox')
                                        <div class="row g-3 align-center">
                                            <div class="col-lg-5">
                                                <div class="form-group">
                                                    <label class="form-label" for="{{ $parameter_item->key }}">{{ $parameter_item->label }}</label>
                                                    <span class="form-note font-helvetica-regular">{{ $parameter_item->snippet }}</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-7">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input font-neue" @if($parameter_item->value == 1) checked @endif name="{{ $parameter_item->key }}" id="{{ $parameter_item->key }}" value="1">
                                                            <label class="custom-control-label" for="{{ $parameter_item->key }}"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @break
                                        @endswitch
                                        @endforeach
                                    </form>
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