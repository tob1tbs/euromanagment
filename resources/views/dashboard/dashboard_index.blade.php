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
                                                <div class="col-7">
                                                    
                                                </div>
                                                <div class="col-5">
                                                    <div class="row p-2">
                                                        <div class="col-12 mt-2">
                                                            <div class="form-group">
                                                                <label class="form-label" for="search_query">ძებნა</label>
                                                                <input type="text" class="form-control focus" id="search_query" placeholder="დასახელება, შტრიხკოდი">
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <ul class="nav nav-tabs font-neue">
                                                                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tabItem1">პროდუქცია</a></li>
                                                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabItem2">კატეგორიები</a></li>
                                                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabItem3">ბრენდები</a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-12 mt-2">
                                                            <div class="tab-content">
                                                                <div class="tab-pane active" id="tabItem1">
                                                                    <div class="row">
                                                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                                                            <div class="card card-bordered">
                                                                                <img src="..." class="card-img-top" alt="">
                                                                                <div class="card-inner">
                                                                                    <h5 class="card-title">Card with stretched link</h5>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                                                            <div class="card card-bordered">
                                                                                <img src="..." class="card-img-top" alt="">
                                                                                <div class="card-inner">
                                                                                    <h5 class="card-title">Card with stretched link</h5>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                                                            <div class="card card-bordered">
                                                                                <img src="..." class="card-img-top" alt="">
                                                                                <div class="card-inner">
                                                                                    <h5 class="card-title">Card with stretched link</h5>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="tab-pane" id="tabItem2">
                                                                    <p>2</p>
                                                                </div>
                                                                <div class="tab-pane" id="tabItem3">
                                                                    <p>3</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
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