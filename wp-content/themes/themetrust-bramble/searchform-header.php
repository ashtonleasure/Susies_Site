<?php
/**
 * @package bramble
 */
?>

<form method="get" id="search_form" name="search" action="<?php echo esc_url( home_url( '/' ) ); ?>" />
	<label class="screen-reader-text" for="s"><?php _x( 'Search for:', 'label', 'bramble' ); ?></label>
	<input name="s" type="text" class="search_input" id="hide-a-bar" value="<?php _e( 'Type and press enter to search.', 'bramble' ); ?>" />
	<input type="hidden" id="searchsubmit" value="search" />
</form>