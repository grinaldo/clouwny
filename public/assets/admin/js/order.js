function initTNBar(el) {
    var container = $(el).parent().parent();
    var currentValue = container.find('.tn-container').text();
    container.html('<input type="text" value="' + currentValue + '" onkeypress="return initChangeTN(event, this)">');
}

function initChangeTN(e, el) {
    if (e.keyCode == 13) {
        var trackingNumber = $(el).val();
        var orderNumber    = $(el).parent().parent().find('td')[0].innerHTML;
        var csrf = $('meta[name=csrf-token]').attr("content");
        $.ajax({
            /* the route pointing to the post function */
            url: '/backend/orders/tracking-number/update',
            type: 'POST',
            /* send the csrf-token and the input to the controller */
            data: {_token: csrf, tracking_number: trackingNumber, order_number: orderNumber},
            dataType: 'JSON',
            /* remind that 'data' is the response of the AjaxController */
            success: function success(data) {
                var content = '<div class="tn-container">'+data.tracking_number+'</div> <b><a href="#" class="edit-tn" onclick="initTNBar(this)">[<i class="fa fa-icon fa-edit"></i> edit]</a></b>';
                $(el).parent().html(content);
            },
            error: function error(data) {
            }
        });
    }
}

function initUpdateOrderStatus(e, el){
    var orderNumber = $(el).parent().parent().find('td')[0].innerHTML;
    var statusType = $(el).data('status');
    var verified = $(el).prop('checked');
    var csrf = $('meta[name=csrf-token]').attr("content");
    $.ajax({
        url: '/backend/orders/status/update',
        type: 'POST',
        /* send the csrf-token and the input to the controller */
        data: {_token: csrf, check: verified, status: statusType, order_number: orderNumber},
        dataType: 'JSON',
        /* remind that 'data' is the response of the AjaxController */
        success: function success(data) {
            alert('Order ' + data.order_number + ' updated to ' + data.order_status +'!');
            var elToEdit = $(el).parent().parent().find('.latest-status');
            if (data.order_status == 'Order Shipped') {
                elToEdit.removeClass('label-warning');
                elToEdit.removeClass('label-info');
                elToEdit.addClass('label-success');
            } else if (data.order_status == 'Order Verified') {
                elToEdit.removeClass('label-warning');
                elToEdit.removeClass('label-success');
                elToEdit.addClass('label-info');
            } else {
                elToEdit.removeClass('label-info');
                elToEdit.removeClass('label-success');
                elToEdit.addClass('label-warning');
            }
            elToEdit.html(data.order_status);
        },
        error: function error(data) {
        }
    });
}