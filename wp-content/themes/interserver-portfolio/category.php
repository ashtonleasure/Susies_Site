<?php
/**
* The template for displaying Archive pages.
*
* Learn more: http://codex.wordpress.org/Template_Hierarchy
*
* @package InterServer Portfolio
*/
get_header();
?>
<div id="primary" class="content-area col-xs-12 col-sm-12 col-md-12">
   <main id="main" class="site-main container" role="main">
      <div class="blog-three-grid">
         <!---blog-three-grid-->
         <?php if ( have_posts() ) : while ( have_posts()) : the_post() ;?>
         <div class="blog-full">
            <?php get_template_part( 'template-parts/content', 'blog' );?>
         </div>
         <?php 
         endwhile; //wp_reset_postdata(); 
         endif;
         ?>
      </div>
      <!---blog-three-grid-->
      <?php interserver_portfolio_custom_pagination();?>
   </main>
   <!-- #main -->
</div>
<!-- #primary -->
<?php get_footer(); ?>
