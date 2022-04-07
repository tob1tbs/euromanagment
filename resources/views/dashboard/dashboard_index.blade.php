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
                                    <div class="card card-bordered card-stretch mt-3">
                                        <div class="card-inner p-0">
                                            <div class="row">
                                                <div class="col-8">
                                                    <div style="background: #f9f9f9; border-right: 1px solid #dedede;">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="col-12 mb-2 p-2">
                                                                    <div class="form-group">
                                                                        <label class="form-label">პროდუქტი</label>
                                                                        <select class="form-select form-control form-control-lg" data-search="on">
                                                                            <option value="0">პროდუქტის ძიება...</option>
                                                                            <option value="1">0000000220-123</option>
                                                                            <option value="2">431</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <table class="table table-striped" style="border-top: 1px solid #dedede;">
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
                                                <div class="col-4">
                                                    <div class="row p-3">
                                                        <div class="col-6 mb-2">
                                                            <div class="form-group">
                                                                <label class="form-label">მომხმარებლის ტიპი</label>
                                                                <select class="form-control">
                                                                    
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 mb-2">
                                                            <div class="form-group">
                                                                <label class="form-label">ს.კოდი / პირადი ნომერი</label>
                                                                <input type="number" class="form-control" name="">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 mb-2">
                                                            <div class="form-group">
                                                                <label class="form-label">მომხმარებლის ტიპი</label>
                                                                <select class="form-control">
                                                                    
                                                                </select>
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