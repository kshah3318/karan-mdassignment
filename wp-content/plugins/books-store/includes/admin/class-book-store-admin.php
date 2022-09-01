<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Admin Class
 *
 * Manage Admin Panel Class
 *
 * @package Books Store
 * @since 1.0.0
 */

class Book_Store_Admin {

	public $model, $scripts;

	//class constructor
	function __construct() {

		global $book_store_model, $book_store_scripts;

		$this->scripts = $book_store_scripts;
		$this->model = $book_store_model;
	}
	/**
	 * Adding Hooks
	 *
	 * @package Books Store
	 * @since 1.0.0
	 */
	function add_hooks(){
	}
}
?>