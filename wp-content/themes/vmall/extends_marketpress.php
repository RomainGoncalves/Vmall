<?php
/**
*	Custom functions to add Front end capabilities to Marketpress
*
*/

define('MAX_UPLOAD_SIZE', 2000000);  
define('TYPE_WHITELIST', serialize(array(  
  'image/jpeg',  
  'image/png',  
  'image/gif'  
  )));

register_taxonomy( 'product_category', 'product', apply_filters( 'mp_register_product_category', array("hierarchical" => true, 'label' => __('Product Categories', 'mp'), 'singular_label' => __('Product Category', 'mp'), 'rewrite' => array('slug' => $settings['slugs']['store'] . '/' . $settings['slugs']['products'] . '/' . $settings['slugs']['category'])) ) );
register_taxonomy( 'product_tag', 'product', apply_filters( 'mp_register_product_tag', array("hierarchical" => false, 'label' => __('Product Tags', 'mp'), 'singular_label' => __('Product Tag', 'mp'), 'rewrite' => array('slug' => $settings['slugs']['store'] . '/' . $settings['slugs']['products'] . '/' . $settings['slugs']['tag'])) ) );

function product_frontend_form(){

	echo '<form method="post" action="" id="add_product" enctype="multipart/form-data">
				
				<fieldset class="left">
					
					<label for="title">
					<span class="placeholder" title="Title..."></span>
					<input type="text" name="title" id="title" placeholder="Name of the product..." value="" />
					</label>
					<label for="description" class="block">Description
					<span class="placeholder" title="Description..."></span>' ;

	wp_editor('', $editor_id = 'description', array('textarea_rows' => 5, 'textarea_name' => 'description')) ;
	//<textarea id="description" name="description" placeholder="Description..."></textarea>
	echo 		'</label>
					<div class="labels-container">
						<label for="price">Price ($)</label>
						<label for="sale">Sale Price ($)</label>
						<label for="quantity">Quantity</label>
						<label for="shipping">Shipping ($)</label>
						<label for="pickup">Pick Up Only</label>

					</div>
					<input type="text" name="price[]" id="price" placeholder="Price..." value="" />
					<input type="text" name="sale[]" id="sale" placeholder="Sale price..." value="" />
					<input type="text" name="quantity[]" id="quantity" placeholder="Quantity..." value="" />
					<input type="text" name="shipping" id="shipping" placeholder="Shipping..." value="" />
					<input type="checkbox" name="pickup" id="pickup" value="1" />

					<input type="hidden" name="add" value="1" />
					<label for="details" class="block">Details
					<span class="placeholder" title="Details..."></span>' ;
					wp_editor('', $editor_id = 'details', array('textarea_rows' => 3, 'textarea_name' => 'details')) ;
	echo			'<label for="warranty" class="block">Warranty
					<span class="placeholder" title="Warranty, if applicable......"></span>
					' ;
					wp_editor('', $editor_id = 'warranty', array('textarea_rows' => 3, 'textarea_name' => 'warranty')) ;
				
	echo	'</fieldset>
				
				<fieldset class="right">
					<label for="product_categories" class="label-category">Category</label>' ;
				
	echo 		checkbox_product_categories(array('')) ;
	/*echo '		<label for="tags" class="label-tags">Tags</label>
			<div class="label-tags"><input type="text" name="tags" id="tags" placeholder="Separate tags with a comma." />
			</div>' ;*/

 	echo wp_nonce_field('add_product', 'add_product_submitted');  
 	echo '<label for="product_image_file" class="label-image">Image</label>';    
 	echo '<div class="label-image">
 		<input type="file" size="14" name="product_image_file" id="product_image_file" />
 		</div>
 		<button class="add-product">Add Product</button>';
	echo '</fieldset></form>' ;

	//echo $html ;
}

