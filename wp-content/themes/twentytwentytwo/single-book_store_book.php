<?php
/* 
 * As I am using default latest wordpress theme - I have added single template file inside this theme only.
 * But according to the wordpress standards single template is to be included after created child theme.
 * For the time being please consider for the same.
*/
get_header();

$prefix = BOOK_STORE_PREFIX;
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
<h4 class="text-left"><?php echo esc_html('Book Details:','bkstore') ?></h4>
<table class="table book-search-records" id="book-search-records">
                    <thead>
                        <tr>
                            <th scope="col"><?php echo esc_html('No','bkstore') ?></th>
                            <th scope="col"><?php echo esc_html('Book Name','bkstore') ?></th>
                            <th scope="col"><?php echo esc_html('Price','bkstore') ?></th>
                            <th scope="col"><?php echo esc_html('Author','bkstore') ?></th>
                            <th scope="col"><?php echo esc_html('Publisher','bkstore') ?></th>
                            <th scope="col"><?php echo esc_html('Rating','bkstore') ?></th>
                        </tr>
                    </thead>
                     <tbody>
                     <tr>
						<th scope="row"><?php echo get_the_ID(); ?></th>
						<td><?php echo get_the_title(); ?></td>
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
                </tbody>
            </table>            
<?php
get_footer();




