<?php
/**
 * @package bramble
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
		<?php if ( 'post' == get_post_type() ) : ?>
			<span class="meta <?php bramble_meta_class(); ?>">
				<?php bramble_the_post_meta(); ?>
				<?php $show_comments = get_theme_mod( 'bramble_show_meta_comments', 'yes' ); ?>
				<?php if($show_comments == 'yes') {?>
					<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
						<span class="comments-link"><?php comments_popup_link( __( 'No Comments', 'bramble' ), __( '1 Comment', 'bramble' ), __( '% Comments', 'bramble' ) ); ?></span>
					<?php endif; ?>
				<?php } ?>
			</span><!-- .entry-meta -->
		<?php endif; ?>

		<?php if(has_post_thumbnail()) : ?>
			<div class="featured-image">
				<a href="<?php the_permalink() ?>" rel="bookmark" ><?php the_post_thumbnail( 'bramble_post_thumb', array( 'class' => 'post-thumb', 'alt' => ''. the_title_attribute( 'echo=0' ) .'', 'title' => ''. the_title_attribute( 'echo=0' ) .'' ) ); ?></a>
			</div>
		<?php endif; ?>

	</header><!-- .entry-header -->

	<?php
		if ( is_search() ) : // Display Excerpts on Option or Search ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	<?php else : ?>
	<div class="entry-content">
		<?php the_excerpt(); ?>
	</div><!-- .entry-content -->
	<?php endif; ?>
	
</article><!-- #post-<?php the_ID(); ?> -->
