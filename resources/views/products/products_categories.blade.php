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
            <div class="nk-content-body">
                <div class="nk-block nk-block-lg">
                    <div class="card card-bordered">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card-inner">
                                    <table class="datatable-init nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                                        <thead>
                                            <tr class="nk-tb-item nk-tb-head font-neue">
                                                <th class="nk-tb-col"><span class="sub-text">კატეგორიის დასახელება</span></th>
                                                <th class="nk-tb-col"><span class="sub-text">სტატუსი</span></th>
                                                <th class="nk-tb-col nk-tb-col-tools text-right"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                       		@foreach($categories_list as $category_item)
                                            <tr class="nk-tb-item font-helvetica-regular">
                                                <td class="nk-tb-col">
                                                    <div class="user-card">
                                                        <div class="user-info">
                                                            <span class="tb-lead">{{ $category_item->name }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col tb-col-md">
                                                	@if($category_item->id != 1)
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input" id="category_active_{{ $category_item->id }}" onclick="CategoryActiveChange({{ $category_item->id }}, this)" @if($category_item->active == 1) checked @endif>
                                                        <label class="custom-control-label" for="category_active_{{ $category_item->id }}"></label>
                                                    </div>
                                                    @endif
                                                </td>
                                                <td class="nk-tb-col nk-tb-col-tools">
                                                	@if($category_item->id != 1)
                                                    <ul class="nk-tb-actions gx-1">
                                                        <li>
                                                            <div class="drodown">
                                                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <ul class="link-list-opt no-bdr">
                                                                    	<li><a href="javascript:;" onclick="CategoryEdit({{ $category_item->id }})"><em class="icon ni ni-focus"></em><span>რედაქტირება</span></a></li>
                                                                        <li><a href="javascript:;" onclick="CategoryDelete({{ $category_item->id }})"><em class="icon ni ni-focus"></em><span>წაშლა</span></a></li>
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
<div class="modal fade" id="category_modal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-neue">კატეგორიის დამატება</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" class="form-validate is-alter" novalidate="novalidate" id="category_form">
                    <div class="form-group">
                        <label class="form-label font-helvetica-regular" for="category_name">დასახელება</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" name="category_name" id="category_name">
                            <input type="hidden" class="form-control" name="category_id" id="category_id">
                        </div>
                    </div>
                    <button type="button" class="btn btn-success font-helvetica-regular" onclick="CategorySubmit()">განახლება</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ url('assets/scripts/products_scripts.js') }}"></script>
@endsection