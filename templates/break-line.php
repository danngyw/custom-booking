<?php

global $post;

 $room_id = $post->ID;
$price      = get_post_meta($room_id,'price', true);
if(!$price){
    $price = 0;
}
$ranges    = get_the_terms($room_id, 'room_range' );
$rate     = get_the_terms($room_id, 'rate' );

?>
<div class="row room-item break-line">

<div class="col-4">
<?php
echo  '<a href="'.get_permalink().'" class="img-link">';
if(has_post_thumbnail()){
    the_post_thumbnail();
}else{
    echo '<img src="'.BOOKING_URL.'/assets/img/no-thumbnail.jpg" >';
}
echo '</a>';
?>
</div>
<div class="col-8">
<a href="<?php echo get_permalink();?>" class="title-link">
    <h3> <?php the_title();?></h3>
</a>

<div class="short">
<span class="room-price"><?php echo $price;?>($)</span>
<?php
    if(!is_wp_error($ranges) && !empty($ranges)){
        $range_string = join(', ', wp_list_pluck($ranges, 'name'));
        echo '<span class="room-range"> '.$range_string.' $(USD)</span>';
    }
    if(!is_wp_error($rate) && !empty($rate)){
        $rate_string = join(', ', wp_list_pluck($rate, 'name'));
        echo '<span class="room-type">  '.$rate_string.' stars</span>';
    }
?>
    <div class="room-excerpt"> <?php    the_excerpt(); ?> </div>
</div>

</div>
</div>