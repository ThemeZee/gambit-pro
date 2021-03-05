<?php
/**
 * Custom Colors
 *
 * Adds color settings to Customizer and generates color CSS code
 *
 * @package Gambit Pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Custom Colors Class
 */
class Gambit_Pro_Custom_Colors {

	/**
	 * Custom Colors Setup
	 *
	 * @return void
	 */
	static function setup() {

		// Return early if Gambit Theme is not active.
		if ( ! current_theme_supports( 'gambit-pro' ) ) {
			return;
		}

		// Add Custom Color CSS code to custom stylesheet output.
		add_filter( 'gambit_pro_custom_css_stylesheet', array( __CLASS__, 'custom_colors_css' ) );

		// Add Custom Color Settings.
		add_action( 'customize_register', array( __CLASS__, 'color_settings' ) );
	}

	/**
	 * Builds all custom color CSS styles.
	 *
	 * @param String $custom_css Custom Styling CSS.
	 * @return string CSS code
	 */
	static function custom_colors_css( $custom_css = '' ) {

		// Get Theme Options from Database.
		$theme_options = Gambit_Pro_Customizer::get_theme_options();

		// Get Default Fonts from settings.
		$default_options = Gambit_Pro_Customizer::get_default_options();

		// Color Variables.
		$color_variables = '';

		// Check if we are in Customizer Preview.
		$is_customize_preview = is_customize_preview();

		// Set Top Navigation Color.
		if ( $theme_options['top_navi_color'] !== $default_options['top_navi_color'] ) {
			$color_variables .= '--header-bar-background-color: ' . $theme_options['top_navi_color'] . ';';

			// Check if a light background color was chosen.
			if ( self::is_color_light( $theme_options['top_navi_color'] ) ) {
				$color_variables .= '--header-bar-link-color: #151515;';
				$color_variables .= '--header-bar-link-hover-color: rgba(0, 0, 0, 0.5);';
				$color_variables .= '--header-bar-border-color: rgba(0, 0, 0, 0.1);';
			}
		}

		// Set Primary Navigation Color.
		if ( $theme_options['navi_primary_color'] !== $default_options['navi_primary_color'] ) {
			$color_variables .= '--navi-primary-color: ' . $theme_options['navi_primary_color'] . ';';

			// Check if a light background color was chosen.
			if ( self::is_color_light( $theme_options['navi_primary_color'] ) ) {
				$color_variables .= '--navi-primary-text-color: #151515;';
			}
		}

		// Set Secondary Navigation Color.
		if ( $theme_options['navi_secondary_color'] !== $default_options['navi_secondary_color'] ) {
			$color_variables .= '--navi-secondary-color: ' . $theme_options['navi_secondary_color'] . ';';

			// Check if a light background color was chosen.
			if ( self::is_color_light( $theme_options['navi_secondary_color'] ) ) {
				$color_variables .= '--navi-secondary-text-color: #151515;';
				$color_variables .= '--navi-secondary-text-hover-color: rgba(0, 0, 0, 0.5);';
				$color_variables .= '--navi-border-color: rgba(0, 0, 0, 0.1);';
			}
		}

		// Set Primary Content Color.
		if ( $theme_options['content_primary_color'] !== $default_options['content_primary_color'] ) {
			$color_variables .= '--link-color: ' . $theme_options['content_primary_color'] . ';';
			$color_variables .= '--button-color: ' . $theme_options['content_primary_color'] . ';';
			$color_variables .= '--site-title-color: ' . $theme_options['content_primary_color'] . ';';
			$color_variables .= '--title-hover-color: ' . $theme_options['content_primary_color'] . ';';

			// Check if a light background color was chosen.
			if ( self::is_color_light( $theme_options['content_primary_color'] ) ) {
				$color_variables .= '--button-text-color: #151515;';
			}
		}

		// Set Secondary Content Color.
		if ( $theme_options['content_secondary_color'] !== $default_options['content_secondary_color'] ) {
			$color_variables .= '--link-hover-color: ' . $theme_options['content_secondary_color'] . ';';
			$color_variables .= '--button-hover-color: ' . $theme_options['content_secondary_color'] . ';';
			$color_variables .= '--site-title-hover-color: ' . $theme_options['content_secondary_color'] . ';';
			$color_variables .= '--title-color: ' . $theme_options['content_secondary_color'] . ';';

			// Check if a light background color was chosen.
			if ( self::is_color_light( $theme_options['content_secondary_color'] ) ) {
				$color_variables .= '--button-hover-text-color: #151515;';
			}
		}

		// Set Widget Title Color.
		if ( $theme_options['widget_title_color'] !== $default_options['widget_title_color'] ) {
			$color_variables .= '--widget-title-color: ' . $theme_options['widget_title_color'] . ';';

			// Check if a light background color was chosen.
			if ( self::is_color_light( $theme_options['widget_title_color'] ) ) {
				$color_variables .= '--widget-title-text-color: #151515;';
			}
		}

		// Set Footer Color.
		if ( $theme_options['footer_color'] !== $default_options['footer_color'] ) {
			$color_variables .= '--footer-background-color: ' . $theme_options['footer_color'] . ';';

			// Check if a light background color was chosen.
			if ( self::is_color_light( $theme_options['footer_color'] ) ) {
				$color_variables .= '--footer-light-background-color: rgba(0, 0, 0, 0.05);';
				$color_variables .= '--footer-medium-background-color: rgba(0, 0, 0, 0.15);';
				$color_variables .= '--footer-text-color: #151515;';
				$color_variables .= '--footer-link-color: #151515;';
				$color_variables .= '--footer-link-hover-color: rgba(0, 0, 0, 0.5);';
			}
		}

		// Set Color Variables.
		if ( '' !== $color_variables ) {
			$custom_css .= ':root {' . $color_variables . '}';
		}

		return $custom_css;
	}

