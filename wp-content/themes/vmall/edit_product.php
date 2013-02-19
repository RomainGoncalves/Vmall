<?php
/**
 * Template Name: Edit product page
 * Description: A Page Template to edit products by logged in users
 *
 */

get_header(); ?>

		<div id="primary" class="showcase">
			<div id="content" role="main">
				<div class="page-content-user">
					<?php
					//First lets check if the user is logged in
					if(is_user_logged_in()){
						
						//if we're editing
						if(isset($_GET['edit'])){

							$postID = $_GET['edit'] ;
					?>

					<h2 class="page-title logged-in">Edit Product</h2>

					<?php

					//Check if user is post owner
					if(check_user_post($postID, get_current_user_id()) == true){
						
						product_frontend_form_edit($_GET['edit']) ;

					}


						}
						else{
							?>

							<h2 class="page-title"><?php the_title() ; ?></h2>

							<?php
						//Once they're logged in let's display the form
						product_frontend_form() ;

						}
						
					}
					else{
						
						//Otherwise we display the login form
						wp_login_form() ;
					
					}
					?>
					<div class="clear"></div>
				</div>
			</div><!-- #content -->
		</div><!-- #primary -->
<?php get_sidebar() ; ?>
<?php get_footer(); ?>