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