	/**
	 * Adds all color settings in the Customizer
	 *
	 * @param object $wp_customize / Customizer Object.
	 */
	static function color_settings( $wp_customize ) {

		// Add Section for Theme Colors.
		$wp_customize->add_section( 'gambit_pro_section_colors', array(
			'title'    => __( 'Theme Colors', 'gambit-pro' ),
			'priority' => 60,
			'panel'    => 'gambit_options_panel',
		) );

		// Get Default Colors from settings.
		$default_options = Gambit_Pro_Customizer::get_default_options();

		// Add Widget Title Color setting.
		$wp_customize->add_setting( 'gambit_theme_options[top_navi_color]', array(
			'default'           => $default_options['top_navi_color'],
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'gambit_theme_options[top_navi_color]', array(
				'label'    => _x( 'Top Navigation', 'color setting', 'gambit-pro' ),
				'section'  => 'gambit_pro_section_colors',
				'settings' => 'gambit_theme_options[top_navi_color]',
				'priority' => 1,
			)
		) );

		// Add Navigation Primary Color setting.
		$wp_customize->add_setting( 'gambit_theme_options[navi_primary_color]', array(
			'default'           => $default_options['navi_primary_color'],
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'gambit_theme_options[navi_primary_color]', array(
				'label'    => _x( 'Navigation (primary)', 'color setting', 'gambit-pro' ),
				'section'  => 'gambit_pro_section_colors',
				'settings' => 'gambit_theme_options[navi_primary_color]',
				'priority' => 2,
			)
		) );

		// Add Navigation Secondary Color setting.
		$wp_customize->add_setting( 'gambit_theme_options[navi_secondary_color]', array(
			'default'           => $default_options['navi_secondary_color'],
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'gambit_theme_options[navi_secondary_color]', array(
				'label'    => _x( 'Navigation (secondary)', 'color setting', 'gambit-pro' ),
				'section'  => 'gambit_pro_section_colors',
				'settings' => 'gambit_theme_options[navi_secondary_color]',
				'priority' => 3,
			)
		) );

		// Add Post Primary Color setting.
		$wp_customize->add_setting( 'gambit_theme_options[content_primary_color]', array(
			'default'           => $default_options['content_primary_color'],
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'gambit_theme_options[content_primary_color]', array(
				'label'    => _x( 'Content (primary)', 'color setting', 'gambit-pro' ),
				'section'  => 'gambit_pro_section_colors',
				'settings' => 'gambit_theme_options[content_primary_color]',
				'priority' => 4,
			)
		) );

		// Add Link and Button Color setting.
		$wp_customize->add_setting( 'gambit_theme_options[content_secondary_color]', array(
			'default'           => $default_options['content_secondary_color'],
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'gambit_theme_options[content_secondary_color]', array(
				'label'    => _x( 'Content (secondary)', 'color setting', 'gambit-pro' ),
				'section'  => 'gambit_pro_section_colors',
				'settings' => 'gambit_theme_options[content_secondary_color]',
				'priority' => 5,
			)
		) );

		// Add Widget Title Color setting.
		$wp_customize->add_setting( 'gambit_theme_options[widget_title_color]', array(
			'default'           => $default_options['widget_title_color'],
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'gambit_theme_options[widget_title_color]', array(
				'label'    => _x( 'Widget Titles', 'color setting', 'gambit-pro' ),
				'section'  => 'gambit_pro_section_colors',
				'settings' => 'gambit_theme_options[widget_title_color]',
				'priority' => 6,
			)
		) );

		// Add Footer Color setting.
		$wp_customize->add_setting( 'gambit_theme_options[footer_color]', array(
			'default'           => $default_options['footer_color'],
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'gambit_theme_options[footer_color]', array(
				'label'    => _x( 'Footer', 'color setting', 'gambit-pro' ),
				'section'  => 'gambit_pro_section_colors',
				'settings' => 'gambit_theme_options[footer_color]',
				'priority' => 7,
			)
		) );
	}

	/**
	 * Returns color brightness.
	 *
	 * @param int Number of brightness.
	 */
	static function get_color_brightness( $hex_color ) {

		// Remove # string.
		$hex_color = str_replace( '#', '', $hex_color );

		// Convert into RGB.
		$r = hexdec( substr( $hex_color, 0, 2 ) );
		$g = hexdec( substr( $hex_color, 2, 2 ) );
		$b = hexdec( substr( $hex_color, 4, 2 ) );

		return ( ( ( $r * 299 ) + ( $g * 587 ) + ( $b * 114 ) ) / 1000 );
	}

	/**
	 * Check if the color is light.
	 *
	 * @param bool True if color is light.
	 */
	static function is_color_light( $hex_color ) {
		return ( self::get_color_brightness( $hex_color ) > 130 );
	}

	/**
	 * Check if the color is dark.
	 *
	 * @param bool True if color is dark.
	 */
	static function is_color_dark( $hex_color ) {
		return ( self::get_color_brightness( $hex_color ) <= 130 );
	}
}

// Run Class.
add_action( 'init', array( 'Gambit_Pro_Custom_Colors', 'setup' ) );
