function GetProductList() {
  $.ajax({
        dataType: 'json',
        url: "/dashboards/ajax/get/products",
        type: "GET",
        data: {
            search_query: $("#product_search").val(),
        },
        success: function(data) {
            if(data['status'] == true) {
                $(".product-search-body").html('');

                if(data['ProductList'].length > 0) {

                $.each(data['ProductList'], function(key, value) {
                    if(!value['photo']) {
                        var photo = '<img src="/no_photo.svg" class="card-img-top img-fluid" alt=""" style="width: 100%; height: 150px;">';
                    } else {
                        var photo = `<img src="`+value['photo']+`" class="card-img-top img-fluid" alt="">`;
                    }

                    $(".product-search-body").append(`
                        <div class="col-6 mb-2" onclick="GetProductData(`+value['id']+`)" style="cursor: pointer">
                            <div class="card card-bordered">
                                <div class="card-inner">
                                    <div style="position: absolute; right: 10px; top: 10px;">
                                        <span class="badge badge-primary font-helvetica-regular">ნაშთი: `+value['count']+` `+value['product_unit']['name']+`</span>
                                    </div>
                                    <div style="position: absolute; left: 10px;bottom: 10px;">
                                        <span class="badge badge-success font-helvetica-regular">საცალო ფასი: `+value['product_price']['0']['retail_price'] / 100+` ₾</span>
                                        <span class="badge badge-success font-helvetica-regular">საბითუმო ფასი: `+value['product_price']['0']['wholesale_price'] / 100+` ₾</span>
                                    </div>
                                    `+photo+`
                                </div>
                            </div>
                            <div class="font-neue badge mt-1 badge badge-secondary">`+value['name']+`</div>
                        </div>
                    `);
                });
                } else {
                    $(".product-search-body").append(`
                        <div class="col-12">
                            <div class="example-alert">
                                <div class="alert alert-light alert-icon font-helvetica-regular">
                                    <em class="icon ni ni-alert-circle"></em>
                                    პროდუქტი აღნიშნული სახელით ვერ მოიძებნა
                                </div>
                            </div>
                        </div>
                    `);
                }
            }
        }
  });
}

function GetProductData(product_id) {
    $.ajax({
        dataType: 'json',
        url: "/dashboards/ajax/get/product/data",
        type: "GET",
        data: {
            product_id: product_id,
        },
        success: function(data) {
            if(data['status'] == true) {
                $('#product_info')[0].reset();
                $("#product_name").val('#'+data['ProductData']['id']+' - '+data['ProductData']['name']);
                $("#product_unit").val(data['ProductData']['product_unit']['name']);
                $("#product_vendor_price").val(data['ProductData']['product_price'][0]['vendor_price'] / 100 +' ₾');
                $("#product_retail_price").val(data['ProductData']['product_price'][0]['retail_price'] / 100 +' ₾');
                $("#product_wholesale_price").val(data['ProductData']['product_price'][0]['wholesale_price'] / 100 +' ₾');
                $("#product_id").val(data['ProductData']['id']);
            }
        }
    });
    $("#ProductInfoModal").modal('show');
}

function AddToCart() {
    var form = $('#product_info')[0];
    var data = new FormData(form);

    $.ajax({
        dataType: 'json',
        url: "/dashboards/ajax/cart/add",
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
                $(".product-dashboard-list").html('');
                    $.each(data['CartData'], function(key, value) {
                        $(".product-dashboard-list").append(`
                            <tr class="dashboard-item-`+value['id']+` font-helvetica-regular">
                                <th>`+value['name']+`</th>
                                <td>`+value['attributes']['unit']+`</td>
                                <td>
                                    <div class="form-control-wrap number-spinner-wrap" style="width: 150px;">
                                        <button class="btn btn-icon btn-outline-light number-spinner-btn number-minus" data-number="minus" onclick="UpdateQuantityMinus(`+value['id']+`)"><em class="icon ni ni-minus"></em></button>
                                        <input type="number" class="form-control number-spinner item-quantity-`+value['id']+`" value="`+value['quantity']+`">
                                        <button class="btn btn-icon btn-outline-light number-spinner-btn number-plus" data-number="plus" onclick="UpdateQuantityPlus(`+value['id']+`)"><em class="icon ni ni-plus"></em></button>
                                    </div> 
                                </td>
                                <td>`+(value['price'] / 100).toFixed(2)+`</td>
                                <td class="total_price-`+value['id']+`">`+(value['quantity'] * value['price']).toFixed() / 100+` ₾</td>
                                <td>
                                    <a href="javascript:;" onclick="RemoveFromCart(`+value['id']+`)" class="btn btn-primary font-neue btn-dim d-none d-sm-inline-flex" data-toggle="dropdown">
                                        <em class="icon ni ni-trash"></em>
                                    </a>
                                </td>
                            </tr>
                        `);
                    });

                    $(".tfoot-buttons").html('');
                    $(".tfoot-buttons").append(`
                        <tr>
                            <td colspan="2">
                                <div>
                                    <button class="btn btn-danger font-neue" onclick="ClearCart()">შეკვეთის გასუფთავება</button>
                                    <button class="btn btn-success font-neue" onclick="MakeOrder()">შეკვეთის განთავსება</button>
                                </div>
                            </td>
                            <td>
                                <center><span class="badge badge-success item-counts">`+data['total_quantity']+`</span></center>
                            </td>
                            <td></td>
                            <td colspan="3">
                                <span class="badge badge-success item_total_price">`+data['cart_total']+` ₾</span>
                            </td>
                        </tr>
                    `);
                $("#ProductInfoModal").modal('hide');
                NioApp.NumberSpinner();
            } else {
                
            }
        }
    });
}

