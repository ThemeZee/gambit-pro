<?php
/**
 * Footer Line
 *
 * Displays credit link and footer text based on theme options
 * Registers and displays footer navigation
 *
 * @package Gambit Pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Footer Line Class
 */
class Gambit_Pro_Footer_Line {

	/**
	 * Footer Line Setup
	 *
	 * @return void
	 */
	static function setup() {

		// Return early if Gambit Theme is not active.
		if ( ! current_theme_supports( 'gambit-pro' ) ) {
			return;
		}

		// Display footer navigation.
		add_action( 'gambit_before_footer', array( __CLASS__, 'display_footer_navigation' ), 40 );

		// Remove default footer text function and replace it with new one.
		remove_action( 'gambit_footer_text', 'gambit_footer_text' );
		add_action( 'gambit_footer_text', array( __CLASS__, 'display_footer_text' ) );

		// Display social icons in footer.
		add_action( 'gambit_footer_menu', array( __CLASS__, 'display_footer_social_menu' ) );

		// Add Footer Settings in Customizer.
		add_action( 'customize_register', array( __CLASS__, 'footer_settings' ) );

	}

	/**
	 * Display footer navigation menu
	 *
	 * @return void
	 */
	static function display_footer_navigation() {

		// Check if there is a footer menu.
		if ( has_nav_menu( 'footer' ) ) {

			echo '<div id="footer-navigation-wrap" class="footer-navigation-wrap">';

				echo '<div id="footer-navigation-bg" class="footer-navigation-background">';

					echo '<nav id="footer-navigation" class="footer-navigation navigation container clearfix" role="navigation">';

						echo '<span class="today">' . date_i18n( get_option( 'date_format' ), current_time( 'timestamp' ) ) . ' / ' . date_i18n( get_option( 'time_format' ), current_time( 'timestamp' ) ) . '</span>';

						wp_nav_menu( array(
							'theme_location' => 'footer',
							'container' => false,
							'menu_class' => 'footer-navigation-menu',
							'echo' => true,
							'fallback_cb' => '',
							'depth' => 1,
							)
						);

					echo '</nav>';

				echo '</div>';

			echo '</div><!-- #footer-navigation-wrap -->';

		}

	}

	/**
	 * Displays Credit Link and user defined Footer Text based on theme settings.
	 *
	 * @return void
	 */
	static function display_footer_text() {

		// Get Theme Options from Database.
		$theme_options = Gambit_Pro_Customizer::get_theme_options();

		// Display Footer Text.
		if ( '' !== $theme_options['footer_text'] ) :

			echo do_shortcode( wp_kses_post( $theme_options['footer_text'] ) );

		endif;

		// Call Credit Link function of theme if credit link is activated.
		if ( true == $theme_options['credit_link'] ) :

			if ( function_exists( 'gambit_footer_text' ) ) :

				gambit_footer_text();

			endif;

		endif;

	}

	/**
	 * Display social icons in footer
	 *
	 * @return void
	 */
	static function display_footer_social_menu() {

		// Check if there is a social menu.
		if ( has_nav_menu( 'footer-social' ) ) {

			echo '<div id="footer-social-icons" class="footer-social-icons social-icons-navigation clearfix">';

			// Display Social Icons Menu.
			wp_nav_menu( array(
				'theme_location' => 'footer-social',
				'container' => false,
				'menu_class' => 'social-icons-menu',
				'echo' => true,
				'fallback_cb' => '',
				'link_before' => '<span class="screen-reader-text">',
				'link_after' => '</span>',
				'depth' => 1,
				)
			);

			echo '</div>';

		}

	}

	/**
	 * Adds footer text and credit link setting
	 *
	 * @param object $wp_customize / Customizer Object.
	 */
	static function footer_settings( $wp_customize ) {

		// Add Sections for Footer Settings.
		$wp_customize->add_section( 'gambit_pro_section_footer', array(
			'title'    => __( 'Footer Settings', 'gambit-pro' ),
			'priority' => 90,
			'panel' => 'gambit_options_panel',
			)
		);

		// Add Footer Text setting.
		$wp_customize->add_setting( 'gambit_theme_options[footer_text]', array(
			'default'           => '',
			'type'           	=> 'option',
			'transport'         => 'refresh',
			'sanitize_callback' => array( __CLASS__, 'sanitize_footer_text' ),
			)
		);
		$wp_customize->add_control( 'gambit_theme_options[footer_text]', array(
			'label'    => __( 'Footer Text', 'gambit-pro' ),
			'section'  => 'gambit_pro_section_footer',
			'settings' => 'gambit_theme_options[footer_text]',
			'type'     => 'textarea',
			'priority' => 30,
			)
		);

		// Add Credit Link setting.
		$wp_customize->add_setting( 'gambit_theme_options[credit_link]', array(
			'default'           => true,
			'type'           	=> 'option',
			'transport'         => 'refresh',
			'sanitize_callback' => 'gambit_sanitize_checkbox',
			)
		);
		$wp_customize->add_control( 'gambit_theme_options[credit_link]', array(
			'label'    => __( 'Display Credit Link to ThemeZee on footer line', 'gambit-pro' ),
			'section'  => 'gambit_pro_section_footer',
			'settings' => 'gambit_theme_options[credit_link]',
			'type'     => 'checkbox',
			'priority' => 40,
			)
		);

	}

	/**
	 *  Sanitize footer content textarea
	 *
	 * @param String $value / Value of the setting.
	 * @return string
	 */
	static function sanitize_footer_text( $value ) {

		if ( current_user_can( 'unfiltered_html' ) ) :
			return $value;
		else :
			return stripslashes( wp_filter_post_kses( addslashes( $value ) ) );
		endif;
	}

	/**
	 * Register footer navigation menu
	 *
	 * @return void
	 */
	static function register_footer_menu() {

		// Return early if Gambit Theme is not active.
		if ( ! current_theme_supports( 'gambit-pro' ) ) {
			return;
		}

		register_nav_menus( array(
			'footer' => esc_html__( 'Footer Navigation', 'gambit-pro' ),
			'footer-social' => esc_html__( 'Footer Social Icons', 'gambit-pro' ),
		) );

	}
}

// Run Class.
add_action( 'init', array( 'Gambit_Pro_Footer_Line', 'setup' ) );

// Register footer navigation in backend.
add_action( 'after_setup_theme', array( 'Gambit_Pro_Footer_Line', 'register_footer_menu' ), 30 );
