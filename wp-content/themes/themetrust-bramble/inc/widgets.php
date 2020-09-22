<?php
/**
 * @package bramble
 */
?>
<?php

global $ttrust_config;
$ttrust_config['name'] = "Bramble";


/**
* Defines widgetized areas
*/

function bramble_register_sidebars() {

	register_sidebar( array(
		'name' 				=> __( 'Sidebar', 'bramble' ),
		'id' 				=> 'sidebar',
		'description' 		=> __( 'This is the widget area for blog posts.', 'bramble' ),
		'before_widget' 	=> '<div id="%1$s" class="widget-box widget %2$s"><div class="inside">',
		'after_widget' 		=> '</div></div>',
		'before_title' 		=> '<h3 class="widget-title">',
		'after_title' 		=> '</h3>'
	) );
	
	register_sidebar( array(
		'name' => 'Shop Sidebar',
		'id' => 'sidebar_shop',
		'description' 		=> __( 'This is the widget area for shop pages.', 'bramble' ),
		'before_widget' 	=> '<div id="%1$s" class="widget-box widget %2$s"><div class="inside">',
		'after_widget' 		=> '</div></div>',
		'before_title' 		=> '<h3 class="widget-title">',
		'after_title' 		=> '</h3>'
	));

	register_sidebar( array(
		'name' 				=> __( 'Slide Panel', 'bramble' ),
		'id' 				=> 'slide_panel_mobile',
		'description' 		=> __( 'This is the widget area for the mobile slide panel.', 'bramble' ),
		'before_widget' 	=> '<div id="%1$s" class="widget-box widget %2$s"><div class="inside">',
		'after_widget' 		=> '</div></div>',
		'before_title' 		=> '<h3 class="widget-title">',
		'after_title' 		=> '</h3>'
	) );
	
	register_sidebar( array(
		'name' 				=> __( 'Header', 'bramble' ),
		'id' 				=> 'header_sidebar',
		'description' 		=> __( 'This is the widget area for the header.', 'bramble' ),
		'before_widget' 	=> '<div id="%1$s" class="widget-box widget %2$s"><div class="inside">',
		'after_widget' 		=> '</div></div>',
		'before_title' 		=> '<h3 class="widget-title">',
		'after_title' 		=> '</h3>'
	) );
	
	register_sidebar( array(
		'name' 				=> __( 'Footer', 'bramble' ),
		'id' 				=> 'footer',
		'description' 		=> __( 'This is the default widget area for the footer.', 'bramble' ),
		'before_widget' 	=> '<div id="%1$s" class="small one-third %2$s footer-box widget-box"><div class="inside">',
		'after_widget' 		=> '</div></div>',
		'before_title' 		=> '<h3 class="widget-title">',
		'after_title' 		=> '</h3>'
	) );

} // bramble_register_sidebars()

add_action( 'widgets_init', 'bramble_register_sidebars' );


if(!function_exists('tt_add_support_custom_sidebar')) {
    /**
     * Add custom sidebars
     */
    function tt_add_support_custom_sidebar() {
        add_theme_support('tt_sidebar');
        if (get_theme_support('tt_sidebar')) new tt_sidebar();
    }

    add_action('after_setup_theme', 'tt_add_support_custom_sidebar');
}


add_action( 'load-widgets.php', 'load_color_picker' );

function load_color_picker() {    
	wp_enqueue_style( 'wp-color-picker' );        
	wp_enqueue_script( 'wp-color-picker' );    
}
?>