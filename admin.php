<?php

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
  <div class="post_author">1</div>
  <div class="comment_status">closed</div>
  <div class="ping_status">closed</div>
  <div class="_status">publish</div>
  <div class="jj">09</div>
  <div class="mm">11</div>
  <div class="aa">2021</div>
  <div class="hh">10</div>
  <div class="mn">08</div>
  <div class="ss">43</div>
  <div class="post_password"></div><div class="page_template">default</div><div class="post_category" id="rate_8">6</div><div class="tags_input" id="room_range_8"></div><div class="sticky"></div></div><div class="row-actions"><span class="edit"><a href="http://localhost/wp/wp-admin/post.php?post=8&amp;action=edit" aria-label="Edit “Phòng đơn”">Edit</a> | </span><span class="inline hide-if-no-js"><button type="button" class="button-link editinline" aria-label="Quick edit “Phòng đơn” inline" aria-expanded="false">Quick&nbsp;Edit</button> | </span><span class="trash"><a href="http://localhost/wp/wp-admin/post.php?post=8&amp;action=trash&amp;_wpnonce=3d6b1c689e" class="submitdelete" aria-label="Move “Phòng đơn” to the Trash">Trash</a> | </span><span class="view"><a href="http://localhost/wp/room/phong-don/" rel="bookmark" aria-label="View “Phòng đơn”">View</a></span></div><button type="button" class="toggle-row"><span class="screen-reader-text">Show more details</span></button></td>


  <td class="taxonomy-rate column-taxonomy-rate" data-colname="Rates"><?php echo $booking->phone;?> </td>
  <td class="taxonomy-room_range column-taxonomy-room_range" data-colname="Range"><?php echo $booking->email;?></td>
  <td class="date column-date" data-colname="Date">Booked:<br>2021/11/09 at 10:08 am</td>    </tr>
  <?php }
function html_list_booking(){

    global $wpdb;
    $tbl_booking   = $wpdb->prefix . 'book_room';
    $book = $sql = "SELECT * FROM $tbl_booking";
    $results = $wpdb->get_results($sql);
    echo '<div class="wrap">';

    ?>
    <form id="posts-filter" method="get">

<p class="search-box">
  <label class="screen-reader-text" for="post-search-input">Search Posts:</label>
  <input type="search" id="post-search-input" name="s" value="">
    <input type="submit" id="search-submit" class="button" value="Search Posts">
    <br />
  </p>
  <p style="margin-bottom: 15px; display: inline-block;"> &nbsp; </p>

   <table class="wp-list-table widefat fixed striped table-view-list posts">
  <thead>
  <tr>
    <td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1">Select All</label><input id="cb-select-all-1" type="checkbox"></td>
    <th scope="col" id="title" class="manage-column column-title column-primary sortable desc">
      <a href="#"><span>Full name</span><span class="sorting-indicator"></span></a>
    </th>

    <th scope="col" id="taxonomy-rate" class="manage-column column-taxonomy-rate">Phone</th>
    <th scope="col" id="taxonomy-room_range" class="manage-column column-taxonomy-room_range">Email</th><th scope="col" id="date" class="manage-column column-date sortable asc"><a href="#wp-admin/edit.php?post_type=room&amp;orderby=date&amp;order=desc"><span>Date</span><span class="sorting-indicator"></span></a></th>
  </tr>
  </thead>

  <tbody id="the-list">

    <?php
      foreach($results as $booking){
        booking_row_html($booking);
      }
      ?>
  </tbody>

  <tfoot>
  <tr>
    <td class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-2">Select All</label><input id="cb-select-all-2" type="checkbox"></td>
    <th scope="col" class="manage-column column-title column-primary sortable desc"><a href="#/edit.php?post_type=room&amp;orderby=title&amp;order=asc"><span>Title</span><span class="sorting-indicator"></span></a></th>

    <th scope="col" class="manage-column column-taxonomy-rate">Phone</th>
    <th scope="col" class="manage-column column-taxonomy-room_range">Email</th>
    <th scope="col" class="manage-column column-date sortable asc">
        <a href="#wp-admin/edit.php?post_type=room&amp;orderby=date&amp;order=desc"><span>Date</span><span class="sorting-indicator"></span></a>
      </th>
      </tr>
  </tfoot>

</table>

</form>
</div>
<?php
}