function product_frontend_form_edit($postID){

	$post = get_post($postID, $output = OBJECT, $filter = 'raw') ;
	$postmeta = get_post_meta($postID) ;
	//unserialize
	foreach ($postmeta as $key => $val) {
		$meta[$key] = maybe_unserialize($val[0]);
		if (!is_array($meta[$key]) && $key != "mp_is_sale" && $key != "mp_track_inventory" && $key != "mp_product_link" && $key != "mp_file" && $key != "mp_price_sort")
		  $meta[$key] = array($meta[$key]);
	}
	
	$categories = wp_get_object_terms($postID, 'product_category') ;

	echo '<form method="post" action="" id="add_product" enctype="multipart/form-data">
				
				<fieldset class="left">
					
					<label for="title">
					<span class="placeholder" title="Title..."></span>
					<input type="text" name="title" id="title" placeholder="Name of the product..." value="'.$post->post_title.'" />
					</label>
					<label for="description" class="block">Description
					<span class="placeholder" title="Description..."></span>' ;

	wp_editor($post->post_content, $editor_id = 'description', array('textarea_rows' => 5)) ;
	//<textarea id="description" name="description" placeholder="Description..."></textarea>
	echo 		'</label>
					<div class="labels-container">
						<label for="price">Price ($)</label>
						<label for="sale">Sale Price ($)</label>
						<label for="quantity">Quantity</label>
						<label for="shipping">Shipping ($)</label>
						<label for="pickup">Pick Up Only</label>

					</div>
					<input type="text" name="price[]" id="price" placeholder="Price..." value="'.$meta["mp_price"][0].'" />
					<input type="text" name="sale[]" id="sale" placeholder="Sale price..." value="'.$meta["mp_sale_price"][0].'" />
					<input type="text" name="quantity[]" id="quantity" placeholder="Quantity..." value="'.$meta["mp_inventory"][0].'" />
					' ;

					//check if pickup is set
					if($meta["mp_shipping"]["extra_cost"] == 'Pickup Only'){

	echo			'<input type="text" name="shipping" id="shipping" placeholder="Shipping..." value="'.$meta["mp_shipping"][0].'" disabled="disabled" />
					<input type="checkbox" name="pickup" id="pickup" value="1" checked="checked" />' ;

					}
					else{

	echo			'<input type="text" name="shipping" id="shipping" placeholder="Shipping..." value="'.$meta["mp_shipping"][0].'" />
					<input type="checkbox" name="pickup" id="pickup" value="1" />' ;

					}
	echo 			'<input type="hidden" name="update" value="1" />
					<label for="details" class="block">Details
					<span class="placeholder" title="Details..."></span>' ;
					wp_editor($meta["mp_details"][0], $editor_id = 'details', array('textarea_rows' => 3)) ;
	echo			'<label for="warranty" class="block">Warranty
					<span class="placeholder" title="Warranty, if applicable......"></span>
					' ;
					wp_editor($meta["mp_warranty"][0], $editor_id = 'warranty', array('textarea_rows' => 3)) ;
				
	echo	'</fieldset>
				
				<fieldset class="right">
					<label for="product_categories" class="label-category">Category</label>' ;
				
	echo 		checkbox_product_categories($categories) ;
	/*echo '		<label for="tags" class="label-tags">Tags</label>
			<div class="label-tags"><input type="text" name="tags" id="tags" placeholder="Separate tags with a comma." />
			</div>' ;*/

 	echo wp_nonce_field('edit_product', 'add_product_submitted');

 	$html .= '<label for="product_image_file" class="label-image">Image</label>';    
 	$html .= '<div class="label-image">' ;

 	if(has_post_thumbnail($postID)){

 		$html .= get_the_post_thumbnail($postID) ;

 	}
 	$html .= '<input type="file" size="60" name="product_image_file" id="product_image_file" />
 		</div>
 		<button class="edit-product">Edit Product</button>';
	$html .= '</fieldset></form>' ;
	echo $html ;

}
//Function that retrieves product categories and display them with an associated checkbox
function checkbox_product_categories($cat_object = ''){

	//Get product categories
			$args = array(
			'type'                     => 'post',
			'child_of'                 => 0,
			'parent'                   => '',
			'orderby'                  => 'term_group',
			'order'                    => 'desc',
			'hide_empty'               => 0,
			'hierarchical'             => 1,
			'exclude'                  => 40,
			'include'                  => '',
			'number'                   => '',
			'taxonomy'                 => 'product_category',
			'pad_counts'               => false );
			
			$categories = get_categories( $args ) ;
			$list_cat = '<ol id="product_categories">' ;
			//var_dump($categories) ;
			foreach($categories as $category){
			
				//If category is child
				if(!empty($category->parent)){
				
					$class = 'child' ;
					
				}
				else{
				
					$class = 'parent' ;
					
				}
				
				$list_cat .= '<li class="'.$class.'">
					<input type="checkbox" id="'.$category->category_nicename.'" name="categories[]"' ;

				foreach ($cat_object as $argument) {
					if($argument->term_id ==  $category->term_id){

						$list_cat .= ' checked="checked"' ;

					}
				}

				$list_cat .= ' value="'.$category->term_id.'" />
					<label for="'.$category->category_nicename.'">'.$category->name.'</label>
					</li>' ;
			
			}
			$list_cat .= '</ol>' ;
			
			return $list_cat ;

}
function add_product_process_image($file, $post_id){  
   
  require_once(ABSPATH . "wp-admin" . '/includes/image.php');  
  require_once(ABSPATH . "wp-admin" . '/includes/file.php');  
  require_once(ABSPATH . "wp-admin" . '/includes/media.php');  
   
  $attachment_id = media_handle_upload($file, $post_id);  
   
  update_post_meta($post_id, '_thumbnail_id', $attachment_id);  
  
  $attachment_data = array(  
    'ID' => $attachment_id
  );  
    
  wp_update_post($attachment_data);  
  
  return $attachment_id;  
  
}
function sui_parse_file_errors($file = ''){  
  /*, $image_caption*/
  $result = array();  
  $result['error'] = 0;  
    
  if($file['error']){  
    
    $result['error'] = "No file uploaded or there was an upload error!";  
      
    return $result;  
    
  } 
  $image_data = getimagesize($file['tmp_name']);  
    
  if(!in_array($image_data['mime'], unserialize(TYPE_WHITELIST))){  
    
    $result['error'] = 'Your image must be a jpeg, png or gif!';  
      
  }elseif(($file['size'] > MAX_UPLOAD_SIZE)){  
    
    $result['error'] = 'Your image was ' . $file['size'] . ' bytes! It must not exceed ' . MAX_UPLOAD_SIZE . ' bytes.';  
      
  }  
      
  return $result;  
  
}  

