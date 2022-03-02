@extends('layout.layout')

@section('css')
<link rel="stylesheet" href="{{ url('assets/css/editors/summernote.css') }}" />
@endsection

@section('content')
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-inner">
            <div class="nk-block-head">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h4 class="nk-block-title font-neue">ახალი პროდუქტის დამატება</h4>
                    </div>    
                </div>
            </div>
            <div class="nk-content-body card-bordered">
                <div class="card card-preview">
                    <form id="product_form" class="row">
                        <div class="col-lg-8">
                            <div class="card-inner">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item"><a class="nav-link active font-neue" data-toggle="tab" href="#basic_parameters">ძირითადი პარამეტრები</a></li>
                                    <li class="nav-item"><a class="nav-link font-neue" data-toggle="tab" href="#product_gallery">პროდუქტის სურათები</a></li>
                                    <li class="nav-item"><a class="nav-link font-neue" data-toggle="tab" href="#product_parameters">პროდუქტის დამატებითი პარამეტრები</a></li>
                                    <li class="nav-item"><a class="nav-link font-neue" data-toggle="tab" href="#product_seo">SEO</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="basic_parameters">
                                        <div class="row">
                                            <div class="col-10 mt-2">
                                                <div class="form-group">
                                                    <label class="form-label" for="product_parent">მშობელი პროდუქტი</label>
                                                    <select class="form-control" name="product_parent" id="product_parent">
                                                        <option value="0"></option>
                                                        @foreach($product_list as $product_item)
                                                        <option value="{{ $product_item->id }}">{{ $product_item->name_ge }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <button type="button" class="btn btn-success float-right font-helvetica-regular" style="font-size: 12px; margin-top: 43px;" onclick="ImportParentProduct()">მონაცემთა იმპორტი</button>
                                            </div>
                                            <div class="col-4 mt-2">
                                                <div class="form-group">
                                                    <label class="form-label" for="product_category">პროდუქტის კატეგორია</label>
                                                    <select class="form-control" name="product_category" id="product_category" onchange="GetSubCategoryAndBrandList() ">
                                                        <option value="0"></option>
                                                        @foreach($product_category_list as $category_item)
                                                        <option value="{{ $category_item->id }}">{{ json_decode($category_item->name)->ge }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-4 mt-2">
                                                <div class="form-group">
                                                    <label class="form-label" for="product_child_category">პროდუქტის ქვეკატეგორია</label>
                                                    <select class="form-control" name="product_child_category" id="product_child_category" disabled onchange="GetBrandByChildCategory()">
                                                        <option value="0"></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-4 mt-2">
                                                <div class="form-group">
                                                    <label class="form-label" for="product_brand">პროდუქტის ბრენდი</label>
                                                    <select class="form-control" name="product_brand" id="product_brand" disabled>
                                                        <option value="0"></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 mt-2">
                                                <div class="form-group">
                                                    <label class="form-label" for="product_name_ge">პროდუქტის დასახელება (ქართულად)</label>
                                                    <input type="text" name="product_name_ge" id="product_name_ge" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-12 mt-2">
                                                <div class="form-group">
                                                    <label class="form-label" for="product_description_ge">პროდუქტის აღწერა (ქართულად)</label>
                                                    <textarea class="summernote" name="product_description_ge" id="product_description_ge"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-12 mt-2">
                                                <div class="form-group">
                                                    <label class="form-label" for="product_brand">პროდუქტის დასახელება (ინგლისურად)</label>
                                                    <input type="text" name="product_name_en" id="product_name_en" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-12 mt-2">
                                                <div class="form-group">
                                                    <label class="form-label" for="product_description_en">პროდუქტის აღწერა (ინგლისურად)</label>
                                                    <textarea class="summernote" name="product_description_en" id="product_description_en"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="product_gallery">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <input id="thumbnail" class="form-control" type="text" style="width: 85%; float: left;">
                                                    <input type="hidden" name="product_photo" id="product_photo">
                                                    <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-light font-helvetica-regular" style="max-width: 15%; float: right;">სურათის არჩევა</a>
                                                </div>
                                            </div>
                                            <div class="col-12 mt-2">
                                                <div class="nk-fmg-quick-list nk-block">
                                                    <div class="toggle-expand-content expanded" data-content="quick-access">
                                                        <div class="nk-files nk-files-view-grid">
                                                            <div class="nk-files-list">
                                                                <div class="nk-file-item nk-file">
                                                                    <div class="nk-file-info" id="holder">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="product_parameters">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="alert alert-fill alert-warning alert-icon font-helvetica-regular">
                                                    <em class="icon ni ni-alert-circle"></em> 
                                                    პარამეტრების სანახავად გთხოვთ აირჩით პროდუქტის კატეგორია.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="product_seo">
                                        <div class="row">
                                            <div class="col-lg-6 mt-2">
                                                <div class="form-group">
                                                    <label class="form-label" for="product_meta_keywords_ge">პროდუქტის მეტა KEYWORDS (ქართულად)</label>
                                                    <input type="text" name="product_meta_keywords_ge" id="product_meta_keywords_ge" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 mt-2">
                                                <div class="form-group">
                                                    <label class="form-label" for="product_meta_keywords_en">პროდუქტის მეტა KEYWORDS (ინგლისურად)</label>
                                                    <input type="text" name="product_meta_keywords_en" id="product_meta_keywords_en" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 mt-2">
                                                <div class="form-group">
                                                    <label class="form-label" for="product_meta_description_ge">პროდუქტის მეტა DESCRIPTION (ქართულად)</label>
                                                    <input type="text" name="product_meta_description_ge" id="product_meta_description_ge" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 mt-2">
                                                <div class="form-group">
                                                    <label class="form-label" for="product_meta_description_en">პროდუქტის მეტა DESCRIPTION (ინგლისურად)</label>
                                                    <input type="text" name="product_meta_description_en" id="product_meta_description_en" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card-inner">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label" for="product_status">პროდუქტის სტატუსი</label>
                                            <select class="form-control" name="product_status" id="product_status">
                                                @foreach($product_status as $status_item)
                                                <option value="{{ $status_item->id }}">{{ $status_item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <div class="form-group">
                                            <label class="form-label" for="product_vendor">პროდუქტის მომწოდებელი</label>
                                            <select class="form-control" name="product_vendor" id="product_vendor">
                                                @foreach($product_vendor_list as $vendor_item)
                                                <option value="{{ $vendor_item->id }}">{{ $vendor_item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <div class="form-group">
                                            <label class="form-label" for="product_price">პროდუქტის ღირებულება</label>
                                            <input type="text" name="product_price" id="product_price" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-6 mt-2">
                                        <div class="form-group">
                                            <label class="form-label" for="product_discount_price">პროდუქტის ფასდაკლების თანხა</label>
                                            <input type="number" name="product_discount_price" id="product_discount_price" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-6 mt-2">
                                        <div class="form-group">
                                            <label class="form-label" for="product_discount_percent">პროდუქტის ფასდაკლების %</label>
                                            <input type="number" name="product_discount_percent" id="product_discount_percent" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <div class="form-group">
                                            <label class="form-label" for="product_count">პროდუქტის რაოდენობა</label>
                                            <input type="number" name="product_count" id="product_count" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-6 mt-2">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" name="product_in_stock" value="1" id="product_in_stock">
                                            <label class="custom-control-label form-label" for="product_in_stock" >მარაგშია</label>
                                        </div>
                                    </div>
                                    <div class="col-6 mt-2">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" name="product_preorder" value="1" id="product_preorder">
                                            <label class="custom-control-label form-label" for="product_preorder">წინასწარი შეკვეთით</label>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <button class="btn btn-success font-neue" type="button" onclick="ProductSubmit()">შენახვა</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="product_id" id="product_id">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>  
@endsection

@section('js')
<script type="text/javascript" src="{{ url('assets/js/jquery-ui.min.js') }}"></script>
<script src="{{ url('assets/scripts/products_scripts.js') }}"></script>
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{ url('assets/js/libs/editors/summernote.js') }}"></script>
<script src="{{ url('assets/js/editors.js') }}"></script>
<script type="text/javascript">
    var route_prefix = "{{ url('filemanager') }}";
    $('#lfm').filemanager('image', {prefix: route_prefix});

    $(document).ready(function() {
        $('.summernote').summernote();
    });
</script>
@endsection