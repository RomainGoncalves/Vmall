<?php
## 404 Error page
get_header(); ?>

<div id="primary">
	<div id="content" role="main">
		<h2 class="page-title">Wrong Page.</h2>
		<div class="page-content">
		There is nothing on this page.<br />
		Check out <a href="<?php echo home_url($path = '/', $scheme = null); ?>">our products</a>.
		</div>
	</div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>