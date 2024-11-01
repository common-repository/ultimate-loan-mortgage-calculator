<?php
/**
 * Calculator settings navigation.
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

<div class="ulmc-settings-tabs-links">
	<ul class="ulmc-settings-tabs-links-list" id="ulmc-settings-tab-links">
		<li>
			<div class="ulmc-shortcode-desktop">
				<div class="ulmc-shortcode">
					<button class="ulmc-shortcode-title" type="button"><?php esc_html_e( 'Your Shortcode', 'ultimate-loan-mortgage-calculator' ); ?></button>
					<div class="ulmc-shortcode-result-wrapper">
						<textarea class="ulmc-shortcode-result" rows="1" readonly>[ultimate-loan-mortgage-calculator]</textarea>
						<button class="ulmc-shortcode-copy ulmc-tooltip" type="button">
							<div class="ulmc-tooltip-text"><?php esc_html_e( 'Copy shortcode', 'ultimate-loan-mortgage-calculator' ); ?></div>
						</button>
					</div>
				</div>	
			</div>																
		</li>
		<li>
			<a href="#main-settings" class="active">
				<span><?php esc_html_e( 'Settings', 'ultimate-loan-mortgage-calculator' ); ?></span>
				<svg>
					<use xlink:href="<?php echo esc_url( ULMC_PLUGIN_URL . 'admin/images/settings-main.svg#main' ); ?>"></use>
				</svg>							
			</a>
		<li>
			<a href="#calculation-settings">
				<span><?php esc_html_e( 'Calculation', 'ultimate-loan-mortgage-calculator' ); ?></span>
				<svg>
					<use xlink:href="<?php echo esc_url( ULMC_PLUGIN_URL . 'admin/images/settings-calculation.svg#calc' ); ?>"></use>
				</svg>
			</a>
		</li>
		<li>
			<a href="#styling-settings">
				<span><?php esc_html_e( 'Styling', 'ultimate-loan-mortgage-calculator' ); ?></span>
				<svg>
					<use xlink:href="<?php echo esc_url( ULMC_PLUGIN_URL . 'admin/images/settings-styling.svg#styling' ); ?>"></use>
				</svg>
		</a>
		</li>
	</ul>
</div>
