<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://belovdigital.agency
 * @since      1.0.0
 *
 * @package    ultimate-loan-mortgage-calculator
 * @subpackage ultimate-loan-mortgage-calculator/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 */
class ULMC_Public {

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
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_register_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ulmc-public.min.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_register_script( $this->plugin_name . '-vendor', plugin_dir_url( __FILE__ ) . 'js/ulmc-vendor.min.js', array( 'jquery' ), $this->version, true );
		wp_register_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ulmc-public.min.js', array( 'jquery' ), $this->version, true );

		wp_localize_script(
			$this->plugin_name,
			'ulmc_vars',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'i18n'    => array(
					'emailSendSuccess'       => __( 'Ultimate Loan & Mortgage Calculator results have been successfully sent to your email address!', 'ultimate-loan-mortgage-calculator' ),
					'emailSendFail'          => __( 'An error has occurred.', 'ultimate-loan-mortgage-calculator' ),
					'emptyFields'            => __( 'Please, fill in all fields correctly.', 'ultimate-loan-mortgage-calculator' ),
					'acceptanceMessage'      => __( 'Please accept our Privacy Policy and Terms & Conditions to proceed.', 'ultimate-loan-mortgage-calculator' ),
					'invalidFields'          => __( 'Check that the fields are filled in correctly.', 'ultimate-loan-mortgage-calculator' ),
					'emptyRequiredFields'    => __( 'Please, fill out the required fields of the form.', 'ultimate-loan-mortgage-calculator' ),
					'showScheduleButtonText' => __( 'Show Amortization Schedule', 'ultimate-loan-mortgage-calculator' ),
					'hideScheduleButtonText' => __( 'Hide Amortization Schedule', 'ultimate-loan-mortgage-calculator' ),
				),
			)
		);
	}

	/**
	 * Shortcode callback function.
	 *
	 * @since    1.0.0
	 * @return   string    html markup of calculator.
	 */
	public function ulmc_shortcode_callback() {
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-datepicker' );

		wp_enqueue_style( $this->plugin_name );
		wp_enqueue_script( $this->plugin_name . '-vendor' );
		wp_enqueue_script( $this->plugin_name );

		ob_start();
		include 'partials/public-display.php';
		return ob_get_clean();
	}


	/**
	 * Ajax handler for sending the result to email.
	 *
	 * @since    1.0.0
	 */
	public function ajax_send_result_on_email() {
		$server_response = array();
		// Nonce verification.
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'ulmc-nonce' ) ) {
			wp_send_json_error( __( 'Nonce verification failed', 'ultimate-loan-mortgage-calculator' ) );
			die();
		}

		// Input data.
		$user_email  = isset( $_POST['user_email'] ) ? sanitize_text_field( wp_unslash( $_POST['user_email'] ) ) : '';
		$result_data = isset( $_POST['data'] ) ? wp_kses_post( wp_unslash( $_POST['data'] ) ) : '';

		if ( $result_data ) {
			$result_data = (array) json_decode( $result_data );
		}

		$ulmc               = new ULMC();
		$notification_email = $ulmc->get_option( 'notification_email' );

		$email_user_subject  = $ulmc->get_option( 'email_user_subject' );
		$email_user_body     = $ulmc->get_option( 'email_user_body' );
		$email_user_body     = $this->replace_params_for_user_data( $email_user_body, $result_data, $user_email );
		$email_admin_subject = $ulmc->get_option( 'email_admin_subject' );
		$email_admin_body    = $ulmc->get_option( 'email_admin_body' );
		$email_admin_body    = $this->replace_params_for_user_data( $email_admin_body, $result_data, $user_email );

		// Headers.
		$headers    = array();
		$sitename   = wp_parse_url( network_home_url(), PHP_URL_HOST );
		$from_name  = get_bloginfo( 'name' );
		$reply_to   = get_bloginfo( 'admin_email' );
		$from_email = 'notification@';

		if ( null !== $sitename ) {
			if ( str_starts_with( $sitename, 'www.' ) ) {
				$sitename = substr( $sitename, 4 );
			}

			$from_email .= $sitename;
		}
		$headers['From']         = 'From: "' . wp_strip_all_tags( $from_name, true ) . '" <' . $from_email . '>';
		$headers['Reply-To']     = "Reply-To: {$reply_to}";
		$headers['Content-type'] = 'Content-type: text/html; charset=utf-8';

		$server_response['user_email_sent']         = wp_mail( $user_email, $email_user_subject, $email_user_body, $headers );
		$server_response['notification_email_sent'] = wp_mail( $notification_email, $email_admin_subject, $email_admin_body, $headers );

		if ( $server_response['user_email_sent'] ) {
			$server_response['success_message'] = __( 'Thank you for your submission. Ultimate Loan & Mortgage Calculator results have been successfully sent to your email address!', 'ultimate-loan-mortgage-calculator' );
		} else {
			wp_send_json_error( __( 'There was a problem while sending the email', 'ultimate-loan-mortgage-calculator' ) );
		}

		wp_send_json_success( $server_response );
		die();
	}

	/**
	 * Replaces the user text parameters from the email template with the actual user data.
	 *
	 * @param string $text Text with params.
	 * @param array  $result Calculation result.
	 * @param string $user_email User Email.
	 */
	private function replace_params_for_user_data( $text, $result, $user_email ) {
		$text_replaced = $text;

		$params_from_template = array(
			'loan_balance',
			'currency',
			'interest_rate',
			'loan_term_years',
			'loan_term_months',
			'payment_frequency',
			'number_of_payments',
			'payment_amount',
			'total_cost',
			'total_interest',
			'schedule',
		);

		if ( str_contains( $text_replaced, '{user_email}' ) ) {
			$text_replaced = str_replace( '{user_email}', $user_email, $text_replaced );
		}

		foreach ( $params_from_template as $param ) {

			if ( isset( $result[ $param ] ) && str_contains( $text_replaced, '{' . $param . '}' ) ) {

				switch ( $param ) {

					case 'loan_term_years':
						// translators: Term Year/Years.
						$text_replaced = str_replace( '{loan_term_years}', sprintf( _n( '%s year', '%s years', $result[ $param ], 'ultimate-loan-mortgage-calculator' ), $result[ $param ] ), $text_replaced );
						break;
					case 'loan_term_months':
						// translators: Term Month/Months.
						$text_replaced = str_replace( '{loan_term_months}', sprintf( _n( '%s month', '%s months', $result[ $param ], 'ultimate-loan-mortgage-calculator' ), $result[ $param ] ), $text_replaced );
						break;
					case 'schedule':
						$schedule_replaced = str_replace( '<td>', '<td style="border: 1px solid #a1a1a1;">', $result['schedule'] );

						$schedule_html  = '<table border="1" cellpadding="5" cellspacing="0" style="border: 1px solid #a1a1a1;">';
						$schedule_html .= '<thead><tr>';
						$schedule_html .= '<th style="border: 1px solid #a1a1a1;background-color:#d6d6d6;font-weight:bold;">' . esc_html__( 'Period', 'ultimate-loan-mortgage-calculator' ) . '</th>';
						$schedule_html .= '<th style="border: 1px solid #a1a1a1;background-color:#d6d6d6;font-weight:bold;">' . esc_html__( 'Date Payment', 'ultimate-loan-mortgage-calculator' ) . '</th>';
						$schedule_html .= '<th style="border: 1px solid #a1a1a1;background-color:#d6d6d6;font-weight:bold;">' . esc_html__( 'Opening Balance', 'ultimate-loan-mortgage-calculator' ) . '</th>';
						$schedule_html .= '<th style="border: 1px solid #a1a1a1;background-color:#d6d6d6;font-weight:bold;">' . ucfirst( esc_html( $result['payment_frequency'] ) ) . ' ' . esc_html__( 'Principal', 'ultimate-loan-mortgage-calculator' ) . '</th>';
						$schedule_html .= '<th style="border: 1px solid #a1a1a1;background-color:#d6d6d6;font-weight:bold;">' . ucfirst( esc_html( $result['payment_frequency'] ) ) . ' ' . esc_html__( 'Interest', 'ultimate-loan-mortgage-calculator' ) . '</th>';
						$schedule_html .= '<th style="border: 1px solid #a1a1a1;background-color:#d6d6d6;font-weight:bold;">' . esc_html__( 'Closing Balance', 'ultimate-loan-mortgage-calculator' ) . '</th>';
						$schedule_html .= '</tr></thead>';
						$schedule_html .= '<tbody>';
						$schedule_html .= wp_kses_post( $schedule_replaced );
						$schedule_html .= '</tbody>';
						$schedule_html .= '</table>';

						$text_replaced = str_replace( '{schedule}', $schedule_html, $text_replaced );
						break;
					default:
						$text_replaced = str_replace( '{' . $param . '}', $result[ $param ], $text_replaced );
				}
			}
		}

		return $text_replaced;
	}


}
