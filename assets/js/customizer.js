/**
 * Customizer JS
 *
 * Reloads changes on Theme Customizer Preview asynchronously for better usability
 *
 * @package Gambit Pro
 */

( function( $ ) {

	// Add Empty CSS area.
	var colors = $( '#gambit-pro-custom-colors-css' );

	if ( ! colors.length ) {
		colors = $( 'body' ).append( '<style type="text/css" id="gambit-pro-custom-colors-css"></style>' ).find( '#gambit-pro-custom-colors-css' );
	}

	/* Top Navigation Color Option */
	wp.customize( 'gambit_theme_options[top_navi_color]', function( value ) {
		value.bind( function( newval ) {
			$( '.header-bar-wrap, .top-navigation-menu ul' )
				.css( 'background', newval );
		} );
	} );

	/* Widgt Title Color Option */
	wp.customize( 'gambit_theme_options[widget_title_color]', function( value ) {
		value.bind( function( newval ) {
			$( '.widget-header, .page-header' )
				.css( 'background', newval );
		} );
	} );

	/* Footer Color Option */
	wp.customize( 'gambit_theme_options[footer_color]', function( value ) {
		value.bind( function( newval ) {
			$( '.site-footer-wrap, .footer-navigation-wrap, .footer-widgets-background' )
				.css( 'background', newval );
		} );
	} );

	/* Theme Fonts */
	wp.customize( 'gambit_theme_options[text_font]', function( value ) {
		value.bind( function( newval ) {

			// Embed Font.
			var fontFamilyUrl = newval.split( " " ).join( "+" );
			var googleFontPath = "http://fonts.googleapis.com/css?family=" + fontFamilyUrl + ":400,700";
			var googleFontSource = "<link id='gambit-pro-custom-text-font' href='" + googleFontPath + "' rel='stylesheet' type='text/css'>";
			var checkLink = $( "head" ).find( "#gambit-pro-custom-text-font" ).length;

			if (checkLink > 0) {
				$( "head" ).find( "#gambit-pro-custom-text-font" ).remove();
			}
			$( "head" ).append( googleFontSource );

			// Set CSS.
			$( 'body, button, input, select, textarea' )
				.css( 'font-family', newval );

		} );
	} );

	wp.customize( 'gambit_theme_options[title_font]', function( value ) {
		value.bind( function( newval ) {

			// Embed Font.
			var fontFamilyUrl = newval.split( " " ).join( "+" );
			var googleFontPath = "http://fonts.googleapis.com/css?family=" + fontFamilyUrl + ":400,700";
			var googleFontSource = "<link id='gambit-pro-custom-title-font' href='" + googleFontPath + "' rel='stylesheet' type='text/css'>";
			var checkLink = $( "head" ).find( "#gambit-pro-custom-title-font" ).length;

			if (checkLink > 0) {
				$( "head" ).find( "#gambit-pro-custom-title-font" ).remove();
			}
			$( "head" ).append( googleFontSource );

			// Set CSS.
			$( '.site-title, .page-title, .entry-title' )
				.css( 'font-family', newval );

		} );
	} );

	wp.customize( 'gambit_theme_options[navi_font]', function( value ) {
		value.bind( function( newval ) {

			// Embed Font.
			var fontFamilyUrl = newval.split( " " ).join( "+" );
			var googleFontPath = "http://fonts.googleapis.com/css?family=" + fontFamilyUrl + ":400,700";
			var googleFontSource = "<link id='gambit-pro-custom-navi-font' href='" + googleFontPath + "' rel='stylesheet' type='text/css'>";
			var checkLink = $( "head" ).find( "#gambit-pro-custom-navi-font" ).length;

			if (checkLink > 0) {
				$( "head" ).find( "#gambit-pro-custom-navi-font" ).remove();
			}
			$( "head" ).append( googleFontSource );

			// Set CSS.
			$( '.main-navigation-menu a' )
				.css( 'font-family', newval );

		} );
	} );

	wp.customize( 'gambit_theme_options[widget_title_font]', function( value ) {
		value.bind( function( newval ) {

			// Embed Font.
			var fontFamilyUrl = newval.split( " " ).join( "+" );
			var googleFontPath = "http://fonts.googleapis.com/css?family=" + fontFamilyUrl + ":400,700";
			var googleFontSource = "<link id='gambit-pro-custom-widget-title-font' href='" + googleFontPath + "' rel='stylesheet' type='text/css'>";
			var checkLink = $( "head" ).find( "#gambit-pro-custom-widget-title-font" ).length;

			if (checkLink > 0) {
				$( "head" ).find( "#gambit-pro-custom-widget-title-font" ).remove();
			}
			$( "head" ).append( googleFontSource );

			// Set CSS.
			$( '.page-header .archive-title, .comments-header .comments-title, .comment-reply-title span,.widget-title' )
				.css( 'font-family', newval );

		} );
	} );

} )( jQuery );
