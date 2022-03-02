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
                                <li class="nav-item"><a class="nav-link active font-neue" data-toggle="tab" href="#basic_parameters">ზოგადი პარამეტრები</a></li>
                                <li class="nav-item"><a class="nav-link font-neue" data-toggle="tab" href="#contact_info">საკონტაქტო ინფორმაცია</a></li>
                                <li class="nav-item"><a class="nav-link font-neue" data-toggle="tab" href="#social_network">სოციალური ქსელები</a></li>
                                <li class="nav-item"><a class="nav-link font-neue" data-toggle="tab" href="#plugins">პლაგინები</a></li>
                                <li class="nav-item"><a class="nav-link font-neue" data-toggle="tab" href="#seo">SEO</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="basic_parameters">
                                    <form action="#" class="gy-3" id="basic_parameters_form">
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
                                        <div class="row g-3 align-center">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-label font-helvetica-regular">&nbsp;</label>
                                                    <div class="form-control-wrap">
                                                        <button class="btn btn-success font-helvetica-regular" onclick="BasicParametersSubmit()" type="button" style="height: 36px;">შენახვა</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="contact_info">
                                    <form action="#" class="gy-3" id="info_parameters_form">
                                        @foreach($parameter_info_list as $info_parameter_item)
                                        @switch($info_parameter_item->type)
                                        @case('input')
                                        <div class="row g-3 align-center">
                                            <div class="col-lg-5">
                                                <div class="form-group">
                                                    <label class="form-label" for="{{ $info_parameter_item->key }}">{{ $info_parameter_item->label }}</label>
                                                    <span class="form-note font-helvetica-regular">{{ $info_parameter_item->snippet }}</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-7">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="{{ $info_parameter_item->key }}" name="{{ $info_parameter_item->key }}" value="{{ $info_parameter_item->value }}" {{ $info_parameter_item->disabled == 1 ? 'disabled' : '' }}>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @break
                                        @case('checkbox')
                                        <div class="row g-3 align-center">
                                            <div class="col-lg-5">
                                                <div class="form-group">
                                                    <label class="form-label" for="{{ $info_parameter_item->key }}">{{ $info_parameter_item->label }}</label>
                                                    <span class="form-note font-helvetica-regular">{{ $info_parameter_item->snippet }}</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-7">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input font-neue" @if($info_parameter_item->value == 1) checked @endif name="{{ $info_parameter_item->key }}" id="{{ $info_parameter_item->key }}" value="1">
                                                            <label class="custom-control-label" for="{{ $info_parameter_item->key }}"></label>
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
                                <div class="tab-pane" id="social_network">
                                    <form action="#" class="gy-3" id="social_parameters_form">
                                        @foreach($parameter_social_list as $social_parameter_item)
                                        @switch($social_parameter_item->type)
                                        @case('input')
                                        <div class="row g-3 align-center">
                                            <div class="col-lg-5">
                                                <div class="form-group">
                                                    <label class="form-label" for="{{ $social_parameter_item->key }}">{{ $social_parameter_item->label }}</label>
                                                    <span class="form-note font-helvetica-regular">{{ $social_parameter_item->snippet }}</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-7">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="{{ $social_parameter_item->key }}" name="{{ $social_parameter_item->key }}" value="{{ $social_parameter_item->value }}" {{ $social_parameter_item->disabled == 1 ? 'disabled' : '' }}>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @break
                                        @case('checkbox')
                                        <div class="row g-3 align-center">
                                            <div class="col-lg-5">
                                                <div class="form-group">
                                                    <label class="form-label" for="{{ $social_parameter_item->key }}">{{ $social_parameter_item->label }}</label>
                                                    <span class="form-note font-helvetica-regular">{{ $social_parameter_item->snippet }}</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-7">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input font-neue" @if($social_parameter_item->value == 1) checked @endif name="{{ $social_parameter_item->key }}" id="{{ $social_parameter_item->key }}" value="1">
                                                            <label class="custom-control-label" for="{{ $social_parameter_item->key }}"></label>
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
                                <div class="tab-pane" id="plugins">
                                    <form action="#" class="gy-3" id="plugin_parameters_form">
                                        @foreach($parameter_plugin_list as $plugin_parameter_item)
                                        @switch($plugin_parameter_item->type)
                                        @case('input')
                                        <div class="row g-3 align-center">
                                            <div class="col-lg-5">
                                                <div class="form-group">
                                                    <label class="form-label" for="{{ $plugin_parameter_item->key }}">{{ $plugin_parameter_item->label }}</label>
                                                    <span class="form-note font-helvetica-regular">{{ $plugin_parameter_item->snippet }}</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-7">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="{{ $plugin_parameter_item->key }}" name="{{ $plugin_parameter_item->key }}" value="{{ $plugin_parameter_item->value }}" {{ $plugin_parameter_item->disabled == 1 ? 'disabled' : '' }}>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @break
                                        @case('checkbox')
                                        <div class="row g-3 align-center">
                                            <div class="col-lg-5">
                                                <div class="form-group">
                                                    <label class="form-label" for="{{ $plugin_parameter_item->key }}">{{ $plugin_parameter_item->label }}</label>
                                                    <span class="form-note font-helvetica-regular">{{ $plugin_parameter_item->snippet }}</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-7">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input font-neue" @if($plugin_parameter_item->value == 1) checked @endif name="{{ $plugin_parameter_item->key }}" id="{{ $plugin_parameter_item->key }}" value="1">
                                                            <label class="custom-control-label" for="{{ $plugin_parameter_item->key }}"></label>
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
                                <div class="tab-pane" id="seo">
                                    333
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
<script src="{{ url('assets/scripts/parameters_scripts.js') }}"></script>
@endsection