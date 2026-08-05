<?php

/**
 * Provide a admin area view for the plugin
 *
 * Get Airbnb Reviews — multiple sources with AJAX download per source.
 *
 * @link       https://wpreviewslider.com/
 * @since      1.0.0
 *
 * @package    WP_Airbnb_Review
 * @subpackage WP_Airbnb_Review/admin/partials
 */

// check user capabilities
if ( ! current_user_can( 'manage_options' ) ) {
	return;
}

// Ensure crawls option exists and migrate legacy single URL.
$airbnb_crawls = $this->wpairbnb_get_crawls();

// Delete source if requested.
if ( isset( $_GET['ract'] ) && $_GET['ract'] === 'del' && isset( $_GET['pageid'] ) ) {
	check_admin_referer( 'wpairbnb_del_source' );
	$del_pageid = sanitize_text_field( wp_unslash( $_GET['pageid'] ) );
	$this->wpairbnb_delete_source( $del_pageid );
	$airbnb_crawls = $this->wpairbnb_get_crawls();
	add_settings_error( 'airbnb-radio', 'wpairbnb_message', __( 'Source deleted.', 'wp-airbnb-review-slider' ), 'updated' );
}

if ( isset( $this->errormsg ) && $this->errormsg !== '' ) {
	add_settings_error( 'airbnb-radio', 'wpairbnb_message', esc_html( $this->errormsg ), 'updated' );
}

$del_base = wp_nonce_url(
	admin_url( 'admin.php?page=wp_airbnb-get_airbnb&ract=del' ),
	'wpairbnb_del_source'
);
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

			<p>
				<?php esc_html_e( 'Add one or more Airbnb listing pages, then download reviews for each source. Please note that Airbnb may not return all reviews.', 'wp-airbnb-review-slider' ); ?>
			</p>

			<?php settings_errors( 'airbnb-radio' ); ?>

			<div id="wpairbnb_add_source_box" style="margin-bottom:20px;">
				<h3><?php esc_html_e( 'Add Airbnb Source', 'wp-airbnb-review-slider' ); ?></h3>
				<p>
					<label for="airbnb_new_url"><strong><?php esc_html_e( 'Listing URL', 'wp-airbnb-review-slider' ); ?></strong></label><br>
					<input type="text" id="airbnb_new_url" class="regular-text" style="width:100%;max-width:700px;" placeholder="https://www.airbnb.com/rooms/47530503" value="">
				</p>
				<p>
					<label for="airbnb_new_name"><strong><?php esc_html_e( 'Listing Name (optional)', 'wp-airbnb-review-slider' ); ?></strong></label><br>
					<input type="text" id="airbnb_new_name" class="regular-text" style="width:100%;max-width:400px;" placeholder="<?php esc_attr_e( 'Leave blank to use a generic label', 'wp-airbnb-review-slider' ); ?>" value="">
				</p>
				<p>
					<button type="button" id="wpairbnb_add_source" class="button button-primary"><?php esc_html_e( 'Add Source', 'wp-airbnb-review-slider' ); ?></button>
					<span id="wpairbnb_add_loader" class="wprevloader" style="display:none;width:20px;height:20px;border-width:3px;vertical-align:middle;margin-left:8px;"></span>
					<span id="wpairbnb_add_msg" style="margin-left:8px;"></span>
				</p>
				<p class="description">
					<?php esc_html_e( 'Examples:', 'wp-airbnb-review-slider' ); ?>
					</br>
					https://www.airbnb.com/rooms/47530503
					</br>
					https://www.airbnb.com/experiences/321167
				</p>
			</div>

			<div id="currentsources">
				<style>
				#currentsources table { max-width: 100%; table-layout: fixed; word-wrap: break-word; }
				#currentsources table td { word-wrap: break-word; overflow-wrap: break-word; }
				#currentsources .airbnb-source-msg { display: inline-block; margin-left: 8px; }
				#currentsources .buttonloader2.wprevloader { display:none; width:20px; height:20px; border-width:3px; vertical-align:middle; margin-left:6px; }
				</style>
				<table class="w3-table-all wpfbr_mb15 w3-white w3-border w3-border-light-gray2 w3-round-small">
					<tr>
						<th><?php esc_html_e( 'Listing Name', 'wp-airbnb-review-slider' ); ?></th>
						<th><?php esc_html_e( 'Listing ID', 'wp-airbnb-review-slider' ); ?></th>
						<th><?php esc_html_e( 'Source Avg / Total', 'wp-airbnb-review-slider' ); ?></th>
						<th><?php esc_html_e( 'Action', 'wp-airbnb-review-slider' ); ?></th>
					</tr>
					<tbody id="wpairbnb_sources_tbody">
					<?php
					$source_count = 0;
					if ( is_array( $airbnb_crawls ) ) {
						foreach ( $airbnb_crawls as $pageid => $source ) {
							if ( ! is_array( $source ) || $pageid === '' || $pageid === '0' ) {
								continue;
							}
							$source_count++;
							$bname  = isset( $source['businessname'] ) ? $source['businessname'] : '';
							$url    = isset( $source['url'] ) ? $source['url'] : '';
							$avg    = isset( $source['avg'] ) ? $source['avg'] : '';
							$total  = isset( $source['total'] ) ? $source['total'] : '';
							$avg_total_label = ( $avg !== '' || $total !== '' ) ? esc_html( $avg ) . ' / ' . esc_html( $total ) : '—';
							$del_url = add_query_arg( 'pageid', rawurlencode( $pageid ), $del_base );
							?>
							<tr data-pageid="<?php echo esc_attr( $pageid ); ?>">
								<td>
									<?php echo esc_html( $bname ); ?>
									<?php if ( $url ) : ?>
										<br><a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'View on Airbnb', 'wp-airbnb-review-slider' ); ?></a>
									<?php endif; ?>
								</td>
								<td><?php echo esc_html( $pageid ); ?></td>
								<td class="airbnb-source-stats"><?php echo $avg_total_label; ?></td>
								<td>
									<button type="button" class="button button-primary downloadrevs" data-pageid="<?php echo esc_attr( $pageid ); ?>"><?php esc_html_e( 'Download Reviews', 'wp-airbnb-review-slider' ); ?></button>
									<span class="buttonloader2 wprevloader"></span>
									<a class="button" style="color:#a00;" href="<?php echo esc_url( $del_url ); ?>" onclick="return confirm('<?php echo esc_js( __( 'Delete this source and its reviews?', 'wp-airbnb-review-slider' ) ); ?>');"><?php esc_html_e( 'Delete', 'wp-airbnb-review-slider' ); ?></a>
									<span class="airbnb-source-msg"></span>
								</td>
							</tr>
							<?php
						}
					}
					if ( $source_count === 0 ) {
						echo '<tr class="wpairbnb-no-sources"><td colspan="4">' . esc_html__( 'No sources yet. Add an Airbnb listing URL above.', 'wp-airbnb-review-slider' ) . '</td></tr>';
					}
					?>
					</tbody>
				</table>
			</div>

			<p><b><?php esc_html_e( 'The Pro version can download all your reviews with avatars from multiple listings and check for new reviews daily!', 'wp-airbnb-review-slider' ); ?></b></p>

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
