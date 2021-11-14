<?php

/**
 * clone method load_template
 *
 **/
function box_load_template ( $_template_file, $require_once = true, $args = array() ) {
	global $posts, $post, $wp_did_header, $wp_query, $wp_rewrite, $wpdb, $wp_version, $wp, $id, $comment, $user_ID;

	if ( is_array( $wp_query->query_vars ) ) {
		/*
		 * This use of extract() cannot be removed. There are many possible ways that
		 * templates could depend on variables that it creates existing, and no way to
		 * detect and deprecate it.
		 *
		 * Passing the EXTR_SKIP flag is the safest option, ensuring globals and
		 * function variables cannot be overwritten.
		 */
		// phpcs:ignore WordPress.PHP.DontExtract.extract_extract
		extract( $wp_query->query_vars, EXTR_SKIP );
	}

	if ( isset( $s ) ) {
		$s = esc_attr( $s );
	}
	$template = BOOKING_PATH.'/'.$_template_file;
	if( file_exists($template ) ){
		require $template;
	} else{
		echo ' file not exists';
	}
}