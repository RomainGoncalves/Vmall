<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
/*Preserves Search Function
*
*http://codex.wordpress.org/Creating_a_Search_Page
*
*/

global $query_string;

$query_args = explode("&", $query_string);
$search_query = array();

foreach($query_args as $key => $string) {
	$query_split = explode("=", $string);
	$search_query[$query_split[0]] = urldecode($query_split[1]);
} // foreach

get_header(); ?>

		<div id="primary" class="showcase">
			<div id="content" role="main">
				<h2 class="page-title">Search for: <?php echo $search_query['s'] ; ?></h2>
				<div class="page-content">

					<?php 

					//test query
					if(mp_test_query($search_query) == true){

						mp_display_products($query = $search_query, $display = 'grid');


					}
					else{

						echo '<span class="search-result">No results found for your search: <span class="search-terms">'.$search_query['s'].'</span></span>' ;

					} ?>

					<div class="clear"></div>
				</div>
			</div><!-- #content -->
		</div><!-- #primary -->

<?php get_sidebar() ; ?>
<?php get_footer(); ?>