function BranchModal() {
	$(".branch-modal-title").html('ფილიალის / განყოფილების დამატება');
	$("#branch_modal").modal('show');
}

function BranchSubmit() {
	var form = $('#branch_form')[0];
    var data = new FormData(form);

    $.ajax({
        dataType: 'json',
        url: "/company/ajax/branch/submit",
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
                    $(".role-input").removeClass('border-danger');
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