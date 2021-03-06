@extends('layout.layout')

@section('css')

@endsection

@section('content')
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-msg">
                    <div class="nk-msg-aside">
                        <div class="nk-msg-nav">
                            <div class="row py-3">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="product_search">მოძებნეთ პროდუქტი...</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="product_search" name="product_search" placeholder="საძიებო სიტყვა..." onkeyup="GetProductList()">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="nk-msg-list p-2" data-simplebar style="overflow-x: hidden;">
                            <div class="product-search-body row">

                            </div>
                        </div>
                    </div>
                    <div class="nk-msg-body bg-white profile-shown" style="padding-right: 400px;">
                        <div class="nk-msg-reply nk-reply" data-simplebar>
                            <table class="table table-striped" style="margin-top: -1px;">
                                <thead>
                                    <tr class="font-neue">
                                        <th scope="col">დასახელება</th>
                                        <th scope="col">ერთეული</th>
                                        <th scope="col">რაოდენობა</th>
                                        <th scope="col">ფასი</th>
                                        <th scope="col">ჯამი</th>
                                        <th scope="col">მოქმედება</th>
                                    </tr>
                                </thead>
                                <tbody class="product-dashboard-list">
                                    @if(count(Cart::getContent()) > 0)
                                        @foreach(Cart::getContent() as $cart_item)
                                        <tr class="dashboard-item-{{ $cart_item->id }} font-helvetica-regular">
                                            <th>{{ $cart_item->name }}</th>
                                            <td>{{ $cart_item->attributes->unit }}</td>
                                            <td>
                                                <div class="form-control-wrap number-spinner-wrap" style="width: 150px;">
                                                    <button class="btn btn-icon btn-outline-light number-spinner-btn number-minus" data-number="minus" onclick="UpdateQuantityMinus({{ $cart_item->id }})"><em class="icon ni ni-minus"></em></button>
                                                    <input type="number" class="form-control number-spinner item-quantity-{{ $cart_item->id }}" value="{{ $cart_item->quantity }}">
                                                    <button class="btn btn-icon btn-outline-light number-spinner-btn number-plus" data-number="plus" onclick="UpdateQuantityPlus({{ $cart_item->id }})"><em class="icon ni ni-plus"></em></button>
                                                </div>
                                            </td>
                                            <td>{{ $cart_item->price / 100 }} ₾</td>
                                            <td class="total_price-{{ $cart_item->id }}">{{ $cart_item->quantity * ($cart_item->price / 100) }} ₾</td>
                                            <td>
                                                <a href="javascript:;" onclick="RemoveFromCart({{ $cart_item->id }})" class="btn btn-primary font-neue btn-dim d-none d-sm-inline-flex" data-toggle="dropdown">
                                                    <em class="icon ni ni-trash"></em>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                    <tr style="background-color: white;">
                                        <th colspan="7">
                                            <div class="example-alert">
                                                <div class="alert alert-info alert-icon">
                                                    <em class="icon ni ni-alert-circle"></em> 
                                                    <strong class="font-helvetica-regular">შეკვეთა ცარიელია.</strong>
                                                </div>
                                            </div>
                                        </th>
                                    </tr>
                                    @endif
                                </tbody>
                                <tfoot class="tfoot-buttons">
                                    @if(count(Cart::getContent()) > 0)
                                    <tr>
                                      <td colspan="2">
                                            <div>
                                                <button class="btn btn-danger font-neue" onclick="ClearCart()">შეკვეთის გასუფთავება</button>
                                                <button class="btn btn-success font-neue" onclick="MakeOrder()">შეკვეთის განთავსება</button>
                                            </div>
                                      </td>
                                      <td>
                                          <center><span class="badge badge-success item-counts">{{ Cart::getTotalQuantity() }}</span></center>
                                      </td>
                                      <td></td>
                                      <td colspan="3">
                                          <span class="badge badge-success item_total_price">{{ Cart::getTotal() / 100 }} ₾</span>
                                      </td>
                                    </tr>
                                    @endif
                                </tfoot>
                            </table>
                        </div>
                        <div class="nk-msg-profile visible  p-3" data-simplebar style="width: 400px;">
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <div class="form-group">
                                        <label class="form-label" for="order_customer_type">კლიენტის ტიპი:</label>
                                        <div class="form-control-wrap">
                                            <select class="form-control" id="order_customer_type" name="order_customer_type">
                                                <option value="0"></option>
                                                @foreach($customer_type['customer_type'] as $customer_k => $customer_value)
                                                <option value="{{ $customer_k }}">{{ $customer_value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="form-group">
                                        <label class="form-label" for="order_customer_code">ს.კ ან პირადი ნომერი:</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="order_customer_code" name="order_customer_code">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-2 d-flex justify-content-center">
                                    <button class="btn btn-success font-neue" onclick="ExportCustomerData()">ექსპროტი</button>
                                    <button class="btn btn-danger font-neue ml-2" onclick="ClearCustomerFields()">გასუფთავება</button>
                                </div>
                                <div class="col-12">
                                    <div class="customer-data-body"></div>
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
<form id="order_detail">
    <input type="hidden" name="order_id" id="order_id">        
    <input type="hidden" name="customer_type" id="customer_type">        
    <input type="hidden" name="customer_id" id="customer_id">        
</form>
@endsection

@section('js')
<script src="{{ url('assets/scripts/dashboard_scripts.js') }}"></script>
@endsection