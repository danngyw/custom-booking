<?php
/*
Plugin Name: Custom Booking
Plugin URI: https://akismet.com/
Description: Booking hotel.
Version: 1.0
Author: Automattic
Author URI: https://abc.com
License: GPLv2 or later
Text Domain: booking
*/

define( 'BOOKING_PATH', dirname( __FILE__ ) );
define( 'BOOKING_URL', plugin_dir_url( __FILE__ ) );
require_once('functions.php');
require_once('booking-shortcodes.php');
require_once(BOOKING_PATH.'/admin.php');
Class CustomBooking{
	function __construct(){
		add_action( 'init', array($this, 'resigster_post_type' ));
		add_action( 'wp_head',array($this,'add_head_css'));
		add_action( 'wp_enqueue_scripts', array($this, 'enqueue_script'));
		add_action( 'wp_ajax_save_booking',array($this,'save_booking'));
		add_action( 'wp_ajax_nopriv_save_booking',array($this,'save_booking'));
	}
	function save_booking(){

		$request 	= $_REQUEST['request'];
		$fullname 	= $request['fullname'];
		$email 		= $request['email'];
		$phone 		= $request['phone'];

		global $wpdb;
		$tbl_book 	= $wpdb->prefix . 'book_room';
		$in_args = array(
			'full_name' 	=> $fullname,
			'email' 		=> $email,
			'phone' 		=> $phone,
			'gmt_time' 		=> current_time( 'mysql', 1 ),
			'local_time' 	=> current_time('mysql', 0),
		);

		$insert = $wpdb->insert( $tbl_book, $in_args );
		$msg = 'Your booking has been sent. Thank you.';
		if(! $insert){
			$msg = 'There are something wrong.';
		}

		$response = array('success' => true, 'msg' =>$msg );
		wp_send_json($response);
	}
	function enqueue_script(){
		wp_enqueue_script('jquery');
		$cdn_bootstraps = 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js';

		wp_enqueue_script( 'bootstraps',
        	$cdn_bootstraps, array('jquery','validate'), rand(),true );

		wp_enqueue_script('validate','https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js', array('jquery'), rand(), true);
		wp_enqueue_script( 'booking-js',
        	BOOKING_URL . '/assets/js/booking.js', array('jquery','validate'), rand(),true
	    );

		wp_enqueue_script( 'booking-js',
        	BOOKING_URL . '/assets/js/booking.js', array('jquery','validate','bootstraps'), rand(),true
	    );
	    wp_enqueue_style( 'booking-style', BOOKING_URL.'/assets/booking.css',array(), rand() );
	}
	function add_head_css(){ ?>
	<script type="text/javascript">
		var booking = {ajax_url:'<?php echo admin_url().'admin-ajax.php'; ?>'};
	</script>
	   <script src="<?php echo BOOKING_URL;?>/assets/js/Moment.js"></script>

	   <script src="<?php echo BOOKING_URL;?>/assets/js/bootstrap-datetimepicker.min.js"></script>

		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css" integrity="sha512-cOGz9gyEibwgs1MVDCcfmQv6mPyUkfvrV9TsRbTuOA12SQnLzBROihf6/jK57u0YxzlxosBFunSt4V75K6azMw==" crossorigin="anonymous" referrerpolicy="no-referrer" />


		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

		<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;400;500&family=Roboto+Condensed:ital,wght@0,300;0,400;1,300&display=swap" rel="stylesheet">
		<?php

	}
	function resigster_post_type() {
		$args = array(
	        'public'    => true,
	        'label'     => __( 'Rooms', 'textdomain' ),
	        'menu_icon' => 'dashicons-book',
	        'menu_position' => 11,
	        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields' ),
	    );
    	register_post_type( 'room', $args );
    	$labels = array(
	        'name'              => _x( 'Rates', 'taxonomy general name', 'textdomain' ),
	        'singular_name'     => _x( 'Rate', 'taxonomy singular name', 'textdomain' ),
	        'search_items'      => __( 'Search rates', 'textdomain' ),
	        'all_items'         => __( 'Rates', 'textdomain' ),
	        'parent_item'       => __( 'Parent rate', 'textdomain' ),
	        'parent_item_colon' => __( 'Parent rate:', 'textdomain' ),
	        'edit_item'         => __( 'Edit rate', 'textdomain' ),
	        'update_item'       => __( 'Update rate', 'textdomain' ),
	        'add_new_item'      => __( 'Add New rate', 'textdomain' ),
	        'new_item_name'     => __( 'New rate Name', 'textdomain' ),
	        'menu_name'         => __( 'Rate', 'textdomain' ),
	    );

	    $args = array(
	        'hierarchical'      => true,
	        'labels'            => $labels,
	        'show_ui'           => true,
	        'show_admin_column' => true,
	        'query_var'         => true,
	        'rewrite'           => array( 'slug' => 'rate' ),
	    );

	    register_taxonomy( 'rate', 'room', $args );
	    $labels = array(
	        'name'              => _x( 'Range', 'taxonomy general name', 'textdomain' ),
	        'singular_name'     => _x( 'Range', 'taxonomy singular name', 'textdomain' ),
	        'search_items'      => __( 'Search rates', 'textdomain' ),
	        'all_items'         => __( 'Range', 'textdomain' ),
	        'parent_item'       => __( 'Parent range', 'textdomain' ),
	        'parent_item_colon' => __( 'Parent range:', 'textdomain' ),
	        'edit_item'         => __( 'Edit range', 'textdomain' ),
	        'update_item'       => __( 'Update range', 'textdomain' ),
	        'add_new_item'      => __( 'Add New range', 'textdomain' ),
	        'new_item_name'     => __( 'New range Name', 'textdomain' ),
	        'menu_name'         => __( 'Range', 'textdomain' ),
	    );

	    $args = array(
	        'hierarchical'      => false,
	        'labels'            => $labels,
	        'show_ui'           => true,
	        'show_admin_column' => true,
	        'query_var'         => true,
	        'rewrite'           => array( 'slug' => 'range' ),
	    );

	    register_taxonomy( 'room_range', 'room', $args );
	}

}
$booking = new CustomBooking();

function custom_booking_create_table() {

	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	$tbl_book = $wpdb->prefix . 'book_room';
	$sql = "CREATE TABLE $tbl_book (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		phone varchar(19) NOT NULL ,
		full_name varchar(55) NOT NULL ,
		email varchar(55) NOT NULL ,
		gmt_time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		local_time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";
	dbDelta( $sql );

}
function custom_booking_install(){
	custom_booking_create_table();
}
register_activation_hook( __FILE__, 'custom_booking_install', 15 );

?>