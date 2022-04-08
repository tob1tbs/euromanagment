@extends('layout.layout')

@section('css')

@endsection

@section('content')
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-inner">
            <div class="nk-block-head">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h4 class="nk-block-title font-neue">საწყობების ნაშთები</h4>
                    </div>  
                </div>
            </div>
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <div class="toggle-wrap nk-block-tools-toggle">
                            <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                            <div class="toggle-expand-content" data-content="pageMenu">
                                <ul class="nk-block-tools g-3">
                                    <li class="nk-block-tools-opt">
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle btn btn-light font-helvetica-regular" data-toggle="dropdown">ნაშთები</a>
                                            <div class="dropdown-menu" style="min-width: 300px;">
                                                <ul class="link-check font-helvetica-regular">
                                                    <li><span>Excel</span></li>
                                                    <li><a href="javascript:;" onclick="ProductBalanceExport()">
                                                        <em class="icon ni ni-download"></em><span>არსებული ნაშთების ჩამოტვირთვა</span></a>
                                                    </li>
                                                </ul>
                                                <ul class="link-check font-helvetica-regular">
                                                    <li><a href="{{ route('actionProductBalanceHistory') }}">
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
            <div class="nk-content-body">
                <div class="nk-block nk-block-lg">
                    <div class="card card-bordered">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card-inner">
                                    <ul class="nav nav-tabs">
                                        @foreach($warehouse_list as $branch_item)
                                        <li class="nav-item">
                                            <a class="nav-link font-neue @if($loop->first) active @endif" data-toggle="tab" href="#branch_item_{{$branch_item->id}}">{{$branch_item->parentBranch->name}} - {{$branch_item->name}}</a>
                                        </li>
                                        @endforeach
                                    </ul>
                                    <div class="tab-content">
                                        @foreach($warehouse_list as $branch_item)
                                        <div class="tab-pane @if($loop->first) active @endif" id="branch_item_{{$branch_item->id}}">
                                            <div class="nk-tb-list">
                                                <div class="nk-tb-item nk-tb-head font-neue">
                                                    <div class="nk-tb-col p-0"><span><b>დასახელება</b></span></div>
                                                    <div class="nk-tb-col text-right"><b>სტატუსი</b></div>
                                                    <div class="nk-tb-col text-right p-0"><span><b>მოქმედება</b></span></div>
                                                </div>
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
@endsection

@section('js')
<script src="{{ url('assets/products/products_scripts.js') }}"></script>
@endsection