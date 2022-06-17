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
				            <div class="card-head">
				                <h5 class="card-title font-neue">ახალი მომხმარებლის დამატება</h5>
				            </div>
				            <form id="product_form">
				            	<div  class="row">
			                   		<div class="col-lg-12 mb-2">
				                        <div class="form-group">
				                            <label class="form-label font-helvetica-regular" for="customer_type">მომხმარებლის ტიპი</label>
				                            <div class="form-control-wrap">
				                                <select class="form-control check-input" name="customer_type" id="customer_type" onchange="GetCustomerType()">
				                                	<option value="0"></option>
				                                	@foreach($customers_fields['customer_type'] as $type_k => $type_v)
				                                	<option value="{{ $type_k }}">{{ $type_v }}</option>
				                                	@endforeach
				                                </select>
				                            </div>
				                        </div>
				                    </div>
			                    </div>
			                    <div class="row step-2">

			                    </div>
			                    <div class="row step-3">

			                    </div>
			                    <div class="row">
			                    	<div class="col-12">
			                    		<button class="btn btn-success font-neue" type="button" onclick="CustomerSubmit()">შენახვა</button>
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
@endsection

@section('js')
<script src="{{ url('assets/scripts/customers_scripts.js') }}"></script>
@endsection