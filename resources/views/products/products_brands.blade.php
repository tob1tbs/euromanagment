@extends('layout.layout')

@section('css')

@endsection

@section('content')
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-inner">
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
            <div class="nk-content-body">
                <div class="nk-block nk-block-lg">
                    <div class="card card-bordered">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card-inner">
                                    <table class="datatable-init nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                                        <thead>
                                            <tr class="nk-tb-item nk-tb-head font-neue">
                                                <th class="nk-tb-col"><span class="sub-text">ბრენდის დასახელება</span></th>
                                                <th class="nk-tb-col"><span class="sub-text">სტატუსი</span></th>
                                                <th class="nk-tb-col nk-tb-col-tools text-right"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                       		@foreach($brand_list as $brand_item)
                                            <tr class="nk-tb-item font-helvetica-regular">
                                                <td class="nk-tb-col">
                                                    <div class="user-card">
                                                        <div class="user-info">
                                                            <span class="tb-lead">{{ $brand_item->name }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col tb-col-md">
                                                    @if($brand_item->id != 1)
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input" id="brand_active_{{ $brand_item->id }}" onclick="BrandActiveChange({{ $brand_item->id }}, this)" @if($brand_item->active == 1) checked @endif>
                                                        <label class="custom-control-label" for="brand_active_{{ $brand_item->id }}"></label>
                                                    </div>
                                                    @endif
                                                </td>
                                                <td class="nk-tb-col nk-tb-col-tools">
                                                    @if($brand_item->id != 1)
                                                    <ul class="nk-tb-actions gx-1">
                                                        <li>
                                                            <div class="drodown">
                                                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <ul class="link-list-opt no-bdr">
                                                                        <li><a href="javascript:;" onclick="BrandEdit({{ $brand_item->id }})"><em class="icon ni ni-focus"></em><span>რედაქტირება</span></a></li>
                                                                        <li><a href="javascript:;" onclick="BrandDelete({{ $brand_item->id }})"><em class="icon ni ni-focus"></em><span>წაშლა</span></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>            
            </div>
        </div>
    </div>
</div>  
<div class="modal fade" id="brand_modal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-neue">ბრენდის დამატება</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" class="form-validate is-alter" novalidate="novalidate" id="brand_form">
                    <div class="form-group">
                        <label class="form-label font-helvetica-regular" for="brand_name">დასახელება</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" name="brand_name" id="brand_name">
                            <input type="hidden" class="form-control" name="brand_id" id="brand_id">
                        </div>
                    </div>
                    <button type="button" class="btn btn-success font-helvetica-regular" onclick="BrandSubmit()">განახლება</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ url('assets/scripts/products_scripts.js') }}"></script>
@endsection