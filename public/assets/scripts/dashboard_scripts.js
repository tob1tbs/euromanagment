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
                        Swal.fire({
                            icon: 'success',
                            text: data['message'],
                            timer: 2000,
                        });
                        location.reload();
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
                var order_data = data['DashboardOrderData']['created_at'];

                $(".modal-order-number").html('').append('#'+data['DashboardOrderData']['id']);
                $(".modal-order-date").html('').append(order_data.split('T')[0]+ ' '+order_data.split('T')[1].split('.')[0]);

                if(data['DashboardOrderData']['rs_send'] == 1) {
                    var order_buttons = `
                        <a href="/dashboards/orders/invoice/print/`+data['DashboardOrderData']['id']+`" target="_blank" class="btn btn-warning font-neue">
                            ინვოისის დაბეჭდვა
                            <em class="icon ni ni-printer-fill ml-1"></em>
                        </a>
                        <button class="btn btn-primary font-neue">
                            ინვოისის გაგზავნა
                            <em class="icon ni ni-send ml-1"></em>
                        </button>
                        <a href="/dashboards/orders/print/`+data['DashboardOrderData']['id']+`" target="_blank" class="btn btn-info font-neue">
                            დეტალური დაბეჭდვა
                            <em class="icon ni ni-printer-fill ml-1"></em>
                        </a>
                    `;

                    var rs_send_form = '';
                } else {
                    var rs_send_form = `
                        <div class="col-3 mb-3">
                            <div class="form-group">
                                <label class="form-label">ზედნადების ტიპი:</label>
                                <select class="form-control" name="send_overhead_type" id="send_overhead_type" onchange="ValidTransportInputs()">
                                    <option value="0"></option>
                                    <option value="1">ტრანსპორტირებით</option>
                                    <option value="2">ტრანსპორტირების გარეშე</option>
                                    <option value="3">შიდა გადაზიდვა</option>
                                    <option value="4">უკან დაბრუნება</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-3 mb-3">
                            <div class="form-group">
                                <label class="form-label">ზედნადების კატეგორია:</label>
                                <select class="form-control" name="send_overhead_category" id="send_overhead_category">
                                    <option value="1">ჩვეულებრივი</option>
                                    <option value="2">ხე-ტყე</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-3 mb-3">
                            <div class="form-group">
                                <label class="form-label">მძღოლის (პირადი ნომერი):</label>
                                <input type="text" class="form-control" name="send_overhead_driver" id="send_overhead_driver">
                            </div>
                        </div>
                        <div class="col-3 mb-3">
                            <div class="form-group">
                                <label class="form-label">მანქანის ნომერი:</label>
                                <input type="text" class="form-control" name="send_overhead_car" id="send_overhead_car">
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="form-group">
                                <label class="form-label">ტრანსპორტირების დაწყების ადგილი:</label>
                                <input type="text" class="form-control" name="send_overhead_start_address" id="send_overhead_start_address">
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="form-group">
                                <label class="form-label">ტრანსპორტირების დასრულების ადგილი:</label>
                                <input type="text" class="form-control" name="send_overhead_end_address" id="send_overhead_end_address">
                            </div>
                        </div>
                    `;
                    var order_buttons = `
                        <button class="btn btn-success font-neue" type="button" onclick="SendOverhead()">ზედნადების ატვირთვა</button>
                        <a href="/dashboards/orders/print/`+data['DashboardOrderData']['id']+`" target="_blank" class="btn btn-warning font-neue">
                            ინვოისის დაბეჭდვა
                            <em class="icon ni ni-printer-fill ml-1"></em>
                        </a>
                        <button class="btn btn-primary font-neue">
                            ინვოისის გაგზავნა
                            <em class="icon ni ni-send ml-1"></em>
                        </button>
                        <a href="/dashboards/orders/print/`+data['DashboardOrderData']['id']+`" target="_blank" class="btn btn-info font-neue">
                            დეტალური დაბეჭდვა
                            <em class="icon ni ni-printer-fill ml-1"></em>
                        </a>
                    `;
                }
                $(".order-buttons").html('').append(order_buttons);
                $(".send-overhead-form").html('').append(rs_send_form);

                var order_item_html = '';
                var overead_list = '';

                $.each(data['DashboardOrderData']['order_items'], function(key, value) {
                    if(data['DashboardOrderData']['rs_send'] == 0 || data['DashboardOrderData']['rs_send'] == 2) {
                        var item_switcher = `
                            <div class="g" style="position: relative; left: 10px;">
                                <div class="custom-control custom-control-sm custom-switch">
                                    <input type="checkbox" name="item_rs[`+value['id']+`][]" value="1" class="custom-control-input" id="overhead_item_`+value['id']+`" checked>
                                    <label class="custom-control-label" for="overhead_item_`+value['id']+`"></label>
                                </div>
                            </div>
                        `
                    } else {
                        var item_switcher = `-`;
                    }
                    order_item_html += `
                        <tr class="font-helvetica-regular">
                            <td>`+value['id']+`</td>
                            <td>`+value['order_item_data']['name']+`</td>
                            <td>`+value['price'] / 100+`₾</td>
                            <td>`+value['order_item_data']['product_unit']['name']+`</td>
                            <td>`+value['quantity']+`</td>
                            <td>`+value['quantity'] * value['price'] / 100+`₾</td>
                            <td>
                                `+item_switcher+`
                            </td>
                        </tr>
                    `;
                });
                $("#order_id").val(order_id);
                $("#order_form").html('').append(order_item_html);
                $(".order-customer").html('');

                if(data['DashboardOrderData']['customer_company'] != null && data['DashboardOrderData']['customer_type'] == null) {
                    $(".order-customer").append(data['DashboardOrderData']['customer_company']['name']+' ('+data['DashboardOrderData']['customer_company']['code']+')');
                }

                if(data['DashboardOrderData']['customer_company'] == null && data['DashboardOrderData']['customer_type'] != null) {
                    $(".order-customer").append(data['DashboardOrderData']['customer_type']['name']+' '+data['DashboardOrderData']['customer_type']['lastname']+' ('+data['DashboardOrderData']['customer_type']['personal_id']+')');
                }

                $(".overhead-list, .transaction-list").html('');
                if(data['DashboardOrderOverheadList'].length > 0) {
                    $.each(data['DashboardOrderOverheadList'], function(key, value) {
                        if(value['status'] == 1) {
                            var order_status = '<span class="badge badge-outline-success font-helvetica-regular">ზედნადები ატვირთულია</span>';
                            if(data['DashboardOrderData']['status'] == 4) {
                                var overhead_cancel = '';
                            } else {
                                var overhead_cancel = '<a href="javascript:;" onclick="CancelOverhead('+value['overhead_id']+', '+value['order_id']+')" class="btn btn-sm btn-danger font-helvetica-regular">გაუქმება</a>';
                            }
                            var cancel_date = '-';
                            var cancel_by = '';
                        } else if (value['status'] == 2) {
                            var order_status = '<span class="badge badge-outline-danger font-helvetica-regular">გაუქმებული</span>';
                            var overhead_cancel = '';
                            var cancel_date = '<span class="badge badge-outline-danger">'+value['deleted_at']+'</span>';
                            var cancel_by = value['deleted_by']['name']+` `+value['deleted_by']['lastname'];
                        } 

                        $(".overhead-list").append(`
                            <tr class="tb-tnx-item font-helvetica-regular">
                                <td class="tb-tnx-id">
                                    <a href="javascript:;" onclick="ViewSendOverhead(`+value['id']+`)"><span>`+value['overhead_id']+`</span></a>
                                </td>
                                <td class="text-center tb-tnx-info">
                                    <span class="badge badge-outline-primary">`+value['created_at'].split('T')[0]+` `+value['created_at'].split('T')[1].split('.')[0]+`</span>
                                    <br>
                                    <span>`+value['created_by']['name']+` `+value['created_by']['lastname']+`</span>
                                </td>
                                <td class="text-center tb-tnx-info">
                                    `+cancel_date+`<br>
                                    <span>`+cancel_by+`</span>
                                </td>
                                <td class="text-center tb-tnx-info">
                                    <div class="tb-tnx-status">
                                        `+order_status+`
                                    </div>
                                </td>
                                <td>
                                    `+overhead_cancel+`
                                </td>
                            </tr>
                        `);
                    });
                } else {
                    $(".overhead-list").append(`
                        <tr class="tb-tnx-item font-helvetica-regular">
                            <td class="tb-tnx-id" colspan="5">
                                <div class="example-alert text-center">
                                    <div class="alert alert-info alert-icon font-helvetica-regular">
                                    <em class="icon ni ni-alert-circle"></em> აღნიშნულ შეკვეთაზე ზედნადები არ არის ატვირთული.</div>
                                </div>
                            </td>
                        </tr>
                    `);
                }

                if(1 == 2) {

                } else {
                    $(".transaction-list").append(`
                        <tr class="tb-tnx-item font-helvetica-regular">
                            <td class="tb-tnx-id" colspan="5">
                                <div class="example-alert text-center">
                                    <div class="alert alert-info alert-icon font-helvetica-regular">
                                    <em class="icon ni ni-alert-circle"></em> აღნიშნულ შეკვეთაზე ტრანზაქციები არ არის შექმნილი.</div>
                                </div>
                            </td>
                        </tr>
                    `);
                }
                $(".order_total").html('').append(data['DashboardOrderData']['total_price'] / 100+ '₾');
                $("#OrderModal").modal('show');
            }
        }
    });
}

