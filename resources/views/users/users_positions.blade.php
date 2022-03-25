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
                        <h4 class="nk-block-title font-neue">სამუშაო პოზიციები</h4>
                    </div>        
                    <div class="nk-block-head-content">
                        <ul class="nk-block-tools g-3">
                            <li>
                                <a href="javascript:;" onclick="AddPositionModal()" class="btn btn-white btn-outline-light">
                                    <em class="icon ni ni-plus"></em>
                                    <span class="font-helvetica-regular">ახალი პოზიციის დამატება</span>
                                </a>
                            </li>
                        </ul>
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
                                                <th class="nk-tb-col"><span class="sub-text"></span>ID</th>
                                                <th class="nk-tb-col"><span class="sub-text">პოზიციის დასახელება</span></th>
                                                <th class="nk-tb-col"><span class="sub-text">სტატუსი</span></th>
                                                <th class="nk-tb-col nk-tb-col-tools text-right"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($user_work_position_list as $position_item)
                                            <tr class="nk-tb-item">
                                                <td class="nk-tb-col">
                                                    <div class="user-card">
                                                        <div class="user-info">
                                                            <span class="tb-lead font-helvetica-regular">{{ $position_item->id }}</span>
                                                        </div>
                                                    </div>
                                                </td><td class="nk-tb-col">
                                                    <div class="user-card">
                                                        <div class="user-info">
                                                            <span class="tb-lead font-helvetica-regular">{{ $position_item->name }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col tb-col-md">
                                                    @if($position_item->id != 1)
                                                    <div class="form-group">
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input" name="reg-public" id="position_{{ $position_item->id }}" value="1" @if($position_item->active == 1) checked @endif onclick="PositionActiveChange({{ $position_item->id}}, this)">
                                                            <label class="custom-control-label" for="position_{{ $position_item->id }}"></label>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </td>
                                                <td class="nk-tb-col nk-tb-col-tools">
                                                    @if($position_item->id != 1)
                                                    <ul class="nk-tb-actions gx-1">
                                                        <li>
                                                            <div class="drodown">
                                                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <ul class="link-list-opt no-bdr font-helvetica-regular" style="width: 300px;">
                                                                        <li><a href="javascript:;" onclick="PositionEdit({{ $position_item->id }})"><em class="icon ni ni-edit"></em><span>რედაქტირება</span></a></li>
                                                                        <li><a href="javascript:;" class="text-danger" onclick="PositionDelete({{ $position_item->id }})"><em class="icon ni ni-trash"></em><span>წაშლა</span></a></li>
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
<div class="modal fade" id="position_modal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-top" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-neue position-modal-title"></h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" class="form-validate is-alter" id="position_form">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 mb-3">
                            <div class="form-group">
                                <label class="form-label" for="position_name">დასახელება</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control error-input" name="position_name" id="position_name">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="position_id" id="position_id">
                        <div class="col-lg-12 mb-3">
                            <div class="form-group">
                                <button type="button" onclick="PositionSubmit()" class="btn btn-lg btn-primary font-helvetica-regular">შენახვა</button>
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
<script src="{{ url('assets/scripts/users_scripts.js') }}"></script>
@endsection