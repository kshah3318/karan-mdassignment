<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Scripts Class
 *
 * Handles adding scripts functionality to the admin pages
 * as well as the front pages.
 *
 * @package Books Store
 * @since 1.0.0
 */

class Book_Store_Scripts {

	//class constructor
	function __construct()
	{
		
	}
	
	/**
	 * Enqueue Scripts on Admin Side
	 * 
	 * @package Books Store
	 * @since 1.0.0
	 */
	public function book_store_admin_scripts(){
	
	}
	
	/**
	 * Adding Hooks
	 *
	 * Adding hooks for the styles and scripts.
	 *
	 * @package Books Store
	 * @since 1.0.0
	 */
	function add_hooks(){
		
		//add admin scripts
		add_action('admin_enqueue_scripts', array($this, 'book_store_admin_scripts'));
	}
}
?>