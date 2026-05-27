<?php

/**
 * Provide a admin area view for the plugin
 *
 * @package    WP_Airbnb_Review
 * @subpackage WP_Airbnb_Review/admin/partials
 */

if ( ! current_user_can( 'manage_options' ) ) {
	return;
}

if ( isset( $_GET['settings-updated'] ) ) {
	add_settings_error( 'airbnb-radio', 'wpairbnb_message', __( 'Settings Saved', 'wp-airbnb-review-slider' ), 'updated' );
}

if ( isset( $this->errormsg ) ) {
	add_settings_error( 'airbnb-radio', 'wpairbnb_message', esc_html( $this->errormsg ), 'error' );
}
?>

<div class="">
<h1></h1>
<div class="wrap" id="wp_rev_maindiv">

<img class="wprev_headerimg" src="<?php echo esc_url( plugin_dir_url( __FILE__ ) . 'logo.png?v=' . $this->version ); ?>">
<?php
include 'tabmenu.php';
?>
	<div class="wpfbr_margin10">
		<div class="w3-col welcomediv w3-container w3-white w3-border w3-border-light-gray2 w3-round-small">

			<form action="options.php" method="post">
				<?php
				settings_fields( 'wp_airbnb-get_airbnb' );
				do_settings_sections( 'wp_airbnb-get_airbnb' );
				submit_button( __( 'Save Settings & Download', 'wp-airbnb-review-slider' ) );
				?>
				<p><i><?php _e( 'Note: It may take a little time after you hit the Save button to download your reviews.', 'wp-airbnb-review-slider' ); ?></i></p>
				<p><b><?php _e( 'The Pro version can download all your reviews with avatars from multiple Airbnb listings and check for new reviews daily!', 'wp-airbnb-review-slider' ); ?></b></p>
			</form>
			<?php
			settings_errors( 'airbnb-radio' );
			?>

		</div>
	</div>
	</div>
	</div>

	<div id="popup_info" class="popup-wrapper wpairbnb_hide">
	  <div class="popup-content">
		<div class="popup-title">
		  <button type="button" class="popup-close">&times;</button>
		  <h3 id="popup_titletext"></h3>
		</div>
		<div class="popup-body">
		  <div id="popup_bobytext1"></div>
		  <div id="popup_bobytext2"></div>
		</div>
	  </div>
	</div>

