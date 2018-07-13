;
(function ($, window, document, undefined) {
    $(document).on('heartbeat-tick', function (event, data) {

        if (data.acn === undefined) {
            return;
        }

        $.each(data.acn.amount, function (key, value) {
            $('.coupon-id-' + value.id).text(value.am);
        });

    });
})(jQuery, window, document);