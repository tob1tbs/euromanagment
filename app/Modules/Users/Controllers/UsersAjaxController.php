<?php

namespace App\Modules\Users\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Modules\Users\Models\User;
use App\Modules\Users\Models\UserRole;
use App\Modules\Users\Models\UserPermission;
use App\Modules\Users\Models\UserPermissionGroup;
use App\Modules\Users\Models\UserRoleHasPermission;
use App\Modules\Users\Models\UserWorkCalendar;
use App\Modules\Users\Models\UserWorkSalary;
use App\Modules\Users\Models\UserWorkVacation;
use App\Modules\Users\Models\UserWorkVacationType;
use App\Modules\Users\Models\UserWorkData;
use App\Modules\Users\Models\UserWorkPosition;
use App\Modules\Users\Models\UserContact;

use App\Modules\Company\Models\Branch;

use Validator;
use Hash;
use Auth;
use Response;
use \Carbon\Carbon;
use \Carbon\CarbonPeriod;

use App\Exports\UserSalaryExport;
use Maatwebsite\Excel\Facades\Excel;

class UsersAjaxController extends Controller
{
    //ROLE - PERMISSION
    public function ajaxUserRoleSubmit(Request $Request) {
        if($Request->isMethod('POST')) {
            $messages = array(
                'required' => 'გთხოვთ შეავსოთ ყველა აუცილებელი ველი',
                'role_key.unique' => 'მოცემული KEY დაკავებულია',
            );
            $validator = Validator::make($Request->all(), [
                'role_title' => 'required|max:255',
                'role_name' => 'required|unique:new_roles,name,'.$Request->role_id.'|max:255',
            ], $messages);

            if ($validator->fails()) {
                return Response::json(['status' => true, 'errors' => true, 'message' => $validator->getMessageBag()->toArray()], 200);
            } else {
                $UserRole = new UserRole();
                $UserRoleInfo = $UserRole::updateOrCreate(
                    ['id' => $Request->role_id],
                    [
                        'id' => $Request->role_id,
                        'name' => $Request->role_name,
                        'title' => $Request->role_title,
                        'guard_name' => 'web',
                    ],
                );
                return Response::json(['status' => true, 'errors' => false, 'message' => 'წვდომის ჯგუფი წარმატებით დაემატა'], 200);
            }
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!'], 200);
        }
    }

