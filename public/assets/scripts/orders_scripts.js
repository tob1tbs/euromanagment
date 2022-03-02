function MakeOrderAction(action_id, order_id) {
	$.ajax({
        dataType: 'json',
        url: "/orders/ajax/action/submit",
        type: "POST",
        data: {
            action_id: action_id,
            order_id: order_id,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            return;
        }
    });
}