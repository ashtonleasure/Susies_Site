<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package InterServer Portfolio
 *
 */
get_header(); ?>
<div class="container">
	<div id="primary" class="content-area col-xs-12 col-sm-7 col-md-9 paddi">
		<main id="main" class="site-main" role="main">
		   <div class="entry-content"> 
		   <div class="blog-two-grid"> 
				<?php
				if (have_posts()): ?>
		   	<?php
				global $query_string;
				$query_args = explode("&", $query_string);
				$search_query = array();
				if (strlen($query_string) > 0) {
					foreach($query_args as $key => $string) {
						$query_split = explode("=", $string);
						$search_query[$query_split[0]] = urldecode($query_split[1]);
					} // foreach
				} //if
				$search = new WP_Query($search_query);
				while ($search->have_posts()):
					$search->the_post();
					/**
					 * Run the loop for the search to output the results.
					 * If you want to overload this in a child theme then include a file
					 * called content-search.php and that will be used instead.
					 */
				?>
				<div class="blog-full">
					<?php get_template_part('template-parts/content', 'blog');?>
				</div>
				<?php
				endwhile;
				interserver_portfolio_custom_pagination();
				wp_reset_postdata();
				else:
					get_template_part('template-parts/content', 'none');
				endif; ?>
			</div>
			</div><!-- entry-content -->
		</main><!-- #main -->
	</div><!-- #primary -->
	<?php get_sidebar(); ?>
</div> <!-- #container -->
<?php get_footer(); ?>
