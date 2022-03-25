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
                            <h3 class="nk-block-title page-title font-neue">სამუშაო კალენდარი</h3>
                        </div>
                        <div class="nk-block-head-content">
                            <a href="#" class="btn btn-primary font-helvetica-regular" onclick="addUserWorkModal()">
                                <em class="icon ni ni-plus"></em><span>დამატება</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="nk-block">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <div style="margin: 20px 0;">
                                <span style="width: 20px; height: 20px; background: #526484; padding: 7px; border-radius: 5px; color: #fff; font-size: 12px;" class="font-neue">სამუშაო დღე</span>
                                <span style="width: 20px; height: 20px; background: #d52800; padding: 7px; border-radius: 5px; color: #fff; font-size: 12px;" class="font-neue">შვებულება</span>
                            </div>
                            <div id="calendar" class="nk-calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
                                        <option value="0">გთხოვთ აირჩიოთ თანამშრომელი</option>
                                        @foreach($users_list as $user_item)
                                        <option value="{{ $user_item->id }}">{{ $user_item->name }} {{ $user_item->lastname }}</option>
                                        @endforeach
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
<div class="modal fade" tabindex="-1" id="viewUserWorkModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title work-modal-title font-helvetica-regular"></h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <div class="row g-3 align-center">
                    <div class="col-lg-5">
                        <div class="form-group">
                            <label class="form-label">თანამშრომელი:</label>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="form-group">
                            <span class="view_work_user font-helvetica-regular"></span>
                        </div>
                    </div> 
                    <div class="col-lg-5">
                        <div class="form-group">
                            <label class="form-label">სამუშაო თარიღი:</label>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="form-group">
                            <span class="view_work_date font-helvetica-regular"></span>
                        </div>
                    </div> 
                    <div class="col-lg-5">
                        <div class="form-group">
                            <label class="form-label">შეადგინა:</label>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="form-group">
                            <span class="view_work_creator font-helvetica-regular"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-white">
                <input type="hidden" name="view_work_id" id="view_work_id">
                <input type="hidden" name="view_event_id" id="view_event_id">
                <a href="javascript:;" class="btn btn-dim btn-danger font-helvetica-regular" onclick="DeleteUserWork()">წაშლა</a>
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
            url: '{{ route('ajaxUserWorkGet') }}',
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
        calendar.render();
    });
</script>
@endsection