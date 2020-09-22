<?php
/**
 * Custom template tags for Bramble.
 * @package bramble
 */


/**
 * Bramble view all link for the shop and assoc. pages
 *
 * Designed to serve as the view all link for all post types, it accepts the post type argument (reqd)
 * and an optional tag to enclose the link.
 *
 * @param string $post_type The post type whose archive we're linking to
 * @param string $tag       An optional tag to wrap the link in
 */
if ( ! function_exists( 'bramble_the_view_all' ) ) {
    function bramble_the_view_all( $post_type, $tag = '' ) {

	    // Test for WooCommerce as well here...
	    if( 'product' == $post_type && class_exists( 'WooCommerce' ) ) {

		    $shop_page_id   = wc_get_page_id( 'shop' );
		    $url            = get_permalink( $shop_page_id );
		    $title          = get_option( 'woocommerce_shop_page_title' ) ? get_option( 'woocommerce_shop_page_title' ) : get_the_title( $shop_page_id );

		    // No shop set up
		    if( -1 == $shop_page_id ) {
			    $url   = home_url( '/' );
			    $title = 'Home';
		    }

	    } elseif( 'post' == $post_type ) {

			$blog_id = get_option( 'page_for_posts' );
		    $url     = get_permalink( $blog_id );
			$title   = get_the_title( $blog_id );

	    } else {
		    return; // Don't generate a link at all
	    }

	    // Deal with the tag
	    $allowed_html = array( 'h1', 'h2', 'h3', 'h4', 'span', 'div', 'i', 'b', 'strong' );

	    if( $tag ) {
		    $tag_open  = '<' . wp_kses( $tag, $allowed_html ) . '>';
		    $tag_close = '</' . wp_kses( $tag, $allowed_html ) . '>';
	    } else {
		    $tag_open  = '';
		    $tag_close = '';
	    }

        printf( '<a href="%1$s" alt="%2$s" class="button">%3$s%4$s%5$s</a>',
	        esc_url( $url ),
            esc_attr( $title ),
	        $tag_open,
	        __( 'View All', 'bramble' ),
	        $tag_close
        );

    } // bramble_the_view_all
} // if

/**
 * Pagination template tag, based on Kriesi custom pagination function
 *
 * @param int $pages
 * @param int $range
 */

if ( ! function_exists( 'bramble_the_paging_nav' ) ) {
	function bramble_the_paging_nav( $pages = '', $range = 2 ) {
		$showitems = ( $range * 2 ) + 1;

		global $paged;
		if ( empty( $paged ) ) {
			$paged = 1;
		}

		if ( '' == $pages ) {
			global $wp_query;
			$pages = $wp_query->max_num_pages;
			if ( ! $pages ) {
				$pages = 1;
			}
		}

		if ( 1 != $pages ) {
			echo "<div class='pagination clear'><div class='inside'>";
			if ( $paged > 2 && $paged > $range + 1 && $showitems < $pages ) {
				echo "<a href='" . esc_url( get_pagenum_link( 1 ) ) . "'>&laquo;</a>";
			}
			if ( $paged > 1 && $showitems < $pages ) {
				echo "<a href='" . esc_url( get_pagenum_link( $paged - 1 ) ) . "'>&lsaquo;</a>";
			}

			for ( $i = 1; $i <= $pages; $i ++ ) {
				if ( 1 != $pages && ( ! ( $i >= $paged + $range + 1 || $i <= $paged - $range - 1 ) || $pages <= $showitems ) ) {
					echo ( $paged == $i ) ? "<span class='current'>$i</span>" : "<a href='" . esc_url( get_pagenum_link( $i ) ) . "' class='inactive' >$i</a>";
				}
			}

			if ( $paged < $pages && $showitems < $pages ) {
				echo "<a href='" . get_pagenum_link( $paged + 1 ) . "'>&rsaquo;</a>";
			}
			if ( $paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages ) {
				echo "<a href='" . esc_url( get_pagenum_link( $pages ) ) . "'>&raquo;</a>";
			}
			echo "</div></div>\n";
		}
	} // bramble_the_paging_nav
} // if

