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
	 * Add Custom Meta Box
	 * 
	 * Handles to add custom meta box
	 * in post and page
	 *
	 * @package Books Store
	 * @since 1.0.0
	 */

	public function book_store_add_custom_fields() {

		add_meta_box( 'book_store_custom_field', esc_html__( 'Book Store Custom Data', 'bkstore' ), array( $this, 'book_store_render_custom_fields' ), BOOK_STORE_POST_TYPE_BOOK, 'advanced', 'high' );

	}

	/**
	 * Add Custom Meta Box
	 * 
	 * Handles to add custom meta box
	 * in bookstore custom plugin
	 *
	 * @package Books Store
	 * @since 1.0.0
	 */

	public function book_store_render_custom_fields( $post ) {

		global $post, $book_store_model;

		$model = $book_store_model;
		$prefix = BOOK_STORE_PREFIX;

		$book_store_custom_price = get_post_meta( $post->ID, $prefix . '_price', true );
		$book_store_custom_rating	= get_post_meta( $post->ID, $prefix . '_rating', true );

		?>

		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row">
						<label for="book_store_price"><strong><?php echo esc_html__( 'Book Price', 'bkstore' ); ?></strong></label>
					</th>
					<td>
						<input type="number" min="1" max="3000" id="book_store_price" class="regular-text" name="<?php echo $prefix ?>_price" value="<?php echo $model->book_store_escape_attr( $book_store_custom_price ); ?>" />
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="book_store_rating"><strong><?php echo esc_html__( 'Book Rating', 'bkstore' ); ?></strong></label>
					</th>
					<td>
						<input type="number" min="1" max="5" id="book_store_rating" class="regular-text" name="<?php echo $prefix ?>_rating" value="<?php echo $model->book_store_escape_attr( $book_store_custom_rating ); ?>" />
					</td>
				</tr>
			</tbody>
		</table>
       <?php
	}

	/**
	 * Add Custom Meta Box
	 * 
	 * Handles to save meta data of plugn
	 * 
	 *
	 * @package Books Store
	 * @since 1.0.0
	 */

	 public function book_store_save_custom_meta( $post_id ){

		global $post_type;
		
		$prefix = BOOK_STORE_PREFIX;
		
		$post_type_object = get_post_type_object( $post_type );
		
		// Check for which post type we need to add the meta box
		$pages = array( BOOK_STORE_POST_TYPE_BOOK );
		
		

		if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )                // Check Autosave
		|| ( ! isset( $_POST['post_ID'] ) || $post_id != $_POST['post_ID'] )        // Check Revision
		|| ( ! in_array( $post_type, $pages ) )              // Check if current post type is supported.
		|| ( ! current_user_can( $post_type_object->cap->edit_post, $post_id ) ) )       // Check permission
		{
		  return $post_id;
		}
		
		// Update Custom Title
		if( isset( $_POST[ $prefix . '_price' ] ) ) {
			
			update_post_meta( $post_id, $prefix . '_price', $_POST[ $prefix . '_price' ] );
		}
		// Update Custom Description
		if( isset( $_POST[ $prefix . '_rating' ] ) ) {
			
			update_post_meta( $post_id, $prefix . '_rating', $_POST[ $prefix . '_rating' ] );
		}	

		$custom_post_title = get_post_meta($post_id, $prefix . '_custom_title',true);
		if( empty( $custom_post_title ) && !empty( $_POST['post_title'] ) ) {

			update_post_meta( $post_id, $prefix . '_custom_title', $_POST['post_title'] );

		}

	 }

	/**
	 * Adding Hooks
	 *
	 * @package Books Store
	 * @since 1.0.0
	 */
	function add_hooks(){
		
		// add action to add custom meta box in post and page
		add_action( 'add_meta_boxes', array( $this, 'book_store_add_custom_fields' ) );

		// add action to save custom meta
		add_action( 'save_post', array( $this, 'book_store_save_custom_meta' ) );
	
	}
}
?>