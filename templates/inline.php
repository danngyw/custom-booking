<?php

global $post;

 $room_id = $post->ID;
$price      = get_post_meta($room_id,'price', true);
if(!$price){
    $price = 0;
}
$ranges    = get_the_terms($room_id, 'room_range' );
$rate     = get_the_terms($room_id, 'rate' );

echo '<div class=" col-4 room-item inline">';
echo  '<a href="'.get_permalink().'" class="title-link">';
echo '<h3>'.get_the_title().'</h3>';
echo '</a>';
echo  '<a href="'.get_permalink().'" class="img-link">';
if(has_post_thumbnail()){
    the_post_thumbnail();
}else{
    echo '<img src="'.BOOKING_URL.'/assets/img/no-thumbnail.jpg" >';
}
echo '</a>';
echo '<div class="short">';
    echo '<span class="room-price">'.$price.'($)</span>';
    if(!is_wp_error($ranges) && !empty($ranges)){
        $range_string = join(', ', wp_list_pluck($ranges, 'name'));
        echo '<span class="room-range"> '.$range_string.' $(USD)</span>';
    }
    if(!is_wp_error($rate) && !empty($rate)){
        $rate_string = join(', ', wp_list_pluck($rate, 'name'));
        echo '<span class="room-type">  '.$rate_string.' stars</span>';
    }
    echo '<div class="room-excerpt">';
    the_excerpt();
    echo '</div>';

echo '</div>';
echo '</div>';