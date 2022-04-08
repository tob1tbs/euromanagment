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
				                <h5 class="card-title font-neue">ახალი პროდუქციის დამატება</h5>
				            </div>
				            <form id="product_form" class="row">
			                    <div class="col-lg-12 mb-2">
			                        <div class="form-group">
			                            <label class="form-label font-helvetica-regular" for="parent_product">მშობელი პროდუქტი</label>
			                            <div class="form-control-wrap">
			                                <select class="form-control" name="parent_product" id="parent_product">
			                                	<option value="0"></option>
			                                	@foreach($parent_products as $product_item)
			                                	<option value="{{ $product_item->id }}">{{ $product_item->name }}</option>
			                                	@endforeach
			                                </select>
			                            </div>
			                        </div>
			                    </div>
			                    <div class="col-lg-4 mb-2">
			                        <div class="form-group">
			                            <label class="form-label font-helvetica-regular" for="product_name">დასახელება</label>
			                            <div class="form-control-wrap">
			                                <input type="text" class="form-control" name="product_name" id="product_name">
			                            </div>
			                        </div>
			                    </div>
			                    <div class="col-lg-4 mb-2">
			                        <div class="form-group">
			                            <label class="form-label font-helvetica-regular" for="product_category">კატეგორია</label>
			                            <div class="form-control-wrap">
			                                <select class="form-control" name="product_category" id="product_category">
			                                	@foreach($categories_list as $category_item)
			                                	<option value="{{ $category_item->id }}">{{ $category_item->name }}</option>
			                                	@endforeach
			                                </select>
			                            </div>
			                        </div>
			                    </div>
			                    <div class="col-lg-4 mb-2">
			                        <div class="form-group">
			                            <label class="form-label font-helvetica-regular" for="product_brand">ბრენდი</label>
			                            <div class="form-control-wrap">
			                                <select class="form-control" name="product_brand" id="product_brand">
			                                	@foreach($brand_list as $brand_item)
			                                	<option value="{{ $brand_item->id }}">{{ $brand_item->name }}</option>
			                                	@endforeach
			                                </select>
			                            </div>
			                        </div>
			                    </div>
			                    <div class="col-lg-4 mb-2">
			                        <div class="form-group">
			                            <label class="form-label font-helvetica-regular" for="product_vendor">მომწოდებელი</label>
			                            <div class="form-control-wrap">
			                                <select class="form-control" name="product_vendor" id="product_vendor">
			                                	@foreach($vendor_list as $vendor_item)
			                                	<option value="{{ $vendor_item->id }}">{{ $vendor_item->name }}</option>
			                                	@endforeach
			                                </select>
			                            </div>
			                        </div>
			                    </div>
			                    <div class="col-lg-4 mb-2">
			                        <div class="form-group">
			                            <label class="form-label font-helvetica-regular" for="product_count">რაოდენობა</label>
			                            <div class="form-control-wrap">
			                                <input type="text" class="form-control" name="product_count" id="product_count">
			                            </div>
			                        </div>
			                    </div>
			                    <div class="col-lg-4 mb-2">
			                        <div class="form-group">
			                            <label class="form-label font-helvetica-regular" for="product_unit">ერთეული</label>
			                            <div class="form-control-wrap">
			                                <select class="form-control" name="product_unit" id="product_unit">
			                                	
			                                </select>
			                            </div>
			                        </div>
			                    </div>
			                    <div class="col-lg-6 mb-2">
			                        <div class="form-group">
			                            <label class="form-label font-helvetica-regular" for="product_branch">ფილიალი</label>
			                            <div class="form-control-wrap">
			                                <select class="form-control" name="product_branch" id="product_branch" onchange="GetWarehouseList()">
			                                	<option value="0"></option>
		                                		@foreach($branch_list as $branch_item)
			                                	<option value="{{ $branch_item->id }}">{{ $branch_item->name }}</option>
			                                	@endforeach
			                                </select>
			                            </div>
			                        </div>
			                    </div>
			                    <div class="col-lg-6 mb-2">
			                        <div class="form-group">
			                            <label class="form-label font-helvetica-regular" for="product_warehouse">საწყობი</label>
			                            <div class="form-control-wrap">
			                                <select class="form-control" name="product_warehouse" id="product_warehouse" disabled> 
			                                	
			                                </select>
			                            </div>
			                        </div>
			                    </div>
			                    <div class="col-lg-4 mb-2">
			                        <div class="form-group">
			                            <label class="form-label font-helvetica-regular" for="product_vendor_price">ასაღები ფასი</label>
			                            <div class="form-control-wrap">
			                                <input type="number" class="form-control" name="product_vendor_price" id="product_vendor_price" value="0">
			                            </div>
			                        </div>
			                    </div>
			                    <div class="col-lg-4 mb-2">
			                        <div class="form-group">
			                            <label class="form-label font-helvetica-regular" for="product_retail_price">საცალო ფასი</label>
			                            <div class="form-control-wrap">
			                                <input type="number" class="form-control" name="product_retail_price" id="product_retail_price" value="0">>
			                            </div>
			                        </div>
			                    </div>
			                    <div class="col-lg-4 mb-2">
			                        <div class="form-group">
			                            <label class="form-label font-helvetica-regular" for="product_wholesale_price">საბითუმო ფასი</label>
			                            <div class="form-control-wrap">
			                                <input type="number" class="form-control" name="product_wholesale_price" id="product_wholesale_price" value="0">>
			                            </div>
			                        </div>
			                    </div>
			                    <div class="col-lg-4 mb-2">
			                    	<button class="btn btn-success font-neue" type="button" onclick="ProductSubmit()">შენახვა</button>
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
<script src="{{ url('assets/scripts/products_scripts.js') }}"></script>
@endsection