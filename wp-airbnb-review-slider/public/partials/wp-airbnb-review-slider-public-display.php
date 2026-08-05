<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    WP_Airbnb_Review
 * @subpackage WP_Airbnb_Review/public/partials
 */

 	//db function variables
	global $wpdb;
	$table_name = $wpdb->prefix . 'wpairbnb_post_templates';
	
 //use the template id to find template in db, echo error if we can't find it or just don't display anything
 	//Get the form--------------------------
	$tid = htmlentities($a['tid']);
	$tid = intval($tid);
	$currentform = $wpdb->get_results("SELECT * FROM $table_name WHERE id = ".$tid);
	
	//check to make sure template found
	if(isset($currentform[0])){
		
		//use values from currentform to get reviews from db
		$table_name = $wpdb->prefix . 'wpairbnb_reviews';
		
		if($currentform[0]->hide_no_text=="yes"){
			$min_words = 2;
			$max_words = 5000;
		} else {
			$min_words = 0;
			$max_words = 5000;
		}
		
		if($currentform[0]->display_order=="random"){
			$sorttable = "RAND() ";
			$sortdir = "";
		} else {
			$sorttable = "created_time_stamp ";
			$sortdir = "DESC";
		}

		$reviewsperpage= $currentform[0]->display_num*$currentform[0]->display_num_rows;
		$tablelimit = $reviewsperpage;
		//change limit for slider
		if($currentform[0]->createslider == "yes"){
			$tablelimit = $tablelimit*$currentform[0]->numslides;
		}
		
		//----------------------
		//pro filter settings 	min_words, max_words, min_rating, rtype, rpage, showreviewsbyid========
		if($currentform[0]->min_words>0){
			$min_words = intval($currentform[0]->min_words);
		}
		if($currentform[0]->max_words>0){
			$max_words = intval($currentform[0]->max_words);
		}
		
		//min_rating filter----
		if($currentform[0]->min_rating>0){
			$min_rating = intval($currentform[0]->min_rating);
		} else {
			$min_rating ="";
		}
		
		//rtype filter-----
		$rtypefilter = "";
		if($currentform[0]->rtype!=""){
			$rtypearray = json_decode($currentform[0]->rtype);
			$rtypearray = array_filter($rtypearray);
			$rtypearray = array_values($rtypearray);
			if(count($rtypearray)>0){
				for ($x = 0; $x < count($rtypearray); $x++) {
					if($rtypearray[$x]=="fb"){$rtypearray[$x]="Facebook";}
					if($rtypearray[$x]=="manual"){$rtypearray[$x]="Manual";}
					if($rtypearray[$x]=="airbnb"){$rtypearray[$x]="Airbnb";}
					
					if($x==0){
						$rtypefilter = "AND (type = '".$rtypearray[$x]."'";
					} else {
						$rtypefilter = $rtypefilter." OR type = '".$rtypearray[$x]."'";
					}
				}
				$rtypefilter = $rtypefilter.")";
			}
		}
		//source (rpage) filter — single pageid, safely bound via $wpdb->prepare below.
		//Backward compatible: legacy JSON-array values use the first pageid, and an
		//empty value falls back to the last-added source (or the newest review).
		$filtersource = isset($currentform[0]->rpage) ? trim($currentform[0]->rpage) : "";
		if($filtersource!=""){
			$decodedsource = json_decode($filtersource, true);
			if(is_array($decodedsource)){
				$decodedsource = array_values(array_filter($decodedsource));
				$filtersource = isset($decodedsource[0]) ? $decodedsource[0] : "";
			}
		}
		if($filtersource==""){
			$crawlsraw = get_option('wprev_airbnb_crawls');
			$crawls = $crawlsraw ? json_decode($crawlsraw, true) : array();
			if(is_array($crawls) && count($crawls)>0){
				$crawlkeys = array_keys($crawls);
				$filtersource = (string) end($crawlkeys);
			}
			if($filtersource==""){
				$newestpageid = $wpdb->get_var("SELECT pageid FROM ".$table_name." WHERE pageid != '' ORDER BY created_time_stamp DESC LIMIT 1");
				if($newestpageid){
					$filtersource = $newestpageid;
				}
			}
		}
		
		//showreviewsbyid filter---------replaces all other filters
		$onlyselected = false;
		if($currentform[0]->showreviewsbyid!=""){
			$showreviewsbyidarray = json_decode($currentform[0]->showreviewsbyid);
			$showreviewsbyidarray = array_filter($showreviewsbyidarray);
			$showreviewsbyidarray = array_values($showreviewsbyidarray);
			if(count($showreviewsbyidarray)>0){
				$onlyselected = true;
			}
		}
		
		if($onlyselected){
			$query = "SELECT * FROM ".$table_name." WHERE id IN (";
			//loop array and add to query
			$n=1;
			foreach ($showreviewsbyidarray as $value) {
				if($value!=""){
					if(count($showreviewsbyidarray)==$n){
						$query = $query." $value";
					} else {
						$query = $query." $value,";
					}
				}
				$n++;
			}
			$query = $query.")";
			$totalreviews = $wpdb->get_results($query);
		} else {
			$sourcefilter = "";
			$prepareargs = array( "0", $min_words, $max_words, $min_rating, "yes" );
			if($filtersource!=""){
				$sourcefilter = " AND pageid = %s";
				$prepareargs[] = $filtersource;
			}
			$totalreviews = $wpdb->get_results(
				$wpdb->prepare("SELECT * FROM ".$table_name."
				WHERE id>%d AND review_length >= %d AND review_length <= %d AND rating >= %d AND hide != %s ".$rtypefilter.$sourcefilter."
				ORDER BY ".$sorttable." ".$sortdir." 
				LIMIT ".$tablelimit." ", $prepareargs)
			);
		}

		//echo $wpdb->last_query ;
			
			//print_r($totalreviews);
			//echo "<br><br>";
			
	//only continue if some reviews found
	$makingslideshow=false;
	if(count($totalreviews)>0){

		//if creating a slider than we need to split into chunks for each slider
		//if($currentform[0]->createslider == "yes"){
			//print_r(array_chunk($totalreviews, $reviewsperpage));
			$totalreviewschunked = array_chunk($totalreviews, $reviewsperpage);
		//}
		//loop through each chunk
		
		
			//add styles from template misc here
			$misc_style ="";
			$template_misc_array = json_decode($currentform[0]->template_misc, true);
			if(is_array($template_misc_array)){
				
				//hide stars and/or date
				if($template_misc_array['showstars']=="no"){
					$misc_style = $misc_style . '#wprev-slider-'.$currentform[0]->id.' .wprevpro_star_imgs_T'.$currentform[0]->style.' {display: none;}';
				}
				if($template_misc_array['showdate']=="no"){
					$misc_style = $misc_style . '#wprev-slider-'.$currentform[0]->id.' .wprev_showdate_T'.$currentform[0]->style.' {display: none;}';
				}
				
				
				$misc_style = $misc_style . '#wprev-slider-'.$currentform[0]->id.' .wprev_preview_bradius_T'.$currentform[0]->style.' {border-radius: '.$template_misc_array['bradius'].'px;}';
				if(isset($template_misc_array['bgcolor1']) && $template_misc_array['bgcolor1']!=''){
				$misc_style = $misc_style . '#wprev-slider-'.$currentform[0]->id.' .wprev_preview_bg1_T'.$currentform[0]->style.' {background:'.$template_misc_array['bgcolor1'].';}';
				}
				if(isset($template_misc_array['bgcolor2']) && $template_misc_array['bgcolor2']!=''){
				$misc_style = $misc_style . '#wprev-slider-'.$currentform[0]->id.' .wprev_preview_bg2_T'.$currentform[0]->style.' {background:'.$template_misc_array['bgcolor2'].';}';
				}
				if(isset($template_misc_array['tcolor1']) && $template_misc_array['tcolor1']!=''){
				$misc_style = $misc_style . '#wprev-slider-'.$currentform[0]->id.' .wprev_preview_tcolor1_T'.$currentform[0]->style.' {color:'.$template_misc_array['tcolor1'].';}';
				}
				if(isset($template_misc_array['tcolor2']) && $template_misc_array['tcolor2']!=''){
				$misc_style = $misc_style . '#wprev-slider-'.$currentform[0]->id.' .wprev_preview_tcolor2_T'.$currentform[0]->style.' {color:'.$template_misc_array['tcolor2'].';}';
				}
				
				//style specific mods 	div > p
				if($currentform[0]->style=="1"){
					$misc_style = $misc_style . '#wprev-slider-'.$currentform[0]->id.' .wprev_preview_bg1_T'.$currentform[0]->style.'::after{ border-top: 30px solid '.$template_misc_array['bgcolor1'].'; }';
				}
				if($currentform[0]->style=="2"){
					$misc_style = $misc_style . '#wprev-slider-'.$currentform[0]->id.' .wprev_preview_bg1_T'.$currentform[0]->style.' {border-bottom:3px solid '.$template_misc_array['bgcolor2'].'}';
				}
				if($currentform[0]->style=="3"){
					$misc_style = $misc_style . '#wprev-slider-'.$currentform[0]->id.' .wprev_preview_tcolor3_T'.$currentform[0]->style.' {text-shadow:'.$template_misc_array['tcolor3'].' 1px 1px 0px;}';
				}
				if($currentform[0]->style=="4"){
					$misc_style = $misc_style . '#wprev-slider-'.$currentform[0]->id.' .wprev_preview_tcolor3_T'.$currentform[0]->style.' {color:'.$template_misc_array['tcolor3'].';}';
				}

				//read more link color
				if ( ! empty( $template_misc_array['read_more_color'] ) ) {
					$rmc = trim( (string) $template_misc_array['read_more_color'] );
					if ( preg_match( '/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{4}|[0-9a-fA-F]{6}|[0-9a-fA-F]{8})$/', $rmc )
						|| preg_match( '/^rgba?\(\s*[\d.]+\s*,\s*[\d.]+\s*,\s*[\d.]+\s*(,\s*[\d.]+\s*)?\)$/i', $rmc ) ) {
						$misc_style = $misc_style . '#wprev-slider-' . $currentform[0]->id . ' .wprs_rd_more{color:' . $rmc . ';}';
					}
				}
	
				//echo "<style>".$misc_style."</style>";
				//$custom_css = $misc_style;
			}
			
		//print out user style added
		echo "<style>".$misc_style.$currentform[0]->template_css."</style>";
		//$custom_css = $misc_style . $currentform[0]->template_css;
		
		//wp_add_inline_style( 'wpairbnb_w3', $custom_css );

		//badge: open phase (style + outer wrap + left/above badge, no-op if Location is not set)
		//Prefer the misc override (kept in sync on save), else fall back to the
		//already-resolved single pageid from the reviews query above.
		if ( isset( $template_misc_array['filtersource'] ) && $template_misc_array['filtersource'] !== '' ) {
			$filtersource = $template_misc_array['filtersource'];
		}
		$wpairbnb_badge_phase = 'open';
		include plugin_dir_path( __FILE__ ) . 'wpairbnb_badge_render.php';

		//if making slide show then add it here

		// Style 6 without a badge: tighter arrow inset (see .wprev_style6_nobadge CSS).
		$style6_nobadge = '';
		if ( (string) $currentform[0]->style === '6' && $template_misc_array['blocation'] === '' ) {
			$style6_nobadge = ' wprev_style6_nobadge';
		}

		if($currentform[0]->createslider == "yes"){
			//make sure we have enough to create a show here
			if($totalreviews>$reviewsperpage){
				$makingslideshow = true;
				echo '<div class="wprev-slider'.esc_attr($style6_nobadge).'" id="wprev-slider-'.$currentform[0]->id.'"><ul>';
			}
		} else {
			echo '<div class="wprev-no-slider'.esc_attr($style6_nobadge).'" id="wprev-slider-'.$currentform[0]->id.'">';
		}
		$loopnum = 1;
		foreach ( $totalreviewschunked as $reviewschunked ){
			//echo "loop1";
			$totalreviewstemp = $reviewschunked;
			
			//need to break $totalreviewstemp up based on how many rows, create an multi array containing them
			if($currentform[0]->display_num_rows>1 && count($totalreviewstemp)>$currentform[0]->display_num){
				//count of reviews total is greater than display per row then we need to break in to multiple rows
				for ($row = 0; $row < $currentform[0]->display_num_rows; $row++) {
					$n=1;
					foreach ( $totalreviewstemp as $tempreview ){
						//echo "<br>".$tempreview->reviewer_name;
						//echo $n."-".$row."-".$currentform[0]->display_num;
						if($n>($row*$currentform[0]->display_num) && $n<=(($row+1)*$currentform[0]->display_num)){
							$rowarray[$row][$n]=$tempreview;
						}
						$n++;
					}
				}
			} else {
				//everything on one row so just put in multi array
				$rowarray[0]=$totalreviewstemp;
			}
			
			 
			//if making slide show
			if($makingslideshow){
				if($loopnum>1){
					echo '<li style="display:none;">';
				} else {
					echo '<li>';
				}
			}
		 
				//include the correct tid here
				if($currentform[0]->style=="1" || $currentform[0]->style=="2" || $currentform[0]->style=="3" || $currentform[0]->style=="4" || $currentform[0]->style=="5" || $currentform[0]->style=="6" || $currentform[0]->style=="7" || $currentform[0]->style=="8" || $currentform[0]->style=="9" || $currentform[0]->style=="10" ){
				$iswidget=false;
					include(plugin_dir_path( __FILE__ ) . 'template_style_'.$currentform[0]->style.'.php');
				}
			
			//if making slide show then end loop here
			if($makingslideshow){
					echo '</li>';
			}
			$loopnum++;
		}	//end loop chunks
		//if making slide show then end it
		if($makingslideshow){
			//grab db values
			if($currentform[0]->sliderautoplay!="" && $currentform[0]->sliderautoplay=='yes'){
				$autoplay = 'true';
			} else {
				$autoplay = 'false';
			}
			if($currentform[0]->sliderdirection=='vertical' || $currentform[0]->sliderdirection=='horizontal' || $currentform[0]->sliderdirection=='fade'){
				$animation = $currentform[0]->sliderdirection;
			} else {
				$animation = 'horizontal';
			}
			if($currentform[0]->sliderarrows!="" && $currentform[0]->sliderarrows=='no'){
				$arrows = 'false';
			} else {
				$arrows = 'true';
			}
			if($currentform[0]->sliderdots!="" && $currentform[0]->sliderdots=='no'){
				$slidedots = '$("#wprev-slider-'.$currentform[0]->id.'").siblings(".wprs_unslider-nav").hide();';
			} else {
				$slidedots = '$("#wprev-slider-'.$currentform[0]->id.'").siblings(".wprs_unslider-nav").show();';
			}

			if($currentform[0]->sliderdelay!="" && intval($currentform[0]->sliderdelay)>0){
				$delay = intval($currentform[0]->sliderdelay)*1000;
			} else {
				$delay = "5000";
			}
			
			//if($currentform[0]->sliderheight=="" || $currentform[0]->sliderheight!='yes'){
			//	$animateHeight = 'false';
			//} else {
				$animateHeight = 'true';
			//}
			
				echo '</ul></div>';
				/*echo "<script type='text/javascript' defer>
						function wprs_defer_trip(method) {
							if (window.jQuery) {
								method();
							} else {
								setTimeout(function() { wprs_defer_trip(method) }, 50);
							}
						}
						wprs_defer_trip(function () {
							jQuery(document).ready(function($) {
								$('#wprev-slider-".$currentform[0]->id."').wprs_unslider(
									{
									autoplay:".$autoplay.",
									delay: '".$delay."',
									animation: '".$animation."',
									arrows: ".$arrows.",
									animateHeight: ".$animateHeight.",
									activeClass: 'wprs_unslider-active',
									}
								);
								".$slidedots."
							});
						});
						</script>";
						*/
		} else {
		echo '</div>';
		}

		//badge: close phase (right-side badge, then close the outer wrap; no-op if Location is not set)
		$wpairbnb_badge_phase = 'close';
		include plugin_dir_path( __FILE__ ) . 'wpairbnb_badge_render.php';

	}
}
?>

