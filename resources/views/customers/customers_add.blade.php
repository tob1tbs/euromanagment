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
                        <h4 class="nk-block-title font-neue">ახალი მომხმარებლის დამატება</h4>
                    </div>    
                </div>
            </div>
            <div class="nk-content-body">
                <div class="card card-preview">
                    <div class="card-inner">
                        <form id="customer_form" class="row">
                            <div class="col-8">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label" for="customer_type">მომხმარებლის ტიპი</label>
                                            <select class="form-control" name="customer_type" id="customer_type">
                                                <option value="1">ფიზიკური პირი</option>
                                                <option value="2">იურიდიული პირი</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row company-data" style="display: none;">
                                    <div class="col-12 mt-3">
                                        <h4 class="font-neue">ინფორმაცია კომპანიაზე</h4>
                                        <small class="font-helvetica-regular" style="font-size: 14px;">პირადი ინფორმაცია იქნება გამოყენებული როგორც კომპანიის წარმომადგენილის მონაცემები.</small>
                                    </div>
                                    <div class="col-4 mt-2">
                                        <div class="form-group">
                                            <label class="form-label" for="company_name">კომპანიის დასახელება</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control check-input" name="company_name" id="company_name">
                                                <small class="font-helvetica-regular error-company_name text-error text-danger mt-1"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4 mt-2">
                                        <div class="form-group">
                                            <label class="form-label" for="company_code">კომპანიის საიდენტიფიკაციო კოდი</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control check-input" name="company_code" id="company_code">
                                                <small class="font-helvetica-regular error-company_code text-error text-danger mt-1"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4 mt-2">
                                        <div class="form-group">
                                            <label class="form-label" for="company_address">კომპანიის მისამართი</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control check-input" name="company_address" id="company_address">
                                                <small class="font-helvetica-regular error-company_address text-error text-danger mt-1"></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 mt-3">
                                        <h4 class="font-neue">პირადი ინფორმაცია</h4>
                                    </div>
                                    <div class="col-6 mt-2">
                                        <div class="form-group">
                                            <label class="form-label" for="customer_name">სახელი</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control customer-input" name="customer_name" id="customer_name">
                                                <small class="font-helvetica-regular error-customer_name text-error text-danger mt-1"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 mt-2">
                                        <div class="form-group">
                                            <label class="form-label" for="customer_lastname">გვარი</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control customer-input" name="customer_lastname" id="customer_lastname">
                                                <small class="font-helvetica-regular error-customer_lastname text-error text-danger mt-1"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 mt-2">
                                        <div class="form-group">
                                            <label class="form-label" for="customer_personal_number">პირადი ნომერი</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control customer-input" name="customer_personal_number" id="customer_personal_number">
                                                <small class="font-helvetica-regular error-customer_personal_number text-error text-danger mt-1"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 mt-2">
                                        <div class="form-group">
                                            <label class="form-label" for="customer_bdate">დაბადების თარიღი</label>
                                            <div class="form-control-wrap">
                                                <input type="date" class="form-control customer-input" name="customer_bdate" id="customer_bdate">
                                                <small class="font-helvetica-regular error-customer_bdate text-error text-danger mt-1"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 mt-2">
                                        <div class="form-group">
                                            <label class="form-label" for="customer_phone">ტელეფონის ნომერი</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control customer-input" name="customer_phone" id="customer_phone">
                                                <small class="font-helvetica-regular error-customer_phone text-error text-danger mt-1"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 mt-2">
                                        <div class="form-group">
                                            <label class="form-label" for="customer_email">ელ-ფოსტა</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control customer-input" name="customer_email" id="customer_email">
                                                <small class="font-helvetica-regular error-customer_email text-error text-danger mt-1"></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-success font-neue mt-3" type="button" onclick="CustomerSubmit()">დადასტურება</button>
                            </div>
                            <input type="hidden" name="customer_id" id="customer_id">
                            <input type="hidden" name="company_id" id="company_id">
                        </form>
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