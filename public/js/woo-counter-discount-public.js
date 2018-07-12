;( function ( $, window, document, undefined ) {

	$( '.composite_data' )

		.on( 'wc-composite-initializing', function( event, composite ) {
			console.log(event);
		} );

} ) ( jQuery, window, document );