<?php
/**
* The main template file.
*
* This is the most generic template file in a WordPress theme
* and one of the two required files for a theme (the other being style.css).
* It is used to display a page when nothing more specific matches a query.
* E.g., it puts together the home page when no home.php file exists.
*
* @link https://codex.wordpress.org/Template_Hierarchy
*
* @package InterServer Portfolio
*
*/
get_header(); ?>
<div class="container">
   <div id="primary" class="content-area col-xs-12 col-sm-7 col-md-9 paddi">
   	<main id="main" class="site-main" role="main">
	      <?php
			$query_args = array(
				'post_type' => 'post',
				'orderby'=>'date',
				'order' =>'DESC',
			);
			$the_query = new WP_Query( $query_args ); 
			$custom_class_chrome = '';
			if( $the_query->post_count==2 ){
				$custom_class_chrome = 'chrome_grid_class';					
			}
			?>
	      <div class="blog-two-grid <?php echo esc_attr( $custom_class_chrome ); ?>">
	         <!---.blog-two-grid-->
	         <?php
				while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
					<div class="blog-full">
						<?php get_template_part( 'template-parts/content', 'blog' );?>
					</div>
	         <?php 
	     		endwhile;
				wp_reset_postdata(); ?>
	      </div>
	      <!-- .blog-two-grid -->
	      <?php interserver_portfolio_custom_pagination( $the_query );?>
   	</main>
    	<!-- #main -->
  	</div>
  	<!-- #primary -->
  	<?php get_sidebar(); ?>
</div> 
<!-- #container -->
<?php get_footer();?>
