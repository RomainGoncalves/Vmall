<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); ?>

		<div id="primary">
			<div id="content" role="main">
				
				<?php while ( have_posts() ) : the_post(); ?>

					<h2 class="page-title"><?php the_title() ; ?></h2>
					<?php 
					if($wp_query->query_vars['taxonomy'] == '') { ?>

						<div class="page-content"><?php the_content() ; ?></div>

					<?php }
					else{ ?>

					<div class="page-content-category"><?php the_content() ; ?></div>

					<?php }

					?>


				<?php endwhile; // end of the loop. ?>

			</div><!-- #content -->
		</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>