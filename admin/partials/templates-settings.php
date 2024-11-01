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

<section id="templates-settings" class="ulmc-settings-section block-disabled">
	<h2 class="ulmc-settings-section-title">
		<?php esc_html_e( 'Email templates', 'ultimate-loan-mortgage-calculator' ); ?>
	</h2>

	<div class="ulmc-settings-group">
		<div class="ulmc-settings-group-title">
			<h3><?php esc_html_e( 'User parameters', 'ultimate-loan-mortgage-calculator' ); ?></h3>
		</div>
		<div class="ulmc-settings-group-content">
			<p class="ulmc-settings-description">
				<?php esc_html_e( 'Use these parameters when constructing notifications to user and administrator. Do not remove curly braces - {user_name}.', 'ultimate-loan-mortgage-calculator' ); ?>
			</p>
			<table class="ulmc-settings-group-text-block-table">
				<tbody>
					<tr>
						<td><?php echo '{user_name}'; ?></td>
						<td><?php esc_html_e( "The user's name", 'ultimate-loan-mortgage-calculator' ); ?></td>
					</tr>
					<tr>
						<td><?php echo '{user_email}'; ?></td>
						<td><?php esc_html_e( "The user's email address", 'ultimate-loan-mortgage-calculator' ); ?></td>
					</tr>
				</tbody>
			</table>							
		</div>

		<div class="ulmc-settings-group">
			<?php
			$email_user_subject = $ulmc->get_option( 'email_user_subject' );
			$email_user_body    = $ulmc->get_option( 'email_user_body' );
			?>
			<div class="ulmc-settings-group-title">
				<h3><?php esc_html_e( 'Email template to user', 'ultimate-loan-mortgage-calculator' ); ?></h3>
			</div>

			<div class="ulmc-settings-group-content">
				<p class="ulmc-settings-description ulmc-settings-description--100"><?php esc_html_e( 'Fill in the From (Name/Title) and From (Email) fields - for example, Ultimate Loan & Mortgage Calculator and calculator. Leave these fields blank if you want to use the default WordPress settings or configure them on SMTP.', 'ultimate-loan-mortgage-calculator' ); ?></p>

				<label class="ulmc-settings-group-label"><?php esc_html_e( 'Subject', 'ultimate-loan-mortgage-calculator' ); ?>
					<input class="disabled" disabled type="text" value="<?php echo esc_html( $email_user_subject ); ?>" /></label>
				<label class="ulmc-settings-group-label"><?php esc_html_e( 'Body', 'ultimate-loan-mortgage-calculator' ); ?>
					<textarea rows="18" name="ulmc_template_user_email_body"
						class="ulmc-settings-textarea disabled" disabled><?php echo esc_html( $email_user_body ); ?></textarea>
				</label>
			</div>
		</div>

		<div class="ulmc-settings-group">
			<?php
			$email_admin_subject = $ulmc->get_option( 'email_admin_subject' );
			$email_admin_body    = $ulmc->get_option( 'email_admin_body' );
			?>
			<div class="ulmc-settings-group-title">
				<h3><?php esc_html_e( 'Notification template', 'ultimate-loan-mortgage-calculator' ); ?></h3>
			</div>
			<div class="ulmc-settings-group-content">
				<label class="ulmc-settings-group-label"><?php esc_html_e( 'Subject', 'ultimate-loan-mortgage-calculator' ); ?>
					<input class="disabled" disabled type="text" name="ulmc_template_admin_email_subject"
						value="<?php echo esc_attr( $email_admin_subject ); ?>" /></label>
				<label class="ulmc-settings-group-label"><?php esc_html_e( 'Body', 'ultimate-loan-mortgage-calculator' ); ?>
					<textarea rows="18" name="ulmc_template_admin_email_body"
						class="ulmc-settings-textarea disabled" disabled><?php echo esc_html( $email_admin_body ); ?></textarea>
				</label>
			</div>
		</div>
	</div>					

</section>
