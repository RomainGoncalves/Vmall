<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?><!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";
	
	?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php
	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>
</head>

<body <?php body_class(); ?>>
	<header id="branding" role="banner">
		<div class="top-banner-wrap1">
		<div class="top-banner-wrap2">
			<hgroup id="top-banner-login">
				<?php /*global $current_user ; 

				//If user is logged in
				if(is_user_logged_in()){

					$user_name = $current_user->display_name ;

				}
				else{

					$user_name = "Anonymous" ;

				}
*/
				 ?>
				<!--<span class="login-message">Good morning <?php //echo $user_name ; ?>.</span>-->
				<img src="<?php echo get_template_directory_uri() ; ?>/images/support-local-business.png" alt="supporting local businesses" />
				<?php
				
				$defaults = array(  
					'theme_location'  => 'top_nav_loggedin',
					'container'       => 'nav',
					'container_id'         => 'top_nav'
				);
				
				if ( is_user_logged_in() ) {    
				   wp_nav_menu( $defaults ); //sign in
			  } else { 
				   wp_nav_menu( array( 'theme_location' => 'top_nav', 'container' => 'nav', 'container_id' => 'top_nav' ) ); //sign out
			   } ?>
			</hgroup>
		</div>
		</div>
			<h1 id="site-title">
				<span><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
				<?php bloginfo( 'name' ); ?></a></span>
			</h1>
			<h2 id="site-description"><?php bloginfo( 'description' ); ?></h2>
			
			<hgroup id="logo-block">
				<a href="<?php echo esc_url(home_url( '/')) ; ?>" title="<?php bloginfo('description') ; ?>">
					<img src="<?php header_image(); ?>" alt="vmall logo" />
				</a>
				<div class="shopping_cart">
					<?php echo mp_cart_link($echo = true, $url = false, $link_text = 'View Cart') ; ?>
					<h2>Shopping Cart</h2>
					<span class="cart-summary">Total: <?php echo mp_cart_link($echo = true, $url = false, $link_text = mp_items_count_in_cart().' item') ; ?> 
					Amount: <span class="cart-amount"><?php echo mp_total_cart_amount() ; ?></span></span>
					
				
				</div>
			
			</hgroup>
			
		<?php wp_nav_menu( array( 'theme_location' => 'main_menu', 'menu_id' => 'main_menu_list', 'container' => 'nav', 'container_id' => 'header_bottom' ) ); ?>
		<div id="search-block">
			<?php get_search_form(); ?>
		</div>
	</header><!-- #branding -->
<div id="page" class="hfeed">

	<div id="main">
	