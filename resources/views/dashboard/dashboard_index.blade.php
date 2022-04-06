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
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-2">
                                                    <div class="form-group">
                                                        <label class="form-label">მომხმარებლის ტიპი</label>
                                                        <select class="form-control">
                                                            
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="form-group">
                                                        <label class="form-label">საიდენტიფიკაციო კოდი / პირადი ნომერი</label>
                                                        <input type="number" class="form-control" name="">
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="form-group">
                                                        <label class="form-label">მომხმარებლის ტიპი</label>
                                                        <select class="form-control">
                                                            
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card card-bordered card-stretch mt-3">
                                        <div class="card-inner p-0">
                                            <div class="row">
                                                <div class="col-7">
                                                    <div style="background: #f9f9f9; border-right: 1px solid #dedede;">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <table class="table table-striped">
                                                                    <thead>
                                                                        <tr class="font-neue">
                                                                            <th scope="col">დასახელება</th>
                                                                            <th scope="col">ფასი</th>
                                                                            <th scope="col">რაოდენობა</th>
                                                                            <th scope="col">ჯამი</th>
                                                                            <th scope="col">RS</th>
                                                                            <th scope="col">მოქმედება</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <th scope="row">1</th>
                                                                            <td>Mark</td>
                                                                            <td>Otto</td>
                                                                            <td>@mdo</td>
                                                                            <td>
                                                                                <div class="custom-control custom-control-sm custom-checkbox">
                                                                                    <input type="checkbox" class="custom-control-input" id="customCheck2">
                                                                                    <label class="custom-control-label" for="customCheck2"></label>
                                                                                </div>
                                                                            </td>
                                                                            <td>@mdo</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
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
                                                                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tabItem1">პროდუქციის სრული სია</a></li>
                                                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabItem2">კატეგორიები</a></li>
                                                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabItem3">ბრენდები</a></li>
                                                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tabItem4">მომწოდებლები</a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-12 mt-2">
                                                            <div class="tab-content">
                                                                <div class="tab-pane active" style="overflow-y: scroll; overflow-x: hidden; height: 300px;" id="tabItem1">
                                                                    <div class="row">
                                                                        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                                                            <div class="card card-bordered">
                                                                                <img src="..." class="card-img-top" alt="">
                                                                                <div class="card-inner">
                                                                                    
                                                                                </div>
                                                                                <span class="badge badge-dim badge-primary p-1" style="border-radius: 0; font-size: 14px;">150₾</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                                                            <div class="card card-bordered">
                                                                                <img src="..." class="card-img-top" alt="">
                                                                                <div class="card-inner">
                                                                                    
                                                                                </div>
                                                                                <span class="badge badge-dim badge-primary p-1" style="border-radius: 0; font-size: 14px;">150₾</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                                                            <div class="card card-bordered">
                                                                                <img src="..." class="card-img-top" alt="">
                                                                                <div class="card-inner">
                                                                                    
                                                                                </div>
                                                                                <span class="badge badge-dim badge-primary p-1" style="border-radius: 0; font-size: 14px;">150₾</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                                                            <div class="card card-bordered">
                                                                                <img src="..." class="card-img-top" alt="">
                                                                                <div class="card-inner">
                                                                                    
                                                                                </div>
                                                                                <span class="badge badge-dim badge-primary p-1" style="border-radius: 0; font-size: 14px;">150₾</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                                                            <div class="card card-bordered">
                                                                                <img src="..." class="card-img-top" alt="">
                                                                                <div class="card-inner">
                                                                                    
                                                                                </div>
                                                                                <span class="badge badge-dim badge-primary p-1" style="border-radius: 0; font-size: 14px;">150₾</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                                                            <div class="card card-bordered">
                                                                                <img src="..." class="card-img-top" alt="">
                                                                                <div class="card-inner">
                                                                                    
                                                                                </div>
                                                                                <span class="badge badge-dim badge-primary p-1" style="border-radius: 0; font-size: 14px;">150₾</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                                                            <div class="card card-bordered">
                                                                                <img src="..." class="card-img-top" alt="">
                                                                                <div class="card-inner">
                                                                                    
                                                                                </div>
                                                                                <span class="badge badge-dim badge-primary p-1" style="border-radius: 0; font-size: 14px;">150₾</span>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                                                            <div class="card card-bordered">
                                                                                <img src="..." class="card-img-top" alt="">
                                                                                <div class="card-inner">
                                                                                    
                                                                                </div>
                                                                                <span class="badge badge-dim badge-primary p-1" style="border-radius: 0; font-size: 14px;">150₾</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                                                            <div class="card card-bordered">
                                                                                <img src="..." class="card-img-top" alt="">
                                                                                <div class="card-inner">
                                                                                    
                                                                                </div>
                                                                                <span class="badge badge-dim badge-primary p-1" style="border-radius: 0; font-size: 14px;">150₾</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                                                            <div class="card card-bordered">
                                                                                <img src="..." class="card-img-top" alt="">
                                                                                <div class="card-inner">
                                                                                    
                                                                                </div>
                                                                                <span class="badge badge-dim badge-primary p-1" style="border-radius: 0; font-size: 14px;">150₾</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                                                            <div class="card card-bordered">
                                                                                <img src="..." class="card-img-top" alt="">
                                                                                <div class="card-inner">
                                                                                    
                                                                                </div>
                                                                                <span class="badge badge-dim badge-primary p-1" style="border-radius: 0; font-size: 14px;">150₾</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                                                            <div class="card card-bordered">
                                                                                <img src="..." class="card-img-top" alt="">
                                                                                <div class="card-inner">
                                                                                    
                                                                                </div>
                                                                                <span class="badge badge-dim badge-primary p-1" style="border-radius: 0; font-size: 14px;">150₾</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                                                            <div class="card card-bordered">
                                                                                <img src="..." class="card-img-top" alt="">
                                                                                <div class="card-inner">
                                                                                    
                                                                                </div>
                                                                                <span class="badge badge-dim badge-primary p-1" style="border-radius: 0; font-size: 14px;">150₾</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                                                            <div class="card card-bordered">
                                                                                <img src="..." class="card-img-top" alt="">
                                                                                <div class="card-inner">
                                                                                    
                                                                                </div>
                                                                                <span class="badge badge-dim badge-primary p-1" style="border-radius: 0; font-size: 14px;">150₾</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                                                            <div class="card card-bordered">
                                                                                <img src="..." class="card-img-top" alt="">
                                                                                <div class="card-inner">
                                                                                    
                                                                                </div>
                                                                                <span class="badge badge-dim badge-primary p-1" style="border-radius: 0; font-size: 14px;">150₾</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                                                            <div class="card card-bordered">
                                                                                <img src="..." class="card-img-top" alt="">
                                                                                <div class="card-inner">
                                                                                    
                                                                                </div>
                                                                                <span class="badge badge-dim badge-primary p-1" style="border-radius: 0; font-size: 14px;">150₾</span>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                                                            <div class="card card-bordered">
                                                                                <img src="..." class="card-img-top" alt="">
                                                                                <div class="card-inner">
                                                                                    
                                                                                </div>
                                                                                <span class="badge badge-dim badge-primary p-1" style="border-radius: 0; font-size: 14px;">150₾</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                                                            <div class="card card-bordered">
                                                                                <img src="..." class="card-img-top" alt="">
                                                                                <div class="card-inner">
                                                                                    
                                                                                </div>
                                                                                <span class="badge badge-dim badge-primary p-1" style="border-radius: 0; font-size: 14px;">150₾</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                                                            <div class="card card-bordered">
                                                                                <img src="..." class="card-img-top" alt="">
                                                                                <div class="card-inner">
                                                                                    
                                                                                </div>
                                                                                <span class="badge badge-dim badge-primary p-1" style="border-radius: 0; font-size: 14px;">150₾</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                                                            <div class="card card-bordered">
                                                                                <img src="..." class="card-img-top" alt="">
                                                                                <div class="card-inner">
                                                                                    
                                                                                </div>
                                                                                <span class="badge badge-dim badge-primary p-1" style="border-radius: 0; font-size: 14px;">150₾</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                                                            <div class="card card-bordered">
                                                                                <img src="..." class="card-img-top" alt="">
                                                                                <div class="card-inner">
                                                                                    
                                                                                </div>
                                                                                <span class="badge badge-dim badge-primary p-1" style="border-radius: 0; font-size: 14px;">150₾</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                                                            <div class="card card-bordered">
                                                                                <img src="..." class="card-img-top" alt="">
                                                                                <div class="card-inner">
                                                                                    
                                                                                </div>
                                                                                <span class="badge badge-dim badge-primary p-1" style="border-radius: 0; font-size: 14px;">150₾</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                                                            <div class="card card-bordered">
                                                                                <img src="..." class="card-img-top" alt="">
                                                                                <div class="card-inner">
                                                                                    
                                                                                </div>
                                                                                <span class="badge badge-dim badge-primary p-1" style="border-radius: 0; font-size: 14px;">150₾</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                                                            <div class="card card-bordered">
                                                                                <img src="..." class="card-img-top" alt="">
                                                                                <div class="card-inner">
                                                                                    
                                                                                </div>
                                                                                <span class="badge badge-dim badge-primary p-1" style="border-radius: 0; font-size: 14px;">150₾</span>
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
</div>
@endsection

@section('js')
<script src="{{ url('assets/scripts/dashboard_scripts.js') }}"></script>
@endsection