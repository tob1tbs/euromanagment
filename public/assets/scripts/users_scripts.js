function UserRoleAdd() {
	$(".role-modal-title").html('ახალი წვდომის ჯგუფი');
	$("#role_modal").modal('show');
}

function UserRoleSubmit() {
	var form = $('#role_form')[0];
    var data = new FormData(form);

    $.ajax({
        dataType: 'json',
        url: "/users/ajax/role/submit",
        type: "POST",
        data: data,
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        cache: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            if(data['status'] == true) {
                if(data['errors'] == true) {
                    $(".branch-input").removeClass('border-danger');
                    $(".error-text").html('');
                    $.each(data['message'], function(key, value) {
                        $('#'+key).addClass('border-danger');
                        $('.error-'+key).html(value);
                    })
                } else {
                    Swal.fire({
                        icon: 'success',
                        text: data['message'],
                        timer: 2000,
                    });
                    location.reload()
                }
            } else {
                Swal.fire({
                  icon: 'error',
                  text: data['message'],
                })
            }
        }
    });
}

function UserRoleActiveChange(role_id, elem) {
	if($(elem).is(":checked")) {
        role_active = 1;
    } else {
        role_active = 0
    }

	$.ajax({
        dataType: 'json',
        url: "/users/ajax/role/active",
        type: "POST",
        data: {
        	role_id: role_id,
        	role_active: role_active,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            return;
        }
    });
}

function UserRoleDelete(role_id) {
	Swal.fire({
        title: "ნამდვილად გსურთ ჯგუფის წაშლა?",
        text: "მომხმარებლები რომელებთაც ააქვთ მინიჭებული აღნიშნული ჯგუფი, ავტომატურად გადავლენ ჯგუფ მოხმარებლებში !!!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: 'წაშლა',
        cancelButtonText: "გათიშვა",
        preConfirm: () => {
            $.ajax({
                dataType: 'json',
                url: "/users/ajax/role/delete",
                type: "POST",
                data: {
                    role_id: role_id,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    Swal.fire({
                      icon: 'success',
                      text: data['message'],
                    })
                    location.reload();
                }
            });
        }
    });
}

function UserRoleEdit(role_id) {
    $.ajax({
        dataType: 'json',
        url: "/users/ajax/role/edit",
        type: "GET",
        data: {
            role_id: role_id,
        },
        success: function(data) {
            if(data['status'] == true) {
             	$('#role_form').trigger("reset");
                $.each(data['UserRoleData'], function(key, value){
                    $("#role_"+key).val(value);
                    $(".role-modal-title").html('წვდომის ჯგუფის რედაქტირება');
                    $("#role_modal").modal('show');
                });
            }
        }
    });
}

