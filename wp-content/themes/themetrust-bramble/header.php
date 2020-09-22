<?php
// @package bramble
global $woocommerce;
$header_position              = get_theme_mod( 'bramble_header_position', 'header-side' );
$slide_bg                     = get_theme_mod( 'bramble_slide_panel_background' );
$header_transparent_bg        = get_theme_mod( 'bramble_slide_panel_background' );
//$header_color_scheme          = get_theme_mod( 'bramble_header_color_scheme', 'dark' );
$show_header_search           = get_theme_mod( 'bramble_enable_header_search' );
$show_slide_panel             = get_theme_mod( 'bramble_enable_slide_panel' );
$header_layout                = get_theme_mod( 'bramble_header_layout', 'wide-header' );
$header_class = "";

//Grab the metabox values
if(!is_archive() && !is_search() && !is_front_page()) {
$id = get_the_ID();
$header_hide = get_post_meta( $id, '_bramble_header_hide', true );
$header_layout_meta = get_post_meta( $id, '_bramble_header_layout', true );
if($header_layout_meta != "default" && $header_layout_meta != $header_layout){ $header_layout = $header_layout_meta; }
$header_transparent_bg = get_post_meta( $id, '_bramble_header_transparent_bg', true );
//$header_color_scheme_metabox = get_post_meta( $id, '_bramble_header_color_scheme', true );
//$header_color_scheme = ($header_color_scheme != $header_color_scheme_metabox) ? $header_color_scheme_metabox : $header_color_scheme;
//if($header_transparent_bg == "yes"){ $header_class .= "transparent "; }
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>

</head>

<body <?php body_class($header_layout); ?>>
	<?php bramble_loader(); ?>
	<?php bramble_scroll_to_top(); ?>
	
	<?php if($show_header_search == "yes") { ?>
	<div id="header-search" class="header-search">
		<span id="search-toggle-close" class="search-toggle close" data-target="header-search" ></span>
		<div class="inside">
			<div class="form-wrap">
			<form role="search" method="get" id="searchform" class="searchform clear" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<?php $search_text = __("Type and press enter to search.", "bramble"); ?> 
				<input type="text" placeholder="<?php echo $search_text; ?>" name="s" id="s" />
			</form>
			
			</div>
		</div>
	</div>
	<?php } ?>
	
	<?php if(!isset($header_hide) || $header_hide != "yes") { ?>
	<!-- Slide Panel -->
	<div id="slide-panel"<?php if( $slide_bg ){ echo ' style="background-image: url(' . $slide_bg . ');"'; } ?>>
		<div class="hidden-scroll">
			<div class="inner <?php if(has_nav_menu('slide_panel_mobile')) echo 'has-mobile-menu'; ?>">	
				<?php wp_nav_menu( array(
					'container'			=> 'nav',
					'container_id'		=> 'slide-main-menu',
					'menu_class'        => 'collapse sidebar',
					'theme_location'	=> 'slide_panel',
					'fallback_cb' 		=> 'bramble_slide_nav'
				) ); ?>
				
				<?php wp_nav_menu( array(
					'container'			=> 'nav',
					'container_id'		=> 'slide-mobile-menu',
					'menu_class'        => 'collapse sidebar',
					'theme_location'	=> 'slide_panel_mobile',
					'fallback_cb' 		=> 'bramble_slide_nav',
					'menu' => get_post_meta( $id, '_bramble_header_menu_mobile', true)
				) ); ?>

				<?php if ( is_active_sidebar( 'slide_panel_mobile' ) ) : ?>
					<div class="widget-area mobile" role="complementary">
						<?php dynamic_sidebar( 'slide_panel_mobile' ); ?>
					</div><!-- .widget-area-mobile -->
				<?php endif; ?>
			</div><!-- .inner -->
		</div>
		<span id="menu-toggle-close" class="menu-toggle right close slide" data-target="slide-panel"><span></span></span>
	</div><!-- /slide-panel-->	
	<?php } ?>
	
	
<div id="site-wrap">

	
	<?php if(!isset($header_hide) || $header_hide != "yes") { ?>
	<header id="site-header" class="<?php echo $header_class; ?>">
		<div class="inside clearfix">
			<?php $logo_head_tag = ( is_front_page() ) ? "h1" : "h2"; ?>
			
			<?php //Grab the logos 
			if($header_layout != "narrow-header"){
				$ttrust_logo = get_theme_mod( 'bramble_logo' ); 
			}else{
				$ttrust_logo = get_theme_mod( 'bramble_logo_small' ); 
			}
			$ttrust_logo_mobile = get_theme_mod( 'bramble_logo_mobile' ); 
			?>

			<div id="logo" class="<?php if( $ttrust_logo_mobile ) echo 'has-mobile'; ?>">
				<?php if( $ttrust_logo ) { ?>
					<<?php echo $logo_head_tag; ?> class="site-title"><a href="<?php bloginfo('url'); ?>"><img src="<?php echo $ttrust_logo; ?>" alt="<?php bloginfo('name'); ?>" /></a></<?php echo $logo_head_tag; ?>>
				<?php } else { ?>
					<<?php echo $logo_head_tag; ?> class="site-title text"><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></<?php echo $logo_head_tag; ?>>
				<?php } ?>
				
				<?php if( $ttrust_logo_mobile ) { ?>
					<<?php echo $logo_head_tag; ?> class="site-title mobile"><a href="<?php bloginfo('url'); ?>"><img src="<?php echo $ttrust_logo_mobile; ?>" alt="<?php bloginfo('name'); ?>" /></a></<?php echo $logo_head_tag; ?>>
				<?php } ?>
			</div>

			<div class="main-nav woocommerce">

				<?php wp_nav_menu( array(
					'container'			=> 'nav',
					'container_id'		=> 'main-menu',
					'menu_class' 		=> 'sf-menu sf-vertical',
					'theme_location'	=> 'primary',
					'fallback_cb' 		=> 'bramble_main_nav',
					'menu' => get_post_meta( $id, '_bramble_header_menu_main', true)
				) ); ?>
				
			</div>
			
			<div class="secondary-nav clearfix">
				
				<?php if($woocommerce) { ?>
				<a class="cart-icon open" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'bramble'); ?>">
				<?php if($woocommerce->cart->cart_contents_count > 0){?>
				<span class="cart-count"><?php echo $woocommerce->cart->cart_contents_count; ?></span>
				<?php } ?>
				</a>
				<?php } ?>
				
				<?php if($show_header_search == "yes") { ?>
				<span id="search-toggle-open" class="search-toggle right open" data-target="header-search" ></span>
				<?php } ?>
				
				<span id="menu-toggle-open" class="menu-toggle right open slide <?php if($show_slide_panel == "yes") echo 'constant'; ?>" data-target="slide-menu" ></span>
				
			
			</div>
			
			<?php if ( is_active_sidebar( 'header_sidebar' ) ) : // The sidebar in the side header ?>
				<div id="widget-area" class="widget-area" role="complementary">
					<?php dynamic_sidebar( 'header_sidebar' ); ?>
				</div><!-- .widget-area -->
			<?php endif; ?>
			
		</div>

	</header><!-- #site-header -->
	<?php } ?>
	

<div id="main-container">
	<div id="middle">