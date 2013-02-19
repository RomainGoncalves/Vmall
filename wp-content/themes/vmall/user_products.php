<?php
/**
 * Template Name: User Product Page
 * Description: A Page Template to display products of specific logged in users
 *
 */

get_header(); ?>

		<div id="primary" class="showcase">
			<div id="content" role="main">
				<div class="page-content-user">
				<h2 class="page-title"><?php the_title() ; ?></h2>
					<?php
					//First lets check if the user is logged in
					if(is_user_logged_in()){
				
						//Once they're logged in let's display the form
						mp_user_products() ;
					
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