function UserRolePermissions(role_id) {
	$.ajax({
        dataType: 'json',
        url: "/users/ajax/role/permission",
        type: "GET",
        data: {
            role_id: role_id,
        },
        success: function(data) {
            if(data['status'] == true) {
                $(".permission-list").html('');
                if(Object.keys(data['PermissionGroupArray']).length > 0) {
                	view = ``;
	                $.each(data['PermissionGroupArray']['group_data'], function(key, value){
	                    view += `
	                    <div class="col-lg-3 col-sm-12 mb-3">
	                        <div class="font-neue">`+value['group_name']+`</div>
	                        <div class="row">
	                        `;
	                        $.each(value['permissions']['list'], function(permission_key, permission_value){
	                            view += `
	                            <div class="col-lg-12 permission-item-`+permission_value['id']+`">
	                                <div class="float-left">
	                                <div class="custom-control custom-control-sm custom-checkbox">
	                                    <input type="checkbox" class="custom-control-input" name="permissions[]" id="permission_`+permission_value['id']+`" value="`+permission_value['id']+`">
	                                    <label class="custom-control-label font-neue" for="permission_`+permission_value['id']+`">`+permission_value['title']+`</label>
	                                </div>
	                                </div>
	                                <div class="float-right">
	                                	<span onclick="UserRolePermissionDelete(`+permission_value['id']+`, `+role_id+`)"><em class="icon ni ni-delete-fill" style="font-size: 24px; color: #e36262; cursor: pointer"></em></span>
	                                </div>
	                            </div>
	                            `;
	                        });
	                    view += `</div></div>`;
	                });
	                $(".permission-list").append(view);
	                $.each(data['PermissionGroupArray']['group_data'], function(key, value){
	                    $.each(value['permissions']['list'], function(permission_key, permission_value){
	                        $.each(value['permissions']['selected'], function(selected_key, selected_value){
	                            if(permission_value['id'] == selected_value['permission_id']) {
	                                $("#permission_"+selected_value['permission_id']).prop('checked', true);
	                            }
	                        });
	                    });
	                });
	                $(".permission-submit-button").css('display', 'block');
                } else {
                	$(".permission-list").html(`
                		<div class="col-12 mb-3">
	                		<div class="alert alert-fill alert-warning alert-icon font-helvetica-regular">
	                            <em class="icon ni ni-alert-circle"></em> აღნიშნულ ჯგუფს არააქვს უფლებები
	                        </div>
                        </div>
            		`);
                	$(".permission-submit-button").css('display', 'none');
                }
                $("#permission_role").val(role_id);
                $("#permission_role_id").val(role_id);
                $("#permission_modal").modal('show');
            }
        }
    });
}

function AddPermissionSubmit() {
	var form = $('#permission_add_form')[0];
    var data = new FormData(form);

    $.ajax({
        dataType: 'json',
        url: "/users/ajax/role/permission/submit",
        type: "POST",
        data: data,
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        cache: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            if(data['status'] == true) {
            	if(data['errors'] == true) {
            		$(".permission-input").removeClass('border-danger');
                    $(".error-text").html('');
                    $.each(data['message'], function(key, value) {
                        $('#'+key).addClass('border-danger');
                        $('.error-'+key).html(value);
                    })
            	} else {
            		$(".permission-list").html('');
        			view = ``;
	                $.each(data['PermissionGroupArray']['group_data'], function(key, value){
	                    view += `
	                    <div class="col-lg-3 col-sm-12 mb-3">
	                        <div class="font-neue">`+value['group_name']+`</div>
	                        <div class="row">
	                        `;
	                        $.each(value['permissions']['list'], function(permission_key, permission_value){
	                            view += `
	                            <div class="col-lg-12 permission-item-`+permission_value['id']+`">
	                                <div class="float-left">
	                                <div class="custom-control custom-control-sm custom-checkbox">
	                                    <input type="checkbox" class="custom-control-input" name="permissions[]" id="permission_`+permission_value['id']+`" value="`+permission_value['id']+`">
	                                    <label class="custom-control-label font-neue" for="permission_`+permission_value['id']+`">`+permission_value['title']+`</label>
	                                </div>
	                                </div>
	                                <div class="float-right">
	                                	<span onclick="UserRolePermissionDelete(`+permission_value['id']+`, `+$("#permission_role_id").val()+`)"><em class="icon ni ni-delete-fill" style="font-size: 24px; color: #e36262; cursor: pointer"></em></span>
	                                </div>
	                            </div>
	                            `;
	                        });
	                    view += `</div></div>`;
	                });
	                $(".permission-list").append(view);
	                $.each(data['PermissionGroupArray']['group_data'], function(key, value){
	                    $.each(value['permissions']['list'], function(permission_key, permission_value){
	                        $.each(value['permissions']['selected'], function(selected_key, selected_value){
	                            if(permission_value['id'] == selected_value['permission_id']) {
	                                $("#permission_"+selected_value['permission_id']).prop('checked', true);
	                            }
	                        });
	                    });
	                });
	                $(".permission-submit-button").css('display', 'block');
            	}
            }
        }
    });
}

