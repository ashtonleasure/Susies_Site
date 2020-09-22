<?php
/**
* The header for our theme.
*
* This is the template that displays all of the <head> section and everything up until <div id="content">
*
* @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
*
* @package InterServer Portfolio
*
*/
?>
<!DOCTYPE html>
<html 
   <?php language_attributes(); ?>>
   <head>
      <meta charset="<?php bloginfo( 'charset' ); ?>">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="profile" href="http://gmpg.org/xfn/11">
      <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
      <?php wp_head();
         ?>
   </head>
   <body 
      <?php body_class(); ?>>
      <div id="top"></div>
      <header id="masthead" class="site-header" role="banner">
         <div class="container">
         <div id='menu-cont' class="menu-wrap">
            <nav id="cssmenu">
               <h1 class="site-title">
                  <a href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
                  <?php if ( function_exists( 'the_custom_logo' ) && ( has_custom_logo() ) ) { the_custom_logo(); } else {echo esc_html( get_bloginfo( 'name'));} ?>
                  </a>
               </h1>
               <div id="head-mobile">
               </div>
               <div class="button">
               </div>
               <?php wp_nav_menu( array( 'theme_location' => 'primary','container'=>'ul','menu_class'=>'main-menu')); ?>
            </nav>
         </div>
      </header>
      <!-- #masthead -->
      <?php

         if(is_front_page() || is_home() ){


         if(get_theme_mod('hide_slider_sec') !=1 && get_theme_mod( 'slider_loop', 3 )*1 > 0){

         
         $args = array(
            'post_type' => 'post',
            'posts_per_page' => (int) get_theme_mod('slider_loop','3'),
            'meta_query' => array( array(
            'key' => '_thumbnail_id'
         ) )
         );
         $slider_query = new WP_Query($args);
         if ($slider_query->have_posts()) { ?>
      <?php while ($slider_query->have_posts()) : $slider_query->the_post();
         $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
         $img_arr[] = $thumb;
         $id_arr[] = $post->ID; 
         endwhile;?>
      <?php if(!empty($id_arr)){ ?>
      <div class="slider-wrap">
         <div id="slider" class="nivoSlider">
            <?php 
               $i=1;
               foreach($img_arr as $url){ if(!empty($url)){ ?>
            <img src="<?php echo esc_url($url[0]); ?>" title="#slidecaption<?php echo (int)$i; ?>" />
            <?php }
               $i++; } ?>
         </div>
         <?php 
            $i=1;
            foreach($id_arr as $id){ 
            $title = get_the_title( $id );
            $link =  get_permalink( $id );
            $post_l = get_post($id); 
            setup_postdata( $post_l );
            $content = interserver_portfolio_custom_excerpt(10);
            ?>  
         <div id="slidecaption<?php echo (int)$i;?>" class="nivo-html-caption">
            <div class="slider-text-heading">
               <?php echo '<a href="'.esc_url($link).'">'.esc_html($title).'</a>';?>
            </div>
            <div class="slider-text">
               <?php echo esc_html($content);?>
            </div>
         </div>
         <?php $i++; } ?>       
      </div>
      <!--slider_wrap-->
      <?php 
         }
         }else{
         interserver_portfolio_header_image();
         } 
      }else{
         interserver_portfolio_header_image();
      } 
   } else { 
         interserver_portfolio_header_image();
   }
?> 
<div id="page" class="site">
   <div id="main-content" class="site-content">