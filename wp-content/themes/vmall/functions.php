<?php

//Lets enqueue styles and scripts
//Only for front end
if(!is_admin()){

	//Reset
	wp_enqueue_style('css-reset', 'http://yui.yahooapis.com/3.5.0/build/cssreset/cssreset-min.css') ;
  wp_enqueue_style('css-nivo-slider', get_template_directory_uri().'/js/nivo-slider/nivo-slider.css', 'css-style') ;
	//Our stylesheet
  wp_enqueue_style('css-style', get_template_directory_uri().'/style.css', 'css-reset') ;
	wp_enqueue_style('css-bootstrap', get_template_directory_uri().'/css/bootstrap.min.css', 'css-reset') ;
  wp_enqueue_style('css-jqueryui', get_template_directory_uri().'/jquery-ui-theme/jquery-ui-1.8.24.custom.css', 'css-style') ;
  wp_enqueue_script('jquery') ;
  wp_enqueue_script('jquery-ui-core') ;

  wp_enqueue_script('modernizr-custom', get_template_directory_uri().'/js/modernizr.js') ;
  wp_enqueue_script('vmall-custom', get_template_directory_uri().'/js/vmall.js', 'jquery',1.0, true) ;

	wp_enqueue_script( 'jquery-ui-accordion', true );
  wp_enqueue_script( 'jquery-ui-tabs', true );
  wp_enqueue_script( 'jquery-ui-button', true );
  wp_enqueue_script('js-nivo-slider', get_template_directory_uri().'/js/nivo-slider/jquery.nivo.slider.pack.js', true) ;


    wp_enqueue_script('thickbox');
    wp_enqueue_style('thickbox');

    wp_enqueue_script('media-upload');
    wp_enqueue_script('comment-reply');

	include('extends_marketpress.php') ;
}

add_theme_support( 'custom-header' );

include('widget/simple-widget.php') ;
include('function-login.php') ;

add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 200, 200, true);

//For featured images
add_image_size( 'homepage-featured', 960, 300, true );//Automatic crop

add_filter('show_admin_bar', '__return_false');

register_nav_menus( array(
	'main_menu' => 'Main Menu',
	'user_menu' => 'User Menu',
	'top_nav'	=> 'Top Navigation',
	'top_nav_loggedin'	=> 'Top Navigation User',
	'footer_order'	=> 'Footer Order Support',
	'footer_product'	=> 'Footer Product Support',
	'footer_ccards'	=> 'Footer Credit Cards',
	'footer_reward'	=> 'Footer Reward zone program',
	'footer_legal'	=> 'Footer Legal'
) );

function my_search_form( $form ) {

    $form = '<form role="search" method="get" id="searchform2" action="' . home_url( '/' ) . '" >
    <div><label class="screen-reader-text" for="s">' . __('Search for:') . '</label>
    <input type="text" value="' . get_search_query() . '" name="s" id="s" />
    <input type="submit" id="searchsubmit" value="'. esc_attr__('Search') .'" />
    </div>
    </form>';

    return $form;
}

add_filter( 'get_search_form', 'my_search_form' );

register_sidebar(array(
  'name' => __( 'Main Sidebar - Left' ),
  'id' => 'main-left-sidebar',
  'description' => __( 'Widgets in this area will be shown on the left-hand side.' ),
  'before_title' => '<h2>',
  'after_title' => '</h2>'
));
register_sidebar(array(
  'name' => __( 'Shop Cart - Top' ),
  'id' => 'shop-cart-top',
  'description' => __( 'Widgets for the shopping cart.' ),
  'before_title' => '<h2>',
  'after_title' => '</h2>'
));

function mytheme_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    extract($args, EXTR_SKIP);

    if ( 'div' == $args['style'] ) {
      $tag = 'div';
      $add_below = 'comment';
    } else {
      $tag = 'li';
      $add_below = 'div-comment';
    }
?>
    <<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
    <?php if ( 'div' != $args['style'] ) : ?>
    <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
    <?php endif; ?>
    <div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
      <?php
        /* translators: 1: date, 2: time */
        printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','' );
      ?>
    </div>
    <div class="comment-author vcard">
    <?php $args['avatar_size'] = 50  ; ?>
    <?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?>
    <?php printf(__('<cite class="fn">%s</cite> <span class="says">said:</span>'), get_comment_author_link()) ?>
    </div>
<?php if ($comment->comment_approved == '0') : ?>
    <em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>
    
<?php endif; ?>

    <div class="comment-text">
      <?php comment_text() ?>
    </div>
    <div class="reply">
    <?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
    </div>
    <?php if ( 'div' != $args['style'] ) : ?>
    </div>
    <?php endif; ?>
<?php
}