/**
 * Post navigation
 */

if ( ! function_exists( 'bramble_the_post_nav' ) ) {
	// Display navigation to next/previous post when applicable.
	function bramble_the_post_nav() {
		// Don't print empty markup if there's nowhere to navigate.
		$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
		$next     = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous ) {
			return;
		}
		?>
		<nav class="navigation post-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'bramble' ); ?></h1>

			<div class="nav-links clear">
				<?php
				next_post_link( '<div class="nav-next"><span class="label">%link</span></div>', _x( '%title', 'Next post link', 'bramble' ) );
				$portfolio_page_id = bramble_get_portfolio_id();
				if ( $portfolio_page_id ) {
					?>
					<div class="nav-portfolio <?php if ( ! get_next_post() ) {
						echo 'inactive';
					} ?>">
						<a href="<?php echo esc_url( get_permalink( $portfolio_page_id ) ); ?>"></a>
					</div>
				<?php
				}
				previous_post_link( '<div class="nav-previous"><span class="label">%link</span></div>', _x( '%title', 'Previous post link', 'bramble' ) );
				?>
			</div>
			<div class="clear"></div>
			<!-- .nav-links -->
		</nav><!-- .navigation -->
	<?php
	} // bramble_the_post_nav
} // if

/**
 * Function to display meta data for posts
 */

if ( ! function_exists( 'bramble_meta_class' ) ) {
	function bramble_meta_class() {
		$show_date = get_theme_mod( 'bramble_show_meta_date', 'yes' );
		$show_author = get_theme_mod( 'bramble_show_meta_author', 'yes' );
		$show_categories = get_theme_mod( 'bramble_show_meta_categories', 'yes' );
		$show_comments = get_theme_mod( 'bramble_show_meta_comments', 'yes' );
		if($show_date == 'no' && $show_author == 'no' && $show_categories == 'no' && $show_comments == 'no') {
			echo "no-meta";
		}
	}
}

if ( ! function_exists( 'bramble_the_post_meta' ) ) {
	function bramble_the_post_meta() {
		$show_date = get_theme_mod( 'bramble_show_meta_date', 'yes' );
		$show_author = get_theme_mod( 'bramble_show_meta_author', 'yes' );
		$show_categories = get_theme_mod( 'bramble_show_meta_categories', 'yes' );
		$has_meta = false;
		$meta = '';
		
		if($show_date == 'yes') {
			$has_meta = true;
			$date = '<span>' . esc_attr( get_the_date() ) . '</span>';
			$meta .= $date;
		}
		
		if($show_author == 'yes') {
			$has_meta = true;
			$author = '<span>' . __( 'By ', 'bramble' ) . '<a href="'. esc_url(get_author_posts_url( get_the_author_meta( 'ID' ))) .'">'. esc_html( get_the_author() ) .'</a></span>';
			$meta .= $author;
		}
		
		if($show_categories == 'yes') {
			$has_meta = true;
			$categories = get_the_category();
			$separator  = ', ';
			$output     = '';
			if ( $categories ) {
				foreach ( $categories as $category ) {
					$output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="' . esc_attr( sprintf( __( "View all posts in %s", 'bramble' ), $category->name ) ) . '">' . $category->cat_name . '</a>' . $separator;
				}
				$category_string = '<span>' . trim( $output, $separator ) . '</span>';
			} else {
				$category_string = '';
			}
		
			$meta .= $category_string;
		}
		
		if($has_meta) echo $meta;
		
	} // bramble_the_post_meta
} // if

/**
 * Simple function to check whether current page is the blog
 */

if ( ! function_exists( 'bramble_is_blog' ) ) {
	function bramble_is_blog() {
		global $post;
		$posttype = get_post_type( $post );

		return ( ( ( is_archive() ) || ( is_author() ) || ( is_category() ) || ( is_home() ) || ( is_single() ) || ( is_tag() ) ) && ( 'post' == $posttype ) ) ? true : false;
	} // bramble_is_blog
} // if

