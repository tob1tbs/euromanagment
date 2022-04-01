function getCustomerFields() {
  $.ajax({
        dataType: 'json',
        url: "/dashboards/ajax/get/fields",
        type: "GET",
        data: {
            type_id: $("#customer_type").val(),
        },
        success: function(data) {
            if(data['status'] == true) {
                
            }
        }
  });
}