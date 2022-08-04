function GetCustomerType() {
	$.ajax({
        dataType: 'json',
        url: "/customers/ajax/get/fields",
        type: "GET",
        data: {
            customer_type_id: $("#customer_type").val(),
        },
        success: function(data) {
            if(data['status'] == true) {
                $(".step-2, .step-3").html('');
                if(data['customer_type_id'] == 1) {
                    html = '';
                    $.each(data['customer_fields'], function(key, value) {
                        switch(value['type']) {
                            case 'text':
                                html += `
                                    <div class="col-lg-6 mb-2">
                                        <div class="form-group">
                                            <label class="form-label font-helvetica-regular" for="`+value['name']+`">`+value['label']+`</label>
                                            <div class="form-control-wrap">
                                                <input type="text" name="`+value['name']+`" id="`+value['name']+`" class="form-control check-input">
                                            </div>
                                        </div>
                                    </div>
                                `;
                            break;
                            case 'select':
                                if(value['name'] == 'customer_referal') {
                                    html += `
                                        <div class="col-lg-6 mb-2">
                                            <div class="form-group">
                                                <label class="form-label font-helvetica-regular" for="`+value['name']+`">`+value['label']+`</label>
                                                <div class="form-control-wrap">
                                                    <select class="form-select form-control form-control-lg font-helvetica-regular" data-search="on" id="`+value['name']+`" name="`+value['name']+`">
                                                    <option value="0">-</option>`
                                                    $.each(data['ReferalList'], function(key, value) {
                                                        html += `<option value=`+value['id']+`>`+value['name']+` `+value['lastname']+` (`+value['personal_id']+`)</option>`;
                                                    });
                                                    html += `</select>
                                                </div>
                                            </div>
                                        </div>
                                    `;
                                }
                            break;
                        }
                    });
                    $(".step-2").append(html);
                    $("#customer_referal").select2();
                }

                if(data['customer_type_id'] == 2) {
                    html = `<div class="col-lg-12 mb-2">
                                <div class="form-group">
                                    <label class="form-label font-helvetica-regular" for="customer_type_legal">`+data['customer_fields']['label']+`</label>
                                    <div class="form-control-wrap">
                                        <select class="form-control check-input" name="customer_type_legal" id="customer_type_legal" onchange="GetCustomerLegalFields()">
                                            <option value="0"></option>`;
                                            $.each(data['customer_fields']['values'], function(key, value) {
                                                html += `<option value="`+key+`">`+value+`</option>`;
                                            });
                                            html += `
                                        </select>
                                    </div>
                                </div>
                            </div>
                        `;
                    $(".step-2").append(html);
                }
            }
        }
    });
}

function GetCustomerLegalFields() {
    $.ajax({
        dataType: 'json',
        url: "/customers/ajax/get/fields/legal",
        type: "GET",
        data: {
            customer_type_id: $("#customer_type").val(),
            customer_type_legal_id: $("#customer_type_legal").val(),
        },
        success: function(data) {
            if(data['status'] == true) {
                $(".step-3").html('');
                $.each(data['customer_fields'], function(key, value) {
                    $(".step-3").append(`
                        <div class="col-lg-6 mb-2">
                            <div class="form-group">
                                <label class="form-label font-helvetica-regular" for="`+value['name']+`">`+value['label']+`</label>
                                <div class="form-control-wrap">
                                    <input type="text" name="`+value['name']+`" id="`+value['name']+`" class="form-control check-input">
                                </div>
                            </div>
                        </div>
                    `);
                });
            }
        }
    });
}

function CustomerSubmit() {
    var form = $('#product_form')[0];
    var data = new FormData(form);

    $.ajax({
        dataType: 'json',
        url: "/customers/ajax/submit/",
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
                    $(".check-input").removeClass('border-danger');
                    $.each(data['message'], function(key, value) {
                        $("#"+key).addClass('border-danger');
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
                    window.location.replace(data['redirect_url']);
                }
            } else {
                
            }
        }
    });
}

function PayMoney(item_id) {
    Swal.fire({
        title: "ნამდვილად გსურთ თანხის დარიცხვა",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: 'დარიცხვა',
        cancelButtonText: "გათიშვა",
        preConfirm: () => {
            $.ajax({
                dataType: 'json',
                url: "/customers/ajax/referal/pay",
                type: "POST",
                data: {
                    item_id: item_id,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if(data['status'] == true) {
                        Swal.fire({
                            icon: 'success',
                            text: data['message'][0],
                            timer: 2000,
                        });
                        location.reload();
                    }
                }
            });
        }
    });
}
function RemovePayMoney(item_id) {
    Swal.fire({
        title: "ნამდვილად გსურთ დარიცხვის წაშლა",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: 'წაშლა',
        cancelButtonText: "გათიშვა",
        preConfirm: () => {
            $.ajax({
                dataType: 'json',
                url: "/customers/ajax/referal/pay/delete",
                type: "POST",
                data: {
                    item_id: item_id,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if(data['status'] == true) {
                        Swal.fire({
                            icon: 'success',
                            text: data['message'][0],
                            timer: 2000,
                        });
                        location.reload();
                    }
                }
            });
        }
    });
}