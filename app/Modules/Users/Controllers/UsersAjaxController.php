<?php

namespace App\Modules\Users\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Modules\Users\Models\UserRole;
use App\Modules\Users\Models\UserPermission;
use App\Modules\Users\Models\UserPermissionGroup;
use App\Modules\Users\Models\UserRoleHasPermission;

use Validator;
use Response;
use \Carbon\Carbon;

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
}
