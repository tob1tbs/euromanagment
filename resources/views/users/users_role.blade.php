@extends('layout.layout')

@section('css')

@endsection

@section('content')
<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h4 class="nk-block-title font-neue">წვდომის ჯგუფების ჩამონათვალი</h4>
                        </div>    
                        <div class="nk-block-head-content">
                            <ul class="nk-block-tools g-3">
                                <li>
                                    <a href="javascript:;" class="btn btn-white btn-outline-light" onclick="UserRoleAdd()">
                                        <em class="icon ni ni-plus"></em>
                                        <span class="font-helvetica-regular">ახალი წვდომის ჯგუფი</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card card-preview">
                    <div class="card-inner">
                        <table class="datatable-init nk-tb-list nk-tb-ulist font-helvetica-regular" data-auto-responsive="false">
                            <thead>
                                <tr class="nk-tb-item nk-tb-head font-helvetica-regular">
                                    <th class="nk-tb-col"><span class="sub-text">ჯგუფის დასახელება</span></th>
                                    <th class="nk-tb-col tb-col-md"><span class="sub-text">ჯგუფის (KEY)</span></th>
                                    <th class="nk-tb-col tb-col-md"><span class="sub-text">სტატუსი</span></th>
                                    <th class="nk-tb-col nk-tb-col-tools text-right"></th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach($user_role_list as $user_role_item)
                                <tr class="nk-tb-item">
                                    <td class="nk-tb-col">
                                        <div class="user-card">
                                            <div class="user-info">
                                                <span class="tb-lead">{{ $user_role_item->title }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="nk-tb-col tb-col-mb">
                                        <span class="tb-amount">{{ $user_role_item->name }}</span>
                                    </td>
                                    <td class="nk-tb-col tb-col-md">
                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                @if($user_role_item->id != 1 AND $user_role_item->id != 2)
                                                <input type="checkbox" class="custom-control-input" name="reg-public" id="role_{{ $user_role_item->id }}" value="1" @if($user_role_item->active == 1) checked @endif onclick="UserRoleActiveChange({{ $user_role_item->id}}, this)">
                                                <label class="custom-control-label" for="role_{{ $user_role_item->id }}"></label>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="nk-tb-col nk-tb-col-tools">
                                        <ul class="nk-tb-actions gx-1">
                                            @if($user_role_item->id != 1 AND $user_role_item->id != 2)
                                            <li>
                                                <div class="drodown">
                                                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <ul class="link-list-opt no-bdr" style="width: 300px;">
                                                            <li><a href="javascript:;" onclick="UserRolePermissions({{ $user_role_item->id }})"><em class="icon ni ni-unlock"></em><span>უფლებები</span></a></li>
                                                            <li><a href="javascript:;" onclick="UserRoleEdit({{ $user_role_item->id }})"><em class="icon ni ni-edit"></em><span>რედაქტირება</span></a></li>
                                                            <li><a href="javascript:;" class="text-danger" onclick="UserRoleDelete({{ $user_role_item->id }})"><em class="icon ni ni-trash"></em><span>წაშლა</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                            @endif
                                        </ul>
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
<div class="modal fade" id="role_modal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-top" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-neue role-modal-title"></h5>
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
                                <label class="form-label" for="role_name">KEY</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control role-input" name="role_name" id="role_name">
                                    <span class="text-danger font-helvetica-regular font-italic error-text error-role_name"></span>
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
<div class="modal fade" id="permission_modal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document" style="max-width: 80%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-neue">უფლებების ჩამონათვალი</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" class="form-validate is-alter" id="permission_form">
                    <div class="row permission-list">
                        
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <button class="btn btn-success font-neue permission-submit-button" type="button" onclick="SyncPermissionSubmit()">შენახვა</button>
                        </div>
                    </div>
                    <input type="hidden" name="permission_role" id="permission_role">
                </form>
                <form action="#" class="form-validate is-alter" id="permission_add_form" style="margin-top: 10px;">
                    <div class="row">
                        <div class="col-12">
                            <h5 class="font-neue" style="font-size: 16px; margin: 10px 0;">უფლების დამატება დამატება</h5>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label font-helvetica-regular" for="permission_group">უფლების ჯგუფი</label>
                                <div class="form-control-wrap">
                                    <select class="form-control" name="permission_group">
                                        @foreach($user_permission_group_list as $group_item)
                                        <option value="{{ $group_item->id }}">{{ $group_item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label font-helvetica-regular" for="permission_title">უფლების დასახელება</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control permission-input" name="permission_title" id="permission_title">
                                    <small class="error-permission_title error-text text-danger mt-1 font-helvetica-regular"></small>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-label font-helvetica-regular" for="permission_name">უფლების KEY </label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control permission-input" name="permission_name" id="permission_name">
                                    <small class="error-permission_name error-text text-danger mt-1 font-helvetica-regular"></small>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-1">
                            <div class="form-group">
                                <label class="form-label font-helvetica-regular">&nbsp;</label>
                                <div class="form-control-wrap">
                                    <button class="btn btn-success font-helvetica-regular" onclick="AddPermissionSubmit()" type="button" style="height: 36px;">შენახვა</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="permission_role_id" id="permission_role_id">
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ url('assets/scripts/users_scripts.js') }}"></script>
@endsection