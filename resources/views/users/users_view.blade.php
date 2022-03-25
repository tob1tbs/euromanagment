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
								        <div class="nk-block">
                                            <div class="nk-data data-list">
                                                <div class="data-item">
                                                    <div class="data-col">
                                                        <span class="data-label font-neue">სახელი გვარი</span>
                                                        <span class="data-value font-helvetica-regular">{{ $user_data->name }} {{ $user_data->lastname }}</span>
                                                    </div>
                                                </div>
                                                <div class="data-item">
                                                    <div class="data-col">
                                                        <span class="data-label font-neue">პირადი ნომერი</span>
                                                        <span class="data-value font-helvetica-regular">{{ $user_data->personal_id }}</span>
                                                    </div>
                                                </div>
                                                <div class="data-item">
                                                    <div class="data-col">
                                                        <span class="data-label font-neue">დაბადების თარიღი</span>
                                                        <span class="data-value font-helvetica-regular">{{ $user_data->bday }}</span>
                                                    </div>
                                                </div>
                                                <div class="data-item">
                                                    <div class="data-col">
                                                        <span class="data-label font-neue">ტელეფონის ნომერი</span>
                                                        <span class="data-value font-helvetica-regular">{{ $user_data->phone }}</span>
                                                    </div>
                                                </div>
                                                <div class="data-item">
                                                    <div class="data-col">
                                                        <span class="data-label font-neue">ელ-ფოსტა</span>
                                                        <span class="data-value font-helvetica-regular">{{ $user_data->email }}</span>
                                                    </div>
                                                </div>
                                                <div class="data-item">
                                                    <div class="data-col">
                                                        <span class="data-label font-neue">წვდომის ჯგუფი</span>
                                                        <span class="data-value font-helvetica-regular">{{ $user_data->role_id }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="nk-data data-list">
                                                <div class="data-head">
                                                    <h6 class="overline-title font-neue">სამუშაო პოზიცია</h6>
                                                </div>
                                                <table class="table table-sm">
                                                    <thead>
                                                        <tr class="font-neue text-center">
                                                          <th scope="col">სამუშაო პოზიცია</th>
                                                          <th scope="col">ხელფასი</th>
                                                          <th scope="col">ფილიალი / განყოფილება</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($user_data->workData as $work_item)
                                                    <tr class="font-helvetica-regular text-center">
                                                        <td>{{ $work_item->userPosition->name}}</td>
                                                        <td>{{ $work_item->salary }} ₾</td>
                                                        <td>{{ $work_item->userBranch->name }} / {{ $work_item->userBranchDepartament->name }}</td>
                                                    </tr>
                                                    @endforeach
                                                  </tbody>
                                                </table>
                                            </div>
                                            <div class="nk-data data-list">
                                                <div class="data-head">
                                                    <h6 class="overline-title font-neue">საკონტაქტი პირები</h6>
                                                </div>
                                                <div class="data-item">
                                                    <div class="data-col">
                                                        <span class="data-label font-neue">Language</span>
                                                        <span class="data-value font-helvetica-regular">English (United State)</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
								    </div>
								    <div class="tab-pane" id="work_calendar">
				                        <div class="card-inner">
                                            <div style="margin: 20px 0;">
                                                <span style="width: 20px; height: 20px; background: #526484; padding: 7px; border-radius: 5px; color: #fff; font-size: 12px;" class="font-neue">სამუშაო დღე</span>
                                                <span style="width: 20px; height: 20px; background: #d52800; padding: 7px; border-radius: 5px; color: #fff; font-size: 12px;" class="font-neue">შვებულება</span>
                                            </div>
                                            <div id="calendar" class="nk-calendar"></div>
                                        </div>
								    </div>
								    <div class="tab-pane" id="vacation_list">
								        <table class="table table-ulogs">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th class="tb-col-time font-neue"><span class="overline-title">#</span></th>
                                                    <th class="tb-col-time font-neue"><span class="overline-title">გასვლის თარიღი</span></th>
                                                    <th class="tb-col-time font-neue"><span class="overline-title">დაბრუნების თარიღი</span></th>
                                                    <th class="tb-col-time font-neue"><span class="overline-title">შექმნა</span></th>
                                                    <th class="tb-col-time font-neue"><span class="overline-title">შექმნის თარიღი</span></th>
                                                    <th class="tb-col-action"><span class="overline-title">წაშლა</span></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($user_work_vacation as $vacation_item)
                                                <tr class="font-helvetica-regular">
                                                    <td class="tb-col-time">{{ $vacation_item->id }}</td>
                                                    <td class="tb-col-time"><span class="sub-text">{{ $vacation_item->date_from }}</span></td>
                                                    <td class="tb-col-time"><span class="sub-text">{{ $vacation_item->date_to }}</span></td>
                                                    <td class="tb-col-time"><span class="sub-text">{{ $vacation_item->CreatedBy->name }} {{ $vacation_item->CreatedBy->lastname }}</span></td>
                                                    <td class="tb-col-time"><span class="sub-text">{{ \Carbon\Carbon::parse($vacation_item->created_at)->format('Y-m-d') }}</span></td>
                                                    <td class="tb-col-action"><a href="javascript:;" onclick="DeleteVacation({{ $vacation_item->id }})">წაშლა</a></td>
                                                </tr>
                                                @endforeach
                                            <tbody>
                                        </table>
								    </div>
								</div>
                            </div>
                            <div class="card-aside card-aside-left user-aside toggle-slide toggle-slide-left toggle-break-lg" data-content="userAside" data-toggle-screen="lg" data-toggle-overlay="true">
                                <div class="card-inner-group" data-simplebar>
                                    <div class="card-inner p-0">
                                        <div class="card-inner p-0">
                                            <ul class="link-list-menu font-helvetica-regular">
                                                <li><a href="javascript:;"><span>პროფილის რედაქტირება</span></a></li>
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
<style type="text/css">
    .data-head {
        border-radius: 0;
    }
</style>
<div class="modal fade" tabindex="-1" id="addUserWorkModal">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-neue">განრიგში ჩამატება</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" id="add_user_work_modal" class="form-validate is-alter">
                    <div class="row gx-4 gy-3">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">თანამშრომელი</label>
                                <div class="form-control-wrap">
                                    <select class="form-select form-control form-control-lg" data-search="on" id="work_user_id" name="work_user_id">
                                        <option value="{{ $user_data->id }}">{{ $user_data->name }} {{ $user_data->lastname }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">თარიღი</label>
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-left">
                                        <em class="icon ni ni-calendar"></em>
                                    </div>
                                    <input type="text" id="work_date" name="work_date" class="form-control date-picker" data-date-format="yyyy-mm-dd">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <ul class="d-flex justify-content-between gx-4 mt-1">
                                <li>
                                    <button id="addEvent" type="button" onclick="addUserWorkSubmit()" class="btn btn-primary font-helvetica-regular">დამატება</button>
                                </li>
                                <li>
                                    <button id="resetEvent" data-dismiss="modal" class="btn btn-danger btn-dim font-helvetica-regular">გათიშვა</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ url('assets/js/libs/fullcalendar.js') }}"></script>
