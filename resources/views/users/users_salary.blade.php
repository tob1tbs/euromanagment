@extends('layout.layout')

@section('css')

@endsection

@section('content')
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-xl">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-fmg">
                    <div class="nk-fmg-body">
                        <div class="nk-fmg-body-content">
                            <div class="nk-fmg-listing nk-block-lg">
                                <div class="nk-block-head-xs">
                                    <div class="nk-block-between g-2">
                                        <div class="nk-block-head-content">
                                            <h6 class="nk-block-title title font-neue">თანამშრომელთა ხელფასები</h6>
                                        </div>

                                    </div>
                                </div>
                                <form action="#">
                                    <div class="row g-4">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="form-label" for="salary_year">წელი</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-control" id="salary_year" name="salary_year">
                                                        @foreach($year_list as $year_item)
                                                        <option value="{{ $year_item }}" @if(empty(request()->salary_year)) @if($current_date->format('Y') == $year_item) selected @endif @else @if(request()->salary_year == $year_item) selected @endif @endif>{{ $year_item }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="form-label" for="salary_month">თვე</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-control" id="salary_month" name="salary_month">
                                                        @foreach($month_list as $month_key => $month_item)
                                                        <option value="{{ $month_key }}" @if(empty(request()->salary_month)) @if($current_date->format('m') == $month_key) selected @endif @else @if(request()->salary_month == $month_key) selected @endif @endif>{{ $month_item }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="form-label" for="salary_work_position">სამუშაო პოზიცია</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-control" id="salary_work_position" name="salary_work_position">
                                                        <option value="0"></option>
                                                        @foreach($work_position as $work_item)
                                                        <option value="{{ $work_item->id }}" @if(request()->salary_work_position == $work_item->id) selected @endif>{{ $work_item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="form-label" for="salary_search_query">სწრაფი ძებნა</label>
                                                <div class="form-control-wrap ">
                                                    <input type="text" class="form-control" id="salary_search_query" name="salary_search_query" value="{{ request()->salary_search_query }}" placeholder="სახელი, გვარი, პირადი ნომერი, სხვა...">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-1">
                                            <div class="form-group">
                                                <label class="form-label" for="pay-amount-1">&nbsp;</label>
                                                <div class="form-control-wrap">
                                                    <button type="submit" class="btn btn-success font-neue">ძებნა</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="tab-content">
                                    <table class="table mt-2">
                                        <tbody style="border: 1px solid #dbdfea;">
                                            @foreach($salary_data as $solary_item)
                                            <tr class="font-neue" style="border-top: 1px solid #dbdfea;">
                                                <th >{{ $solary_item['position_data']['name'] }}</th>
                                                @for ($i = 0; $i < $days_count; $i++)
                                                <th></th>
                                                @endfor
                                                <th style="border: 1px solid #dbdfea; text-align: center;">ფიქსირებული</th>
                                                <th style="border: 1px solid #dbdfea; text-align: center;">დღიური</th>
                                                <th style="border: 1px solid #dbdfea; text-align: center;">ჯამი</th>
                                            </tr>
                                            @foreach($solary_item['data'] as $item)
                                            <tr class="font-helvetica-regular salary-line">
                                                <th>&bull; <span class="pl-1">{{ $item['name'] }} {{ $item['lastname'] }}</span></th>
                                                @foreach($item['calendar'] as $salary_key => $salary_item)
                                                    @if($salary_item['work_on_this_day'] == 1)
                                                        @if($salary_item['total_day_salary'] == 0)
                                                        <th class="day-cell" style="border: 1px solid #dbdfea;" onclick="AddUserSalary('{{ $item['user_id'] }}', '{{ $item['position_id'] }}', '{{ $salary_item['date']}}')">{{ $salary_key }}</th>
                                                        @else
                                                        <th style="border: 1px solid #dbdfea;" class="table-cell day-cell" onclick="ViewUserSalary({{ $salary_item['id'] }})">{{ $salary_item['total_day_salary'] }}</th>
                                                        @endif
                                                    @else
                                                    <th class="day-cell" style="border: 1px solid #dbdfea; " onclick="UserNotWorking({{ $salary_item['date'] }})">{{ $salary_key }}</th>
                                                    @endif
                                                @endforeach
                                                <th class="text-center" style="border: 1px solid #dbdfea;">{{ $item['basic_salary'] }} ₾</th>
                                                <th class="text-center" style="border: 1px solid #dbdfea;">{{ $item['total_salary'] }}</span> ₾</th>
                                                <th class="text-center" style="border: 1px solid #dbdfea;">{{ $item['basic_salary'] + $item['total_salary'] }}</span> ₾</th>
                                            </tr>
                                            @endforeach
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
<div class="modal fade" tabindex="-1" id="userAddSalary">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-neue">ხელფასის დამატება</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" id="add_user_salary_form" class="form-validate is-alter">
                    <div class="row gx-4 gy-3">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label" for="salary_date">თარიღი</label>
                                <div class="form-control-wrap">
                                    <input type="text" id="salary_date" name="salary_date" class="form-control date-picker valid" data-date-format="yyyy-mm-dd" aria-invalid="false">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label" id="user_day_salary">დღიური ხელფასი</label>
                                <div class="form-control-wrap">
                                    <input type="number" class="form-control" id="user_day_salary" name="user_day_salary">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label" id="user_bonus_salary">ბონუსი</label>
                                <div class="form-control-wrap">
                                    <input type="number" class="form-control" id="user_bonus_salary" name="user_bonus_salary">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label" id="user_fine_salary">ჯარიმა</label>
                                <div class="form-control-wrap">
                                    <input type="number" class="form-control" id="user_fine_salary" name="user_fine_salary">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label" id="user_fine_salary">ჯარიმა</label>
                                <div class="form-control-wrap">
                                    <textarea class="form-control" id="user_salary_comment" name="user_salary_comment"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <button class="btn btn-success font-neue" type="button" onclick="AddSalarySubmit()">შენახვა</button>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="salary_user_id" id="salary_user_id">
                    <input type="hidden" name="salary_position" id="salary_position">
                </form>
            </div>
        </div>
    </div>
</div>  
<div class="modal fade" tabindex="-1" id="userViewSalary">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-neue">ხელფასის დეტალები</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="#" id="add_user_salary_form" class="form-validate is-alter">
                    <div class="row g-3 align-center">
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="form-label">თანამშრომელი:</label>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="form-group">
                                <span class="view_salary_user font-helvetica-regular"></span>
                            </div>
                        </div> 
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="form-label">თარიღი:</label>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="form-group">
                                <span class="view_salary_date font-helvetica-regular"></span>
                            </div>
                        </div> 
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="form-label">გამომუშავებული ხელფასი:</label>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="form-group">
                                <span class="view_salary font-helvetica-regular"></span> ₾
                            </div>
                        </div> 
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="form-label">ბონუსი:</label> ₾
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="form-group">
                                <span class="view_salary_bonus font-helvetica-regular"></span> ₾
                            </div>
                        </div> 
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="form-label">ჯარიმა:</label>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="form-group">
                                <span class="view_salary_fine font-helvetica-regular"></span> ₾
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="form-label">შექმნა:</label>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="form-group">
                                <span class="view_salary_creator font-helvetica-regular"></span>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label class="form-label">კომენტარი:</label>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="form-group">
                                <span class="view_salary_comment font-helvetica-regular"></span>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="view_salary_id" id="view_salary_id">
                </form>
            </div>
            <div class="modal-footer bg-white">
                <a href="javascript:;" class="btn btn-dim btn-danger font-helvetica-regular" onclick="DeleteUserSalary()">წაშლა</a>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
    .table-cell {
        background: #92e28d;
        color: #000000;
        cursor: pointer;
        opacity: 1 !important;
    }

    .salary-line {
        position: relative;
    }

    .salary-line:hover, .day-cell:hover {
        -webkit-box-shadow: inset 0px 0px 0px 3px rgba(49,183,245,1);
        -moz-box-shadow: inset 0px 0px 0px 3px rgba(49,183,245,1);
        box-shadow: inset 0px 0px 0px 3px rgba(49,183,245,1);
        cursor: pointer;
        opacity: 1;
    }
</style>
@endsection

@section('js')
<script src="{{ url('assets/scripts/users_scripts.js') }}"></script>
@endsection