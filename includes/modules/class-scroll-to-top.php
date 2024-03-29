<?php
/**
 * Scroll to top
 *
 * Displays scroll to top button based on theme options
 *
 * @package Gambit Pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Scroll to top Class
 */
class Gambit_Pro_Scroll_To_Top {

	/**
	 * Scroll to top Setup
	 *
	 * @return void
	 */
	static function setup() {

		// Return early if Gambit Theme is not active.
		if ( ! current_theme_supports( 'gambit-pro' ) ) {
			return;
		}

		// Enqueue Scroll-To-Top JavaScript.
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_script' ) );

		// Add Scroll-To-Top Checkbox in Customizer.
		add_action( 'customize_register', array( __CLASS__, 'scroll_to_top_settings' ) );
	}

	/**
	 * Enqueue Scroll-To-Top JavaScript
	 *
	 * @return void
	 */
	static function enqueue_script() {

		// Get Theme Options from Database.
		$theme_options = Gambit_Pro_Customizer::get_theme_options();

		// Call Credit Link function of theme if credit link is activated.
		if ( true === $theme_options['scroll_to_top'] && ! self::is_amp() ) :

			wp_enqueue_script( 'gambit-pro-scroll-to-top', GAMBIT_PRO_PLUGIN_URL . 'assets/js/scroll-to-top.min.js', array(), '20220924', true );

			// Passing Parameters to navigation.js.
			wp_localize_script( 'gambit-pro-scroll-to-top', 'gambitProScrollToTop', array(
				'icon'  => self::get_svg( 'collapse' ),
				'label' => esc_attr__( 'Scroll to top', 'gambit-pro' ),
			) );

		endif;
	}

	/**
	 * Get SVG icon.
	 *
	 * @return void
	 */
	static function get_svg( $icon ) {
		if ( function_exists( 'gambit_get_svg' ) ) {
			return gambit_get_svg( $icon );
		}
	}

	/**
	 * Add scroll to top checkbox setting
	 *
	 * @param object $wp_customize / Customizer Object.
	 */
	static function scroll_to_top_settings( $wp_customize ) {

		// Add Scroll to top headline.
		$wp_customize->add_control( new Gambit_Customize_Header_Control(
			$wp_customize, 'gambit_theme_options[scroll_top_title]', array(
				'label'    => esc_html__( 'Scroll to top', 'gambit-pro' ),
				'section'  => 'gambit_pro_section_footer',
				'settings' => array(),
				'priority' => 10,
			)
		) );

		// Add Scroll to top setting.
		$wp_customize->add_setting( 'gambit_theme_options[scroll_to_top]', array(
			'default'           => false,
			'type'              => 'option',
			'transport'         => 'refresh',
			'sanitize_callback' => 'gambit_sanitize_checkbox',
		) );

		$wp_customize->add_control( 'gambit_theme_options[scroll_to_top]', array(
			'label'    => __( 'Display Scroll to top button', 'gambit-pro' ),
			'section'  => 'gambit_pro_section_footer',
			'settings' => 'gambit_theme_options[scroll_to_top]',
			'type'     => 'checkbox',
			'priority' => 20,
		) );
	}

	/**
	 * Checks if AMP page is rendered.
	 */
	static function is_amp() {
		return function_exists( 'is_amp_endpoint' ) && is_amp_endpoint();
	}
}

// Run Class.
add_action( 'init', array( 'Gambit_Pro_Scroll_To_Top', 'setup' ) );
