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
?>

<div class="">
<h1></h1>
<div class="wrap" id="wp_rev_maindiv">

<img class="wprev_headerimg" src="<?php echo esc_url( plugin_dir_url( __FILE__ ) . 'logo.png?v=' . $this->version ); ?>">
<?php
include 'tabmenu.php';
?>
<div class="welcomecontainer wpfbr_margin10 w3-row-padding w3-section w3-stretch">

<div class="w3-col s12 m6 w3-container ">
<div class="welcomediv w3-white w3-border w3-border-light-gray2 w3-round-small">
	<h3><?php _e( 'Welcome!', 'wp-airbnb-review-slider' ); ?></h3>
	<p><?php _e( 'Thank you for being an awesome WP Review Slider customer! If you have trouble, please don\'t hesitate to contact me.', 'wp-airbnb-review-slider' ); ?></p>
	<h3><?php _e( 'Getting Started:', 'wp-airbnb-review-slider' ); ?></h3>
	<p><?php _e( '1) Use the "Get Airbnb Reviews" page to download your reviews and save them to your database.', 'wp-airbnb-review-slider' ); ?> <?php printf( __( 'The %1$sPro version%2$s can download reviews from 90+ sites and multiple Airbnb listings!', 'wp-airbnb-review-slider' ), '<a href="https://wpreviewslider.com/" target="_blank">', '</a>' ); ?></p>
	<p><?php _e( '2) Once downloaded, the reviews should show up on the "Review List" page of the plugin.', 'wp-airbnb-review-slider' ); ?></p>
	<p><?php _e( '3) Create a Review Slider or Grid for your site on the "Templates" page. By default the review template will show all your reviews; you can use the filters to only show the reviews you want.', 'wp-airbnb-review-slider' ); ?></p>
	<p><?php _e( 'If you have any trouble please check the', 'wp-airbnb-review-slider' ); ?> <a href="https://wordpress.org/support/plugin/wp-airbnb-review-slider/" target="_blank"><?php _e( 'Support Forum', 'wp-airbnb-review-slider' ); ?></a> <?php _e( 'first. If you want to contact me privately you can use the form on my website', 'wp-airbnb-review-slider' ); ?> <a href="https://wpreviewslider.com/contact/"><?php _e( 'here', 'wp-airbnb-review-slider' ); ?></a>.</p>
	<p><?php _e( 'Thanks!', 'wp-airbnb-review-slider' ); ?><br>Josh<br><?php _e( 'Developer/Creator', 'wp-airbnb-review-slider' ); ?></p>
</div>
</div>
<div class="w3-col s12 m6 welcomediv w3-container ">
<div class="welcomediv w3-white w3-border w3-border-light-gray2 w3-round-small">
<a id="provimg" href="https://wpreviewslider.com/" target="_blank"><img class="wprev_wpproimg" src="<?php echo esc_url( plugin_dir_url( __FILE__ ) . 'sitelogo4.png?v=' . $this->version ); ?>"></a>
	<h3><?php _e( 'Pro Version Features!', 'wp-airbnb-review-slider' ); ?></h3>
	<ul style="list-style-type: circle;margin-left: 20px;">
	<li><?php _e( 'Personal support from the developer! I\'ll even help set it up!', 'wp-airbnb-review-slider' ); ?></li>
	<li><?php _e( 'Download all your Airbnb reviews from multiple listings plus images!', 'wp-airbnb-review-slider' ); ?></li>
	<li><?php _e( 'Also get reviews from Google, Facebook, Yelp, TripAdvisor, and 90+ other sites!', 'wp-airbnb-review-slider' ); ?></li>
	<li><?php _e( 'Show reviews in a Grid, Rows, Slider, Masonry, with endless scroll and different pagination options!', 'wp-airbnb-review-slider' ); ?></li>
	<li><?php _e( 'Hide certain reviews from displaying.', 'wp-airbnb-review-slider' ); ?></li>
	<li><?php _e( 'Manually add reviews or upload a CSV file.', 'wp-airbnb-review-slider' ); ?></li>
	<li><?php _e( 'Access 11+ review template styles and create a child theme.', 'wp-airbnb-review-slider' ); ?></li>
	<li><?php _e( 'Lots of cool badges, floats, and pop-ins!', 'wp-airbnb-review-slider' ); ?></li>
	<li><?php printf( __( 'See all features %1$shere%2$s. Plus get access to all new features I add in the future!', 'wp-airbnb-review-slider' ), '<b><a href="https://wpreviewslider.com/features/" target="_blank">', '</a></b>' ); ?></li>
</ul>
</div>
</div>

</div>

<div id="reviewdiv" class="welcomecontainer wpfbr_margin10 w3-row-padding w3-section w3-stretch wpfbr_margin10">
<div class="w3-col s12 m12 w3-container ">
<div class="welcomediv w3-white w3-border w3-border-light-gray2 w3-round-small">
<h5><?php _e( 'As a thank you for trying my free plugin, here\'s a special promo code to save 15% when you go Pro!', 'wp-airbnb-review-slider' ); ?></h5>
<code>WPPRO15</code>