/**
 * Custom function to retrieve total amount in cart
 *
 */
function mp_total_cart_amount(){

	global $mp ;
	
	$cart = $mp->get_cart_contents(true);
	
	foreach ($cart as $product_id => $variations) {
        foreach ($variations as $variation => $data) {
			
			$totals[] = $data[0]['price'] * $data[0]['quantity'];
	
		}
	}
	
	if(!empty($totals)){
		return "$".array_sum($totals) ;
	}
}

/**
 * Custom function to retrieve products from 1 user
 *
 */
function mp_user_products(){

	//First let's make sure the user is logged
	if(is_user_logged_in()){

		//Variables
		$userID = get_current_user_id() ;

		//Query
		$query = 'author='.$userID.'&post_type=product' ;

		if(have_posts()){

			//If we receive an ID to edit 1 product
			if (isset($_GET['edit'])) {

				$id = intval($_GET['edit']) ;

				product_frontend_form_edit($id) ;

			}else{

			mp_display_products_list($query, true) ;
			}
		}
		else{

			echo "no post" ;
		}

	}
	else{

		echo "You aren't looged in. Please log in." ;

	}

}

function mp_test_query($query = ''){ 

	$new_query = new WP_Query($query) ;

	if($new_query->posts[0] != ''){

		return true ;

	}
	else{
		return false ;
	}

}
function mp_display_products($query = '', $display){ 

	//$new_query_wp = new WP_Query($query) ;
	$new_query = query_posts($query) ;

//var_dump($new_query_WP) ;
//var_dump($new_query) ;

	wp_simple_pagination(array('base' => 'store/products'));	

	$i = 1 ;

	if($display == 'row'){
		echo '<table summary="Display featured products in rows" id="products-list">' ;
	}

	if ( $new_query != '' ) : ?>

		<?php /* Start the Loop */ ?>
		<?php foreach ($new_query as $post) {
		
				$sale_price = get_post_meta($post->ID, 'mp_sale_price', true) ;
				$sale_price = $sale_price[0] ;
				$price = get_post_meta($post->ID, 'mp_price', true) ;
				
				//Determines end_price
				if($sale_price == 0){

					//End price is normal price
					$end_price = '$'.$price[0] ;

				}
				else{

					//Or end price is  sale price
					$end_price = '$'.$sale_price ;
				}
				//If theres a sale price
				if($sale_price != 0){
					
					//We display
					$price = 'RRP: <span class="price">$'.$price[0].'</span>' ;
					
				}
				else{

					//Or we don't
					$price = "" ;
				}
			?>
			<?php //We display each product

			//Let's shorten the title string
			$title = $post->post_title ;
			$string_size = 25 ;

			//Test if string is longer that string_size
			if(strlen($title) > $string_size){

				$title = substr($title, 0, $string_size).'...' ;

			}

			//Check if we need a grid of a row display
			if($display == 'grid'){

	//Inventory
	$inventory = get_post_meta($post->ID, 'mp_inventory', true) ;

			?>
		<article class="post-<?php echo $post->ID ; ?> product post-product-<?php echo $i ; ?>">
			<h2><a href="<?php echo get_permalink( $post->ID ) ; ?>" title="View product: <?php echo $post->post_title ; ?>"><?php echo $title ; ?></a></h2>
			
			<?php //Test if there is a thumbnail
			if(has_post_thumbnail($post->ID)){
				
				echo '<div class="image_product">' ;
				mp_product_image( $echo = true, $context = 'list', $post->ID, $size = 200 ) ;
				echo '</div><!--end thumbnail-->' ;
			
			}
			else{
			
				echo '<div class="image_product">
				<img src="'.get_template_directory_uri().'/images/default-product.png" alt="Default image for product" />
				</div>' ;
			
			}
			?>
			<div class="product-details">
			
				<span class="product-old-price"><?php echo $price ; ?></span>
				<span class="product-detail-link"><a href="<?php echo get_permalink($post->ID) ; ?>">Details</a></span>
				<span class="product-price"><?php echo $end_price ; ?></span>
			<?php

			//If inventory isn't empty
			if(!empty($inventory)){
				mp_buy_button( $echo = true, $context = 'list', $post_id = $post->ID ) ; 
			}

				?>
			</div>	
		</article>
			
			<?php 

			}//end grid display
			//Start row
			else{

				echo '<tr>

					<td>' ;
					if(has_post_thumbnail($post->ID)){
				
						echo '<div class="image_product">' ;
						mp_product_image( $echo = true, $context = 'list', $post->ID, $size = 88 ) ;
						echo '</div><!--end thumbnail-->' ;
					
					}
					else{
					
						echo '<div class="image_product">
						<img src="'.get_template_directory_uri().'/images/default-product.png" alt="Default image for product" />
						</div>' ;
					
					}

				echo '</td>
					<td class="title"><h2><a href="'.get_permalink( $post->ID ).'" title="View product: '.$post->post_title.'">'.$post->post_title.'</a></h2>
					<span class="product-detail-link"><a href="'.get_permalink( $post->ID ).'">Details</a></span></td>
					<td>Customer Rating:' ;
					if(function_exists('kk_star_ratings')) : echo kk_star_ratings($post->ID); endif;

				$comments_count = wp_count_comments( $post->ID );

				echo '<span class="reviews">Reviews ('.$comments_count->approved.')</span></td>
					<td class="price"><span class="product-price">'.$end_price.'</span>';
					mp_buy_button( $echo = true, $context = 'list', $post_id = $post->ID ) ;
				echo '</td></tr>' ;

			}


			$i++ ;
			
			if($i == 4){ $i = 1 ; }
			
			?>	
		<?php } 
			if($display == 'row'){
			echo '</table>' ;
		}
		?>
	<?php else : ?>
	<?php endif; ?>

	<div class="clear index-space"></div>
	<?php
	wp_simple_pagination(array('base' => 'store/products'));
}
function mp_display_products_list($query, $admin){//For Edit Product page
			
	query_posts( $query );
	$i = 1 ;
	
	?>
	<?php if ( have_posts() ) : ?>

		<table summary="User products table" id="user_product">
			<thead>
				<tr>
					<td>Thumb</td><td>Title</td><td>Price</td><td>Sale Price</td><td>Quantity</td><td>Edit</td><td>Delete</td>
				</tr>
			</thead>
			<tbody>
		<?php /* Start the Loop */ ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<?php
				$sale_price = get_post_meta(get_the_ID(), 'mp_sale_price', true) ;
				$sale_price = $sale_price[0] ;
				$price = get_post_meta(get_the_ID(), 'mp_price', true) ;
				$quantity = get_post_meta(get_the_ID(), $key = 'mp_inventory', $single = false) ;
				
				//Determines end_price
				if($sale_price == 0){

					//End price is normal price
					$end_price = '$'.$price[0] ;

				}
				else{

					//Or end price is  sale price
					$end_price = '$'.$sale_price ;
				}
				//If theres a sale price
				if($sale_price != 0){
					
					//We display
					$price = '$'.$price[0] ;
					
				}
				else{

					//Or we don't
					$price = "" ;
				}
			?>
			<?php //We display each product ?>

				<tr>

					<td>
						<?php //Test if there is a thumbnail
						if(has_post_thumbnail()){
							
							echo '<div class="image_product">' ;
							the_post_thumbnail() ;
							echo '</div><!--end thumbnail-->' ;
						
						}
						else{
						
							echo '<div class="image_product">
							<img src="'.get_template_directory_uri().'/images/default-product.png" alt="Default image for product" />
							</div>' ;
						
						}?>
					</td>
					<td><?php the_title() ; ?></td>
					<td><?php echo $price ; ?></td>
					<td><?php echo $end_price ; ?></td>
					<td><?php echo $quantity[0][0] ; ?></td>
					<td><a href="../edit-product/?edit=<?php the_ID() ; ?>">Edit</a></td>
					<td><a href="./?del=<?php the_ID() ; ?>" class="delete-product">Delete</a></td>


				</tr>

			
		<?php endwhile; ?>
	
			</tbody>

		</table>
	<?php else : ?>
	<?php endif;
}

