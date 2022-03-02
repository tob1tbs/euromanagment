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
                                                        <li><a href="javascript:;" onclick="OptionsModal()"><span>პარამეტრის დამატება</span></a></li>
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
                                            <h3 class="nk-block-title page-title font-neue">პარამეტრების  ჩამონათვალი</h3>
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
                                                                            <span class="sub-title dropdown-title font-neue">პარამეტრების ფილტრი</span>
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
                                                                                        <label class="font-helvetica-regular overline-title overline-title-alt">პარამეტრის სახელი <br></label>
                                                                                        <input type="text" class="form-control" name="search_query">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <div class="form-group">
                                                                                        <label class="font-helvetica-regular overline-title overline-title-alt">სტატუსი</label>
                                                                                        <select class="form-select form-select-sm" name="option_active">
                                                                                            
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
                                <div class="nk-tb-list nk-tb-ulist" id="option_sortable">
                                    <div class="nk-tb-item nk-tb-head font-helvetica-regular">
                                        <div class="nk-tb-col"><span class="sub-text">ID</span></div>
                                        <div class="nk-tb-col"><span class="sub-text">ტიპი</span></div>
                                        <div class="nk-tb-col"><span class="sub-text">სორტირება</span></div>
                                        <div class="nk-tb-col"><span class="sub-text">პარამეტრის დასახელება</span></div>
                                        <div class="nk-tb-col"><span class="sub-text">კატეგორია / ქვეკატეგორია</span></div>
                                        <div class="nk-tb-col tb-col-md"><span class="sub-text">სტატუსი</span></div>
                                        <div class="nk-tb-col nk-tb-col-tools text-right"></div>
                                    </div>
                                    @foreach($product_option_list as $option_item)
                                    <div class="nk-tb-item font-helvetica-regular" id="option_item-{{ $option_item->id }}">
                                        <div class="nk-tb-col">
                                            <a href="javascript:;">
                                                <div class="user-card">
                                                    <div class="user-info">
                                                        <span class="tb-lead">{{ $option_item->id }}<span class="dot dot-success d-md-none ml-1"></span></span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="nk-tb-col">
                                            <a href="javascript:;">
                                                <div class="user-card">
                                                    <div class="user-info">
                                                        <span class="tb-lead">{{ $option_item->type }}<span class="dot dot-success d-md-none ml-1"></span></span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="nk-tb-col">
                                            <a href="javascript:;">
                                                <div class="user-card">
                                                    <div class="user-info">
                                                        <span class="tb-lead">{{ $option_item->sortable }}<span class="dot dot-success d-md-none ml-1"></span></span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="nk-tb-col">
                                            <a href="javascript:;">
                                                <div class="user-card">
                                                    <div class="user-info">
                                                        <span class="tb-lead">{{ json_decode($option_item->name)->ge }} / {{ json_decode($option_item->name)->en }}<span class="dot dot-success d-md-none ml-1"></span></span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="nk-tb-col">
                                            <a href="javascript:;">
                                                <div class="user-card">
                                                    <div class="user-info">
                                                        <span class="tb-lead">{{ json_decode($option_item->getCategoryData->name)->ge }} @if(!empty($option_item->child_category_id)) / {{ json_decode($option_item->getChildCategoryData->name)->ge }} @endif<span class="dot dot-success d-md-none ml-1"></span></span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="nk-tb-col tb-col-md">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="category_active_{{ $option_item->id }}" onclick="OptionActiveChange({{ $option_item->id }}, this)" @if($option_item->active == 1) checked @endif>
                                                <label class="custom-control-label" for="category_active_{{ $option_item->id }}"></label>
                                            </div>
                                        </div>
                                        <div class="nk-tb-col nk-tb-col-tools">
                                            <ul class="nk-tb-actions gx-1">
                                                <li>
                                                    <div class="drodown">
                                                        <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                        <div class="dropdown-menu dropdown-menu-right" style="width: 240px;">
                                                            <ul class="link-list-opt no-bdr">
                                                                @if($option_item->type != 'input')
                                                                <li>
                                                                    <a href="javascript:;" onclick="OptionValue({{ $option_item->id }})">
                                                                        <em class="icon ni ni-dot"></em>
                                                                        <span>პარამეტრის მნიშვნელობები</span>
                                                                    </a>
                                                                </li>
                                                                @endif
                                                                <li class="divider"></li>
                                                                <li>
                                                                    <a href="javascript:;" onclick="OptionEdit({{ $option_item->id }})">
                                                                        <em class="icon ni ni-dot"></em>
                                                                        <span>რედაქტირება</span>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="javascript:;" onclick="OptionDelete({{ $option_item->id }})" class="text-danger">
                                                                        <em class="icon ni ni-trash"></em>
                                                                        <span>პარამეტრის წაშლა</span>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
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
<div class="modal fade" id="OptionModal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-neue option-modal-head"></h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form id="option_form" class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label font-helvetica-regular" for="option_name_ge">პარამეტრის დასახელება (ქართულად)</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control check-input" name="option_name_ge" id="option_name_ge">
                                <small class="option_name_ge-error text-error text-danger mt-1"></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label font-helvetica-regular" for="option_name_en">პარამეტრის დასახელება (ინგლისურად)</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control check-input" name="option_name_en" id="option_name_en">
                                <small class="option_name_en-error text-error text-danger mt-1"></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label font-helvetica-regular" for="option_category">პარამეტრის კატეგორია </label>
                            <div class="form-control-wrap">
                                <select class="form-control check-input" name="option_category" id="option_category" onchange="GetSubCategoryList('option_category', 'option_child_category')">
                                    <option value=""></option>
                                    @foreach($product_category_list as $category_item)
                                    <option value="{{ $category_item->id }}">{{ json_decode($category_item->name)->ge }}</option>
                                    @endforeach
                                </select>
                                <small class="option_category-error text-error text-danger mt-1"></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label font-helvetica-regular" for="option_child_category">პარამეტრის ქვეკატეგორია </label>
                            <div class="form-control-wrap">
                                <select class="form-control check-input" name="option_child_category" id="option_child_category" disabled>
                                    
                                </select>
                                <small class="option_child_category-error text-error text-danger mt-1"></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label font-helvetica-regular" for="option_type">პარამეტრის ტიპი </label>
                            <div class="form-control-wrap">
                                <select class="form-control check-input" name="option_type" id="option_type">
                                    <option value=""></option>
                                    @foreach($product_option_type_list as $key => $type_item)
                                    <option value="{{ $key }}">{{ $type_item }}</option>
                                    @endforeach
                                </select>
                                <small class="option_type-error text-error text-danger mt-1"></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label font-helvetica-regular" for="option_key">პარამეტრის KEY</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control check-input" name="option_key" id="option_key">
                                <small class="option_key-error text-error text-danger mt-1"></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <div class="form-group">
                            <label class="form-label font-helvetica-regular">&nbsp;</label>
                            <div class="form-control-wrap">
                                <button class="btn btn-success font-helvetica-regular" onclick="OptionSubmit()" type="button" style="height: 36px;">შენახვა</button>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="option_id" id="option_id">
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="OptionValueModal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document" style="max-width: 80%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-neue">პარამეტრების მნიშვნელობების ჩამონათვალი</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <tr class="font-helvetica-regular">
                          <th>ID</th>
                          <th>SORT</th>
                          <th>მნიშვნელობის დასახელება (ქართულად)</th>
                          <th>მნიშვნელობის დასახელება (ინგლისურად)</th>
                          <th>სტატუსი</th>
                          <th>მოქმედება</th>
                        </tr>
                    </thead>
                    <tbody id="option_value">
                        
                    </tbody>
                </table>
                <form id="option_value_form" class="row">
                    <div class="col-12">
                        <h5 class="font-neue" style="font-size: 16px; margin: 10px 0;">მნიშვნელობის დამატება</h5>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label font-helvetica-regular" for="option_value_name_ge">მნიშვნელობის დასახელება (ქართულად)</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control check-input" name="option_value_name_ge" id="option_value_name_ge">
                                <small class="option_value_name_ge-error text-error text-danger mt-1"></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label font-helvetica-regular" for="option_value_name_en">მნიშვნელობის დასახელება (ინგლისურად)</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control check-input" name="option_value_name_en" id="option_value_name_en">
                                <small class="option_value_name_en-error text-error text-danger mt-1"></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <div class="form-group">
                            <label class="form-label font-helvetica-regular">&nbsp;</label>
                            <div class="form-control-wrap">
                                <button class="btn btn-success font-helvetica-regular" onclick="OptionValueSubmit()" type="button" style="height: 36px;">შენახვა</button>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="value_option_id" id="value_option_id">
                    <input type="hidden" name="option_value_id" id="option_value_id">
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