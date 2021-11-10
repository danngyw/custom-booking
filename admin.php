<?php
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
      'dashicons-media-spreadsheet'
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
      </th><td class="title column-title has-row-actions column-primary page-title" data-colname="Title"><div class="locked-info"><span class="locked-avatar"></span> <span class="locked-text"></span></div>
<strong><a class="row-title" href="http://localhost/wp/wp-admin/post.php?post=8&amp;action=edit" aria-label="“Phòng đơn” (Edit)"><?php echo $booking->full_name;?></a></strong>

<div class="hidden" id="inline_8">
  <div class="post_title"><?php echo $booking->full_name;?></div><div class="post_name">phong-don</div>
  <?php

  $string = "?page=booking-room&action=delete&id={$booking->id}";
  $trash_url = admin_url($string);
  ?>
  <div class="post_password"></div><div class="page_template">default</div>
  <div class="post_category" id="rate_8">6</div><div class="tags_input" id="room_range_8"></div><div class="sticky"></div></div><div class="row-actions"><span class="edit"><a href="http://localhost/wp/wp-admin/post.php?post=8&amp;action=edit" aria-label="Edit “Phòng đơn”">Edit</a> | </span><span class="inline hide-if-no-js"><button type="button" class="button-link editinline" aria-label="Quick edit “Phòng đơn” inline" aria-expanded="false">Quick&nbsp;Edit</button> | </span>
    <span class="trash"><a href="<?php echo $trash_url;?>" class="submitdelete" onclick="return confirm_delete()" aria-label="Move “Phòng đơn” to the Trash">Delete</a> | </span><span class="view"><a href="http://localhost/wp/room/phong-don/" rel="bookmark" aria-label="View “Phòng đơn”">View</a></span></div><button type="button" class="toggle-row"><span class="screen-reader-text">Show more details</span></button></td>


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

    global $wpdb;
    $tbl_booking   = $wpdb->prefix . 'book_room';

    $order      = isset($_GET['order']) ? strtoupper($_GET['order']) : 'DESC';
    $action     = isset($_GET['action']) ? $_GET['action'] : '';
    $id         = isset($_GET['id']) ? strtoupper($_GET['id']) : 0;
    $admin_url = admin_url('?page=booking-room');

    if( $action == 'delete' && $id > 0){
        delete_booking_record($id);
    }

    if($order == 'DESC'){
      $order_url = admin_url('?page=booking-room&orderby=date&order=asc');
    } else{
      $order = 'ASC';
      $order_url = admin_url('?page=booking-room&orderby=date&order=desc');
    }
    $text = isset($_GET['s']) ? $_GET['s'] : '';
    $search  = '';
    if($text){
        $order_url.='&s='.$text;
        $search = " WHERE full_name LIKE '%{$text}%' OR email LIKE '%{$text}%' OR phone LIKE '%{$text}%'";
    }
    $sql = "SELECT * FROM $tbl_booking $search ORDER BY  id {$order}";
    $results = $wpdb->get_results($sql);

    echo '<div class="wrap">';

    ?>
    <script type="text/javascript">
    function confirm_delete() {
      return confirm('are you sure?');
    }
    </script>

    <h1 class="wp-heading-inline">List Booking</h1>
    <form id="posts-filter" method="get" action="<?php echo $admin_url;?>">

        <p class="search-box">
            <label class="screen-reader-text" for="post-search-input">Search :</label>
            <input type="hidden" id="post-search-input" name="page" value="booking-room">
            <input type="text" id="post-search-input" name="s" value="<?php echo $text;?>">
            <input type="submit" id="search-submit" class="button" value="Search Booking">
            <br />
        </p>
        <p style="margin-bottom: 15px; display: inline-block;"> &nbsp; </p>
        <?php
        table_booking_header($order_url);
        if($results){
            foreach($results as $booking){
              booking_row_html($booking);
            }
        } else{
            echo('<tr><td colspan="4"><h3>No booking found.</h3></td></tr>');
        }
        table_booking_footer($order_url);
        ?>
    </form>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    $(".submitdelete").click(function(){
      alert('111');
    });
  })
</script>
<?php
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