<?php


function show_list_room($att){
    $args = array(
        'post_type'     => 'room',
        'post_status'   => 'publish',
    );
    $layout = isset($att['layout']) ?$att['layout'] :'inline';
    $line_css = $line_close= '';
    if($layout == 'inline'){
        $line_css = '<div class="row">';
        $line_close = '</div>';
    }
    $query  = new WP_Query($args);
    if($query->have_posts()){
        echo '<div class="container">';
        echo $line_css;
        while($query->have_posts()){
            $query->the_post();
            global $post;
            if($layout == 'inline'){
                box_load_template('templates/inline.php','', $post);
            } else{
                box_load_template('templates/break-line.php','', $post);
            }

        }
        echo $line_close;
        echo '</div>';
    } else {
        echo 'No room found.';
    }
}
function shortcode_booking_room($atts){
    $att = shortcode_atts( array(
        'title' => false,
        'layout' => '',
    ), $atts );
    ob_start();

    show_list_room($atts);

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