function SyncPermissionSubmit() {
	var form = $('#permission_form')[0];
    var data = new FormData(form);

    $.ajax({
        dataType: 'json',
        url: "/users/ajax/role/permission/sync",
        type: "POST",
        data: data,
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        cache: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            if(data['status'] == true) {
                Swal.fire({
                    icon: 'success',
                    text: data['message'],
                    timer: 1500,
                    timerProgressBar: true,
                })
                $("#PermissionModal").modal('hide');
            } else {
                Swal.fire({
                  icon: 'error',
                  text: data['message'],
                })
            }
        }
    });
}

function UserRolePermissionDelete(permission_id, role_id) {
	Swal.fire({
        title: "ნამდვილად გსურთ უფლების წაშლა?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: 'წაშლა',
        cancelButtonText: "გათიშვა",
        preConfirm: () => {
            $.ajax({
                dataType: 'json',
                url: "/users/ajax/role/permission/delete",
                type: "POST",
                data: {
                    permission_id: permission_id,
                    role_id: role_id,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    Swal.fire({
                      	icon: 'success',
                      	text: data['message'],
                      	timer: 1500,
                		timerProgressBar: true,
                    })
                    $(".permission-item-"+permission_id).remove();
                }
            });
        }
    });
}

function addUserWorkModal() {
    $('#add_user_work_modal')[0].reset();
    $("#addUserWorkModal").modal('show');
}

function addUserWorkSubmit() {
    var form = $('#add_user_work_modal')[0];
    var data = new FormData(form);

    $.ajax({
        dataType: 'json',
        url: "/users/ajax/work/add",
        type: "POST",
        data: data,
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        cache: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            if(data['status'] == true) {
                if(data['errors'] == true) {
                    $.each(data['message'], function(key, value) {
                        NioApp.Toast(value, 'error', {
                            position: 'top-right'
                        });
                    })
                } else {
                    NioApp.Toast(data['message'], 'success', {
                        position: 'top-right'
                    });
                    $("#addUserWorkModal").modal('hide');
                    location.reload();
                }
            } else {
                Swal.fire({
                  icon: 'error',
                  text: data['message'],
                })
            }
        }
    });
}

function DeleteUserWork() {
    Swal.fire({
        title: "ნამდვილად გსურთ თანამშრომლის განრიგიდან წაშლა?",
        text: "თუ თანამშრომელს აღნიშნულ დღეს ერიცხება ხელფასი, ხელფასი წაიშლება !!!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: 'წაშლა',
        cancelButtonText: "გათიშვა",
        preConfirm: () => {
            $.ajax({
                dataType: 'json',
                url: "/users/ajax/work/delete",
                type: "POST",
                data: {
                    work_id: $("#view_work_id").val(),
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if(data['status'] == true) {
                        NioApp.Toast(data['message'], 'success', {
                            position: 'top-right'
                        });
                        $("#viewUserWorkModal").modal('hide');
                        location.reload();
                    } else {
                        Swal.fire({
                          icon: 'error',
                          text: data['message'],
                        })
                    }
                }
            });
        }
    });
}

function AddUserSalary(user_id, position_id, date) {
    $('#add_user_salary_form')[0].reset();
    $("#salary_user_id").val(user_id);
    $("#salary_position").val(position_id);
    $("#salary_date").val(date);
    $("#userAddSalary").modal('show');
}

function AddSalarySubmit() {
    var form = $('#add_user_salary_form')[0];
    var data = new FormData(form);

    $.ajax({
        dataType: 'json',
        url: "/users/ajax/salary/submit",
        type: "POST",
        data: data,
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        cache: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            if(data['status'] == true) {
                if(data['errors'] == true) {
                    NioApp.Toast(data['message'], 'error', {
                        position: 'top-right'
                    });
                } else {
                    NioApp.Toast(data['message'], 'success', {
                        position: 'top-right'
                    });
                    $(".cell-item-"+data['day']+"-"+data['user_id']).html(data['total']).addClass('table-cell');
                    $('#add_user_salary_form')[0].reset();
                    $("#userAddSalary").modal('hide');
                }
            }
        }
    });
}

