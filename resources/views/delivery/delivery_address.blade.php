@extends('layout.layout')

@section('css')

@endsection

@section('content')
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block nk-block-lg">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <ul class="nav nav-tabs">
                            	@foreach($address_array as $address_item)
                                <li class="nav-item"><a class="nav-link @if($loop->first == 1) active @endif font-neue" data-toggle="tab" href="#city_{{ $address_item['city_id'] }}">{{ $address_item['city_name'] }}</a></li>
                                @endforeach
                            </ul>
                            <div class="tab-content">
                            	@foreach($address_array as $address_item)
                            	<div class="tab-pane @if($loop->first == 1) active @endif" id="city_{{ $address_item['city_id'] }}">
                            		<table class="datatable-init table font-helvetica-regular">
                                        <thead>
                                            <tr>
                                                <th class="nk-tb-col"><span class="sub-text">ID</span></th>
	                                            <th class="nk-tb-col tb-col-mb"><span class="sub-text">დასახელებაა</span></th>
	                                            <th class="nk-tb-col tb-col-md"><span class="sub-text">მიწოდების ღირებულება</span></th>
	                                            <th class="nk-tb-col tb-col-md"><span class="sub-text">სტატუსი</span></th>
	                                            <th class="nk-tb-col nk-tb-col-tools text-right"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
									 		@foreach($address_item['districts'] as $district_item)
									    	<tr>
									      		<td scope="row">{{ $district_item->id }}</td>
									      		<td>{{ json_decode($district_item->name)->ge }}</td>
									      		<td>
									      			<div class="form-control-wrap"  style="max-width: 200px;">
			                                            <a tabindex="-1" href="#" class="form-icon form-icon-right" onclick="SaveDeliveryPrice({{ $district_item->id }})">
			                                                <em class="passcode-icon icon-show icon ni ni-save"></em>
			                                            </a>
			                                            <input type="number" class="form-control form-control-sm" id="delivery_price_{{ $district_item->id }}" value="{{ $district_item->delivery_price / 100 }}">
			                                        </div>
								      			</td>
									      		<td>
									      			<div class="form-group">
	                                                    <div class="custom-control custom-switch">
	                                                        <input type="checkbox" class="custom-control-input" name="reg-public" id="district_{{ $district_item->id }}" value="1" @if($district_item->active == 1) checked @endif onclick="DistrictActiveChange({{ $district_item->id}}, this)">
	                                                        <label class="custom-control-label" for="district_{{ $district_item->id }}"></label>
	                                                    </div>
	                                                </div>
									      		</td>
									      		<td>
									      			<ul class="nk-tb-actions gx-1">
	                                                    <li>
	                                                        <div class="drodown">
	                                                            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
	                                                            <div class="dropdown-menu dropdown-menu-right" style="width: 300px;">
	                                                                <ul class="link-list-opt no-bdr">
	                                                                    <li>
	                                                                    	<a href="javascript:;" onclick="GetStreetList({{ $district_item->id }})">
	                                                                    		<em class="icon ni ni-activity-round"></em>
	                                                                    		<span>ქუჩების ჩამონათვალი</span>
	                                                                    	</a>
	                                                                    </li>
	                                                                </ul>
	                                                            </div>
	                                                        </div>
	                                                    </li>
	                                                </ul>
	                                            </td>
									    	</tr>
									    	@endforeach
									  </tbody>
									</table>
                            	</div>
                            	@endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="street_modal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-top" role="document" style="max-width: 80%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-neue">ქუჩების ჩამონათვალი</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <table class="datatable-init table font-helvetica-regular" style="margin-bottom: 0;">
                    <thead>
                        <tr>
                            <th class="nk-tb-col"><span class="sub-text">ID</span></th>
                            <th class="nk-tb-col tb-col-mb"><span class="sub-text">ქუჩის დასახელება</span></th>
                            <th class="nk-tb-col tb-col-md"><span class="sub-text">სტატუსი</span></th>
                            <th class="nk-tb-col nk-tb-col-tools text-right"></th>
                        </tr>
                    </thead>
                    <tbody class="street-table-list">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ url('assets/scripts/delivery_scripts.js') }}"></script>
@endsection

