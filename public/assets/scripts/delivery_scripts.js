function GetStreetList(district_id) {
	$.ajax({
        dataType: 'json',
        url: "/delivery/ajax/streets",
        type: "GET",
        data: {
        	district_id: district_id,
        },
        success: function(data) {
            if(data['status'] == true) {
            	$(".street-table-list").html('');
            	$.each(data['DeliveryStreetList'], function(key, value) {
            		if(value['active'] == 1) {
            			var checked = 'checked';
            		} else {
            			var checked = '';
            		}
            		$(".street-table-list").append(`
            			<tr>
				      		<td scope="row">`+value['id']+`</td>
				      		<td>`+value['name_ge']+`</td>
				      		<td>
				      			<div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" name="reg-public" id="street_`+value['id']+`" value="1" onclick="StreetActiveChange(`+value['id']+`, this)" `+checked+`>
                                        <label class="custom-control-label" for="street_`+value['id']+`"></label>
                                    </div>
                                </div>
				      		</td>
				      		<td>
				      			<ul class="nk-tb-actions gx-1">
                                    <li>
                                        <div class="drodown">
                                            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                            <div class="dropdown-menu dropdown-menu-right" style="widtd: 300px;">
                                                <ul class="link-list-opt no-bdr">
                                                    <li><a href="#"><em class="icon ni ni-activity-round"></em><span>211231</span></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </td>
				    	</tr>
        			`);
                })
            	$("#street_modal").modal('show');
            }
        }
    });
}

function SaveDeliveryPrice(district_id) {
	$.ajax({
        dataType: 'json',
        url: "/delivery/ajax/district_price",
        type: "POST",
        data: {
        	district_id: district_id,
        	delivery_price: $("#delivery_price_"+district_id).val(),
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

function StreetActiveChange(street_id, elem) {
	if($(elem).is(":checked")) {
        street_active = 1;
    } else {
        street_active = 0
    }

	$.ajax({
        dataType: 'json',
        url: "/delivery/ajax/streets/active",
        type: "POST",
        data: {
        	street_id: street_id,
        	street_active: street_active,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            return;
        }
    });
}