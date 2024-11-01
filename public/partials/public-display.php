<?php
/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://belovdigital.agency
 * @since      1.0.0
 *
 * @package    ultimate-loan-mortgage-calculator
 * @subpackage ultimate-loan-mortgage-calculator/public/partials
 *
 * @global array $atts (input data)
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Shortcode input data.
$ulmc_id     = uniqid( 'ulmc_' );
$ulmc        = new ULMC();
$style_theme = $ulmc->get_option( 'style_theme' );

$font_size      = $ulmc->get_option( 'font_size' );
$primary_color  = $ulmc->get_option( 'primary_color' );
$default_colors = $ulmc->get_default_colors( $primary_color );

foreach ( $default_colors['minimal'] as $name => $color ) {
	$colors_for_css_variables[ str_replace( '_', '-', $name ) ] = $color['default_color'];
}
?>

<div 
	id="<?php echo esc_attr( $ulmc_id ); ?>"
	class="ultimate-loan-mortgage-calculator ulmc-style-theme-<?php echo esc_attr( $style_theme ); ?>" 
	data-colors="<?php echo esc_attr( wp_json_encode( $colors_for_css_variables, JSON_UNESCAPED_UNICODE ) ); ?>"
	data-font-size="<?php echo esc_attr( $font_size ); ?>"
	>

	<?php
	$title_show = $ulmc->get_option( 'title_show' );
	$title_text = $ulmc->get_option( 'title_text' );
	?>
	<h2 class="ulmc-main-title" style="<?php echo 'show' === $title_show ? '' : 'display: none'; ?>">
		<?php echo esc_html( $title_text ); ?>
	</h2>

	<div class="ulmc-wrapper">
		<form class="ulmc-settings">

			<div class="ulmc-settings__wrapper">

				<h3 class="ulmc-settings__title"><?php esc_html_e( 'Main Specifications', 'ultimate-loan-mortgage-calculator' ); ?></h3>

				<div class="ulmc-settings__field">
					<?php
					$loan_balance_id          = 'ulmc_loan_balance_help';
					$default_loan_balance     = $ulmc->get_option( 'default_loan_balance' );
					$default_loan_balanc_step = 100;
					$currency                 = $ulmc->get_option( 'currency' );
					?>

					<div class="ulmc-input ulmc-metric ulmc-input__with-sign">
						<div class="ulmc-input__label-wrapper">
							<label for="ulmc_loan_balance_<?php echo esc_attr( $ulmc_id ); ?>" class="ulmc-input__label"><?php esc_html_e( 'Loan Balance', 'ultimate-loan-mortgage-calculator' ); ?></label>
							<?php $ulmc->display_help_open( $loan_balance_id ); ?>
						</div>
						<div class="ulmc-input__text-wrapper">
							<input id="ulmc_loan_balance_<?php echo esc_attr( $ulmc_id ); ?>" class="ulmc-input__text ulmc_loan_balance" name="ulmc-loan-balance" type="number" value="<?php echo esc_attr( $default_loan_balance ); ?>" min="0" step="<?php echo esc_attr( $default_loan_balanc_step ); ?>">
							<span data-currency="<?php echo esc_html( $currency ); ?>" class="ulmc-input__text-placeholder ulmc_currency_symbol"><?php echo esc_html( $ulmc->get_currency_symbol( $currency ) ); ?></span>
						</div>
					</div>
					<?php
					$ulmc->display_help_text(
						array(
							'id'   => $loan_balance_id,
							'text' => __(
								'Enter the total amount of money you have borrowed or plan to borrow. This is the initial loan amount or the remaining balance if you\'re calculating a current loan',
								'ultimate-loan-mortgage-calculator',
							),
						)
					);
					?>
				</div>

				<div class="ulmc-settings__field">
					<?php
					$interest_rate_id           = 'ulmc_interest_rate_help';
					$default_interest_rate      = $ulmc->get_option( 'default_interest_rate' );
					$default_interest_rate_step = 0.01;
					?>

					<div class="ulmc-input ulmc-metric ulmc-input__with-sign">
						<div class="ulmc-input__label-wrapper">
							<label for="ulmc_interest_rate_<?php echo esc_attr( $ulmc_id ); ?>" class="ulmc-input__label"><?php esc_html_e( 'Interest Rate', 'ultimate-loan-mortgage-calculator' ); ?></label>
							<?php $ulmc->display_help_open( $interest_rate_id ); ?>
						</div>
						<div class="ulmc-input__text-wrapper">
							<input id="ulmc_interest_rate_<?php echo esc_attr( $ulmc_id ); ?>" class="ulmc-input__text ulmc_interest_rate" name="ulmc-interest-rate" type="number" step="<?php echo esc_attr( $default_interest_rate_step ); ?>" min="0" value="<?php echo esc_attr( $default_interest_rate ); ?>">
							<span class="ulmc-input__text-placeholder"><?php esc_html_e( ' % ', 'ultimate-loan-mortgage-calculator' ); ?></span>
						</div>
					</div>

					<?php
					$ulmc->display_help_text(
						array(
							'id'   => $interest_rate_id,
							'text' => __( 'Enter the annual interest rate for your loan, expressed as a percentage. This is the rate at which interest will accrue on the loan balance.', 'ultimate-loan-mortgage-calculator' ),
						)
					);
					?>
				</div>


				<?php
				$show_down_payment = $ulmc->get_option( 'down_payment' );
				if ( 'show' === $show_down_payment ) :
					$down_payment_id           = 'ulmc_down_payment_help';
					$default_down_payment      = $ulmc->get_option( 'default_down_payment' );
					$default_down_payment_step = 100;
					?>
					<div class="ulmc-settings__field">
						<div class="ulmc-input ulmc-metric ulmc-input__with-sign">
							<div class="ulmc-input__label-wrapper">
								<label for="ulmc_down_payment_<?php echo esc_attr( $ulmc_id ); ?>" class="ulmc-input__label"><?php esc_html_e( 'Down Payment', 'ultimate-loan-mortgage-calculator' ); ?></label>
								<?php $ulmc->display_help_open( $down_payment_id ); ?>
							</div>
							<div class="ulmc-input__text-wrapper">
								<input id="ulmc_down_payment_<?php echo esc_attr( $ulmc_id ); ?>" class="ulmc-input__text ulmc_down_payment" name="ulmc-down-payment" type="number" step="<?php echo esc_attr( $default_down_payment_step ); ?>" min="0" value="<?php echo esc_attr( $default_down_payment ); ?>">
								<span class="ulmc-input__text-placeholder"><?php echo esc_html( $ulmc->get_currency_symbol( $currency ) ); ?></span>
							</div>
						</div>

						<?php
						$ulmc->display_help_text(
							array(
								'id'   => $down_payment_id,
								'text' => __( 'Enter the amount of money you have paid as a down payment. This is the initial payment you made to reduce the loan balance.', 'ultimate-loan-mortgage-calculator' ),
							)
						);
						?>
					</div>
					<?php
				endif;
				?>

				<div class="ulmc-settings__field">
					<p class="ulmc-input__label"><?php esc_html_e( 'Loan Term', 'ultimate-loan-mortgage-calculator' ); ?></p>
					<div class="ulmc-row">					
						<div class="ulmc-input ulmc-metric ulmc-input__term">
							<input id="ulmc_term_years_<?php echo esc_attr( $ulmc_id ); ?>" class="ulmc-validate ulmc_term_years" name="ulmc-term-years" type="number" step="1" min="0" max="99" required placeholder="0" value="1">
							<label for="ulmc_term_years_<?php echo esc_attr( $ulmc_id ); ?>" class="ulmc-input__placeholder"><?php esc_html_e( 'years', 'ultimate-loan-mortgage-calculator' ); ?></label>
						</div>

						<div class="ulmc-input ulmc-metric ulmc-input__term">
							<input id="ulmc_term_months_<?php echo esc_attr( $ulmc_id ); ?>" class="ulmc-validate ulmc_term_months" name="ulmc-term-months" type="number" step="1" min="0" max="12" required placeholder="0" value="0">
							<label for="ulmc_term_months_<?php echo esc_attr( $ulmc_id ); ?>" class="ulmc-input__placeholder"><?php esc_html_e( 'months', 'ultimate-loan-mortgage-calculator' ); ?></label>
						</div>
					</div>
				</div>

				<div class="ulmc-settings__field">
					<?php
					$payment_frequencies = $ulmc->get_payment_frequencies();
					$default_frequency   = 'monthly';
					?>
					<p class="ulmc-input__label"><?php esc_html_e( 'Payment frequency', 'ultimate-loan-mortgage-calculator' ); ?></p>
					<div class="ulmc-input">
						<select class="ulmc-select custom-select ulmc_payment_frequency" name="ulmc_payment_frequency">
							<?php foreach ( $payment_frequencies as $key => $value ) : ?>
								<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $default_frequency, $key, true ); ?>><?php echo esc_html( $value ); ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>

				<div class="ulmc-settings__field">
					<?php
					$date_format = $ulmc->get_option( 'date_format' );
					?>

					<div class="ulmc-input">
						<div class="ulmc-input__label-wrapper">
							<label for="ulmc_date_payment_<?php echo esc_attr( $ulmc_id ); ?>" class="ulmc-input__label"><?php esc_html_e( 'Date of first payment', 'ultimate-loan-mortgage-calculator' ); ?></label>
						</div>
						<input data-format="<?php echo esc_attr( $date_format ); ?>" id="ulmc_date_payment_<?php echo esc_attr( $ulmc_id ); ?>" class="ulmc-input__text ulmc_date_payment" type="text" value="">
					</div>

				</div>
			</div>

			<?php
			if ( current_user_can( 'administrator' ) ) :
				?>
				<div class="ulmc-settings__edit-link-wrapper">
					<a class="ulmc-settings__edit-link" target="_blank" href="<?php echo esc_url( admin_url( 'admin.php?page=ultimate-loan-mortgage-calculator' ) ); ?>"><?php esc_html_e( 'Edit Calculator', 'ultimate-loan-mortgage-calculator' ); ?></a>
					<?php
					$ulmc->display_tooltip(
						array(
							'text' => __( 'You can see it because you\'re logged in as an administrator.', 'ultimate-loan-mortgage-calculator' ),
						)
					);
					?>
				</div>
						<?php
			endif;
			?>

		</form>

		<div class="ulmc-result">

			<div class="ulmc-result__data">
				<h3 class="ulmc-result__data-title"><?php esc_html_e( 'Your Results:', 'ultimate-loan-mortgage-calculator' ); ?></h3>

				<div class="ulmc-result__data-group">
					<div class="ulmc-result__data-subtitle"><span class="ulmc_result_payment_frequency"><?php esc_html_e( 'Monthly', 'ultimate-loan-mortgage-calculator' ); ?></span>&nbsp;<?php esc_html_e( 'payment', 'ultimate-loan-mortgage-calculator' ); ?></div>		
					<div class="ulmc-result__data-result">
						<span class="ulmc_result_payment_amount ulmc-result__data-result-count">0</span>			
					</div>
				</div>
				<div class="ulmc-result__data-group">
					<div class="ulmc-result__data-subtitle"><?php esc_html_e( 'Total payment', 'ultimate-loan-mortgage-calculator' ); ?></div>		
					<div class="ulmc-result__data-result">
						<span class="ulmc_result_total_cost ulmc-result__data-result-count">0</span>			
					</div>
				</div>
				<div class="ulmc-result__data-group">
					<div class="ulmc-result__data-subtitle"><?php esc_html_e( 'Total Interest', 'ultimate-loan-mortgage-calculator' ); ?></div>		
					<div class="ulmc-result__data-result">
						<span class="ulmc_result_total_interest ulmc-result__data-result-count">0</span>			
					</div>
				</div>

				<button class="ulmc-button ulmc-schedule__show" type="button"><?php esc_html_e( 'Show Amortization Schedule', 'ultimate-loan-mortgage-calculator' ); ?></button>
			</div>

			<div class="ulmc-save-result">

				<h3 class="ulmc-save-result__title">
					<svg class="ulmc-save-result__title-icon">
						<use xlink:href="<?php echo esc_attr( ULMC_PLUGIN_URL . 'public/images/download.svg#download' ); ?>"></use>
					</svg>
					<?php esc_html_e( 'Save results:', 'ultimate-loan-mortgage-calculator' ); ?>
				</h3>

				<form class="ulmc-save-result__form">
					<?php wp_nonce_field( 'ulmc-nonce', 'ulmc_nonce_' . $ulmc_id ); ?>
					<div class="ulmc-save-result__form-wrapper">
						<label for="ulmc_user_email_<?php echo esc_attr( $ulmc_id ); ?>" class="ulmc-save-result__form-label"><?php esc_html_e( 'Email Address', 'ultimate-loan-mortgage-calculator' ); ?></label>
						<input id="ulmc_user_email_<?php echo esc_attr( $ulmc_id ); ?>" class="ulmc-save-result__form-field ulmc-save-result__form-email ulmc-validate ulmc_user_email" value="" type="email" name="email" placeholder="<?php esc_attr_e( 'mail@example.com', 'ultimate-loan-mortgage-calculator' ); ?>" required autocomplete="email">
						<button class="ulmc-button ulmc-save-result__form-submit ulmc_send_result" type="button"><?php esc_html_e( 'Send to Email', 'ultimate-loan-mortgage-calculator' ); ?></button>
					</div>

					<?php
					if ( 'show' === $ulmc->get_option( 'user_agreements' ) ) :
						$user_agreements_text = $ulmc->replace_params_for_user_agreements( $ulmc->get_option( 'user_agreements_text' ) );
						?>
						<div class="ulmc-save-result__form-user-agreement">
							<label id="ulmc_user_acceptance" class="ulmc-checkbox ulmc-checkbox--privacy">
								<input type="checkbox" name="ulmc_user_acceptance">
								<span class="ulmc-checkbox-text">
									<div class="ulmc-checkbox-text-wrapper"><?php echo wp_kses_post( $user_agreements_text ); ?></div>
									<span class="ulmc-checkbox-check">
									<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
										<path fill-rule="evenodd" clip-rule="evenodd" d="M16.6485 4.30806C16.8736 4.50515 17 4.77242 17 5.0511C17 5.32978 16.8736 5.59706 16.6485 5.79414L7.64917 13.6716C7.53024 13.7757 7.38904 13.8583 7.23364 13.9146C7.07824 13.971 6.91168 14 6.74347 14C6.57526 14 6.4087 13.971 6.2533 13.9146C6.0979 13.8583 5.95671 13.7757 5.83778 13.6716L1.36655 9.75843C1.25187 9.66148 1.1604 9.54551 1.09748 9.41728C1.03455 9.28906 1.00143 9.15115 1.00005 9.0116C0.99866 8.87206 1.02904 8.73366 1.08941 8.6045C1.14978 8.47534 1.23893 8.358 1.35166 8.25932C1.4644 8.16064 1.59845 8.0826 1.74601 8.02976C1.89356 7.97691 2.05166 7.95032 2.21109 7.95153C2.37051 7.95275 2.52806 7.98174 2.67454 8.03682C2.82103 8.0919 2.95351 8.17197 3.06427 8.27235L6.74307 11.4925L14.9499 4.30806C15.0614 4.2104 15.1938 4.13292 15.3396 4.08007C15.4853 4.02721 15.6415 4 15.7992 4C15.9569 4 16.1131 4.02721 16.2589 4.08007C16.4046 4.13292 16.537 4.2104 16.6485 4.30806Z" fill="currentColor"/>
									</svg>
									</span>
							</span>
							</label>
						</div>
					<?php endif; ?>
				</form>

				<div class="ulmc-save-result__form-notices"></div>

			</div>
		</div>
	</div>

	<div class="ulmc-schedule" style="display:none;">

		<div class="ulmc-table__wrapper">
			<table class="ulmc-table ulmc_schedule_table">
				<thead>
						<tr>
								<th><?php esc_html_e( 'Period', 'ultimate-loan-mortgage-calculator' ); ?></th>
								<th class="ulmc_date_heading"><?php esc_html_e( 'Date Payment', 'ultimate-loan-mortgage-calculator' ); ?></th>
								<th class="ulmc_balance_heading"><?php esc_html_e( 'Opening Balance', 'ultimate-loan-mortgage-calculator' ); ?></th>
								<th class="ulmc_principal_heading"><?php esc_html_e( 'Monthly Principal', 'ultimate-loan-mortgage-calculator' ); ?></th>
								<th class="ulmc_interest_heading"><?php esc_html_e( 'Monthly Interest', 'ultimate-loan-mortgage-calculator' ); ?></th>
								<th><?php esc_html_e( 'Closing Balance', 'ultimate-loan-mortgage-calculator' ); ?></th>
						</tr>
				</thead>
				<tbody class="ulmc-schedule-table-body">
				</tbody>
			</table>
		</div>

	</div>
</div>
