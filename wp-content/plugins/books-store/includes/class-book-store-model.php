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