<?php


function show_list_room(){
    $args = array(
        'post_type'     => 'room',
        'post_status'   => 'publish',
    );
    $query  = new WP_Query($args);
    if($query->have_posts()){
        echo '<div class="container"> <div class="row">';
        while($query->have_posts()){
            $query->the_post();
            global $post;
            $room_id = $post->ID;
            $price      = get_post_meta($room_id,'price', true);
            if(!$price){
                $price = 0;
            }
            $ranges    = get_the_terms($room_id, 'room_range' );
            $rate     = get_the_terms($room_id, 'rate' );

            echo '<div class=" col-4 room-item">';
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
        }
        echo '</div></div>';
    } else {
        echo 'No room found.';
    }
}
function shortcode_booking_room($atts){
    $attributes = shortcode_atts( array(
        'title' => false,
        'limit' => 4,
    ), $atts );

    ob_start();

    show_list_room();

    return ob_get_clean();
}
add_shortcode( 'booking_room', 'shortcode_booking_room' );

function shortcode_booking_form(){
     ob_start(); ?>
    <form class="booking-form needs-validation">
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="fullname" required class="form-control"  placeholder="Name">
        </div>
        <div class="form-group">
            <label >Email</label>
            <input type="email" name="email" required class="form-control"  placeholder="Your Email">
        </div>
        <div class="form-group">
            <label >Phone number</label>
            <input type="text" name="phone" required class="form-control"  placeholder="Phone Number">
        </div>
        <div class="row">
            <div class='col-sm-6'>
                 <label for="validationTooltip02">Check In</label>
                <div class='input-group date' id='datetimepicker1'>
                    <input type='text' class="form-control datepicker" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>

            </div>
            <div class="col-md-6">
                <label for="validationTooltip02">Check Out</label>
                <div class='input-group date' id='datetimepicker1'>
                    <input type='text' class="form-control datepicker" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>


        <div class="form-group">
        <button type="submit" class="button-submit form-control "placeholder="Send"> SEND <span class="btn-loading">&nbsp;</span> </button>
        </div>
    </form>
    <?php
    return ob_get_clean();
}

add_shortcode( 'booking_form', 'shortcode_booking_form' );
// $date =  current_time( 'mysql' );
// $date=date_create("2013-03-15");

// echo date_format($date,"Y/m/d at H:i a");
// echo '11 <br />';
// echo date_format($date,"Y/m/d H:i:s");
//2021/11/09 at 10:08 am<