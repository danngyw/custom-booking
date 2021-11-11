<?php
Class bookingAdmin{
	public $order_url;
	public $posts_per_page ;
	public $search;
	public $paged;
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
		$colums = array('full_name','phone','email','local_date','status');
	}

	function item($booking){

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

	    //page 1 - (records 01-10): offset = 0, limit=10;

	    //page 2 - (records 11-20) offset = 10, limit =10;

	    $sql = "SELECT * FROM $tbl_booking $search_where ORDER BY  id {$order}";

	    $offset 			= ($this->paged-1)*$this->posts_per_page;
	    $sql_current_page 	= "SELECT * FROM $tbl_booking $search_where ORDER BY  id {$order}   LIMIT  $offset, 10 ";
	    $total_results 		= $wpdb->get_results($sql);
	    $total 				= count($total_results);
	    $results = $wpdb->get_results($sql_current_page);
	      $this->table_header($total);
	        if($results){
	            foreach($results as $booking){
	              booking_row_html($booking);
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
					<th scope="col" id="title" class="manage-column column-title column-primary desc">
					<span>Full name</span>
					</th>

					<th scope="col" id="taxonomy-rate" class="manage-column ">Phone</th>
					<th scope="col" id="taxonomy-room_range" class="manage-column column-taxonomy-room_range">Email</th><th scope="col" id="date" class="manage-column column-date sortable desc"><a href="<?php echo $this->order_url;?>"><span>Date</span><span class="sorting-indicator"></span></a></th>
				</tr>
			</thead>

			<tbody id="the-list"> <?php
	}
	function table_footer($total){ ?>
				</tbody>

				<tfoot>
					<tr>
					<td class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-2">Select All</label><input id="cb-select-all-2" type="checkbox"></td>
					<th scope="col" class="manage-column column-title column-primary desc"><span>Full name</span></th>

					<th scope="col" class="manage-column column-taxonomy-rate">Phone</th>
					<th scope="col" class="manage-column column-taxonomy-room_range">Email</th>
					<th scope="col" class="manage-column column-date sortable asc">
					<a href="<?php echo $this->order_url;?>"><span>Date</span><span class="sorting-indicator"></span></a>
					</th>
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
	</div><?php
	}
}