<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://belovdigital.agency
 * @since      1.0.0
 *
 * @package    ultimate-loan-mortgage-calculator
 * @subpackage ULMC/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$ulmc = new ULMC();
?>

<form method="post" action="options.php" novalidate>
	<?php settings_fields( 'ulmc-settings-group' ); ?>

	<div class="ulmc-settings">

		<div class="ulmc-settings-wrapper">

			<div class="ulmc-settings-content">
				<div class="ulmc-settings-header">
					<?php wp_nonce_field( 'ulmc-nonce', 'ulmc_nonce' ); ?>

					<h1 class="ulmc-settings-header-title"><?php echo esc_html( get_admin_page_title() ); ?></h1>

					<div class="ulmc-description">
						<p><?php esc_html_e( '1. Choose the settings you\'d like to use for this specified instance of the shortcode on your website (widget, a particular page, or something else).', 'ultimate-loan-mortgage-calculator' ); ?><br>
						<?php esc_html_e( '2. Copy the shortcode and paste it wherever you need.', 'ultimate-loan-mortgage-calculator' ); ?></p>
					</div>
					<div class="ulmc-shortcode-mob"></div>				

				</div>

				<div class="ulmc-settings-tabs">

					<?php require 'navigation.php'; ?>

					<div class="ulmc-settings-tabs-wrapper">

						<?php
						require 'main-settings.php';
						require 'calculation-settings.php';
						require 'style-settings.php';
						?>

					</div>

				</div>
			</div>

			<div class="ulmc-settings-sidebar">
			</div>
		</div>
	</div>
</form>
