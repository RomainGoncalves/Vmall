<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?>

	</div><!-- #main -->

	<footer id="footer-links" role="contentinfo">

			<?php
				/* A sidebar in the footer? Yep. You can can customize
				 * your footer with three columns of widgets.
				 */
				if ( ! is_404() )
					get_sidebar( 'footer' );
			?>
		<div id="top-footer">

			<div class="footer-menus">
				<h4>Order Support</h4>
				<?php wp_nav_menu( array( 'theme_location' => 'footer_order', 'container' => 'nav', 'container_id' => 'footer_order' ) ); ?>
			</div>
			<div class="footer-menus">
				<h4>Product Support</h4>
				<?php wp_nav_menu( array( 'theme_location' => 'footer_product', 'container' => 'nav', 'container_id' => 'footer_product' ) ); ?>
			</div>
			<div class="footer-menus">
				<h4>Legal</h4>
				<?php wp_nav_menu( array( 'theme_location' => 'footer_legal', 'container' => 'nav', 'container_id' => 'footer_legal' ) ); ?>
			</div>

		</div>
		<div id="copyright" class="clear">
			<div>
				<span>&copy; Vmall Pty Ltd 2012 &middot; All rights Reserved</span>
				<span class="socials">Follow us: 
					<img src="<?php echo get_template_directory_uri().'/images/fb-icon.png' ; ?>" alt"facebook icon" />
					<img src="<?php echo get_template_directory_uri().'/images/twitter-icon.png' ; ?>" alt"twitter icon" />
				</span>
			</div>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>