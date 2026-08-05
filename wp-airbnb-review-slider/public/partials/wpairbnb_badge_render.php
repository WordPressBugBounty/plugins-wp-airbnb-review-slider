<?php
/**
 * Build and optionally emit the Airbnb review badge (summary card).
 *
 * Expects in scope:
 *   $template_misc_array (array), $filtersource (string), $currentform (array of objects), $wpdb
 *
 * Sets in scope:
 *   $badgehtml (string), $wprev_badge_active (bool)
 *
 * When $wpairbnb_badge_phase === 'open': echoes style, outer wrap, and left/above badge.
 * When $wpairbnb_badge_phase === 'close': echoes right badge and closes outer wrap.
 *
 * @package WP_Airbnb_Review_Slider
 */

if ( ! defined( 'WPINC' ) ) {
	exit;
}

if ( ! isset( $template_misc_array ) || ! is_array( $template_misc_array ) ) {
	$template_misc_array = array();
}
if ( ! isset( $template_misc_array['blocation'] ) ) {
	$template_misc_array['blocation'] = '';
}

$wprev_badge_active = ( $template_misc_array['blocation'] !== '' );

if ( ! $wprev_badge_active ) {
	$badgehtml = '';
	return;
}

if ( ! isset( $wpairbnb_badge_phase ) ) {
	$wpairbnb_badge_phase = 'open';
}

