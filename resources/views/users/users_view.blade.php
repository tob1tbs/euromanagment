@extends('layout.layout')

@section('css')

@endsection

@section('content')
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block">
                    <div class="card card-bordered">
                        <div class="card-aside-wrap">
                            <div class="card-inner card-inner-lg p-0">
                            	<ul class="nav nav-tabs pl-4 font-helvetica-regular">
								    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#personal_information">პირადი ინფორმაცია</a></li>
								    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#work_calendar">სამუშაო კალენდარი</a></li>
								    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#vacation_list">შვებულება</a></li>
								</ul>
								<div class="tab-content mt-0">
								    <div class="tab-pane active" id="personal_information">
								        <p>content</p>
								    </div>
								    <div class="tab-pane" id="work_calendar">
								        
								    </div>
								    <div class="tab-pane" id="vacation_list">
								        
								    </div>
								</div>
                            </div>
                            <div class="card-aside card-aside-left user-aside toggle-slide toggle-slide-left toggle-break-lg" data-content="userAside" data-toggle-screen="lg" data-toggle-overlay="true">
                                <div class="card-inner-group" data-simplebar>
                                    <div class="card-inner">
                                        <div class="user-card">
                                            <div class="user-info">
                                                <span class="lead-text font-neue">{{ $user_data->name }} {{ $user_data->lastname }}</span>
                                                @foreach($user_work_data as $work_item)
                                                <span class="sub-text font-helvetica-regular">{{ $work_item->userPosition->name }}</span>
                                                @endforeach
                                            </div>
                                            <div class="user-action">
                                                <div class="dropdown">
                                                    <a class="btn btn-icon btn-trigger mr-n2" data-toggle="dropdown" href="#"><em class="icon ni ni-more-v"></em></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <ul class="link-list-opt no-bdr font-helvetica-regular">
                                                            <li><a href="#"><em class="icon ni ni-edit-fill"></em><span>პროფილის რედაქტირება</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-inner">
                                        <div class="user-account-info py-0">
                                            <h6 class="overline-title-alt">{{ $user_data->phone}}</h6>
                                            <h6 class="overline-title-alt">{{ $user_data->email}}</h6>
                                        </div>
                                    </div>
                                    <div class="card-inner p-0">
                                        <div class="card-inner p-0">
                                            <ul class="link-list-menu font-helvetica-regular">
                                                <li><a href="javascript:;" onclick="AddVacationModal()"><span>შვებულების დამატება</span></a></li>
                                            </ul>
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
<div class="modal fade" tabindex="-1" id="AddVacationModal">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-neue">შვებულების დამატება</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" id="add_user_vacation_form" class="form-validate is-alter">
                    <div class="row gx-4 gy-3">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">შვებულების ტიპი</label>
                                <div class="form-control-wrap">
                                    <select id="vacation_type" name="vacation_type" class="form-control">
                                        @foreach($user_work_vacation_type_list as $type_item)
                                        <option value="{{ $type_item->id }}">{{ $type_item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">გასვლის თარიღი</label>
                                <div class="form-control-wrap">
                                    <input type="date" name="vacation_start" class="form-control date-pick">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">დაბრუნების თარიღი</label>
                                <div class="form-control-wrap">
                                    <input type="date" name="vacation_end" class="form-control date-pick">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <ul class="d-flex justify-content-between gx-4 mt-1">
                                <li>
                                    <button id="resetEvent" data-dismiss="modal" class="btn btn-danger btn-dim font-helvetica-regular">გათიშვა</button>
                                </li>
                                <li>
                                    <button id="addEvent" type="button" onclick="UserVacationValidate()" class="btn btn-primary font-helvetica-regular">თარიღების შემოწმება</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <input type="hidden" name="vacation_user_id" value="{{ request()->user_id }}">
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ url('assets/scripts/users_scripts.js') }}"></script>
@endsection