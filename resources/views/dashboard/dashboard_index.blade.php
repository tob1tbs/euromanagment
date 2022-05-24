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
                                                                    <tbody class="product-dashboard-list">
                                                                        
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-5">
                                                    <div class="row p-3">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label class="form-label" for="product_search">მოძებნეთ პროდუქტი...</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="text" class="form-control" id="product_search" name="product_search" placeholder="საძიებო სიტყვა..." onkeyup="GetProductList()">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 mt-2">
                                                            <div class="row product-search-body">
                                                                
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
<div class="modal fade" id="ProductInfoModal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-top" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-neue">ინფორმაცია პროდუქტზე</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" class="form-validate is-alter" novalidate="novalidate" id="product_info">
                    <div class="row">
                        <div class="col-9 mb-2">
                            <div class="form-group">
                                <label class="form-label font-helvetica-regular" for="product_name">პროდუქტი / კოდი</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control check-input" name="product_name" id="product_name" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-3 mb-2">
                            <div class="form-group">
                                <label class="form-label font-helvetica-regular" for="product_unit">ერთეული</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control check-input" name="product_unit" id="product_unit" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label font-helvetica-regular" for="product_vendor_price">პროდუქტის ასაღები ფასი</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control check-input" name="product_vendor_price" id="product_vendor_price" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label font-helvetica-regular" for="product_retail_price">პროდუქტის საცალო ფასი</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control check-input" name="product_retail_price" id="product_retail_price" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label font-helvetica-regular" for="product_wholesale_price">პროდუქტის საბითუმო ფასი</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control check-input" name="product_wholesale_price" id="product_wholesale_price" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 mt-2">
                            <button class="btn btn-success font-neue" type="button" onclick="AddToCart()">შეკვეთაში დამატება</button>
                        </div>
                    </div>
                    <input type="hidden" name="product_id" id="product_id">
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ url('assets/scripts/dashboard_scripts.js') }}"></script>
@endsection