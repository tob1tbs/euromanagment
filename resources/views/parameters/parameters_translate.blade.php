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
                        <h4 class="nk-block-title font-neue">თარგმნების ჩამონათვალი</h4>
                    </div>        
                    <div class="nk-block-head-content">
                        <ul class="nk-block-tools g-3">
                            <li>
                                <a href="javascript:;" onclick="TranslateAdd()" class="btn btn-white btn-outline-light">
                                    <em class="icon ni ni-plus"></em>
                                    <span class="font-helvetica-regular">ახალი თარგმანი</span>
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
                            <table class="datatable-init nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                                <thead>
                                    <tr class="nk-tb-item nk-tb-head font-helvetica-regular">
                                        <th class="nk-tb-col"><span class="sub-text">თარგმნის KEY</span></th>
                                        <th class="nk-tb-col"><span class="sub-text">თარგმნის მნიშვნელობა (ქართულად)</span></th>
                                        <th class="nk-tb-col"><span class="sub-text">თარგმნის მნიშვნელობა (ინგლისურად)</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($parameters_translate_list as $translate_item)
                                    <tr class="nk-tb-item">
                                        <td class="nk-tb-col">
                                            <div class="user-card">
                                                <div class="user-info">
                                                    <span class="tb-lead font-helvetica-regular">{{ $translate_item->key}}                                                                
                                                        <span class="dot dot-success d-md-none ml-1"></span></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="nk-tb-col">
                                            <div class="user-card">
                                                <div class="user-info">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control form-control-sm" id="translate_ge_{{ $translate_item->id }}" value="{{ json_decode($translate_item->value)->ge }}" onkeyup="ChangeTranslate({{ $translate_item->id }})">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="nk-tb-col">
                                            <div class="user-card">
                                                <div class="user-info">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control form-control-sm" id="translate_en_{{ $translate_item->id }}" value="{{ json_decode($translate_item->value)->en }}" onkeyup="ChangeTranslate({{ $translate_item->id }})">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
<div class="modal fade" id="translate_add" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-center modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-neue">ახალი თარგმანი</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" class="form-validate is-alter" id="translate_add_form">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label" for="translate_key">თარგმნის KEY</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control translate-input" name="translate_key" id="translate_key">
                                    <small class="font-helvetica-regular error-translate_key text-error text-danger mt-1"></small>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 mt-2">
                            <div class="form-group">
                                <label class="form-label" for="translate_value_ge">თარგმნის მნიშვნელობა (ქართულად)</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control translate-input" name="translate_value_ge" id="translate_value_ge">
                                    <small class="font-helvetica-regular error-translate_value_ge text-error text-danger mt-1"></small>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 mt-2">
                            <div class="form-group">
                                <label class="form-label" for="translate_value_en">თარგმნის მნიშვნელობა (ინგლისურად)</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control translate-input" name="translate_value_en" id="translate_value_en">
                                    <small class="font-helvetica-regular error-translate_value_en text-error text-danger mt-1"></small>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <button class="btn btn-success font-helvetica-regular mt-2" type="button" onclick="TranslateParametersSubmit()">შენახვა</button>
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