<h5><?php _e( 'Some feedback from over 10k+ happy Pro customers:', 'wp-airbnb-review-slider' ); ?></h5>

<div class="w3_wprs-row">
	<div class="w3_wprs-col s4">
		<style>.wpairbnb_t1_DIV_2::after{ border-top: 30px solid #fdfdfd; }.wpairbnb_t1_DIV_1 {margin: 5px;}a { text-decoration: none; }</style>
		<div class="w3_wprs-col">
			<div class="wpairbnb_t1_DIV_1">
				<div class="wpairbnb_t1_DIV_2 wprev_preview_bg1 wprev_preview_bradius" style="border-radius: 0px; background: rgb(253, 253, 253);"><p class="wpairbnb_t1_P_3 wprev_preview_tcolor1" style="color: rgb(85, 85, 85);"><span class="wpairbnb_star_imgs"><img src="https://ljapps.com/wp-content/plugins/wp-review-slider-pro-premium/public/partials/imgs/stars_5_yellow.png" alt="">&nbsp;&nbsp;</span><?php _e( 'Perfect for our vacation rental! Easy to set up and guests love seeing real Airbnb reviews on our site.', 'wp-airbnb-review-slider' ); ?></p></div>
				<span class="wpairbnb_t1_A_8"><img src="https://s3-us-west-2.amazonaws.com/freemius/plugins//reviews/c8174af85095ea546c03cddd103abfd2.jpg" alt="thumb" class="wpairbnb_t1_IMG_4"></span>
				<span class="wpairbnb_t1_SPAN_5 wprev_preview_tcolor2" style="color: rgb(85, 85, 85);">Antony Bowers<br>Director, <a href="https://www.sweetfantasies.co.uk" target="_blank">Sweet Fantasies Cakes</a></span>
			</div>
		</div>
	</div>
	<div class="w3_wprs-col s4">
		<div class="w3_wprs-col">
			<div class="wpairbnb_t1_DIV_1">
				<div class="wpairbnb_t1_DIV_2 wprev_preview_bg1 wprev_preview_bradius" style="border-radius: 0px; background: rgb(253, 253, 253);"><p class="wpairbnb_t1_P_3 wprev_preview_tcolor1" style="color: rgb(85, 85, 85);"><span class="wpairbnb_star_imgs"><img src="https://ljapps.com/wp-content/plugins/wp-review-slider-pro-premium/public/partials/imgs/stars_5_yellow.png" alt="">&nbsp;&nbsp;</span><?php _e( 'Great product, great support! Love this plugin and the support received has been amazing and fast.', 'wp-airbnb-review-slider' ); ?></p></div>
				<span class="wpairbnb_t1_A_8"><img src="https://wpreviewslider.com/wp-content/uploads/wprevslider/avatars/1633774408_188.jpg" alt="thumb" class="wpairbnb_t1_IMG_4"></span>
				<span class="wpairbnb_t1_SPAN_5 wprev_preview_tcolor2" style="color: rgb(85, 85, 85);">Russ Kemp<br>Owner, <a href="https://www.russkempphotography.com" target="_blank">Russ Kemp Photography</a></span>
			</div>
		</div>
	</div>
	<div class="w3_wprs-col s4">
		<div class="w3_wprs-col">
			<div class="wpairbnb_t1_DIV_1">
				<div class="wpairbnb_t1_DIV_2 wprev_preview_bg1 wprev_preview_bradius" style="border-radius: 0px; background: rgb(253, 253, 253);"><p class="wpairbnb_t1_P_3 wprev_preview_tcolor1" style="color: rgb(85, 85, 85);"><span class="wpairbnb_star_imgs"><img src="https://ljapps.com/wp-content/plugins/wp-review-slider-pro-premium/public/partials/imgs/stars_5_yellow.png" alt="">&nbsp;&nbsp;</span><b><?php _e( 'Wow this thing really works!', 'wp-airbnb-review-slider' ); ?></b> <?php _e( 'Exactly what I needed to show Airbnb reviews in a slider. Highly recommend!', 'wp-airbnb-review-slider' ); ?></p></div>
				<span class="wpairbnb_t1_A_8"><img src="https://wpreviewslider.com/wp-content/uploads/wprevslider/avatars/1649464747_442.jpg" alt="thumb" class="wpairbnb_t1_IMG_4"></span>
				<span class="wpairbnb_t1_SPAN_5 wprev_preview_tcolor2" style="color: rgb(85, 85, 85);">Andrea Barnes<br>Developer, <a href="https://websitessandiego.com" target="_blank">Websites San Diego</a></span>
			</div>
		</div>
	</div>
</div>
<br>
<a href="https://wpreviewslider.com/pricing/#customerfeedback" target="_blank" class="w3-button w3-round w3-border w3-greentrip w3-margin-bottom w3-margin-top"><?php _e( 'Read More Pro Version Feedback Here', 'wp-airbnb-review-slider' ); ?></a>

</div>
</div>
</div>

</div>
</div>
