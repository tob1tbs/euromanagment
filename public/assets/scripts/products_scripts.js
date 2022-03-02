function CategoryModal() {
	$('#category_form')[0].reset();
	$(".category-modal-head").html('პროდუქტის კატეგორიის დამატება');
	$("#CategoryModal").modal('show');
}

function CategoryFormSubmit() {
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

$("#parent_sortable").sortable({
    items: "> div:not(:first)",
    axis: 'y',
    update: function (event, ui) {
        var data = $(this).sortable('serialize');
        $.ajax({
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: "/products/ajax/categories/sortable",
        });
    }
});

function CategoryActiveChange(category_id, elem) {
    if($(elem).is(":checked")) {
        category_active = 1;
    } else {
        category_active = 2
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
        title: "ნამდვილად გსურთ მომხმარებლის წაშლა?",
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
	$(".category-modal-head").html('პროდუქტის კატეგორიის რედაქტირება');
	$.ajax({
        dataType: 'json',
        url: "/products/ajax/categories/edit",
        type: "GET",
        data: {
            category_id: category_id,
        },
        success: function(data) {
            if(data['status'] == true) {
        		$('#category_form')[0].reset();
	            $("#category_name_ge").val(JSON.parse(data['ProductCategoryData']['name'])['ge']);
	            $("#category_name_en").val(JSON.parse(data['ProductCategoryData']['name'])['en']);
                $("#category_keywords_ge").val(JSON.parse(data['ProductCategoryData']['meta'])['ge']);
                $("#category_keywords_en").val(JSON.parse(data['ProductCategoryData']['meta'])['en']);
	            $("#category_id").val(data['ProductCategoryData']['id']);
		        $("#CategoryModal").modal('show');
            }
        }
    });
}

function ChildCategoriesList(category_id) {
    var form = $('#child_category_add')[0].reset();
    var data = new FormData(form);

	$.ajax({
        dataType: 'json',
        url: "/products/ajax/categories/child",
        type: "GET",
        data: {
            category_id: category_id,
        },
        success: function(data) {
            if(data['status'] == true) {
            	$(".child-category-list").html('');
            	$.each(data['ProductChildCategoryList'], function(key, value) {
                    if(value['active'] == 1) {
                        var checked = 'checked';                            
                    } else {
                        var checked = '';
                    }

	            	$(".child-category-list").append(`
	            		<tr id="child_category_item-`+value['id']+`">
					      	<th>`+value['id']+`</th>
                            <th class="text-center">`+value['sortable']+`</th>
					      	<td>`+JSON.parse(value['name'])['ge']+`</td>
                            <td>`+JSON.parse(value['name'])['en']+`</td>
					      	<td>
						      	<div class="custom-control custom-switch">
	                                <input type="checkbox" class="custom-control-input" id="child_category_`+value['id']+`" onclick="CategoryActiveChange(`+value['id']+`, this)" `+checked+`>
	                                <label class="custom-control-label" for="child_category_`+value['id']+`"></label>
	                            </div>
					      	</td>
					      	<td>
                                <ul class="nk-tb-actions gx-1">
                                    <li>
                                        <div class="drodown">
                                            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown">
                                                <em class="icon ni ni-more-h"></em>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right" style="width: 240px;">
                                                <ul class="link-list-opt no-bdr font-helvetica-regular">
                                                    <li>
                                                        <a href="javascript:;" onclick="CategoryEdit(`+value['id']+`)">
                                                            <em class="icon ni ni-dot"></em>
                                                            <span>რედაქტირება</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;" onclick="ChildCategoryDelete(`+value['id']+`)" class="text-danger">
                                                            <em class="icon ni ni-trash"></em>
                                                            <span>ქვეკატეგორიის წაშლა</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </td>
					    </tr>
	        		`);
        		});
                $("#child_category_parent_id").val(category_id);
        		$("#ChildCategoryModal").modal('show');
            }
        }
    });
}

function ChildCategoryAdd() {
    var form = $('#child_category_add')[0];
    var data = new FormData(form);

    $.ajax({
        dataType: 'json',
        url: "/products/ajax/categories/child/submit",
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
                $(".check-input").removeClass('border-danger'); 
                $(".text-error").html('');
                if(data['errors'] == true) {
                    $.each(data['message'], function(key, value) {
                        $("#"+key).addClass('border-danger');
                        $("."+key+"-error").html(value);
                    });
                } else {
                    $(".child-category-list").html('');
                    var form = $('#child_category_add')[0].reset();
                    $.each(data['ProductChildCategoryList'], function(key, value) {

                        if(value['active'] == 1) {
                            var checked = 'checked';                            
                        } else {
                            var checked = '';
                        }

                        $(".child-category-list").append(`
                            <tr id="child_category_item-`+value['id']+`">
                                <th>`+value['id']+`</th>
                                <th class="text-center">`+value['sortable']+`</th>
                                <td>`+JSON.parse(value['name'])['ge']+`</td>
                                <td>`+JSON.parse(value['name'])['en']+`</td>
                                <td>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="child_category_`+value['id']+`" onclick="CategoryActiveChange(`+value['id']+`, this)" `+checked+`>
                                        <label class="custom-control-label" for="child_category_`+value['id']+`"></label>
                                    </div>
                                </td>
                                <td>
                                    <ul class="nk-tb-actions gx-1">
                                        <li>
                                            <div class="drodown">
                                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown">
                                                    <em class="icon ni ni-more-h"></em>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right" style="width: 240px;">
                                                    <ul class="link-list-opt no-bdr">
                                                        <li class="divider"></li>
                                                        <li>
                                                            <a href="javascript:;" onclick="CategoryEdit({{ $category_item->id }})">
                                                                <em class="icon ni ni-dot"></em>
                                                                <span>რედაქტირება</span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;" onclick="ChildCategoryDelete(`+value['id']+`)" class="text-danger">
                                                                <em class="icon ni ni-trash"></em>
                                                                <span>ქვეკატეგორიის წაშლა</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        `);
                    });
                }
            }
        }
    });
}

