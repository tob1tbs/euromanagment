<?php

namespace App\Modules\Users\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Modules\Users\Models\User;
use App\Modules\Users\Models\UserRole;
use App\Modules\Users\Models\UserPermissionGroup;
use App\Modules\Users\Models\UserWorkSalary;
use App\Modules\Users\Models\UserSalary;
use App\Modules\Users\Models\UserWorkPosition;
use App\Modules\Users\Models\UserWorkCalendar;
use App\Modules\Users\Models\UserWorkData;
use App\Modules\Users\Models\UserWorkVacation;
use App\Modules\Users\Models\UserWorkVacationType;
use App\Modules\Users\Models\UserContact;

use App\Modules\Company\Models\Branch;

use Carbon\Carbon;

use Auth;

class UsersController extends Controller
{

    public function __construct() {
        
    }

    public function actionUsersLogin(Request $Request) {
        if (view()->exists('users.users_login')) {

            $data = [
                
            ];

            return view('users.users_login', $data);
        } else {
            abort('404');
        }
    }

    public function actionUsersIndex(Request $Request) {
        if (view()->exists('users.users_index')) {

            $User = new User();
            $UserList = $User::where('deleted_at_int', '!=', 0)->orderBy('id', 'DESC')->get();

            $UserRole = new UserRole();
            $UserRoleList = $UserRole::where('deleted_at_int', '!=', 0)->where('active', 1)->get();

            $data = [
                'user_list' => $UserList,
                'user_role_list' => $UserRoleList,
            ];

            return view('users.users_index', $data);
        } else {
            abort('404');
        }
    }

    public function actionUsersAdd() {
        if (view()->exists('users.users_add')) {

            $UserWorkPosition = new UserWorkPosition();
            $UserWorkPositionList = $UserWorkPosition::where('deleted_at_int', '!=', 0)->where('active', 1)->get();

            $Branch = new Branch();
            $BranchList = $Branch::where('parent_id', 0)->where('deleted_at_int', '!=', 0)->where('active', 1)->get();

            $data = [
                'work_position_list' => $UserWorkPositionList,
                'branch_list' => $BranchList,
            ];

            return view('users.users_add', $data);
        } else {
            abort('404');
        }
    }

    public function actionUsersEdit(Request $Request) {
        if (view()->exists('users.users_edit')) {

            $data = [];

            return view('users.users_edit', $data);
        } else {
            abort('404');
        }
    }

    public function actionUsersCalendar(Request $Request) {
        if (view()->exists('users.users_calendar')) {

            $User = new User();
            $UserList = $User::where('deleted_at_int', '!=', 0)->where('active', 1)->get();

            $data = [
                'users_list' => $UserList,
            ];

            return view('users.users_calendar', $data);
        } else {
            abort('404');
        }
    }

