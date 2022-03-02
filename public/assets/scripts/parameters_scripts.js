function GetPaymentParameters(payment_id) {
	$.ajax({
        dataType: 'json',
        url: "/parameters/ajax/payments/options",
        type: "GET",
        data: {
            payment_id: payment_id,
        },
        success: function(data) {
            if(data['status'] == true) {
            	parameter_data = JSON.parse(data['ParameterOptions'][0]['options']);
            	$(".payment-parameter-data").html('');
            	$.each(parameter_data, function(key, value) {
            		
            		if(value['secret'] == true) {
            			var secret = 'password';
            			var eye = `<a tabindex="-1" href="#" class="form-icon form-icon-right" data-target="`+key+`" onclick="HideTextSwitch(this)">
                                    <em class="passcode-icon icon-show icon ni ni-eye first-eye"></em>
                                </a>`;
            		} else {
            			var secret = 'text';
            			var eye = '';
            		}

            		if(value['disabled'] == true) {
            			var disabled = 'readonly';
            		} else {
            			var disabled = '';
            		}

                    $(".payment-parameter-data").append(`
                        <div class="col-lg-6 mb-2">
                            <div class="form-label-group">
                                <label class="form-label" for="`+key+`">`+value['label']+`</label>
                            </div>
                            <div class="form-control-wrap">
                                `+eye+`
                                <input type="`+secret+`" class="form-control form-control-lg" id="`+key+`" value="`+value['value']+`" `+disabled+` name="`+key+`">
                            </div>
                        </div>
                	`);
                })
             	$("#payment_parameters").modal('show');
            }
        }
    });
}

function PaymentActiveChange(payment_id, elem) {
	if($(elem).is(":checked")) {
        payment_active = 1;
    } else {
        payment_active = 0
    }

	$.ajax({
        dataType: 'json',
        url: "/parameters/ajax/payments/active",
        type: "POST",
        data: {
        	payment_id: payment_id,
        	payment_active: payment_active,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            return;
        }
    });
}

function HideTextSwitch(elem) {
	
	var target = $(elem).data("target");

	if($('#'+target).attr('type') == 'password') {
		$('#'+target).attr('type', 'text');
	} else {
		$('#'+target).attr('type', 'password');
	}
}

function PaymentParametersSubmit() {
	Swal.fire({
        title: "ნამდვილად გსურთ გადახდის პარამეტრების შეცვლა?",
        text: "გთხოვთ გაითვალისწინოთ, არასწორი პარამეტრების მითითების შემთხვევაში გადახდის მეთოდი არ იმუშავებს !!!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: 'შეცვლა',
        cancelButtonText: "გათიშვა",
        preConfirm: () => {
            var form = $('#payment_parameters_form')[0];
		    var data = new FormData(form);

		    $.ajax({
		        dataType: 'json',
		        url: "/parameters/ajax/payments/submit",
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
		                $("#payment_parameters").modal('hide');
		            }
		        }
		    });
        }
    });
}

function ChangeTranslate(translate_id) {
	$.ajax({
        dataType: 'json',
        url: "/parameters/ajax/translate/update",
        type: "POST",
        data: {
        	translate_id: translate_id,
        	translate_ge: $("#translate_ge_"+translate_id).val(),
        	translate_en: $("#translate_en_"+translate_id).val(),
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            return;
        }
    });
}

function TranslateAdd() {
	$("#translate_add").modal('show');
}

function TranslateParametersSubmit() {
	var form = $('#translate_add_form')[0];
    var data = new FormData(form);

    $.ajax({
        dataType: 'json',
        url: "/parameters/ajax/translate/add",
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
                    $(".translate-input").removeClass('border-danger');
                    $(".text-error").html('');
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
                    location.reload();
                }
            }
        }
    });
}
function BasicParametersSubmit() {
    var form = $('#basic_parameters_form')[0];
    var data = new FormData(form);

    $.ajax({
        dataType: 'json',
        url: "/parameters/ajax/translate/add",
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
                    $(".translate-input").removeClass('border-danger');
                    $(".text-error").html('');
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
                    location.reload();
                }
            }
        }
    });
}