/**
 * Bramble a link of categories without linking to them
 *
 * @param string $id
 */

if ( ! function_exists( 'bramble_category_list' ) ) {
	function bramble_category_list( $id ) {
		$categories = get_the_category( $id );
		$separator  = ', ';
		$output     = '';

		if ( $categories ) {
			foreach ( $categories as $category ) {
				$output .= $category->cat_name . $separator;
			}

			return trim( $output, $separator );
		}
	} // bramble_category_list
} // if

/**
 * Check whether the blog is categorized
 *
 * @return bool whether or not blog is categorized
 */

if ( ! function_exists( 'bramble_categorized_blog' ) ) {
	function bramble_categorized_blog() {
		if ( false === ( $all_the_cool_cats = get_transient( 'bramble_categories' ) ) ) {
			// Bramble an array of all the categories that are attached to posts.
			$all_the_cool_cats = get_categories( array(
				'fields'     => 'ids',
				'hide_empty' => 1,

				// We only need to know if there is more than one category.
				'number'     => 2,
			) );

			// Count the number of categories that are attached to the posts.
			$all_the_cool_cats = count( $all_the_cool_cats );

			set_transient( 'bramble_categories', $all_the_cool_cats );
		}

		if ( $all_the_cool_cats > 1 ) {
			// This blog has more than 1 category so bramble_categorized_blog should return true.
			return true;
		} else {
			// This blog has only 1 category so bramble_categorized_blog should return false.
			return false;
		}
	} // bramble_categorized_blog
} // if


/**
 * Custom post excerpts, remove ellipses from excerpts
 *
 * @param string $text the excerpt
 *
 * @return string $new_text excerpt without ellipses
 */

if ( ! function_exists( 'bramble_excerpt_ellipsis' ) ) {
	function bramble_excerpt_ellipsis( $text ) {
		global $post;

		$bramble_the_more_link = '&hellip; <a href="' . esc_url( get_permalink() ) . '" title="' . the_title_attribute( 'echo=0' ) . '" class="read-more">';
		$bramble_the_more_link .= __( 'Read More', 'bramble' );
		$bramble_the_more_link .= '</a>';

		$new_text = str_replace( '[&hellip;]', $bramble_the_more_link, $text );

		return $new_text;
	} // bramble_excerpt_ellipsis

	add_filter( 'the_excerpt', 'bramble_excerpt_ellipsis' );
} // if

// Add Excerpt Support for Pages
add_post_type_support( 'page', 'excerpt' );


/**
 * Check if blog page template
 *
 */

if ( ! function_exists( 'is_blog_page' ) ) {
	function is_blog_page() {
		global $wp_query;
		$pageid = (int) $wp_query->post->ID;
		$template_name = get_post_meta($pageid, '_wp_page_template', true);
		$pos = strpos($template_name, "blog");
		if($pos === false) {
			return false;
		}else {
			return true;
		}
	}
}




/**
 * Prints custom more link
 *
 * @param string $class
 */

if ( ! function_exists( 'bramble_the_more_link' ) ) {
	function bramble_the_more_link( $class = '' ) {
		global $post;

		$bramble_the_more_link = '<a href="' . esc_url( get_permalink() ) . '" title="' . the_title_attribute( 'echo=0' ) . '" class="read-more' . $class . '">';
		$bramble_the_more_link .= __( 'Read More', 'bramble' );
		$bramble_the_more_link .= '</a>';

		echo $bramble_the_more_link;
	} // bramble_the_more_link
} // if

/**
 * Remove <p> Tags from Images (currently deactivated)
 *
 * @param $content
 *
 * @return mixed
 */