function ChildCategoryDelete(child_category_id) {
	Swal.fire({
        title: "ნამდვილად გსურთ მომხმარებლის წაშლა?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: 'წაშლა',
        cancelButtonText: "გათიშვა",
        preConfirm: () => {
            $.ajax({
                dataType: 'json',
                url: "/products/ajax/categories/child/delete",
                type: "POST",
                data: {
                    child_category_id: child_category_id,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    $(".child-category-list").html('');
                    var form = $('#child_category_add')[0].reset();
                    $.each(data['ProductChildCategoryList'], function(key, value) {

                        if(value['active'] == 1) {
                            var checked = 'checked';                            
                        } else {
                            var checked = '';
                        }

                        $(".child-category-list").append(`
                            <tr id="child_category_item-`+value['id']+`">
                                <th>`+value['id']+`</th>
                                <th class="text-center">`+value['sortable']+`</th>
                                <td>`+JSON.parse(value['name'])['ge']+`</td>
                            	<td>`+JSON.parse(value['name'])['en']+`</td>
                                <td>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="child_category_`+value['id']+`" onclick="CategoryActiveChange(`+value['id']+`, this)" `+checked+`>
                                        <label class="custom-control-label" for="child_category_`+value['id']+`"></label>
                                    </div>
                                </td>
                                <td>
                                    <ul class="nk-tb-actions gx-1">
                                        <li>
                                            <div class="drodown">
                                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown">
                                                    <em class="icon ni ni-more-h"></em>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right" style="width: 240px;">
                                                    <ul class="link-list-opt no-bdr">
                                                        <li class="divider"></li>
                                                        <li>
                                                            <a href="javascript:;" onclick="CategoryEdit({{ $category_item->id }})">
                                                                <em class="icon ni ni-dot"></em>
                                                                <span>რედაქტირება</span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;" onclick="ChildCategoryDelete(`+value['id']+`)" class="text-danger">
                                                                <em class="icon ni ni-trash"></em>
                                                                <span>კატეგორიის წაშლა</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        `);
                    });
                }
            });
        }
    });
}

$("#child_sortable").sortable({
    axis: 'y',
    update: function (event, ui) {
        var data = $(this).sortable('serialize');
        $.ajax({
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: "/products/ajax/categories/child/sortable",
        });
    }
});

// BRANDS
function BrandModal() {
    $(".brand-modal-head").html('პროდუქტის ბრენდის დამატება');
    $('#brand_form')[0].reset();
    $("#BrandModal").modal('show');
}

