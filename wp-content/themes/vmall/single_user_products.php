<?php
/**
 * Template Name: Single User Product Page
 * Description: A Page Template to display products of specific logged in users
 *
 */

get_header(); 

//Test if seller is in the request
if (isset($_GET['seller'])) {
	
	//Checks that it's an integer
	$seller_ID = intval($_GET['seller']) ;

	//Now gets author (seller) infos
	$seller = get_userdata($seller_ID) ;

	//If $seller = false then produce error
	if ($seller == false) {
		
		$error = '<span class="error">This user could not be found.</span><br /><a href="'.home_url($path = '/', $scheme = null).'">View more products</a>' ;


	}
	else{

		//Otherwise we query with the author ID
		//var_dump($seller) ;
		//Query
		$query = 'author='.$seller_ID.'&post_type=product' ;

	}


}

?>

		<div id="primary" class="showcase">
			<div id="content" role="main">
				<h2 class="page-title"><?php the_title() ; ?> <?php echo $seller->user_login ; ?></h2>
				
					<?php
					//First lets check if the user is logged in
					if(!$error){
				
						//Once they're logged in let's display the form
						mp_display_products($query, 'grid') ;
					
					}
					else{
						
						//Otherwise we display the login form
						echo $error ;
					
					}
					?>
					<div class="clear"></div>
				
			</div><!-- #content -->
		</div><!-- #primary -->
<?php get_sidebar() ; ?>
<?php get_footer(); ?>