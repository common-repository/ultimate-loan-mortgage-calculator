<?php
/**
 * Calculator calculation settings.
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

?>

<section id="calculation-settings" class="ulmc-settings-section">
	<h2 class="ulmc-settings-section-title"><?php esc_html_e( 'Calculation', 'ultimate-loan-mortgage-calculator' ); ?></h2>

	<div id="currency_settings" class="ulmc-settings-group">
		<div class="ulmc-settings-group-title">
			<h3><?php esc_html_e( 'Currency', 'ultimate-loan-mortgage-calculator' ); ?></h3>
		</div>

		<?php
		$currency   = $ulmc->get_option( 'currency' );
		$currencies = $ulmc->get_currencies();
		?>
		<div class="ulmc-settings-group-content">
			<select id="ulmc_currency_select" name="ulmc_options[currency]">
				<?php
				foreach ( $currencies as $key => $value ) :
					?>
					<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $key, $currency, true ); ?>><?php echo esc_html( $value['name'] ) . ' (' . esc_html( $value['symbol'] ) . ')'; ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>

	<div id="date_format_settings" class="ulmc-settings-group">
		<div class="ulmc-settings-group-title">
			<h3><?php esc_html_e( 'Date Format', 'ultimate-loan-mortgage-calculator' ); ?></h3>
		</div>

		<?php
		$date_format  = $ulmc->get_option( 'date_format' );
		$date_formats = $ulmc->get_default_date_formats();
		?>
		<div class="ulmc-settings-group-content">
			<select id="ulmc_date_format" name="ulmc_options[date_format]">
				<?php
				foreach ( $date_formats as $key => $value ) :
					?>
					<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $key, $date_format, true ); ?>><?php echo esc_html( $value ); ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>

	<div class="ulmc-settings-group">
		<?php $default_loan_balance = $ulmc->get_option( 'default_loan_balance' ); ?>

		<div class="ulmc-settings-group-title">
			<h3><?php esc_html_e( 'Default Loan Balance', 'ultimate-loan-mortgage-calculator' ); ?></h3>
		</div>
		<input name="ulmc_options[default_loan_balance]" type="number" min="0" value="<?php echo esc_attr( $default_loan_balance ); ?>" >
	</div>

	<div class="ulmc-settings-group">
		<?php $default_interest_rate = $ulmc->get_option( 'default_interest_rate' ); ?>

		<div class="ulmc-settings-group-title">
			<h3><?php esc_html_e( 'Default Interest Rate', 'ultimate-loan-mortgage-calculator' ); ?></h3>
		</div>
		<input name="ulmc_options[default_interest_rate]" type="number" step="0.01" min="0" value="<?php echo esc_attr( $default_interest_rate ); ?>">

	</div>

	<div class="ulmc-settings-group">
		<?php
		$show_down_payment    = $ulmc->get_option( 'down_payment' );
		$default_down_payment = $ulmc->get_option( 'default_down_payment' );
		?>

		<div class="ulmc-settings-group-title">
			<h3><?php esc_html_e( 'Default Down Payment', 'ultimate-loan-mortgage-calculator' ); ?></h3>
		</div>

		<label class="ulmc-checkbox">
			<input type="checkbox" name="ulmc_options[down_payment]" value="show" <?php checked( 'show', $show_down_payment ); ?>>
			<span><?php esc_html_e( 'Show Down Payment', 'ultimate-loan-mortgage-calculator' ); ?></span>
		</label>
		<div id="down_payment_settings" style="<?php echo 'show' === $show_down_payment ? '' : 'display:none;'; ?>">
			<input name="ulmc_options[default_down_payment]" type="number" step="1" min="0" value="<?php echo esc_attr( $default_down_payment ); ?>">
		</div>

	</div>

	<div class="ulmc-settings-submit">
		<?php echo esc_html( submit_button( null, 'ulmc-submit', 'publish', true, array( 'id' => 'publish' ) ) ); ?>
	</div>

</section>
