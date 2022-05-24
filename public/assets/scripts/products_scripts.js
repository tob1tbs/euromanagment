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

function GetWarehouseList() {
	$.ajax({
        dataType: 'json',
        url: "/products/ajax/warehouse/get",
        type: "GET",
        data: {
            branch_id: $("#product_branch").val(),
        },
        success: function(data) {
            if(data['status'] == true) {
                $("#product_warehouse").html('');
                
                if(data['WarehouseList'].length > 0) {
                    $.each(data['WarehouseList'], function(key, value) {
                        $("#product_warehouse").append(
                            `<option value="`+value['id']+`">`+value['name']+`</option>`
                        );
                    });
                    $("#product_warehouse").attr('disabled', false);
                } else {
                    $("#product_warehouse").attr('disabled', true);
                }
            }
        }
    });
}

function ProductSubmit() {
    var form = $('#product_form')[0];
    var data = new FormData(form);

    $.ajax({
        dataType: 'json',
        url: "/products/ajax/submit",
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
                    window.location.replace(data['redirect_url']);
                }
            } else {
                NioApp.Toast(data['message'], 'error', {
                    position: 'top-right'
                });
            }
        }
    });
}

function UpdateProductCount(product_id, elem) {
    $.ajax({
        dataType: 'json',
        url: "/products/ajax/count",
        type: "GET",
        data: {
            product_id: product_id,
        },
        success: function(data) {
            if(data['status'] == true) {
                $('#product_count_form')[0].reset();
                $("#product_count").val(data['ProductData']['count']);
                $("#product_count_id").val(data['ProductData']['id']);
                $("#CountUploadModal").modal('show');
            }
        }
    });
}

function ProductCountSubmit() {
    var form = $('#product_count_form')[0];
    var data = new FormData(form);

    $.ajax({
        dataType: 'json',
        url: "/products/ajax/count/submit",
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
                    $(".text-error").html('');
                    $.each(data['message'], function(key, value) {
                        $("#"+key).addClass('border-danger');
                        $("."+key+"-error").html(value);
                    });
                } else {
                    Swal.fire({
                      icon: 'success',
                      text: data['message'],
                    })
                    location.reload();
                }
            }
        }
    });
}

function ProductPriceHistory(product_id) {
    $.ajax({
        dataType: 'json',
        url: "/products/ajax/price/history",
        type: "GET",
        data: {
            product_id: product_id,
        },
        success: function(data) {
            if(data['status'] == true) {
                var ctx = document.getElementById('solidLineChart').getContext('2d');
                var chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: JSON.parse(data['DayLabels']),
                        dataUnit: 'BTC',
                        lineTension: 0,
                        legend: true,
                        datasets: [{
                            label: "ფასი ცვლილება თვის ჭრილში, (ასაღები ფასი)",
                            backgroundColor: 'transparent',
                            borderColor: 'rgb(255, 99, 132)',
                            data: JSON.parse(data['PriceVendorLabel']),
                        }, 
                        {
                            label: "ფასი ცვლილება თვის ჭრილში, (საცალო ფასი)",
                            backgroundColor: 'transparent',
                            borderColor: 'rgb(255, 255, 0)',
                            data: JSON.parse(data['PriceRetailLabel']),
                        }, 
                        {
                            label: "ფასი ცვლილება თვის ჭრილში, (საბითუმო ფასი)",
                            backgroundColor: 'transparent',
                            borderColor: 'rgb(255, 0, 255)',
                            data: JSON.parse(data['PriceWholesaleLabel']),
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                    }
                });
                $(".price-history-table-body").html('');
                $.each(data['PriceItemList'], function(key, value) {
                    $(".price-history-table-body").append(`
                        <tr class="history-table-item-`+value['id']+`">
                            <td>`+value['created_at']+`</td>
                            <td>`+value['vendor_price'] / 100+` ₾</td>
                            <td>`+value['retail_price'] / 100+` ₾</td>
                            <td>`+value['wholesale_price'] / 100+` ₾</td>
                            <th>
                                <em class="icon ni ni-trash text-danger" style="font-size: 21px; cursor: pointer;" onclick="DeletePriceChangeItem(`+value['id']+`)"></em>
                            </th>
                        </tr>
                    `);
                });
                $("#PriceHistoryModal").modal('show');
            }
        }
    });
}

function DeletePriceChangeItem(item_id) {
    Swal.fire({
        title: "ნამდვილად გსურთ ფასის ცვლილების წაშლა?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: 'წაშლა',
        cancelButtonText: "გათიშვა",
        preConfirm: () => {
            $.ajax({
                dataType: 'json',
                url: "/products/ajax/price/delete",
                type: "POST",
                data: {
                    item_id: item_id,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    Swal.fire({
                      icon: 'success',
                      text: data['message'],
                    })
                    $(".history-table-item-"+item_id).remove();
                    location.reload();
                }
            });
        }
    });
}

function UpdateProductPrice(product_id) {
    $('#update_product_price_form')[0].reset();
    $("#update_price_product_id").val(product_id);
    $("#ProductPriceUpdateModal").modal('show');
}

function ProductPriceSubmit() {
    var form = $('#update_product_price_form')[0];
    var data = new FormData(form);

    $.ajax({
        dataType: 'json',
        url: "/products/ajax/price/update",
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
                })
                location.reload();
            }
        }
    });
}

  