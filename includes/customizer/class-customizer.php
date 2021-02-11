<?php
/**
 * Customizer
 *
 * Setup the Customizer and theme options for the Pro plugin
 *
 * @package Gambit Pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Customizer Class
 */
class Gambit_Pro_Customizer {

	/**
	 * Customizer Setup
	 *
	 * @return void
	 */
	static function setup() {

		// Return early if Gambit Theme is not active.
		if ( ! current_theme_supports( 'gambit-pro' ) ) {
			return;
		}

		// Enqueue scripts and styles in the Customizer.
		add_action( 'customize_preview_init', array( __CLASS__, 'customize_preview_js' ) );
		add_action( 'customize_controls_print_styles', array( __CLASS__, 'customize_preview_css' ) );

		// Remove Upgrade section.
		remove_action( 'customize_register', 'gambit_customize_register_upgrade_settings' );
	}

	/**
	 * Get saved user settings from database or plugin defaults
	 *
	 * @return array
	 */
	static function get_theme_options() {

		// Merge Theme Options Array from Database with Default Options Array.
		return wp_parse_args( get_option( 'gambit_theme_options', array() ), self::get_default_options() );
	}


	/**
	 * Returns the default settings of the plugin
	 *
	 * @return array
	 */
	static function get_default_options() {

		$default_options = array(
			'logo_spacing'              => 0,
			'header_spacing'            => 20,
			'scroll_to_top'             => false,
			'footer_text'               => '',
			'credit_link'               => true,
			'top_navi_color'            => '#1585b5',
			'navi_primary_color'        => '#1585b5',
			'navi_secondary_color'      => '#252525',
			'content_primary_color'     => '#1585b5',
			'content_secondary_color'   => '#252525',
			'widget_title_color'        => '#252525',
			'footer_color'              => '#252525',
			'text_font'                 => 'Oxygen',
			'title_font'                => 'Oxygen',
			'title_is_bold'             => true,
			'title_is_uppercase'        => false,
			'navi_font'                 => 'Oxygen',
			'navi_is_bold'              => false,
			'navi_is_uppercase'         => false,
			'widget_title_font'         => 'Oxygen',
			'widget_title_is_bold'      => false,
			'widget_title_is_uppercase' => false,
		);

		return $default_options;
	}

	/**
	 * Embed JS file to make Theme Customizer preview reload changes asynchronously.
	 *
	 * @return void
	 */
	static function customize_preview_js() {
		wp_enqueue_script( 'gambit-pro-customizer-js', GAMBIT_PRO_PLUGIN_URL . 'assets/js/customizer.js', array( 'customize-preview' ), '20201119', true );
	}

	/**
	 * Embed CSS styles for the theme options in the Customizer
	 *
	 * @return void
	 */
	static function customize_preview_css() {
		wp_enqueue_style( 'gambit-pro-customizer-css', GAMBIT_PRO_PLUGIN_URL . 'assets/css/customizer.css', array(), '20201119' );
	}
}

// Run Class.
add_action( 'init', array( 'Gambit_Pro_Customizer', 'setup' ) );
