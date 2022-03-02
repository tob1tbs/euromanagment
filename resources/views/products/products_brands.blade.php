@extends('layout.layout')

@section('css')

@endsection

@section('content')
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <div class="toggle-wrap nk-block-tools-toggle">
                                <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                                <div class="toggle-expand-content" data-content="pageMenu">
                                    <ul class="nk-block-tools g-3">
                                        <li class="nk-block-tools-opt">
                                            <div class="drodown">
                                                <a href="#" class="dropdown-toggle btn btn-icon btn-primary" data-toggle="dropdown"><em class="icon ni ni-plus"></em></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <ul class="link-list-opt no-bdr font-helvetica-regular">
                                                        <li><a href="javascript:;" onclick="BrandModal()"><span>ბრენდის დამატება</span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="nk-block">
                    <div class="card card-bordered card-stretch">
                        <div class="card-inner-group">
                            <div class="card-inner position-relative card-tools-toggle">
                                <div class="card-title-group">
                                    <div class="card-tools">
                                        <div class="nk-block-head-content">
                                            <h3 class="nk-block-title page-title font-neue">ბრენდები ჩამონათვალი</h3>
                                        </div>
                                    </div>
                                    <div class="card-tools mr-n1">
                                        <ul class="btn-toolbar gx-1">
                                            <li>
                                                <div class="toggle-wrap">
                                                    <a href="#" class="btn btn-icon btn-trigger toggle" data-target="cardTools"><em class="icon ni ni-menu-right"></em></a>
                                                    <div class="toggle-content" data-content="cardTools">
                                                        <ul class="btn-toolbar gx-1">
                                                            <li class="toggle-close">
                                                                <a href="#" class="btn btn-icon btn-trigger toggle" data-target="cardTools"><em class="icon ni ni-arrow-left"></em></a>
                                                            </li>
                                                            <li>
                                                                <div class="dropdown">
                                                                    <a href="#" class="btn btn-trigger btn-icon dropdown-toggle" data-toggle="dropdown">
                                                                        <div class="dot dot-primary"></div>
                                                                        <em class="icon ni ni-filter-alt"></em>
                                                                    </a>
                                                                    <div class="filter-wg dropdown-menu dropdown-menu-xl dropdown-menu-right">
                                                                        <div class="dropdown-head">
                                                                            <span class="sub-title dropdown-title font-neue">ბრენდები ფილტრი</span>
                                                                            <div class="dropdown">
                                                                                <a href="#" class="btn btn-sm btn-icon">
                                                                                    <em class="icon ni ni-more-h"></em>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="dropdown-body dropdown-body-rg">
                                                                            <form method="get" class="row gx-6 gy-3">
                                                                                <div class="col-6">
                                                                                    <div class="form-group">
                                                                                        <label class="font-helvetica-regular overline-title overline-title-alt">ბრენდის სახელი <br></label>
                                                                                        <input type="text" class="form-control" name="search_query" value="{{ request()->search_query }}">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <div class="form-group">
                                                                                        <label class="font-helvetica-regular overline-title overline-title-alt">სტატუსი</label>
                                                                                        <select class="form-select form-select-sm" name="brand_active">
                                                                                          
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <div class="form-group">
                                                                                        <label class="font-helvetica-regular overline-title overline-title-alt">სორტირება</label>
                                                                                        <select class="form-select form-select-sm" name="sort_by">
                                                                                           
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <div class="form-group">
                                                                                        <label class="font-helvetica-regular overline-title overline-title-alt">რაოდენობა</label>
                                                                                        <select class="form-select form-select-sm" name="count">
                                                                                          
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <div class="form-group">
                                                                                        <button type="submit" class="btn btn-secondary font-neue">გაფილტვრა</button>
                                                                                        <a href="" class="btn btn-primary font-neue">ფილტრის გასუფთავება</a>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card-inner p-0">
                                <div class="nk-tb-list nk-tb-ulist" id="brand_sortable">
                                    <div class="nk-tb-item nk-tb-head font-helvetica-regular">
                                        <div class="nk-tb-col"><span class="sub-text">ID</span></div>
                                        <div class="nk-tb-col"><span class="sub-text">სორტირება</span></div>
                                        <div class="nk-tb-col"><span class="sub-text">ბრენდის დასახელება (ქართულად / ინგლისურად)</span></div>
                                        <div class="nk-tb-col"><span class="sub-text">კატეგორია / ქვეკატეგორია</span></div>
                                        <div class="nk-tb-col tb-col-md"><span class="sub-text">სტატუსი</span></div>
                                        <div class="nk-tb-col nk-tb-col-tools text-right"></div>
                                    </div>
                                    @foreach($product_brand_list as $brand_item)
                                    <div class="nk-tb-item font-helvetica-regular" id="brand_item-{{ $brand_item->id }}">
                                        <div class="nk-tb-col">
                                            <a href="javascript:;">
                                                <div class="user-card">
                                                    <div class="user-info">
                                                        <span class="tb-lead">{{ $brand_item->id }}<span class="dot dot-success d-md-none ml-1"></span></span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="nk-tb-col">
                                            <a href="javascript:;">
                                                <div class="user-card">
                                                    <div class="user-info">
                                                        <span class="tb-lead">{{ $brand_item->sortable }}<span class="dot dot-success d-md-none ml-1"></span></span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="nk-tb-col">
                                            <a href="javascript:;">
                                                <div class="user-card">
                                                    <div class="user-info">
                                                        <span class="tb-lead">{{ json_decode($brand_item->name)->ge }} / {{ json_decode($brand_item->name)->en }}<span class="dot dot-success d-md-none ml-1"></span></span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="nk-tb-col">
                                            <a href="javascript:;">
                                                <div class="user-card">
                                                    <div class="user-info">
                                                        <span class="tb-lead">
                                                            @if(!empty($brand_item->category_id)) {{ json_decode($brand_item->getCategoryData->name)->ge }}@endif
                                                            @if(!empty($brand_item->child_category_id))  / {{ json_decode($brand_item->getChildCategoryData->name)->ge }} @endif
                                                            <span class="dot dot-success d-md-none ml-1"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="nk-tb-col tb-col-md">
                                            @if($brand_item->id != 1)
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="brand_active_{{ $brand_item->id }}" onclick="BrandActiveChange({{ $brand_item->id }}, this)" @if($brand_item->active == 1) checked @endif>
                                                <label class="custom-control-label" for="brand_active_{{ $brand_item->id }}"></label>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="nk-tb-col nk-tb-col-tools">
                                            @if($brand_item->id != 1)
                                            <ul class="nk-tb-actions gx-1">
                                                <li>
                                                    <div class="drodown">
                                                        <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                        <div class="dropdown-menu dropdown-menu-right" style="width: 240px;">
                                                            <ul class="link-list-opt no-bdr">
                                                                <li>
                                                                    <a href="javascript:;" onclick="BrandEdit({{ $brand_item->id }})">
                                                                        <em class="icon ni ni-dot"></em>
                                                                        <span>რედაქტირება</span>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="javascript:;" onclick="BrandDelete({{ $brand_item->id }})" class="text-danger">
                                                                        <em class="icon ni ni-trash"></em>
                                                                        <span>ბრენდის წაშლა</span>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="card-inner">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="BrandModal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-neue brand-modal-head"></h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" class="form-validate is-alter row" novalidate="novalidate" id="brand_form">
                    <div class="form-group col-lg-6">
                        <label class="form-label font-helvetica-regular" for="brand_name_ge">ბრენდის დასახელება (ქართულად) *</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control check-input" name="brand_name_ge" id="brand_name_ge">
                            <small class="brand_name_ge-error text-error text-danger mt-1"></small>
                        </div>
                    </div>
                    <div class="form-group col-lg-6">
                        <label class="form-label font-helvetica-regular" for="brand_name_en">ბრენდის დასახელება (ინგლისურად)</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" name="brand_name_en" id="brand_name_en">
                        </div>
                    </div>
                    <div class="form-group col-lg-6">
                        <label class="form-label font-helvetica-regular" for="brand_category_id">ბრენდის კატეგორია</label>
                        <div class="form-control-wrap">
                            <select class="form-control" name="brand_category_id" id="brand_category_id" onchange="GetSubCategoryList('brand_category_id', 'brand_child_category_id')">
                                <option value="0"></option>
                                @foreach($product_category_list as $category_item)
                                <option value="{{ $category_item->id }}">{{ json_decode($category_item->name)->ge }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-lg-6">
                        <label class="form-label font-helvetica-regular" for="brand_child_category_id">ბრენდის ქვეკატეგორიები</label>
                        <div class="form-control-wrap">
                            <select class="form-control" id="brand_child_category_id" name="brand_child_category_id" disabled="true">
                                <option></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-lg-12">
                        <button type="button" class="btn btn-lg btn-primary font-helvetica-regular" onclick="BrandFormSubmit()">დადასტურება</button>
                    </div>
                    <input type="hidden" name="brand_id" id="brand_id">
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="{{ url('assets/js/jquery-ui.min.js') }}"></script>
<script src="{{ url('assets/scripts/products_scripts.js') }}"></script>
@endsection