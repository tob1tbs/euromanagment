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
                                <th>#`+value['id']+` - `+value['name']+`</th>
                                <td>Mark</td>
                                <td>
                                    <div class="form-control-wrap number-spinner-wrap" style="width: 150px;">
                                        <button class="btn btn-icon btn-outline-light number-spinner-btn number-minus" data-number="minus"><em class="icon ni ni-minus"></em></button>
                                        <input type="number" class="form-control number-spinner" value="0">
                                        <button class="btn btn-icon btn-outline-light number-spinner-btn number-plus" data-number="plus"><em class="icon ni ni-plus"></em></button>
                                    </div> 
                                </td>
                                <td>`+value['quantity']+` `+value['attributes']['unit']+`</td>
                                <td>@mdo</td>
                                <td>
                                    <div class="custom-control custom-control-sm custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck2" checked>
                                        <label class="custom-control-label" for="customCheck2"></label>
                                    </div>
                                </td>
                                <td>

                                </td>
                            </tr>
                        `);
                    });

                    $(".tfoot-buttons").html('');
                    $(".tfoot-buttons").append(`
                        <tr>
                            <td colspan="6">
                                <div class="float-right">
                                    <button class="btn btn-danger font-neue" onclick="ClearCart()">შეკვეთის გასუფთავება</button>
                                    <button class="btn btn-success font-neue">შეკვეთის განთავსება</button>
                                </div>
                            </td>
                        </tr>
                    `);
                $("#ProductInfoModal").modal('hide');
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
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
                    console.log(123);
                    if(data['CustomerData']['type'] == 1) {
                        html = `
                            <div class="nk-wg-card card card-bordered h-100">
                                <div class="card-inner h-100">
                                    <div class="nk-iv-wg2">
                                        <div class="nk-iv-wg2-title">
                                            <h6 class="title font-neue">კლიენტი:</h6>
                                        </div>
                                        <div class="nk-iv-wg2-text">
                                            <div class="nk-iv-wg2-amount ui-v2 font-neue" style="font-size: 16px;">`+JSON.parse(data['CustomerData']['data'])['name']+` `+JSON.parse(data['CustomerData']['data'])['lastname']+`</div>
                                            <ul class="nk-iv-wg2-list">
                                                <li>
                                                    <span class="item-label font-neue">პირადი ნომერი</span>
                                                    <span class="item-value">`+data['CustomerData']['code']+`</span>
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
                                                    <span class="item-value font-helvetica-regular">`+JSON.parse(data['CustomerData']['data'])['address']+`</span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="nk-iv-wg2-cta">
                                            <a href="#" class="btn btn-success btn-block font-neue">არჩევა</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    }
                    $(".customer-data-body").append(html);
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
}