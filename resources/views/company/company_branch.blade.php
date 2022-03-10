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
                                    <a class="nav-link font-neue" data-toggle="tab" href="branch_item_{{$branch_item['id']}}">{{$branch_item['name']}}</a>
                                </li>
                                @endforeach
                            </ul>
                            <div class="tab-content">
                                
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
                <form action="#" class="form-validate is-alter" id="role_form">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 mb-3">
                            <div class="form-group">
                                <label class="form-label" for="role_title">დასახელება</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control role-input" name="role_title" id="role_title">
                                    <span class="text-danger font-helvetica-regular font-italic error-text error-role_title"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-sm-12 mb-3">
                            <div class="form-group">
                                <label class="form-label" for="role_name">ფილიალი</label>
                                <div class="form-control-wrap">
                                    <select class="form-control">
                                        <option value="0"></option>
                                        @foreach($branch_list as $branch_item)
                                        <option value="{{ $branch_item['id'] }}">{{ $branch_item['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="role_id" id="role_id">
                        <div class="col-lg-12 mb-3">
                            <div class="form-group">
                                <button type="button" onclick="UserRoleSubmit()" class="btn btn-lg btn-primary font-helvetica-regular">შენახვა</button>
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