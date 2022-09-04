<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Plugin Model Class
 *
 * Handles generic functionailties
 *
 * @package Books Store
 * @since 1.0.0
 */

class Book_Store_Model {
 	 	
 	//class constructor
	public function __construct()	{		

		add_shortcode( 'book-search-layout', array( $this, 'book_search_html' ) );

		// Custom ajax search for Book Search filter link.
		add_action('wp_ajax_nopriv_book_search_filtering', array($this, 'book_search_filtering'));
	    add_action('wp_ajax_book_search_filtering', array($this, 'book_search_filtering'));

	}
		
	/**
	  * Escape Tags & Slashes
	  *
	  * Handles escapping the slashes and tags
	  *
	  * @package Books Store
	  * @since 1.0.0
	  */
	   
	 public function book_store_escape_attr($data){
	  
	 	return esc_attr(stripslashes($data));
	 }
	 
	 /**
	  * Stripslashes 
 	  * 
  	  * It will strip slashes from the content
	  *
	  * @package Books Store
	  * @since 1.0.0
	  */
	   
	 public function book_store_escape_slashes_deep($data = array(),$flag = false){
	 	
	 	if($flag != true) {
			$data = $this->book_store_nohtml_kses($data);
		}
		$data = stripslashes_deep($data);
		return $data;
	 }

	 /**
	 * Book Store - Custom ajax filtering 
	 * 
	 * Custom code to implement book search filtering
	 * 
	 * @package Books Store
	 * @since 1.0.0
	 */

	 public function book_search_filtering(){

		$prefix = BOOK_STORE_PREFIX;
		$meta_query_args = array();
		$get_data_args = array(
			'post_type'      => 'book_store_book',
			'posts_per_page' => -1,
			'post_status'    => 'publish',
			'order' => 'ASC',
		);

		/* Custom code to search on basis of book title */
		if( !empty( $_POST['book_title'] ) ) {
			$get_data_args['s'] = $_POST['book_title']; 
		}

		/* Custom code to search on basis of rating */
		if( !empty( $_POST['book_rating'] ) ) {
			
			$meta_query_args[] = array(
				'key'     => $prefix . '_rating',
				'value'   => $_POST['book_rating'],
				'compare' => '='
			  ); 
		}

		/* Custom code to search on basis of price */
		if( !empty( $_POST['book_pricing'] ) ) {
			$meta_query_args['relation'] = "AND";
			$meta_query_args[] = array(
				'key'     => $prefix . '_price',
				'type'     => 'numeric',
				'value'   => array(0,$_POST['book_pricing']),
				'compare' => 'between'
			  ); 
		}


		$get_data_args['meta_query'] = $meta_query_args;
		$books_data = new WP_Query($get_data_args);
		
	
		
		 if ($books_data->have_posts()) : 
			while ( $books_data->have_posts() ) : $books_data->the_post(); 

			$book_store_custom_price = get_post_meta( get_the_ID(), $prefix . '_price', true );
			$book_store_star_rating = get_post_meta( get_the_ID(), $prefix . '_rating', true );
			$book_store_author_details = get_the_terms( get_the_ID(), 'author' );
			if( !empty( $book_store_author_details ) && is_array( $book_store_author_details ) ){
				$book_store_author_name = $book_store_author_details[0]->name;
			}	

			$book_store_publisher_details = get_the_terms( get_the_ID(), 'publisher' );
			$book_store_publisher_name = '';
			if( !empty( $book_store_publisher_details ) && is_array( $book_store_publisher_details ) ) {
				if( count( $book_store_publisher_details ) == 1) {
					$book_store_publisher_name = $book_store_publisher_details[0]->name;
				} else {
					$book_store_multiple_publisher_data = array();
					foreach( $book_store_publisher_details as $key => $publisher_data ) {
						$book_store_multiple_publisher_data[$key] = $publisher_data->name;
					}
					$book_store_publisher_name = implode(", ",$book_store_multiple_publisher_data);
				}
			}	

		?>
		<tr>
			<th scope="row"><?php echo get_the_ID(); ?></th>
			<td><a target="_blank" href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></td></a>
			<td><?php echo $book_store_custom_price; ?></td>
			<td><?php echo $book_store_author_name; ?></td>
			<td><?php echo $book_store_publisher_name; ?></td>
			<td>
			<div class="star-rating">
				<?php for( $i=0 ; $i < 5 ; $i++ ) { 
						$star_class = '';
						if( $i < ( $book_store_star_rating)  ) {
							$star_class = 'dashicons-star-filled';
						} else {
							$star_class = 'dashicons-star-empty';
						}
					?>	
					<span class="dashicons <?php echo $star_class; ?>"></span>
				<?php } ?>	
			  </div>
			</td>	
		</tr>

		<?php 
			endwhile; 
			else:
		?>
		  	<tr>
				<td colspan='6'><?php echo esc_html('No Posts found based on your criteria.','bkstore') ?></td>
			</tr>

		<?php	
		endif;	
			 
		die();
	 }