if ( $wpairbnb_badge_phase === 'open' ) {

	$defaults = array(
		'bname'     => '',
		'bimgurl'   => '',
		'bbtnurl'   => '',
		'bnameurl'  => '',
		'bbtncolor' => '',
		'bbkcolor'  => '',
		'bbradius'  => '',
		'bbwidth'   => '0',
		'bbcolor'   => '',
		'bdropsh'   => '',
		'bcenter'   => '',
		'bhname'    => '',
		'bhphoto'   => '',
		'bhbased'   => '',
		'bhbtn'     => '',
		'bhpow'     => '',
		'bshape'    => '',
		'bobasedon' => '',
		'borevus'   => '',
	);
	foreach ( $defaults as $k => $v ) {
		if ( ! isset( $template_misc_array[ $k ] ) ) {
			$template_misc_array[ $k ] = $v;
		}
	}

	$businessname = $template_misc_array['bname'];
	$imageurl     = $template_misc_array['bimgurl'];
	$butnlinkurl  = $template_misc_array['bbtnurl'];
	$bnameurl     = $template_misc_array['bnameurl'];

	$badge_imgs_base    = trailingslashit( wprev_airbnb_plugin_url ) . 'public/partials/imgs/';
	$airbnb_badge_icon  = $badge_imgs_base . 'airbnb_badge_icon.svg';
	$airbnb_powered_img = $badge_imgs_base . 'airbnb_outline.png';
	if ( $imageurl === '' ) {
		$imageurl = $airbnb_badge_icon;
	}
	$powered_by_img = $airbnb_powered_img;

	$bbtncolor        = sanitize_text_field( $template_misc_array['bbtncolor'] );
	$bbackgroundcolor = sanitize_text_field( $template_misc_array['bbkcolor'] );
	if ( $bbtncolor === '' ) {
		$bbtncolor = '#FF5A5F';
	}
	if ( $bbackgroundcolor === '' ) {
		$bbackgroundcolor = '#ffffff';
	}
	$bborderradius = intval( $template_misc_array['bbradius'] );
	$bborderwidth  = absint( $template_misc_array['bbwidth'] );
	$bbordercolor  = '';
	if ( $template_misc_array['bbcolor'] !== '' ) {
		$bbordercolor = sanitize_text_field( $template_misc_array['bbcolor'] );
	}

	$bdropsh = esc_html( $template_misc_array['bdropsh'] );
	$bcenter = esc_html( $template_misc_array['bcenter'] );
	$bshape  = esc_html( $template_misc_array['bshape'] );

	$bhnameclass  = ( $template_misc_array['bhname'] === 'yes' ) ? 'badgehideclass' : '';
	$bhphotoclass = ( $template_misc_array['bhphoto'] === 'yes' ) ? 'badgehideclass' : '';
	$bhbasedclass = ( $template_misc_array['bhbased'] === 'yes' ) ? 'badgehideclass' : '';
	$bhbtnclass   = ( $template_misc_array['bhbtn'] === 'yes' ) ? 'badgehideclass' : '';
	$bhpowclass   = ( $template_misc_array['bhpow'] === 'yes' ) ? 'badgehideclass' : '';

	$badge_style  = '';
	$badge_style .= 'a.wprev-airbnb-wr-a {background: ' . $bbtncolor . ' !important;}';
	$badge_style .= 'a.wprev-airbnb-wr-a:hover {background: ' . $bbtncolor . 'de !important;}';

	// FB pattern: only emit border rule when width>0; do NOT set border:0 when dropshadow off.
	$badge_place_style = 'background: ' . $bbackgroundcolor . ' !important;border-radius:' . $bborderradius . 'px !important;';
	if ( $bborderwidth > 0 ) {
		if ( $bbordercolor === '' ) {
			$bbordercolor = '#eeeeee';
		}
		$badge_place_style .= 'border:' . $bborderwidth . 'px solid ' . $bbordercolor . ' !important;';
	}
	$badge_style .= '.wprev-airbnb-place {' . $badge_place_style . '}';

	if ( $bdropsh === 'yes' ) {
		$badge_style .= '.wprev-airbnb-place {box-shadow: rgba(0, 0, 0, .08) 2px 2px 3px 0px !important;}';
	} else {
		$badge_style .= '.wprev-airbnb-place {box-shadow: none !important;}';
	}
	if ( $bcenter === 'yes' && $template_misc_array['blocation'] !== 'abovewide' ) {
		$badge_style .= '.wprev-airbnb-place {flex-direction: column !important;align-items: center !important;}';
		$badge_style .= '.wprev-airbnb-right {display: flex!important;align-items: center!important;flex-direction: column!important;width: 100% !important;text-align: center !important;}';
		$badge_style .= '.wprev-airbnb-name{margin-bottom: 3px !important;}';
		$badge_style .= '.wprev-airbnb-powered,.wprev-airbnb-wr {display: flex !important;justify-content: center !important;width: 100% !important;}';
		$badge_style .= '.wprev-airbnb-powered img {margin-left: auto !important;margin-right: auto !important;}';
	}
	if ( $bshape === 'round' ) {
		$badge_style .= 'img.sprev-airbnb-left-src {border-radius: 50% !important;}';
	}

	// Avg / total from crawler source values in wpairbnb_total_averages.
	$templaceid     = isset( $filtersource ) ? $filtersource : '';
	$badgeavg       = '';
	$badgetotal     = '';
	$table_name_avg = $wpdb->prefix . 'wpairbnb_total_averages';
	if ( $templaceid !== '' ) {
		$currentlocation = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT avg, total FROM $table_name_avg WHERE pagetype = %s AND btp_id = %s LIMIT 1",
				'Airbnb',
				$templaceid
			)
		);
		if ( ! empty( $currentlocation ) ) {
			$badgeavg   = $currentlocation[0]->avg;
			$badgetotal = intval( $currentlocation[0]->total );
		}
	} else {
		$all_avgs = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT avg, total FROM $table_name_avg WHERE pagetype = %s AND btp_type = %s",
				'Airbnb',
				'page'
			)
		);
		if ( is_array( $all_avgs ) && count( $all_avgs ) === 1 ) {
			$badgeavg   = $all_avgs[0]->avg;
			$badgetotal = intval( $all_avgs[0]->total );
		}
	}

	if ( $template_misc_array['blocation'] === 'leftmid' || $template_misc_array['blocation'] === 'rightmid' ) {
		$badge_style .= '.wprev_outer_wb {align-items: center !important;}';
	}

	$wprev_outer_wb_class = 'wprev_outer_wb';
	if ( isset( $currentform[0]->style ) && (string) $currentform[0]->style === '6' ) {
		$badge_side_locations = array( 'left', 'right', 'leftmid', 'rightmid' );
		if ( in_array( $template_misc_array['blocation'], $badge_side_locations, true ) ) {
			$wprev_outer_wb_class .= ' wprev_badge_style6_side';
		}
	}

	if ( $template_misc_array['blocation'] === 'above' ) {
		$badge_style .= '.wprev_outer_wb {flex-direction: column !important;}.wprev_badge_div.badgeleft {margin-left: auto !important;margin-right: auto !important;}';
	}

	$badgeabovewide1     = '';
	$badgeabovewide2     = '';
	$badgeabovewideclose = '';
	if ( $template_misc_array['blocation'] === 'abovewide' ) {
		$badge_style        .= '.wprev_outer_wb {flex-direction: column !important;}.wprev_badge_div.badgeleft {margin-left: auto !important;margin-right: auto !important;}.wprev_badge_div.badgeleft {margin: 0px 46px !important;}.wprev-airbnb-place {justify-content: space-between !important;align-items: center !important;}.wprev-airbnb-leftboth {display: flex !important;}  @media only screen and (max-width: 600px) {.wprev-airbnb-place {flex-direction: column;}}';
		$badgeabovewide1     = '<div class="wprev-airbnb-leftboth">';
		$badgeabovewide2     = '<div class="wprev-airbnb-right">';
		$badgeabovewideclose = '</div>';
	}

	$bimgsize = 50;
	if ( isset( $template_misc_array['bimgsize'] ) && $template_misc_array['bimgsize'] > 0 ) {
		$bimgsize     = absint( $template_misc_array['bimgsize'] );
		$badge_style .= 'img.sprev-airbnb-left-src {min-width: ' . $bimgsize . 'px !important;min-height: ' . $bimgsize . 'px !important;}';
	}

	echo '<style>' . $badge_style . '</style>';
	echo '<div class="' . esc_attr( $wprev_outer_wb_class ) . '">';

	$basedontext = 'Based on <span class="wprev_btot">' . $badgetotal . '</span> reviews';
	if ( $template_misc_array['bobasedon'] !== '' ) {
		$basedontext = esc_html( $template_misc_array['bobasedon'] );
	}
	$basedontext = str_replace( '#', '<span class="wprev_btot">' . $badgetotal . '</span>', $basedontext );

	$reviewusontext = __( 'Review us on Airbnb!', 'wp-airbnb-review-slider' );
	if ( $template_misc_array['borevus'] !== '' ) {
		$reviewusontext = esc_html( $template_misc_array['borevus'] );
	}

	$badgehtml = '<div class="wprev-airbnb-place">' . $badgeabovewide1
		. '<div class="wprev-airbnb-left ' . $bhphotoclass . '"><img class="sprev-airbnb-left-src" src="' . esc_url( $imageurl ) . '" alt="' . esc_attr( $businessname ) . '" width="' . $bimgsize . '" height="' . $bimgsize . '" title="' . esc_attr( $businessname ) . '"></div>'
		. '<div class="wprev-airbnb-right"><div class="wprev-airbnb-name ' . $bhnameclass . '"><a href="' . esc_url( $bnameurl ) . '" target="_blank" rel="nofollow noopener"><span class="wprev-businessname">' . esc_html( $businessname ) . '</span></a></div>'
		. '<div class="wprevstardiv"><span class="wprev-airbnb-rating">' . esc_html( $badgeavg ) . '</span><span class="wprevpro_star_imgs_T1"><span class="starloc1 wprevpro_star_imgs wprevpro_star_imgsloc1">'
		. '<span class="svgicons svg-wprsp-star"></span><span class="svgicons svg-wprsp-star"></span><span class="svgicons svg-wprsp-star"></span><span class="svgicons svg-wprsp-star"></span><span class="svgicons svg-wprsp-star"></span>'
		. '</span></span></div>'
		. '<div class="wprev-airbnb-basedon ' . $bhbasedclass . '">' . $basedontext . '</div>'
		. $badgeabovewideclose . $badgeabovewideclose . $badgeabovewide2
		. '<div class="wprev-airbnb-powered ' . $bhpowclass . '"><img class="wprev-airbnb-powered-img" src="' . esc_url( $powered_by_img ) . '" alt="' . esc_attr__( 'powered by Airbnb', 'wp-airbnb-review-slider' ) . '" width="102" height="20" title="' . esc_attr__( 'powered by Airbnb', 'wp-airbnb-review-slider' ) . '"></div>'
		. '<div class="wprev-airbnb-wr ' . $bhbtnclass . '"><a class="wprev-airbnb-wr-a" target="_blank" rel="nofollow noopener" href="' . esc_url( $butnlinkurl ) . '">' . $reviewusontext . '</a></div>'
		. '</div></div>';

	if ( in_array( $template_misc_array['blocation'], array( 'left', 'leftmid', 'above', 'abovewide' ), true ) ) {
		echo '<div class="wprev_badge_div badgeleft">';
		echo $badgehtml; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- built with esc_* above.
		echo '</div>';
	}
} elseif ( $wpairbnb_badge_phase === 'close' ) {

	if ( ! isset( $badgehtml ) ) {
		$badgehtml = '';
	}
	if ( in_array( $template_misc_array['blocation'], array( 'right', 'rightmid' ), true ) ) {
		echo '<div class="wprev_badge_div badgeright">';
		echo $badgehtml; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo '</div>';
	}
	echo '</div>';
}
