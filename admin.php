<?php

require_once('class-booking-admin.php');
function delete_booking_record($id){
    global $wpdb;                           // WPDB class object
    $tbl_book  = $wpdb->prefix . 'book_room';
    $check =  $wpdb->delete(
        $tbl_book,          // table name with dynamic prefix
        ['id' => $id],                       // which id need to delete
        ['%d'],                             // make sure the id format
    );
    if($check){
        echo '<p> A booking has been deleted.</p>';
    }
}
add_action('admin_menu', 'custom_menu');
function custom_menu() {

  add_menu_page(
      'Booking Room',
      'Booking Room',
      'manage_options',
      'booking-room',
      'html_list_booking',
      'dashicons-media-spreadsheet',
      11
    );
}
function booking_row_html($booking){?>
  <tr id="post-8" class="iedit author-self level-0 post-8 type-room status-publish hentry rate-6 entry">
      <th scope="row" class="check-column">     <label class="screen-reader-text" for="cb-select-8">
        Select Phòng đơn      </label>
      <input id="cb-select-8" type="checkbox" name="post[]" value="8">
      <div class="locked-indicator">
        <span class="locked-indicator-icon" aria-hidden="true"></span>
        <span class="screen-reader-text">
        “Phòng đơn” is locked       </span>
      </div>
      </th>
      <td class="title column-title has-row-actions column-primary page-title" data-colname="Title">
        <div class="locked-info"><span class="locked-avatar"></span> <span class="locked-text"></span></div>
        <strong><a class="row-title" href="#" ><?php echo $booking->full_name;?></a></strong>

<div class="hidden" id="inline_8">
  <div class="post_title"><?php echo $booking->full_name;?></div><div class="post_name">phong-don</div>
  <?php

  $string = "?page=booking-room&action=delete&id={$booking->id}";
  $trash_url = admin_url($string);
  ?>
  <div class="post_password"></div><div class="page_template">default</div>
  <div class="tags_input" id="room_range_8"></div><div class="sticky"></div></div><div class="row-actions"><span class="edit"><a href="#" aria-label="Edit “Phòng đơn”">Edit</a> | </span><span class="inline hide-if-no-js">| </span>
    <span class="trash"><a href="<?php echo $trash_url;?>" class="submitdelete" onclick="return confirm_delete()" >Delete</a> | </span>
    <span class="view"><a href="#" rel="bookmark" aria-label="View ">View</a></span></div>
  <td class="taxonomy-rate column-taxonomy-rate" data-colname="Rates"><?php echo $booking->phone;?> </td>
  <td class="taxonomy-room_range column-taxonomy-room_range" data-colname="Range"><?php echo $booking->email;?></td>
  <td class="date column-date" data-colname="Date">
    <?php
    $time = strtotime($booking->local_time);
    if( $time>1 ) {
        // echo 'Booked:<br>';
        // //echo $booking->date_booking;
        // echo date_i18n('Y/m/d h:i',$time , $gmt = true);
        //echo get_the_date('Y/m/d', $time);
        echo 'Booked:<br>'; echo date("Y/m/d H:i a", strtotime($booking->local_time));
    };
        ?>

         </td>    </tr>
  <?php }
function html_list_booking(){


    $table = new bookingAdmin();
    $table->show();
}

function table_booking_footer(){?>
</tbody>

  <tfoot>
  <tr>
    <td class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-2">Select All</label><input id="cb-select-all-2" type="checkbox"></td>
    <th scope="col" class="manage-column column-title column-primary desc"><span>Full name</span></th>

    <th scope="col" class="manage-column column-taxonomy-rate">Phone</th>
    <th scope="col" class="manage-column column-taxonomy-room_range">Email</th>
    <th scope="col" class="manage-column column-date sortable asc">
        <a href="<?php echo $order_url;?>"><span>Date</span><span class="sorting-indicator"></span></a>
      </th>
      </tr>
  </tfoot>

</table>
<?php }

function table_booking_header($order_url){

    ?>
<table class="wp-list-table widefat fixed striped table-view-list posts">
  <thead>
  <tr>
    <td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1">Select All</label><input id="cb-select-all-1" type="checkbox"></td>
    <th scope="col" id="title" class="manage-column column-title column-primary desc">
      <span>Full name</span>
    </th>

    <th scope="col" id="taxonomy-rate" class="manage-column column-taxonomy-rate">Phone</th>
    <th scope="col" id="taxonomy-room_range" class="manage-column column-taxonomy-room_range">Email</th><th scope="col" id="date" class="manage-column column-date sortable asc"><a href="<?php echo $order_url;?>"><span>Date</span><span class="sorting-indicator"></span></a></th>
  </tr>
  </thead>

  <tbody id="the-list">
  <?php }