if( ! function_exists( 'bramble_filter_ptags_on_images' ) ) {
	function bramble_filter_ptags_on_images( $content ) {
		return preg_replace( '/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content );
	} // bramble_filter_ptags_on_images

	//add_filter( 'the_content', 'bramble_filter_ptags_on_images' );
} // if

/**
 * Flush out the transients used in bramble_categorized_blog.
 */

if( ! function_exists( 'bramble_category_transient_flusher' ) ) {
	function bramble_category_transient_flusher() {
		// Like, beat it. Dig?
		delete_transient( 'bramble_categories' );
	} // bramble_category_transient_flusher

	add_action( 'edit_category', 'bramble_category_transient_flusher' );
	add_action( 'save_post', 'bramble_category_transient_flusher' );
} // if

/**
 * Comments
 *
 * @param string $comment
 * @param mixed $args
 * @param int $depth
 */
if( ! function_exists( 'bramble_the_comments' ) ) {
	function bramble_the_comments( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment; ?>
		<li id="li-comment-<?php comment_ID() ?>">

		<div class="comment <?php echo get_comment_type(); ?>" id="comment-<?php comment_ID() ?>">

			<?php echo get_avatar( $comment, '70', get_template_directory_uri() . '/images/default_avatar.png' ); ?>

			<h5><?php comment_author_link(); ?></h5>
			<span class="date"><?php comment_date(); ?></span>

			<?php if ( $comment->comment_approved == '0' ) : ?>
				<p><span class="message"><?php _e( 'Your comment is awaiting moderation.', 'bramble' ); ?></span></p>
			<?php endif; ?>

			<?php comment_text() ?>

			<?php
			if ( get_comment_type() != "trackback" )
				comment_reply_link( array_merge( $args, array( 'add_below'  => 'comment',
				                                               'reply_text' => '<span>' . __( 'Reply', 'bramble' ) . '</span>',
				                                               'login_text' => '<span>' . __( 'Log in to reply', 'bramble' ) . '</span>',
				                                               'depth'      => $depth,
				                                               'max_depth'  => $args['max_depth']
						) ) )

			?>

		</div><!-- end comment -->

	<?php
	} // bramble_the_comments
}// if

/**
 * Pings
 *
 * @param string $comment
 * @param mixed $args
 * @param mixed $depth
 */

if( !function_exists( 'bramble_the_pings' ) ) {
	function bramble_the_pings( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment; ?>
		<li class="comment" id="comment-<?php comment_ID() ?>"><?php comment_author_link(); ?> - <?php comment_excerpt(); ?>
	<?php
	} // bramble_the_pings
} // if

/**
 * Sanitize text using kses, do the shortcodes and tag it with <p>
 *
 * @param string $content
 *
 * @return string $content
 */

if ( ! function_exists( 'bramble_clean_and_tag' ) ) {
	function bramble_clean_and_tag( $content ) {

		$return = wpautop( wp_kses_post( do_shortcode( $content ) ) );

		return $return;

	} // bramble_clean_and_tag
} // if


/**
 * Builds and prints the skill filter nav, hiding any skills without associated projects
 *
 * @param str $post_type    Optional. Accepts project or post for use in the portfolio
 *   and blog.
 * @since 1.0
 */
if( ! function_exists( 'bramble_filter_nav' ) ) :
	function bramble_filter_nav( $post_type = 'project' ) {

		if( 'project' == $post_type )
			$tax = 'skill';
		else
			$tax = 'category';

		$args = array(
			'taxonomy'     => $tax,
			'orderby'      => 'slug',
			'hide_empty'   => 1
		);

		$categories = get_categories( $args );

		//Display FilterNav only if there is more than one skill

		if( sizeof( $categories ) > 0 ) { ?>
			<ul id="filter-nav" class="clearfix">
				<li class="all-btn"><a href="#" data-filter="*" class="selected"><?php _e( 'All', 'bramble' ); ?></a></li>
				<?php
				foreach( $categories as $pcat ) {

					$output = sprintf( '<li><a href="#" data-filter=".%1$s">%2$s</a></li>%3$s',
							esc_attr( $pcat->slug ),
							ucfirst( esc_attr( $pcat->name ) ),
							"\n"
						);

					echo $output;

				} // foreach

				?>
			</ul>
		<?php
		} // if

	} // bramble_filter_nav
endif;


/**
 * Store the skills in the $ttrust_config global array for filtering the portfolio
 *
 * @param str $post_type
 *
 * @return mixed $ttrust_config Global, which in the case stores the skills
 * @since 1.0
 */
if( ! function_exists( 'bramble_get_skills' ) ) :
	function bramble_get_skills( $post, $post_type = 'project' ){

		global $ttrust_config;

		if( 'post' == $post_type )
			$tax = 'category';
		else
			$tax = 'skill';

        // Zero all variables each time function is run
		$ttrust_config['isotope_terms'] = array();
        $ttrust_config['isotope_names'] = array();
        $ttrust_config['isotope_class'] = '';

		$terms = get_the_terms( $post->ID, $tax );

		if ( $terms ) {
			foreach ( $terms as $term ) {
				$ttrust_config['isotope_terms'][] = $term->slug;
                $ttrust_config['isotope_names'][] = $term->name;
			}

            $ttrust_config['isotope_class'] = implode(' ', $ttrust_config['isotope_terms']);
		}

		return $ttrust_config;

	} // bramble_get_skills
endif;


/**
 * Generate the project thumb title for the portfolio masonry view
 *
 * @since 1.0
 */
 if( ! function_exists( 'bramble_the_thumb_title' ) ) :
	 function bramble_the_thumb_title(){

		 global $ttrust_config; // Grabs the isotope classes
		 $skills_ucfirst    = array();

		 if( ! empty( $ttrust_config['isotope_names'] ) )
			 $skills = $ttrust_config['isotope_names'];

		 // Begin building the string with the project title
		 $output = the_title( '<h2 class="entry-title">', "</h2>\n" );

		 // Add skills if there are any
		 if( ! empty( $skills ) ) {

			 $output .= "\n<h3>";

			 foreach( $skills as $skill ){
				 $skills_ucfirst[] = ucfirst( esc_attr( $skill ) );
			 }

			 $output .= implode(', ', $skills_ucfirst );

			 $output .= "</h3>";

		 } // if

		 echo $output;

	 } // bramble_the_thumb_title
 endif;

/**
 * Generate list of skill for project thumbnails.
 *
 * @since 1.0
 */
 if( ! function_exists( 'bramble_the_thumb_skills()' ) ) :
	 function bramble_the_thumb_skills(){

		 global $ttrust_config; // Grabs the isotope classes
		 $skills_ucfirst    = array();

		 if( ! empty( $ttrust_config['isotope_names'] ) )
			 $skills = $ttrust_config['isotope_names'];

		 $output = "";

		 // Add skills if there are any
		 if( ! empty( $skills ) ) {

			 foreach( $skills as $skill ){
				 $skills_ucfirst[] = ucfirst( esc_attr( $skill ) );
			 }

			 $output .= implode(', ', $skills_ucfirst );

		 } // if

		 echo $output;

	 } // bramble_the_thumb_title
 endif;


/* Social Sharing Links */

if (!function_exists('bramble_social_sharing')) {

    function bramble_social_sharing() {
					$show_facebook = get_theme_mod( 'bramble_show_facebook', 'yes' );
					$show_twitter = get_theme_mod( 'bramble_show_twitter', 'yes' );
					$show_google = get_theme_mod( 'bramble_show_google', 'yes' );
					$show_linkedin = get_theme_mod( 'bramble_show_linkedin', 'yes' );
					$show_pinterest = get_theme_mod( 'bramble_show_pinterest', 'yes' );
					$show_tumblr = get_theme_mod( 'bramble_show_tumblr', 'yes' );
        			$html = '';
                    $html .= '<div class="social-sharing">';
                    $html .= '<ul>';

                    if ($show_facebook == "yes") {
                        $html .= '<li class="facebook-share">';
                        $html .= '<a title="' . __("Share on Facebook", "bramble") . '" href="#" onclick="window.open(\'http://www.facebook.com/sharer.php?s=100&amp;p[title]=' . urlencode(get_the_title()) . '&amp;p[summary]=' . urlencode(get_the_excerpt()) . '&amp;p[url]=' . urlencode(get_permalink()) . '&amp;p[images][0]=';
                        if (function_exists('the_post_thumbnail')) {
                            $html .= wp_get_attachment_url(get_post_thumbnail_id());
                        }
                        $html .='\', \'sharer\', \'toolbar=0,status=0,width=620,height=280\');">';
                        $html .= '<i class="fa fa-facebook"></i>';
                        $html .= "</a>";
                        $html .= "</li>";
                    }

                    if ($show_twitter == "yes") {
                        $html .= '<li class="twitter-share">';
                        $html .= '<a href="#" title="' . __("Share on Twitter", 'bramble') . '" onclick="popUp=window.open(\'http://twitter.com/home?status=' . urlencode(mb_strlen(get_permalink())) . get_permalink() . '\', \'popupwindow\', \'scrollbars=yes,width=800,height=400\');popUp.focus();return false;">';
                        $html .= '<i class="fa fa-twitter"></i>';
                        $html .= "</a>";
                        $html .= "</li>";
                    }

                    if ($show_google == "yes") {
                        $html .= '<li  class="google-share">';
                        $html .= '<a href="#" title="' . __("Share on Google+", "bramble") . '" onclick="popUp=window.open(\'https://plus.google.com/share?url=' . urlencode(get_permalink()) . '\', \'popupwindow\', \'scrollbars=yes,width=800,height=400\');popUp.focus();return false">';
                        $html .= '<i class="fa fa-google-plus"></i>';
                        $html .= "</a>";
                        $html .= "</li>";
                    }

                    if ($show_linkedin == "yes") {
                        $html .= '<li  class="linkedin-share">';
                        $html .= '<a href="#" class="' . __("Share on LinkedIn", "bramble") . '" onclick="popUp=window.open(\'http://linkedin.com/shareArticle?mini=true&amp;url=' . urlencode(get_permalink()) . '&amp;title=' . urlencode(get_the_title()) . '\', \'popupwindow\', \'scrollbars=yes,width=800,height=400\');popUp.focus();return false">';
						$html .= '<i class="fa fa-linkedin"></i>';
                        $html .= "</a>";
                        $html .= "</li>";
                    }

                    if (isset($edgt_options['enable_tumblr']) && $edgt_options['enable_tumblr'] == "yes") {
                        $html .= '<li  class="tumblr_share">';
                        $html .= '<a href="#" title="' . __("Share on Tumblr", "edgt") . '" onclick="popUp=window.open(\'http://www.tumblr.com/share/link?url=' . urlencode(get_permalink()) . '&amp;name=' . urlencode(get_the_title()) . '&amp;description=' . urlencode(get_the_excerpt()) . '\', \'popupwindow\', \'scrollbars=yes,width=800,height=400\');popUp.focus();return false">';
                        $html .= '<i class="fa fa-tumblr"></i>';
                        $html .= "</a>";
                        $html .= "</li>";
                    }

                    if ($show_pinterest == "yes") {
                        $html .= '<li  class="pinterest-share">';
                        $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                        $html .= '<a href="#" title="' . __("Share on Pinterest", "bramble") . '" onclick="popUp=window.open(\'http://pinterest.com/pin/bramble/button/?url=' . urlencode(get_permalink()) . '&amp;description=' . get_the_title() . '&amp;media=' . urlencode($image[0]) . '\', \'popupwindow\', \'scrollbars=yes,width=800,height=400\');popUp.focus();return false">';
                       	$html .= '<i class="fa fa-pinterest"></i>';
                        $html .= "</a>";
                        $html .= "</li>";
                    }

                    $html .= '</ul>'; //close ul
                    $html .= '</div>'; //close div.social_share_list_holder
 
        echo $html;
    }
}