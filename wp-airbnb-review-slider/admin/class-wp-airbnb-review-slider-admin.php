<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    WP_Airbnb_Review
 * @subpackage WP_Airbnb_Review/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    WP_Airbnb_Review
 * @subpackage WP_Airbnb_Review/admin
 * @author     Your Name <email@example.com>
 */
class WP_Airbnb_Review_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugintoken    The ID of this plugin.
	 */
	private $plugintoken;
	private $_token;
	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;
	public $errormsg;
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugintoken       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugintoken, $version ) {

		$this->_token = $plugintoken;
		$this->version = $version;
				

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in WP_Airbnb_Review_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The WP_Airbnb_Review_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		//only load for this plugin wp_airbnb-settings-pricing
		if(isset($_GET['page'])){
			if($_GET['page']=="wp_airbnb-reviews" || $_GET['page']=="wp_airbnb-templates_posts" || $_GET['page']=="wp_airbnb-get_airbnb" || $_GET['page']=="wp_airbnb-get_pro" || $_GET['page']=="wp_airbnb-welcome" || $_GET['page']=="wp_airbnb-opt"){

			wp_register_style( 'Font_Awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css' );
			wp_enqueue_style('Font_Awesome');

			wp_enqueue_style( $this->_token."_wprev_w3", plugin_dir_url( __FILE__ ) . 'css/wprev_w3.css', array(), $this->version, 'all' );

			wp_enqueue_style( $this->_token, plugin_dir_url( __FILE__ ) . 'css/wpairbnb_admin.css', array(), $this->version, 'all' );
			wp_enqueue_style( $this->_token."_wpairbnb_w3", plugin_dir_url( __FILE__ ) . 'css/wpairbnb_w3.css', array(), $this->version, 'all' );
			}
			//load template styles for the templates page (Style 1 + Style 6 live preview)
			if($_GET['page']=="wp_airbnb-templates_posts" || $_GET['page']=="wp_airbnb-get_pro" || $_GET['page']=="wp_airbnb-welcome"){
				wp_enqueue_style( $this->_token."_style1", plugin_dir_url(dirname(__FILE__)) . 'public/css/wprev-public_template1.css', array(), $this->version, 'all' );
				wp_enqueue_style( $this->_token."_style6", plugin_dir_url(dirname(__FILE__)) . 'public/css/wprev-public_template6.css', array(), $this->version, 'all' );
			}
		}

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in WP_Airbnb_Review_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The WP_Airbnb_Review_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		

		//scripts for all pages in this plugin
		if(isset($_GET['page'])){
			if($_GET['page']=="wp_airbnb-reviews" || $_GET['page']=="wp_airbnb-templates_posts" || $_GET['page']=="wp_airbnb-get_airbnb" || $_GET['page']=="wp_airbnb-get_pro" || $_GET['page']=="wp_airbnb-welcome" || $_GET['page']=="wp_airbnb-opt"){
				//pop-up script
				wp_register_script( 'simple-popup-js',  plugin_dir_url( __FILE__ ) . 'js/wpairbnb_simple-popup.min.js' , '', $this->version, false );
				wp_enqueue_script( 'simple-popup-js' );
				
			}
			//scripts for the get airbnb reviews page (multi-source add/download)
			if($_GET['page']=="wp_airbnb-get_airbnb"){
				wp_enqueue_script('wpairbnb_get_airbnb-js', plugin_dir_url( __FILE__ ) . 'js/wpairbnb_get_airbnb.js', array( 'jquery' ), $this->version, false );
				wp_localize_script('wpairbnb_get_airbnb-js', 'adminjs_script_vars',
					array(
					'wpairbnb_nonce'=> wp_create_nonce('randomnoncestring')
					)
				);
			}
		}
		
	
		//scripts for review list page
		if(isset($_GET['page'])){
			if($_GET['page']=="wp_airbnb-reviews"){
				//admin js
				wp_enqueue_script('wpairbnb_review_list_page-js', plugin_dir_url( __FILE__ ) . 'js/wpairbnb_review_list_page.js', array( 'jquery','media-upload','thickbox' ), $this->version, false );
				//used for ajax
				wp_localize_script('wpairbnb_review_list_page-js', 'adminjs_script_vars', 
					array(
					'wpairbnb_nonce'=> wp_create_nonce('randomnoncestring')
					)
				);
				
 				wp_enqueue_script('thickbox');
				wp_enqueue_style('thickbox');
		 
				wp_enqueue_script('media-upload');
				wp_enqueue_script('wptuts-upload');

				//lity lightbox for review media thumbnails
				wp_enqueue_style( $this->_token."_lity_min", plugin_dir_url( __FILE__ ) . 'css/lity.min.css', array(), $this->version, 'all' );
				wp_enqueue_script( 'wpairbnb_lity-js', plugin_dir_url( __FILE__ ) . 'js/lity.min.js', array( 'jquery' ), $this->version, false );

			}
			
			//scripts for templates posts page
			if($_GET['page']=="wp_airbnb-templates_posts"){

				//add color picker here
				wp_enqueue_style( 'wp-color-picker' );
				//alpha add-on — extends Iris without replacing the WP color-result button markup
				wp_enqueue_script( 'wp-color-picker-alpha', plugin_dir_url( __FILE__ ) . 'js/wpairbnb-wp-color-picker-alpha.js', array( 'wp-color-picker' ), '3.0.0', false );

				//needed for the badge business image uploader (wp.media, not thickbox)
				wp_enqueue_media();

				//admin js
				wp_enqueue_script('wpairbnb_templates_posts_page-js', plugin_dir_url( __FILE__ ) . 'js/wpairbnb_templates_posts_page.js', array( 'jquery', 'wp-color-picker', 'wp-color-picker-alpha' ), $this->version, false );
				//used for ajax
				wp_localize_script('wpairbnb_templates_posts_page-js', 'adminjs_script_vars', 
					array(
					'wpairbnb_nonce'=> wp_create_nonce('randomnoncestring'),
					'pluginsUrl' => wprev_airbnb_plugin_url
					)
				);

				//slider engine so the live preview can build working sliders
				wp_enqueue_script( $this->_token."_unslider-swipe-min", plugin_dir_url( dirname( __FILE__ ) ) . 'public/js/wprs-unslider-swipe.js', array( 'jquery' ), $this->version, false );

				//thickbox kept for the remaining inline "pro settings" popup on this page
 				wp_enqueue_script('thickbox');
				wp_enqueue_style('thickbox');

			}
		}
		
	}
	
	public function add_menu_pages() {

		/**
		 * adds the menu pages to wordpress
		 */

		$page_title = 'WP Airbnb Reviews : Reviews List';
		$menu_title = 'WP Airbnb';
		$capability = 'manage_options';
		$menu_slug = 'wp_airbnb-welcome';
		
		add_menu_page($page_title, $menu_title, $capability, $menu_slug, array($this,'wp_airbnb_welcome'),'dashicons-star-half');
		// We add this submenu page with the same slug as the parent to ensure we don't get duplicates
		$sub_menu_title = __('Welcome', 'wp_airbnb-welcome');
		add_submenu_page($menu_slug, $page_title, $sub_menu_title, $capability, $menu_slug, array($this,'wp_airbnb_welcome'));
		
		// Now add the submenu page
		$submenu_page_title = 'WP Reviews Pro : Get Airbnb Reviews';
		$submenu_title = 'Get Airbnb Reviews';
		$submenu_slug = 'wp_airbnb-get_airbnb';
		
		//add_menu_page($page_title, $menu_title, $capability, $menu_slug, array($this,'wp_airbnb_getairbnb'),'dashicons-star-half');
		
		add_submenu_page($menu_slug, $submenu_page_title, $submenu_title, $capability, $submenu_slug, array($this,'wp_airbnb_getairbnb'));
		
		//add_menu_page($page_title, $menu_title, $capability, $menu_slug, array($this,'wp_airbnb_settings'),'dashicons-star-half');
		
		// Now add the submenu page for airbnb
		$submenu_page_title = 'WP Reviews Pro : Reviews List';
		$submenu_title = 'Review List';
		$submenu_slug = 'wp_airbnb-reviews';
		add_submenu_page($menu_slug, $submenu_page_title, $submenu_title, $capability, $submenu_slug, array($this,'wp_airbnb_reviews'));
		
		// Now add the submenu page for the reviews templates
		$submenu_page_title = 'WP Reviews Pro : Templates';
		$submenu_title = 'Templates';
		$submenu_slug = 'wp_airbnb-templates_posts';
		add_submenu_page($menu_slug, $submenu_page_title, $submenu_title, $capability, $submenu_slug, array($this,'wp_airbnb_templates_posts'));

		// Email opt-in (also used for first-visit redirect)
		add_submenu_page( $menu_slug, 'WP Airbnb Reviews : Email Opt-In', __( 'Email Opt-In', 'wp-airbnb-review-slider' ), $capability, 'wp_airbnb-opt', array( $this, 'wp_airbnb_opt' ) );

		// Now add the submenu page for the reviews templates
		//$submenu_page_title = 'WP FB Reviews : Upgrade';
		//$submenu_title = 'Get Pro';
		//$submenu_slug = 'wp_airbnb-get_pro';
		//add_submenu_page($menu_slug, $submenu_page_title, $submenu_title, $capability, $submenu_slug, array($this,'wp_fb_getpro'));


	}

	/**
	 * First visit to any plugin admin page: send users to the Brevo email opt-in
	 * until they Allow, Opt Out, or Skip.
	 */
	public function wpairbnb_maybe_redirect_optin() {
		if ( ! is_admin() || ! current_user_can( 'manage_options' ) ) {
			return;
		}
		if ( empty( $_GET['page'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			return;
		}
		$page = sanitize_text_field( wp_unslash( $_GET['page'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$plugin_pages = array(
			'wp_airbnb-welcome',
			'wp_airbnb-reviews',
			'wp_airbnb-get_airbnb',
			'wp_airbnb-templates_posts',
			'wp_airbnb-get_pro',
		);
		if ( ! in_array( $page, $plugin_pages, true ) ) {
			return;
		}
		$optin = get_option( 'wp_airbnb_optin', 'blank' );
		if ( in_array( $optin, array( 'blank', '' ), true ) ) {
			wp_safe_redirect( admin_url( 'admin.php?page=wp_airbnb-opt' ) );
			exit;
		}
	}

	public function wp_airbnb_opt() {
		require_once plugin_dir_path( __FILE__ ) . '/partials/opt.php';
	}

	public function wprev_airbnb_add_external_link_admin_submenu() {
		global $submenu;

		$menu_slug = 'wp_airbnb-welcome';

		if ( array_key_exists( $menu_slug, $submenu ) ) {
			$submenu[ $menu_slug ][] = array( '<div id="wprev-66023">Go Pro!</div>', 'manage_options', 'https://wpreviewslider.com/' );
		}
	}
	public function wpse_66023_add_jquery() 
	{
		?>
		<script type="text/javascript">
			jQuery(document).ready( function($) {   
				$('#wprev-66023').parent().attr('target','_blank');  
			});
		</script>
		<?php
	}
	
	public function wp_airbnb_welcome() {
		require_once plugin_dir_path( __FILE__ ) . '/partials/welcome.php';
	}
	
	public function wp_airbnb_reviews() {
		require_once plugin_dir_path( __FILE__ ) . '/partials/review_list.php';
	}
	
	public function wp_airbnb_templates_posts() {
		require_once plugin_dir_path( __FILE__ ) . '/partials/templates_posts.php';
	}
	public function wp_airbnb_getairbnb() {
		require_once plugin_dir_path( __FILE__ ) . '/partials/get_airbnb.php';
	}
	public function wp_fb_getpro() {
		require_once plugin_dir_path( __FILE__ ) . '/partials/get_pro.php';
	}

	/**
	 * custom option and settings on airbnb page
	 */
	 //===========start airbnb page settings===========================================================
	public function wpairbnb_airbnb_settings_init()
	{
	
		// register a new setting for "wp_airbnb-get_airbnb" page
		register_setting('wp_airbnb-get_airbnb', 'wpairbnb_airbnb_settings');
		
		// register a new section in the "wp_airbnb-get_airbnb" page
		add_settings_section(
			'wpairbnb_airbnb_section_developers',
			'',
			array($this,'wpairbnb_airbnb_section_developers_cb'),
			'wp_airbnb-get_airbnb'
		);
		
		//register airbnb business url input field
		add_settings_field(
			'airbnb_business_url', // as of WP 4.6 this value is used only internally
			'Airbnb Listing URL',
			array($this,'wpairbnb_field_airbnb_business_id_cb'),
			'wp_airbnb-get_airbnb',
			'wpairbnb_airbnb_section_developers',
			[
				'label_for'         => 'airbnb_business_url',
				'class'             => 'wpairbnb_row',
				'wpairbnb_custom_data' => 'custom',
			]
		);

		//Turn on Airbnb Reviews Downloader
		add_settings_field("airbnb_radio", "Turn On Airbnb Reviews", array($this,'airbnb_radio_display'), "wp_airbnb-get_airbnb", "wpairbnb_airbnb_section_developers",
			[
				'label_for'         => 'airbnb_radio',
				'class'             => 'wpairbnb_row',
				'wpairbnb_custom_data' => 'custom',
			]); 
	
	}
	//==== developers section cb ====
	public function wpairbnb_airbnb_section_developers_cb($args)
	{
		//echos out at top of section
		echo "<p>Use this page to download your newest Airbnb business reviews.</p><p><b>The Pro version will allow you to download all your reviews from all your listings and will keep them updated automatically.</b></b></p>";
	}
	
	//==== field cb =====
	public function wpairbnb_field_airbnb_business_id_cb($args)
	{
		// get the value of the setting we've registered with register_setting()
		$options = get_option('wpairbnb_airbnb_settings');
		
		// Ensure $options is an array
		if (!is_array($options)) {
			$options = array();
		}
		
		// Get the current value safely
		$current_value = isset($options[$args['label_for']]) ? $options[$args['label_for']] : '';

		// output the field
		?>
		<input id="<?= esc_attr($args['label_for']); ?>" data-custom="<?= esc_attr($args['wpairbnb_custom_data']); ?>" type="text" name="wpairbnb_airbnb_settings[<?= esc_attr($args['label_for']); ?>]" placeholder="" value="<?php echo esc_attr($current_value); ?>">
		
		<p class="description">
			<?= esc_html__('Copy and paste the Airbnb URL for your location and click Save Settings. Examples:', 'wp_airbnb-settings'); ?>
			</br>
			<?= esc_html__('https://www.airbnb.com/rooms/47530503', 'wp_airbnb-settings'); ?>
			</br>
			<?= esc_html__('https://www.airbnb.com/experiences/321167', 'wp_airbnb-settings'); ?>
			</br>

		</p>
		<?php
	}
	public function airbnb_radio_display($args)
		{
		$options = get_option('wpairbnb_airbnb_settings');
		
		// Ensure $options is an array
		if (!is_array($options)) {
			$options = array();
		}
		
		// Get the current value safely
		$current_value = isset($options[$args['label_for']]) ? $options[$args['label_for']] : '';
		
		   ?>
				<input type="radio" name="wpairbnb_airbnb_settings[<?= esc_attr($args['label_for']); ?>]" value="yes" <?php checked('yes', $current_value, true); ?>>Yes&nbsp;&nbsp;&nbsp;
				<input type="radio" name="wpairbnb_airbnb_settings[<?= esc_attr($args['label_for']); ?>]" value="no" <?php checked('no', $current_value, true); ?>>No
		   <?php
		}
	//=======end airbnb page settings========================================================

	
	/**
	 * Store reviews in table, called from javascript file admin.js
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function wpairbnb_process_ajax(){
	//ini_set('display_errors',1);  
	//error_reporting(E_ALL);
		
		check_ajax_referer('randomnoncestring', 'wpairbnb_nonce');
		
		$postreviewarray = $_POST['postreviewarray'];
		
		//var_dump($postreviewarray);

		//loop through each one and insert in to db
		global $wpdb;
		$table_name = $wpdb->prefix . 'wpairbnb_reviews';
		
		$stats = array();
		
		foreach($postreviewarray as $item) { //foreach element in $arr
			$pageid = $item['pageid'];
			$pagename = $item['pagename'];
			$created_time = $item['created_time'];
			$created_time_stamp = strtotime($created_time);
			$reviewer_name = $item['reviewer_name'];
			$reviewer_id = $item['reviewer_id'];
			$rating = $item['rating'];
			$review_text = $item['review_text'];
			$review_length = str_word_count($review_text);
			$rtype = $item['type'];
			
			//check to see if row is in db already
			$checkrow = $wpdb->get_row( "SELECT id FROM ".$table_name." WHERE rating = '$rating'" );
			if ( null === $checkrow ) {
				$stats[] =array( 
						'pageid' => $pageid, 
						'pagename' => $pagename, 
						'created_time' => $created_time,
						'created_time_stamp' => strtotime($created_time),
						'reviewer_name' => $reviewer_name,
						'reviewer_id' => $reviewer_id,
						'rating' => $rating,
						'review_text' => $review_text,
						'hide' => '',
						'review_length' => $review_length,
						'type' => $rtype
					);
			}
		}
		$i = 0;
		$insertnum = 0;
		foreach ( $stats as $stat ){
			$insertnum = $wpdb->insert( $table_name, $stat );
			$i=$i + 1;
		}
	
		$insertid = $wpdb->insert_id;

		//header('Content-Type: application/json');
		echo $insertnum."-".$insertid."-".$i;

		die();
	}

	/**
	 * Hides or deletes reviews in table, called from javascript file wpairbnb_review_list_page.js
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function wpairbnb_hidereview_ajax(){
	//ini_set('display_errors',1);  
	//error_reporting(E_ALL);
		
		check_ajax_referer('randomnoncestring', 'wpairbnb_nonce');
		
		$rid = intval($_POST['reviewid']);
		$myaction = $_POST['myaction'];

		//loop through each one and insert in to db
		global $wpdb;
		$table_name = $wpdb->prefix . 'wpairbnb_reviews';
		
		//check to see if we are deleting or just hiding or showing
		if($myaction=="hideshow"){
			//grab review and see if it is hidden or not
			$myreview = $wpdb->get_row( "SELECT * FROM $table_name WHERE id = $rid" );
			
			//pull array from options table of airbnb hidden
			$airbnbhidden = get_option( 'wpairbnb_hidden_reviews' );
			if(!$airbnbhidden){
				$airbnbhiddenarray = array('');
			} else {
				$airbnbhiddenarray = json_decode($airbnbhidden,true);
			}
			if(!is_array($airbnbhiddenarray)){
				$airbnbhiddenarray = array('');
			}
			$this_airbnb_val = $myreview->reviewer_name."-".$myreview->created_time_stamp."-".$myreview->review_length."-".$myreview->type."-".$myreview->rating;

			if($myreview->hide=="yes"){
				//already hidden need to show
				$newvalue = "";
				
				//remove from $airbnbhidden
				if(($key = array_search($this_airbnb_val, $airbnbhiddenarray)) !== false) {
					unset($airbnbhiddenarray[$key]);
				}
				
			} else {
				//shown, need to hide
				$newvalue = "yes";
				
				//need to update Airbnb hidden ids in options table here array of name,time,count,type
				 array_push($airbnbhiddenarray,$this_airbnb_val);
			}
			//update hidden airbnb reviews option, use this when downloading airbnb reviews so we can re-hide them each download
			$airbnbhiddenjson=json_encode($airbnbhiddenarray);
			update_option( 'wpairbnb_hidden_reviews', $airbnbhiddenjson );
			
			//update database review table to hide this one
			$data = array( 
				'hide' => "$newvalue"
				);
			$format = array( 
					'%s'
				); 
			$updatetempquery = $wpdb->update($table_name, $data, array( 'id' => $rid ), $format, array( '%d' ));
			if($updatetempquery>0){
				echo $rid."-".$myaction."-".$newvalue;
			} else {
				echo $rid."-".$myaction."-fail";
			}

		}
		if($myaction=="deleterev"){
			$deletereview = $wpdb->delete( $table_name, array( 'id' => $rid ), array( '%d' ) );
			if($deletereview>0){
				echo $rid."-".$myaction."-success";
			} else {
				echo $rid."-".$myaction."-fail";
			}
		
		}

		die();
	}

	/**
	 * Ajax: save an edited review (reviewer avatar URL + display date) without a
	 * page reload, called from admin/js/wpairbnb_review_list_page.js.
	 * @access  public
	 * @since   4.6
	 * @return  void
	 */
	public function wpairbnb_savereview_ajax() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => __( 'Insufficient permissions', 'wp-airbnb-review-slider' ) ) );
			return;
		}

		check_ajax_referer( 'randomnoncestring', 'wpairbnb_nonce' );

		global $wpdb;
		$table_name = $wpdb->prefix . 'wpairbnb_reviews';

		$r_id       = isset( $_POST['editrid'] ) ? absint( $_POST['editrid'] ) : 0;
		$avatar_url = isset( $_POST['avatar_url'] ) ? esc_url_raw( wp_unslash( $_POST['avatar_url'] ) ) : '';
		$rdate_raw  = isset( $_POST['review_date'] ) ? sanitize_text_field( wp_unslash( $_POST['review_date'] ) ) : '';

		if ( $r_id <= 0 ) {
			wp_send_json_error( array( 'message' => __( 'Invalid review.', 'wp-airbnb-review-slider' ) ) );
			return;
		}

		$existing = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$table_name} WHERE id = %d", $r_id ) );
		if ( ! $existing ) {
			wp_send_json_error( array( 'message' => __( 'Review not found.', 'wp-airbnb-review-slider' ) ) );
			return;
		}

		//keep userpic and userpiclocal in sync so the front-end shows the edited avatar
		$data   = array(
			'userpic'      => $avatar_url,
			'userpiclocal' => $avatar_url,
		);
		$format = array( '%s', '%s' );

		$parsed_stamp = $rdate_raw !== '' ? strtotime( $rdate_raw ) : false;
		if ( ! $parsed_stamp ) {
			wp_send_json_error( array( 'message' => __( 'Invalid date. Use the format YYYY-MM-DD HH:MM:SS.', 'wp-airbnb-review-slider' ) ) );
			return;
		}

		$created_time               = date( 'Y-m-d H:i:s', $parsed_stamp );
		$data['created_time']       = $created_time;
		$data['created_time_stamp'] = $parsed_stamp;
		$format[]                   = '%s';
		$format[]                   = '%d';

		$updated = $wpdb->update(
			$table_name,
			$data,
			array( 'id' => $r_id ),
			$format,
			array( '%d' )
		);

		if ( false === $updated ) {
			wp_send_json_error( array( 'message' => __( 'Database error while saving. Please try again.', 'wp-airbnb-review-slider' ) ) );
			return;
		}

		wp_send_json_success(
			array(
				'userpic' => $avatar_url,
				'date'    => $created_time,
			)
		);
	}
	
	/**
	 * Ajax, retrieves reviews from table, called from javascript file wpairbnb_templates_posts_page.js
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function wpairbnb_getreviews_ajax(){
	//ini_set('display_errors',1);  
	//error_reporting(E_ALL);
		
		check_ajax_referer('randomnoncestring', 'wpairbnb_nonce');
		$filtertext = htmlentities($_POST['filtertext']);
		$filterrating = htmlentities($_POST['filterrating']);
		$filterrating = intval($filterrating);
		//$curselrevs = $_POST['curselrevs'];
		$curselrevs ="";
		
		//perform db search and return results
		global $wpdb;
		$table_name = $wpdb->prefix . 'wpairbnb_reviews';
		$rowsperpage = 20;
		
		//pagenumber
		if(isset($_POST['pnum'])){
		$temppagenum = $_POST['pnum'];
		} else {
		$temppagenum ="";
		}
		if ( $temppagenum=="") {
			$pagenum = 1;
		} else if(is_numeric($temppagenum)){
			$pagenum = intval($temppagenum);
		}
		
		//sort direction
		if($_POST['sortdir']=="ASC" || $_POST['sortdir']=="DESC"){
			$sortdir = $_POST['sortdir'];
		} else {
			$sortdir = "DESC";
		}

		//make sure sortby is valid
		if(!isset($_POST['sortby'])){
			$_POST['sortby'] = "";
		}
		$allowed_keys = ['created_time_stamp', 'reviewer_name', 'rating', 'review_length', 'pagename', 'type' , 'hide'];
		$checkorderby = sanitize_key($_POST['sortby']);
	
		if(in_array($checkorderby, $allowed_keys, true) && $_POST['sortby']!=""){
			$sorttable = $_POST['sortby']. " ";
		} else {
			$sorttable = "created_time_stamp ";
		}
		if($_POST['sortdir']=="ASC" || $_POST['sortdir']=="DESC"){
			$sortdir = $_POST['sortdir'];
		} else {
			$sortdir = "DESC";
		}
		
		//get reviews from db
		$lowlimit = ($pagenum - 1) * $rowsperpage;
		$tablelimit = $lowlimit.",".$rowsperpage;
		
		if($filterrating>0){
			$filterratingtext = "rating = ".$filterrating;
		} else {
			$filterratingtext = "rating > 0";
		}
			
		//check to see if looking for previously selected only
		if (is_array($curselrevs)){
			$query = "SELECT * FROM ".$table_name." WHERE id IN (";
			//loop array and add to query
			$n=1;
			foreach ($curselrevs as $value) {
				if($value!=""){
					if(count($curselrevs)==$n){
						$query = $query." $value";
					} else {
						$query = $query." $value,";
					}
				}
				$n++;
			}
			$query = $query.")";
			//echo $query ;

			$reviewsrows = $wpdb->get_results($query);
			$hidepagination = true;
			$hidesearch = true;
		} else {
		

			//if filtertext set then use different query
			if($filtertext!=""){
				$reviewsrows = $wpdb->get_results("SELECT * FROM ".$table_name."
					WHERE (reviewer_name LIKE '%".$filtertext."%' or review_text LIKE '%".$filtertext."%') AND ".$filterratingtext."
					ORDER BY ".$sorttable." ".$sortdir." 
					LIMIT ".$tablelimit." "
				);
				$hidepagination = true;
			} else {
				$reviewsrows = $wpdb->get_results(
					$wpdb->prepare("SELECT * FROM ".$table_name."
					WHERE id>%d AND ".$filterratingtext."
					ORDER BY ".$sorttable." ".$sortdir." 
					LIMIT ".$tablelimit." ", "0")
				);
			}
		}
		
		//total number of rows
		$reviewtotalcount = $wpdb->get_var( "SELECT COUNT(*) FROM ".$table_name." WHERE id>1 AND ".$filterratingtext );
		//total pages
		$totalpages = ceil($reviewtotalcount/$rowsperpage);
		
		$reviewsrows['reviewtotalcount']=$reviewtotalcount;
		$reviewsrows['totalpages']=$totalpages;
		$reviewsrows['pagenum']=$pagenum;
		if($hidepagination){
			$reviewsrows['reviewtotalcount']=0;
			//$reviewsrows['totalpages']=0;
			//$reviewsrows['pagenum']=0;
		}
		if($hidesearch){
			//$reviewsrows['reviewtotalcount']=0;
			$reviewsrows['totalpages']=0;
			//$reviewsrows['pagenum']=0;
		}
		
		$results = json_encode($reviewsrows);
		echo $results;

		die();
	}
	
	
	
	/**
	 * replaces insert into post text on media uploader when uploading reviewer avatar
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */	
	public function wpairbnb_media_text() {
		global $pagenow;
		if ( 'media-upload.php' == $pagenow || 'async-upload.php' == $pagenow ) {
			// Now we'll replace the 'Insert into Post Button' inside Thickbox
			add_filter( 'gettext', array($this,'replace_thickbox_text') , 1, 3 );
		}
	}
	 
	public function replace_thickbox_text($translated_text, $text, $domain) {
		if ('Insert into Post' == $text) {
			$referer = strpos( wp_get_referer(), 'wp_airbnb-reviews' );
			if ( $referer != '' ) {
				return __('Use as Reviewer Avatar', 'wp-airbnb-review-slider' );
			}
		}
		return $translated_text;
	}
	

	/**
	 * download csv file of reviews
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */	
	public function wpairbnb_download_csv() {
      global $pagenow;
      if ($pagenow=='admin.php' && current_user_can('export') && isset($_GET['taction']) && $_GET['taction']=='downloadallrevs' && $_GET['page']=='wp_airbnb-reviews') {
        header("Content-type: application/x-msdownload");
        header("Content-Disposition: attachment; filename=reviewdata.csv");
        header("Pragma: no-cache");
        header("Expires: 0");

		global $wpdb;
		$table_name = $wpdb->prefix . 'wpairbnb_reviews';		
		$downloadreviewsrows = $wpdb->get_results(
				$wpdb->prepare("SELECT * FROM ".$table_name."
				WHERE id>%d ", "0"),'ARRAY_A'
			);
		$file = fopen('php://output', 'w');
		$delimiter=";";
		
		foreach ($downloadreviewsrows as $line) {
		    fputcsv($file, $line, $delimiter);
		}

        exit();
      }
    }	
	
	/**
	 * adds drop down menu of templates on post edit screen
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */	
	//add_action('media_buttons','add_sc_select',11);
	public function add_sc_select(){
		//get id's and names of templates that are post type 
		$shortcodes_list='';
		global $wpdb;
		$table_name = $wpdb->prefix . 'wpairbnb_post_templates';
		$currentforms = $wpdb->get_results("SELECT id, title, template_type FROM $table_name WHERE template_type = 'post'");
		if(count($currentforms)>0){
		echo '&nbsp;<select id="wprs_sc_select"><option value="select">Review Template</option>';
		foreach ( $currentforms as $currentform ){
			$shortcodes_list .= '<option value="[wpairbnb_usetemplate tid=\''.$currentform->id.'\']">'.$currentform->title.'</option>';
		}
		 echo $shortcodes_list;
		 echo '</select>';
		}
	}
	//add_action('admin_head', 'button_js');
	public function button_js() {
			echo '<script type="text/javascript">
			jQuery(document).ready(function(){
			   jQuery("#wprs_sc_select").change(function() {
							if(jQuery("#wprs_sc_select :selected").val()!="select"){
							  send_to_editor(jQuery("#wprs_sc_select :selected").val());
							}
							  return false;
					});
			});
			</script>';
	}
	

	/**
	 * download airbnb reviews when clicking the legacy Save Settings button
	 * (kept for backward compatibility with the old single-URL settings form).
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */	
	public function wpairbnb_download_airbnb() {
      global $pagenow;
      if (isset($_GET['settings-updated']) && $pagenow=='admin.php' && current_user_can('export') && $_GET['page']=='wp_airbnb-get_airbnb') {

		$options = get_option('wpairbnb_airbnb_settings');
		$tempurl = isset( $options['airbnb_business_url'] ) ? trim( $options['airbnb_business_url'] ) : '';
		if ( $tempurl !== '' && filter_var( $tempurl, FILTER_VALIDATE_URL ) ) {
			$pageid   = $this->wpairbnb_extract_pageid_from_url( $tempurl );
			$pagename = $this->wpairbnb_extract_businessname_from_url( $tempurl );
			$result   = $this->wpairbnb_download_one_source( $tempurl, $pageid, $pagename );
			$this->errormsg = isset( $result['ackmsg'] ) ? $result['ackmsg'] : '';
		}
      }
    }

	/**
	 * Get saved Airbnb crawl sources, migrating the legacy single URL if needed.
	 *
	 * @return array
	 */
	public function wpairbnb_get_crawls() {
		$raw = get_option( 'wprev_airbnb_crawls', 'not-exists' );
		if ( 'not-exists' === $raw ) {
			$crawls = array();
			update_option( 'wprev_airbnb_crawls', wp_json_encode( $crawls ) );
		} else {
			$crawls = json_decode( $raw, true );
			if ( ! is_array( $crawls ) ) {
				$crawls = array();
			}
		}

		// Migrate legacy single airbnb_business_url into crawls.
		$options = get_option( 'wpairbnb_airbnb_settings' );
		if ( is_array( $options ) && ! empty( $options['airbnb_business_url'] ) ) {
			$url = esc_url_raw( trim( $options['airbnb_business_url'] ) );
			if ( $url && filter_var( $url, FILTER_VALIDATE_URL ) ) {
				$pageid = $this->wpairbnb_extract_pageid_from_url( $url );
				if ( $pageid && ! isset( $crawls[ $pageid ] ) ) {
					$crawls[ $pageid ] = array(
						'pageid'       => $pageid,
						'businessname' => $this->wpairbnb_extract_businessname_from_url( $url ),
						'url'          => strtok( $url, '?' ),
						'avg'          => '',
						'total'        => '',
					);
					update_option( 'wprev_airbnb_crawls', wp_json_encode( $crawls ) );
				}
			}
		}

		return $crawls;
	}

	/**
	 * Persist crawls option and keep legacy airbnb_business_url in sync.
	 *
	 * @param array $crawls Sources keyed by pageid.
	 */
	public function wpairbnb_save_crawls( $crawls ) {
		if ( ! is_array( $crawls ) ) {
			$crawls = array();
		}
		update_option( 'wprev_airbnb_crawls', wp_json_encode( $crawls ) );

		// Keep first source URL in legacy option for older template link fallbacks.
		$options = get_option( 'wpairbnb_airbnb_settings' );
		if ( ! is_array( $options ) ) {
			$options = array();
		}
		$first_url = '';
		foreach ( $crawls as $source ) {
			if ( is_array( $source ) && ! empty( $source['url'] ) ) {
				$first_url = $source['url'];
				break;
			}
		}
		$options['airbnb_business_url'] = $first_url;
		update_option( 'wpairbnb_airbnb_settings', $options );
	}

	/**
	 * Extract the Airbnb listing/experience/user id from a business URL.
	 *
	 * @param string $url Airbnb URL.
	 * @return string
	 */
	public function wpairbnb_extract_pageid_from_url( $url ) {
		$url = strtok( $url, '?' );
		if ( preg_match( '~/rooms/(?:[^/?#]+/)?([0-9]+)~i', $url, $m ) ) {
			return sanitize_text_field( $m[1] );
		}
		if ( preg_match( '~/experiences/(?:[^/?#]+/)?([0-9]+)~i', $url, $m ) ) {
			return sanitize_text_field( $m[1] );
		}
		if ( preg_match( '~/users/show/([0-9]+)~i', $url, $m ) ) {
			return sanitize_text_field( $m[1] );
		}
		// Fallback: last run of digits in the path.
		$path = wp_parse_url( $url, PHP_URL_PATH );
		if ( $path && preg_match( '~([0-9]+)(?!.*[0-9])~', $path, $m ) ) {
			return sanitize_text_field( $m[1] );
		}
		return '';
	}

	/**
	 * Best-effort business name from an Airbnb URL (Airbnb has no readable
	 * slug like Yelp, so this is a generic label until the real title is
	 * known — the crawl-server response has no page title either).
	 *
	 * @param string $url Airbnb URL.
	 * @return string
	 */
	public function wpairbnb_extract_businessname_from_url( $url ) {
		$pageid = $this->wpairbnb_extract_pageid_from_url( $url );
		if ( $pageid === '' ) {
			return __( 'Airbnb Listing', 'wp-airbnb-review-slider' );
		}
		if ( stripos( $url, '/experiences/' ) !== false ) {
			return sprintf( __( 'Airbnb Experience %s', 'wp-airbnb-review-slider' ), $pageid );
		}
		if ( stripos( $url, '/users/show/' ) !== false ) {
			return sprintf( __( 'Airbnb Host %s', 'wp-airbnb-review-slider' ), $pageid );
		}
		return sprintf( __( 'Airbnb Listing %s', 'wp-airbnb-review-slider' ), $pageid );
	}

	/**
	 * Build one source table row HTML for AJAX add.
	 *
	 * @param string $pageid Page id.
	 * @param array  $source Source data.
	 * @return string
	 */
	public function wpairbnb_source_row_html( $pageid, $source ) {
		$bname     = isset( $source['businessname'] ) ? $source['businessname'] : '';
		$url       = isset( $source['url'] ) ? $source['url'] : '';
		$avg       = isset( $source['avg'] ) ? $source['avg'] : '';
		$total     = isset( $source['total'] ) ? $source['total'] : '';
		$avg_total = ( $avg !== '' || $total !== '' ) ? esc_html( $avg ) . ' / ' . esc_html( $total ) : '—';
		$del_url   = wp_nonce_url(
			admin_url( 'admin.php?page=wp_airbnb-get_airbnb&ract=del&pageid=' . rawurlencode( $pageid ) ),
			'wpairbnb_del_source'
		);

		ob_start();
		?>
		<tr data-pageid="<?php echo esc_attr( $pageid ); ?>">
			<td>
				<?php echo esc_html( $bname ); ?>
				<?php if ( $url ) : ?>
					<br><a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'View on Airbnb', 'wp-airbnb-review-slider' ); ?></a>
				<?php endif; ?>
			</td>
			<td><?php echo esc_html( $pageid ); ?></td>
			<td class="airbnb-source-stats"><?php echo $avg_total; ?></td>
			<td>
				<button type="button" class="button button-primary downloadrevs" data-pageid="<?php echo esc_attr( $pageid ); ?>"><?php esc_html_e( 'Download Reviews', 'wp-airbnb-review-slider' ); ?></button>
				<span class="buttonloader2 wprevloader"></span>
				<a class="button" style="color:#a00;" href="<?php echo esc_url( $del_url ); ?>" onclick="return confirm('<?php echo esc_js( __( 'Delete this source and its reviews?', 'wp-airbnb-review-slider' ) ); ?>');"><?php esc_html_e( 'Delete', 'wp-airbnb-review-slider' ); ?></a>
				<span class="airbnb-source-msg"></span>
			</td>
		</tr>
		<?php
		return ob_get_clean();
	}

	/**
	 * Delete a source, its reviews, and averages row.
	 *
	 * @param string $pageid Page id.
	 */
	public function wpairbnb_delete_source( $pageid ) {
		$pageid = sanitize_text_field( $pageid );
		if ( $pageid === '' ) {
			return;
		}
		$crawls = $this->wpairbnb_get_crawls();
		unset( $crawls[ $pageid ] );
		$this->wpairbnb_save_crawls( $crawls );

		global $wpdb;
		$wpdb->delete( $wpdb->prefix . 'wpairbnb_reviews', array( 'pageid' => $pageid ) );
		$wpdb->delete( $wpdb->prefix . 'wpairbnb_total_averages', array( 'btp_id' => $pageid ) );
	}

	/**
	 * AJAX: add an Airbnb source URL.
	 */
	public function wpairbnb_ajax_add_source() {
		if ( ! current_user_can( 'manage_options' ) ) {
			echo wp_json_encode( array( 'ack' => 'error', 'ackmsg' => 'Insufficient permissions.' ) );
			wp_die();
		}
		check_ajax_referer( 'randomnoncestring', 'wpairbnb_nonce' );

		$url  = isset( $_POST['airbnb_url'] ) ? esc_url_raw( trim( wp_unslash( $_POST['airbnb_url'] ) ) ) : '';
		$name = isset( $_POST['businessname'] ) ? sanitize_text_field( wp_unslash( $_POST['businessname'] ) ) : '';

		if ( ! $url || ! filter_var( $url, FILTER_VALIDATE_URL ) ) {
			echo wp_json_encode( array( 'ack' => 'error', 'ackmsg' => __( 'Please enter a valid Airbnb URL.', 'wp-airbnb-review-slider' ) ) );
			wp_die();
		}
		if ( stripos( $url, 'airbnb.' ) === false ) {
			echo wp_json_encode( array( 'ack' => 'error', 'ackmsg' => __( 'URL must be an Airbnb listing page.', 'wp-airbnb-review-slider' ) ) );
			wp_die();
		}

		$pageid = $this->wpairbnb_extract_pageid_from_url( $url );
		if ( $pageid === '' ) {
			echo wp_json_encode( array( 'ack' => 'error', 'ackmsg' => __( 'Could not determine a listing ID from that URL.', 'wp-airbnb-review-slider' ) ) );
			wp_die();
		}

		$crawls = $this->wpairbnb_get_crawls();
		if ( isset( $crawls[ $pageid ] ) ) {
			echo wp_json_encode( array( 'ack' => 'error', 'ackmsg' => __( 'That source is already added.', 'wp-airbnb-review-slider' ) ) );
			wp_die();
		}

		if ( $name === '' ) {
			$name = $this->wpairbnb_extract_businessname_from_url( $url );
		}

		$source = array(
			'pageid'       => $pageid,
			'businessname' => $name,
			'url'          => strtok( $url, '?' ),
			'avg'          => '',
			'total'        => '',
		);
		$crawls[ $pageid ] = $source;
		$this->wpairbnb_save_crawls( $crawls );

		echo wp_json_encode(
			array(
				'ack'      => 'success',
				'ackmsg'   => __( 'Source added. Click Download Reviews to fetch reviews.', 'wp-airbnb-review-slider' ),
				'pageid'   => $pageid,
				'row_html' => $this->wpairbnb_source_row_html( $pageid, $source ),
			)
		);
		wp_die();
	}

	/**
	 * AJAX: download reviews for one saved source.
	 */
	public function wpairbnb_ajax_download_source() {
		if ( ! current_user_can( 'manage_options' ) ) {
			echo wp_json_encode( array( 'ack' => 'error', 'ackmsg' => 'Insufficient permissions.' ) );
			wp_die();
		}
		check_ajax_referer( 'randomnoncestring', 'wpairbnb_nonce' );

		$pageid = isset( $_POST['pageid'] ) ? sanitize_text_field( wp_unslash( $_POST['pageid'] ) ) : '';
		$crawls = $this->wpairbnb_get_crawls();
		if ( $pageid === '' || empty( $crawls[ $pageid ]['url'] ) ) {
			echo wp_json_encode( array( 'ack' => 'error', 'ackmsg' => __( 'Source not found. Add the URL again.', 'wp-airbnb-review-slider' ) ) );
			wp_die();
		}

		$result = $this->wpairbnb_download_one_source(
			$crawls[ $pageid ]['url'],
			$pageid,
			isset( $crawls[ $pageid ]['businessname'] ) ? $crawls[ $pageid ]['businessname'] : ''
		);

		echo wp_json_encode( $result );
		wp_die();
	}

	//fix stringtotime for other languages
	private function myStrtotime($date_string) { 
		$monthnamearray = array(
		'janvier'=>'jan',
		'février'=>'feb',
		'mars'=>'march',
		'avril'=>'apr',
		'mai'=>'may',
		'juin'=>'jun',
		'juillet'=>'jul',
		'août'=>'aug',
		'septembre'=>'sep',
		'octobre'=>'oct',
		'novembre'=>'nov',
		'décembre'=>'dec',
		'gennaio'=>'jan',
		'febbraio'=>'feb',
		'marzo'=>'march',
		'aprile'=>'apr',
		'maggio'=>'may',
		'giugno'=>'jun',
		'luglio'=>'jul',
		'agosto'=>'aug',
		'settembre'=>'sep',
		'ottobre'=>'oct',
		'novembre'=>'nov',
		'dicembre'=>'dec',
		'janeiro'=>'jan',
		'fevereiro'=>'feb',
		'março'=>'march',
		'abril'=>'apr',
		'maio'=>'may',
		'junho'=>'jun',
		'julho'=>'jul',
		'agosto'=>'aug',
		'setembro'=>'sep',
		'outubro'=>'oct',
		'novembro'=>'nov',
		'dezembro'=>'dec',
		'enero'=>'jan',
		'febrero'=>'feb',
		'marzo'=>'march',
		'abril'=>'apr',
		'mayo'=>'may',
		'junio'=>'jun',
		'julio'=>'jul',
		'agosto'=>'aug',
		'septiembre'=>'sep',
		'octubre'=>'oct',
		'noviembre'=>'nov',
		'diciembre'=>'dec',
		'januari'=>'jan',
		'februari'=>'feb',
		'maart'=>'march',
		'april'=>'apr',
		'mei'=>'may',
		'juni'=>'jun',
		'juli'=>'jul',
		'augustus'=>'aug',
		'september'=>'sep',
		'oktober'=>'oct',
		'november'=>'nov',
		'december'=>'dec',
		' de '=>''
		);
		return strtotime(strtr(strtolower($date_string), $monthnamearray)); 
	}
	
	//for using curl instead of fopen
	private function file_get_contents_curl($url) {
		$agent= 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, $agent);
		curl_setopt($ch, CURLOPT_URL,$url);		

		$data = curl_exec($ch);
		curl_close($ch);

		return $data;
	}

	private function getreviewurlfrommain($urlvalue, $listing_id, $limit=10, $offset=0, $listtype=''){
		/*
					$response = wp_remote_get( $savedurlfile );
					if ( is_array( $response ) ) {
					  $header = $response['headers']; // array of http header lines
					  $fileurlcontents = $response['body']; // use the content
					} else {
						echo "Error finding key. Please contact plugin support.";
						die();
					}
					
			if (ini_get('allow_url_fopen') == true) {
				$fileurlcontents=file_get_contents($urlvalue);
			} else if (function_exists('curl_init')) {
				$fileurlcontents=$this->file_get_contents_curl($urlvalue);
			} else {
				$fileurlcontents='<html><body>fopen is not allowed on this host.</body></html>';
				$errormsg = $errormsg . ' <p style="color: #A00;">fopen is not allowed on this host and cURL did not work either. Ask your web host to turn fopen on or fix cURL.</p>';
				$this->errormsg = $errormsg;
				echo $errormsg;
				die();
			}
			*/
			
			//grab the page and save it locally
			$response = wp_remote_get($urlvalue);
					if ( is_array( $response ) ) {
					  $header = $response['headers']; // array of http header lines
					  $fileurlcontents = $response['body']; // use the content
					} else {
						echo "Error finding key. Please contact plugin support.";
						die();
					}
			//$savedurlfile = plugin_dir_path( __FILE__ ).'airbnbcapture.html';
			//$savefile = file_put_contents($savedurlfile,$fileurlcontents );
			//if(!file_exists($savedurlfile)){
			//	echo "Error 101: Unable to get Airbnb page. Please make sure that your Hosting provider has file_put_contents turned on.";
			//			die();
			//}
			//================================
			/*
			if (ini_get('allow_url_fopen') == true) {
				$fileurlcontents=file_get_contents($savedurlfile);
			} else if (function_exists('curl_init')) {
				$fileurlcontents=$this->file_get_contents_curl($savedurlfile);
			} else {
				$fileurlcontents='<html><body>fopen is not allowed on this host.</body></html>';
				$errormsg = $errormsg . ' <p style="color: #A00;">fopen is not allowed on this host and cURL did not work either. Ask your web host to turn fopen on or fix cURL.</p>';
				$this->errormsg = $errormsg;
				echo $errormsg;
				die();
			}
			*/
			
			$locale = '';
			$key ='';
			
					//going to try to pull the API key
					$dom  = new DOMDocument();
					libxml_use_internal_errors( 1 );
					$dom->loadHTML( $fileurlcontents );

					$xpath = new DOMXpath( $dom );

					//look for title.
					$titlepos = strpos($fileurlcontents, '<title>');
					$pagename='';
					if($titlepos>0){
						$titlepos = strpos($fileurlcontents, '<title>');
						$titlehalfstring = substr($fileurlcontents,$titlepos+7);
						$titleendpos = strpos($titlehalfstring, '</title>');
						$pagename = substr($titlehalfstring,0,$titleendpos);
					}
					
					if($pagename==''){
						$titleNode = $xpath->query('//title');
						$temptitle = $titleNode->item(0)->nodeValue;
						$pieces = explode("-", $temptitle);
						$pagename=$pieces[0];
					}
					$reviewurl['pagetitle']=$pagename;
					
					
					$key = $this->get_string_between($fileurlcontents, '","api_config":{"key":"', '","');
					
					
					if($key==""){
						$items = $xpath->query( '//meta/@content' );
						//$items = $dom->getElementsByTagName("meta");
						$key='';
						$findme='"api_config":{';
						if( $items->length < 1 )
						{
							die( "Error 1: No key found." );
						} else {
							//print_r($items);
							foreach ($items as $item) {
								if(strpos($item->nodeValue,$findme)){
									$nodearray = json_decode( $item->nodeValue, true );
									$key = $nodearray['api_config']['key'];
									$locale = $nodearray['locale'];
									//echo $key;
									//end the loop early
									break;
								}
							}
						}
					}

					if($key==""){
						//first shorten the stringtotime
						$findme = '","api_config":';
						$pos = strpos($fileurlcontents, $findme);
						//echo "<br>".$pos;
						$shortstring = substr($fileurlcontents,$pos-20,200);
						//echo "<br>".$shortstring;
						//no key found using dom method, try getting with string method
						$findme = 'api","key":"';
						$pos = strpos($shortstring, $findme);
						//echo "<br>".$pos;
						$tempendstring = substr($shortstring,$pos,100);
						//echo "<br>".$tempendstring;
						$end = strpos($tempendstring, '"},');
						//echo "<br>".$end;
						$key = substr($shortstring,$pos+12,$end-12);
						//echo "<br>".$key;
						//now fine locale
						$findme = '"locale":"';
						$firstpos = strpos($shortstring, $findme);
						//echo "<br>".$firstpos;
						$locale = substr($shortstring,$firstpos+10,2);
						//echo "<br>".$locale;
						//die();
					}
					
					if($key==""){
						die( "Error 2: No key found. Please reload the page to try again." );
					}
					//print_r($nodearray);
					//die();
					
					//use the key and the listing id to find review data					
					//$rurl = "https://www.airbnb.com/api/v2/reviews?key=".$key."&locale=".$locale."&listing_id=".$listing_id."&role=guest&_format=for_p3&_limit=".$limit."&_offset=".$offset."&_order=language_country";
					
					//https://www.airbnb.com/api/v2/reviews?key=d306zoyjsyarp7ifhu67rjxn52tv0t20&locale=en&listing_id=12351&role=guest&_format=for_p3&_limit=15&_offset=0&_order=language_country
					
					////https://www.airbnb.com/api/v2/reviews?key=d306zoyjsyarp7ifhu67rjxn52tv0t20&locale=fr&listing_id=38215705&role=guest&_format=for_p3&_limit=20&_order=recent
					
					$rurl = "https://www.airbnb.com/api/v2/reviews?key=".$key."&locale=".$locale."&listing_id=".$listing_id."&role=guest&_format=for_p3&_limit=20&_order=recent";
					$reviewurl['url'] = esc_url_raw($rurl);
					
					if($listtype=='experience'){
						//https://www.airbnb.com/api/v2/reviews?key=d306zoyjsyarp7ifhu67rjxn52tv0t20&currency=USD&locale=en&public=true&reviewable_id=312948&reviewable_type=MtTemplate&role=guest&_limit=5&_offset=0&_format=for_experiences_guest_flow&supported_media_item_types%5B%5D=picture
						
						//$rurl = "https://www.airbnb.com/api/v2/reviews?key=".$key."&locale=".$locale."&reviewable_id=".$listing_id."&reviewable_type=MtTemplate&role=guest&_format=for_experiences_guest_flow&_limit=".$limit."&_offset=".$offset."&_order=language_country";
						
						
						
						//$rurl = "https://www.airbnb.com/api/v2/reviews?key=".$key."&locale=".$locale."&reviewable_id=".$listing_id."&reviewable_type=MtTemplate&role=guest&_format=for_experiences_guest_flow&_order=recent";
						
						//v3 for experiences
						$rurl ='https://www.airbnb.com/api/v3/ExperiencesPdpReviews?operationName=ExperiencesPdpReviews&variables={"request":{"fieldSelector":"for_p3_translation_only","entityId":"ExperienceListing:'.$listing_id.'","offset":"0","limit":'.$limit.',"first":'.$limit.',"showingTranslationButton":false}}&extensions={"persistedQuery":{"version":1,"sha256Hash":"c2e483a512971b1e4a3b324039d1706bd8591ea1589f2c4e93534479fdd7c582"}}';
						$reviewurl['url'] = $rurl;
					}

					$reviewurl['key'] = $key;
					//print_r($reviewurl);
					//die();
					
					return $reviewurl;
		
	}
	
	public function get_string_between($string, $start, $end, $end2=''){
		$string = ' ' . $string;
		$len='';
		$ini = strpos($string, $start);
		if ($ini == 0) return '';
		$ini += strlen($start);
		$pos2 = strpos($string, $end, $ini);
		if($pos2>0){
			$len = strpos($string, $end, $ini) - $ini;
		}
		$len2 =500000;
		if($end2!=''){
			$len2 = strpos($string, $end2, $ini) - $ini;
		}
		if($len2<$len){
			$len=$len2;
		}
		if($len>0){
			$result = substr($string, $ini, $len);
		} else {
			$result = substr($string, $ini);
		}
		return $result;
	}
		
	/**
	 * Call the remote crawling service (crawl.ljapps.com) for one Airbnb
	 * listing/experience and return an array of normalized, sanitized
	 * reviews plus avg/total. Airbnb pages return everything in one call
	 * (the crawl server requests up to 48 reviews), so unlike Yelp there
	 * is no paging loop.
	 *
	 * @param string $listedurl Airbnb listing/experience URL.
	 * @param int    $pagenum   Page number (kept for parity with the crawl API).
	 * @param string $iscron    'yes' for cron, 'no' for manual.
	 * @return array
	 */
	public function wprpfree_getapps_getrevs_page_airbnb( $listedurl, $pagenum, $iscron ) {
		set_time_limit( 150 );

		$result = array(
			'ack'     => 'success',
			'avg'     => '',
			'total'   => '',
			'reviews' => array(),
		);

		if ( ! filter_var( $listedurl, FILTER_VALIDATE_URL ) ) {
			$result['ack']    = 'error';
			$result['ackmsg'] = __( 'Please enter a valid URL.', 'wp-airbnb-review-slider' );
			return $result;
		}

		$listedurl = strtok( stripslashes( $listedurl ), '?' );

		if ( isset( $_SERVER['SERVER_ADDR'] ) && $_SERVER['SERVER_ADDR'] != '' ) {
			$ip_server = $_SERVER['SERVER_ADDR'];
		} else {
			$ip_server = urlencode( get_site_url() );
		}
		$siteurl = urlencode( get_site_url() );

		$nhful         = 'new';
		$blockstoinsert = '20';

		$tempurlval = 'https://crawl.ljapps.com/crawlrevs?rip=' . $ip_server . '&surl=' . $siteurl . '&scrapeurl=' . urlencode( $listedurl ) . '&stype=airbnb&sfp=pro&nobot=1&nhful=' . $nhful . '&locationtype=&scrapequery=&tempbusinessname=&pagenum=' . $pagenum . '&nextpageurl=&iscron=' . $iscron . '&blocks=' . $blockstoinsert;

		$serverresponse = '';
		$args           = array(
			'timeout'   => 120,
			'sslverify' => false,
			'headers'   => array(
				'Content-Type' => ' application/json',
				'Accept'       => 'application/json',
			),
		);
		$response = wp_remote_get( $tempurlval, $args );
		if ( is_array( $response ) && ! is_wp_error( $response ) ) {
			$serverresponse = $response['body'];
		} else {
			$result['ack']    = 'error';
			$result['ackmsg'] = 'Error 0001a: trouble contacting crawling server with remote_get. Please try again or contact support. ' . ( is_wp_error( $response ) ? $response->get_error_message() : '' );
			return $result;
		}

		// Check for block or timeout; fall back to the backup crawl server.
		if ( strpos( $serverresponse, 'Please wait while your request is being verified' ) !== false || ! isset( $serverresponse ) || $serverresponse == '' || strpos( $serverresponse, 'Access denied by Imunify360 bot-protection.' ) !== false || strpos( $serverresponse, '403 Forbidden' ) !== false ) {
			$response = wp_remote_get( 'https://ocean.ljapps.com/crawlrevs.php?rip=' . $ip_server . '&surl=' . $siteurl . '&scrapeurl=' . urlencode( $listedurl ) . '&stype=airbnb&sfp=pro&nobot=1&nhful=' . $nhful . '&locationtype=&scrapequery=&tempbusinessname=&pagenum=' . $pagenum . '&nextpageurl=', array( 'sslverify' => false, 'timeout' => 60 ) );
			if ( is_array( $response ) && ! is_wp_error( $response ) ) {
				$serverresponse = $response['body'];
			}
		}

		$serverresponsearray = json_decode( $serverresponse, true );

		if ( $serverresponse == '' || ! is_array( $serverresponsearray ) ) {
			$result['ack']    = 'error';
			$result['ackmsg'] = 'Error 0001: trouble contacting crawling server. Please try again or contact support.';
			return $result;
		}
		if ( isset( $serverresponsearray['ack'] ) && $serverresponsearray['ack'] == 'error' ) {
			$result['ack']    = 'error';
			$result['ackmsg'] = 'Error 0002: ' . $serverresponsearray['ackmessage'];
			return $result;
		}
		if ( ! isset( $serverresponsearray['result'] ) || ! is_array( $serverresponsearray['result'] ) ) {
			$result['ack']    = 'error';
			$result['ackmsg'] = 'Error 0002b: trouble finding reviews. Contact support with this error code and the URL you are using.';
			return $result;
		}
		if ( isset( $serverresponsearray['result']['ack'] ) && $serverresponsearray['result']['ack'] == 'error' ) {
			$result['ack']    = 'error';
			$result['ackmsg'] = 'Error 0003: ' . $serverresponsearray['ackmessage'] . ' : ' . $serverresponsearray['result']['ackmsg'];
			return $result;
		}

		$crawlerresultarray = $serverresponsearray['result'];

		$result['avg']   = isset( $crawlerresultarray['avg'] ) ? $crawlerresultarray['avg'] : '';
		$result['total'] = isset( $crawlerresultarray['total'] ) ? $crawlerresultarray['total'] : '';

		$crawlerreviewsarray = ( isset( $crawlerresultarray['reviews'] ) && is_array( $crawlerresultarray['reviews'] ) ) ? $crawlerresultarray['reviews'] : array();

		foreach ( $crawlerreviewsarray as $review ) {
			$reviewer_name = isset( $review['reviewer_name'] ) ? trim( $review['reviewer_name'] ) : '';
			if ( $reviewer_name === '' ) {
				continue;
			}

			$tempownerres = '';
			if ( isset( $review['owner_response'] ) && $review['owner_response'] != '' ) {
				$tempownerres = sanitize_textarea_field( $review['owner_response'] );
			}
			$templocation = '';
			if ( isset( $review['location'] ) && $review['location'] != '' ) {
				$templocation = sanitize_text_field( $review['location'] );
			}
			$tempmediaurlsarrayjson = '';
			if ( isset( $review['mediaurlsarrayjson'] ) && $review['mediaurlsarrayjson'] != '' ) {
				$tempmediaurlsarrayjson = $this->wprevpro_sanitize_media_urls_json( $review['mediaurlsarrayjson'] );
			}

			// Untrusted data from the remote crawling service: sanitize every field.
			$result['reviews'][] = array(
				'reviewer_name'      => sanitize_text_field( $reviewer_name ),
				'userpic'            => isset( $review['userimage'] ) ? esc_url_raw( $review['userimage'] ) : '',
				'rating'             => isset( $review['rating'] ) ? (int) $review['rating'] : 0,
				'updated'            => isset( $review['date'] ) ? sanitize_text_field( $review['date'] ) : '',
				'review_text'        => isset( $review['review_text'] ) ? sanitize_textarea_field( $review['review_text'] ) : '',
				'location'           => $templocation,
				'owner_response'     => $tempownerres,
				'mediaurlsarrayjson' => $tempmediaurlsarrayjson,
				'from_url_review'    => isset( $review['from_url_review'] ) ? esc_url_raw( $review['from_url_review'] ) : '',
			);
		}

		return $result;
	}

	/**
	 * Sanitize a JSON-encoded array of media URLs from the remote crawling
	 * service before it is stored or re-encoded.
	 *
	 * @param string $json Raw JSON string of URLs.
	 * @return string Re-encoded JSON of sanitized URLs, or '' if invalid.
	 */
	private function wprevpro_sanitize_media_urls_json( $json ) {
		$decoded = json_decode( $json, true );
		if ( ! is_array( $decoded ) ) {
			return '';
		}

		$safe = array();
		foreach ( $decoded as $url ) {
			if ( is_string( $url ) && $url !== '' ) {
				$safe[] = esc_url_raw( $url );
			}
		}

		return wp_json_encode( $safe );
	}

	/**
	 * Download and store reviews for a single Airbnb source URL.
	 *
	 * @param string $tempurl  Airbnb listing/experience URL.
	 * @param string $pageid   Page id (listing/experience/user id).
	 * @param string $pagename Business name.
	 * @return array
	 */
	public function wpairbnb_download_one_source( $tempurl, $pageid = '', $pagename = '' ) {
		ini_set( 'memory_limit', '800M' );
		set_time_limit( 180 );

		$result = array(
			'ack'    => 'success',
			'ackmsg' => '',
			'avg'    => '',
			'total'  => '',
		);

		$tempurl = trim( $tempurl );
		if ( ! filter_var( $tempurl, FILTER_VALIDATE_URL ) ) {
			$result['ack']    = 'error';
			$result['ackmsg'] = __( 'Please enter a valid URL.', 'wp-airbnb-review-slider' );
			return $result;
		}

		$tempurl = strtok( $tempurl, '?' );

		if ( $pageid === '' ) {
			$pageid = $this->wpairbnb_extract_pageid_from_url( $tempurl );
		}
		if ( $pagename === '' ) {
			$pagename = $this->wpairbnb_extract_businessname_from_url( $tempurl );
		}

		global $wpdb;
		$table_name  = $wpdb->prefix . 'wpairbnb_reviews';
		$totalinsert = 0;

		$listedurl = $tempurl;
		// Manual downloads use iscron=no so the crawl server does not throttle us.
		$iscron = 'no';

		// Airbnb returns everything in one crawl-server call (up to 48 reviews).
		$reviewscrawl = $this->wprpfree_getapps_getrevs_page_airbnb( $listedurl, 1, $iscron );

		if ( ! is_array( $reviewscrawl ) || ( isset( $reviewscrawl['ack'] ) && $reviewscrawl['ack'] === 'error' ) ) {
			$result['ack']    = 'error';
			$result['ackmsg'] = isset( $reviewscrawl['ackmsg'] ) ? $reviewscrawl['ackmsg'] : __( 'Unable to find any reviews. Please try again or contact support.', 'wp-airbnb-review-slider' );
			return $result;
		}

		$all_reviews  = ( ! empty( $reviewscrawl['reviews'] ) && is_array( $reviewscrawl['reviews'] ) ) ? $reviewscrawl['reviews'] : array();
		$source_avg   = isset( $reviewscrawl['avg'] ) ? $reviewscrawl['avg'] : '';
		$source_total = isset( $reviewscrawl['total'] ) ? $reviewscrawl['total'] : '';

		if ( empty( $all_reviews ) ) {
			$result['ack']    = 'error';
			$result['ackmsg'] = __( 'Unable to find any reviews. Please try again or contact support.', 'wp-airbnb-review-slider' );
			return $result;
		}

		$result['avg']   = $source_avg;
		$result['total'] = $source_total;

		$reviews = array();
		foreach ( $all_reviews as $review ) {
			$rtext         = isset( $review['review_text'] ) ? $review['review_text'] : '';
			$review_length = str_word_count( $rtext );
			$unixtimestamp = $this->myStrtotime( isset( $review['updated'] ) ? $review['updated'] : '' );
			if ( ! $unixtimestamp ) {
				$unixtimestamp = time();
			}
			$timestamp = date( 'Y-m-d H:i:s', $unixtimestamp );

			// Dedupe by name + length (+ pageid) so re-downloads don't duplicate rows.
			if ( $pageid !== '' ) {
				$checkrow = $wpdb->get_var(
					$wpdb->prepare(
						"SELECT id FROM {$table_name} WHERE reviewer_name = %s AND review_length = %d AND pageid = %s",
						$review['reviewer_name'],
						$review_length,
						$pageid
					)
				);
			} else {
				$checkrow = $wpdb->get_var(
					$wpdb->prepare(
						"SELECT id FROM {$table_name} WHERE reviewer_name = %s AND rating = %d",
						$review['reviewer_name'],
						(int) $review['rating']
					)
				);
			}

			if ( ! empty( $checkrow ) ) {
				continue;
			}

			// Re-hide previously hidden reviews on re-download.
			$airbnbhidden      = get_option( 'wpairbnb_hidden_reviews' );
			$airbnbhiddenarray = $airbnbhidden ? json_decode( $airbnbhidden, true ) : array( '' );
			if ( ! is_array( $airbnbhiddenarray ) ) {
				$airbnbhiddenarray = array( '' );
			}
			$this_airbnb_val = trim( $review['reviewer_name'] ) . '-' . $unixtimestamp . '-' . $review_length . '-Airbnb-' . (int) $review['rating'];
			$hideme           = in_array( $this_airbnb_val, $airbnbhiddenarray, true ) ? 'yes' : '';

			// Defense in depth: re-sanitize immediately before the DB write.
			$reviews[] = array(
				'pageid'             => $pageid,
				'pagename'           => trim( $pagename ),
				'reviewer_name'      => sanitize_text_field( $review['reviewer_name'] ),
				'userpic'            => esc_url_raw( isset( $review['userpic'] ) ? $review['userpic'] : '' ),
				'rating'             => (int) $review['rating'],
				'created_time'       => $timestamp,
				'created_time_stamp' => $unixtimestamp,
				'review_text'        => sanitize_textarea_field( trim( $rtext ) ),
				'hide'               => $hideme,
				'review_length'      => $review_length,
				'type'               => 'Airbnb',
				'from_url'           => esc_url_raw( $listedurl ),
				'mediaurlsarrayjson' => isset( $review['mediaurlsarrayjson'] ) ? $review['mediaurlsarrayjson'] : '',
			);
		}

		foreach ( $reviews as $stat ) {
			$insertnum    = $wpdb->insert( $table_name, $stat );
			$totalinsert += (int) $insertnum;
		}

		// Persist source avg/total for badges.
		if ( $pageid !== '' ) {
			$this->updatetotalavgreviews( 'Airbnb', $pageid, $source_avg, $source_total, $pagename );

			$crawls = $this->wpairbnb_get_crawls();
			if ( ! isset( $crawls[ $pageid ] ) ) {
				$crawls[ $pageid ] = array(
					'pageid'       => $pageid,
					'businessname' => $pagename,
					'url'          => $listedurl,
				);
			}
			$crawls[ $pageid ]['avg']           = $source_avg;
			$crawls[ $pageid ]['total']         = $source_total;
			$crawls[ $pageid ]['businessname']  = $pagename;
			$crawls[ $pageid ]['url']           = $listedurl;
			$crawls[ $pageid ]['last_download'] = time();
			$this->wpairbnb_save_crawls( $crawls );
		}

		$numreturned      = count( $all_reviews );
		$result['ackmsg'] = sprintf(
			/* translators: 1: reviews found, 2: new reviews inserted */
			__( '%1$d reviews found. %2$d new reviews downloaded. Check the Review List page.', 'wp-airbnb-review-slider' ),
			$numreturned,
			$totalinsert
		);
		$this->errormsg = $result['ackmsg'];

		return $result;
	}

	/**
	 * Store source avg/total for badges (option + averages table).
	 *
	 * @param string $type     Review type.
	 * @param string $pageid   Page id.
	 * @param string $avg      Source average from crawler.
	 * @param string $total    Source total from crawler.
	 * @param string $pagename Business name.
	 */
	public function updatetotalavgreviews( $type, $pageid, $avg, $total, $pagename = '' ) {
		global $wpdb;
		$table_name = $wpdb->prefix . 'wpairbnb_reviews';
		$avg        = str_replace( ',', '.', (string) $avg );
		$option     = 'wpairbnb_total_avg_reviews';

		$wppro_total_avg_reviews_array = get_option( $option );
		if ( $wppro_total_avg_reviews_array ) {
			$wppro_total_avg_reviews_array = json_decode( $wppro_total_avg_reviews_array, true );
		}
		if ( ! is_array( $wppro_total_avg_reviews_array ) ) {
			$wppro_total_avg_reviews_array = array();
		}

		$ratingsarray = array();
		$abreviews    = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT rating, type FROM {$table_name} WHERE hide != %s AND pageid = %s",
				'yes',
				$pageid
			)
		);
		$pagetype = $type;
		foreach ( $abreviews as $abreview ) {
			if ( $abreview->rating > 0 ) {
				$ratingsarray[] = (float) $abreview->rating;
			}
			if ( ! empty( $abreview->type ) ) {
				$pagetype = $abreview->type;
			}
		}

		$avgdb   = 0;
		$totaldb = 0;
		if ( count( $ratingsarray ) > 0 ) {
			$avgdb   = round( array_sum( $ratingsarray ) / count( $ratingsarray ), 3 );
			$totaldb = count( $ratingsarray );
		}

		if ( ! isset( $wppro_total_avg_reviews_array[ $pageid ] ) ) {
			$wppro_total_avg_reviews_array[ $pageid ] = array();
		}
		$wppro_total_avg_reviews_array[ $pageid ]['total_indb'] = $totaldb;
		$wppro_total_avg_reviews_array[ $pageid ]['avg_indb']   = $avgdb;
		if ( floatval( $avg ) > 0 ) {
			$wppro_total_avg_reviews_array[ $pageid ]['avg'] = round( floatval( $avg ), 3 );
		}
		if ( intval( $total ) > 0 ) {
			$wppro_total_avg_reviews_array[ $pageid ]['total'] = intval( $total );
		}

		update_option( $option, wp_json_encode( $wppro_total_avg_reviews_array, JSON_FORCE_OBJECT ) );

		$valuearray = array(
			'btp_id'     => $pageid,
			'btp_name'   => $pagename,
			'pagetype'   => $pagetype,
			'total'      => isset( $wppro_total_avg_reviews_array[ $pageid ]['total'] ) ? $wppro_total_avg_reviews_array[ $pageid ]['total'] : '',
			'total_indb' => $totaldb,
			'avg'        => isset( $wppro_total_avg_reviews_array[ $pageid ]['avg'] ) ? $wppro_total_avg_reviews_array[ $pageid ]['avg'] : '',
			'avg_indb'   => $avgdb,
			'numr1'      => '',
			'numr2'      => '',
			'numr3'      => '',
			'numr4'      => '',
			'numr5'      => '',
		);
		$this->updatetotalavgreviewstableinsert( 'page', $valuearray );
	}

	/**
	 * Insert/replace a row in wpairbnb_total_averages.
	 *
	 * @param string $btp_type   page|template|badge.
	 * @param array  $valuearray Row values.
	 */
	public function updatetotalavgreviewstableinsert( $btp_type, $valuearray ) {
		global $wpdb;
		$table_name_totalavg = $wpdb->prefix . 'wpairbnb_total_averages';
		$data                = array(
			'btp_id'     => isset( $valuearray['btp_id'] ) ? $valuearray['btp_id'] : '',
			'btp_name'   => isset( $valuearray['btp_name'] ) ? $valuearray['btp_name'] : '',
			'btp_type'   => $btp_type,
			'pagetype'   => isset( $valuearray['pagetype'] ) ? $valuearray['pagetype'] : '',
			'total_indb' => isset( $valuearray['total_indb'] ) ? (string) $valuearray['total_indb'] : '',
			'total'      => isset( $valuearray['total'] ) ? (string) $valuearray['total'] : '',
			'avg_indb'   => isset( $valuearray['avg_indb'] ) ? (string) $valuearray['avg_indb'] : '',
			'avg'        => isset( $valuearray['avg'] ) ? (string) $valuearray['avg'] : '',
			'numr1'      => isset( $valuearray['numr1'] ) ? (string) $valuearray['numr1'] : '',
			'numr2'      => isset( $valuearray['numr2'] ) ? (string) $valuearray['numr2'] : '',
			'numr3'      => isset( $valuearray['numr3'] ) ? (string) $valuearray['numr3'] : '',
			'numr4'      => isset( $valuearray['numr4'] ) ? (string) $valuearray['numr4'] : '',
			'numr5'      => isset( $valuearray['numr5'] ) ? (string) $valuearray['numr5'] : '',
		);
		$format = array( '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s' );
		$wpdb->replace( $table_name_totalavg, $data, $format );
	}
	 
	 
	 
	public function wpairbnb_download_airbnb_master_old() {
		//make sure file get contents is turned on for this host
		$errormsg ='';
					
			global $wpdb;
			$table_name = $wpdb->prefix . 'wpairbnb_reviews';
			$options = get_option('wpairbnb_airbnb_settings');
			$tempurl = trim($options['airbnb_business_url']);
			//make sure you have valid url, if not display message
			if (filter_var($tempurl, FILTER_VALIDATE_URL)) {
			  // you're good
			  //echo "valid url";
			  if($options['airbnb_radio']=='yes'){
				//echo "passed both tests";
				$stripvariableurl = strtok($tempurl, '?');
				//find the listing_id
				$listing_id = (int) filter_var($stripvariableurl, FILTER_SANITIZE_NUMBER_INT);
				
				//find the reviewurl for this URL
				
				if(strpos($tempurl, '/experiences/') !== false){		
					//experiences, get different api key stuff
					$isexperience = true;
					$urldetails = $this->getreviewurlfrommain($stripvariableurl, $listing_id, $limit=20, $offset=0, 'experience');
				} else {
					$isexperience = false;
					$urldetails = $this->getreviewurlfrommain($stripvariableurl, $listing_id, $limit=15, $offset=0, 'room');
				}
				//print_r($urldetails);
				//echo "<br><br>";
				//die();
				
				
				$urlvalue =$urldetails['url'];
				
				//include_once('simple_html_dom.php');
				//loop to grab pages
				$reviews = [];
				$n=1;
					
					if($isexperience){
						$data = wp_remote_get( $urlvalue ,
							 array( 'timeout' => 30,
							'headers' => array( 'X-Airbnb-API-Key' => $urldetails['key']) 
							 ));
					} else {
						$data = wp_remote_get( $urlvalue );
					}
					if ( is_wp_error( $data ) ) 
					{
						$response['error_message'] 	= $data->get_error_message();
						$reponse['status'] 		= $data->get_error_code();
						print_r($response);
						die();
					}
					$pagedata = json_decode( $data['body'], true );
					
					//print_r($pagedata);
					//die();

					//find airbnb business name and add to db under pagename
					$pagename ='';
					if($urldetails['pagetitle']!=""){
						$pagename =$urldetails['pagetitle'];
					}

					// Find 20 reviews
					if($isexperience){
						$reviewsarray = $pagedata['data']['merlin']['pdpReviews']['reviews'];
					} else {
						$reviewsarray = $pagedata['reviews'];
					}
					//print_r($reviewsarray);
					//die();

					foreach ($reviewsarray as $review) {

							$user_name='';
							$userimage='';
							$rating='';
							$datesubmitted='';
							$rtext='';
							if($isexperience){
								// Find user_name
								if($review['reviewer']['firstName']){
									$user_name = $review['reviewer']['firstName'];
								}
								
								// Find userimage ui_avatar
								if($review['reviewer']['pictureUrl']){
									$userimage = $review['reviewer']['pictureUrl'];
								}
								
								// find date created_at
								if($review['createdAt']){
									$datesubmitted = $review['createdAt'];
								}

							} else {
								// Find user_name
								if($review['reviewer']['first_name']){
									$user_name = $review['reviewer']['first_name'];
								}
								
								// Find userimage ui_avatar
								if($review['reviewer']['picture_url']){
									$userimage = $review['reviewer']['picture_url'];
								}
								
								// find date created_at
								if($review['created_at']){
									$datesubmitted = $review['created_at'];
								}
							}

							// find rating
							if($review['rating']){
								$rating = $review['rating'];
							}

							// find text
							if($review['comments']){
								$rtext = $review['comments'];
							}
							
				
							if($rating>0){
								$review_length = str_word_count($rtext);
								$timestamp = $this->myStrtotime($datesubmitted);
								$unixtimestamp = $timestamp;
								$timestamp = date("Y-m-d H:i:s", $timestamp);
								//check option to see if this one has been hidden
								//pull array from options table of airbnb hidden
								$airbnbhidden = get_option( 'wpairbnb_hidden_reviews' );
								if(!$airbnbhidden){
									$airbnbhiddenarray = array('');
								} else {
									$airbnbhiddenarray = json_decode($airbnbhidden,true);
								}
								$this_airbnb_val = trim($user_name)."-".strtotime($datesubmitted)."-".$review_length."-Airbnb-".$rating;
								if (in_array($this_airbnb_val, $airbnbhiddenarray)){
									$hideme = 'yes';
								} else {
									$hideme = 'no';
								}
								
								//add check to see if already in db, skip if it is and end loop
								$reviewindb = 'no';
								$checkrow = $wpdb->get_var( "SELECT id FROM ".$table_name." WHERE rating = '".$rating."' AND reviewer_name = '".trim($user_name)."' " );
								if( empty( $checkrow ) ){
										$reviewindb = 'no';
								} else {
										$reviewindb = 'yes';
								}
								if( $reviewindb == 'no' )
								{
								$reviews[] = [
										'reviewer_name' => trim($user_name),
										'pagename' => trim($pagename),
										'userpic' => $userimage,
										'rating' => $rating,
										'created_time' => $timestamp,
										'created_time_stamp' => $unixtimestamp,
										'review_text' => trim($rtext),
										'hide' => $hideme,
										'review_length' => $review_length,
										'type' => 'Airbnb'
								];
								}
								$review_length ='';
							}
					}

					// clean up memory
					if (!empty($html)) {
						$html->clear();
						unset($html);
					}
				
				
				//add all new airbnb reviews to db
				$insertnum=0;
				foreach ( $reviews as $stat ){
					$insertnum = $wpdb->insert( $table_name, $stat );
				}
				//reviews added to db
				if($insertnum>0){
					$errormsg = $errormsg . ' Airbnb reviews downloaded. They should now be on the Review List. Use the Template tab to display them on your site.';
					$this->errormsg = $errormsg;
				} else {
					$errormsg = $errormsg . ' Unable to find any new reviews.';
					$this->errormsg = $errormsg;
				}
				
			  }
			} else {
				$errormsg = $errormsg . ' Please enter a valid URL.';
				$this->errormsg = $errormsg;
			}
			
			if($options['airbnb_radio']=='no'){
				$wpdb->delete( $table_name, array( 'type' => 'Airbnb' ) );
				//cancel wp cron job
			}
			

		if($errormsg !=''){
			//echo $errormsg;
		}
	}

    	/**
	 * download airbnb users reviews
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */	
	public function wpairbnb_download_airbnb_master_users() {
		//make sure file get contents is turned on for this host
		$errormsg ='';
		$ShowUserReviews = false;
					
			global $wpdb;
			$table_name = $wpdb->prefix . 'wpairbnb_reviews';
			$options = get_option('wpairbnb_airbnb_settings');
			
			// Enhanced security: Validate URL format AND destination to prevent SSRF
			$url = $options['airbnb_business_url'];
			if (filter_var($url, FILTER_VALIDATE_URL) && $this->is_airbnb_domain($url)) {
			  // you're good
			  //echo "valid url";
			  if($options['airbnb_radio']=='yes'){
				//echo "passed both tests";
				$stripvariableurl = strtok($options['airbnb_business_url'], '?');
				$airbnburl[1] = $stripvariableurl;
				
				//include_once('simple_html_dom.php');
				//loop to grab pages
				$reviews = [];
				$n=1;
				foreach ($airbnburl as $urlvalue) {
					
					
					// Create DOM from URL or file
					/*
					if (ini_get('allow_url_fopen') == true) {
						$fileurlcontents=file_get_contents($urlvalue);
					} else if (function_exists('curl_init')) {
						$fileurlcontents=$this->file_get_contents_curl($urlvalue);
					} else {
						// Enable 'allow_url_fopen' or install cURL.
						$fileurlcontents='<html><body>fopen is not allowed on this host.</body></html>';
						$errormsg = $errormsg . ' <p style="color: #A00;">fopen is not allowed on this host and cURL did not work either. Please ask your hosting provided to turn fopen on or fix cURL.</p>';
						$this->errormsg = $errormsg;
						break;
					}
					*/
					
					
					// Enhanced security: Grab the page with content-type validation
					$response = wp_remote_get($urlvalue, array(
						'timeout' => 30,
						'user-agent' => 'Mozilla/5.0 (compatible; WP-Airbnb-Review-Slider/1.0)'
					));
					
					if (is_wp_error($response)) {
						$errormsg = 'Error connecting to Airbnb: ' . $response->get_error_message();
						$this->errormsg = $errormsg;
						return;
					}
					
					if (!is_array($response) || !isset($response['body'])) {
						$errormsg = 'Error: Invalid response from Airbnb';
						$this->errormsg = $errormsg;
						return;
					}
					
					// Validate content type to prevent XSS
					$headers = wp_remote_retrieve_headers($response);
					$content_type = wp_remote_retrieve_header($response, 'content-type');
					
					if ($content_type && strpos($content_type, 'text/html') === false) {
						$errormsg = 'Error: Invalid content type received. Expected HTML content.';
						$this->errormsg = $errormsg;
						return;
					}
					
					$fileurlcontents = $response['body'];



					// Find 20 reviews
					$i = 1;
					
					
					//find the $pagename
					//"title":"
					$titlepos = strpos($fileurlcontents, '"title":"');
					if(!$titlepos){
						$titlepos = strpos($fileurlcontents, '<title>');
						$titlehalfstring = substr($fileurlcontents,$titlepos+7);
						$titleendpos = strpos($titlehalfstring, '</title>');
						$pagename = substr($titlehalfstring,0,$titleendpos);
					} else {
						$titlehalfstring = substr($fileurlcontents,$titlepos+9);
						$titleendpos = strpos($titlehalfstring, '","');
						$pagename = substr($titlehalfstring,0,$titleendpos);
					}
					
					
					//need to pull out json of reviews and make an array here
					//"recent_reviews_from_guest":
					$findme = '"recent_reviews_from_guest":';
						$pos = strpos($fileurlcontents, $findme);
						//echo "<br>".$pos;
						
						$temphalfstring = substr($fileurlcontents,$pos+28);
						//echo "<br>".$temphalfstring;
						$endpos = strpos($temphalfstring, "]");
						
						$finalstring = substr($temphalfstring,0,$endpos+1);
						//echo "<br>".$finalstring;
						
						$reviewArray = json_decode($finalstring, true);
						
						//print_r($reviewArray);

					foreach ($reviewArray as $review) {

							if ($i > 21) {
									break;
							}
							$user_name='';
							$userimage='';
							$rating='';
							$datesubmitted='';
							$rtext='';
							// Find user_name
							if(isset($review['reviewer']['first_name'])){
								$user_name = $review['reviewer']['first_name'];
							}
							//echo $user_name;
							//die();
							
							// Find userimage ui_avatar, need to pull from lazy load varible
							//print_r($review->find('div.avatar-wrapper', 0)->find('img.lazy', 0));
							$userimage ='';
							if(isset($review['reviewer']['picture_url'])){
								$userimage = $review['reviewer']['picture_url'];
							}
							
							//echo $userimage ;
							
							//die();
							
							// find rating
							$rating ='';
							//if($review->find('span.ui_bubble_rating', 0)){
							//	$temprating = $review->find('span.ui_bubble_rating', 0)->class;
							//	$int = filter_var($temprating, FILTER_SANITIZE_NUMBER_INT);
							///echo $int."<br>";
							//	$rating = str_replace(0,"",$int);
							//}
							
							// find date
							if(isset($review['created_at'])){
								$datesubmitted = $review['created_at'];
							}
							
							$timestamp = $this->myStrtotime($datesubmitted);
							//echo $datesubmitted;
							//echo $timestamp;
							//die();

							// find text
							if(isset($review['comments'])){
								$rtext = $review['comments'];
							}
							

							if($user_name!=''){
								$review_length = str_word_count($rtext);
								$pos = strpos($userimage, 'default_avatars');
								if ($pos === false) {
									$userimage = str_replace("60s.jpg","120s.jpg",$userimage);
								}
								//$timestamp = strtotime($datesubmitted);
								if($datesubmitted!=''){
								$timestamp = $this->myStrtotime($datesubmitted);
								$unixtimestamp = $timestamp;
								$timestamp = date("Y-m-d H:i:s", $timestamp);
								}
								//check option to see if this one has been hidden
								//pull array from options table of airbnb hidden
								$airbnbhidden = get_option( 'wpairbnb_hidden_reviews' );
								if(!$airbnbhidden){
									$airbnbhiddenarray = array('');
								} else {
									$airbnbhiddenarray = json_decode($airbnbhidden,true);
								}
								$this_airbnb_val = trim($user_name)."-".strtotime($datesubmitted)."-".$review_length."-Airbnb-".$rating;
								if (in_array($this_airbnb_val, $airbnbhiddenarray)){
									$hideme = 'yes';
								} else {
									$hideme = 'no';
								}
								
								//add check to see if already in db, skip if it is and end loop
								$reviewindb = 'no';
								$checkrow = $wpdb->get_var( "SELECT id FROM ".$table_name." WHERE rating = '".$rating."' AND reviewer_name = '".trim($user_name)."' " );
								if( empty( $checkrow ) ){
										$reviewindb = 'no';
								} else {
										$reviewindb = 'yes';
								}
								if( $reviewindb == 'no' )
								{
								$reviews[] = [
										'reviewer_name' => trim($user_name),
										'pagename' => trim($pagename),
										'userpic' => $userimage,
										'rating' => $rating,
										'created_time' => $timestamp,
										'created_time_stamp' => $unixtimestamp,
										'review_text' => trim($rtext),
										'hide' => $hideme,
										'review_length' => $review_length,
										'type' => 'Airbnb'
								];
								}
								$review_length ='';
							}
							$i++;
					
					}

					//find total number here and end break loop early if total number less than 50. review-count
					//$totalreviews = $html->find('span.header_rating', 0)->find('span[property=v:count]', 0)->plaintext;
					//$totalreviews = intval($totalreviews);
					//if (($n*20) > $totalreviews) {
					//				break;
					//		}
					//sleep for random 2 seconds
					sleep(rand(0,2));
					$n++;
					
					// clean up memory
					if (!empty($html)) {
						$html->clear();
						unset($html);
					}
				}
				 

					// clean up memory
					if (!empty($html)) {
						$html->clear();
						unset($html);
					}
				
				
				//add all new airbnb reviews to db with enhanced security
				$insertnum=0;
				foreach ( $reviews as $stat ){
					// Sanitize review data to prevent XSS attacks
					$sanitized_stat = $this->sanitize_review_data($stat);
					$insertnum = $wpdb->insert( $table_name, $sanitized_stat );
				}
				//reviews added to db
				if($insertnum>0){
					$errormsg = $errormsg . ' Airbnb reviews downloaded.';
					$this->errormsg = $errormsg;
				} else {
					$errormsg = $errormsg . ' Unable to find any new reviews.';
					$this->errormsg = $errormsg;
				}
				
				// Security: No temporary files written to prevent file injection attacks
				
			  }
			} else {
				$errormsg = $errormsg . ' Please enter a valid URL.';
				$this->errormsg = $errormsg;
			}
			
			if($options['airbnb_radio']=='no'){
				$wpdb->delete( $table_name, array( 'type' => 'Airbnb' ) );
				//cancel wp cron job
			}
			

		if($errormsg !=''){
			//echo $errormsg;
		}
	}
	
	/**
	 * displays message in admin if it's been longer than 30 days.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function wprp_admin_notice__success () {

		$activatedtime = get_option('wprev_activated_time_airbnb');
		//if this is an old install then use 23 days ago
		if($activatedtime==''){
			$activatedtime= time() - (86400*23);
			update_option( 'wprev_activated_time_airbnb', $activatedtime );
		}
		$thirtydaysago = time() - (86400*30);
		
		//check if an option was clicked on
		if (isset($_GET['wprevpronotice'])) {
		  $wprevpronotice = $_GET['wprevpronotice'];
		} else {
		  //Handle the case where there is no parameter
		   $wprevpronotice = '';
		}
		if($wprevpronotice=='mlater_airbnb'){		//hide the notice for another 30 days
			update_option( 'wprev_notice_hide_airbnb', 'later' );
			$newtime = time() - (86400*21);
			update_option( 'wprev_activated_time_airbnb', $newtime );
			$activatedtime = $newtime;
			
		} else if($wprevpronotice=='notagain_airbnb'){		//hide the notice forever
			update_option( 'wprev_notice_hide_airbnb', 'never' );
		}
		
		$wprev_notice_hide = get_option('wprev_notice_hide_airbnb');

		if($activatedtime<$thirtydaysago && $wprev_notice_hide!='never'){
		
			$urltrimmedtab = remove_query_arg( array('taction', 'tid', 'sortby', 'sortdir', 'opt') );
			$urlmayberlater = esc_url( add_query_arg( 'wprevpronotice', 'mlater_airbnb',$urltrimmedtab ) );
			$urlnotagain = esc_url( add_query_arg( 'wprevpronotice', 'notagain_airbnb',$urltrimmedtab ) );
			
			$temphtml = '<p>Hey, I noticed you\'ve been using my <b>WP Airbnb Review Slider</b> plugin for a while now – that\'s awesome! Could you please do me a BIG favor and give it a 5-star rating on WordPress? <br>
			Thanks!<br>
			~ Josh W.<br></p>
			<ul>
			<li><a href="https://wordpress.org/support/plugin/wp-airbnb-review-slider/reviews/#new-post" target="_blank">Ok, you deserve it</a></li>
			<li><a href="'.$urlmayberlater.'">Not right now, maybe later</a></li>
			<li><a href="'.$urlnotagain.'">Don\'t remind me again</a></li>
			</ul>
			<p>P.S. If you\'ve been thinking about upgrading to the <a href="https://wpreviewslider.com/" target="_blank">Pro</a> version, here\'s a 10% off coupon code you can use! ->  <b>wprevpro10off</b></p>';
			
			?>
			<div class="notice notice-info">
				<div class="wprevpro_admin_notice" style="color: #007500;">
				<?php _e( $temphtml, $this->_token ); ?>
				</div>
			</div>
			<?php
		}

	}
	
		/**
	 * add dashboard widget to wordpress admin
	 * @access  public
	 * @since   7.3
	 * @return  void
	 */
	public function wprevproairbnb_dashboard_widget() {
		global $wp_meta_boxes;
		//wp_add_dashboard_widget('custom_help_widget', 'Theme Support', 'custom_dashboard_help');
		add_meta_box( 'airbnbrevsid', 'WP Airbnb Review Slider Recent Reviews', array($this,'custom_dashboard_help'), 'dashboard', 'side', 'high' );
	}
	 
	public function custom_dashboard_help() {
		global $wpdb;
		$reviews_table_name = $wpdb->prefix . 'wpairbnb_reviews';
		$tempquery = "select * from ".$reviews_table_name." ORDER by created_time_stamp Desc limit 4";
		$reviewrows = $wpdb->get_results($tempquery);
		$now = time(); // or your date as well
		
		echo '<style>
			img.wprev_dash_avatar {float: left;margin-right: 8px;border-radius: 20px;}
			.wprev_dash_stars {float: right;}
			p.wprev_dash_text {margin-top: -6px;}
			span.wprev_dash_timeago {font-size: 12px;font-style: italic;}
			</style>';
			
		echo '<style>
			img.wprev_dash_avatar {float: left;margin-right: 8px;border-radius: 20px;}
			.wprev_dash_stars {float: right;}
			p.wprev_dash_text {margin-top: -6px;}
			span.wprev_dash_timeago {font-size: 12px;font-style: italic;}
			.wprev_dash_revdiv {min-height: 50px;}
			</style>';
		echo '<ul>';
		foreach ( $reviewrows as $review ) 
		{
			$timesince = '';
			if(strlen($review->review_text)>130){
				$reviewtext = substr($review->review_text,0,130).'...';
			} else {
				$reviewtext = $review->review_text;
			}
			
			$your_date = $review->created_time_stamp;
			$datediff = $now - $your_date;
			$daysago = round($datediff / (60 * 60 * 24));
			if($daysago==1){
				$daysagohtml = $daysago.' day ago';
			} else {
				$daysagohtml = $daysago.' days ago';
			}
			if($review->rating<1){
				if($review->recommendation_type=='positive'){
					$review->rating=5;
				} else {
					$review->rating=2;
				}
			}

			$imgs_url = plugin_dir_url(__DIR__).'/public/partials/imgs/';
			$starfile = 'stars_'.$review->rating.'_yellow.png';
			$starhtml='<img src="'.$imgs_url."".$starfile.'" alt="'.$review->rating.' star rating" class="wprev_dash_stars">';
			
			$avatarhtml = '';
			if(isset($review->userpic) && $review->userpic!=''){
				$avatarhtml = '<img alt="" src="'.$review->userpic.'" class="wprev_dash_avatar" height="40" width="40">';
			}
			
			echo '<li><div class="wprev_dash_revdiv">'.$avatarhtml.'<div class="wprev_dash_stars">'.$starhtml.'</div><h4 class="wprev_dash_name">'.$review->reviewer_name.' - <span class="wprev_dash_timeago">'.$daysagohtml.'</span></h4><p class="wprev_dash_text">'.$reviewtext.'</p></div></li>';
			
		}
		echo '</ul>';
		
		echo '<div><a href="admin.php?page=wp_airbnb-reviews">All Reviews</a> - <a href="https://wpreviewslider.com/" target="_blank">Go Pro For More Cool Features!</a></div>';
	}

	/**
	 * Enhanced security: Validate Airbnb URLs to prevent SSRF attacks
	 * @access  private
	 * @since   1.0.0
	 * @param   string    $url    The URL to validate
	 * @return  bool              True if valid Airbnb URL, false otherwise
	 */
	private function is_valid_airbnb_url($url) {
		// Basic URL format validation
		if (!filter_var($url, FILTER_VALIDATE_URL)) {
			return false;
		}
		
		// Parse URL to check components
		$parsed_url = parse_url($url);
		if (!$parsed_url || !isset($parsed_url['host'])) {
			return false;
		}
		
		// Only allow Airbnb domains
		$allowed_hosts = array(
			'www.airbnb.com',
			'airbnb.com',
			'www.airbnb.co.uk',
			'airbnb.co.uk',
			'www.airbnb.ca',
			'airbnb.ca',
			'www.airbnb.com.au',
			'airbnb.com.au'
		);
		
		if (!in_array($parsed_url['host'], $allowed_hosts)) {
			return false;
		}
		
		// Only allow specific Airbnb URL patterns
		$allowed_patterns = array(
			'/users/show/',
			'/rooms/',
			'/experiences/'
		);
		
		$path = isset($parsed_url['path']) ? $parsed_url['path'] : '';
		$has_valid_pattern = false;
		
		foreach ($allowed_patterns as $pattern) {
			if (strpos($path, $pattern) !== false) {
				$has_valid_pattern = true;
				break;
			}
		}
		
		return $has_valid_pattern;
	}

	/**
	 * Enhanced security: Sanitize review data to prevent XSS
	 * @access  private
	 * @since   1.0.0
	 * @param   array     $review_data    The review data to sanitize
	 * @return  array                     Sanitized review data
	 */
	private function sanitize_review_data($review_data) {
		$sanitized = array();
		
		// Sanitize text fields
		$sanitized['reviewer_name'] = sanitize_text_field($review_data['reviewer_name']);
		$sanitized['pagename'] = sanitize_text_field($review_data['pagename']);
		$sanitized['review_text'] = wp_kses_post($review_data['review_text']); // Allow safe HTML
		$sanitized['userpic'] = esc_url_raw($review_data['userpic']);
		
		// Sanitize numeric fields
		$sanitized['rating'] = intval($review_data['rating']);
		$sanitized['created_time_stamp'] = intval($review_data['created_time_stamp']);
		$sanitized['review_length'] = intval($review_data['review_length']);
		
		// Sanitize date field
		$sanitized['created_time'] = sanitize_text_field($review_data['created_time']);
		
		// Sanitize type field
		$sanitized['type'] = sanitize_text_field($review_data['type']);
		
		// Sanitize hide field
		$sanitized['hide'] = sanitize_text_field($review_data['hide']);
		
		return $sanitized;
	}

	/**
	 * Enhanced security: Check if URL is from allowed Airbnb domains
	 * @access  private
	 * @since   1.0.0
	 * @param   string    $url    The URL to validate
	 * @return  bool              True if valid Airbnb domain, false otherwise
	 */
	private function is_airbnb_domain($url) {
		$parsed_url = parse_url($url);
		if (!$parsed_url || !isset($parsed_url['host'])) {
			return false;
		}
		
		// Only allow Airbnb domains
		$allowed_hosts = array(
			'www.airbnb.com',
			'airbnb.com',
			'www.airbnb.co.uk',
			'airbnb.co.uk',
			'www.airbnb.ca',
			'airbnb.ca',
			'www.airbnb.com.au',
			'airbnb.com.au'
		);
		
		return in_array($parsed_url['host'], $allowed_hosts);
	}

	/**
	 * Small helper: allow hex or rgb(a) colors, otherwise empty.
	 *
	 * @access  private
	 * @since   1.0.0
	 * @param   string $color Raw color value.
	 * @return  string
	 */
	private function wpairbnb_sanitize_css_color( $color ) {
		$color = trim( (string) $color );
		if ( $color === '' ) {
			return '';
		}
		if ( preg_match( '/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{4}|[0-9a-fA-F]{6}|[0-9a-fA-F]{8})$/', $color ) ) {
			return $color;
		}
		if ( preg_match( '/^rgba?\(\s*[\d.]+\s*,\s*[\d.]+\s*,\s*[\d.]+\s*(,\s*[\d.]+\s*)?\)$/i', $color ) ) {
			return $color;
		}
		return '';
	}

	/**
	 * Ajax: return the rendered template HTML for the live preview.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function wpairbnb_previewtemplate_ajax() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => 'Insufficient permissions' ) );
			return;
		}
		check_ajax_referer( 'randomnoncestring', 'wpairbnb_nonce' );

		$tid         = isset( $_POST['tid'] ) ? absint( $_POST['tid'] ) : 0;
		$returnarray = $this->wpairbnb_previewtemplate_ajax_get( $tid );
		echo wp_json_encode( $returnarray );
		die();
	}

	/**
	 * Build preview HTML for a template id using the public shortcode renderer.
	 *
	 * @access  public
	 * @since   1.0.0
	 * @param   int $tid Template id.
	 * @return  array
	 */
	public function wpairbnb_previewtemplate_ajax_get( $tid ) {
		$atts = array( 'tid' => absint( $tid ) );
		require_once plugin_dir_path( __DIR__ ) . 'public/class-wp-airbnb-review-slider-public.php';
		$plugin_public_class = new WP_Airbnb_Review_Public( $this->_token, $this->version );
		$templatehtml         = $plugin_public_class->wpairbnb_usetemplate_func( $atts, null );

		return array(
			'tid'          => absint( $tid ),
			'ack'          => 'success',
			'templatehtml' => $templatehtml,
		);
	}

	/**
	 * Ajax: save (insert/update) a review template then return its preview HTML.
	 *
	 * Mirrors the page-POST save logic in admin/partials/templates_posts.php so
	 * the live preview reflects exactly what will be stored.
	 *
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function wpairbnb_savetemplate_ajax() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => 'Insufficient permissions' ) );
			return;
		}
		check_ajax_referer( 'randomnoncestring', 'wpairbnb_nonce' );

		$formdata  = isset( $_POST['data'] ) ? stripslashes( $_POST['data'] ) : '';
		$formarray = json_decode( $formdata, true );
		if ( ! is_array( $formarray ) ) {
			echo wp_json_encode( array( 'ack' => 'error', 'ackmessage' => 'Invalid form data.' ) );
			die();
		}

		global $wpdb;
		$table_name = $wpdb->prefix . 'wpairbnb_post_templates';

		$get = function ( $key, $default = '' ) use ( $formarray ) {
			return isset( $formarray[ $key ] ) ? $formarray[ $key ] : $default;
		};

		$t_id             = sanitize_text_field( $get( 'edittid' ) );
		$title            = sanitize_text_field( $get( 'wpairbnb_template_title' ) );
		$template_type    = sanitize_text_field( $get( 'wpairbnb_template_type', 'post' ) );
		$style            = sanitize_text_field( $get( 'wprevpro_template_style', '1' ) );
		$display_num      = sanitize_text_field( $get( 'wpairbnb_t_display_num', '3' ) );
		$display_num_rows = sanitize_text_field( $get( 'wpairbnb_t_display_num_rows', '1' ) );
		$display_order    = sanitize_text_field( $get( 'wpairbnb_t_display_order', 'newest' ) );
		$hide_no_text     = sanitize_text_field( $get( 'wpairbnb_t_hidenotext', 'no' ) );
		$template_css     = sanitize_textarea_field( $get( 'wpairbnb_template_css' ) );
		$createslider     = sanitize_text_field( $get( 'wpairbnb_t_createslider', 'no' ) );
		$numslides        = sanitize_text_field( $get( 'wpairbnb_t_numslides', '3' ) );
		$read_more        = sanitize_text_field( $get( 'wprevpro_t_read_more', 'no' ) );
		$read_more_text   = sanitize_text_field( $get( 'wprevpro_t_read_more_text', 'read more' ) );
		$read_more_num    = absint( $get( 'wprevpro_t_read_more_num', '30' ) );
		$min_rating       = sanitize_text_field( $get( 'wpairbnb_t_min_rating', '1' ) );
		$review_same_hgt  = sanitize_text_field( $get( 'wpairbnb_t_review_same_height', 'no' ) );
		$filtersource     = sanitize_text_field( $get( 'wpairbnb_t_filtersource' ) );

		// template misc (style + slider + badge, stored as JSON the public renderer reads)
		$templatemiscarray = array();
		$templatemiscarray['showstars'] = sanitize_text_field( $get( 'wprevpro_template_misc_showstars', 'yes' ) );
		$templatemiscarray['showdate']  = sanitize_text_field( $get( 'wprevpro_template_misc_showdate', 'yes' ) );
		$templatemiscarray['bgcolor1']  = $this->wpairbnb_sanitize_css_color( $get( 'wprevpro_template_misc_bgcolor1' ) );
		$templatemiscarray['bgcolor2']  = $this->wpairbnb_sanitize_css_color( $get( 'wprevpro_template_misc_bgcolor2' ) );
		$templatemiscarray['tcolor1']   = $this->wpairbnb_sanitize_css_color( $get( 'wprevpro_template_misc_tcolor1' ) );
		$templatemiscarray['tcolor2']   = $this->wpairbnb_sanitize_css_color( $get( 'wprevpro_template_misc_tcolor2' ) );
		$templatemiscarray['tcolor3']   = $this->wpairbnb_sanitize_css_color( $get( 'wprevpro_template_misc_tcolor3' ) );
		$templatemiscarray['bradius']   = sanitize_text_field( $get( 'wprevpro_template_misc_bradius', '0' ) );

		// Style-tab options.
		$templatemiscarray['verified']       = sanitize_text_field( $get( 'wprevpro_template_misc_verified', 'no' ) );
		$templatemiscarray['lastnameformat'] = sanitize_text_field( $get( 'wprevpro_template_misc_lastname', 'show' ) );
		$templatemiscarray['avataropt']      = sanitize_text_field( $get( 'wprevpro_template_misc_avataropt', 'show' ) );
		$templatemiscarray['showicon']       = sanitize_text_field( $get( 'wprevpro_template_misc_showicon', 'lin' ) );
		$ajax_tfont1 = absint( $get( 'wprevpro_template_misc_tfont1', 0 ) );
		$ajax_tfont2 = absint( $get( 'wprevpro_template_misc_tfont2', 0 ) );
		$templatemiscarray['tfont1'] = $ajax_tfont1 > 0 ? (string) $ajax_tfont1 : '';
		$templatemiscarray['tfont2'] = $ajax_tfont2 > 0 ? (string) $ajax_tfont2 : '';

		// General-tab options (read more + reviews same height).
		$templatemiscarray['review_same_height'] = $review_same_hgt;
		$templatemiscarray['read_more_num']      = (string) $read_more_num;
		$templatemiscarray['read_more_color']    = $this->wpairbnb_sanitize_css_color( $get( 'wprevpro_t_read_more_color' ) );

		// Filter source lives in misc (the public renderer reads template_misc['filtersource']).
		$templatemiscarray['filtersource'] = $filtersource;

		// Badge options.
		$templatemiscarray['blocation'] = sanitize_text_field( $get( 'wpairbnb_t_blocation' ) );
		$templatemiscarray['bname']     = sanitize_text_field( $get( 'wpairbnb_t_bname' ) );
		$templatemiscarray['bnameurl']  = esc_url_raw( $get( 'wpairbnb_t_bnameurl' ) );
		$templatemiscarray['bimgurl']   = esc_url_raw( $get( 'wpairbnb_t_bimgurl' ) );
		$templatemiscarray['bshape']    = sanitize_text_field( $get( 'wpairbnb_t_bshape' ) );
		$templatemiscarray['bimgsize']  = sanitize_text_field( $get( 'wpairbnb_t_bimgsize', '50' ) );
		$templatemiscarray['bbtnurl']   = esc_url_raw( $get( 'wpairbnb_t_bbtnurl' ) );
		$templatemiscarray['bbradius']  = sanitize_text_field( $get( 'wpairbnb_t_bbradius', '0' ) );
		$templatemiscarray['bbwidth']   = sanitize_text_field( $get( 'wpairbnb_t_bbwidth', '0' ) );
		$templatemiscarray['bbtncolor'] = $this->wpairbnb_sanitize_css_color( $get( 'wpairbnb_t_bbtncolor', '#FF5A5F' ) );
		$templatemiscarray['bbkcolor']  = $this->wpairbnb_sanitize_css_color( $get( 'wpairbnb_t_bbkcolor', '#ffffff' ) );
		$templatemiscarray['bbcolor']   = $this->wpairbnb_sanitize_css_color( $get( 'wpairbnb_t_bbcolor', '#eeeeee' ) );
		$templatemiscarray['bdropsh']   = sanitize_text_field( $get( 'wpairbnb_t_bdropsh' ) );
		$templatemiscarray['bcenter']   = sanitize_text_field( $get( 'wpairbnb_t_bcenter' ) );
		$templatemiscarray['bhname']    = sanitize_text_field( $get( 'wpairbnb_t_bhname' ) );
		$templatemiscarray['bhphoto']   = sanitize_text_field( $get( 'wpairbnb_t_bhphoto' ) );
		$templatemiscarray['bhbased']   = sanitize_text_field( $get( 'wpairbnb_t_bhbased' ) );
		$templatemiscarray['bhbtn']     = sanitize_text_field( $get( 'wpairbnb_t_bhbtn' ) );
		$templatemiscarray['bhpow']     = sanitize_text_field( $get( 'wpairbnb_t_bhpow' ) );
		$templatemiscarray['bhreviews'] = sanitize_text_field( $get( 'wpairbnb_t_bhreviews' ) );
		$templatemiscarray['bobasedon'] = sanitize_text_field( $get( 'wpairbnb_t_bobasedon' ) );
		$templatemiscarray['borevus']   = sanitize_text_field( $get( 'wpairbnb_t_borevus' ) );

		$templatemiscjson = wp_json_encode( $templatemiscarray );
		$timenow          = time();

		$data = array(
			'title'              => $title,
			'template_type'      => $template_type,
			'style'              => $style,
			'created_time_stamp' => $timenow,
			'display_num'        => $display_num,
			'display_num_rows'   => $display_num_rows,
			'display_order'      => $display_order,
			'hide_no_text'       => $hide_no_text,
			'template_css'       => $template_css,
			'min_rating'         => $min_rating,
			'min_words'          => '',
			'max_words'          => '',
			'rtype'              => '["airbnb"]',
			'rpage'              => $filtersource,
			'createslider'       => $createslider,
			'numslides'          => $numslides,
			'sliderautoplay'     => '',
			'sliderdirection'    => '',
			'sliderarrows'       => '',
			'sliderdots'         => '',
			'sliderdelay'        => '',
			'sliderheight'       => $review_same_hgt,
			'review_same_height' => $review_same_hgt,
			'showreviewsbyid'    => '',
			'template_misc'      => $templatemiscjson,
			'read_more'          => $read_more,
			'read_more_num'      => $read_more_num,
			'read_more_text'     => $read_more_text,
		);
		$format = array(
			'%s', '%s', '%d', '%d', '%d', '%d', '%s', '%s', '%s', '%d',
			'%d', '%d', '%s', '%s', '%s', '%d', '%s', '%s', '%s', '%s',
			'%d', '%s', '%s', '%s', '%s', '%s', '%d', '%s',
		);

		$returnarray = array(
			'iu'         => '',
			'ack'        => '',
			'ackmessage' => '',
			't_id'       => '',
		);

		if ( $t_id === '' ) {
			$returnarray['iu'] = 'insert';
			$inserttemplate    = $wpdb->insert( $table_name, $data, $format );
			$t_id              = $wpdb->insert_id;
			if ( ! $inserttemplate ) {
				$returnarray['ack']        = 'error';
				$returnarray['ackmessage'] = __( 'Unable to update. Try refreshing the page.', 'wp-airbnb-review-slider' );
			} else {
				$returnarray['ack']        = 'success';
				$returnarray['ackmessage'] = __( 'Template Saved!', 'wp-airbnb-review-slider' );
			}
		} else {
			$returnarray['iu'] = 'update';
			$updatetempquery   = $wpdb->update( $table_name, $data, array( 'id' => absint( $t_id ) ), $format, array( '%d' ) );
			if ( false === $updatetempquery ) {
				$returnarray['ack']        = 'error';
				$returnarray['ackmessage'] = __( 'Unable to update. Try refreshing the page.', 'wp-airbnb-review-slider' );
			} else {
				$returnarray['ack']        = 'success';
				$returnarray['ackmessage'] = __( 'Template Updated!', 'wp-airbnb-review-slider' );
			}
		}

		$returnarray['t_id']         = absint( $t_id );
		$returnpreview               = $this->wpairbnb_previewtemplate_ajax_get( absint( $t_id ) );
		$returnarray['templatehtml'] = $returnpreview['templatehtml'];

		echo wp_json_encode( $returnarray );
		die();
	}

}