function ViewUserSalary(salary_id) {
    $.ajax({
        dataType: 'json',
        url: "/users/ajax/salary/view",
        type: "GET",
        data: {
            salary_id: salary_id,
        },
        success: function(data) {
            if(data['status'] == true) {
                $("#view_salary_id").val(data['UserWorkSalaryData']['id']);
                $(".view_salary_user").html(data['UserWorkSalaryData']['salary_user']['name']+' '+data['UserWorkSalaryData']['salary_user']['lastname']);
                $(".view_salary_date").html(data['UserWorkSalaryData']['date']);
                $(".view_salary").html(data['UserWorkSalaryData']['salary']);
                $(".view_salary_bonus").html(data['UserWorkSalaryData']['bonus']);
                $(".view_salary_fine").html(data['UserWorkSalaryData']['fine']);
                $(".view_salary_comment").html(data['UserWorkSalaryData']['comment']);
                $(".view_salary_creator").html(data['UserWorkSalaryData']['salary_creator']['name']+' '+data['UserWorkSalaryData']['salary_creator']['lastname']);
                $("#userViewSalary").modal('show');
            }
        }
    });
}

function DeleteUserSalary() {
    Swal.fire({
        title: "ნამდვილად გსურთ ხელფასის წაშლა?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: 'წაშლა',
        cancelButtonText: "გათიშვა",
        preConfirm: () => {
            $.ajax({
                dataType: 'json',
                url: "/users/ajax/salary/delete",
                type: "POST",
                data: {
                    salary_id: $("#view_salary_id").val(),
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if(data['status'] == true) {
                        location.reload();
                    }
                }
            });
        }
    });
}

function UserNotWorking() {
    NioApp.Toast('აღნიშნულ თარიღში თანამშრომელი არ მუშაობდა', 'error', {
        position: 'top-right'
    });
}

function AddVacationModal() {
    $("#AddVacationModal").modal('show');
}

function UserVacationValidate() {
    var form = $('#add_user_vacation_form')[0];
    var data = new FormData(form);

    $.ajax({
        dataType: 'json',
        url: "/users/ajax/vacation/validate",
        type: "POST",
        data: data,
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        cache: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            if(data['status'] == true) {
                if(data['errors'] == true) {
                    $.each(data['message'], function(key, value) {
                        NioApp.Toast(value, 'error', {
                            position: 'top-right'
                        });
                    })
                } else {
                    if(data['skip'] == false) {
                        NioApp.Toast(data['message'], 'error', {
                            position: 'top-right'
                        });
                    } else {
                        Swal.fire({
                            title: "ნამდვილად გსურთ შვებულების დამატება?",
                            text: data['message'],
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonText: 'დამატება',
                            cancelButtonText: "გათიშვა",
                            preConfirm: () => {
                                var form = $('#add_user_vacation_form')[0];
                                var data = new FormData(form);

                                $.ajax({
                                    dataType: 'json',
                                    url: "/users/ajax/vacation/submit",
                                    type: "POST",
                                    data: data,
                                    enctype: 'multipart/form-data',
                                    processData: false,
                                    contentType: false,
                                    cache: false,
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    success: function(data) {
                                        if(data['status'] == true) {
                                            Swal.fire({
                                                icon: 'success',
                                                text: data['message'],
                                                timer: 2000,
                                            });
                                            location.reload()
                                        }
                                    }
                                });
                            }
                        });
                    }
                }
            }
        }
    });
}

function UserSubmit() {
    var form = $('#user_form')[0];
    var data = new FormData(form);

    $.ajax({
        dataType: 'json',
        url: "/users/ajax/submit",
        type: "POST",
        data: data,
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        cache: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            if(data['status'] == true) {
                if(data['errors'] == true) {
                    $.each(data['message'], function(key, value) {
                        $(".error-input").removeClass('border-danger');
                        $.each(data['message'], function(key, value) {
                            $('#'+key).addClass('border-danger');
                            NioApp.Toast(value, 'error', {
                                position: 'top-right'
                            });
                        })
                    });
                }
            } else {
                
            }
        }
    });
}

