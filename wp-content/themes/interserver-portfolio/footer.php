<?php
/**
* The template for displaying the footer.
*
* Contains the closing of the #content div and all content after.
*
* @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
*
* @package InterServer Portfolio
*
*/
?>
</div><!-- .site-content -->
</div><!-- #page -->
<a href="#top" class="back-to-top" style="display: inline;">Back to Top
</a>
<footer class="container-fluid">
   <div class="row footer-top">
      <div class="container">
         <div class="col-sm-12 col-lg-12 col-md-12">
            <div class="col-xs-12 col-sm-6 col-md-3 col-fot-4">
               <?php dynamic_sidebar( 'footer-1' ); ?>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-fot-2">
               <?php dynamic_sidebar( 'footer-2' ); ?>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-fot-3">
               <?php dynamic_sidebar( 'footer-3' ); ?>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-fot-4">
               <?php dynamic_sidebar( 'footer-4' ); ?>
            </div>
         </div>
      </div>
   </div>
   <div class="row footer-bottom">
      <div class="container">
         <div class="col-sm-12 col-lg-12 col-md-12 text-center">
            <?php dynamic_sidebar( 'footer-bottom' ); ?>	      	
         </div>
      </div>
      <div class="copyright_sec">
         <div class="col-md-12">
            <div class="text-center">
               <?php esc_html_e( 'Powered By ', 'interserver-portfolio' ); ?>
               <a href="<?php echo esc_url( 'https://www.interserver.net' ); ?>">
               <?php esc_html_e( 'InterServer Web Hosting','interserver-portfolio' ); ?>
               </a>
            </div>
         </div>
      </div>
   </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