function ClearCart() {
    $.ajax({
        dataType: 'json',
        url: "/dashboards/ajax/cart/clear",
        type: "POST",
        data: {
                
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            if(data['status'] == true) {
                $(".product-dashboard-list, .tfoot-buttons").html('');
                $(".product-dashboard-list").append(`
                    <tr style="background-color: white;">
                        <th colspan="7">
                            <div class="example-alert">
                                <div class="alert alert-info alert-icon">
                                    <em class="icon ni ni-alert-circle"></em> 
                                    <strong class="font-helvetica-regular">შეკვეთა ცარიელია.</strong>
                                </div>
                            </div>
                        </th>
                    </tr>
                `);
            }
        }
    });
}

function ExportCustomerData() {
    $.ajax({
        dataType: 'json',
        url: "/dashboards/ajax/get/customers",
        type: "GET",
        data: {
            customer_type: $("#order_customer_type").val(),
            customer_code: $("#order_customer_code").val(),
        },
        success: function(data) {
            $(".customer-data-body").html('');
            if(data['status'] == true) {
                if(data['errors'] == true) {
                    $.each(data['message'], function(key, value) {
                        NioApp.Toast(value, 'error', {
                            position: 'top-right'
                        });
                    })
                } else {
                    if(data['type'] == 1) {
                        html = `
                            <div class="nk-wg-card card card-bordered h-100 mb-2">
                                <div class="card-inner h-100">
                                    <div class="nk-iv-wg2">
                                        <div class="nk-iv-wg2-title">
                                            <h6 class="title font-neue">კლიენტი:</h6>
                                        </div>
                                        <div class="nk-iv-wg2-text">
                                            <div class="nk-iv-wg2-amount ui-v2 font-neue" style="font-size: 16px;">`+data['CustomerData']['name']+` `+data['CustomerData']['lastname']+`</div>
                                            <ul class="nk-iv-wg2-list">
                                                <li>
                                                    <span class="item-label font-neue">პირადი ნომერი</span>
                                                    <span class="item-value">`+data['CustomerData']['personal_id']+`</span>
                                                </li>
                                                <li>
                                                    <span class="item-label font-neue">ტელფონის ნომერი</span>
                                                    <span class="item-value font-helvetica-regular">`+data['CustomerData']['phone']+`</span>
                                                </li>
                                                <li>
                                                    <span class="item-label font-neue">ელ-ფოსტა</span>
                                                    <span class="item-value font-helvetica-regular">`+data['CustomerData']['email']+`</span>
                                                </li>
                                                <li>
                                                    <span class="item-label font-neue">მისამართი</span>
                                                    <span class="item-value font-helvetica-regular">`+data['CustomerData']['address']+`</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    }
                    if(data['type'] == 2) {
                        html = `
                            <div class="nk-wg-card card card-bordered h-100 mb-2">
                                <div class="card-inner h-100">
                                    <div class="nk-iv-wg2">
                                        <div class="nk-iv-wg2-title">
                                            <h6 class="title font-neue">კლიენტი:</h6>
                                        </div>
                                        <div class="nk-iv-wg2-text">
                                            <div class="nk-iv-wg2-amount ui-v2 font-neue" style="font-size: 16px;">
                                                <span class="badge badge-success font-helvetica-regular">ი/მ</span>
                                                `+data['CustomerData']['name']+` `+data['CustomerData']['lastname']+`
                                            </div>
                                            <ul class="nk-iv-wg2-list">
                                                <li>
                                                    <span class="item-label font-neue">პირადი ნომერი</span>
                                                    <span class="item-value">`+data['CustomerData']['personal_id']+`</span>
                                                </li>
                                                <li>
                                                    <span class="item-label font-neue">ტელფონის ნომერი</span>
                                                    <span class="item-value font-helvetica-regular">`+data['CustomerData']['phone']+`</span>
                                                </li>
                                                <li>
                                                    <span class="item-label font-neue">ელ-ფოსტა</span>
                                                    <span class="item-value font-helvetica-regular">`+data['CustomerData']['email']+`</span>
                                                </li>
                                                <li>
                                                    <span class="item-label font-neue">მისამართი</span>
                                                    <span class="item-value font-helvetica-regular">`+data['CustomerData']['address']+`</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    }
                    if(data['type'] == 3) {
                        html = `
                            <div class="nk-wg-card card card-bordered h-100 mb-2">
                                <div class="card-inner h-100">
                                    <div class="nk-iv-wg2">
                                        <div class="nk-iv-wg2-title">
                                            <h6 class="title font-neue">კლიენტი:</h6>
                                        </div>
                                        <div class="nk-iv-wg2-text">
                                            <div class="nk-iv-wg2-amount ui-v2 font-neue" style="font-size: 16px;">
                                            `+data['CustomerData']['name']+`
                                            </div>
                                            <ul class="nk-iv-wg2-list">
                                                <li>
                                                    <span class="item-label font-neue">საიდენტიფიკაციო კოდი:</span>
                                                    <span class="item-value">`+data['CustomerData']['code']+`</span>
                                                </li>
                                                <li>
                                                    <span class="item-label font-neue">მისამართი</span>
                                                    <span class="item-value font-helvetica-regular">`+data['CustomerData']['address']+`</span>
                                                </li>
                                                <li>
                                                    <span class="item-label font-neue">საკონტაქტო პირი:</span>
                                                    <span class="item-value font-helvetica-regular">`+data['CustomerData']['contact']+`</span>
                                                </li>
                                                <li>
                                                    <span class="item-label font-neue">ტელეფონის ნომერი:</span>
                                                    <span class="item-value font-helvetica-regular">`+data['CustomerData']['phone']+`</span>
                                                </li>
                                                <li>
                                                    <span class="item-label font-neue">ელ-ფოსტა</span>
                                                    <span class="item-value font-helvetica-regular">`+data['CustomerData']['email']+`</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    }
                    $(".customer-data-body").append(html);
                    $("#customer_type").val(data['type']);
                    $("#customer_id").val(data['CustomerData']['id']);
                }
            } else {
                $.each(data['message'], function(key, value) {
                    NioApp.Toast(value, 'error', {
                        position: 'top-right'
                    });
                });
            }
        }
    });
}

function ClearCustomerFields() {
    $("#order_customer_type").val('');
    $("#order_customer_code").val('');
    $(".customer-data-body").html('');
}


$("#order_customer_type").change(function() {
    $("#order_customer_code").val('');
    $(".customer-data-body").html('');
});

function SelectCustomerData(customer_id, customer_type) {
    Swal.fire({
        title: "ნამდვილად გსურთ აღნიშნული კლიენტის არჩევა",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: 'არჩევა',
        cancelButtonText: "გათიშვა",
        preConfirm: () => {
            $('#order_detail')[0].reset();
            $("#customer_type").val(customer_type);
            $("#customer_id").val(customer_id);
        }
    });
}

function RemoveFromCart(item_id) {
    Swal.fire({
        title: "ნამდვილად გსურთ კალათიდან წაშლა",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: 'წაშლა',
        cancelButtonText: "გათიშვა",
        preConfirm: () => {
            $.ajax({
                dataType: 'json',
                url: "/dashboards/ajax/cart/remove",
                type: "POST",
                data: {
                    item_id: item_id,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if(data['status'] == true) {
                        $(".product-dashboard-list").html('');
                        if(Object.keys(data['CartData']).length > 0) {
                            $.each(data['CartData'], function(key, value) {
                                $(".product-dashboard-list").append(`
                                    <tr class="dashboard-item-`+value['id']+` font-helvetica-regular">
                                        <th>`+value['name']+`</th>
                                        <td>`+value['attributes']['unit']+`</td>
                                        <td>
                                            <div class="form-control-wrap number-spinner-wrap" style="width: 150px;">
                                                <button class="btn btn-icon btn-outline-light number-spinner-btn number-minus" data-number="minus" onclick="UpdateQuantityMinus(`+value['id']+`)"><em class="icon ni ni-minus"></em></button>
                                                <input type="number" class="form-control number-spinner item-quantity-`+value['id']+`" value="`+value['quantity']+`">
                                                <button class="btn btn-icon btn-outline-light number-spinner-btn number-plus" data-number="plus" onclick="UpdateQuantityPlus(`+value['id']+`)"><em class="icon ni ni-plus"></em></button>
                                            </div> 
                                        </td>
                                        <td>`+(value['price'] / 100).toFixed(2)+`</td>
                                        <td class="total_price-`+value['id']+`">`+(value['quantity'] * value['price']).toFixed() / 100+` ₾</td>
                                        <td>
                                            <a href="javascript:;" onclick="RemoveFromCart(`+value['id']+`)" class="btn btn-primary font-neue btn-dim d-none d-sm-inline-flex" data-toggle="dropdown">
                                                <em class="icon ni ni-trash"></em>
                                            </a>
                                        </td>
                                    </tr>
                                `);
                            });
                        } else {
                            $(".tfoot-buttons").html('');
                            $(".product-dashboard-list").append(`
                                <tr style="background-color: white;">
                                    <th colspan="7">
                                        <div class="example-alert">
                                            <div class="alert alert-info alert-icon">
                                                <em class="icon ni ni-alert-circle"></em> 
                                                <strong class="font-helvetica-regular">შეკვეთა ცარიელია.</strong>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                            `);
                        }
                        NioApp.NumberSpinner();

                        $(".item-counts, .item_total_price").html('');
                        $(".item_total_price").append(data['cart_total']+' ₾');
                        $(".item-counts").append(data['total_quantity']);
                    }
                }
            });
        }
    });
}

function UpdateQuantityPlus(item_id) {
    $.ajax({
        dataType: 'json',
        url: "/dashboards/ajax/cart/quantity",
        type: "POST",
        data: {
            quantity: parseInt($(".item-quantity-"+item_id).val()) + 1,
            item_id: item_id ,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            if(data['status'] == true) {
                $(".item-counts, .item_total_price").html('');
                $(".item_total_price").append(data['cart_total']+' ₾');
                $(".item-counts").append(data['total_quantity']);
                $(".total_price-"+item_id).html('');
                $(".total_price-"+item_id).append((data['item_total_price'].toFixed(2))+' ₾');
            }
        }
    });
}

function UpdateQuantityMinus(item_id) {
    $.ajax({
        dataType: 'json',
        url: "/dashboards/ajax/cart/quantity",
        type: "POST",
        data: {
            quantity: parseInt($(".item-quantity-"+item_id).val()) - 1,
            item_id: item_id ,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            if(data['status'] == true) {
                $(".item-counts, .item_total_price").html('');
                $(".item_total_price").append(data['cart_total']+' ₾');
                $(".item-counts").append(data['total_quantity']);
                $(".total_price-"+item_id).html('');
                $(".total_price-"+item_id).append((data['item_total_price'].toFixed(2))+' ₾');
            }
        }
    });
}

function MakeOrder() {
    $.ajax({
        dataType: 'json',
        url: "/dashboards/ajax/cart/submit",
        type: "POST",
        data: {
            order_id: $("#order_id").val(),
            customer_type: $("#customer_type").val(),
            customer_id: $("#customer_id").val() ,
        },
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
                    Swal.fire({
                        icon: 'success',
                        text: data['message'][0],
                        timer: 2000,
                    });
                    window.location.replace(data['redirect_url']);
                }
            }
        }
    });
}

function RejectOrder(order_id) {
    Swal.fire({
        title: "ნამდვილად გსურთ შეკვეთის გაუქმება",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: 'წაშლა',
        cancelButtonText: "გათიშვა",
        preConfirm: () => {
            $.ajax({
                dataType: 'json',
                url: "/dashboards/ajax/order/reject",
                type: "POST",
                data: {
                    order_id: order_id,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if(data['status'] == true) {
                       
                    }
                }
            });
        }
    });
}

function OrderModal(order_id) {
    $.ajax({
        dataType: 'json',
        url: "/dashboards/ajax/order/get",
        type: "GET",
        data: {
            order_id: order_id,
        },
        success: function(data) {
            if(data['status'] == true) {
                $(".modal-order-number").html('').append(data['DashboardOrderData']['id']);
                $(".modal-order-date").html('').append(new Date(data['DashboardOrderData']['created_at']));
                $("#OrderModal").modal('show');
            }
        }
    });
}