function GetDepartamentList() {
    $.ajax({
        dataType: 'json',
        url: "/users/ajax/get/departament",
        type: "GET",
        data: {
            branch_id: $("#user_position_branch").val(),
        },
        success: function(data) {
            if(data['status'] == true) {
                $("#user_position_departament").html('');
                if(data['BranchList'].length > 0) {
                    $.each(data['BranchList'], function(key, value) {
                        $("#user_position_departament").append(`<option value="`+value['id']+`">`+value['name']+`</option>`);
                    });
                    $("#user_position_departament").removeAttr('disabled');
                } else {
                    $("#user_position_departament").append(`<option value="0">გთხოვთ აირჩიოთ ფილიალი</option>`);
                    $("#user_position_departament").attr('disabled', 'disabled');
                }
            } else {
                $("#user_position_departament").html('');
                $("#user_position_departament").append(`<option value="0">გთხოვთ აირჩიოთ ფილიალი</option>`);
                $("#user_position_departament").attr('disabled', 'disabled');
            }
        }
    });
}

function WorkPositionAdd() {
    checkPosition = () => {

        if ($("#user_position").val() == 0) {
           $("#user_position").addClass('border border-danger');
            positionValid = false;
            return;
        } else {
            $("#user_position").removeClass('border border-danger');
            positionValid = true;
        }

        if ($("#user_position_branch").val() == 0) {
            $("#user_position_branch").addClass('border border-danger');
            positionValid = false;
            return;
        } else {
            $("#user_position_branch").removeClass('border border-danger');
            positionValid = true;
        }

        if ($("#user_position_departament").val() == 0) {
           $("#user_position_departament").addClass('border border-danger');
            positionValid = false;
            return;
        } else {
            $("#user_position_departament").removeClass('border border-danger');
            positionValid = true;
        }

        if ($("#user_position_salary_type").val() == 0) {
           $("#user_position_salary_type").addClass('border border-danger');
            positionValid = false;
            return;
        } else {
            $("#user_position_salary_type").removeClass('border border-danger');
            positionValid = true;
        }

        if ($("#user_salary").val() == "") {
           $("#user_salary").addClass('border border-danger');
            positionValid = false;
            return;
        } else {
            $("#user_salary").removeClass('border border-danger');
            positionValid = true;
        }

        return positionValid;
    };

    positionValid = checkPosition();

    if(positionValid) {

        $(".user_work_position").append(`
            <tr class="font-helvetica-regular">
                <td class="px-2">`+$('#user_position option:selected').html()+`</td>
                <td>`+$('#user_position_branch option:selected').html()+` / `+$('#user_position_departament option:selected').html()+`</td>
                <td>`+$('#user_position_salary_type option:selected').html()+` / `+$('#user_salary').val()+`</td>
                <td>
                    <span class="font-helvetica-regular" onclick="RemoveWorkPosition(this)" style="cursor: pointer;">პოზიცის წაშლა</span>
                </td>
                <input type="hidden" name="position[]" value="`+$("#user_position").val()+`">
                <input type="hidden" name="branch[]" value="`+$("#user_position_branch").val()+`">
                <input type="hidden" name="departament[]" value="`+$("#user_position_departament").val()+`">
                <input type="hidden" name="salary_type[]" value="`+$("#user_position_salary_type").val()+`">
                <input type="hidden" name="salary[]" value="`+$("#user_salary").val()+`">
            </tr>
        `);
    }
}

function RemoveWorkPosition(elem) {
    $(elem).parents('tr').remove();
}

