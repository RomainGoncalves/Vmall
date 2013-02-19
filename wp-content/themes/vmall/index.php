<?php

get_header(); ?>

	<?php
	##Featured slider
	$query = 'post_type=product&product_category=featured' ;

	$new_query = new WP_Query($query) ;
	
	//Start counter
	$i = 1 ;

	if ( !empty($new_query) ) { ?>
		<div class="slider-wrapper">
		    <div id="slider" class="nivoSlider">

	<?php foreach ($new_query->posts as $post) {
			
			$caption = 'title=#slider-'.$i ;

			if(has_post_thumbnail($post->ID)){
				
				the_post_thumbnail($size = 'homepage-featured', $attr = $caption) ;
			
			}

	$i++ ;

	} ?>
			</div>
		</div>
<?php
	//Reset counter
	$i = 1 ;

	//Now for the caption
	foreach ($new_query->posts as $post) {
			
			$caption = 'slider-'.$i ;
			?>
			
		<div id="<?php echo $caption ; ?>" class="nivo-html-caption">
		    <?php echo $post->post_title ; ?><a href="<?php echo get_permalink($post->ID) ; ?>" title="<?php echo $post->post_title ; ?>" class="learn-more">Details</a>
		</div>

	<?php 

	$i++ ;

	}
	}

	?>
		<div id="primary">
			<div id="content" role="main">
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
			</div><!-- #content -->
		</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>