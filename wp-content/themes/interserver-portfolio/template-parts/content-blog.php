<?php
/**
* Template part for displaying blog content.
*
* @link https://codex.wordpress.org/Template_Hierarchy
*
* @package InterServer Portfolio
*
*/
?>
<div class="blogpost_box"><!---blogpost_box-->
   <?php $img_attribs = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
      if ( $img_attribs ) {   
      echo '<div class="blogimage"><a href="'.esc_url(get_permalink()).'">'. get_the_post_thumbnail($post->ID,"full").'</a></div>';
  } ?>   
   <h2 class="title"><a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a></h2>
   <div class="entry"><!---entry-->    
      <div class="blogcontent"><?php echo esc_html(interserver_portfolio_custom_excerpt(15));?></div>
      <div class="pmc-read-more"><a href="<?php echo esc_url(get_permalink()); ?>"><?php esc_html_e('Read More','interserver-portfolio')?></a>
      </div>  
   </div> <!---entry-->  
   <div class="bottomBlog"><!---bottomBlog-->    
      <div class="post-time">
         <i class="fas fa-calendar-alt" aria-hidden="true"></i><a class="post-meta-time" href="<?php the_permalink(); ?>"  rel="bookmark"><?php the_time( get_option('date_format') ); ?></a>  
      </div>
      <div class="blog-category"> <i class="fas fa-folder-open" aria-hidden="true"></i><?php $categories = get_the_terms( $post, 'category' ); foreach( $categories as $category ) { echo '<a href="' . esc_url( home_url( '/' ) ) . 'category'.'/' . esc_html( $category->slug ) . '">'. esc_html( $category->name ) .'</a>';
         }?>   
      </div>           
      <div class="post-author">
         <a class="post-meta-author" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><i class="fas fa-user" aria-hidden="true"></i><?php the_author(); ?></a>     
      </div>  
  </div><!---bottomBlog-->
</div><!---blogpost_box-->