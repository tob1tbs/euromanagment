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
                        <h4 class="nk-block-title font-neue">ფილიალების და განყოფილებების ჩამონათვალი</h4>
                    </div>        
                    <div class="nk-block-head-content">
                        <ul class="nk-block-tools g-3">
                            <li>
                                <a href="javascript:;" onclick="BranchModal()" class="btn btn-white btn-outline-light">
                                    <em class="icon ni ni-plus"></em>
                                    <span class="font-helvetica-regular">ახალი ფილიალი / განყოფილება</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="nk-content-body">
                <div class="nk-block nk-block-lg">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <ul class="nav nav-tabs">
                                @foreach($branch_list as $branch_item)
                                <li class="nav-item">
                                    <a class="nav-link font-neue @if($loop->first) active @endif" data-toggle="tab" href="#branch_item_{{$branch_item['id']}}">{{$branch_item['name']}}</a>
                                </li>
                                @endforeach
                            </ul>
                            <div class="tab-content">
                                @foreach($branch_list as $branch_item)
                                <div class="tab-pane @if($loop->first) active @endif" id="branch_item_{{$branch_item['id']}}">
                                    <div class="nk-tb-list">
                                        <div class="nk-tb-item nk-tb-head font-neue">
                                            <div class="nk-tb-col p-0"><span><b>დასახელება</b></span></div>
                                            <div class="nk-tb-col text-right"><b>სტატუსი</b></div>
                                            <div class="nk-tb-col text-right p-0"><span><b>მოქმედება</b></span></div>
                                        </div>
                                        @foreach($branch_item['departaments'] as $departament_item)
                                        <div class="nk-tb-item font-helvetica-regular">
                                            <div class="nk-tb-col p-0">
                                                <div class="align-center">
                                                    <span class="tb-sub">{{ $departament_item->name }}</span>
                                                </div>
                                            </div>
                                            <div class="nk-tb-col tb-col-sm">
                                                <span class="tb-sub text-success">
                                                    <div class="custom-control custom-switch float-right">
                                                        <input type="checkbox" class="custom-control-input" id="user_active_2" onclick="ProductActiveChange(2, this)" checked="">
                                                        <label class="custom-control-label" for="user_active_2"></label>
                                                    </div>
                                                </span>
                                            </div>
                                            <div class="nk-tb-col nk-tb-col-action p-0">
                                                <div class="dropdown">
                                                    <a class="text-soft dropdown-toggle btn btn-sm btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-chevron-right"></em></a>
                                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-xs">
                                                        <ul class="link-list-plain">
                                                            <li><a href="#">რედაქტირება</a></li>
                                                            <li><a href="#" onclick="DeleteWorkBranch({{ $departament_item->id }})">წაშლა</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
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
<div class="modal fade" id="branch_modal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-top" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-neue branch-modal-title"></h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" class="form-validate is-alter" id="branch_form">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 mb-3">
                            <div class="form-group">
                                <label class="form-label" for="branch_name">დასახელება</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control branch-input" name="branch_name" id="branch_name">
                                    <span class="text-danger font-helvetica-regular font-italic error-text error-branch_name"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-sm-12 mb-3">
                            <div class="form-group">
                                <label class="form-label" for="branch_parent">ფილიალი</label>
                                <div class="form-control-wrap">
                                    <select class="form-control" id="branch_parent" name="branch_parent">
                                        <option value="0"></option>
                                        @foreach($branch_list as $branch_item)
                                        <option value="{{ $branch_item['id'] }}">{{ $branch_item['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="branch_id" id="branch_id">
                        <div class="col-lg-12 mb-3">
                            <div class="form-group">
                                <button type="button" onclick="BranchSubmit()" class="btn btn-lg btn-primary font-helvetica-regular">შენახვა</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ url('assets/scripts/company_scripts.js') }}"></script>
@endsection