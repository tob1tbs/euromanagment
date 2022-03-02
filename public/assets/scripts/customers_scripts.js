$("#customer_type").change(function(){
	if($("#customer_type").val() == 1) {
		$(".company-data").hide();
	} else {
		$(".company-data").show();
	}
});

function CustomerSubmit() {
	var form = $('#customer_form')[0];
    var data = new FormData(form);

    $.ajax({
        dataType: 'json',
        url: "/customers/ajax/submit",
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
                    $(".customer-input").removeClass('border-danger');
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
                    window.location.replace(data['redirect']);
                }
            }
        }
    });
}

function CustomersActiveChange(customer_id, elem) {
	if($(elem).is(":checked")) {
        customer_active = 1;
    } else {
        customer_active = 0
    }

	$.ajax({
        dataType: 'json',
        url: "/customers/ajax/active",
        type: "POST",
        data: {
        	customer_id: customer_id,
        	customer_active: customer_active,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            return;
        }
    });
}

function CompanyActiveChange(company_id, elem) {
    if($(elem).is(":checked")) {
        company_active = 1;
    } else {
        company_active = 0
    }

    $.ajax({
        dataType: 'json',
        url: "/customers/ajax/company/active",
        type: "POST",
        data: {
            company_id: company_id,
            company_active: company_active,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            return;
        }
    });
}