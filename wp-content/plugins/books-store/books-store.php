<?php
/*
Plugin Name: Books Store
Plugin URI: http://multidots.com/
Description: Practical Assignment - Book Store with Advance search and Feature functionality
Version: 1.0.0
Author: Karan Shah
Author URI: http://multidots.com/
*/

/**
 * Basic plugin definitions 
 * 
 * @package Books Store
 * @since 1.0.0
 */
if( !defined( 'BOOK_STORE_DIR' ) ) {
  define( 'BOOK_STORE_DIR', dirname( __FILE__ ) );      // Plugin dir
}
if( !defined( 'BOOK_STORE_VERSION' ) ) {
  define( 'BOOK_STORE_VERSION', '1.0.0' );      // Plugin Version
}
if( !defined( 'BOOK_STORE_URL' ) ) {
  define( 'BOOK_STORE_URL', plugin_dir_url( __FILE__ ) );   // Plugin url
}
if( !defined( 'BOOK_STORE_INC_DIR' ) ) {
  define( 'BOOK_STORE_INC_DIR', BOOK_STORE_DIR.'/includes' );   // Plugin include dir
}
if( !defined( 'BOOK_STORE_INC_URL' ) ) {
  define( 'BOOK_STORE_INC_URL', BOOK_STORE_URL.'includes' );    // Plugin include url
}
if( !defined( 'BOOK_STORE_ADMIN_DIR' ) ) {
  define( 'BOOK_STORE_ADMIN_DIR', BOOK_STORE_INC_DIR.'/admin' );  // Plugin admin dir
}
if(!defined('BOOK_STORE_PREFIX')) {
  define('BOOK_STORE_PREFIX', 'book_store'); // Plugin Prefix
}
if(!defined('BOOK_STORE_VAR_PREFIX')) {
  define('BOOK_STORE_VAR_PREFIX', '_book_store_'); // Variable Prefix
}
if(!defined('BOOK_STORE_POST_TYPE_BOOK')) {
	define('BOOK_STORE_POST_TYPE_BOOK', 'book_store_book'); // Post Type for Book
}

/**
 * Load Text Domain
 *
 * This gets the plugin ready for translation.
 *
 * @package Books Store
 * @since 1.0.0
 */
load_plugin_textdomain( 'bkstore', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

/**
 * Activation Hook
 *
 * Register plugin activation hook.
 *
 * @package Books Store
 * @since 1.0.0
 */
register_activation_hook( __FILE__, 'book_store_install' );

function book_store_install(){
	
}

/**
 * Deactivation Hook
 *
 * Register plugin deactivation hook.
 *
 * @package Books Store
 * @since 1.0.0
 */
register_deactivation_hook( __FILE__, 'book_store_uninstall');

function book_store_uninstall(){
  
}

// Global variables
global $book_store_scripts, $book_store_model, $book_store_admin;

// Script class handles most of script functionalities of plugin
include_once( BOOK_STORE_INC_DIR.'/class-book-store-scripts.php' );
$book_store_scripts = new Book_Store_Scripts();
$book_store_scripts->add_hooks();

// Model class handles most of model functionalities of plugin
include_once( BOOK_STORE_INC_DIR.'/class-book-store-model.php' );
$book_store_model = new Book_Store_Model();

// Admin class handles most of admin panel functionalities of plugin
include_once( BOOK_STORE_ADMIN_DIR.'/class-book-store-admin.php' );
$book_store_admin = new Book_Store_Admin();
$book_store_admin->add_hooks();

// Registring Post type functionality
require_once( BOOK_STORE_INC_DIR.'/book-store-post-type.php' );
?>