if(isset($_POST['add'])){
	addProduct() ;
}
function addProduct() {
  	//var_dump($_POST) ;
    $title = $_POST['title'];
    $content = nl2br($_POST['description']) ;
    $categories = $_POST['categories'] ;
    $tags = $_POST['tags'] ;

	$post = array(
	  'post_author' => get_current_user_id(), //The user ID number of the author.
	  'post_content' => $content, //The full text of the post.
	  'post_status' => 'publish', //Set the status of the new post. 
	  'post_title' => $title, //The title of your post.
	  'post_type' => 'product', //You may want to insert a regular post, page, link, a menu item or some custom post type
	  'tags_input' => $tags //For tags.
	);

    $new_id = wp_insert_post( $post );

    //For Categories
	$terms = wp_set_post_terms($new_id, $categories, 'product_category', true);

    //price function
    /**/$func_curr = '$price = round(preg_replace("/[^0-9.]/", "", $price), 2);return ($price) ? $price : 0;';

  	//Customs
  	if(isset($_POST['price']) && !empty($_POST['price'])){
   		update_post_meta($new_id, 'mp_price', array_map(create_function('$price', $func_curr), $_POST['price'])); //add price
	}
	if(isset($_POST['sale']) && !empty($_POST['sale'])){

		update_post_meta($new_id, 'mp_is_sale', isset($_POST['sale']) ? 1 : 0);
	    update_post_meta($new_id, 'mp_sale_price', array_map(create_function('$price', $func_curr), $_POST['sale'])); //add sale price
	}
	if(isset($_POST['shipping']) && !empty($_POST['shipping'])){
	    update_post_meta($new_id, 'mp_shipping', array('extra_cost' => $_POST['shipping'])); //add shipping
	}
	if(isset($_POST['pickup']) && !empty($_POST['pickup'])){
	    update_post_meta($new_id, 'mp_shipping', array('extra_cost' => 'Pickup Only')); //add shipping
	}
	if(isset($_POST['quantity']) && !empty($_POST['quantity'])){
		update_post_meta($new_id, 'mp_track_inventory', isset($_POST['quantity']) ? 1 : 0);
	    update_post_meta($new_id, 'mp_inventory', array_map(create_function('$price', $func_curr), $_POST['quantity'])); //add quantity
    }
    if(isset($_POST['warranty']) && !empty($_POST['warranty'])){
    	update_post_meta($new_id, 'mp_warranty', nl2br($_POST['warranty'])) ;
	}
    if(isset($_POST['details']) && !empty($_POST['details'])){
    	update_post_meta($new_id, 'mp_details', nl2br($_POST['details'])) ;
	}

   //Adding image
   if(isset($_POST['add_product_submitted'] ) && wp_verify_nonce($_POST['add_product_submitted'], 'add_product')){
	  $result = sui_parse_file_errors($_FILES['product_image_file']/*, $_POST['sui_image_caption']*/);  

	  if($result['error']){  
	    
	    echo '<p>ERROR: ' . $result['error'] . '</p>';  
	    
	  }else{  
	  
	    $user_image_data = array(  
	      'post_title' => $title,  
	      'post_status' => 'published',  
	      'post_author' => $current_user->ID,  
	      'post_type' => 'attachment'       
	    );  
	      
	    if($new_id){  
	      
	      add_product_process_image('product_image_file', $new_id);
	      
	    }  
	  }  
	}

   //Redirect
   wp_redirect(get_permalink($new_id), $status = 302) ;
   exit() ;
}

