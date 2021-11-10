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
require_once('booking-shortcodes.php');
require_once('admin.php');
Class CustomBooking{
	function __construct(){
		add_action( 'init', array($this, 'custom_codex_custom_init' ));
		add_action( 'wp_footer', array($this, 'add_custom_css' ));
		add_action('wp_head',array($this,'add_css'));
		add_action('wp_enqueue_scripts', array($this, 'enqueue_script'));
		add_action('wp_ajax_save_booking',array($this,'save_booking'));
		add_action('wp_ajax_nopriv_save_booking',array($this,'save_booking'));
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
		wp_enqueue_script('validate','https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js', array('jquery'), rand(), true);
		wp_enqueue_script( 'booking',
        	plugin_dir_url( __FILE__ ) . '/js/booking.js',
	        array('jquery','validate'),
	        rand(),
	        true
	    );
	}
	function add_css(){
	?>
	<script type="text/javascript">
		var booking = {ajax_url:'<?php echo admin_url().'admin-ajax.php'; ?>'};
	</script>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
		<?php

	}
	function custom_codex_custom_init() {
		$args = array(
	        'public'    => true,
	        'label'     => __( 'Rooms', 'textdomain' ),
	        'menu_icon' => 'dashicons-book',
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
	function add_custom_css(){

		?>
		<style type="text/css">
			.col-md-3{
				width: 33.33%;
				display: inline-block;
				padding: 10px;
				float: left;
			}
			.col-md-3 a{
				text-decoration: none;
			}
			.room-type,.room-excerpt,.room-price{
				display: block;
				clear: both;
			}
			.room-item{
				overflow: hidden;
				font-size: 15px;
				margin:  0 0 15px 0;
			}
			.room-item a{
				font-size: 15px;
			}
			.room-item a img{
				max-height: 300px;
				clear: both;
				display: block;
				margin-bottom: 10px;
				border-radius: 5px;
			}
			.room-item h3{
				font-size: 25px;
				margin-bottom: 10px;
			}
			.single-room img{
				border-radius: 5px;
				margin: 10px 0 15px 0;
			}
			.booking-form button.disabled{
				background-color: #ccc !important;
			}
			.form-group label.error{
				font-size: 13px;
				color: #db8317;
			}
			.booking-form input{
				border: 1px solid #ccc;
				border-radius: 3px;
			}
			.booking-form button.button-submit,
			button:not(:hover):not(:active):not(.has-background){
				background-color: green !important;
			    color: #fff;
			    font-weight: 450;
			    font-size: 15px;
			    border: 1px solid green;
			    height: 39px;
			}
			.booking-form input[type=text]:focus{
				outline: 0 !important;
			}

		</style>
	<?php }

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