function UserLogin() {
    var form = $('#user_login_form')[0];
    var data = new FormData(form);

    $.ajax({
        dataType: 'json',
        url: "/users/ajax/login/submit",
        type: "POST",
        data: data,
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        cache: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            if(data['status'] == true) {
                if(data['errors'] == true) {
                    $.each(data['message'], function(key, value) {
                        NioApp.Toast(value, 'error');
                    })
                } else {
                    window.location.replace(data['redirect_url']);
                }
            } else {
                NioApp.Toast(data['message'], 'error');
            }
        }
    });
}

function ViewDetailSalary(user_id, position_id) {
    $.ajax({
        dataType: 'json',
        url: "/users/ajax/salary/detail",
        type: "GET",
        data: {
            user_id: user_id,
            position_id: position_id,
            salary_year: $("#salary_year").val(),
            salary_month: $("#salary_month").val(),
        },
        success: function(data) {
            if(data['status'] == true) {
                $(".user-salary-list, .user_salary-total").html('');
                var total_sum = data['sum'] + data['month_salary'];
                $.each(data['UserWorkSalaryList'], function(key, value) {
                    var total = value['salary'] + value['bonus'] - value['fine'];

                    $(".user-salary-list").append(`
                        <tr class="text-center">
                          <td class="text-center">`+value['date']+`</td>
                          <td class="text-center">`+value['salary']+` ₾</td>
                          <td class="text-center">`+value['bonus']+` ₾</td>
                          <td class="text-center">`+value['fine']+` ₾</td>
                          <td class="text-left">`+value['comment']+` ₾</td>
                          <td class="text-right">`+total+`₾ </td>
                        </tr>
                    `);
                });
                $(".user_salary-total").append(`
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>ფიქსირებული: `+data['month_salary']+` ₾ <br>გამომუშავებული: `+data['sum']+` ₾ <br>ჯამი: `+total_sum+` ₾ <br></td>
                `);
                $("#salary_view_user_id").val(data['user_id']);
                $("#userViewDetailSalary").modal('show');
            }
        }
    });
}

function AddPositionModal() {
    $(".position-modal-title").html('ახალი პოზიციის დამატება');
    $('#position_form')[0].reset();
    $("#position_modal").modal('show');
}

function PositionSubmit() {
    var form = $('#position_form')[0];
    var data = new FormData(form);

    $.ajax({
        dataType: 'json',
        url: "/users/ajax/position/submit",
        type: "POST",
        data: data,
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        cache: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            if(data['status'] == true) {
                if(data['errors'] == true) {
                    $(".error-input").removeClass('border-danger');
                    $.each(data['message'], function(key, value) {
                        $('#'+key).addClass('border-danger');
                        NioApp.Toast(value, 'error', {
                            position: 'top-right'
                        });
                    })
                } else {
                    Swal.fire({
                        icon: 'success',
                        text: data['message'],
                        timer: 2000,
                    });
                    location.reload();
                }
            } else {
                NioApp.Toast(data['message'], 'error');
            }
        }
    });
}

function PositionEdit(position_id) {
    $.ajax({
        dataType: 'json',
        url: "/users/ajax/position/edit",
        type: "GET",
        data: {
            position_id: position_id,
        },
        success: function(data) {
            if(data['status'] == true) {
                $(".position-modal-title").html('პოზიციის რედაქტირება');
                $('#position_form')[0].reset();
                $("#position_name").val(data['UserWorkPositionData']['name']);
                $("#position_id").val(data['UserWorkPositionData']['id']);
                $("#position_modal").modal('show');
            }
        }
    });
}

function PositionActiveChange(position_id, elem) {
    if($(elem).is(":checked")) {
        position_active = 1;
    } else {
        position_active = 0
    }

    $.ajax({
        dataType: 'json',
        url: "/users/ajax/position/active",
        type: "POST",
        data: {
            position_id: position_id,
            position_active: position_active,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            return;
        }
    });
}

