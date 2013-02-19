<?php
/**
 * Template Name: User Order page
 * Description: A Page Template where logged in users can check their orders.
 *
 */

get_header(); ?>

		<div id="primary" class="showcase">
			<div id="content" role="main">
				<div class="page-content-user">
					<?php
					//First lets check if the user is logged in
					if(is_user_logged_in()){
						
						mp_order_status() ;
						
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