<?php
Class bookingAdmin{
	public $order_url;
	public $posts_per_page ;
	public $search;
	public $paged;
	public $colums;
	function __construct(){
		$this->posts_per_page  = 10;
		$this->search 	= isset($_GET['s']) ? $_GET['s'] : '';
		$this->paged 	= isset($_GET['paged']) ? (int) $_GET['paged']: 1;
		$order      	= isset($_GET['order']) ? strtoupper($_GET['order']) : 'DESC';
		$this->url  	= admin_url('?page=booking-room');
		if($order == 'DESC'){
	      $this->order_url = admin_url('?page=booking-room&order=asc');
	    } else{
	      $order = 'ASC';
	      $this->order_url = admin_url('?page=booking-room');
	    }
		$this->colums = array(
			'full_name' 	=> array('label'=>' Full name','class'=>'column-title column-primary'),
			'phone' 			=> array('label'=>'Phone','class'=>'column-phone column-format'),
			'email' 			=> array('label'=>'email','class'=>' column-author'),
			'local_date' 	=> array('label'=>'Date','class'=>'column-date column-format'),
			'status' 			=> array('label'=>'Status','class'=>'column-status'),
		);
	}

	function item($booking){ ?>

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
	  <div class="post_password"></div>
	  <div class="page_template">default</div>
	  <div class="tags_input" id="room_range_8"></div><div class="sticky"></div>
</div>
  <div class="row-actions">
  	<span class="edit"><a href="#" aria-label=>Edit</a> | </span><span class="inline hide-if-no-js">| </span>
    <span class="trash"><a href="<?php echo $trash_url;?>" class="submitdelete" onclick="return confirm_delete()" >Delete</a> | </span>
    <span class="view"><a href="#" rel="bookmark" aria-label="View ">View</a></span>
  </div>
  <td class="taxonomy-rate column-taxonomy-rate" data-colname="Rates"><?php echo $booking->phone;?> </td>
  <td class="taxonomy-room_range column-taxonomy-room_range" data-colname="Range"><?php echo $booking->email;?></td>
  <td class="date column-date" data-colname="Date">
    <?php
    $time = strtotime($booking->local_time);
    if( $time>1 ) {
        echo 'Booked:<br>'; echo date("Y/m/d H:i a", strtotime($booking->local_time));
    };        ?>
	</td>
	<td class="date column-date" data-colname="Date">Status</td>

</tr>
         <?php
	}
	function show(){
		$this->list_booking();

	}
	function list_booking(){
		global $wpdb;
		$tbl_booking   = $wpdb->prefix . 'book_room';
	    $order      = isset($_GET['order']) ? strtoupper($_GET['order']) : 'DESC';
	    $action     = isset($_GET['action']) ? $_GET['action'] : '';
	    $id         = isset($_GET['id']) ? strtoupper($_GET['id']) : 0;

	    if( $action == 'delete' && $id > 0){
	        delete_booking_record($id);
	    }

	    if($order == 'DESC'){
	    } else{
	      $order = 'ASC';
	    }
	    $search_where = '';

	    if($this->search){
	        $this->order_url.='&s='.$this->search;
	        $search_where = " WHERE full_name LIKE '%{$this->search}%' OR email LIKE '%{$this->search}%' OR phone LIKE '%{$this->search}%'";
	    }

	    $sql = "SELECT * FROM $tbl_booking $search_where ORDER BY  id {$order}";

	    $offset 			= ($this->paged-1)*$this->posts_per_page;
	    $sql_current_page 	= "SELECT * FROM $tbl_booking $search_where ORDER BY  id {$order}   LIMIT  $offset, 10 ";
	    $total_results 		= $wpdb->get_results($sql);
	    $total 				= count($total_results);
	    $results = $wpdb->get_results($sql_current_page);
	      $this->table_header($total);
	        if($results){
	            foreach($results as $booking){
	              	$this->item($booking);
	            }
	        } else {
	            echo('<tr><td colspan="4"><h3>No booking found.</h3></td></tr>');
	        }
	        $this->table_footer($total);
	}

	function col_full_name(){

	}
	function col_phone(){

	}

	function table_header($total){ ?>
		<div class="wrap">
		    <script type="text/javascript">
		    function confirm_delete() {
		      return confirm('are you sure?');
		    }
	    </script>

	    <h1 class="wp-heading-inline">List Booking</h1>
	    <hr class="wp-header-end">
	    <h2 class="screen-reader-text">Filter posts list</h2>
	    <ul class="subsubsub">
	      <li class="all"><a href="#" class="current" aria-current="page">All <span class="count">(<?php echo $total;?>)</span></a> |</li>
	      <li class="publish"><a href="#">Published <span class="count">(<?php echo $total;?>)</span></a></li>
	       <li class="archived"><a href="#">Archived <span class="count">(0)</span></a></li>
	    </ul>
	    <form id="posts-filter" method="get" action="<?php echo $this->url;?>">

	        <p class="search-box">
	            <label class="screen-reader-text" for="post-search-input">Search :</label>
	            <input type="hidden" id="post-search-input" name="page" value="booking-room">
	            <input type="text" id="post-search-input" name="s" placeholder="Keyword" value="<?php echo $this->search;?>">
	            <input type="submit" id="search-submit" class="button" value="Search Booking">
	            <br />
	        </p>
	        <p style="margin-bottom: 15px; display: inline-block;"> &nbsp; </p>
		<table class="wp-list-table widefat fixed striped table-view-list posts">
			<thead>
				<tr>
					<td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1">Select All</label><input id="cb-select-all-1" type="checkbox"></td>

					<?php foreach($this->colums as $colum){
						;
						echo '<th scope="col" id="taxonomy-rate" class="manage-column '.$colum['class'].'">'.$colum['label'].'</th>';
					}
					?>

				</tr>
			</thead>

			<tbody id="the-list"> <?php
	}
	function table_footer($total){ ?>
				</tbody>

				<tfoot>
					<tr>
					<td class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-2">Select All</label><input id="cb-select-all-2" type="checkbox"></td>
					<!-- <th scope="col" class="manage-column column-title column-primary desc"><span>Full name</span></th>

					<th scope="col" class="manage-column column-taxonomy-rate">Phone</th>
					<th scope="col" class="manage-column column-taxonomy-room_range">Email</th>
					<th scope="col" class="manage-column column-date sortable asc">
						<a href="<?php echo $this->order_url;?>"><span>Date</span><span class="sorting-indicator"></span></a>
					</th> -->
					<?php foreach($this->colums as $colum){
						;
						echo '<th scope="col" id="taxonomy-rate" class="manage-column ">'.$colum['label'].'</th>';
					} ?>
					</tr>

				</tfoot>

			</table>
		</form>
	    <div class="tablenav bottom">
			<div class="tablenav-pages">
				<?php
				$big = 999999999; // need an unlikely integer
				$max = ceil($total/$this->posts_per_page);
				echo paginate_links( array(
				'base'  => str_replace( $big, '%#%', get_pagenum_link( $big )  ),
				'format'  => '?paged=%#%',
				'current' => max( 1, $this->paged ),
				'total'   => $max
				) );
				?>
			</div>
	    </div>
	</div>
	<style type="text/css">
		.column-status{
			width: 95px;
		}
	</style>

	<?php
	}
}