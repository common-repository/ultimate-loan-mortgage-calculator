<?php
/**
 * Calculator style settings.
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

<section id="styling-settings" class="ulmc-settings-section">
	<h2 class="ulmc-settings-section-title"><?php esc_html_e( 'Styling', 'ultimate-loan-mortgage-calculator' ); ?></h2>

	<div id="color_settings" class="ulmc-settings-group">
		<?php $primary_color = $ulmc->get_option( 'primary_color' ); ?>

		<div class="ulmc-settings-group-title">
			<h3><?php esc_html_e( 'Color settings', 'ultimate-loan-mortgage-calculator' ); ?></h3>
		</div>

		<div class="ulmc-settings-group-content">

			<div class="ulmc-settings-color-schema" >								
				<table class="ulmc-settings-color-table">
					<tbody>
						<tr>
							<td><label for="ulmc_schema_color_custom"><?php esc_html_e( 'Choose color scheme', 'ultimate-loan-mortgage-calculator' ); ?></label></td>
							<td><input type="text" class="ulmc-color-custom" name="ulmc_options[primary_color]" id="ulmc_schema_color_custom" value="<?php echo esc_attr( $primary_color ); ?>" data-default-color="#325878" /></td>
						</tr>
					</tbody>
				</table>
			</div>							
		</div>

	</div>

	<div id="font_size_settings" class="ulmc-settings-group">
		<?php
		$default_font_sizes = $ulmc->get_font_sizes();
		$font_size          = $ulmc->get_option( 'font_size' );
		?>
		<div class="ulmc-settings-group-title">
			<h3><?php esc_html_e( 'Base font size', 'ultimate-loan-mortgage-calculator' ); ?></h3>
		</div>
		<div class="ulmc-settings-group-content">
			<select id="ulmc_font_size" name="ulmc_options[font_size]">
				<?php
				foreach ( $default_font_sizes as $font ) :
					?>
					<option value="<?php echo esc_attr( $font['value'] ); ?>" <?php selected( $font['value'], $font_size, true ); ?>><?php echo esc_html( $font['name'] ); ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>

	<div class="ulmc-settings-submit">
		<?php echo esc_html( submit_button( null, 'ulmc-submit', 'publish', true, array( 'id' => 'publish' ) ) ); ?>
	</div>

</section>
