<?php
$urltrimmedtab = remove_query_arg( array( 'page', 'deleterev', '_wpnonce', 'taction', 'tid', 'sortby', 'sortdir', 'opt', 'settings-updated' ) );

$urlreviewlist    = esc_url( add_query_arg( 'page', 'wp_airbnb-reviews', $urltrimmedtab ) );
$urltemplateposts = esc_url( add_query_arg( 'page', 'wp_airbnb-templates_posts', $urltrimmedtab ) );
$urlgetairbnb     = esc_url( add_query_arg( 'page', 'wp_airbnb-get_airbnb', $urltrimmedtab ) );
$urlwelcome       = esc_url( add_query_arg( 'page', 'wp_airbnb-welcome', $urltrimmedtab ) );
?>
	<div class="w3-bar w3-border w3-white">
	<a href="<?php echo $urlwelcome; ?>" class="w3-bar-item w3-button <?php if ( isset( $_GET['page'] ) && $_GET['page'] === 'wp_airbnb-welcome' ) { echo 'w3-greentrip'; } ?>"><i class="fa fa-home"></i> <?php _e( 'Welcome', 'wp-airbnb-review-slider' ); ?></a>
	<a href="<?php echo $urlgetairbnb; ?>" class="w3-bar-item w3-button <?php if ( isset( $_GET['page'] ) && $_GET['page'] === 'wp_airbnb-get_airbnb' ) { echo 'w3-greentrip'; } ?>"><i class="fa fa-search"></i> <?php _e( 'Get Airbnb Reviews', 'wp-airbnb-review-slider' ); ?></a>
	<a href="<?php echo $urlreviewlist; ?>" class="w3-bar-item w3-button <?php if ( isset( $_GET['page'] ) && $_GET['page'] === 'wp_airbnb-reviews' ) { echo 'w3-greentrip'; } ?>"><i class="fa fa-list"></i> <?php _e( 'Review List', 'wp-airbnb-review-slider' ); ?></a>
	<a href="<?php echo $urltemplateposts; ?>" class="w3-bar-item w3-button <?php if ( isset( $_GET['page'] ) && $_GET['page'] === 'wp_airbnb-templates_posts' ) { echo 'w3-greentrip'; } ?>"><i class="fa fa-commenting-o"></i> <?php _e( 'Templates', 'wp-airbnb-review-slider' ); ?></a>
	<a href="https://wpreviewslider.com/" target="_blank" class="goprohbtntrip w3-bar-item w3-button"><i class="fa fa-external-link-square" aria-hidden="true"></i> <?php _e( 'Get Pro Version!', 'wp-airbnb-review-slider' ); ?></a>

	</div>
