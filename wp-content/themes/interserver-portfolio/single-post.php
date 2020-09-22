<?php
/**
* The template for displaying  single blog page.
*
* @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
*
* @package InterServer Portfolio
*
*/
get_header(); ?>
<div id="primary" class="content-area col-xs-12 col-sm-12 col-md-12">
	<main id="main" class="site-main container" role="main">
		<div class="single-blog">
         <?php
				if (have_posts()) : while (have_posts()) :
		   		the_post(); ?>
		   		<div class="blog-full blogpost">
 					<div class="posttext">
                  <div class="topBlog">							
							<h2 class="title"><?php the_title(); ?></h2>
							<div class="post-meta-comments">
		 	                <a href="<?php comments_link(); ?>"><?php comments_number('No Comments', 'One Comment', '% Comments' );?>
		 	                </a>
		 	                </div>
						</div><!--topBlog-->  
						<div class="blogsingleimage"><a href="<?php echo esc_url(get_permalink()); ?>"><?php the_post_thumbnail('full'); ?></a></div><!--blogsingleimage-->
						<div class="sentry"><?php the_content();?></div>
						<div class="blog-category">
								<i class="fas fa-folder-open" aria-hidden="true"></i> 
								<?php
                        $categories = get_the_terms( $post, 'category' );
                        foreach( $categories as $category ) {
							    	echo '<a href="' . esc_url(home_url('/')) . 'category'.'/' . esc_html($category->slug) . '">'.esc_html($category->name) .'</a>';
								} ?>
						</div><!--blog-category-->  
		   		</div><!--posttext-->
               </div><!--blogpost-->
					<?php
	       				wp_link_pages( array(
	            		'before' => '<div class="page-links">' . __( 'Pages:', 'interserver-portfolio' ),
	            		'after'  => '</div>',
	        		) ); ?>
					<div class="relatedPosts">
						<div class="relatedtitle">
							<h4>Related Posts</h4>
						</div>
						<div class="related">	
							<?php
							$related = get_posts( array( 'category__in' => wp_get_post_categories($post->ID), 'numberposts' => 3, 'post__not_in' => array($post->ID) ) );
							if( $related ) foreach( $related as $post ) {
							setup_postdata($post); ?>
							<div class="one_third col-xs-12 col-sm-4 col-md-4">
							 	<div class="related_wrap">
									<div style="background: transparent none repeat scroll 0% 0%;" class="image"><a rel="external" href="<?php the_permalink()?>"><?php if ( has_post_thumbnail() ) {the_post_thumbnail('full'); }?></div>
									<h4><a href="<?php the_permalink()?>"><?php the_title(); ?></a></h4>
									<a class="post-meta-time" href="<?php the_permalink(); ?>" rel="bookmark"><?php the_time( get_option('date_format') ); ?></a>		
								</div>
					    	</div>
				        	<?php } wp_reset_postdata(); ?>	
						</div><!--related-->
		     		</div><!--relatedPosts-->
	            <div class="commentform">
	 			  	<?php
						if ( comments_open() || get_comments_number() ) :
						comments_template();
						endif;
					?>
	            </div>
	            <div class="post-navigation"> <?php the_post_navigation();?> </div>
            <?php 
         	endwhile;
			endif;
			?>
		</div><!--single-blog-->
	</main><!-- #main -->
</div><!-- #primary -->
<?php
get_footer();