	/**
	 * BootStrap Search - Shortcode 
	 * 
	 * Custom code to implement shortcode for Book Search functionality on front-end.
	 * 
	 * @package Books Store
	 * @since 1.0.0
	 */

	public function book_search_html(){

		ob_start();

		$prefix = BOOK_STORE_PREFIX;	
		$available_ratings = array(1,2,3,4,5);
		$available_authors = get_terms( array(
			'taxonomy' => 'author',
			'hide_empty' => true,
		) );
		$available_publisher = get_terms( array(
			'taxonomy' => 'publisher',
			'hide_empty' => true,
		) );

		$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
		
		$get_data_args = array(
			'post_type'      => 'book_store_book',
			'posts_per_page' => 5,
			'post_status'    => 'publish',
			'paged' => $paged,
			'order' => 'ASC',
		);
		$books_data = new WP_Query($get_data_args);

	
		?>
			<form method="post" id="book-search-form" name="book-search-form" class="row g-3">
				<h2 class="text-center"><?php echo esc_html('Book Search','bkstore') ?></h2>
				<div class="col-md-6">
					<label for="book_title" class="form-label"><?php echo esc_html('Book Name:','bkstore') ?></label>
					<input type="text" class="form-control" id="book_title">
				</div>
				<div class="col-md-6">
					<label for="book_author" class="form-label"><?php echo esc_html('Author:','bkstore') ?></label>
					<select id="book_author" class="form-select">
						<option selected>Choose...</option>
						<?php if( !empty( $available_authors ) && is_array( $available_authors ) ) { 
							foreach( $available_authors as $author_key => $author ) { ?>
								<option value="<?php echo $author->term_id;; ?>"><?php echo $author->name; ?></option>
						<?php } 
						}	
					?>	
					</select>
				</div>
				<div class="col-md-6">
					<label for="book_publisher" class="form-label"><?php echo esc_html('Publisher:','bkstore') ?></label>
					<select id="book_publisher" class="form-select">
						<option selected>Choose...</option>
						<?php if( !empty( $available_publisher ) && is_array( $available_publisher ) ) { 
							foreach( $available_publisher as $publisher_key => $publisher ) { ?>
								<option value="<?php echo $publisher->term_id;; ?>"><?php echo $publisher->name; ?></option>
						<?php } 
						}
						?>
					</select>
				</div>
				<div class="col-md-6">
					<label for="book_rating" class="form-label"><?php echo esc_html('Rating:','bkstore') ?></label>
					<select id="book_rating" class="form-select">
					<option selected>Choose...</option>
					<?php if( !empty( $available_ratings ) && is_array( $available_ratings ) ) { 
							foreach( $available_ratings as $key => $rating ) { ?>
								<option value="<?php echo ($key + 1); ?>"><?php echo $rating; ?></option>
					<?php } 
						}	
					?>	
					</select>
				</div>
				<div class="col-md-6">
					<label for="book_price" class="form-label"><?php echo esc_html('Price:','bkstore') ?></label>
					<span class="font-weight-bold purple-text mr-2 mt-1">0</span>
						<input type="range" class="form-range w-50" step="100" min="0" max="3000" id="book_price">
						<input type="hidden" id="selected_book_price" value/>
					<span class="font-weight-bold purple-text ml-2 mt-1">3000</span>
					<b><span class="price-indicator"></span></b>		
				</div>
				<div class="col-12 text-center">
					<button type="submit" class="btn btn-primary book-search"><?php echo esc_html('Search...','bkstore') ?></button>
					<div id="overlay"><div class="cv-spinner"><span class="spinner"></span></div></div>
				</div>
			</form>
			<table  class="table book-search-records" id="book-search-records">
			<thead>
				<tr>
					<th scope="col"><?php echo esc_html('No','bkstore') ?></th>
					<th scope="col"><?php echo esc_html('Book Name.','bkstore') ?></th>
					<th scope="col"><?php echo esc_html('Price','bkstore') ?></th>
					<th scope="col"><?php echo esc_html('Author','bkstore') ?></th>
					<th scope="col"><?php echo esc_html('Publisher','bkstore') ?></th>
					<th scope="col"><?php echo esc_html('Rating','bkstore') ?></th>
				</tr>
			</thead>
			<tbody>
				<?php if ($books_data->have_posts()) : 
						while ( $books_data->have_posts() ) : $books_data->the_post(); 

						$book_store_custom_price = get_post_meta( get_the_ID(), $prefix . '_price', true );
						$book_store_star_rating = get_post_meta( get_the_ID(), $prefix . '_rating', true );
						$book_store_author_details = get_the_terms( get_the_ID(), 'author' );
						if( !empty( $book_store_author_details ) && is_array( $book_store_author_details ) ){
							$book_store_author_name = $book_store_author_details[0]->name;
						}	

						$book_store_publisher_details = get_the_terms( get_the_ID(), 'publisher' );
						$book_store_publisher_name = '';
						if( !empty( $book_store_publisher_details ) && is_array( $book_store_publisher_details ) ) {
							if( count( $book_store_publisher_details ) == 1) {
								$book_store_publisher_name = $book_store_publisher_details[0]->name;
							} else {
								$book_store_multiple_publisher_data = array();
								foreach( $book_store_publisher_details as $key => $publisher_data ) {
									$book_store_multiple_publisher_data[$key] = $publisher_data->name;
								}
								$book_store_publisher_name = implode(", ",$book_store_multiple_publisher_data);
							}
						}	

					?>
					<tr>
						<th scope="row"><?php echo get_the_ID(); ?></th>
						<td><a target="_blank" href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></td></a>
						<td><?php echo $book_store_custom_price; ?></td>
						<td><?php echo $book_store_author_name; ?></td>
						<td><?php echo $book_store_publisher_name; ?></td>
						<td>
						<div class="star-rating">
							<?php for( $i=0 ; $i < 5 ; $i++ ) { 
									$star_class = '';
									if( $i < ( $book_store_star_rating)  ) {
										$star_class = 'dashicons-star-filled';
									} else {
										$star_class = 'dashicons-star-empty';
									}
								?>	
								<span class="dashicons <?php echo $star_class; ?>"></span>
							<?php } ?>	
     					 </div>
						</td>	
					</tr>
			
			<?php 
					endwhile; 
				endif; 
			?>
			</tbody>
			</table>
			<nav class="pagination">
            <div class="pager">
                <?php
                               $total_pages = $books_data->max_num_pages;
							   $big = 999999999; // need an unlikely integer
						   
							   if ($total_pages > 1){
								   $current_page = max(1, get_query_var('page'));
						   
								   echo paginate_links(array(
									   'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
									   'format' => '?page=%#%',
									   'current' => $current_page,
									   'total' => $total_pages,
								   ));
							   }
                ?>
            </div>
        </nav>
		<?php
	
		// return the buffer contents and delete
		return ob_get_clean();

	}

	/**
	 * Strip Html Tags 
	 * 
	 * It will sanitize text input (strip html tags, and escape characters)
	 * 
	 * @package Books Store
	 * @since 1.0.0
	 */
	public function book_store_nohtml_kses($data = array()) {
		
		
		if ( is_array($data) ) {
			
			$data = array_map(array($this,'book_store_nohtml_kses'), $data);
			
		} elseif ( is_string( $data ) ) {
			
			$data = wp_filter_nohtml_kses($data);
		}
		
		return $data;
	}	
}
?>