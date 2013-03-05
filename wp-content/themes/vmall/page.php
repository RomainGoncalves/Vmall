<?php

get_header(); ?>

	<?php

	######################

	# If the variable paged is called we display products only without the slider

	######################
	?>
		<div id="primary">
			<div id="content" role="main">

				<?php

				//Test for the presence of the variable
				if(get_query_var('paged') && !($wp_query->query_vars['taxonomy'])){

				?>
				<h2 class="page-title">Featured Products <!--<span class="view">View as: 

					<a href="<?php echo home_url($path = '?view=grid', $scheme = null) ?>"><img src="<?php echo get_template_directory_uri() ?>/images/list-type-block.png" alt="list by block" /></a>
					<a href="<?php echo home_url($path = '?view=row', $scheme = null) ?>"><img src="<?php echo get_template_directory_uri() ?>/images/list-type-row.png" alt="list by row" /></a>

				</span>-->
				</h2>
				
				<?php if(isset($_GET['view'])){

						if($_GET['view'] == 'row'){

								$display = 'row' ;

						}
						if($_GET['view'] == 'grid'){

								$display = 'grid' ;
								
						}
				}
				else{

					$display = 'grid' ;
				}
				
				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
				mp_display_products(array('post_type' => 'product', 'paged' => $paged), $display) ; ?>

				<div class="clear index-space"></div>

				<?php

				}//end if paged


				//now if it's a normal page
				else{ ?>

						<h2 class="page-title"><?php the_title() ; ?></h2>
						<?php 
						if($wp_query->query_vars['taxonomy'] == '') {
					while ( have_posts() ) : the_post(); ?>

							<div class="page-content"><?php the_content() ; ?></div>

						<?php 
							endwhile; // end of the loop
						}
						else{ ?>

						<div class="page-content-category">
							
							<?php if(isset($_GET['view'])){

							if($_GET['view'] == 'row'){

									$display = 'row' ;

							}
							if($_GET['view'] == 'grid'){

									$display = 'grid' ;
									
							}
							}
							else{

								$display = 'grid' ;
							}
							
							$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
							mp_display_products(array('post_type' => 'product', 'product_category' => $wp_query->query_vars['product_category'], 'paged' => $paged), $display) ; ?>

							<div class="clear index-space"></div>

						</div>

								<?php }

							
						}//end else
						?>
			</div><!-- #content -->
		</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>