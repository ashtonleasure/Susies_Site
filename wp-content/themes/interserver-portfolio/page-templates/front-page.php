<?php
/**
 * Template Name:Homepage
 * 
 * @package InterServer Portfolio
 *
 */

get_header(); ?>
<div id="content" role="main">
   <!--=============== About Section ===============-->
   <?php if(get_theme_mod('hide_about_sec') == ""): ?>
   <section id="about">
      <div class="about-con scr container">
         <div class="heading">
            <h1><?php echo esc_html(get_theme_mod('about_sec_title','About Us'));?></h1>
            <div class="sub-title"><?php echo esc_html(get_theme_mod('about_sec_subtitle'));?></div>
         </div>
         <ul id="about_wrap" class="blog-wrapper">
            <?php for($f=1; $f<6; $f++) { 
               if(get_theme_mod('about_sec_page_'.$f) != '') { ?>
            <?php $page_query = new WP_Query('page_id='.esc_attr(get_theme_mod('about_sec_page_'.$f))); ?>
            <?php while( $page_query->have_posts() ) : $page_query->the_post(); ?>
            <?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
               $url = '';
               if(is_array($thumb)){
                   $url = $thumb['0'];
               } ?>
            <li>
               <div class="blog-img"><a href="<?php the_permalink();?>"><img class="img-responsive" src="<?php if($url !='') { echo esc_url($url); } else { echo esc_url(get_template_directory_uri() .'/images/about.jpg' ); } ?>" alt=""/></a></div>
            </li>
            <?php endwhile;  wp_reset_postdata();?>
            <?php } }?>    
         </ul>
      </div>
   </section>
   <!--About-section-->    
   <?php endif; ?>
   <!--=============== Services Section ===============-->
   <?php if(get_theme_mod('hide_services_sec') == ""): ?>
   <section id="services">
      <div class="container-fluid services-con">
         <div class="container">
            <div class="heading">
               <h1><?php echo esc_html(get_theme_mod('services_sec_title','Services'));?></h1>
               <div class="sub-title"><?php echo esc_html(get_theme_mod('services_sec_subtitle'));?></div>
            </div>
            <ul id="service_wrap" class="blog-wrapper">
               <?php
                  // Get category ID from Theme Customizer
                   $catID = get_theme_mod('services_setting');
                  // Only get Posts that are assigned to the given category ID
                  $service_query = new WP_Query(array(
                     'post_type' => 'post',
                     'order' => 'DESC', 
                     'cat' => $catID,
                     'posts_per_page' => 8,    
                  ));
                      if($service_query->have_posts()) :
                  while( $service_query->have_posts() ) : $service_query->the_post(); ?>
               <li class="col-xs-12 col-sm-6 col-md-3 text-center">
                  <div class="service-img">
                     <?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID), 'thumbnail' );
                        if( is_array($thumb) && count($thumb)>0 ){
                             $url = $thumb['0']; 
                             }else{ 
                             $url = ''; 
                             }
                        ?>    
                     <div class="s_image"><img src="<?php if($url) { echo esc_url($url); } else { echo esc_url(get_template_directory_uri().'/images/service.jpg'); } ?>" alt=""/></div>
                  </div>
                  <div class="service-title topbottom10"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></div>
                  <div class="service-content"><?php echo esc_html(interserver_portfolio_custom_excerpt(17));?></div>
               </li>
               <?php endwhile; endif;?>
            </ul>
         </div>
      </div>
   </section>
   <!--Services-Section-->
   <?php endif;?>
   <!--=============== Portfolio Section ===============-->
   <?php 
      if(get_theme_mod('hide_portfolio_sec') == ""):
        // Get category ID from Theme Customizer
       $porfolio_catID = get_theme_mod('portfolio_cat_setting');
       $categories = get_categories( array('post_type' => 'post','parent'  => $porfolio_catID ) );
       $args = array(
         'post_type' => 'post',
         'posts_per_page' => 8,
         'cat' => $porfolio_catID,
         'meta_query' => array( array(
             'key' => '_thumbnail_id'
            ) )
         );
        $loop = new WP_Query( $args );
         if($loop->have_posts()){
          ?>
   <section id="interserver_portfolio_sec">
      <div class="container-fluid pro-con">
         <div class="container">
            <section id="portfolio" class="interserver_portfolio_section">
               <div class="section-header">
                  <div class="heading">
                     <h1><?php echo esc_html(get_theme_mod('portfolio_sec_title','Portfolio'));?></h1>
                     <div class="sub-title"><?php echo esc_html(get_theme_mod('portfolio_sec_subtitle'));?></div>
                  </div>
                  <div class="interserver_portfolio_sec">
                     <ul id="filters" class="clearfix">
                        <?php
                           $count = count($categories);
                           echo '<li><span data-filter="all" class="filter">All</span></li>';
                           if ( $count > 0 ){
                               $cat_ctr =1;
                               foreach ( $categories as $category ) {
                                   if($category->slug == 'uncategorized') continue;
                                   $termname = strtolower($category->name);
                                   $termname = str_replace(' ', '-', $termname);
                                   echo '<li><span class="filter" data-filter=".'.esc_html($termname).'">'.esc_html($category->name).'</span></li>';
                                   if($cat_ctr>4) break;
                                   $cat_ctr++;
                               }
                           }
                           ?>
                     </ul>
                  </div>
               </div>
               <div id="portfoliolist">
                  <?php
                     while ( $loop->have_posts() ) : $loop->the_post();
                      $terms = get_the_terms( $post->ID, 'category' ); 
                            if ( $terms && ! is_wp_error( $terms ) ) :
                             $links = array();
                            foreach ( $terms as $term ) {
                                 $links[] = $term->name;
                         }
                             $tax_links = join( " ", str_replace(' ', '-', $links));
                             $tax = strtolower($tax_links);
                         else :
                         $tax = '';
                         endif;
                         ?>
                  <div class="portfolio item <?php echo esc_html($tax); ?>" data-cat="<?php echo esc_html($tax); ?>">
                     <div class="portfolio-wrap">
                        <div class="image"><?php if ( has_post_thumbnail() ){ the_post_thumbnail('full',array( 'class' => 'img-responsive' ) ); }?></div>
                        <div class="desc">
                           <p><a href="<?php the_permalink();?>"><?php the_title()?></a></p>
                        </div>
                     </div>
                  </div>
                  <?php endwhile; ?>
               </div>
            </section>
         </div>
         <!--container-->    
      </div>
      <!--container-fluid-->    
   </section>
   <!--Portfolio-Section-->
   <?php } endif;?>
   <!--=============== Blog Section ===============-->
   <?php if(get_theme_mod('hide_blog_sec') == ""): ?>
   <section id="blog">
      <div class="container-fluid blog-con">
         <div class="container">
            <div class="heading">
               <h1><?php echo esc_html(get_theme_mod('blog_sec_title','Blog'));?></h1>
               <div class="sub-title"><?php echo esc_html(get_theme_mod('blog_sec_subtitle'));?></div>
            </div>
            <?php              
               $paged=(get_query_var('paged')) ? get_query_var('paged') : 1; 
               $rer=get_posts('post_type=post&orderby=post_date&order=DESC&posts_per_page=4&paged='.$paged);
               if(have_posts()) :
               echo '<ul id="nextpagedata" class="blog-wrapper">';
                  foreach ( $rer as $post ) : setup_postdata( $post ); ?>
            <li class="col-xs-12 col-sm-6 col-md-3 blog-full">
               <div class="blog-img"><a href="<?php echo esc_url(get_permalink()); ?>"><?php if ( has_post_thumbnail() ) {the_post_thumbnail('full'); }?></a></div>
               <div class="blog-title"><a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a></div>
               <div class="blog-date"><?php the_time( get_option('date_format') ); ?></div>
               <div class="blog-contant"><?php echo esc_html(interserver_portfolio_custom_excerpt(15)); ?></div>
               <div class="pmc-read-more"><a href="<?php echo esc_url(get_permalink()); ?>"><?php esc_html_e('Continue reading','interserver-portfolio')?></a></div>
            </li>
            <?php 
               endforeach; 
               wp_reset_postdata(); 
               echo '</ul>';
               ?>
            <div class="page-navi-wrap">
               <div class="nav-previous"><?php echo previous_posts_link( __( '<span class="meta-nav">&nbsp;&lt;</span> PREVIOUS', 'interserver-portfolio' ) ); ?></div>
               <div class="nav-next"><?php echo next_posts_link( __( 'NEXT <span class="meta-nav">&nbsp;&gt;</span>', 'interserver-portfolio' ) ); ?></div>
            </div>
            <?php else :  endif; ?>    
         </div>
      </div>
   </section>
   <!--blog-->
   <?php endif;?>
</div>
<!-- #content -->
<?php get_footer(); ?>