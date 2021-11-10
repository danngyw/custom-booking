<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header();
the_post();

/* Start the Loop */
echo '<div class="container single-room">';
?>
<h1><?php the_title();?> </h1>
<br />
<hr />
<?php


	if(has_post_thumbnail())
		the_post_thumbnail('full');

	global $post;
    $room_id = $post->ID;
    $price      = get_post_meta($room_id,'price', true);
    if(!$price){
        $price = 0;
    }
    $ranges    = get_the_terms($room_id, 'room_range' );
    $rate     = get_the_terms($room_id, 'rate' );
    echo '<br />';
    echo '<span class="room-price"><strong>Price:</strong> '.$price.'($)</span>';
    if(!is_wp_error($ranges) && !empty($ranges)){
        $range_string = join(', ', wp_list_pluck($ranges, 'name'));
        echo '<span class="room-range"><strong>Range:</strong> '.$range_string.' stars</span>';
    }
    if(!is_wp_error($rate) && !empty($rate)){
        $rate_string = join(', ', wp_list_pluck($rate, 'name'));
        echo '<span class="room-type"><strong>Type:</strong> '.$rate_string.' stars</span>';
    }

    the_content();


echo '</div>';
get_footer();