    public function actionUsersSalary(Request $Request) {
        if (view()->exists('users.users_salary')) { 

            $CurrentDate = Carbon::now()->locale('ka_GE');

            $User = new User();
            $UsersList = $User::where('deleted_at_int', '!=', 0)->where('active', 1);

            if($Request->has('salary_year')) {
                $SalaryYear = $Request->salary_year;
            } else {
                $SalaryYear = Carbon::now()->year;
            }

            if($Request->has('salary_month')) {
                $SalaryMonth = $Request->salary_month;
            } else {
                $SalaryMonth = Carbon::now()->format('m');
            }

            $DaysInMonth = Carbon::create($SalaryYear, $SalaryMonth)->daysInMonth;

            if($Request->isMethod('GET')) {
                if($Request->has('salary_search_query') && !empty($Request->salary_search_query)) {
                    $UsersList->where(function($query) use ($Request) {
                        $query->where('new_users.name', 'like', '%'.$Request->salary_search_query.'%');
                        $query->orWhere('new_users.lastname', 'like', '%'.$Request->salary_search_query.'%');
                        $query->orWhere('new_users.personal_id', 'like', '%'.$Request->salary_search_query.'%');
                        $query->orWhere('new_users.phone', 'like', '%'.$Request->salary_search_query.'%');
                    });
                }

                if($Request->has('salary_work_position') && !empty($Request->salary_work_position)) {
                    $UsersList->whereHas('workData', function ($query) use ($Request) {
                        $query->where('new_users_work_data.deleted_at_int', '!=', 0);
                        $query->where('new_users_work_data.position_id', $Request->salary_work_position);
                    });
                }
            }

            $UsersList = $UsersList->whereRelation('workData', 'deleted_at_int', '!=', 0);

            $UsersList = $UsersList->get()->load('workData');

            $SalaryArray = [];
            $RenderCalendar = [];

            $UserWorkPosition = new UserWorkPosition();
            $UserWorkPositionList = $UserWorkPosition::where('deleted_at_int', '!=', 0)->where('active', 1)->get();

            foreach($UsersList as $UserKey => $UserItem) {
                foreach($UserItem->workData as $Item) {
                    if($Item->deleted_at_int == 1) {

                        foreach($UserWorkPositionList as $PositionItem) {
                            if($PositionItem->id == $Item->position_id) {
                                $SalaryArray[$Item->position_id]['position_data'] = [
                                    'name' => $PositionItem->name,
                                ];
                            }
                        }

                        $SalaryArray[$Item->position_id]['data'][$UserItem->id] = [
                            'user_id' => $UserItem->id,
                            'name' => $UserItem->name,
                            'lastname' => $UserItem->lastname,
                            'position_id' => $Item->position_id,
                            'basic_salary' => $Item->salary,
                            'total_salary' => 0,
                        ];

                        for ($i = 1; $i <= $DaysInMonth; $i++) { 
                            $Day = sprintf("%02d", $i);
                            $RenderCalendar[$Day] = [
                                'id' => 0,
                                'date' => $SalaryYear.'-'.$SalaryMonth.'-'.$Day,
                                'day_salary' => 0,
                                'bonus' => 0,
                                'fine' => 0,
                                'total_day_salary' => 0,
                                'work_on_this_day' => 0,
                            ];
                        }

                        $SalaryArray[$Item->position_id]['data'][$UserItem->id]['calendar'] = $RenderCalendar;

                        $UserWorkCalendar = new UserWorkCalendar();
                        $UserWorkCalendarData = $UserWorkCalendar::where('user_id', $UserItem->id)
                        ->whereMonth('work_date', $SalaryMonth)
                        ->whereYear('work_date', $SalaryYear)
                        ->where('deleted_at_int', '!=', 0)
                        ->get();

                        foreach($UserWorkCalendarData as $CalendarItem) {
                            if($CalendarItem->user_id == $UserItem->id) {
                                $WorkDay =  carbon::parse($CalendarItem->work_date)->format('d');
                                $SalaryArray[$Item->position_id]['data'][$UserItem->id]['calendar'][$WorkDay]['work_on_this_day'] = 1;
                            }
                        }

                        $UserWorkSalary = new UserWorkSalary();
                        $UserWorkSalaryData = $UserWorkSalary::where('deleted_at_int', '!=', 0)->whereYear('date', $SalaryYear)->whereMonth('date', $SalaryMonth)->get();

                        $TotalSalary = 0;
                        $TotalBonus = 0;
                        $TotalFine = 0;

                        foreach($UserWorkSalaryData as $SalaryItem) {
                            if($SalaryItem->user_id == $UserItem->id && $SalaryItem->position_id == $Item->position_id) {
                                $Day =  carbon::parse($SalaryItem->date)->format('d');
                                
                                $TotalSalary = $TotalSalary + $SalaryItem->salary;
                                $TotalBonus = $TotalBonus + $SalaryItem->bonus;
                                $TotalFine = $TotalFine + $SalaryItem->fine;

                                $SalaryArray[$Item->position_id]['data'][$UserItem->id]['calendar'][$Day]['total_day_salary'] = $SalaryItem->salary + $SalaryItem->bonus - $SalaryItem->fine;
                                $SalaryArray[$Item->position_id]['data'][$UserItem->id]['calendar'][$Day]['day_salary'] = $SalaryItem->salary;
                                $SalaryArray[$Item->position_id]['data'][$UserItem->id]['calendar'][$Day]['bonus'] = $SalaryItem->bonus;
                                $SalaryArray[$Item->position_id]['data'][$UserItem->id]['calendar'][$Day]['fine'] = $SalaryItem->fine;
                                $SalaryArray[$Item->position_id]['data'][$UserItem->id]['calendar'][$Day]['id'] = $SalaryItem->id;
                                $SalaryArray[$Item->position_id]['data'][$UserItem->id]['total_salary'] = $TotalSalary + $TotalBonus - $TotalFine;

                            }
                        }

                    }
                }
            }

            $data = [
                'year_list' => $this->yearList(),   
                'month_list' => $this->monthList(),   
                'current_date' => $CurrentDate,
                'days_count' => $DaysInMonth,
                'salary_data' => $SalaryArray,
                'work_position' => $UserWorkPositionList,
            ];

            return view('users.users_salary', $data);
        } else {
            abort('404');
        }
    }

    public function actionUsersRole(Request $Request) {
        if (view()->exists('users.users_role')) {

            $UserRole = new UserRole();
            $UserRoleList = $UserRole::where('deleted_at_int', '!=', 0)->get();

            $UserPermissionGroup = new UserPermissionGroup();
            $UserPermissionGroupList = $UserPermissionGroup::where('deleted_at_int', '!=', 0)->where('active', 1)->get();

            $data = [
                'user_role_list' => $UserRoleList,
                'user_permission_group_list' => $UserPermissionGroupList,
            ];

            return view('users.users_role', $data);
        } else {
            abort('404');
        }
    }

    public function actionUsersPositions(Request $Request) {
        if (view()->exists('users.users_positions')) {

            $UserWorkPosition = new UserWorkPosition();
            $UserWorkPositionList = $UserWorkPosition::where('deleted_at_int', '!=', 0)->get();

            $data = [
                'user_work_position_list' => $UserWorkPositionList,
            ];

            return view('users.users_positions', $data);
        } else {
            abort('404');
        }
    }

    public function actionUsersView(Request $Request) {
        if (view()->exists('users.users_view')) {

            $User = new User();
            $UserData = $User::findOrFail($Request->user_id);

            $UserWorkData = new UserWorkData();
            $UserWorkDataList = $UserWorkData::where('user_id', $Request->user_id)->where('deleted_at_int', '!=', 0)->get();

            $UserWorkVacation = new UserWorkVacation();
            $UserWorkVacationList = $UserWorkVacation::where('user_id', $Request->user_id)->where('deleted_at_int', '!=', 0)->get();

            $UserWorkVacationType = new UserWorkVacationType();
            $UserWorkVacationTypeList = $UserWorkVacationType::where('deleted_at_int', '!=', 0)->get();

            $UserContact = new UserContact();
            $UserContactList = $UserContact::where('user_id', $Request->user_id)->where('deleted_at_int', '!=', 0)->get();

            $data = [
                'user_data' => $UserData,
                'user_work_data' => $UserWorkDataList,
                'user_work_vacation' => $UserWorkVacationList,
                'user_work_vacation_type_list' => $UserWorkVacationTypeList,
                'user_contact' => $UserContactList,
            ];

            return view('users.users_view', $data);
        } else {
            abort('404');
        }
    }

    public function actionUsersLogout(Request $Request) {
        Auth::logout();
        return redirect()->route('actionUsersLogin');
    }
}