    public function ajaxUserRoleActiveChange(Request $Request) {
        if($Request->isMethod('POST') && !empty($Request->role_id) && $Request->role_id != 1 && $Request->role_id != 2) {
            $UserRole = new UserRole();
            $UserRole::find($Request->role_id)->update([
                'active' => $Request->role_active,
            ]);
            return Response::json(['status' => true]);
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxUserRoleDelete(Request $Request) {
        if($Request->isMethod('POST') && !empty($Request->role_id) && $Request->role_id != 1 && $Request->role_id != 2) {
            $UserRole = new UserRole();
            $UserRole::find($Request->role_id)->update([
                'deleted_at' => Carbon::now(),
                'deleted_at_int' => 0,
                'active' => 0,
            ]);
            return Response::json(['status' => true, 'message' => 'ჯგუფი წარმატებით წაიშალა']);
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxUserRoleEdit(Request $Request) {
        if($Request->isMethod('GET') && !empty($Request->role_id) && $Request->role_id != 1 && $Request->role_id != 2) {
            $UserRole = new UserRole();
            $UserRoleData = $UserRole::find($Request->role_id);

            if(!empty($UserRoleData)) {
                return Response::json(['status' => true, 'UserRoleData' => $UserRoleData]);
            } else {
                return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა გთხოვთ სცადოთ თავიდან !!!'], 200);
            }
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxUserRolePermissions(Request $Request) {
        if($Request->isMethod('GET')) {
            $UserPermissionGroup = new UserPermissionGroup();
            $UserPermissionGroupData = $UserPermissionGroup::where('deleted_at_int', '!=', 0)->where('active', 1)->get()->toArray();

            $PermissionGroupArray = [];
            $PermissionArray = [];

            foreach($UserPermissionGroupData as $PermissionGroupItem) {

                $UserPermission = new UserPermission();
                $UserPermissionList = $UserPermission::where('group_id', $PermissionGroupItem['id'])
                ->where('deleted_at_int', '!=', 0)
                ->where('active', 1)
                ->get()
                ->toArray();

                foreach($UserPermissionList as $UserPermissionItem) {
                    if($PermissionGroupItem['id'] == $UserPermissionItem['group_id']) {
                        
                        $UserRoleHasPermission = new UserRoleHasPermission();
                        $UserRoleHasPermissionList = $UserRoleHasPermission::where('role_id', $Request->role_id)->get()->toArray();

                        $PermissionGroupArray['group_data'][$PermissionGroupItem['id']] = [
                            'group_id' => $PermissionGroupItem['id'],
                            'group_name' => $PermissionGroupItem['name'],
                            'permissions' => [
                                'list' => $UserPermissionList, 
                                'selected' => $UserRoleHasPermissionList
                            ],
                        ];
                    }
                }
            }
            return Response::json(['status' => true, 'PermissionGroupArray' => $PermissionGroupArray]);
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    } 

    public function ajaxUserRolePermissionsSubmit(Request $Request) {
        if($Request->isMethod('POST')) {
            $messages = array(
                'required' => 'გთხოვთ შეავსოთ ყველა აუცილებელი ველი',
                'permission_name.unique' => 'მოცემული KEY დაკავებულია',
            );
            $validator = Validator::make($Request->all(), [
                'permission_group' => 'required|max:255',
                'permission_title' => 'required|max:255',
                'permission_name' => 'required|unique:new_permissions,name|max:255',
            ], $messages);

            if ($validator->fails()) {
                return Response::json(['status' => true, 'errors' => true, 'message' => $validator->getMessageBag()->toArray()], 200);
            } else {
                $UserPermission = new UserPermission();
                $UserPermission::updateOrCreate(
                    ['id' => $Request->permission_id],
                    [
                        'id' => $Request->permission_id,
                        'name' => $Request->permission_name,
                        'title' => $Request->permission_title,
                        'guard_name' => 'web',
                        'group_id' => $Request->permission_group,
                    ],
                );

                $UserPermissionGroup = new UserPermissionGroup();
                $UserPermissionGroupData = $UserPermissionGroup::where('deleted_at_int', '!=', 0)->where('active', 1)->get()->toArray();

                $PermissionGroupArray = [];
                $PermissionArray = [];

                foreach($UserPermissionGroupData as $PermissionGroupItem) {

                    $UserPermission = new UserPermission();
                    $UserPermissionList = $UserPermission::where('group_id', $PermissionGroupItem['id'])
                    ->where('deleted_at_int', '!=', 0)
                    ->where('active', 1)
                    ->get()
                    ->toArray();

                    foreach($UserPermissionList as $UserPermissionItem) {
                        if($PermissionGroupItem['id'] == $UserPermissionItem['group_id']) {
                            
                            $UserRoleHasPermission = new UserRoleHasPermission();
                            $UserRoleHasPermissionList = $UserRoleHasPermission::where('role_id', $Request->permission_role_id)->get()->toArray();

                            $PermissionGroupArray['group_data'][$PermissionGroupItem['id']] = [
                                'group_id' => $PermissionGroupItem['id'],
                                'group_name' => $PermissionGroupItem['name'],
                                'permissions' => [
                                    'list' => $UserPermissionList, 
                                    'selected' => $UserRoleHasPermissionList
                                ],
                            ];
                        }
                    }
                }

                return Response::json(['status' => true, 'PermissionGroupArray' => $PermissionGroupArray]);
            }
        }
    }

    public function ajaxUserRolePermissionsSync(Request $Request) {
        if($Request->isMethod('POST') && !empty($Request->permission_role)) {
            $UserRoleHasPermission = new UserRoleHasPermission();
            $UserRoleHasPermission->where('role_id', $Request->permission_role)->delete();

            for ($i=0; $i < count($Request->permissions); $i++) { 
                $UserRoleHasPermission = new UserRoleHasPermission();
                $UserRoleHasPermission->role_id = $Request->permission_role;
                $UserRoleHasPermission->permission_id = $Request->permissions[$i];
                $UserRoleHasPermission->save();
            }
            
            return Response::json(['status' => true, 'message' => 'წვდომის ჯგუფი წარმატებით განახლდა']);
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxUserRolePermissionsDelete(Request $Request) {
        if($Request->isMethod('POST') && !empty($Request->permission_id)) {
            $UserPermission = new UserPermission();
            $UserPermission::find($Request->permission_id)->update([
                'deleted_at_int' => 0,
                'deleted_at' => Carbon::now(),
            ]);

            $UserRoleHasPermission = new UserRoleHasPermission();
            $UserRoleHasPermission->where('permission_id', $Request->permission_id)->where('role_id', $Request->role_id)->get();

            return Response::json(['status' => true, 'message' => 'უფლება წარმატებით წაიშალა !!!']);

        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    // USER WORK
    public function ajaxUserWorkGet(Request $Request) {
        if($Request->isMethod('GET')) {

            $StartDate = Carbon::parse($Request->start);
            $EndDate = Carbon::parse($Request->end);

            $UserWorkCalendar = new UserWorkCalendar();
            $UserWorkCalendarData = $UserWorkCalendar::where('deleted_at_int', '!=', 0)->whereBetween('work_date', [$StartDate, $EndDate])->get();
            $WorkArray = [];

            if(count($UserWorkCalendarData) > 0) {
                foreach($UserWorkCalendarData as $Key => $WorkItem) {
                    $WorkArray[] = [
                        'id' => $WorkItem->id,
                        'title' => $WorkItem->workUser->name.' '.$WorkItem->workUser->lastname,
                        'date' => $WorkItem->work_date,
                        'color' => '#526484',
                    ];
                }
            }

            $UserWorkVacation = new UserWorkVacation();
            $UserWorkVacationList = $UserWorkVacation::whereBetween('date_from', [$StartDate, $EndDate])->whereBetween('date_to', [$StartDate, $EndDate])->where('deleted_at_int', '!=', 0)->get();

            if(!empty($UserWorkVacationList)) {
                foreach($UserWorkVacationList as $VacationItem) {
                    $VacationPeriod = carbonPeriod::create(Carbon::parse($VacationItem->date_from), Carbon::parse($VacationItem->date_to)->subDays(1));
                    foreach($VacationPeriod as $VacationDate) {
                        $WorkArray[] = [
                            'id' => $VacationItem->id,
                            'title' => $VacationItem->vacationUser->name.' '.$VacationItem->vacationUser->lastname,
                            'date' => $VacationDate->format('Y-m-d'),
                            'color' => '#d52800',
                            'is_vacation' => 1,
                        ];
                    }
                }
            }

            return Response::json($WorkArray);
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxUserWorkGetItem(Request $Request) {
        if($Request->isMethod('GET')) {

            $StartDate = Carbon::parse($Request->start);
            $EndDate = Carbon::parse($Request->end);

            $UserWorkCalendar = new UserWorkCalendar();
            $UserWorkCalendarData = $UserWorkCalendar::where('deleted_at_int', '!=', 0)->whereBetween('work_date', [$StartDate, $EndDate])->where('user_id', $Request->user_id)->get();
            $WorkArray = [];

            if(count($UserWorkCalendarData) > 0) {
                foreach($UserWorkCalendarData as $Key => $WorkItem) {
                    $WorkArray[] = [
                        'id' => $WorkItem->id,
                        'title' => $WorkItem->workUser->name.' '.$WorkItem->workUser->lastname,
                        'date' => $WorkItem->work_date,
                        'color' => '#526484',
                    ];
                }
            }

            $UserWorkVacation = new UserWorkVacation();
            $UserWorkVacationList = $UserWorkVacation::whereBetween('date_from', [$StartDate, $EndDate])->whereBetween('date_to', [$StartDate, $EndDate])->where('deleted_at_int', '!=', 0)->where('user_id', $Request->user_id)->get();

            if(!empty($UserWorkVacationList)) {
                foreach($UserWorkVacationList as $VacationItem) {
                    $VacationPeriod = carbonPeriod::create(Carbon::parse($VacationItem->date_from), Carbon::parse($VacationItem->date_to)->subDays(1));
                    foreach($VacationPeriod as $VacationDate) {
                        $WorkArray[] = [
                            'id' => $VacationItem->id,
                            'title' => $VacationItem->vacationUser->name.' '.$VacationItem->vacationUser->lastname,
                            'date' => $VacationDate->format('Y-m-d'),
                            'color' => '#d52800',
                            'is_vacation' => 1,
                        ];
                    }
                }
            }

            return Response::json($WorkArray);
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxUserWorkGetUser(Request $Request) {
        if($Request->isMethod('GET')) {

            $StartDate = Carbon::parse($Request->start);
            $EndDate = Carbon::parse($Request->end);

            $UserWorkCalendar = new UserWorkCalendar();
            $UserWorkCalendarData = $UserWorkCalendar::where('deleted_at_int', '!=', 0)->where('user_id', $Request->user_id)->whereBetween('work_date', [$StartDate, $EndDate])->get();

            if(count($UserWorkCalendarData) > 0) {
                $WorkArray = [];
                foreach($UserWorkCalendarData as $Key => $WorkItem) {
                    $WorkArray[] = [
                        'id' => $WorkItem->id,
                        'title' => $WorkItem->workUser->name.' '.$WorkItem->workUser->lastname,
                        'date' => $WorkItem->work_date,
                        'color' => '#526484',
                    ];
                }
            }

            $UserWorkVacation = new UserWorkVacation();
            $UserWorkVacationList = $UserWorkVacation::whereBetween('date_from', [$StartDate, $EndDate])->where('user_id', $Request->user_id)->whereBetween('date_to', [$StartDate, $EndDate])->get();

            if(!empty($UserWorkVacationList)) {
                foreach($UserWorkVacationList as $VacationItem) {
                    $VacationPeriod = carbonPeriod::create(Carbon::parse($VacationItem->date_from), Carbon::parse($VacationItem->date_to)->subDays(1));
                    foreach($VacationPeriod as $VacationDate) {
                        $WorkArray[] = [
                            'id' => $VacationItem->id,
                            'title' => $WorkItem->workUser->name.' '.$WorkItem->workUser->lastname,
                            'date' => $VacationDate->format('Y-m-d'),
                            'color' => '#d52800',
                        ];
                    }
                }
            }

            return Response::json($WorkArray);
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxUserVacationValidate(Request $Request) {
        if($Request->isMethod('POST')) {
            $messages = array(
                'vacation_start.required' => 'გთხოვთ აირჩიოთ გასვლის თარიღი',
                'vacation_end.required' => 'გთხოვთ აირჩიოთ დაბრუნების თარიღი',
                'vacation_type.required' => 'გთხოვთ შვებულების ტიპი',
            );
            $validator = Validator::make($Request->all(), [
                'vacation_start' => 'required|max:255',
                'vacation_end' => 'required|max:255',
                'vacation_type' => 'required|max:255',
            ], $messages);

            if ($validator->fails()) {
                return Response::json(['status' => true, 'errors' => true, 'can_skip' => false, 'message' => $validator->getMessageBag()->toArray()], 200);
            } else {

                $StartDate = Carbon::parse($Request->vacation_start);
                $EndDate = Carbon::parse($Request->vacation_end);

                $NewVacation = carbonPeriod::create($StartDate, $EndDate->subDays(1));
                $VacationBussinesDays = $EndDate->diffInWeekDays($StartDate);

                $UserWorkVacationType = new UserWorkVacationType();
                $UserWorkVacationTypeData = $UserWorkVacationType::find($Request->vacation_type);

                $UserWorkVacation = new UserWorkVacation();
                $UserWorkVacationList = $UserWorkVacation::where('type_id', $Request->vacation_type)->where('user_id', $Request->vacation_user_id)->where('deleted_at_int', '!=', 0)->get();

                $UserWorkCalendar = new UserWorkCalendar();
                $UserWorkCalendarList = $UserWorkCalendar::where('user_id', $Request->vacation_user_id)->where('deleted_at_int', '!=', 0)->get();

                if($StartDate->gt($EndDate)) {
                    return Response::json(['status' => true, 'error' => false, 'skip' => false, 'message' => 'თარიღები არჩეულია არასწორად, გთხოვთ გადაამოწმოთ თარიღები !!!']);
                }

                if($VacationBussinesDays > $UserWorkVacationTypeData->max_at_one) {
                    return Response::json(['status' => true, 'error' => false, 'skip' => true, 'message' => 'არჩეული სამუშაო დღეები რაოდენობა აღემატება ერთჯერზე ნებადართულს !!!']);
                }

                foreach($NewVacation as $NewVacationItem) {
                    if(!empty($UserWorkCalendarList)) {
                        foreach($UserWorkCalendarList as $CalendarItem) {
                            if($NewVacationItem->format('Y-m-d') == Carbon::parse($CalendarItem->work_date)->format('Y-m-d')) {
                                return Response::json(['status' => true, 'error' => true, 'skip' => false,  'message' => $NewVacationItem->format('Y-m-d').' აღნიშნულ თარიღში თანამშრომელი მუშაობს !!!']);
                            }
                        }
                    }

                    if(!empty($UserWorkVacationList)) {
                        foreach($UserWorkVacationList as $WorkVacationItem) {
                            $UserVacationPeriod = carbonPeriod::create($WorkVacationItem->date_from, $WorkVacationItem->date_to)->toArray();
                            foreach($UserVacationPeriod as $VacationItem) {
                                if($VacationItem->format('Y-m-d') == Carbon::parse($NewVacationItem)->format('Y-m-d')) {
                                    return Response::json(['status' => true, 'error' => true, 'skip' => false,  'message' => $NewVacationItem->format('Y-m-d').' აღნიშნულ თარიღში თანამშრომელი იმყოფება შვებულებაში !!!']);                      
                                }
                            }
                        }
                    }
                }

                return Response::json(['status' => true, 'error' => false, 'skip' => true, 'message' => '']);
            }
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxUserVacationSubmit(Request $Request) {
        if($Request->isMethod('POST')) {
            $messages = array(
                'vacation_start.required' => 'გთხოვთ აირჩიოთ გასვლის თარიღი',
                'vacation_end.required' => 'გთხოვთ აირჩიოთ დაბრუნების თარიღი',
                'vacation_type.required' => 'გთხოვთ შვებულების ტიპი',
            );
            $validator = Validator::make($Request->all(), [
                'vacation_start' => 'required|max:255',
                'vacation_end' => 'required|max:255',
                'vacation_type' => 'required|max:255',
            ], $messages);

            if ($validator->fails()) {
                return Response::json(['status' => true, 'errors' => true, 'message' => $validator->getMessageBag()->toArray()], 200);
            } else {
                
                $StartDate = Carbon::parse($Request->vacation_start);
                $EndDate = Carbon::parse($Request->vacation_end);

                $VacationBussinesDays = $EndDate->diffInWeekDays($StartDate);

                $UserWorkVacation = new UserWorkVacation();
                $UserWorkVacation->date_from = $Request->vacation_start;
                $UserWorkVacation->date_to = $Request->vacation_end;
                $UserWorkVacation->user_id = $Request->vacation_user_id;
                $UserWorkVacation->type_id = $Request->vacation_type;
                $UserWorkVacation->days_count = $VacationBussinesDays;
                $UserWorkVacation->created_by = Auth::user()->id;
                $UserWorkVacation->comment = $Request->vacation_comment;
                $UserWorkVacation->save();

                return Response::json(['status' => true, 'error' => false, 'message' => 'შვებულება წარმატებით დაემატა !!!']);
            }
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxUserWorkAdd(Request $Request) {
        if($Request->isMethod('POST')) {

            $messages = array(
                'required' => 'გთხოვთ შეავსოთ ყველა აუცილებელი ველი',
                'not_in' => 'გთხოვთ შეავსოთ ყველა აუცილებელი ველი',
            );
            $validator = Validator::make($Request->all(), [
                'work_user_id' => 'required|max:255|not_in:0',
                'work_date' => 'required|max:255',
            ], $messages);

            if ($validator->fails()) {
                return Response::json(['status' => true, 'errors' => true, 'message' => $validator->getMessageBag()->toArray()], 200);
            } else {

                $UserWorkData = new UserWorkData();
                $UserWorkDataItem = $UserWorkData::where('user_id', $Request->work_user_id)->where('deleted_at_int', '!=', 0)->first();

                if(empty($UserWorkDataItem)) {
                    return Response::json(['status' => true, 'errors' => true, 'message' =>[0 => 'აღნიშნულ თანამშრომელს არ გააჩნია სამუშაო პოზიცია']]);
                }

                $UserWorkCalendar = new UserWorkCalendar();
                $UserWorkCalendarData = $UserWorkCalendar::whereDate('work_date', Carbon::parse($Request->work_date)->format('Y-m-d'))->where('user_id', $Request->work_user_id)->where('deleted_at_int', '!=', 0)->first();

                $UserWorkVacation = new UserWorkVacation();
                $UserWorkVacationList = $UserWorkVacation::where('user_id', $Request->work_user_id)->where('deleted_at_int', '!=', 0)->get();

                if(!empty($UserWorkCalendarData)) {
                    return Response::json(['status' => true, 'errors' => true, 'message' => ['0' => 'არჩეული თანამშრომელი უკვე დამატებულია არჩეულ დღეზე.']], 200);
                } else {
                    if(!empty($UserWorkVacationList)) {
                        foreach($UserWorkVacationList as $VacationItem) {
                            $VacationPeriod = carbonPeriod::create($VacationItem->date_from, Carbon::parse($VacationItem->date_to)->subDays(1));
                            foreach($VacationPeriod as $PeriodItem) {
                                if(Carbon::parse($PeriodItem->format('Y-m-d')) == Carbon::parse($Request->work_date)) {
                                    return Response::json(['status' => true, 'errors' => true, 'message' => ['0' => 'აღნიშნულ თარიღში თანამშრომელი იმყოფება შვებულებაში.']], 200);
                                }
                            }
                        }
                    }

                    $UserWorkCalendar = new UserWorkCalendar();
                    $UserWorkCalendar->user_id = $Request->work_user_id;
                    $UserWorkCalendar->work_date = $Request->work_date;
                    $UserWorkCalendar->created_by = Auth::user()->id;
                    $UserWorkCalendar->save();

                    $UserWorkData = $UserWorkCalendar::whereMonth('work_date', Carbon::parse($Request->work_date)->format('m'))->where('deleted_at_int', '!=', 0)->get();
                    
                    return Response::json(['status' => true, 'errors' => false, 'message' => 'თანამშრომელი დამატებულია განგრიგში.']);
                }
            }

        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxUserWorkEvent(Request $Request) {
        if($Request->isMethod('GET') && $Request->work_id > 0) {

            $UserWorkCalendar = new UserWorkCalendar();
            $UserWorkData = $UserWorkCalendar::find($Request->work_id)->load(['workCreator', 'workUser']);

            return Response::json(['status' => true, 'UserWorkData' => $UserWorkData]);

        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxUserWorkDelete(Request $Request) {
        if($Request->isMethod('POST') && $Request->work_id > 0) {

            $UserWorkCalendar = new UserWorkCalendar();
            $WorkData = $UserWorkCalendar::find($Request->work_id);

            $UserWorkSalary = new UserWorkSalary();
            $UserWorkSalary::where('user_id', $WorkData->user_id)->whereDate('date', $WorkData->work_date)->update([
                'deleted_at' => Carbon::now(),
                'deleted_at_int' => 0,
            ]);

            $WorkData->update([
                'deleted_at' => Carbon::now(),
                'deleted_at_int' => 0,
                'active' => 0,
            ]);

            $UserWorkData = $UserWorkData = $UserWorkCalendar::whereMonth('work_date', Carbon::parse($WorkData->work_date)->format('m'))->where('deleted_at_int', '!=', 0)->get();

            return Response::json(['status' => true, 'UserWorkData' => $UserWorkData, 'message' => 'თანამშრომელი წაიშალა განრიგიდან']);

        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    // SALARY
    public function ajaxUserSalarySubmit(Request $Request) {
        if($Request->isMethod('POST')) {

            $UserWorkCalendar = new UserWorkCalendar();
            $UserWorkCalendarData = $UserWorkCalendar::whereDate('work_date', Carbon::parse($Request->salary_date))
                                                        ->where('user_id', $Request->salary_user_id)
                                                        ->where('deleted_at_int', '!=', 0)
                                                        ->first();

            if(empty($UserWorkCalendarData)) {
                return Response::json(['status' => true, 'errors' => true, 'message' => 'აღნიშნული თანამშრომელი არ მუშაობდა '.$Request->salary_date.' ში, გთხოვთ გადაამოწმოთ მონაცემები.']);
            } else {
                $messages = array(
                    'user_day_salary.required' => 'გთხოვთ შეიყვანოთ დღიური ხელფასი',
                );
                $validator = Validator::make($Request->all(), [
                    'user_day_salary' => 'required|max:255',
                ], $messages);

                if ($validator->fails()) {
                    return Response::json(['status' => true, 'errors' => true, 'message' => $validator->getMessageBag()->toArray()], 200);
                } else {
                    $UserWorkSalary = new UserWorkSalary();
                    $UserWorkSalary->user_id = $Request->salary_user_id;
                    $UserWorkSalary->salary = $Request->user_day_salary;
                    $UserWorkSalary->bonus = $Request->user_bonus_salary;
                    $UserWorkSalary->fine = $Request->user_fine_salary;
                    $UserWorkSalary->date = $Request->salary_date;
                    $UserWorkSalary->position_id = $Request->salary_position;
                    $UserWorkSalary->comment = $Request->user_salary_comment;
                    $UserWorkSalary->created_by = Auth::user()->id;
                    $UserWorkSalary->save();

                    return Response::json(['status' => true, 'errors' => false, 'message' => 'ხელფასი წარმატებით დაემატა', 'user_id' => $Request->salary_user_id, 'day' => Carbon::parse($Request->salary_date)->format('d'), 'total' => $Request->user_day_salary + $Request->user_bonus_salary - $Request->user_fine_salary]);
                }
            }

        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxUserSalaryView(Request $Request) {
        if($Request->isMethod('GET')) {

            $UserWorkSalary = new UserWorkSalary();
            $UserWorkSalaryData = $UserWorkSalary::find($Request->salary_id)->load('salaryCreator')->load('salaryUser');

            return Response::json(['status' => true, 'UserWorkSalaryData' => $UserWorkSalaryData]);

        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxUserSalaryDelete(Request $Request) {
        if($Request->isMethod('POST') && $Request->salary_id > 0) {

            $UserWorkSalary = new UserWorkSalary();
            $UserWorkSalaryData = $UserWorkSalary::find($Request->salary_id)->update([
                'deleted_at' => Carbon::now(),
                'deleted_at_int' => 0,
                'deleted_by' => 1,
            ]);

            return Response::json(['status' => true, 'message' => 'ხელფასი წარმატებით წაიშლა']);

        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxUserActive(Request $Request) {
        if($Request->isMethod('POST') && !empty($Request->user_id) && $Request->user_id != 1) {
            $User = new User();
            $User::find($Request->user_id)->update([
                'active' => $Request->user_active,
            ]);
            return Response::json(['status' => true]);
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxUserSubmit(Request $Request) {
        if($Request->isMethod('POST')) {
            $messages = array(
                'required' => 'გთხოვთ შეავსოთ ყველა აუცილებელი ველი',
                'user_personal_id.unique' => 'პირადი ნომერი უკვე დაკავებულია',
                'user_email.unique' => 'ელ-ფოსტა უკვე დაკავებულია',
                'user_phone.unique' => 'ტელეფონის ნომერი უკვე დაკავებულია',
            );
            $validator = Validator::make($Request->all(), [
                'user_name' => 'required|max:255',
                'user_lastname' => 'required|max:255',
                'user_bday' => 'required|max:255',
                'user_personal_id' => 'required|unique:new_users,personal_id,'.$Request->user_id.'|max:255',
                'user_phone' => 'required|unique:new_users,phone,'.$Request->user_id.'|max:255',
                'user_email' => 'nullable|unique:new_users,email,'.$Request->user_id.'|max:255',
            ], $messages);

            if ($validator->fails()) {
                return Response::json(['status' => true, 'errors' => true, 'message' => $validator->getMessageBag()->toArray()], 200);
            } else {
                $User = new User();
                $UserData = $User::updateOrCreate(
                    ['id' => $Request->user_id],
                    [
                        'id' => $Request->user_id,
                        'name' => $Request->user_name,
                        'lastname' => $Request->user_lastname,
                        'personal_id' => $Request->user_personal_id,
                        'bday' => $Request->user_bday,
                        'phone' => $Request->user_phone,
                        'email' => $Request->user_email,
                        'address' => $Request->user_address,
                        'address_legal' => $Request->user_address_legal,
                    ],
                );

                if($Request->has('position')) {
                    for ($i=0; $i < count($Request->position); $i++) {
                        $UserWorkData = new UserWorkData();
                        $UserWorkData->position_id = $Request->position[$i];
                        $UserWorkData->user_id = $UserData->id;
                        $UserWorkData->salary_type = $Request->salary_type[$i];
                        $UserWorkData->branch_id = $Request->branch[$i];
                        $UserWorkData->departament_id = $Request->departament[$i];
                        $UserWorkData->salary = $Request->salary[$i];
                        $UserWorkData->save();
                    }
                }

                if($Request->has('contact_phone')) {
                    for ($i=0; $i < count($Request->contact_phone); $i++) {
                        $ContactArray = [
                            'identy' => $Request->contact_identy[$i],
                            'phone' => $Request->contact_phone[$i],
                        ];
                        $UserContact = new UserContact();
                        $UserContact->value = json_encode($ContactArray);
                        $UserContact->user_id = $UserData->id;
                        $UserContact->save();
                    }
                }

                return Response::json(['status' => true, 'redirect_url' => route('actionUsersView', $Request->user_id)]);
            }
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxUserDeletePosition(Request $Request) {
        if($Request->isMethod('POST') && !empty($Request->position_id)) {
            $UserWorkData = new UserWorkData();
            $UserWorkData->find($Request->position_id)->update([
                'deleted_at' => Carbon::now(),
                'deleted_at_int' => 0,
            ]);

            return Response::json(['status' => true]);
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxUserDeleteContact(Request $Request) {
        if($Request->isMethod('POST') && !empty($Request->contact_id)) {
            $UserContact = new UserContact();
            $UserContact->find($Request->contact_id)->update([
                'deleted_at' => Carbon::now(),
                'deleted_at_int' => 0,
            ]);

            return Response::json(['status' => true]);
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxGetDepartamentList(Request $Request) {
        if($Request->isMethod('GET') && $Request->branch_id > 0) {

            $Branch = new Branch();
            $BranchList  = $Branch::where('parent_id', $Request->branch_id)->where('deleted_at_int', '!=', 0)->where('active', 1)->get();

            return Response::json(['status' => true, 'BranchList' => $BranchList]);
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxUserLogin(Request $Request) {
        if($Request->isMethod('POST')) {
            
            $messages = array(
                'required' => 'ელ-ფოსტა ან პაროლი არასწორია',
            );
            $validator = Validator::make($Request->all(), [
                'user_phone' => 'required|max:255',
                'user_password' => 'required|max:255',
            ], $messages);

            if ($validator->fails()) {
                return Response::json(['status' => true, 'errors' => true, 'message' => $validator->getMessageBag()->toArray()], 200);
            } else {
                if(Auth::attempt(['phone' => $Request->user_phone, 'password' => $Request->user_password, 'deleted_at_int' => 1, 'active' => 1], true)) {
                   return Response::json(['status' => true, 'redirect_url' => route('actionMainIndex')]);
                } else {
                    return Response::json(['status' => true, 'errors' => true, 'message' => [0 => 'ელ-ფოსტა ან პაროლია არასწორია !!!']]);
                }
            }
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxUserSalaryDetail(Request $Request) {
        if($Request->isMethod('GET')) {

            $Date = $Request->salary_year.'-'.$Request->salary_month;
            $StartDate = Carbon::parse($Date)->startOfMonth();
            $EndDate = Carbon::parse($Date)->endOfMonth();

            $User = new User();
            $UserData = $User::find($Request->user_id);

            $UserWorkData = new UserWorkData();
            $UserWorkDataItem = $UserWorkData::where('user_id', $Request->user_id)->where('position_id', $Request->position_id)->where('deleted_at_int', '!=', 0)->first();

            $UserWorkSalary = new UserWorkSalary();
            $UserWorkSalaryList = $UserWorkSalary::where('user_id', $Request->user_id)
                                    ->whereDate('date', '>=', $StartDate)
                                    ->whereDate('date', '<=', $EndDate)
                                    ->orderBy('date', 'DESC')
                                    ->where('deleted_at_int', '!=', 0)
                                    ->get();

            return Response::json([
                'status' => true, 
                'sum' => $UserWorkSalaryList->sum('salary') + $UserWorkSalaryList->sum('bonus') - $UserWorkSalaryList->sum('fine'),
                'user_id' => $UserWorkDataItem->user_id,
                'month_salary' => $UserWorkDataItem->salary,
                'UserWorkSalaryList' => $UserWorkSalaryList, 
            ]);

        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxUserPositionSubmit(Request $Request) {
        if($Request->isMethod('POST')) {
            $messages = array(
                'required' => 'გთხოვთ შეავსოთ ყველა აუცილებელი ველი !!!',
            );
            $validator = Validator::make($Request->all(), [
                'position_name' => 'required|max:255',
            ], $messages);

            if ($validator->fails()) {
                return Response::json(['status' => true, 'errors' => true, 'message' => $validator->getMessageBag()->toArray()], 200);
            } else {
                $UserWorkPosition = new UserWorkPosition();
                $UserWorkPosition::updateOrCreate(
                    ['id' => $Request->position_id],
                    ['id' => $Request->position_id, 'name' => $Request->position_name],
                );

                return Response::json(['status' => true, 'errors' => false, 'message' => 'პოზიცია წარმატებით შეინახა.']);
            }
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxUserPositionEdit(Request $Request) {
        if($Request->isMethod('GET') && $Request->position_id > 1) {
            $UserWorkPosition = new UserWorkPosition();
            $UserWorkPositionData = $UserWorkPosition::find($Request->position_id);

            return Response::json(['status' => true, 'UserWorkPositionData' => $UserWorkPositionData]);
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxUserPositionActive(Request $Request) {
        if($Request->isMethod('POST') && !empty($Request->position_id) && $Request->position_id > 1) {
            $UserWorkPosition = new UserWorkPosition();
            $UserWorkPosition::find($Request->position_id)->update([
                'active' => $Request->position_active,
            ]);
            return Response::json(['status' => true]);
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxUserPositionDelete(Request $Request) {
        if($Request->isMethod('POST') && !empty($Request->position_id) && $Request->position_id > 1) {
            
            $UserWorkData = new UserWorkData();
            $UserWorkData::where('position_id', $Request->position_id)->update(['position_id' => 1]);

            $UserWorkPosition = new UserWorkPosition();
            $UserWorkPosition::find($Request->position_id)->update([
                'deleted_at' => Carbon::now(),
                'deleted_at_int' => 0,
                'active' => 0,
            ]);

            return Response::json(['status' => true, 'message' => 'პოზიცია წარმატებით წაიშალა !!!']);
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxUserRoleGet(Request $Request) {
        if($Request->isMethod('GET')) {

            $User = new User();
            $UserData = $User::find($Request->user_id);

            return Response::json(['status' => true, 'UserData' => $UserData]);

        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxUserRoleUpdate(Request $Request) {
        if($Request->isMethod('POST')) {
            $User = new User();
            $UserData = $User::find($Request->user_id)->update([
                'role_id' => $Request->role_id,
            ]);
        }
    }

    public function ajaxUserVacationDelete(Request $Request) {
        if($Request->isMethod('POST')) {
            $UserWorkVacation = new UserWorkVacation();
            $UserWorkVacation::find($Request->vacation_id)->update([
                'deleted_at' => Carbon::now(),
                'deleted_at_int' => 0,
            ]);

            return Response::json(['status' => true, 'message' => 'შვებულება წარმატებით წაიშალა !!!']);
        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxUserVacationView(Request $Request) {
        if($Request->isMethod('GET') && !empty($Request->vacation_id)) {
            $UserWorkVacation = new UserWorkVacation();
            $UserWorkVacationData = $UserWorkVacation::find($Request->vacation_id)->load(['createdBy', 'vacationUser', 'vacationType']);

            return Response::json(['status' => true, 'UserWorkVacationData' => $UserWorkVacationData]);

        } else {
            return Response::json(['status' => false, 'message' => 'დაფიქსირდა შეცდომა, გთხოვთ სცადოთ თავიდან !!!']);
        }
    }

    public function ajaxUserSalaryExport(Request $Request) {
        if($Request->isMethod('GET') && !empty($Request->user_id)) {

            $Date = $Request->salary_year.'-'.$Request->salary_month;
            $StartDate = Carbon::parse($Date)->startOfMonth();
            $EndDate = Carbon::parse($Date)->endOfMonth();

            return Excel::download(new UserSalaryExport($Request->user_id, $StartDate, $EndDate), 'ხელფასი.xlsx');

        } else {

        }
    }
}
