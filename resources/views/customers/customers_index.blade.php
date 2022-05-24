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
                            </ul>
                            <div class="tab-content">
                            	<div class="tab-pane active" id="client_item_1"></div>
                            	<div class="tab-pane" id="client_item_2"></div>
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