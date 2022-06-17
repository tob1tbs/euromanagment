@extends('layout.layout')

@section('css')

@endsection

@section('content')
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block">
                    <div class="card card-bordered">
                        <div class="card-aside-wrap">
                            <div class="card-inner card-inner-lg p-0">
                            	<ul class="nav nav-tabs pl-4 font-helvetica-regular">
								    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#personal_information">პირადი ინფორმაცია</a></li>
								    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#order_history">შეკვეთების ისტორია</a></li>
								</ul>
								<div class="tab-content mt-0">
								    <div class="tab-pane active" id="personal_information">
								        <div class="nk-block">
                                            <div class="nk-data data-list">
                                                <div class="data-item">
                                                    <div class="data-col">
                                                        <span class="data-label font-neue">სახელი გვარი</span>
                                                        <span class="data-value font-helvetica-regular">@if($customer_data->type == 2) <span class="badge badge-success font-helvetica-regular">ი/მ</span> @endif {{ $customer_data->name }} {{ $customer_data->lastname }}</span>
                                                    </div>
                                                </div>
                                                <div class="data-item">
                                                    <div class="data-col">
                                                        <span class="data-label font-neue">პირადი ნომერი</span>
                                                        <span class="data-value font-helvetica-regular">{{ $customer_data->personal_id }}</span>
                                                    </div>
                                                </div>
                                                <div class="data-item">
                                                    <div class="data-col">
                                                        <span class="data-label font-neue">დაბადების თარიღი</span>
                                                        <span class="data-value font-helvetica-regular">{{ $customer_data->bday }}</span>
                                                    </div>
                                                </div>
                                                <div class="data-item">
                                                    <div class="data-col">
                                                        <span class="data-label font-neue">მისამართი</span>
                                                        <span class="data-value font-helvetica-regular">{{ $customer_data->address }}</span>
                                                    </div>
                                                </div>
                                                <div class="data-item">
                                                    <div class="data-col">
                                                        <span class="data-label font-neue">ტელეფონის ნომერი</span>
                                                        <span class="data-value font-helvetica-regular">{{ $customer_data->phone }}</span>
                                                    </div>
                                                </div>
                                                <div class="data-item">
                                                    <div class="data-col">
                                                        <span class="data-label font-neue">ელ-ფოსტა</span>
                                                        <span class="data-value font-helvetica-regular">{{ $customer_data->email }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
								    </div>
								    <div class="tab-pane" id="order_history">
								    	ORDER HISTORY
								    </div>
								</div>
                            </div>
                            <div class="card-aside card-aside-left user-aside toggle-slide toggle-slide-left toggle-break-lg" data-content="userAside" data-toggle-screen="lg" data-toggle-overlay="true">
                                <div class="card-inner-group" data-simplebar>
                                    <div class="card-inner p-0">
                                        <div class="card-inner p-0">
                                            <ul class="link-list-menu font-helvetica-regular">
                                                <li><a href="javascript:;"><span>პროფილის რედაქტირება</span></a></li>
                                            </ul>
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
<style type="text/css">
    .data-head {
        border-radius: 0;
    }
</style>
@endsection

@section('js')
<script src="{{ url('assets/scripts/customers_scripts.js') }}"></script>
@endsection