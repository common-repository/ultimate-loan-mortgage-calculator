<?php
/**
 * Calculator main settings.
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

<section id="main-settings" class="ulmc-settings-section active">

	<h2 class="ulmc-settings-section-title"><?php esc_html_e( 'Settings', 'ultimate-loan-mortgage-calculator' ); ?></h2>

	<div id="title_settings" class="ulmc-settings-group">

		<div class="ulmc-settings-group-title">
			<h3><?php esc_html_e( 'Main Calculator Title', 'ultimate-loan-mortgage-calculator' ); ?></h3>

			<?php
			$title_show = $ulmc->get_option( 'title_show' );
			?>

			<div class="ulmc-switch-wrapper">
				<div class="ulmc-switch">
					<div class="ulmc-switch-option" data-position="left">	<?php esc_html_e( 'Hide', 'ultimate-loan-mortgage-calculator' ); ?></div>
					<label class="ulmc-switch-toggle">
						<input type="checkbox" name="ulmc_options[title_show]" value="show" <?php checked( 'show', $title_show ); ?>>
						<div class="ulmc-switch-toggle-circle"></div>
						<div class="ulmc-switch-toggle-background"></div>
					</label>
					<div class="ulmc-switch-option" data-position="right"><?php esc_html_e( 'Show', 'ultimate-loan-mortgage-calculator' ); ?></div>
				</div>
			</div>						
		</div>

		<div id="title_show_settings" class="ulmc-settings-group-content" style="<?php echo 'show' === $title_show ? '' : 'display:none;'; ?>">

			<div class="ulmc-settings-group-content">

				<div class="ulmc-settings-row ulmc-settings-row-title">
					<?php $title_text = $ulmc->get_option( 'title_text' ); ?>

					<input type="text" name="ulmc_options[title_text]" value="<?php echo esc_attr( $title_text ); ?>">

				</div>
			</div>
		</div>
	</div>

	<div id="notification_settings" class="ulmc-settings-group">
		<?php $notification_email = $ulmc->get_option( 'notification_email' ); ?>

		<div class="ulmc-settings-group">

			<div class="ulmc-settings-group-title">
				<h3><?php esc_html_e( 'Notification settings', 'ultimate-loan-mortgage-calculator' ); ?></h3>
			</div>

			<p class="ulmc-notification-email-description ulmc-settings-description">
				<?php esc_html_e( 'Enter your email to receive notifications about new calculator users (who requested results to their email) and their email addresses', 'ultimate-loan-mortgage-calculator' ); ?>
			</p>
			<input type="email" name="ulmc_options[notification_email]" placeholder="your email"
			value="<?php echo esc_attr( $notification_email ); ?>">
		</div>

		<div id="agreements_settings" class="ulmc-settings-group">
			<?php
			$user_agreements               = $ulmc->get_option( 'user_agreements' );
			$privacy_policy                = $ulmc->get_option( 'privacy_policy' );
			$privacy_policy_url            = $ulmc->get_option( 'privacy_policy_url' );
			$privacy_policy_url_text       = $ulmc->get_option( 'privacy_policy_url_text' );
			$terms_and_conditions          = $ulmc->get_option( 'terms_and_conditions' );
			$terms_and_conditions_url      = $ulmc->get_option( 'terms_and_conditions_url' );
			$terms_and_conditions_url_text = $ulmc->get_option( 'terms_and_conditions_url_text' );
			$user_agreements_text          = $ulmc->get_option( 'user_agreements_text' );
			?>

			<div class="ulmc-settings-group-title">
				<h3><?php esc_html_e( 'User agreements', 'ultimate-loan-mortgage-calculator' ); ?></h3>
			</div>

			<div class="ulmc-settings-group-content">
				<label class="ulmc-checkbox">
					<input type="checkbox" name="ulmc_options[user_agreements]" value="show" <?php checked( 'show', $user_agreements ); ?>>
					<span><?php esc_html_e( 'Show User agreements', 'ultimate-loan-mortgage-calculator' ); ?></span>
				</label>
				<div id="user_agreements_settings" style="<?php echo 'show' === $user_agreements ? '' : 'display:none;'; ?>">
					<label class="ulmc-checkbox ulmc-user-agreements-wrapper">
						<input type="checkbox" name="ulmc_options[privacy_policy]" value="show" <?php checked( 'show', $privacy_policy ); ?>>
						<span><?php esc_html_e( 'Privacy Policy', 'ultimate-loan-mortgage-calculator' ); ?></span>
					</label>
					<div id="privacy_policy_settings" class="ulmc-privacy-policy-wrapper" style="<?php echo 'show' === $privacy_policy ? '' : 'display:none;'; ?>">
						<div class="ulmc-settings-row">
							<label class="ulmc-settings-group-label mr">
								<?php esc_html_e( 'Privacy Policy URL', 'ultimate-loan-mortgage-calculator' ); ?>
								<input type="text" name="ulmc_options[privacy_policy_url]" placeholder="https://your-domain/privacy-policy" value="<?php echo esc_attr( $privacy_policy_url ); ?>">
							</label>
							<label class="ulmc-settings-group-label">
								<?php esc_html_e( 'Privacy Policy URL text', 'ultimate-loan-mortgage-calculator' ); ?>
								<input type="text" name="ulmc_options[privacy_policy_url_text]" placeholder="Privacy Policy" value="<?php echo esc_attr( $privacy_policy_url_text ); ?>">
							</label>
						</div>
					</div>
					<label class="ulmc-checkbox">
						<input type="checkbox" name="ulmc_options[terms_and_conditions]" value="show" <?php checked( 'show', $terms_and_conditions ); ?>>
						<span><?php esc_html_e( 'Terms and Conditions', 'ultimate-loan-mortgage-calculator' ); ?></span>
					</label>
					<div id="terms_and_conditions_settings" class="ulmc-terms-wrapper" style="<?php echo 'show' === $terms_and_conditions ? '' : 'display:none;'; ?>">
						<div class="ulmc-settings-row">
							<label class="ulmc-settings-group-label mr">
								<?php esc_html_e( 'Terms URL', 'ultimate-loan-mortgage-calculator' ); ?>
								<input type="text" name="ulmc_options[terms_and_conditions_url]" placeholder="https://your-domain/terms-and-conditions" value="<?php echo esc_attr( $terms_and_conditions_url ); ?>">
							</label>
							<label class="ulmc-settings-group-label">
								<?php esc_html_e( 'Terms URL text', 'ultimate-loan-mortgage-calculator' ); ?>
								<input type="text" name="ulmc_options[terms_and_conditions_url_text]" placeholder="Terms and Conditions" value="<?php echo esc_attr( $terms_and_conditions_url_text ); ?>">
							</label>
						</div>
					</div>
					<label class="ulmc-settings-group-label">
						<?php esc_html_e( 'User agreement message', 'ultimate-loan-mortgage-calculator' ); ?>
						<textarea class="ulmc-settings-textarea" name="ulmc_options[user_agreements_text]" rows="2"><?php echo wp_kses_post( $user_agreements_text ); ?></textarea>
					</label>
					<p class="ulmc-settings-description"><?php esc_html_e( 'If you change this value make sure to wrap the links using the {} signs: {privacy_policy} and {terms_and_conditions}.', 'ultimate-loan-mortgage-calculator' ); ?></p>
				</div>
			</div>
		</div>
	</div>

	<div class="ulmc-settings-submit">
		<?php echo esc_html( submit_button( null, 'ulmc-submit', 'publish', true, array( 'id' => 'publish' ) ) ); ?>
	</div>

</section>
