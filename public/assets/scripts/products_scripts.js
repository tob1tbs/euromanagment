function CategoryModal() {
	$("#category_modal").modal('show');
}

function CategorySubmit() {
    var form = $('#category_form')[0];
    var data = new FormData(form);

    $.ajax({
        dataType: 'json',
        url: "/products/ajax/categories/submit",
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
                } else {
                	Swal.fire({
	                    icon: 'success',
	                    text: data['message'],
	                    timer: 2000,
	                });
                    location.reload();
                }
            } else {
                NioApp.Toast(data['message'], 'error', {
                    position: 'top-right'
                });
            }
        }
    });
}

function CategoryActiveChange(category_id, elem) {
    if($(elem).is(":checked")) {
        category_active = 1;
    } else {
        category_active = 0
    }

    $.ajax({
        dataType: 'json',
        url: "/products/ajax/categories/active",
        type: "POST",
        data: {
            category_id: category_id,
            category_active: category_active,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            return;
        }
    });
}

function CategoryDelete(category_id) {
    Swal.fire({
        title: "ნამდვილად გსურთ კატეგორიის წაშლა?",
        text: "პროდუქცია რომელებთაც ააქვთ მინიჭებული აღნიშნული კატეგორია, ავტომატურად მიენიჭება კატეგორია (სისტემური კატეგორია) !!!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: 'წაშლა',
        cancelButtonText: "გათიშვა",
        preConfirm: () => {
            $.ajax({
                dataType: 'json',
                url: "/products/ajax/categories/delete",
                type: "POST",
                data: {
                    category_id: category_id,
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

function CategoryEdit(category_id) {
	$.ajax({
        dataType: 'json',
        url: "/products/ajax/categories/get",
        type: "GET",
        data: {
            category_id: category_id,
        },
        success: function(data) {
            if(data['status'] == true) {
                $('#category_form')[0].reset();
                $("#category_name").val(data['ProductCategoryData']['name']);
                $("#category_id").val(data['ProductCategoryData']['id']);
                $("#category_modal").modal('show');
            }
        }
    });
}

function VendorModal() {
	$("#vendor_modal").modal('show');
}

function VendorSubmit() {
    var form = $('#vendor_form')[0];
    var data = new FormData(form);

    $.ajax({
        dataType: 'json',
        url: "/products/ajax/vendors/submit",
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
                } else {
                	Swal.fire({
	                    icon: 'success',
	                    text: data['message'],
	                    timer: 2000,
	                });
                    location.reload();
                }
            } else {
                NioApp.Toast(data['message'], 'error', {
                    position: 'top-right'
                });
            }
        }
    });
}

function VendorActiveChange(vendor_id, elem) {
    if($(elem).is(":checked")) {
        vendor_active = 1;
    } else {
        vendor_active = 0
    }

    $.ajax({
        dataType: 'json',
        url: "/products/ajax/vendors/active",
        type: "POST",
        data: {
            vendor_id: vendor_id,
            vendor_active: vendor_active,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            return;
        }
    });
}

function VendorDelete(vendor_id) {
    Swal.fire({
        title: "ნამდვილად გსურთ მომწოდებლის წაშლა?",
        text: "პროდუქცია რომელებთაც ააქვთ მინიჭებული აღნიშნული მომწოდებელი, ავტომატურად მიენიჭება მომწოდებელი (მომწოდებლის გარეშე) !!!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: 'წაშლა',
        cancelButtonText: "გათიშვა",
        preConfirm: () => {
            $.ajax({
                dataType: 'json',
                url: "/products/ajax/vendors/delete",
                type: "POST",
                data: {
                    vendor_id: vendor_id,
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

function VendorEdit(vendor_id) {
	$.ajax({
        dataType: 'json',
        url: "/products/ajax/vendors/get",
        type: "GET",
        data: {
            vendor_id: vendor_id,
        },
        success: function(data) {
            if(data['status'] == true) {
                $('#vendor_form')[0].reset();
                $("#vendor_name").val(data['ProductVendorData']['name']);
                $("#vendor_code").val(data['ProductVendorData']['code']);
                $("#vendor_id").val(data['ProductVendorData']['id']);
                $("#vendor_modal").modal('show');
            }
        }
    });
}

function BrandModal() {
	$("#brand_modal").modal('show');
}

function BrandSubmit() {
    var form = $('#brand_form')[0];
    var data = new FormData(form);

    $.ajax({
        dataType: 'json',
        url: "/products/ajax/brands/submit",
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
                } else {
                	Swal.fire({
	                    icon: 'success',
	                    text: data['message'],
	                    timer: 2000,
	                });
                    location.reload();
                }
            } else {
                NioApp.Toast(data['message'], 'error', {
                    position: 'top-right'
                });
            }
        }
    });
}

function BrandActiveChange(brand_id, elem) {
    if($(elem).is(":checked")) {
        brand_active = 1;
    } else {
        brand_active = 0
    }

    $.ajax({
        dataType: 'json',
        url: "/products/ajax/brands/active",
        type: "POST",
        data: {
            brand_id: brand_id,
            brand_active: brand_active,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            return;
        }
    });
}

function BrandDelete(brand_id) {
    Swal.fire({
        title: "ნამდვილად გსურთ ბრენდის წაშლა?",
        text: "პროდუქცია რომელებთაც ააქვთ მინიჭებული აღნიშნული ბრენდი, ავტომატურად მიენიჭება ბრენდი (ბრენდი გარეშე) !!!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: 'წაშლა',
        cancelButtonText: "გათიშვა",
        preConfirm: () => {
            $.ajax({
                dataType: 'json',
                url: "/products/ajax/brands/delete",
                type: "POST",
                data: {
                    brand_id: brand_id,
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

function BrandEdit(brand_id) {
	$.ajax({
        dataType: 'json',
        url: "/products/ajax/brands/get",
        type: "GET",
        data: {
            brand_id: brand_id,
        },
        success: function(data) {
            if(data['status'] == true) {
                $('#brand_form')[0].reset();
                $("#brand_name").val(data['ProductBrandData']['name']);
                $("#brand_id").val(data['ProductBrandData']['id']);
                $("#brand_modal").modal('show');
            }
        }
    });
}