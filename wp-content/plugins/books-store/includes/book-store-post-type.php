<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

function book_store_register_post_types() {
	
	// Create Custom Post Type For Book
	$labels = array(
				    'name'				=> __('Books', 'bkstore'),
				    'singular_name' 	=> __('Book', 'bkstore'),
				    'add_new' 			=> __('Add New', 'bkstore'),
				    'add_new_item' 		=> __('Add New Book', 'bkstore'),
				    'edit_item' 		=> __('Edit Book', 'bkstore'),
				    'new_item' 			=> __('New Book', 'bkstore'),
				    'all_items' 		=> __('Books', 'bkstore'),
				    'view_item' 		=> __('View Book', 'bkstore'),
				    'search_items' 		=> __('Search Book', 'bkstore'),
				    'not_found' 		=> __('No Books found', 'bkstore'),
				    'not_found_in_trash'=> __('No Books found in Trash', 'bkstore'),
				    'parent_item_colon' => '',
				    'menu_name' => __('Books', 'bkstore'),
				);
	
	$args = array(
			    'labels'				=> $labels,
			    'public'				=> true,
			    'publicly_queryable'	=> true,
			    'show_ui'				=> true, 
			    'show_in_menu'			=> true, 
			    'query_var'				=> true,
			    'rewrite'				=> array( 'slug' => BOOK_STORE_POST_TYPE_BOOK ),
			    'capability_type'		=> 'post',
			    'map_meta_cap'			=> true,
			    'has_archive'			=> true, 
			    'hierarchical'			=> false,
			    'supports'				=> array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )				    
		  );
	
	register_post_type( BOOK_STORE_POST_TYPE_BOOK, $args );
}
add_action( 'init', 'book_store_register_post_types' );