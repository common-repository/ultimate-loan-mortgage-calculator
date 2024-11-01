<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://belovdigital.agency
 * @since      1.0.0
 *
 * @package    ultimate-loan-mortgage-calculator
 * @subpackage ultimate-loan-mortgage-calculator/includes
 */

/**
 * The core plugin class.
 */
class ULMC {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @var      ULMC_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * Plugin options.
	 *
	 * @since    1.0.0
	 * @var      array    $plugin_options  The plugin options.
	 */
	protected $plugin_options;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'ULMC_VERSION' ) ) {
			$this->version = ULMC_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name    = ULMC_PLUGIN_NAME;
		$this->plugin_options = get_option( 'ulmc_options' );

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - ULMC_Loader. Orchestrates the hooks of the plugin.
	 * - ULMC_Admin. Defines all hooks for the admin area.
	 * - ULMC_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ulmc-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ulmc-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-ulmc-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-ulmc-public.php';

		$this->loader = new ULMC_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Plugin_Name_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.3
	 */
	private function set_locale() {

		$plugin_i18n = new ULMC_I18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 */
	private function define_admin_hooks() {

		$plugin_admin = new ULMC_Admin( $this->get_plugin_name(), $this->get_version() );
		$plugin_file  = ULMC_PLUGIN_FILE;

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_settings_page' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'register_settings' );
		$this->loader->add_action( 'wp_ajax_change_color_schema', $this, 'ajax_change_color_schema' );
		$this->loader->add_action( 'wp_ajax_nopriv_change_color_schema', $this, 'ajax_change_color_schema' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 */
	private function define_public_hooks() {

		$plugin_public = new ULMC_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'wp_ajax_ulmc_send_result', $plugin_public, 'ajax_send_result_on_email' );
		$this->loader->add_action( 'wp_ajax_nopriv_ulmc_send_result', $plugin_public, 'ajax_send_result_on_email' );
		add_shortcode( 'ultimate-loan-mortgage-calculator', array( $plugin_public, 'ulmc_shortcode_callback' ) );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    ULMC_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Increases or decreases the brightness of a color by a percentage of the current brightness.
	 *
	 * @param   string $hex_code        Supported formats: `#FFF`, `#FFFFFF`, `FFF`, `FFFFFF`.
	 * @param   float  $adjust_percent  A number between -1 and 1. E.g. 0.3 = 30% lighter; -0.4 = 40% darker.
	 *
	 * @since     1.0.0
	 * @return  string
	 */
	public function adjust_brightness( $hex_code, $adjust_percent ) {
		$hex_code = ltrim( $hex_code, '#' );

		if ( 3 === strlen( $hex_code ) ) {
			$hex_code = $hex_code[0] . $hex_code[0] . $hex_code[1] . $hex_code[1] . $hex_code[2] . $hex_code[2];
		}

		$hex_code = array_map( 'hexdec', str_split( $hex_code, 2 ) );

		foreach ( $hex_code as & $color ) :
			$adjustable_limit = $adjust_percent < 0 ? $color : 255 - $color;
			$adjust_amount    = ceil( $adjustable_limit * $adjust_percent );

			$color = str_pad( dechex( $color + $adjust_amount ), 2, '0', STR_PAD_LEFT );
		endforeach;

		return '#' . implode( $hex_code );
	}


	/**
	 * Get brightness adjustment coefficient based on the initial color.
	 *
	 * @param string $hex_code Supported formats: `#FFF`, `#FFFFFF`, `FFF`, `FFFFFF`.
	 * @param float  $adjust_percent A number between -1 and 1. E.g. 0.3 = 30% lighter; -0.4 = 40% darker.
	 * @return float Coefficient for brightness adjustment.
	 */
	public function adjust_brightness_by_percent( $hex_code, $adjust_percent ) {
		$hex_code = ltrim( $hex_code, '#' );
		if ( 3 === strlen( $hex_code ) ) {
			$hex_code = $hex_code[0] . $hex_code[0] . $hex_code[1] . $hex_code[1] . $hex_code[2] . $hex_code[2];
		}

		$rgb = array_map( 'hexdec', str_split( $hex_code, 2 ) );

		if ( ! $rgb[0] ) {
			return $hex_code;
		}

		// Calculate the brightness using the formula: 0.299*R + 0.587*G + 0.114*B.
		$brightness = 0.299 * $rgb[0] + 0.587 * $rgb[1] + 0.114 * $rgb[2];

		$adjust_percent = $brightness < 128 ? $adjust_percent : 0 - $adjust_percent;

		$hex_code = array_map( 'hexdec', str_split( $hex_code, 2 ) );

		foreach ( $hex_code as & $color ) :
			$adjustable_limit = $adjust_percent < 0 ? $color : 255 - $color;
			$adjust_amount    = ceil( $adjustable_limit * $adjust_percent );

			$color = str_pad( dechex( $color + $adjust_amount ), 2, '0', STR_PAD_LEFT );
		endforeach;

		return '#' . implode( $hex_code );
	}

	/**
	 * Get Calculator option by name.
	 *
	 * @param   string $name    Option name.
	 *
	 * @since    1.0.0
	 */
	public function get_option( $name ) {
		$default_options = $this->get_default_values();

		if ( isset( $this->plugin_options[ $name ] ) ) {

			if ( 'empty' === $this->plugin_options[ $name ] ) {
				return '';
			}

			return $this->plugin_options[ $name ];
		}

		return isset( $default_options[ $name ] ) ? $default_options[ $name ] : '';
	}

	/**
	 * Calculator default values.
	 *
	 * @since  1.0.0
	 */
	public function get_default_values() {
		$values = array(
			'title_show'                    => 'show',
			'title_text'                    => __( 'Calculate Your Loan / Mortgage Payments', 'ultimate-loan-mortgage-calculator' ),
			'notification_email'            => get_option( 'admin_email' ),
			'primary_color'                 => '#325878',
			'secondary_color'               => '#4989BE',
			'style_theme'                   => 'minimal',
			'email_user_subject'            => __( 'Your loan payments', 'ultimate-loan-mortgage-calculator' ),
			'email_user_body'               => $this->get_user_notification_body(),
			'email_admin_subject'           => __( 'New Ultimate Loan & Mortgage Calculator user', 'ultimate-loan-mortgage-calculator' ),
			'email_admin_body'              => $this->get_admin_notification_body(),
			'privacy_policy_url_text'       => __( 'Privacy Policy', 'ultimate-loan-mortgage-calculator' ),
			'terms_and_conditions_url_text' => __( 'Terms and Conditions', 'ultimate-loan-mortgage-calculator' ),
			'user_agreements_text'          => __( 'Please accept our {privacy_policy} and {terms_and_conditions} to proceed.', 'ultimate-loan-mortgage-calculator' ),
			'currency'                      => 'USD',
			'font_size'                     => '16px',
			'date_format'                   => 'dd MM yy',
			'default_loan_balance'          => '10000',
			'default_interest_rate'         => '5',
			'default_down_payment'          => '0',
		);

		return $values;
	}

	/**
	 * Calculator date formats.
	 *
	 * @since    1.0.0
	 */
	public function get_default_date_formats() {
		$date_formats = array(
			'dd MM yy' => 'dd MM yy - ' . gmdate( 'd F Y' ),
			'mm/dd/yy' => 'mm/dd/yy - ' . gmdate( 'm/d/Y' ),
			'dd/mm/yy' => 'dd/mm/yy - ' . gmdate( 'd/m/Y' ),
			'yy-mm-dd' => 'yy-mm-dd - ' . gmdate( 'Y-m-d' ),
			'dd.mm.yy' => 'dd.mm.yy - ' . gmdate( 'd.m.Y' ),
		);
		return $date_formats;
	}

	/**
	 * Calculator layouts colors.
	 *
	 * @param   string $main_color        Supported formats: `#FFF`, `#FFFFFF`.
	 * @param   string $primary_color     Supported formats: `#FFF`, `#FFFFFF`.
	 *
	 * @since    1.0.0
	 */
	public function get_default_colors( $main_color = '#3E57ED', $primary_color = '#141414' ) {

		$layouts_colors = array(
			'minimal' => array(
				'primary-color'          => array(
					'name'          => __( 'Primary color', 'ultimate-loan-mortgage-calculator' ),
					'default_color' => $primary_color,
				),
				'primary-color-300'      => array(
					'name'          => __( 'Primary color 300', 'ultimate-loan-mortgage-calculator' ),
					'default_color' => $this->adjust_brightness_by_percent( $primary_color, 0.3 ),
				),
				'primary-color-500'      => array(
					'name'          => __( 'Primary color 500', 'ultimate-loan-mortgage-calculator' ),
					'default_color' => $this->adjust_brightness_by_percent( $primary_color, 0.5 ),
				),
				'primary-color-700'      => array(
					'name'          => __( 'Primary color 700', 'ultimate-loan-mortgage-calculator' ),
					'default_color' => $this->adjust_brightness_by_percent( $primary_color, 0.75 ),
				),
				'primary-color-800'      => array(
					'name'          => __( 'Primary color 700', 'ultimate-loan-mortgage-calculator' ),
					'default_color' => $this->adjust_brightness_by_percent( $primary_color, 0.87 ),
				),
				'primary-color-900'      => array(
					'name'          => __( 'Primary color 900', 'ultimate-loan-mortgage-calculator' ),
					'default_color' => $this->adjust_brightness_by_percent( $primary_color, 0.95 ),
				),
				'primary-inverted-color' => array(
					'name'          => __( 'Primary Inverted color', 'ultimate-loan-mortgage-calculator' ),
					'default_color' => $this->adjust_brightness_by_percent( $primary_color, 1 ),
				),
				'accent-color'           => array(
					'name'          => __( 'Accent color', 'ultimate-loan-mortgage-calculator' ),
					'default_color' => $main_color,
				),
				'accent-color-100'       => array(
					'name'          => __( 'Accent color 100', 'ultimate-loan-mortgage-calculator' ),
					'default_color' => $this->adjust_brightness_by_percent( $main_color, 0.1 ),
				),
				'accent-color-300'       => array(
					'name'          => __( 'Accent color 300', 'ultimate-loan-mortgage-calculator' ),
					'default_color' => $this->adjust_brightness_by_percent( $main_color, 0.3 ),
				),
				'accent-color-900'       => array(
					'name'          => __( 'Accent color 800', 'ultimate-loan-mortgage-calculator' ),
					'default_color' => $this->adjust_brightness_by_percent( $main_color, 0.8 ),
				),
				'accent-inverted-color'  => array(
					'name'          => __( 'Accent Inverted color', 'ultimate-loan-mortgage-calculator' ),
					'default_color' => $this->adjust_brightness_by_percent( $main_color, 1 ),
				),

			),
		);

		return $layouts_colors;
	}

	/**
	 * Calculator font sizes.
	 *
	 * @since    1.0.0
	 */
	public function get_font_sizes() {
		$font_sizes = array(
			array(
				'name'  => esc_html__( 'Small', 'ultimate-loan-mortgage-calculator' ),
				'value' => '14px',
			),
			array(
				'name'  => esc_html__( 'Normal', 'ultimate-loan-mortgage-calculator' ),
				'value' => '16px',
			),
			array(
				'name'  => esc_html__( 'Large', 'ultimate-loan-mortgage-calculator' ),
				'value' => '18px',
			),
			array(
				'name'  => esc_html__( 'Extra Large', 'ultimate-loan-mortgage-calculator' ),
				'value' => '20px',
			),
		);

		return $font_sizes;
	}


	/**
	 * User notification body text.
	 *
	 * @since    1.0.0
	 */
	public function get_user_notification_body() {
		$body  = esc_html__( 'Hi!', 'ultimate-loan-mortgage-calculator' ) . '</br>';
		$body .= esc_html__( 'Looks like you requested your loan payments.', 'ultimate-loan-mortgage-calculator' ) . '</br></br>';

		$body .= '<strong>' . esc_html__( 'Loan Balance', 'ultimate-loan-mortgage-calculator' ) . ': </strong> {loan_balance}</br>';
		$body .= '<strong>' . esc_html__( 'Interest Rate', 'ultimate-loan-mortgage-calculator' ) . ': </strong> {interest_rate}%</br>';
		$body .= '<strong>' . esc_html__( 'Loan Term', 'ultimate-loan-mortgage-calculator' ) . ': </strong> {loan_term_years} {loan_term_months}</br>';
		$body .= '<strong>' . esc_html__( 'Payment frequency', 'ultimate-loan-mortgage-calculator' ) . ': </strong> {payment_frequency}</br>';
		$body .= '<strong>' . esc_html__( 'Number of payments', 'ultimate-loan-mortgage-calculator' ) . ': </strong> {number_of_payments}</br>';
		$body .= '<strong>' . esc_html__( 'Payment Amount', 'ultimate-loan-mortgage-calculator' ) . ': </strong> {payment_amount}</br>';
		$body .= '<strong>' . esc_html__( 'Total payment', 'ultimate-loan-mortgage-calculator' ) . ': </strong> {total_cost}</br>';
		$body .= '<strong>' . esc_html__( 'Total Interest', 'ultimate-loan-mortgage-calculator' ) . ': </strong> {total_interest}</br></br>';

		$body .= '<strong>' . esc_html__( 'Amortization Schedule:', 'ultimate-loan-mortgage-calculator' ) . '</strong></br></br>';
		$body .= '{schedule}</br></br>';
		$body .= esc_html__( 'Best regards,', 'ultimate-loan-mortgage-calculator' ) . "\n";
		$body .= esc_html__( 'Ultimate Loan & Mortgage Calculator', 'ultimate-loan-mortgage-calculator' );

		return $body;
	}

	/**
	 * User notification body text.
	 *
	 * @since    1.0.0
	 */
	public function get_admin_notification_body() {
		$body = esc_html__( 'Hey, someone just shared their email address with you.', 'ultimate-loan-mortgage-calculator' ) . '</br></br>';
		/* translators: %s: user_email */
		$body .= '<strong>' . esc_html__( 'User\'s email', 'ultimate-loan-mortgage-calculator' ) . ': </strong> {user_email}</br></br>';
		$body .= esc_html__( 'Make it the beginning of your brand’s active conversation.', 'ultimate-loan-mortgage-calculator' ) . '</br></br>';
		$body .= esc_html__( 'Best regards,', 'ultimate-loan-mortgage-calculator' ) . '</br>';
		$body .= esc_html__( 'Ultimate Loan & Mortgage Calculator', 'ultimate-loan-mortgage-calculator' );

		return $body;
	}

	/**
	 * Displays the tooltip.
	 *
	 * @since    1.0.0
	 *
	 * @param array $args Tooltip args.
	 */
	public function display_tooltip( $args ) {
		$tooltip_text = $args['text'];
		?>
		<span class="ulmc-tooltip">
			<svg class="ulmc-tooltip-icon" style="width:18px;height:18px">
					<use xlink:href="<?php echo esc_attr( ULMC_PLUGIN_URL . 'public/images/help.svg#help' ); ?>"></use>
			</svg>
			<div class="ulmc-tooltip-text"><?php echo esc_html( $tooltip_text ); ?></div>		
		</span>
		<?php
	}

	/**
	 * Displays the help icon.
	 *
	 * @since    1.0.0
	 *
	 * @param string $help_id Help element ID.
	 */
	public function display_help_open( $help_id ) {
		?>
		<span class="ulmc-note" data-id="<?php echo esc_attr( $help_id ); ?>">
			<svg class="ulmc-note__open" style="width:16px;height:16px">
					<use xlink:href="<?php echo esc_attr( ULMC_PLUGIN_URL . 'public/images/info.svg#info' ); ?>"></use>
			</svg>
		</span>
		<?php
	}

	/**
	 * Displays the help text wrapper.
	 *
	 * @since    1.0.0
	 *
	 * @param array $args Help args.
	 */
	public function display_help_text( $args ) {
		$help_id    = isset( $args['id'] ) ? $args['id'] : '';
		$help_class = isset( $args['class'] ) ? $args['class'] : '';
		$help_text  = isset( $args['text'] ) ? $args['text'] : '';
		?>
		<div class="ulmc-note__content <?php echo esc_attr( $help_class ); ?>" id="<?php echo esc_attr( $help_id ); ?>" style="display:none;">
			<svg class="ulmc-note__close" style="width:10px;height:10px">
					<use xlink:href="<?php echo esc_attr( ULMC_PLUGIN_URL . 'public/images/close.svg#close' ); ?>"></use>
			</svg>
			<div class="ulmc-note__wrapper">
				<?php echo esc_html( $help_text ); ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Displays the info text block.
	 *
	 * @since    1.0.0
	 *
	 * @param array $args Info block args.
	 */
	public function display_info_text( $args ) {
		$info_class = isset( $args['class'] ) ? $args['class'] : '';
		$info_text  = isset( $args['text'] ) ? $args['text'] : '';
		?>
		<div class="ulmc-info <?php echo esc_attr( $info_class ); ?>">
			<svg class="ulmc-info__icon">
					<use xlink:href="<?php echo esc_attr( ULMC_PLUGIN_URL . 'public/images/info.svg#info' ); ?>"></use>
			</svg>
			<div class="ulmc-info__content">
				<?php echo esc_html( $info_text ); ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Get default currencies list.
	 *
	 * @since    1.0.0
	 */
	public function get_currencies() {
		$json_file_path = plugin_dir_path( __FILE__ ) . '/data/currencies.json';

		$data_array = array();

		if ( file_exists( $json_file_path ) ) {
			$json_content = file_get_contents( $json_file_path ); //phpcs:ignore.
			$data_array   = json_decode( $json_content, true );
		}

		return $data_array;
	}

	/**
	 * Get the current currency symbol.
	 *
	 * @since    1.0.0
	 *
	 * @param string $currency_key Currency.
	 */
	public function get_currency_symbol( $currency_key ) {
		$currencies = $this->get_currencies();

		foreach ( $currencies as $key => $currency ) {
			if ( $currency_key === $key ) {
				return $currency['symbolNative'];
			}
		}

		return '';
	}

	/**
	 * Get payment frequencies types.
	 *
	 * @since    1.0.0
	 */
	public function get_payment_frequencies() {
		$payment_frequencies = array(
			'annually'      => 'Annually',
			'semi-annually' => 'Semi-annually',
			'quarterly'     => 'Quarterly',
			'monthly'       => 'Monthly',
			'fortnightly'   => 'Fortnightly',
			'weekly'        => 'Weekly',
		);
		return $payment_frequencies;
	}

	/**
	 * Change color schema.
	 *
	 * @since 1.0.0
	 */
	public function ajax_change_color_schema() {
		// Verify nonce.
		if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ), 'ulmc-nonce' ) ) {
			wp_send_json_error( __( 'Nonce verification failed', 'ultimate-loan-mortgage-calculator' ) );
			wp_die();
		}

		$color_schema = isset( $_POST['ulmc_primary_color'] ) ? sanitize_text_field( wp_unslash( $_POST['ulmc_primary_color'] ) ) : '#325878';

		$new_default_colors = $this->get_default_colors( $color_schema );

		echo wp_json_encode( $new_default_colors );
		wp_die();
	}


	/**
	 * Replaces the user agreements text parameters with the calculator settings data.
	 *
	 * @param string $text Text with params.
	 */
	public function replace_params_for_user_agreements( $text ) {
		$text_replaced = $text;

		if ( str_contains( $text_replaced, '{privacy_policy}' ) ) {
			$privacy_policy_url      = $this->get_option( 'privacy_policy_url' );
			$privacy_policy_url_text = $this->get_option( 'privacy_policy_url_text' );

			$privacy_policy_link = '<a href="' . esc_url( $privacy_policy_url ) . '" target="_blank">' . esc_html( $privacy_policy_url_text ) . '</a>';
			$text_replaced       = str_replace( '{privacy_policy}', $privacy_policy_link, $text_replaced );
		}

		if ( str_contains( $text_replaced, '{terms_and_conditions}' ) ) {
			$terms_and_conditions_url      = $this->get_option( 'terms_and_conditions_url' );
			$terms_and_conditions_url_text = $this->get_option( 'terms_and_conditions_url_text' );

			$terms_and_conditions_link = '<a href="' . esc_url( $terms_and_conditions_url ) . '" target="_blank">' . esc_html( $terms_and_conditions_url_text ) . '</a>';
			$text_replaced             = str_replace( '{terms_and_conditions}', $terms_and_conditions_link, $text_replaced );
		}

		return $text_replaced;
	}

}