if(isset($_GET['edit']) && isset($_POST['update']) && ($_POST['update'] == 1)){

	
	//Let's organize the date
	$update_post['ID'] = $_GET['edit'] ;
	$update_post['post_title'] = $_POST['title'] ;
	$update_post['post_content'] = nl2br($_POST['description']) ;
	$update_post['categories'] = $_POST['categories'] ;

	$updated_id = wp_update_post( $update_post );

	$update_post_meta['mp_price'] = $_POST['price'] ;
	$update_post_meta['mp_inventory'] = $_POST['quantity'] ;
	$update_post_meta['mp_sale_price'] = $_POST['sale'] ;

	
	//Update categories
	$terms = wp_set_post_terms($updated_id, $update_post['categories'], 'product_category', false);//false overwrites all previous categories

	//price function
    /**/$func_curr = '$price = round(preg_replace("/[^0-9.]/", "", $price), 2);return ($price) ? $price : 0;';

  	//Customs
  	if(isset($_POST['price']) && !empty($_POST['price'])){
   		update_post_meta($update_post['ID'], 'mp_price', array_map(create_function('$price', $func_curr), $_POST['price'])); //add price
	}
	if(isset($_POST['sale']) && !empty($_POST['sale'])){

		update_post_meta($update_post['ID'], 'mp_is_sale', isset($_POST['sale']) ? 1 : 0);
	    update_post_meta($update_post['ID'], 'mp_sale_price', array_map(create_function('$price', $func_curr), $_POST['sale'])); //add sale price
	}
	if(isset($_POST['shipping']) && !empty($_POST['shipping'])){
	    update_post_meta($update_post['ID'], 'mp_shipping', array('extra_cost' => $_POST['shipping'])); //add shipping
	}
	if(isset($_POST['pickup']) && !empty($_POST['pickup'])){
	    update_post_meta($update_post['ID'], 'mp_shipping', array('extra_cost' => 'Pickup Only')); //add shipping
	}
	if(isset($_POST['quantity']) && !empty($_POST['quantity'])){
		update_post_meta($update_post['ID'], 'mp_track_inventory', isset($_POST['quantity']) ? 1 : 0);
	    update_post_meta($update_post['ID'], 'mp_inventory', array_map(create_function('$price', $func_curr), $_POST['quantity'])); //add quantity
    }
    if(isset($_POST['warranty']) && !empty($_POST['warranty'])){
    	update_post_meta($update_post['ID'], 'mp_warranty', nl2br($_POST['warranty'])) ;
	}
    if(isset($_POST['details']) && !empty($_POST['details'])){
    	update_post_meta($update_post['ID'], 'mp_details', nl2br($_POST['details'])) ;
	}

	//Redirect
  	wp_redirect(get_permalink($updated_id), $status = 302) ;
  	exit() ;

}
if(isset($_GET['del'])){

	//Check if user is logged
	if(is_user_logged_in()){

		//Variables
		$postID = $_GET['del'] ;
		$userID = get_current_user_id() ;

		//Test if values are the same
		if(check_user_post($postID, $userID) == true){

			wp_delete_post($postid = $postID, $force_delete = false) ;

			//redirect
			wp_redirect(get_page_link($id = 311, $leavename = false, $sample = false), $status = 302) ;

		}
		else{

			echo "You're not the creator of this product." ;
		}

	}

}

/** Function to check if current user is post owner**/
function check_user_post($postID, $userID) {

	//Check if user is logged
	if(is_user_logged_in()){

		//Variables
		$postAuthor = get_postdata($postID) ;

		//Test if values are the same
		if($userID == $postAuthor['Author_ID']){

			return true ;

		}
		else{

			return false ;
		}

	}
}