<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package InterServer Portfolio
 */
get_header(); ?>


<div id="primary" class="">
	<main id="main" class="site-main" role="main">
		<section class="error-404 not-found container">
			<div class="page-content text-center">
				<h2><?php esc_html_e("This is somewhat embarrassing, isn't it?", 'interserver-portfolio'); ?></h2>
				<p style="font-size:15px;"><?php esc_html_e('It looks like nothing was found at this location. Maybe try a search?', 'interserver-portfolio'); ?></p>
    		    <?php get_search_form(); ?>
 			</div><!-- .page-content -->
		</section><!-- .error-404 -->
	</main><!-- #main -->
	</div><!-- #primary -->
<?php get_footer(); ?>
