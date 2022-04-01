@extends('layout.layout')

@section('css')

@endsection

@section('content')
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block">
                    <div class="card card-bordered card-stretch">
                        <div class="card-inner-group">
                            <div class="card-inner position-relative card-tools-toggle">
                                <div class="card-title-group">
                                    <div class="card-tools">
                                        <div class="nk-block-head-content">
                                            <h3 class="nk-block-title page-title font-neue">გასაყიდი პანელი</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-inner">
                                <div class="nk-block">
                                    <div class="card card-bordered card-stretch">
                                        <div class="card-inner p-0">
                                            <form id="dashboard_form" class="row">
                                                <div class="col-9">
                                                    <div class="row p-3">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label class="form-label">მომხმარებლის ტიპი</label>
                                                                <div class="form-control-wrap">
                                                                    <select class="form-control" id="customer_type" name="customer_type" onchange="getCustomerFields()">
                                                                        <option value="0"></option>
                                                                        @foreach($customer_type as $type_item)
                                                                        <option value="{{ $type_item->id }}">{{ $type_item->value }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-10">
                                                            <div class="form-group">
                                                                <label class="form-label">პირადი ნომერი</label>
                                                                <div class="form-control-wrap">
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <div class="form-group">
                                                                <label class="form-label">მომხმარებლის ტიპი</label>
                                                                <div class="form-control-wrap">
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    
                                                </div>
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
    </div>
</div>
@endsection

@section('js')
<script src="{{ url('assets/js/libs/dual-listbox.js') }}"></script>
<script src="{{ url('assets/scripts/dashboard_scripts.js') }}"></script>
@endsection