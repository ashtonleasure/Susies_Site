<?php
/**
 * Sidebar
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.7.0
 */
?>
<aside class="sidebar clear">	
    <?php	   
	if(is_shop() && is_active_sidebar('sidebar_shop')) : dynamic_sidebar('sidebar_shop');
	elseif(is_product() && is_active_sidebar('sidebar_shop')) : dynamic_sidebar('sidebar_shop');
	elseif(is_product_category() && is_active_sidebar('sidebar_shop')) : dynamic_sidebar('sidebar_shop');
	elseif(is_product_tag() && is_active_sidebar('sidebar_shop')) : dynamic_sidebar('sidebar_shop');	
	endif;
	?>
</aside><!-- end sidebar -->