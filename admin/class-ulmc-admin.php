<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://belovdigital.agency
 * @since      1.0.0
 *
 * @package    ultimate-loan-mortgage-calculator
 * @subpackage ULMC/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    ultimate-loan-mortgage-calculator
 * @subpackage ULMC/admin
 */
class ULMC_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}


	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 *
	 * @param string $hook Hook name.
	 */
	public function enqueue_styles( $hook ) {
		if ( 'toplevel_page_' . $this->plugin_name !== $hook ) {
			return;
		}
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ulmc-admin.min.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 *
	 * @param string $hook Hook name.
	 */
	public function enqueue_scripts( $hook ) {
		if ( 'toplevel_page_' . $this->plugin_name !== $hook ) {
			return;
		}
		wp_enqueue_script( 'underscore' );
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_script( $this->plugin_name . '-vendor', plugin_dir_url( __FILE__ ) . 'js/ulmc-vendor.min.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ulmc-admin.min.js', array( 'jquery' ), $this->version, true );

		wp_localize_script(
			$this->plugin_name,
			'ulmc_vars',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'i18n'    => array(
					'copied'        => __( 'Copied!', 'ultimate-loan-mortgage-calculator' ),
					'copyShortcode' => __( 'Copy shortcode', 'ultimate-loan-mortgage-calculator' ),
				),

			)
		);
	}

	/**
	 * Add plugin settings page.
	 *
	 * @since    1.0.0
	 */
	public function add_settings_page() {
		add_menu_page(
			__( 'Ultimate Loan & Mortgage Calculator', 'ultimate-loan-mortgage-calculator' ),
			__( 'Loan & Mortgage', 'ultimate-loan-mortgage-calculator' ),
			'manage_options',
			$this->plugin_name,
			array( $this, 'settings_page_callback' ),
			'dashicons-calculator',
			null
		);
	}

	/**
	 * Register plugin settings.
	 *
	 * @since    1.0.0
	 */
	public function register_settings() {
		register_setting( 'ulmc-settings-group', 'ulmc_options', array( $this, 'sanitize_options' ) );
	}

	/**
	 * Sanitize plugin settings.
	 *
	 * @since    1.0.0
	 *
	 * @param array $input Form Input.
	 */
	public function sanitize_options( $input ) {
		$all_options = array(
			'title_show',
			'title_text',
			'notification_email',
			'primary_color',
			'font_size',
			'user_agreements',
			'privacy_policy',
			'privacy_policy_url',
			'privacy_policy_url_text',
			'terms_and_conditions',
			'terms_and_conditions_url',
			'terms_and_conditions_url_text',
			'user_agreements_text',
			'currency',
			'date_format',
			'default_loan_balance',
			'default_interest_rate',
			'down_payment',
			'default_down_payment',
		);

		$switch_options = array(
			'title_show',
			'privacy_policy',
			'user_agreements',
			'terms_and_conditions',
		);

		$sanitized_input = array();

		foreach ( $all_options as $option ) {
			if ( in_array( $option, $switch_options, true ) ) {
				$sanitized_input[ $option ] = isset( $input[ $option ] ) ? 'show' : 'hide';
			} else {
				if ( isset( $input[ $option ] ) && '' !== $input[ $option ] ) {
					$sanitized_input[ $option ] = sanitize_text_field( $input[ $option ] );
				} elseif ( isset( $input[ $option ] ) && '' === $input[ $option ] ) {
					$sanitized_input[ $option ] = 'empty';
				} else {
					$sanitized_input[ $option ] = '';
				}
			}
		}

		return $sanitized_input;
	}

	/**
	 * Plugin settings page markup.
	 *
	 * @since    1.0.0
	 */
	public function settings_page_callback() {
		ob_start();
		include 'partials/admin-display.php';
		echo ob_get_clean(); //phpcs:ignore.
	}

	/**
	 * Plugin settings link.
	 *
	 * @since    1.0.0
	 *
	 * @param array $links Links.
	 */
	public function plugin_settings_link( $links ) {
		$settings_link = '<a href="admin.php?page=ultimate-loan-mortgage-calculator">' . __( 'Settings', 'ultimate-loan-mortgage-calculator' ) . '</a>';
		array_unshift( $links, $settings_link );
		return $links;
	}
}