function BrandFormSubmit() {
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

function GetSubCategoryList(field_name, append_field_name) {
    $.ajax({
        dataType: 'json',
       	url: "/products/ajax/get/subcategories",
        type: "GET",
        data: {
            category_id: $("#"+field_name).val(),
        },
        success: function(data) {
            if(data['status'] == true) {
                $("#"+append_field_name).html('');
                if(data['ProductChildCategoryList'].length > 0) {
                	html = '';
                    $.each(data['ProductChildCategoryList'], function(key, value) {
                        html += `<option value="`+value['id']+`">`+JSON.parse(value['name'])['ge']+`</option>`;
                    });
                    $("#"+append_field_name).append(html);
                    $("#"+append_field_name).removeAttr('disabled');
                } else {
                    $("#"+append_field_name).attr('disabled', 'true');
                }
            }
        }
    });
}

function GetSubCategoryAndBrandList() {
    $.ajax({
        dataType: 'json',
        url: "/products/ajax/get/subcategoriesbrands",
        type: "GET",
        data: {
            category_id: $("#product_category").val(),
        },
        success: function(data) {
            if(data['status'] == true) {
                if(data['ProductBrandList'].length > 0) {
                    $("#product_brand").html('');
                    brand_html = '';
                    $.each(data['ProductBrandList'], function(key, value) {
                        brand_html += `<option value="`+value['id']+`">`+JSON.parse(value['name'])['ge']+`</option>`;
                    });
                    $("#product_brand").append(brand_html);
                    $("#product_brand").removeAttr('disabled');
                } else {
                    $("#product_brand").html('');
                    $("#product_brand").attr('disabled', 'true');
                }

                if(data['ProductChildCategoryList'].length > 0) {
                    $("#product_child_category").html('');
                    category_html = '';
                    $.each(data['ProductChildCategoryList'], function(key, value) {
                        category_html += `<option value="`+value['id']+`">`+JSON.parse(value['name'])['ge']+`</option>`;
                    });
                    $("#product_child_category").append(category_html);
                    $("#product_child_category").removeAttr('disabled');
                } else {
                    $("#product_child_category").html('');
                    $("#product_child_category").attr('disabled', 'true');
                }

                if(Object.keys(data['ProductOptionArray']).length > 0) {
                    $("#product_parameters > .row").html('');
                    $.each(data['ProductOptionArray'], function(key, value) {
                        option_html = '';
                        switch (value['type']) {
                            case 'input':
                                option_html += `
                                <div class="col-4 mt-2">
                                    <div class="form-group">
                                        <label class="form-label" for="`+key+`">`+value['name']+`</label>
                                        <input type="text" name="product_option[`+key+`]" id="`+key+`" class="form-control">
                                        <input type="hidden" name="product_option_id[`+key+`]" value="`+value['id']+`">
                                    </div>
                                </div>
                                `;
                            break;
                            case 'select':
                                select_html = '<option value="0"></option>';
                                $.each(value['options'], function(select_key, select_value) {
                                    select_html += `
                                    <option value="`+select_key+`">`+select_value['name']+`</option>
                                    `;
                                });
                                option_html += `
                                <div class="col-4 mt-2">
                                    <div class="form-group">
                                        <label class="form-label" for="`+key+`">`+value['name']+`</label>
                                        <select class="form-control" name="product_option[`+key+`]" id="`+key+`">
                                        `+select_html+`
                                        </select>
                                        <input type="hidden" name="product_option_id[`+key+`]" value="`+value['id']+`">
                                    </div>
                                </div>
                                `;
                            break;
                            default:
                            option_html += "";
                        }
                        $("#product_parameters > .row").append(option_html);
                    });
                } else {
                    $("#product_parameters > .row").html(`
                        <div class="col-12">
                            <div class="alert alert-fill alert-warning alert-icon font-helvetica-regular">
                                <em class="icon ni ni-alert-circle"></em> 
                                აღნიშნულ კატეგორიაში არ არი პარამეტრები
                            </div>
                        </div>
                    `);    
                }
            } else {
                $("#product_brand, #product_child_category").html('');
                $("#product_brand, #product_child_category").attr('disabled', 'true');
                $("#product_parameters > .row").html(`
                    <div class="col-12">
                        <div class="alert alert-fill alert-warning alert-icon font-helvetica-regular">
                            <em class="icon ni ni-alert-circle"></em> 
                            პარამეტრების სანახავად გთხოვთ აირჩით პროდუქტის კატეგორია.
                        </div>
                    </div>
                `);    
            }
        }
    });
}

function GetBrandByChildCategory() {
    $.ajax({
        dataType: 'json',
        url: "/products/ajax/get/brandsbysubcategory",
        type: "GET",
        data: {
            child_category_id: $("#product_child_category").val(),
        },
        success: function(data) {
            if(data['status'] == true) {
                if(data['ProductBrandList'].length > 0) {
                    $("#product_brand").html('');
                    brand_html = '<option value="0"></option>';
                    $.each(data['ProductBrandList'], function(key, value) {
                        brand_html += `<option value="`+value['id']+`">`+JSON.parse(value['name'])['ge']+`</option>`;
                    });
                    $("#product_brand").append(brand_html);
                    $("#product_brand").removeAttr('disabled');
                } else {
                    $("#product_brand").attr('disabled', 'true');
                }
            }
        }
    });
}

function BrandActiveChange(brand_id, elem) {
    if($(elem).is(":checked")) {
        brand_active = 1;
    } else {
        brand_active = 2
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

$("#brand_sortable").sortable({
    items: "> div:not(:first)",
    axis: 'y',
    update: function (event, ui) {
        var data = $(this).sortable('serialize');
        $.ajax({
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: "/products/ajax/brands/sortable",
        });
    }
});

function BrandEdit(brand_id) {
    $(".brand-modal-head").html('პროდუქტის ბრენდის რედაქტირება');
    $('#brand_form')[0].reset();

    $.ajax({
        dataType: 'json',
        url: "/products/ajax/brands/edit",
        type: "GET",
        data: {
            brand_id: brand_id,
        },
        success: function(data) {
            if(data['status'] == true) {
                $("#brand_child_category_id").html('');
                $("#brand_id").val(data['ProductBrandData']['id']);
                $("#brand_name_ge").val(JSON.parse(data['ProductBrandData']['name'])['ge']);
                $("#brand_name_en").val(JSON.parse(data['ProductBrandData']['name'])['en']);
                if(data['ChildCategoryList'].length > 0) {
                    $.each(data['ChildCategoryList'], function(key, value) {
                        if(data['ProductBrandData']['child_category_id'] == value['id']) {
                            var Selected = 'selected';
                        } else {
                            var Selected = ' ';
                        }
                        $("#brand_child_category_id").append(`<option value="`+value['id']+`" `+Selected+`>`+JSON.parse(value['name'])['ge']+`</option>`);
                    });
                    $("#brand_child_category_id").removeAttr('disabled');
                } else {
                    $("#brand_child_category_id").attr('disabled', 'true');
                }
                $("#brand_category_id option[value='"+data['ProductBrandData']['category_id']+"']").attr("selected","selected");
                $("#BrandModal").modal('show');
            }
        }
    });
}

function OptionsModal() {
    $(".option-modal-head").html('პროდუქტის პარამეტრის დამატება');
    $("#OptionModal").modal('show');
}

function OptionSubmit() {
	var form = $('#option_form')[0];
    var data = new FormData(form);

    $.ajax({
        dataType: 'json',
        url: "/products/ajax/options/submit",
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

function OptionActiveChange(option_id, elem) {
    if($(elem).is(":checked")) {
        option_active = 1;
    } else {
        option_active = 2
    }

    $.ajax({
        dataType: 'json',
        url: "/products/ajax/options/active",
        type: "POST",
        data: {
            option_id: option_id,
            option_active: option_active,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            return;
        }
    });
}


function OptionDelete(option_id) {
    Swal.fire({
        title: "ნამდვილად გსურთ მომხმარებლის წაშლა?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: 'წაშლა',
        cancelButtonText: "გათიშვა",
        preConfirm: () => {
            $.ajax({
                dataType: 'json',
                url: "/products/ajax/options/delete",
                type: "POST",
                data: {
                    option_id: option_id,
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

function OptionEdit(option_id) {
    $(".option-modal-head").html('პროდუქტის პარამეტრის რედაქტირება');
    $.ajax({
        dataType: 'json',
        url: "/products/ajax/options/edit",
        type: "GET",
        data: {
            option_id: option_id,
        },
        success: function(data) {
            if(data['status'] == true) {
                $('#option_form')[0].reset();
                $("#option_name_ge").val(JSON.parse(data['ProductOptionData']['name'])['ge']);
                $("#option_name_en").val(JSON.parse(data['ProductOptionData']['name'])['en']);
                if(data['ProductChildCategoryList'].length > 0) {
                    $.each(data['ProductChildCategoryList'], function(key, value) {
                        if(data['ProductOptionData']['child_category_id'] == value['id']) {
                            var Selected = 'selected';
                        } else {
                            var Selected = ' ';
                        }
                        $("#option_child_category").append(`<option value="`+value['id']+`" `+Selected+`>`+JSON.parse(value['name'])['ge']+`</option>`);
                    });
                    $("#option_child_category").removeAttr('disabled');
                } else {
                    $("#option_child_category").attr('disabled', 'true');
                }
                $("#option_category option[value='"+data['ProductOptionData']['category_id']+"']").attr("selected","selected");
                $("#option_type option[value='"+data['ProductOptionData']['type']+"']").attr("selected","selected");
                $("#option_key").val(data['ProductOptionData']['key']);
                $("#option_id").val(data['ProductOptionData']['id']);
                $("#OptionModal").modal('show');
            }
        }
    });
}

$("#option_sortable").sortable({
    items: "> div:not(:first)",
    axis: 'y',
    update: function (event, ui) {
        var data = $(this).sortable('serialize');
        $.ajax({
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: "/products/ajax/options/sortable",
        });
    }
});

function OptionValue(option_id) {
    $.ajax({
        dataType: 'json',
        url: "/products/ajax/options/value",
        type: "GET",
        data: {
            option_id: option_id,
        },
        success: function(data) {
            if(data['status'] == true) {
                $("#value_option_id").val(option_id);
                $("#option_value").html('');
                $.each(data['ProductOptionValueList'], function(key, value) {
                    if(value['active'] == 1) {
                        var checked = 'checked';                            
                    } else {
                        var checked = '';
                    }
                    $("#option_value").append(`
                        <tr id="option_value_item-`+value['id']+`">
                            <th>`+value['id']+`</th>
                            <th class="text-center">`+value['sortable']+`</th>
                            <td>
                                <div class="form-group">
                                    <label class="form-label d-none"></label>
                                    <div class="form-control-wrap">
                                        <div class="form-icon form-icon-right">
                                            <em class="icon ni ni-save" style="cursor: pointer" onclick="OptionValueNameSave(`+value['id']+`)"></em>
                                        </div>
                                        <input type="text" class="form-control check-input" id="option_name_ge_`+value['id']+`" value="`+JSON.parse(value['name'])['ge']+`">
                                    </div>
                                    <small class="option_name_ge_`+value['id']+`-error text-error text-danger mt-1"></small>
                                </div>
                            </td>
                           <td>
                                <div class="form-group">
                                    <label class="form-label d-none"></label>
                                    <div class="form-control-wrap">
                                        <div class="form-icon form-icon-right">
                                            <em class="icon ni ni-save" style="cursor: pointer" onclick="OptionValueNameSave(`+value['id']+`)"></em>
                                        </div>
                                        <input type="text" class="form-control check-input" id="option_name_en_`+value['id']+`" value="`+JSON.parse(value['name'])['en']+`">
                                    </div>
                                    <small class="option_name_en_`+value['id']+`-error text-error text-danger mt-1"></small>
                                </div>
                            </td>
                            <td>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="option_value_`+value['id']+`" onclick="OptionValueActiveChange(`+value['id']+`, this)" `+checked+`>
                                    <label class="custom-control-label" for="option_value_`+value['id']+`"></label>
                                </div>
                            </td>
                            <td>
                                <ul class="nk-tb-actions gx-1">
                                    <li>
                                        <div class="drodown">
                                            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown">
                                                <em class="icon ni ni-more-h"></em>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right" style="width: 240px;">
                                                <ul class="link-list-opt no-bdr">
                                                    <li>
                                                        <a href="javascript:;" onclick="OptionValueEdit(`+value['id']+`)">
                                                            <em class="icon ni ni-dot"></em>
                                                            <span>რედაქტირება to do</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;" onclick="OptionValueDelete(`+value['id']+`)" class="text-danger">
                                                            <em class="icon ni ni-trash"></em>
                                                            <span>მნიშვნელობის წაშლა</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    `);
                });
                $('#option_value_form')[0].reset();
                $("#OptionValueModal").modal('show');
            }
        }
    });
}

function OptionValueSubmit() {
    var form = $('#option_value_form')[0];
    var data = new FormData(form);

    $.ajax({
        dataType: 'json',
        url: "/products/ajax/options/value/submit",
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
                    $("#option_value").html('');
                    $.each(data['ProductOptionValueList'], function(key, value) {
                        if(value['active'] == 1) {
                            var checked = 'checked';                            
                        } else {
                            var checked = '';
                        }
                        $("#option_value").append(`
                           <tr id="option_value_item-`+value['id']+`">
                                <th>`+value['id']+`</th>
                                <th class="text-center">`+value['sortable']+`</th>
                                <td>
                                    <div class="form-group">
                                        <label class="form-label d-none"></label>
                                        <div class="form-control-wrap">
                                            <div class="form-icon form-icon-right">
                                                <em class="icon ni ni-save" style="cursor: pointer" onclick="OptionValueNameSave(`+value['id']+`)"></em>
                                            </div>
                                            <input type="text" class="form-control check-input" id="option_name_ge_`+value['id']+`" value="`+JSON.parse(value['name'])['ge']+`">
                                        </div>
                                        <small class="option_name_ge_`+value['id']+`-error text-error text-danger mt-1"></small>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <label class="form-label d-none"></label>
                                        <div class="form-control-wrap">
                                            <div class="form-icon form-icon-right">
                                                <em class="icon ni ni-save" style="cursor: pointer" onclick="OptionValueNameSave(`+value['id']+`)"></em>
                                            </div>
                                            <input type="text" class="form-control check-input" id="option_name_en_`+value['id']+`" value="`+JSON.parse(value['name'])['en']+`">
                                        </div>
                                        <small class="option_name_en_`+value['id']+`-error text-error text-danger mt-1"></small>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="option_value_`+value['id']+`" onclick="OptionValueActiveChange(`+value['id']+`, this)" `+checked+`>
                                        <label class="custom-control-label" for="option_value_`+value['id']+`"></label>
                                    </div>
                                </td>
                                <td>
                                    <ul class="nk-tb-actions gx-1">
                                        <li>
                                            <div class="drodown">
                                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown">
                                                    <em class="icon ni ni-more-h"></em>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right" style="width: 240px;">
                                                    <ul class="link-list-opt no-bdr">
                                                        <li>
                                                            <a href="javascript:;" onclick="OptionValueEdit(`+value['id']+`)">
                                                                <em class="icon ni ni-dot"></em>
                                                                <span>რედაქტირება to do</span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;" onclick="OptionValueDelete(`+value['id']+`)" class="text-danger">
                                                                <em class="icon ni ni-trash"></em>
                                                                <span>მნიშვნელობის წაშლა</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        `);
                    });
                    $('#option_value_form')[0].reset();
                }
            }
        }
    });
}

function OptionValueActiveChange(option_value_id, elem) {
    if($(elem).is(":checked")) {
        option_value_active = 1;
    } else {
        option_value_active = 2
    }

    $.ajax({
        dataType: 'json',
        url: "/products/ajax/options/value/active",
        type: "POST",
        data: {
            option_value_id: option_value_id,
            option_value_active: option_value_active,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            return;
        }
    });
}

function  OptionValueDelete(option_value_id) {
    Swal.fire({
        title: "ნამდვილად გსურთ მომხმარებლის წაშლა?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: 'წაშლა',
        cancelButtonText: "გათიშვა",
        preConfirm: () => {
            $.ajax({
                dataType: 'json',
                url: "/products/ajax/options/value/delete",
                type: "POST",
                data: {
                    option_value_id: option_value_id,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if(data['status'] == true) {
                        $("#option_id").val(option_id);
                        $("#option_value").html('');
                        $.each(data['ProductOptionValueList'], function(key, value) {
                            if(value['active'] == 1) {
                                var checked = 'checked';                            
                            } else {
                                var checked = '';
                            }
                            $("#option_value").append(`
                                <tr id="option_value_item-`+value['id']+`">
                                    <th>`+value['id']+`</th>
                                    <th class="text-center">`+value['sortable']+`</th>
                                    <th class="text-center">`+value['key']+`</th>
                                    <td>
                                        <div class="form-group">
                                            <label class="form-label d-none"></label>
                                            <div class="form-control-wrap">
                                                <div class="form-icon form-icon-right">
                                                    <em class="icon ni ni-save" style="cursor: pointer" onclick="OptionValueNameSave(`+value['id']+`)"></em>
                                                </div>
                                                <input type="text" class="form-control check-input" id="option_name_ge_`+value['id']+`" value="`+JSON.parse(value['name'])['ge']+`">
                                            </div>
                                            <small class="option_name_ge_`+value['id']+`-error text-error text-danger mt-1"></small>
                                        </div>
                                    </td>
                                   <td>
                                        <div class="form-group">
                                            <label class="form-label d-none"></label>
                                            <div class="form-control-wrap">
                                                <div class="form-icon form-icon-right">
                                                    <em class="icon ni ni-save" style="cursor: pointer" onclick="OptionValueNameSave(`+value['id']+`)"></em>
                                                </div>
                                                <input type="text" class="form-control check-input" id="option_name_en_`+value['id']+`" value="`+JSON.parse(value['name'])['en']+`">
                                            </div>
                                            <small class="option_name_en_`+value['id']+`-error text-error text-danger mt-1"></small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="option_value_`+value['id']+`" onclick="OptionValueActiveChange(`+value['id']+`, this)" `+checked+`>
                                            <label class="custom-control-label" for="option_value_`+value['id']+`"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <ul class="nk-tb-actions gx-1">
                                            <li>
                                                <div class="drodown">
                                                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown">
                                                        <em class="icon ni ni-more-h"></em>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right" style="width: 240px;">
                                                        <ul class="link-list-opt no-bdr">
                                                            <li>
                                                                <a href="javascript:;" onclick="OptionValueEdit(`+value['id']+`)">
                                                                    <em class="icon ni ni-dot"></em>
                                                                    <span>რედაქტირება to do</span>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:;" onclick="OptionValueDelete(`+value['id']+`)" class="text-danger">
                                                                    <em class="icon ni ni-trash"></em>
                                                                    <span>მნიშვნელობის წაშლა</span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            `);
                        });
                        $('#option_value_form')[0].reset();
                        $("#OptionValueModal").modal('show');
                    }
                }
            });
        }
    });
}

$("#option_value").sortable({
    axis: 'y',
    update: function (event, ui) {
        var data = $(this).sortable('serialize');
        $.ajax({
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: "/products/ajax/options/value/sortable",
        });
    }
});

function OptionValueNameSave(option_value_id) {
    $.ajax({
        dataType: 'json',
        url: "/products/ajax/options/value/update",
        type: "POST",
        data: {
            name_ge: $("#option_name_ge_"+option_value_id).val(),
            name_en: $("#option_name_en_"+option_value_id).val(),
            option_value_id: option_value_id,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            if(data['status'] == true) {
                $(".check-input").removeClass('border-danger'); 
                $(".text-error").html('');
                if(data['errors'] == true) {
                    $.each(data['message'], function(key, value) {
                        $("#option_"+key+"_"+option_value_id+"").addClass('border-danger');
                        $(".option_"+key+"_"+option_value_id+"-error").html(value);
                    });
                } else {
                    toastr.clear();
                    NioApp.Toast(data['message'], 'success');
                }
            } else {
                toastr.clear();
                NioApp.Toast(data['message'], 'error');
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
                
            }
        }
    });
}

function ProductBalanceExport() {
    $.ajax({
        xhrFields: {
            responseType: 'blob',
        },
        url: "/products/ajax/balance/export",
        type: "GET",
        data: {
            
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

function ProductBalanceUpload() {
    $("#BalanceUploadModal").modal('show');
}

function ProductBalanceSubmit() {
    Swal.fire({
        title: "ნამდვილად გსურთ მომხმარებლის ნაშთების განახლება?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: 'დადასტურება',
        cancelButtonText: "გათიშვა",
        preConfirm: () => {
            var form = $('#balance_upload_form')[0];
            var data = new FormData(form);

            $.ajax({
                type: "POST",
                url: "/products/ajax/balance/update",
                data: data,
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
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
            });
        }
    });
}

function VendorModal() {
    $('#vendor_form')[0].reset();
    $(".vendor-modal-head").html('ახალი მომწოდებლის დამატება');
    $("#VendorModal").modal('show');
}

function VendorFormSubmit() {
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

function VendorActiveChange(vendor_id, elem) {
    if($(elem).is(":checked")) {
        vandor_active = 1;
    } else {
        vandor_active = 2
    }

    $.ajax({
        dataType: 'json',
        url: "/products/ajax/vendors/active",
        type: "POST",
        data: {
            vendor_id: vendor_id,
            vandor_active: vandor_active,
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
    $(".vendor-modal-head").html('მომწოდებლის რედაქტირება');
    $.ajax({
        dataType: 'json',
        url: "/products/ajax/vendors/edit",
        type: "GET",
        data: {
            vendor_id: vendor_id,
        },
        success: function(data) {
            if(data['status'] == true) {
                $('#vendor_form')[0].reset();
                $("#vendor_name").val(data['ProductVendorData']['name']);
                $("#vendor_code").val(data['ProductVendorData']['code']);
                $("#vendor_phone").val(data['ProductVendorData']['phone']);
                $("#vendor_address").val(data['ProductVendorData']['address']);
                $("#vendor_id").val(data['ProductVendorData']['id']);
                $("#VendorModal").modal('show');
            }
        }
    });
}

function ImportParentProduct() {    
    $.ajax({
        dataType: 'json',
        url: "/products/ajax/parent",
        type: "GET",
        data: {
            parent_id: $("#product_parent").val(),
        },
        success: function(data) {
            if(data['status'] == true) {
                $('#product_form')[0].reset();
                $("#product_parent option[value='"+data['ProductData']['id']+"']").attr("selected","selected");
                $("#product_name_ge").val(data['ProductData']['name_ge']);
                $("#product_name_en").val(data['ProductData']['name_en']);
                $("#product_category option[value='"+data['ProductData']['category_id']+"']").attr("selected","selected");
                
                if(data['ProductChildCategoryList'].length > 0) {
                    $("#product_child_category").html('');
                    $.each(data['ProductChildCategoryList'], function(key, value) {
                        if(data['ProductData']['child_category_id'] == value['id']) {
                            var Selected = 'selected';
                        } else {
                            var Selected = ' ';
                        }
                        $("#product_child_category").append(`<option value="`+value['id']+`" `+Selected+`>`+JSON.parse(value['name'])['ge']+`</option>`);
                    });
                    $("#product_child_category").removeAttr('disabled');
                } else {
                    $("#product_child_category").attr('disabled', 'true');
                }

                if(data['ProductBrandList'].length > 0) {
                    $("#product_brand").html('');
                    $.each(data['ProductBrandList'], function(key, value) {
                        if(data['ProductData']['brand_id'] == value['id']) {
                            var Selected = 'selected';
                        } else {
                            var Selected = ' ';
                        }
                        $("#product_brand").append(`<option value="`+value['id']+`" `+Selected+`>`+JSON.parse(value['name'])['ge']+`</option>`);
                    });
                    $("#product_brand").removeAttr('disabled');
                } else {
                    $("#product_brand").attr('disabled', 'true');
                }

                $("#product_status").val(data['ProductData']['status']);
                $("#product_vendor option[value='"+data['ProductData']['vendor_id']+"']").attr("selected","selected");
                $("#product_price").val(data['ProductPriceData']['price'] / 100);
                $("#product_discount_price").val(data['ProductData']['discount_price'] / 100);
                $("#product_discount_percent").val(data['ProductData']['discount_percent']);
                $("#product_count").val(data['ProductData']['count']);

                if(data['ProductData']['stock'] == 1) {
                    $("#product_in_stock").prop('checked', true);
                } else {
                    $("#product_in_stock").prop('checked', false);
                }

                if(data['ProductData']['preorder'] == 1) {
                    $("#product_preorder").prop('checked', true);
                } else {
                    $("#product_preorder").prop('checked', false);
                }

                if(Object.keys(data['ProductOptionArray']).length > 0) {
                    $("#product_parameters > .row").html('');
                    $.each(data['ProductOptionArray'], function(key, value) {
                        option_html = '';
                        switch (value['type']) {
                            case 'input':
                                option_html += `
                                <div class="col-4 mt-2">
                                    <div class="form-group">
                                        <label class="form-label" for="`+key+`">`+JSON.parse(value['name'])['ge']+`</label>
                                        <input type="text" name="product_option[`+key+`]" id="`+key+`" class="form-control" value="`+value['value']+`">
                                        <input type="hidden" name="product_option_id[`+key+`]" value="`+value['id']+`">
                                    </div>
                                </div>
                                `;
                            break;
                            case 'select':
                                select_html = '<option value="0"></option>';
                                $.each(value['options'], function(select_key, select_value) {
                                    if(select_value['id'] == value['value']) {
                                        selected = 'selected';
                                    } else {
                                        selected = ' ';
                                    }
                                    select_html += `
                                    <option value="`+select_value['id']+`" `+selected+`>`+JSON.parse(select_value['name'])['ge']+`</option>
                                    `;
                                });
                                option_html += `
                                <div class="col-4 mt-2">
                                    <div class="form-group">
                                        <label class="form-label" for="`+key+`">`+JSON.parse(value['name'])['ge']+`</label>
                                        <select class="form-control" name="product_option[`+key+`]" id="`+key+`">
                                        `+select_html+`
                                        </select>
                                        <input type="hidden" name="product_option_id[`+key+`]" value="`+value['id']+`">
                                    </div>
                                </div>
                                `;
                            break;
                            default:
                            option_html += "";
                        }
                        $("#product_parameters > .row").append(option_html);
                    });
                } else {
                    $("#product_parameters > .row").html(`
                        <div class="col-12">
                            <div class="alert alert-fill alert-warning alert-icon font-helvetica-regular">
                                <em class="icon ni ni-alert-circle"></em> 
                                აღნიშნულ კატეგორიაში არ არი პარამეტრები
                            </div>
                        </div>
                    `);    
                }

                $("#product_meta_keywords_ge").val(JSON.parse(data['ProductMetaData']['keywords'])['ge']);
                $("#product_meta_keywords_en").val(JSON.parse(data['ProductMetaData']['keywords'])['en']);
                $("#product_meta_description_ge").val(JSON.parse(data['ProductMetaData']['description'])['ge']);
                $("#product_meta_description_en").val(JSON.parse(data['ProductMetaData']['description'])['en']);
            } else {
                Swal.fire({
                  icon: 'warning',
                  text: data['message'],
                })
            }
        }
    });
}