function PositionDelete(position_id) {
    Swal.fire({
        title: "ნამდვილად გსურთ პოზიციის წაშლა?",
        text: "მომხმარებლები რომელებთაც ააქვთ მინიჭებული აღნიშნული პოზიცია, ავტომატურად მიენიჭება პოზიცია (პოზიციის გარეშე) !!!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: 'წაშლა',
        cancelButtonText: "გათიშვა",
        preConfirm: () => {
            $.ajax({
                dataType: 'json',
                url: "/users/ajax/position/delete",
                type: "POST",
                data: {
                    position_id: position_id,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    Swal.fire({
                      icon: 'success',
                      text: data['message'],
                    })
                    location.reload();
                }
            });
        }
    });
}

function UserPermissionData(user_id) {
    $.ajax({
        dataType: 'json',
        url: "/users/ajax/role/get",
        type: "GET",
        data: {
            user_id: user_id,
        },
        success: function(data) {
            if(data['status'] == true) {
                $('#role_form')[0].reset();
                $('#update_role_id option[value="'+data['UserData']['role_id']+'"]').attr('selected','selected');
                $("#role_user_id").val(data['UserData']['id']);
                $("#role_modal").modal('show');
            }
        }
    });
}

function UpdateRoleSubmit() {
    Swal.fire({
        title: "ნამდვილად გსურთ ჯგუფის წაშლა?",
        text: "მომხმარებლები რომელებთაც ააქვთ მინიჭებული აღნიშნული ჯგუფი, ავტომატურად გადავლენ ჯგუფ მოხმარებლებში !!!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: 'წაშლა',
        cancelButtonText: "გათიშვა",
        preConfirm: () => {
            $.ajax({
                dataType: 'json',
                url: "/users/ajax/role/update",
                type: "POST",
                data: {
                    role_id: $("#update_role_id").val(),
                    user_id: $("#role_user_id").val(),
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                   
                }
            });
        }
    });
}

function DeleteVacation() {
    Swal.fire({
        title: "ნამდვილად გსურთ შვებულების წაშლა?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: 'წაშლა',
        cancelButtonText: "გათიშვა",
        preConfirm: () => {
            $.ajax({
                dataType: 'json',
                url: "/users/ajax/vacation/delete",
                type: "POST",
                data: {
                    vacation_id: $("#view_vacation_id").val(),
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if(data['status'] == true) {
                        location.reload();
                    }
                }
            });
        }
    });
}

function ViewVacation(vacation_id) {
    $.ajax({
        dataType: 'json',
        url: "/users/ajax/vacation/view",
        type: "GET",
        data: {
            vacation_id: vacation_id,
        },
        success: function(data) {
            if(data['status'] == true) {
                $("#view_vacation_id").val(data['UserWorkVacationData']['id']);
                $(".vacation_user").html(data['UserWorkVacationData']['vacation_user']['name']+' '+data['UserWorkVacationData']['vacation_user']['lastname']);
                $(".vacation_from").html(data['UserWorkVacationData']['date_from']);
                $(".vacation_to").html(data['UserWorkVacationData']['date_to']);
                $(".vacation_days").html(data['UserWorkVacationData']['days_count']);
                $(".vacation_type").html(data['UserWorkVacationData']['vacation_type']['name']);
                $(".created_by").html(data['UserWorkVacationData']['created_by']['name']+' '+data['UserWorkVacationData']['created_by']['lastname']);
                $("#UserVacationViewModal").modal('show');
            }
        }
    });
}

function ExportUserSalary() {
    $.ajax({
        xhrFields: {
            responseType: 'blob',
        },
        url: "/users/ajax/salary/export",
        type: "GET",
        data: {
            user_id: $("#salary_view_user_id").val(),
            salary_year: $("#salary_year").val(),
            salary_month: $("#salary_month").val(),
        },
        success: function(result, status, xhr) {
            var disposition = xhr.getResponseHeader('content-disposition');
            var matches = /"([^"]*)"/.exec(disposition);
            var blob = new Blob([result], {
                type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            });
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = 'balance.xlsx';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    });
}