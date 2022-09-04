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
	 * Enqueue Scripts and Styles on Public Function
	 * 
	 * @package Books Store
	 * @since 1.0.0
	*/

	public function book_store_public_scripts(){

		$localize_scriptArgs = array();
        $localize_scriptArgs['ajaxurl'] = admin_url('admin-ajax.php', ( is_ssl() ? 'https' : 'http'));

		wp_register_style('book-store-public-style', BOOK_STORE_INC_URL . '/css/book-store-public-style.css');
		wp_enqueue_style('book-store-public-style');

		wp_register_style('book-bootstrap-style', BOOK_STORE_INC_URL . '/css/bootstrap.min.css');
		wp_enqueue_style('book-bootstrap-style');

		wp_enqueue_script('book-store-public-script', BOOK_STORE_INC_URL . '/js/book-store-public-script.js',array('jquery'));
		wp_enqueue_script('book-bootstrap-script', BOOK_STORE_INC_URL . '/js/bootstrap.min.js');

		wp_localize_script('book-store-public-script', 'BookStorePublic', $localize_scriptArgs);
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
		add_action('wp_enqueue_scripts', array($this, 'book_store_public_scripts'));
	}
}
?>