function ValidTransportInputs() {
    if($("#send_overhead_type").val() == 2) {
        $("#send_overhead_driver, #send_overhead_car, #send_overhead_start_address, #send_overhead_end_address").val('').attr('disabled', true);
    } else {
        $("#send_overhead_driver, #send_overhead_car, #send_overhead_start_address, #send_overhead_end_address").attr('disabled', false);
    }
}

function SendOverhead() {
    var form = $('#order_form_data')[0];
    var data = new FormData(form);

    $.ajax({
        dataType: 'json',
        url: "/dashboards/ajax/order/overhead/send",
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
                    Swal.fire({
                        icon: 'warning',
                        text: data['message'],
                        timer: 2000,
                    });
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

function CancelOverhead(overhead_id, order_id) {
    Swal.fire({
        title: "ნამდვილად გსურთ ზედნადების გაუქმება",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: 'გაუქმება',
        cancelButtonText: "გათიშვა",
        preConfirm: () => {
            $.ajax({
                dataType: 'json',
                url: "/dashboards/ajax/order/overhead/cancel",
                type: "POST",
                data: {
                    overhead_id: overhead_id,
                    order_id: order_id,
                },
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
                        location.reload();
                    }
                }
            });
        }
    });
}

function ViewSendOverhead(overhead_id) {
    $.ajax({
        dataType: 'json',
        url: "/dashboards/ajax/order/overhead/get",
        type: "GET",
        data: {
            overhead_id: overhead_id,
        },
        success: function(data) {
            if(data['status'] == true) {
                var order_data = data['OverheadData']['created_at'];
                
                $(".view_overhead_number").html('').append(data['OverheadData']['overhead_id']);
                $(".overhead-number").html('').append(data['OverheadData']['overhead_id']);
                $(".overhead-category").html('').append(data['OverheadCategory'][data['OverheadData']['category']]);
                $(".overhead-type").html('').append(data['OverheadType'][data['OverheadData']['type']]);
                $(".overhead-date").html('').append(order_data.split('T')[0]+ ' '+order_data.split('T')[1].split('.')[0]);

                $("#overheads_form").html('');

                var total_price = 0;
                $.each(JSON.parse(data['OverheadData']['data']), function(key, value) {
                    $("#overheads_form").append(`
                        <tr class="tb-odr-item font-helvetica-regular">
                            <td>`+key+`</td>
                            <td>`+value['name']+`</td>
                            <td>`+value['price']+`₾</td>
                            <td>`+value['unit']+`</td>
                            <td>`+value['quantity']+`</td>
                            <td>`+(value['price'] * value['quantity']).toFixed(2)+`₾</td>
                        </tr>
                    `);

                    total_price = total_price + (value['price'] * value['quantity']);
                });
                $(".overhead-total-sum").html('').append(total_price.toFixed(2)+`₾`);
                $(".address-line-start, .address-line-end, .overhead-carm, .overhead-driver, .view_overhead_status").html('');

                if(data['OverheadData']['type'] == 1) {
                    $(".address-line-start").append(`
                        <span class="font-neue"><b>ტრანსპორტირების დაწყების ადგილი:</b></span>
                        <br>
                        <span class="font-neue">`+JSON.parse(data['OverheadData']['address'])['start']+`</span>
                    `);

                    $(".address-line-end").append(`
                        <span class="font-neue"><b>ტრანსპორტირების დასრულების ადგილი:</b></span>
                        <br>
                        <span class="font-neue">`+JSON.parse(data['OverheadData']['address'])['end']+`</span>
                    `);

                    $(".overhead-driver").append(`
                        <span class="font-neue"><b>მძღოლი:</b></span>
                        <br>
                        <span class="font-neue">`+JSON.parse(data['OverheadData']['driver_data'])['driver_data']+` (`+JSON.parse(data['OverheadData']['driver_data'])['driver_personal_number']+`)</span>
                    `);

                    $(".overhead-car").append(`
                        <span class="font-neue"><b>ავტომანქანის ნომერი:</b></span>
                        <br>
                        <span class="font-neue">`+JSON.parse(data['OverheadData']['driver_data'])['car_number']+`</span>
                    `);
                }

                if(data['OverheadData']['status'] == 1) {
                    var overhead_status = `
                        <span class="btn btn-outline-success font-helvetica-regular">ზედნადები ატვირთულია</span>
                    `;
                }

                if(data['OverheadData']['status'] == 2) {
                    var overhead_status = `
                        <span class="btn btn-outline-danger font-helvetica-regular">გაუქმებული</span>
                    `;
                }


                $(".view_overhead_status").append(overhead_status);
                $("#OrderModal").modal('hide');
                $("#OrderOverheadModal").modal('show');
            }
        }
    });
}

function CloseOrder(order_id) {
    Swal.fire({
        title: "ნამდვილად გსურთ შეკვეთის დასრულება",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: 'დასრულება',
        cancelButtonText: "გათიშვა",
        preConfirm: () => {
            $.ajax({
                dataType: 'json',
                url: "/dashboards/ajax/order/close",
                type: "POST",
                data: {
                    order_id: order_id,
                },
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
                        location.reload();
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            text: data['message'],
                            timer: 2000,
                        });
                    }
                }
            });
        }
    });
}

function OrderTransaction(order_id) {
    $.ajax({
        dataType: 'json',
        url: "/dashboards/ajax/get/transaction/data",
        type: "GET",
        data: {
            order_id: order_id,
        },
        success: function(data) {
            if(data['status'] == true) {
                console.log(data);
            }
        }
    });
    $("#TransactionData").modal('show');
}

function TransactionSave() {
    $.ajax({
        dataType: 'json',
        url: "/dashboards/ajax/order/transaction/save",
        type: "POST",
        data: {
            payment_type: $("#payment_type").val(),
            payment_amount: $("#payment_amount").val(),
            order_id: $("#order_id").val(),
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            if(data['status'] == true) {
                
            } else {
            }
        }
    });
}