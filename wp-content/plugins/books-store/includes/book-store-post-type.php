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

	$author_labels = array(
		'name'				=> __('Authors', 'bkstore'),
		'singular_name' 	=> __('Author', 'bkstore'),
		'add_new' 			=> __('Add New', 'bkstore'),
		'add_new_item' 		=> __('Add New Author', 'bkstore'),
		'edit_item' 		=> __('Edit Author', 'bkstore'),
		'new_item' 			=> __('New Author', 'bkstore'),
		'all_items' 		=> __('Authors', 'bkstore'),
		'view_item' 		=> __('View Author', 'bkstore'),
		'search_items' 		=> __('Search Author', 'bkstore'),
		'not_found' 		=> __('No Authors found', 'bkstore'),
		'not_found_in_trash'=> __('No Authors found in Trash', 'bkstore'),
		'parent_item_colon' => '',
		'menu_name' => __('Authors', 'bkstore'),
	);	  

	$publisher_labels = array(
		'name'				=> __('Publishers', 'bkstore'),
		'singular_name' 	=> __('Publisher', 'bkstore'),
		'add_new' 			=> __('Add New', 'bkstore'),
		'add_new_item' 		=> __('Add New Publisher', 'bkstore'),
		'edit_item' 		=> __('Edit Publisher', 'bkstore'),
		'new_item' 			=> __('New Publisher', 'bkstore'),
		'all_items' 		=> __('Publishers', 'bkstore'),
		'view_item' 		=> __('View Publisher', 'bkstore'),
		'search_items' 		=> __('Search Publisher', 'bkstore'),
		'not_found' 		=> __('No Publishers found', 'bkstore'),
		'not_found_in_trash'=> __('No Publishers found in Trash', 'bkstore'),
		'parent_item_colon' => '',
		'menu_name' => __('Publishers', 'bkstore'),
	);	  


	// Custom code to register Publisher and Author Taxonomies.
	register_taxonomy( 'author', BOOK_STORE_POST_TYPE_BOOK, array(

		"labels" 			=> $author_labels,
		"singular_label" 	=> "Author",
		'hierarchical'      => false,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'author' ),
        'show_in_rest'      => true,
	));	  

	//Publisher Taxonomy
	register_taxonomy( 'publisher', BOOK_STORE_POST_TYPE_BOOK, array(

		"labels" 			=> $publisher_labels,
		"singular_label" 	=> "Publisher",
		'hierarchical'      => false,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'publisher' ),
        'show_in_rest'      => true,
	));

}
add_action( 'init', 'book_store_register_post_types' );