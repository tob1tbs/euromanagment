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
                                                        <li><a href="javascript:;" onclick="CategoryModal()"><span>კატეგორიის დამატება</span></a></li>
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
                                            <h3 class="nk-block-title page-title font-neue">კატეგორიების ჩამონათვალი</h3>
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
                                                                            <span class="sub-title dropdown-title font-neue">კატეგორიების ფილტრი</span>
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
                                                                                        <label class="font-helvetica-regular overline-title overline-title-alt">კატეგორიის სახელი <br></label>
                                                                                        <input type="text" class="form-control" name="search_query">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <div class="form-group">
                                                                                        <label class="font-helvetica-regular overline-title overline-title-alt">სტატუსი</label>
                                                                                        <select class="form-select form-select-sm" name="category_active">
                                                                                            
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
                                <div class="nk-tb-list nk-tb-ulist" id="parent_sortable">
                                    <div class="nk-tb-item nk-tb-head font-helvetica-regular">
                                        <div class="nk-tb-col"><span class="sub-text">ID</span></div>
                                        <div class="nk-tb-col"><span class="sub-text">სორტირება</span></div>
                                        <div class="nk-tb-col"><span class="sub-text">კატეგორიის დასახელება (ქართულად / ინგლისურად)</span></div>
                                        <div class="nk-tb-col tb-col-md"><span class="sub-text">სტატუსი</span></div>
                                        <div class="nk-tb-col nk-tb-col-tools text-right"></div>
                                    </div>
                                    @foreach($product_category_list as $category_item)
                                    <div class="nk-tb-item font-helvetica-regular" @if($category_item->id != 1) id="category_item-{{ $category_item->id }}" @endif>
                                        <div class="nk-tb-col">
                                            <a href="javascript:;">
                                                <div class="user-card">
                                                    <div class="user-info">
                                                        <span class="tb-lead">{{ $category_item->id }}<span class="dot dot-success d-md-none ml-1"></span></span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="nk-tb-col">
                                            <a href="javascript:;">
                                                <div class="user-card">
                                                    <div class="user-info">
                                                        <span class="tb-lead">{{ $category_item->sortable }}<span class="dot dot-success d-md-none ml-1"></span></span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="nk-tb-col">
                                            <a href="javascript:;">
                                                <div class="user-card">
                                                    <div class="user-info">
                                                        <span class="tb-lead">{{ json_decode($category_item->name)->ge }} / {{ json_decode($category_item->name)->en }}<span class="dot dot-success d-md-none ml-1"></span></span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="nk-tb-col tb-col-md">
                                            @if($category_item->id != 1)
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="category_active_{{ $category_item->id }}" onclick="CategoryActiveChange({{ $category_item->id }}, this)" @if($category_item->active == 1) checked @endif>
                                                <label class="custom-control-label" for="category_active_{{ $category_item->id }}"></label>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="nk-tb-col nk-tb-col-tools">
                                            @if($category_item->id != 1)
                                            <ul class="nk-tb-actions gx-1">
                                                <li>
                                                    <div class="drodown">
                                                        <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                        <div class="dropdown-menu dropdown-menu-right" style="width: 240px;">
                                                            <ul class="link-list-opt no-bdr">
                                                                <li>
                                                                    <a href="javascript:;" onclick="ChildCategoriesList({{ $category_item->id }})">
                                                                        <em class="icon ni ni-dot"></em>
                                                                        <span>ქვეკატეგორიები</span>
                                                                    </a>
                                                                </li>
                                                                <li class="divider"></li>
                                                                <li>
                                                                    <a href="javascript:;" onclick="CategoryEdit({{ $category_item->id }})">
                                                                        <em class="icon ni ni-dot"></em>
                                                                        <span>რედაქტირება</span>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="javascript:;" onclick="CategoryDelete({{ $category_item->id }})" class="text-danger">
                                                                        <em class="icon ni ni-trash"></em>
                                                                        <span>კატეგორიის წაშლა</span>
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
<div class="modal fade" id="CategoryModal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-neue category-modal-head"></h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" class="form-validate is-alter" novalidate="novalidate" id="category_form">
                    <div class="row">
                        <div class="col-lg-6 mb-2">
                            <div class="form-group">
                                <label class="form-label font-helvetica-regular" for="category_name_ge">კატეგორიის დასახელება (ქართულად) *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control check-input" name="category_name_ge" id="category_name_ge">
                                    <small class="category_name_ge-error text-error text-danger mt-1"></small>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-lg-6 mb-2">
                            <div class="form-group">
                                <label class="form-label font-helvetica-regular" for="category_name_en">კატეგორიის დასახელება (ინგლისურად)</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="category_name_en" id="category_name_en">
                                    <small class="category_name_en-error text-error text-danger mt-1"></small>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-lg-6 mb-2">
                            <div class="form-group">
                                <label class="form-label font-helvetica-regular" for="category_keywords_ge">კატეგორიის Meta Keywords (ქართულად) *</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="category_keywords_ge" id="category_keywords_ge">
                                    <small class="category_keywords_ge-error text-error text-danger mt-1"></small>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-lg-6 mb-2">
                            <div class="form-group">
                                <label class="form-label font-helvetica-regular" for="category_keywords_en">კატეგორიის Meta Keywords (ინგლისურად)</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" name="category_keywords_en" id="category_keywords_en">
                                    <small class="category_keywords_en-error text-error text-danger mt-1"></small>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-lg-6 mb-2">
                            <div class="form-group">
                                <button type="button" class="btn btn-lg btn-primary font-helvetica-regular" onclick="CategoryFormSubmit()">დადასტურება</button>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="category_id" id="category_id">
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ChildCategoryModal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-neue">ქვეკატეგორიები</h5>
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
                          <th>კატეგორიის დასახელება (ქართულად)</th>
                          <th>კატეგორიის დასახელება (ინგლისურად)</th>
                          <th>სტატუსი</th>
                          <th>მოქმედება</th>
                        </tr>
                    </thead>
                    <tbody class="child-category-list" id="child_sortable">
                        
                    </tbody>
                </table>
                <form id="child_category_add" class="row">
                    <div class="col-12">
                        <h5 class="font-neue" style="font-size: 16px; margin: 10px 0;">ქვეკატეგორიის დამატება</h5>
                    </div>
                    <div class="col-lg-6 mb-2">
                        <div class="form-group">
                            <label class="form-label font-helvetica-regular" for="child_category_name_ge">ქვეკატეგორიის დასახელება (ქართულად)</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control check-input" name="child_category_name_ge" id="child_category_name_ge">
                                <small class="child_category_name_ge-error text-error text-danger mt-1"></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-2">
                        <div class="form-group">
                            <label class="form-label font-helvetica-regular" for="child_category_name_en">ქვეკატეგორიის დასახელება (ინგლისურად)</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control check-input" name="child_category_name_en" id="child_category_name_en">
                                <small class="child_category_name_en-error text-error text-danger mt-1"></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-2">
                        <div class="form-group">
                            <label class="form-label font-helvetica-regular" for="child_category_keywords_ge">ქვეკატეგორიის Meta Keywords (ქართულად)</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control check-input" name="child_category_keywords_ge" id="child_category_keywords_ge">
                                <small class="child_category_keywords_ge-error text-error text-danger mt-1"></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-2">
                        <div class="form-group">
                            <label class="form-label font-helvetica-regular" for="child_category_keywords_en">ქვეკატეგორიის Meta Keywords (ინგლისურად)</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control check-input" name="child_category_keywords_en" id="child_category_keywords_en">
                                <small class="child_category_keywords_en-error text-error text-danger mt-1"></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-label font-helvetica-regular">&nbsp;</label>
                            <div class="form-control-wrap">
                                <button class="btn btn-success font-helvetica-regular" onclick="ChildCategoryAdd()" type="button" style="height: 36px;">შენახვა</button>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="child_category_parent_id" id="child_category_parent_id">
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