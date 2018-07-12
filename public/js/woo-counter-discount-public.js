;(function ($, window, document, undefined) {

    $('.composite_data')

            .on('wc-composite-initializing', function (event, composite) {

                var current_configuration = composite.api.get_composite_configuration();

                console.log(current_configuration);
            });

                var current_configuration = composite.api.get_composite_configuration();

                console.log(current_configuration);
})(jQuery, window, document);