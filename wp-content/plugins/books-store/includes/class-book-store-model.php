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
	 * BootStrap Search - Shortcode 
	 * 
	 * Custom code to implement shortcode for Book Search functionality on front-end.
	 * 
	 * @package Books Store
	 * @since 1.0.0
	 */

	public function book_search_html(){

		ob_start();

		$available_ratings = array(1,2,3,4,5);
		$available_authors = get_terms( array(
			'taxonomy' => 'author',
			'hide_empty' => true,
		) );
		$available_publisher = get_terms( array(
			'taxonomy' => 'publisher',
			'hide_empty' => true,
		) );
	
		?>
			<form id="book-search-form" name="book-search-form" class="row g-3">
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
					<span class="font-weight-bold purple-text ml-2 mt-1">3000</span>		
				</div>
				<div class="col-12 text-center">
					<button type="submit" class="btn btn-primary book-search"><?php echo esc_html('Search...','bkstore') ?></button>
				</div>
			</form>
			<table  class="table book-search-records" id="book-search-records">
			<thead>
				<tr>
					<th scope="col">No</th>
					<th scope="col">Book Name</th>
					<th scope="col">Price</th>
					<th scope="col">Author</th>
					<th scope="col">Publisher</th>
					<th scope="col">Rating</th>
				</tr>
			</thead>
			<tbody>
				<tr>
				<th scope="row">1</th>
				<td>Mark</td>
				<td>Otto</td>
				<td>@mdo</td>
				<td>@mdo</td>
				<td>@mdo</td>
				</tr>
				<tr>
				<th scope="row">2</th>
				<td>Jacob</td>
				<td>Thornton</td>
				<td>@fat</td>
				<td>@fat</td>
				<td>@fat</td>
				</tr>
				<tr>
				<th scope="row">3</th>
				<td colspan="2">Larry the Bird</td>
				<td>@twitter</td>
				<td>@twitter</td>
				<td>@twitter</td>
				</tr>
			</tbody>
			</table>
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