<script src="{{ url('assets/scripts/users_scripts.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'ka',
            timeZone: 'UTC',
            themeSystem: 'bootstrap',
            headerToolbar: {
                left: 'prev',
                center: 'title',
                right: 'next',
            },
            height: 800,
            contentHeight: 780,
            aspectRatio: 5,
            editable: false,
            droppable: false,
            selectable: false,
            firstDay: 1,
            views: {
                    dayGridMonth: {
                    dayMaxEventRows: 7
                }
            },
            events: {
            url: '{{ route('ajaxUserWorkGetItem', request()->user_id) }}',
                failure: function() {
                  document.getElementById('script-warning').style.display = 'block'
                }
            },
            dateClick: function(info) {
                $("#work_date").val(info.dateStr);
                $("#addUserWorkModal").modal('show');    
            },
            eventClick: function(info) {
                if(info.event.extendedProps.is_vacation) {
                    Swal.fire({
                        icon: 'warning',
                        text: 'აღნიშნულ დღეს თანამშრომელი იმყოფება შვებულებაში.',
                        timer: 1500,
                        timerProgressBar: true,
                    })
                } else {
                    $.ajax({
                        dataType: 'json',
                        url: "/users/ajax/work/event",
                        type: "GET",
                        data: {
                            work_id: info.event.id,
                        },
                        success: function(data) {
                            if(data['status'] == true) {
                                $(".work-modal-title").html('სამუშაო ინფორმაცია');
                                $(".view_work_user").html(data['UserWorkData']['work_user']['name']+' '+data['UserWorkData']['work_user']['lastname']);
                                $(".view_work_date").html(data['UserWorkData']['work_date']);
                                $(".view_work_creator").html(data['UserWorkData']['work_creator']['name']+' '+data['UserWorkData']['work_creator']['lastname']);
                                $("#view_work_id").val(data['UserWorkData']['id']);
                                $("#view_event_id").val(info.event.id);
                                $("#viewUserWorkModal").modal('show');
                            } else {
                                Swal.fire({
                                  icon: 'error',
                                  text: data['message'],
                                })
                            }
                        }
                    });
                }
            }
        });

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
           calendar.render();
        });
    });
</script>
@endsection