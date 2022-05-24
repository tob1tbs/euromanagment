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
                                                        <li><a href="{{ route('actionProductsAdd') }}"><span>პროდუქტის დამატება</span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle btn btn-light font-helvetica-regular ml-2" data-toggle="dropdown">ნაშთები</a>
                                                <div class="dropdown-menu" style="min-width: 300px;">
                                                    <ul class="link-check font-helvetica-regular">
                                                        <li><span>Excel</span></li>
                                                        <li><a href="javascript:;" onclick="ProductBalanceExport()">
                                                            <em class="icon ni ni-download"></em><span>არსებული ნაშთების ჩამოტვირთვა</span></a>
                                                        </li>
                                                        <li><a href="javascript:;" onclick="ProductBalanceUpload()">
                                                            <em class="icon ni ni-upload"></em><span>ახალი ნაშთების ატვირთვა</span></a>
                                                        </li>
                                                    </ul>
                                                    <ul class="link-check font-helvetica-regular">
                                                        <li><a href="{{ route('actionProductsBalanceHistory') }}">
                                                            <em class="icon ni ni-file-plus"></em><span>ნაშთების ცვლილების ისტორია</span></a>
                                                        </li>
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
                                            <h3 class="nk-block-title page-title font-neue">პროდუქციის ჩამონათვალი</h3>
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
                                                                            <span class="sub-title dropdown-title font-neue">პროდუქციის ფილტრი</span>
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
                                                                                        <label class="font-helvetica-regular overline-title overline-title-alt">დასახელება<br></label>
                                                                                        <input type="text" class="form-control" name="search_query">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <div class="form-group">
                                                                                        <label class="font-helvetica-regular overline-title overline-title-alt">კატეგორია</label>
                                                                                        <select class="form-control form-select-sm" name="product_category">
                                                                                            <option value="0"></option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <div class="form-group">
                                                                                        <label class="font-helvetica-regular overline-title overline-title-alt">ფილიალი</label>
                                                                                        <select class="form-control form-select-sm" name="branch_id">
                                                                                            <option value="0"></option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <div class="form-group">
                                                                                        <label class="font-helvetica-regular overline-title overline-title-alt">განყოფილება</label>
                                                                                        <select class="form-control form-select-sm" name="departament_id">
                                                                                            <option value="0"></option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <div class="form-group">
                                                                                        <label class="font-helvetica-regular overline-title overline-title-alt">რაოდენობა<br></label>
                                                                                        <input type="number" class="form-control" name="product_count" value="{{ request()->product_count }}">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <div class="form-group">
                                                                                        <label class="font-helvetica-regular overline-title overline-title-alt">სტატუსი</label>
                                                                                        <select class="form-control form-select-sm" name="product_status">
                                                                                           
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <div class="form-group">
                                                                                        <label class="font-helvetica-regular overline-title overline-title-alt">მარაგშია</label>
                                                                                        <select class="form-control form-select-sm" name="in_stock">
                                                                                            
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <div class="form-group">
                                                                                        <label class="font-helvetica-regular overline-title overline-title-alt">სორტირება</label>
                                                                                        <select class="form-control form-select-sm" name="product_sort">
                                                                                            
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
                            <div class="card-inner">
                                <div class="nk-block">
                                    <div class="card card-bordered card-stretch">
                                        <div class="card-inner p-0">
                                            <div class="nk-tb-list nk-tb-ulist">
                                                <div class="nk-tb-item nk-tb-head font-helvetica-regular">
                                                    <div class="nk-tb-col"><span># პროდუქტის დასახელება</span></div>
                                                    <div class="nk-tb-col"><span>ერთეული</span></div>
                                                    <div class="nk-tb-col tb-col-mb"><span>კატეგორია</span></div>
                                                    <div class="nk-tb-col tb-col-md"><span>ბრენდი</span></div>
                                                    <div class="nk-tb-col tb-col-md"><span>ასაღები ფასი</span></div>
                                                    <div class="nk-tb-col tb-col-md"><span>საცალო ფასი / საბითუმო ფასი</span></div>
                                                    <div class="nk-tb-col tb-col-lg"><span>დამატების თარიღი</span></div>
                                                    <div class="nk-tb-col tb-col-lg"><span>ნაშთი</span></div>
                                                    <div class="nk-tb-col tb-col-md"><span>სტატუსი</span></div>
                                                    <div class="nk-tb-col nk-tb-col-tools">&nbsp;</div>
                                                </div>
                                                @foreach($product_list as $product_item)
                                                <div class="nk-tb-item font-helvetica-regular">
                                                    <div class="nk-tb-col">
                                                        <div class="user-card">
                                                            <div class="user-info">
                                                                <span class="tb-lead"> # {{ $product_item->id }} {{ $product_item->name_ge }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="nk-tb-col tb-col-mb">
                                                        <span class="tb-lead-sub">
                                                            {{ $product_item->productUnit->name }}
                                                        </span>
                                                    </div>
                                                    <div class="nk-tb-col tb-col-mb">
                                                        <span class="tb-lead-sub">
                                                            {{ $product_item->productCategory->name }} @if($product_item->productCategory->active == 0) <em class="icon ni ni-alert-circle color-warning" title="აღნიშნული კატეგორიის გათიშულია."  data-toggle="tooltip" data-placement="top"></em> @endif
                                                        </span>
                                                    </div>
                                                    <div class="nk-tb-col tb-col-md">
                                                        <span class="tb-date">
                                                            @if(!empty($product_item->brand_id))
                                                                {{ $product_item->productBrand->name }}
                                                            @endif
                                                        </span>
                                                    </div>
                                                    <div class="nk-tb-col tb-col-lg">
                                                        <span class="tb-date">
                                                            @if(!empty($product_item->productPrice))
                                                            {{ $product_item->productPrice[0]->vendor_price / 100 }} ₾
                                                            @endif
                                                        </span>
                                                    </div>
                                                    <div class="nk-tb-col tb-col-lg">
                                                        <span class="tb-date">
                                                            @if(!empty($product_item->productPrice))
                                                            {{ $product_item->productPrice[0]->retail_price / 100 }} ₾
                                                            /
                                                            {{ $product_item->productPrice[0]->wholesale_price / 100 }} ₾
                                                            @endif
                                                        </span>
                                                    </div>
                                                    <div class="nk-tb-col tb-col-md">
                                                        {{ \Carbon\Carbon::parse($product_item->created_at)->format('Y-m-d') }}
                                                    </div>
                                                    <div class="nk-tb-col tb-col-md">
                                                            <span class="badge badge-success" style="cursor: pointer;" onclick="UpdateProductCount({{ $product_item->id}}, this)">{{ $product_item->count }}</span>
                                                    </div>
                                                    <div class="nk-tb-col tb-col-lg">
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input" id="product_active_{{ $product_item->id }}" onclick="ProductActiveChange({{ $product_item->id }}, this)" @if($product_item->active == 1) checked @endif>
                                                            <label class="custom-control-label" for="product_active_{{ $product_item->id }}"></label>
                                                        </div>
                                                    </div>
                                                    <div class="nk-tb-col nk-tb-col-tools">
                                                        <ul class="nk-tb-actions gx-1">
                                                            <li>
                                                                <div class="drodown">
                                                                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                    <div class="dropdown-menu dropdown-menu-right" style="min-width: 250px; width: 100%;">
                                                                        <ul class="link-list-opt no-bdr">
                                                                            <li>
                                                                                <a href="javascript:;" onclick="ProductPriceHistory({{ $product_item->id }})">
                                                                                    <em class="icon ni ni-dot"></em>
                                                                                    <span>ფასების ისტორია</span>
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <a href="javascript:;" onclick="UpdateProductPrice({{ $product_item->id }})">
                                                                                    <em class="icon ni ni-dot"></em>
                                                                                    <span>ნაშთების ისტორია</span>
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <a href="javascript:;" onclick="UpdateProductPrice({{ $product_item->id }})">
                                                                                    <em class="icon ni ni-dot"></em>
                                                                                    <span>ფასის რედაქტირება</span>
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <a href="{{ route('actionProductsEdit', $product_item->id) }}">
                                                                                    <em class="icon ni ni-dot"></em>
                                                                                    <span>რედაქტირება</span>
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <a href="javascript:;" onclick="ProductDelete({{ $product_item->id }})" class="text-danger">
                                                                                    <em class="icon ni ni-trash"></em>
                                                                                    <span>პროდუქტის წაშლა</span>
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
<div class="modal fade" id="BalanceUploadModal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-neue">პროდუქციის ნაშთების ატვირთვა</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" class="form-validate is-alter" novalidate="novalidate" id="balance_upload_form">
                    <div class="form-group">
                        <label class="form-label font-helvetica-regular" for="excel_file">ექსელის ფაილი *</label>
                        <div class="form-control-wrap">
                            <input type="file" class="form-control check-input" name="excel_file" id="excel_file">
                            <small class="excel_file-error text-error text-danger mt-1"></small>
                        </div>
                    </div>
                    <button type="button" class="btn btn-success" onclick="ProductBalanceSubmit()">ატვირთვა</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="CountUploadModal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-neue">პროდუქციის ნაშთების შეცვლა</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" class="form-validate is-alter" novalidate="novalidate" id="product_count_form">
                    <div class="form-group">
                        <label class="form-label font-helvetica-regular" for="product_count">რაოდენობა</label>
                        <div class="form-control-wrap">
                            <input type="number" class="form-control check-input" name="product_count" id="product_count">
                            <input type="hidden" class="form-control check-input" name="product_count_id" id="product_count_id">
                            <small class="product_count-error text-error text-danger mt-1"></small>
                        </div>
                    </div>
                    <button type="button" class="btn btn-success font-helvetica-regular" onclick="ProductCountSubmit()">განახლება</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="PriceHistoryModal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-top" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-neue">ფასის ცვლილების ისტორია</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body price-history-body" style="max-height: 400px;">
                <form class="row" id="get_product_price_history">
                    <div class="col-4">
                        
                    </div>
                    <div class="col-4">
                        
                    </div>
                    <div class="col-12">
                        <ul class="nav nav-tabs mt-n3">
                            <li class="nav-item font-neue">
                                <a class="nav-link active" data-toggle="tab" href="#tabItem1">ცვლილების დიაგრამა</a>
                            </li>
                            <li class="nav-item font-neue">
                                <a class="nav-link" data-toggle="tab" href="#tabItem2">ცვლილების ცხრილი</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabItem1" style="height: 300px;">
                                <canvas class="line-chart" id="solidLineChart"></canvas>
                            </div>
                            <div class="tab-pane" id="tabItem2">
                                <table class="table">
                                    <thead class="thead-dark">
                                        <tr class="font-neue">
                                            <th scope="col">შეცვლის თარიღი</th>
                                            <th scope="col">ასაღები ფასი</th>
                                            <th scope="col">საცალო ფასი</th>
                                            <th scope="col">საბითუმო</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="price-history-table-body">
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ProductPriceUpdateModal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-top" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-neue">ფასის რედაქტირება</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body price-history-body" style="max-height: 400px;">
                 <form action="#" class="form-validate is-alter row" novalidate="novalidate" id="update_product_price_form">
                    <div class="form-group col-md-4 col-sm-12">
                        <label class="form-label font-helvetica-regular" for="update_vendor_price">ასაღები ფასი</label>
                        <div class="form-control-wrap">
                            <input type="number" class="form-control check-input" name="update_vendor_price" id="update_vendor_price">
                        </div>
                    </div>
                    <div class="form-group col-md-4 col-sm-12">
                        <label class="form-label font-helvetica-regular" for="update_retail_price">საცალო ფასი</label>
                        <div class="form-control-wrap">
                            <input type="number" class="form-control check-input" name="update_retail_price" id="update_retail_price">
                        </div>
                    </div>
                    <div class="form-group col-md-4 col-sm-12">
                        <label class="form-label font-helvetica-regular" for="update_wholesale_price">საბითუმო ფასი</label>
                        <div class="form-control-wrap">
                            <input type="number" class="form-control check-input" name="update_wholesale_price" id="update_wholesale_price">
                        </div>
                    </div>
                    <div class="form-group col-12">
                        <button type="button" class="btn btn-success font-helvetica-regular" onclick="ProductPriceSubmit()">განახლება</button>
                    </div>
                    <input type="hidden" name="update_price_product_id" id="update_price_product_id">
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ url('assets/scripts/products_scripts.js') }}"></script>
@endsection