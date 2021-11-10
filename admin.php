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
    <input type="submit" id="search-submit" class="button" value="Search Posts"></p>
    <?php
    echo '<table class="wp-list-table widefat fixed striped table-view-list pages">';
    ?>
    <thead>
  <tr>
    <td id="cb" class="manage-column column-cb check-column">
      <label class="screen-reader-text" for="cb-select-all-1">Select All</label>
      <input id="cb-select-all-1" type="checkbox"></td>
      <th scope="col" id="title" class="manage-column column-title column-primary sortable desc"><a href="http://localhost/wp/wp-admin/edit.php?post_type=page&amp;orderby=title&amp;order=asc"><span>Full name</span><span class="sorting-indicator"></span></a></th><th scope="col" id="author" class="manage-column column-author">Phone</th><th scope="col" id="comments" class="manage-column column-comments num sortable desc"><a href="http://localhost/wp/wp-admin/edit.php?post_type=page&amp;orderby=comment_count&amp;order=asc"><span>
      </span></span><span class="sorting-indicator"></span></a></th>
      <th scope="col" id="date" class="manage-column column-date sortable asc"><a href="http://localhost/wp/wp-admin/edit.php?post_type=page&amp;orderby=date&amp;order=desc"><span>Email</span><span class="sorting-indicator"></span></a></th>
    </tr>
  </thead>
  <?php
      foreach($results as $booking){
      echo '<tr>';
      ?>
      <th scope="row" class="check-column">
      <input id="cb-select-1" type="checkbox" name="post[]" value="1">

      </th><?php
      echo '<td>'.$booking->full_name.'</td>';
      echo '<td>'.$booking->phone.'</td>';
      echo '<td>'.$booking->email.'</td>';
      echo '</tr>';
      }
    echo '</table>';
    echo '</form>';
    echo '</div>';
}