<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    WP_Airbnb_Review
 * @subpackage WP_Airbnb_Review/admin/partials
 */

    // check user capabilities
   if (!current_user_can('manage_options')) {
       return;
   }
	$html="";
//db function variables
global $wpdb;
$table_name = $wpdb->prefix . 'wpairbnb_reviews';
$rowsperpage = 20;
$nonce = wp_create_nonce( 'my-nonce' );
?>
<div class="">
<h1></h1>
<div class="wrap" id="wp_rev_maindiv">

<img class="wprev_headerimg" src="<?php echo esc_url( plugin_dir_url( __FILE__ ) . 'logo.png?v=' . $this->version ); ?>">
<?php 
include("tabmenu.php");
?>	
<div class="wpfbr_margin10">
<div class="w3-col welcomediv w3-container w3-white w3-border w3-border-light-gray2 w3-round-small">


<div class="wpairbnb_margin10">
	<a id="wpairbnb_helpicon" class="wpairbnb_btnicononly button dashicons-before dashicons-editor-help"></a>
	<a id="wpairbnb_removeallbtn" data-sec="<?php echo esc_attr( $nonce ); ?>" class="button dashicons-before dashicons-no"><?php _e('Remove All Reviews', 'wp-airbnb-review-slider'); ?></a>
<p>
	<?php 
_e('Click the eye icon to hide or show a review, the pencil to edit the reviewer avatar and date, or the trash icon to delete. Search reviews, manually add reviews, save a CSV file of your reviews to your computer, and more features available in the <a href="https://wpreviewslider.com/" target="_blank">Pro Version</a> of this plugin!', 'wp-airbnb-review-slider'); 
?>
</p>
</div>

<div id="wpairbnb_new_review">
<table class="form-table">
	<tbody>
		<tr class="wpairbnb_row">
			<th scope="row"><?php esc_html_e( 'Reviewer Name:', 'wp-airbnb-review-slider' ); ?></th>
			<td><input id="wpairbnb_nr_name" type="text" name="wpairbnb_nr_name" value="" readonly class="regular-text"></td>
		</tr>
		<tr class="wpairbnb_row">
			<th scope="row"><?php esc_html_e( 'Rating:', 'wp-airbnb-review-slider' ); ?></th>
			<td><input id="wpairbnb_nr_rating" type="text" name="wpairbnb_nr_rating" value="" readonly class="regular-text"></td>
		</tr>
		<tr class="wpairbnb_row">
			<th scope="row"><?php esc_html_e( 'Review Text:', 'wp-airbnb-review-slider' ); ?></th>
			<td><textarea id="wpairbnb_nr_text" name="wpairbnb_nr_text" cols="50" rows="4" readonly></textarea></td>
		</tr>
		<tr class="wpairbnb_row">
			<th scope="row"><?php esc_html_e( 'Reviewer Avatar URL:', 'wp-airbnb-review-slider' ); ?></th>
			<td>
				<input id="wpairbnb_nr_avatar_url" type="text" name="wpairbnb_nr_avatar_url" value="" class="regular-text">
				<a id="upload_avatar_button" class="button"><?php esc_html_e( 'Upload', 'wp-airbnb-review-slider' ); ?></a>
				<br><p class="description"><?php esc_html_e( 'Avatar for the person who wrote the review.', 'wp-airbnb-review-slider' ); ?></p>
				<img class="" height="60px" id="avatar_preview" src="" alt="">
			</td>
		</tr>
		<tr class="wpairbnb_row">
			<th scope="row"><?php esc_html_e( 'Review Date:', 'wp-airbnb-review-slider' ); ?></th>
			<td>
				<input id="wpairbnb_nr_date" type="text" name="wpairbnb_nr_date" class="regular-text" value="">
				<p class="description"><?php esc_html_e( 'Format: YYYY-MM-DD HH:MM:SS.', 'wp-airbnb-review-slider' ); ?></p>
			</td>
		</tr>
	</tbody>
</table>
<div id="wpairbnb_save_review_msg"></div>
<input type="hidden" name="editrid" id="editrid" value="">
<a id="wpairbnb_submitreviewbtn" class="button button-primary"><?php esc_html_e( 'Save Review', 'wp-airbnb-review-slider' ); ?></a>
<a id="wpairbnb_addnewreview_cancel" class="button button-secondary"><?php esc_html_e( 'Cancel', 'wp-airbnb-review-slider' ); ?></a>
</div>

