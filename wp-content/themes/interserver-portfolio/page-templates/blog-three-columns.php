<?php
/**
*Template Name: Blog Three Columns
*
* @package InterServer Portfolio
*
*/
get_header(); ?>
<div id="primary" class="content-area blog-col col-xs-12 col-sm-12 col-md-12">
   <main id="main" class="site-main container" role="main">
      <?php
         $query_args = array(
         'post_type' => 'post',
          			'orderby'=>'date',
         'order' =>'DESC',
         );
         $the_query = new WP_Query( $query_args ); 
         $custom_class_chrome = '';
         if( $the_query->post_count<=3 ) { $custom_class_chrome = 'chrome_grid_class'; }		
         if( $the_query->post_count<3 ) { $blank_box ='<div class="blog-full" style="box-shadow:none;border:none;"></div>'; }	
         ?>
      <div class="blog-three-grid <?php echo esc_attr($custom_class_chrome); ?>"> <!---.blog-three-grid-->	
         <?php
            $the_query = new WP_Query( $query_args ); 
            while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
         <div class="blog-full">
            <?php get_template_part( 'template-parts/content', 'blog' );?>
         </div><!--blog-full-->
         <?php endwhile; 
            echo $blank_box;
            wp_reset_postdata(); ?>
      </div><!-- .blog-three-grid -->
      <?php interserver_portfolio_custom_pagination( $the_query );?>
   </main><!-- #main -->
</div><!-- #primary -->
<?php get_footer();?>