<?php 

	//remove all, first make sure they want to remove all
	if(isset($_GET['opt']) && $_GET['opt']=="delall"){
		//security
		$nonce = $_REQUEST['_wpnonce'];
		if ( ! wp_verify_nonce( $nonce, 'my-nonce' ) ) {
			// This nonce is not valid.
			die( __( 'Failed security check.', 'wp-airbnb-review-slider' ) ); 
		}

		$delete = $wpdb->query("TRUNCATE TABLE `".$table_name."`");
	}
	
	//pagenumber
	if(isset($_GET['pnum'])){
	$temppagenum = $_GET['pnum'];
	} else {
	$temppagenum ="";
	}
	if ( $temppagenum=="") {
		$pagenum = 1;
	} else if(is_numeric($temppagenum)){
		$pagenum = intval($temppagenum);
	}
	
	if(!isset($_GET['sortdir'])){
		$_GET['sortdir'] = "";
	}
	if ( $_GET['sortdir']=="" || $_GET['sortdir']=="DESC") {
		$sortdirection = "&sortdir=ASC";
	} else {
		$sortdirection = "&sortdir=DESC";
	}
	$currenturl = remove_query_arg( 'sortdir' );
	
	//make sure sortby is valid
	if(!isset($_GET['sortby'])){
		$_GET['sortby'] = "";
	}
	$allowed_keys = ['created_time_stamp', 'reviewer_name', 'rating', 'review_length', 'pagename', 'type' ];
	$checkorderby = sanitize_key($_GET['sortby']);
	
		if(in_array($checkorderby, $allowed_keys, true) && $_GET['sortby']!=""){
			$sorttable = $_GET['sortby']. " ";
		} else {
			$sorttable = "created_time_stamp ";
		}
		if($_GET['sortdir']=="ASC" || $_GET['sortdir']=="DESC"){
			$sortdir = $_GET['sortdir'];
		} else {
			$sortdir = "DESC";
		}
		unset($sorticoncolor);
		for ($x = 0; $x <= 10; $x++) {
			$sorticoncolor[$x]="";
		} 
		if($sorttable=="hide "){
			$sorticoncolor[0]="text_green";
		} else if($sorttable=="reviewer_name "){
			$sorticoncolor[1]="text_green";
		} else if($sorttable=="rating "){
			$sorticoncolor[2]="text_green";
		} else if($sorttable=="created_time_stamp "){
			$sorticoncolor[3]="text_green";
		} else if($sorttable=="review_length "){
			$sorticoncolor[4]="text_green";
		} else if($sorttable=="pagename "){
			$sorticoncolor[5]="text_green";
		} else if($sorttable=="type "){
			$sorticoncolor[6]="text_green";	
		}
		
		$html .= '
		<table class="wp-list-table widefat striped posts">
			<thead>
				<tr>
					<th scope="col" width="70px" class="manage-column">'.__('Actions', 'wp-airbnb-review-slider').'</th>
					<th scope="col" width="50px" class="manage-column">'.__('Pic', 'wp-airbnb-review-slider').'</th>
					<th scope="col" style="min-width:70px" class="manage-column"><a href="'.esc_url( add_query_arg( 'sortby', 'reviewer_name',$currenturl ) ).$sortdirection.'"><i class="dashicons dashicons-sort '.$sorticoncolor[1].'" aria-hidden="true"></i> '.__('Name', 'wp-airbnb-review-slider').'</a></th>
					<th scope="col" width="70px" class="manage-column"><a href="'.esc_url( add_query_arg( 'sortby', 'rating',$currenturl ) ).$sortdirection.'"><i class="dashicons dashicons-sort '.$sorticoncolor[2].'" aria-hidden="true"></i> '.__('Rating', 'wp-airbnb-review-slider').'</a></th>
					<th scope="col" class="manage-column">'.__('Review Text', 'wp-airbnb-review-slider').'</th>
					<th scope="col" width="100px" class="manage-column"><a href="'.esc_url( add_query_arg( 'sortby', 'created_time_stamp',$currenturl ) ).$sortdirection.'"><i class="dashicons dashicons-sort '.$sorticoncolor[3].'" aria-hidden="true"></i> '.__('Date', 'wp-airbnb-review-slider').'</a></th>
					<th scope="col" width="70px" class="manage-column"><a href="'.esc_url( add_query_arg( 'sortby', 'review_length',$currenturl ) ).$sortdirection.'"><i class="dashicons dashicons-sort '.$sorticoncolor[4].'" aria-hidden="true"></i> '.__('Length', 'wp-airbnb-review-slider').'</a></th>
					<th scope="col" width="100px" class="manage-column"><a href="'.esc_url( add_query_arg( 'sortby', 'pagename',$currenturl ) ).$sortdirection.'"><i class="dashicons dashicons-sort '.$sorticoncolor[5].'" aria-hidden="true"></i> '.__('Page Name', 'wp-airbnb-review-slider').'</a></th>
					<th scope="col" width="100px" class="manage-column"><a href="'.esc_url( add_query_arg( 'sortby', 'type',$currenturl ) ).$sortdirection.'"><i class="dashicons dashicons-sort '.$sorticoncolor[6].'" aria-hidden="true"></i> '.__('Type', 'wp-airbnb-review-slider').'</a></th>
				</tr>
				</thead>
			<tbody id="review_list">';
		//get reviews from db
		$lowlimit = ($pagenum - 1) * $rowsperpage;
		$tablelimit = $lowlimit.",".$rowsperpage;
		$reviewsrows = $wpdb->get_results(
			$wpdb->prepare("SELECT * FROM ".$table_name."
			WHERE id>%d
			ORDER BY ".$sorttable." ".$sortdir." 
			LIMIT ".$tablelimit." ", "0")
		);
		//total number of rows
		$reviewtotalcount = $wpdb->get_var( 'SELECT COUNT(*) FROM '.$table_name );
		//total pages
		$totalpages = ceil($reviewtotalcount/$rowsperpage);
		
		if($reviewtotalcount>0){
			foreach ( $reviewsrows as $reviewsrow ) 
			{
				if($reviewsrow->hide!="yes"){
					$hideicon = '<i title="'.esc_attr__('Shown - click to hide', 'wp-airbnb-review-slider').'" class="hiderevbtn dashicons dashicons-visibility text_green" aria-hidden="true"></i>';
					$hiddentrclass = '';
				} else {
					$hideicon = '<i title="'.esc_attr__('Hidden - click to show', 'wp-airbnb-review-slider').'" class="hiderevbtn dashicons dashicons-hidden" aria-hidden="true"></i>';
					$hiddentrclass = 'hiddenrow';
				}

				$editdellink = '<span title="'.esc_attr__('Edit', 'wp-airbnb-review-slider').'" class="reveditbtn dashicons dashicons-edit"></span> <span title="'.esc_attr__('Delete', 'wp-airbnb-review-slider').'" class="revdelbtn text_red dashicons dashicons-trash"></span>';

				//prefer the locally cached avatar if we have one
				$userpicsrc = ( isset($reviewsrow->userpiclocal) && $reviewsrow->userpiclocal!='' ) ? $reviewsrow->userpiclocal : $reviewsrow->userpic;
				$userpic = '<img style="-webkit-user-select: none;width: 50px;" src="'.esc_url($userpicsrc).'" alt="">';

				//review media thumbnails (lity lightbox)
				$mediahtml = '';
				if( isset($reviewsrow->mediaurlsarrayjson) && $reviewsrow->mediaurlsarrayjson!='' ){
					$imagesarray = json_decode( $reviewsrow->mediaurlsarrayjson, true );
					if( is_array($imagesarray) && count($imagesarray)>0 ){
						$mediahtml = '<div class="mediaimgsdiv">';
						foreach ( $imagesarray as $imgurl ) {
							if($imgurl!=''){
								$mediahtml .= '<a href="'.esc_url($imgurl).'" data-lity target="_blank"><img src="'.esc_url($imgurl).'" height="50" alt=""></a> ';
							}
						}
						$mediahtml .= '</div>';
					}
				}

	
				$html .= '<tr id="'.$reviewsrow->id.'" class="'.esc_attr($hiddentrclass).'">
						<th scope="col" class="manage-column">'.$hideicon.' '.$editdellink.'</th>
						<th scope="col" class="wprev_row_userpic manage-column">'.$userpic.'</th>
						<th scope="col" class="wprev_row_reviewer_name manage-column">'.esc_html($reviewsrow->reviewer_name).'</th>
						<th scope="col" class="wprev_row_rating manage-column">'.esc_html($reviewsrow->rating).'</th>
						<th scope="col" class="wprev_row_review_text manage-column">'.esc_html($reviewsrow->review_text).$mediahtml.'</th>
						<th scope="col" class="wprev_row_created_time manage-column">'.esc_html($reviewsrow->created_time).'</th>
						<th scope="col" class="manage-column">'.esc_html($reviewsrow->review_length).'</th>
						<th scope="col" class="manage-column">'.esc_html($reviewsrow->pagename).'</th>
						<th scope="col" class="manage-column">'.esc_html($reviewsrow->type).'</th>
					</tr>';
			}
		} else {
				$html .= '<tr>
						<th colspan="9" scope="col" class="manage-column">'.__('No reviews found. Please visit the <a href="?page=wp_airbnb-get_airbnb">Get Airbnb Reviews</a> page to retrieve reviews.', 'wp-airbnb-review-slider').'</th>
					</tr>';
		}					
				
				
		$html .= '</tbody>
		</table>';
		
		$html .= '<div id="wpairbnb_review_list_pagination_bar">';
		$currenturl = remove_query_arg( 'pnum' );
		for ($x = 1; $x <= $totalpages; $x++) {
			if($x==$pagenum){$blue_grey = "blue_grey";} else {$blue_grey ="";}
			$html .= '<a href="'.esc_url( add_query_arg( 'pnum', $x,$currenturl ) ).'" class="button '.$blue_grey.'">'.$x.'</a>';
		} 
		
		$html .= '</div>';
				
		$html .= '</div>';		
 
echo $html;
?>
</div></div></div>



	<div id="popup_review_list" class="popup-wrapper wpairbnb_hide">
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
	
