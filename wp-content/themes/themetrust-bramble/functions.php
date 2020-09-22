<?php
/*
@package bramble

 * 	Bramble by ThemeTrust © 2015
 *   =====================================================
 *	 1. 	Theme Setup
 *	 	1.1		Content Width
 *	 	1.2		Bramble_Setup
 *		1.3		Required Plugins
 *	 2. 	Header
 *	 	2.1		Bramble Scripts
 *		2.2		Customizer Head
 *	 3. Includes
 *		3.1		Template Tags
 *		3.2		Extra Functions
 *		3.3		Customizer Additions
 *		3.4		Jetpack Compatibility
 *		3.5		Widgets
 *
 */

//////////////////////////////////////////////////////////////
// 1. Theme Setup
/////////////////////////////////////////////////////////////

//	1.1 Content Width
if ( ! isset( $content_width ) ) {
	$content_width = 1200; /* This will have to be overridden. */
}

//	1.2 bramble_Setup
if ( ! function_exists( 'bramble_setup' ) ) :
	function bramble_setup() {

		// 1.2.1 Set Globals & Variables
		global $ttrust_config;
		
		$ttrust_config['theme'] 		= 'bramble ';
		$ttrust_config['version']		= '1.0';

		// 1.2.2 Make theme available for translation.
		load_theme_textdomain( 'bramble', get_template_directory() . '/languages' );

		// 1.2.3 Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// 1.2.4 Add support for thumbnails
		add_theme_support( 'post-thumbnails' );

		// Add Post Image Sizes
		add_image_size( 'bramble_thumb_square', 700, 700, true );
		add_image_size( 'bramble_thumb_landscape', 800, 600, true );
		add_image_size( 'bramble_thumb_portrait', 600, 800, true );
		add_image_size( 'bramble_thumb_wide', 1000, 500, true );
		add_image_size( 'bramble_thumb_tall', 500, 1000, true );
		add_image_size( 'bramble_thumb_wide_tall', 1000, 1000, true );

		// 1.2.5 This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => __( 'Main Menu', 'bramble' ),
			'slide_panel' => __( 'Slide Panel Desktop', 'bramble' ),
			'slide_panel_mobile' => __( 'Slide Panel Mobile', 'bramble' ),
			'left' => __( 'Left Menu (Split Header)', 'bramble' )
		) );
		
		// 1.2.6 Enable support for Custom Backgrounds
		// only enabled if layout mode is boxed.
		if(get_theme_mod( 'bramble_site_width' ) == "boxed"){
			add_theme_support( 'custom-background' );
		}
		
		// 1.2.6 Enable support for Post Formats (currently disabled).
		//add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );
		
		// 1.2.7 Load theme custom post types
		load_template( get_template_directory() . '/inc/class-portfolio-cpt.php', true );
		$portfolio_cpt = new Portfolio_CPT( 'bramble' ); // Sending in the textdomain
		$portfolio_cpt->project_init();
		$portfolio_cpt->skills_init();
		
		load_template( get_template_directory() . '/inc/class-testimonial-cpt.php', true );
		$testimonial_cpt = new Testimonial_CPT( 'bramble' ); // Sending in the textdomain
		$testimonial_cpt->testimonial_init();


		// 1.2.11 Enable support for HTML5 markup.
		add_theme_support( 'html5', array(
			'comment-list',
			'search-form',
			'comment-form',
			'gallery',
			'caption',
		) );

        // Add WooCommerce Support
        add_theme_support( 'woocommerce' );

		// 1.2.12 Add Menus
	
		// 1.2.3 Add custom Page Builder functions
		load_template( get_template_directory() . '/inc/custom-page-builder.php', true );
		
		// 1.2.4 Add custom Page Builder Widgets
		load_template( get_template_directory() . '/inc/page-builder-widgets/woocommerce-products.php', true );
		load_template( get_template_directory() . '/inc/page-builder-widgets/portfolio.php', true );
		load_template( get_template_directory() . '/inc/page-builder-widgets/testimonials.php', true );
		load_template( get_template_directory() . '/inc/page-builder-widgets/blog.php', true );
		load_template( get_template_directory() . '/inc/page-builder-widgets/spacer.php', true );
		load_template( get_template_directory() . '/inc/page-builder-widgets/so-price-table-widget/so-price-table-widget.php', true );
		
		// 1.2.4.1 Add custom sidebars
		load_template( get_template_directory() . '/inc/custom-sidebars.php', true );
		
		// 1.2.5 Enable shortcodes in text widget
		add_filter('widget_text', 'do_shortcode');
		
		// 1.2.6 Metaboxes
		load_template( get_template_directory() . '/inc/metaboxes.php', true );
		
		// 1.2.7 Add custom body and post classes
	
		function bramble_body_class($classes) {
				global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
				        if($is_lynx) $classes[] = 'lynx';
				        elseif($is_gecko) $classes[] = 'gecko';
				        elseif($is_opera) $classes[] = 'opera';
				        elseif($is_NS4) $classes[] = 'ns4';
				        elseif($is_safari) $classes[] = 'safari';
				        elseif($is_chrome) $classes[] = 'chrome';
				        elseif($is_IE) {
				                $classes[] = 'ie';
				                if(preg_match('/MSIE ([0-9]+)([a-zA-Z0-9.]+)/', $_SERVER['HTTP_USER_AGENT'], $browser_version))
				                $classes[] = 'ie'.$browser_version[1];
				        } else $classes[] = 'unknown';
				        if($is_iphone) $classes[] = 'iphone';
				        if ( stristr( $_SERVER['HTTP_USER_AGENT'],"mac") ) {
				                 $classes[] = 'osx';
				           } elseif ( stristr( $_SERVER['HTTP_USER_AGENT'],"linux") ) {
				                 $classes[] = 'linux';
				           } elseif ( stristr( $_SERVER['HTTP_USER_AGENT'],"windows") ) {
				                 $classes[] = 'windows';
				           }
			
			
		        $site_container = get_theme_mod( 'bramble_site_width', '' );
				$header_position = 'side-header';
				$header_sticky = get_theme_mod( 'bramble_sticky_header', '' );				
		        $classes[] = $site_container;
				$classes[] = $header_position;	
				$classes[] = $header_sticky;	
		        return $classes;
		}
		add_filter('body_class', 'bramble_body_class');
		
		

		function bramble_post_class( $classes ) {
			global $post;
			$full_width_content = get_post_meta( $post->ID, '_bramble_post_full_width', true );
			if($full_width_content=='yes'){
				$classes[] = "full";
			}
			return $classes;
		}
		add_filter( 'post_class', 'bramble_post_class' );
		

	} // bramble_setup()
endif; // if()

add_action( 'after_setup_theme', 'bramble_setup' );


// 1.3 Required Plugins

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once dirname( __FILE__ ) . '/inc/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'my_theme_register_required_plugins' );


function my_theme_register_required_plugins() {

	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
		array(
			'name'     => 'Slider Revolution', // The plugin name
			'slug'     => 'revslider', // The plugin slug (typically the folder name)
			'source'   => get_stylesheet_directory() . '/inc/plugins/revslider.zip', // The plugin source
			'required' => false,
		),
		array(
			'name' => 'Page Builder by SiteOrigin',
			'slug' => 'siteorigin-panels',
			'required' => true,
		),
		array(
			'name' => 'Page Builder Widgets Bundle',
			'slug' => 'so-widgets-bundle',
			'required' => true,
		),
		array(
			'name' => 'One Click Demo Import',
			'slug' => 'one-click-demo-import',
			'required' => false,
		),
		array(
			'name' => 'Contact Form 7',
			'slug' => 'contact-form-7',
		),
		array(
			'name' => 'WooCommerce',
			'slug' => 'woocommerce',
		),
	);

	$theme_text_domain = 'bramble';

	/**
	 * Array of configuration settings. Uncomment and amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * uncomment the strings and domain.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		/*'domain'       => $theme_text_domain,         // Text domain - likely want to be the same as your theme. */
		/*'default_path' => '',                         // Default absolute path to pre-packaged plugins */
		/*'menu'         => 'install-my-theme-plugins', // Menu slug */
		'strings'      	 => array(
			/*'page_title'             => __( 'Install Required Plugins', $theme_text_domain ), // */
			/*'menu_title'             => __( 'Install Plugins', $theme_text_domain ), // */
			/*'instructions_install'   => __( 'The %1$s plugin is required for this theme. Click on the big blue button below to install and activate %1$s.', $theme_text_domain ), // %1$s = plugin name */
			/*'instructions_activate'  => __( 'The %1$s is installed but currently inactive. Please go to the <a href="%2$s">plugin administration page</a> page to activate it.', $theme_text_domain ), // %1$s = plugin name, %2$s = plugins page URL */
			/*'button'                 => __( 'Install %s Now', $theme_text_domain ), // %1$s = plugin name */
			/*'installing'             => __( 'Installing Plugin: %s', $theme_text_domain ), // %1$s = plugin name */
			/*'oops'                   => __( 'Something went wrong with the plugin API.', $theme_text_domain ), // */
			/*'notice_can_install'     => __( 'This theme requires the %1$s plugin. <a href="%2$s"><strong>Click here to begin the installation process</strong></a>. You may be asked for FTP credentials based on your server setup.', $theme_text_domain ), // %1$s = plugin name, %2$s = TGMPA page URL */
			/*'notice_cannot_install'  => __( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', $theme_text_domain ), // %1$s = plugin name */
			/*'notice_can_activate'    => __( 'This theme requires the %1$s plugin. That plugin is currently inactive, so please go to the <a href="%2$s">plugin administration page</a> to activate it.', $theme_text_domain ), // %1$s = plugin name, %2$s = plugins page URL */
			/*'notice_cannot_activate' => __( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', $theme_text_domain ), // %1$s = plugin name */
			/*'return'                 => __( 'Return to Required Plugins Installer', $theme_text_domain ), // */
		),
	);

	tgmpa( $plugins, $config );
}



/**
 * Loader Animation
 */
if( !function_exists( 'bramble_loader' ) ){
function bramble_loader(){
	$loader_enabled = get_theme_mod( 'bramble_loader_enabled', 'no' );
	if($loader_enabled == 'yes'){
	$loader_animation = get_theme_mod( 'bramble_loader_animation', 'rotating-plane' );

	echo '<div id="loader-container">';
	switch($loader_animation) {
		case "rotating-plane":
			echo '<div id="loader-icon" class="sk-spinner sk-spinner-rotating-plane"></div>';
			break;
		case "double-bounce":
			echo '<div id="loader-icon" class="sk-spinner sk-spinner-double-bounce">
				  <div class="sk-double-bounce1"></div>
				  <div class="sk-double-bounce2"></div>
				  </div>';
			break;
		case "wave":
			echo '<div id="loader-icon" class="sk-spinner sk-spinner-wave">
			      <div class="sk-rect1"></div>
			      <div class="sk-rect2"></div>
			      <div class="sk-rect3"></div>
			      <div class="sk-rect4"></div>
			      <div class="sk-rect5"></div>
			      </div>';
			break;
		case "wandering-cubes":
			echo '<div id="loader-icon" class="sk-spinner sk-spinner-wandering-cubes">
			      <div class="sk-cube1"></div>
			      <div class="sk-cube2"></div>
			    </div>';
			break;
		case "wandering-cubes":
			echo '<div id="loader-icon" class="sk-spinner sk-spinner-wandering-cubes">
				  <div class="sk-cube1"></div>
				  <div class="sk-cube2"></div>
				  </div>';
			break;
		case "pulse":
			echo '<div id="loader-icon" class="sk-spinner sk-spinner-pulse"></div>';
			break;
		
	}
	echo '<div id="loader-screen"></div>';		
	echo '</div>';
	}	
}
} //if()


/**
 * Scroll to top
 */
if( !function_exists( 'bramble_scroll_to_top' ) ){
function bramble_scroll_to_top(){
	$scroll_to_top_enabled = get_theme_mod( 'bramble_enable_header_scroll_to_top', 'yes' );
	if($scroll_to_top_enabled == 'yes'){
		echo '<div id="scroll-to-top"><span></span></div>';
	}
}
}

/**
 * Gets the correct paged value
 */
if( !function_exists( 'bramble_get_paged_corrected' ) ){
function bramble_get_paged_corrected(){
	global $paged;
	if ( get_query_var('paged') ) { $paged = get_query_var('paged'); }
	elseif ( get_query_var('page') ) { $paged = get_query_var('page'); }
	else { $paged = 1; }
}
add_action( 'pre_get_posts', 'bramble_get_paged_corrected' ); 
} //if()

/**
 * Add the small class to blog posts when using the homepage template
 *
 * @param array $classes
 * @return array $classes
 */
if( !function_exists( 'bramble_small_class' ) ){
function bramble_small_class( $classes ) {

    if( ! is_page_template( 'template-home.php' ) )
        return $classes;

    $classes[] = 'small';

    return $classes;

}

    add_filter( 'post_class', 'bramble_small_class' );
} //if()

//////////////////////////////////////////////////////////////
// 2. Header
/////////////////////////////////////////////////////////////

// 2.1 Bramble Scripts
if ( ! function_exists( 'bramble_scripts_n_styles' ) ) {
	function bramble_scripts_n_styles() {

		// 2.1.1  CSS
		wp_enqueue_style( 'bramble-style', get_stylesheet_uri(), false );
		wp_enqueue_style( 'bramble-owl-carousel', get_template_directory_uri() . '/css/owl.carousel.css', false, '1.3.3', 'all' );
		wp_enqueue_style( 'bramble-owl-theme', get_template_directory_uri() . '/css/owl.theme.css', false, '1.3.3', 'all' );
		wp_enqueue_style( 'bramble-prettyphoto', get_template_directory_uri() . '/css/prettyPhoto.css', false, '3.1.6', 'all' );
		wp_enqueue_style( 'superfish', get_template_directory_uri() . '/css/superfish.css', false, '1.7.5', 'all' );
		wp_enqueue_style( 'bramble-owl-theme', get_template_directory_uri() . '/css/owl.theme.css', false, '1.3.3', 'all' );
		wp_enqueue_style( 'bramble-woocommerce', get_template_directory_uri() . '/css/woocommerce.css', false, '1.0', 'all' );
		
		$loader_anmation = get_theme_mod( 'bramble_loader_animation', 'rotating-plane' );
		$loader_enabled = get_theme_mod( 'bramble_loader_enabled', 'yes' );
		if($loader_enabled=="yes"){
			wp_enqueue_style( 'bramble-loader-main', get_template_directory_uri() . '/css/loaders/spinkit.css', false, '1.0', 'all' );
			wp_enqueue_style( 'bramble-loader-animation', get_template_directory_uri() . '/css/loaders/'.$loader_anmation.'.css', false, '1.0', 'all' );
		}

		// 2.1.2  Fonts
		wp_enqueue_style( 'bramble-font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css', false, '4.0.3', 'all' );
		wp_enqueue_style( 'bramble-linearicons', 'https://cdn.linearicons.com/free/1.0.0/icon-font.min.css', false, '4.0.3', 'all' );

		// 2.1.3  Scripts
		wp_enqueue_script( 'bramble-jquery-actual', get_template_directory_uri().'/js/jquery.actual.js', array( 'jquery' ), '1.0.16', true );

		// Others
		//wp_enqueue_script( 'smoothscroll', get_bloginfo( 'template_url' ) . '/js/smoothscroll.js', array( 'jquery' ), '0.9.9', true );
		wp_enqueue_script( 'hoverIntent', get_bloginfo( 'template_url' ) . '/js/hoverIntent.js', array( 'jquery' ), '1.7.5', true );
		wp_enqueue_script( 'superfish', get_bloginfo( 'template_url' ) . '/js/superfish.js', array( 'jquery' ), '1.7.5', true );
		wp_enqueue_script( 'bramble-wait-for-images', get_bloginfo( 'template_url' ) . '/js/jquery.waitforimages.min.js', array( 'jquery' ), '2.0.2', true );
		
		wp_register_script( 'bramble-parallax-scroll', get_bloginfo( 'template_url' ) . '/js/jquery.parallax-scroll.js', array( 'jquery' ), '1.0.0', true );
		
		wp_enqueue_script( 'bramble-backstretch', get_bloginfo( 'template_url' ) . '/js/jquery.backstretch.js', array( 'jquery' ), '1.0', true );
		wp_enqueue_script( 'bramble-owl', get_bloginfo( 'template_url' ) . '/js/owl.carousel.min.js', array( 'jquery' ), '1.3.3', true );
		wp_enqueue_script( 'bramble-isotope', get_bloginfo( 'template_url' ) . '/js/jquery.isotope.js', array( 'jquery' ), '1.5.25', true );
		wp_enqueue_script( 'bramble-fitvids', get_template_directory_uri() . '/js/jquery.fitvids.js', array( 'jquery' ), '1.0', true );
		wp_enqueue_script( 'bramble-scrollto', get_template_directory_uri() . '/js/jquery.scrollTo.js', array( 'jquery' ), '1.4.6', true );
		wp_enqueue_script( 'bramble-prettyphoto', get_template_directory_uri() . '/js/jquery.prettyPhoto.js', array( 'jquery' ), '3.1.6', true );
		wp_register_script( 'bramble-constellation', get_bloginfo( 'template_url' ) . '/js/constellation.js', array( 'jquery' ), '1.0', true );
		wp_enqueue_script( 'bramble-theme_trust_js', get_template_directory_uri() . '/js/theme_trust.js', array( 'jquery' ), '1.0', true );
		
		global $woocommerce;
		$id = get_the_ID();
		if($woocommerce){
			if( is_shop() || is_product_category() ) { // if we're on a shop page, grab the shop page id
				$id = get_option( 'woocommerce_shop_page_id' );
			}
		}else{
			$id = get_the_ID();
		}	
		
		if(get_post_meta( $id, '_bramble_title_parallax', true ) == "yes"){
			wp_enqueue_script( 'bramble-parallax-scroll');
		}
		
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
			wp_enqueue_script( 'comment-reply' );

	} // bramble_scripts_n_styles()
} // if()

add_action( 'wp_enqueue_scripts', 'bramble_scripts_n_styles' );


//	2.2 Customizer Head
if ( ! function_exists( 'bramble_theme_head' ) ) {
	function bramble_theme_head() { ?>
		<?php if (get_theme_mod('bramble_favicon') ) : ?>
			<link rel="shortcut icon" href="<?php echo get_theme_mod('bramble_favicon'); ?>" />
		<?php endif; ?>
		<meta name="generator" content="<?php global $ttrust_config; echo $ttrust_config['theme'] . ' ' . $ttrust_config['version']; ?>" />

		<!--[if IE 8]>
		<link rel="stylesheet" href="<?php bloginfo( 'template_url' ); ?>/css/ie8.css" type="text/css" media="screen" />
		<![endif]-->
		<!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

		<?php

		//Color
		$color = array();
		$color['accent'] 		    = get_theme_mod( 'bramble_accent_color' );
		$color['base_text'] 		= get_theme_mod( 'bramble_base_text_color' );
		$color['content_background']= get_theme_mod( 'bramble_content_background_color' );
		$color['link'] 			    = get_theme_mod( 'bramble_link_color' );
		$color['link_hover'] 	    = get_theme_mod( 'bramble_link_hover_color' );
		$color['button'] 			= get_theme_mod( 'bramble_button_color' );
		$color['button_text'] 		= get_theme_mod( 'bramble_button_text_color' );
		$color['header_bkg'] 	    = get_theme_mod( 'bramble_header_bkg_color' );
		$color['header_sticky_bkg'] = get_theme_mod( 'bramble_sticky_header_bkg_color' );
		$color['header_accent'] 	= get_theme_mod( 'bramble_header_accent_color' );
		$color['main_menu']         = get_theme_mod( 'bramble_main_menu_color' );
		$color['main_menu_hover']   = get_theme_mod( 'bramble_main_menu_hover_color' );
		$color['sticky_main_menu']  = get_theme_mod( 'bramble_sticky_main_menu_color' );
		$color['sticky_main_menu_hover'] = get_theme_mod( 'bramble_sticky_main_menu_hover_color' );
		$color['site_title'] = get_theme_mod( 'bramble_site_title_color' );
		$color['sticky_site_title'] = get_theme_mod( 'bramble_sticky_site_title_color' );
		$color['loader'] = get_theme_mod( 'bramble_loader_color' );
		$color['loader_bkg'] = get_theme_mod( 'bramble_loader_bkg_color' );
		$color['drop_down_bg'] = get_theme_mod( 'bramble_drop_down_bg_color' );
		$color['drop_down_link'] = get_theme_mod( 'bramble_drop_down_link_color' );
		$color['drop_down_link_hover'] = get_theme_mod( 'bramble_drop_down_link_hover_color' );
		$color['drop_down_divider'] = get_theme_mod( 'bramble_drop_down_divider_color' );
		$color['slide_panel_bg'] = get_theme_mod( 'bramble_slide_panel_bg_color' );
		$color['slide_panel_text'] = get_theme_mod( 'bramble_slide_panel_text_color' );
		$color['slide_panel_link'] = get_theme_mod( 'bramble_slide_panel_link_color' );
		$color['slide_panel_link_hover'] = get_theme_mod( 'bramble_slide_panel_link_hover_color' );
		$color['slide_panel_divider'] = get_theme_mod( 'bramble_slide_panel_divider_color' );
		$color['scroll_to_top_bg'] = get_theme_mod( 'bramble_scroll_to_top_bg_color' );
		$color['scroll_to_top_arrow'] = get_theme_mod( 'bramble_scroll_to_top_arrow_color' );
		$color['footer_bg'] = get_theme_mod( 'bramble_footer_bg_color' );
		$color['footer_widget_title'] = get_theme_mod( 'bramble_footer_widget_title_color' );
		$color['footer_text'] = get_theme_mod( 'bramble_footer_text_color' );
		$color['footer_link'] = get_theme_mod( 'bramble_footer_link_color' );
		$color['footer_link_hover'] = get_theme_mod( 'bramble_footer_link_hover_color' );
		$color['product_hover'] = get_theme_mod( 'bramble_product_hover_color' );
		$color['shop_accent'] = get_theme_mod( 'bramble_shop_accent_color' );
		$color['page_title_text_color'] = get_theme_mod( 'bramble_page_title_text_color' );
		$color['page_title_bg_color'] = get_theme_mod( 'bramble_page_title_bg_color' );
		
		//Logo
		$logo_width = array();
		$logo_width['main'] = get_theme_mod( 'bramble_logo_width' );
		$logo_width['small'] = get_theme_mod( 'bramble_logo_small_width' );
		$logo_width['mobile'] = get_theme_mod( 'bramble_logo_mobile_width' );
		
		//Header
		$header = array();
		$header['top_header_height'] = intval(get_theme_mod( 'bramble_top_header_height', 90 )); 
		$header['sticky_header_height'] = intval(get_theme_mod( 'bramble_sticky_header_height', 60 ));
		$header['mobile_breakpoint'] = intval(get_theme_mod( 'bramble_mobile_header_breakpoint' ));
		
		//Page Titles
		$page_title = array();
		$page_title['alignment'] = get_theme_mod( 'bramble_page_title_alignment' );
		
		
		//MetaBox Settings - Page specific settings 
		global $woocommerce;
		if($woocommerce){
			if( is_shop() || is_product_category() ) { // if we're on a shop page, grab the shop page id
				$id = get_option( 'woocommerce_shop_page_id' );
			}else {
				$id = get_the_ID();
			}
		}else{
			$id = get_the_ID();
		}
		
		$pm_site_title_color = get_post_meta( $id, '_bramble_header_site_title_color', true );
		if($pm_site_title_color){
			$color['site_title'] = $pm_site_title_color;
		}
		
		
		$pm_header_bg_color = get_post_meta( $id, '_bramble_header_background_color', true );
		if($pm_header_bg_color){
			$color['header_bkg'] = $pm_header_bg_color;
		}
		
		$pm_header_menu_color = get_post_meta( $id, '_bramble_header_menu_color', true );
		if($pm_header_menu_color){
			$color['main_menu'] = $pm_header_menu_color;
		}
		
		$pm_header_menu_hover_color = get_post_meta( $id, '_bramble_header_menu_hover_color', true );
		if($pm_header_menu_hover_color){ 
			$color['main_menu_hover'] = $pm_header_menu_hover_color;
		} 
		
		//Title
		$title = array();
		$title['height'] = intval(get_post_meta( $id, '_bramble_title_area_height', true )); 
		$title['color'] = get_post_meta( $id, '_bramble_title_color', true );
		$title['bg_img'] = get_post_meta( $id, '_bramble_title_bg_img', true );

		// Colors
		if( $color ){ ?>

		<style>
		
			<?php // Page Title Alignment
			if( $page_title['alignment'] ) { ?>
				body #primary header.main .inner { text-align: <?php echo $page_title['alignment']; ?>; }
			<?php } ?>
			
			<?php // Page Title Text Color
			if( $color['page_title_text_color'] ) { ?>
				body #primary header.main .inner * { color: <?php echo $color['page_title_text_color']; ?>; }
			<?php } ?>
			
			<?php // Page Title Background Color
			if( $color['page_title_bg_color'] ) { ?>
				#primary header.main { background-color: <?php echo $color['page_title_bg_color']; ?>; }
			<?php } ?>
			
			<?php // Base Text Color
			if( $color['base_text'] ) { ?>
			body { color: <?php echo $color['base_text']; ?>; }
			<?php } ?>
			
			<?php // Content Background Color
			if( $color['content_background'] ) { ?>
			.content-area { background-color: <?php echo $color['content_background']; ?>; }
			<?php } ?>

			<?php // Link Color
			if( $color['link'] ) { ?>
			.entry-content a, .entry-content a:visited { color: <?php echo $color['link']; ?>; }
			<?php } ?>

			<?php // Link Color Hover
			if( $color['link_hover'] ) { ?>
			.entry-content a:hover { color: <?php echo $color['link_hover']; ?>; }
			<?php } ?>
			
			<?php // Button Color
			if( $color['button'] ) { ?>
			.button, a.button, a.button:active, a.button:visited, #footer a.button, #searchsubmit, input[type="submit"], a.post-edit-link, a.tt-button, .pagination a, .pagination span, .woocommerce nav.woocommerce-pagination ul li a, .woocommerce nav.woocommerce-pagination ul li span { background-color: <?php echo $color['button']; ?>; }
			<?php } ?>
			
			<?php // Button Text Color
			if( $color['button_text'] ) { ?>
			.button, a.button, a.button:active, a.button:visited, #footer a.button, #searchsubmit, input[type="submit"], a.post-edit-link, a.tt-button, .pagination a, .pagination span, .woocommerce nav.woocommerce-pagination ul li a, .woocommerce nav.woocommerce-pagination ul li span { color: <?php echo $color['button_text']; ?>; }
			<?php } ?>
			
			<?php // Header Background Color
			if( $color['header_bkg'] ) { ?>
			#site-header { background-color: <?php echo $color['header_bkg']; ?> !important; }
			<?php } ?>
			
			<?php // Header Accent Color
			if( $color['header_accent'] ) { ?>
			.cart-count { background-color: <?php echo $color['header_accent']; ?>; }
			<?php } ?>
			
			<?php // Menu Color
			if( $color['main_menu'] ) { ?>
				.main-nav ul li,
				.secondary-nav span,
				.secondary-nav a { color: <?php echo $color['main_menu']; ?>; }
				
			<?php } ?>
			
			<?php // Menu Color Active/Hover
			if( $color['main_menu_hover'] ) { ?>
				.menu-toggle.open:hover,
				.main-nav ul li:hover,
				.main-nav ul li.active,
				.secondary-nav a:hover,
				.secondary-nav span:hover,
				.main-nav ul li.current,
				.main-nav ul li.current-cat,
				.main-nav ul li.current_page_item,
				.main-nav ul li.current-menu-item,
				.main-nav ul li.current-post-ancestor,
				.single-post .main-nav ul li.current_page_parent,
				.main-nav ul li.current-category-parent,
				.main-nav ul li.current-category-ancestor,
				.main-nav ul li.current-portfolio-ancestor,
				.main-nav ul li.current-projects-ancestor,
				.main-nav ul li.current-menu-ancestor { color: <?php echo $color['main_menu_hover']; ?>;}
				
			<?php } ?>
			
			<?php // Site Title Color
			if( $color['site_title'] ) { ?>
				#site-header h1 a, #site-header h2 a { color: <?php echo $color['site_title']; ?>; }
			<?php } ?>
			
			<?php // Sticky Site Title Color
			if( $color['sticky_site_title'] ) { ?>
				#site-header.sticky h1 a, #site-header.sticky h2 a { color: <?php echo $color['sticky_site_title']; ?>; }
			<?php } ?>
			
			<?php // Loader Color
			if( $color['loader'] ) { ?>
				#loader-icon, #loader-icon * { background-color: <?php echo $color['loader']; ?>; }
			<?php } ?>
			
			<?php // Loader Background Color
			if( $color['loader_bkg'] ) { ?>
				#loader-screen { background-color: <?php echo $color['loader_bkg']; ?>; }
			<?php } ?>

			<?php // Drop Down Backgrond Color
			if( $color['drop_down_bg'] ) { ?>
				.main-nav ul.sf-menu li ul { background-color: <?php echo $color['drop_down_bg']; ?>; }
			<?php } ?>
			
			<?php // Drop Down Link Color
			if( $color['drop_down_link'] ) { ?>
				.main-nav ul ul li, .sticky .main-nav ul ul li { color: <?php echo $color['drop_down_link']; ?>; }
			<?php } ?>
			
			<?php // Drop Down Link Hover Color
			if( $color['drop_down_link_hover'] ) { ?>
				.main-nav ul ul li:hover, 
				.sticky .main-nav ul ul li:hover { color: <?php echo $color['drop_down_link_hover']; ?> !important; }
			<?php } ?>
			
			<?php // Drop Down Divider Color
			if( $color['drop_down_divider'] ) { ?>
				.main-nav .mega-menu > ul > li { border-right: 1px solid <?php echo $color['drop_down_divider']; ?>; }
			<?php } ?>
			
			<?php // Slide Panel Background Color
			if( $color['slide_panel_bg'] ) { ?>
				#slide-panel { background-color: <?php echo $color['slide_panel_bg']; ?>; }
			<?php } ?>
			
			<?php // Slide Panel Text
			if( $color['slide_panel_text'] ) { ?>
				#slide-panel * { color: <?php echo $color['slide_panel_text']; ?>; }
			<?php } ?>
			
			<?php // Slide Panel Link
			if( $color['slide_panel_link'] ) { ?>
				#slide-panel a { color: <?php echo $color['slide_panel_link']; ?>; }
				#slide-panel nav li { color: <?php echo $color['slide_panel_link']; ?>; }
				#slide-panel .menu-toggle.close { color: <?php echo $color['slide_panel_link']; ?>; }
			<?php } ?>
			
			<?php // Slide Panel Link Hover
			if( $color['slide_panel_link_hover'] ) { ?>
				#slide-panel a:hover { color: <?php echo $color['slide_panel_link_hover']; ?>; }
				#slide-panel .menu-toggle.close:hover { color: <?php echo $color['slide_panel_link_hover']; ?>; }
			<?php } ?>
			
			<?php // Slide Panel Divider
			if( $color['slide_panel_divider'] ) { ?>
				#slide-panel nav li { border-bottom: 1px solid <?php echo $color['slide_panel_divider']; ?>; }
				#slide-panel nav ul li:last-child { border: none; }
			<?php } ?>
			
			<?php // Scroll to Top Background Color
			if( $color['scroll_to_top_bg'] ) { ?>
				#scroll-to-top { background-color: <?php echo $color['scroll_to_top_bg']; ?>; }
			<?php } ?>
			
			<?php // Scroll to Top Arrow Color
			if( $color['scroll_to_top_arrow'] ) { ?>
				#scroll-to-top { color: <?php echo $color['scroll_to_top_arrow']; ?>; }
			<?php } ?>
			
			<?php // Footer Background Color
			if( $color['footer_bg'] ) { ?>
				#footer { background-color: <?php echo $color['footer_bg']; ?>; }
			<?php } ?>
			
			<?php // Footer Text
			if( $color['footer_text'] ) { ?>
				#footer * { color: <?php echo $color['footer_text']; ?> !important; }
			<?php } ?>
			
			<?php // Footer Widget Title
			if( $color['footer_widget_title'] ) { ?>
				#footer .widget-title { color: <?php echo $color['footer_widget_title']; ?> !important; }
			<?php } ?>
			
			<?php // Footer Link
			if( $color['footer_link'] ) { ?>
				#footer a { color: <?php echo $color['footer_link']; ?> !important; }
			<?php } ?>
			
			<?php // Footer Link Hover
			if( $color['footer_link_hover'] ) { ?>
				#footer a:hover { color: <?php echo $color['footer_link_hover']; ?> !important; }
			<?php } ?>
			
			<?php // Product Hover
			if( $color['product_hover'] ) { ?>
				.products .product .overlay { background-color: <?php echo $color['product_hover']; ?> !important; }
			<?php } ?>
			
			<?php // Shop Accent Color
			if( $color['shop_accent'] ) { ?>
			.product-thumb span.sale, .product-thumb span.onsale,
			.woocommerce .widget_price_filter .ui-slider .ui-slider-handle,.woocommerce-page .widget_price_filter .ui-slider .ui-slider-handle { background-color: <?php echo $color['shop_accent']; ?> ; }
			.star-rating,
			p.stars a,
			p.stars a.star-1:after,
			p.stars a.star-2:after,
			p.stars a.star-3:after,
			p.stars a.star-4:after,
			p.stars a.star-5:after { color: <?php echo $color['shop_accent']; ?> !important; }
			<?php } ?>
			

		<?php } // if($color)
		
		
		if( $logo_width ){ ?>
			
			<?php // Sticky Logo Width Light
			if( $logo_width['main'] ) { ?>
				#site-header #logo .site-title img { max-width: <?php echo intval($logo_width['main']/2); ?>px; }
			<?php } ?>
			
			<?php // Small Logo
			if( $logo_width['small'] ) { ?>
				.narrow-header #site-header #logo .site-title img { max-width: <?php echo intval($logo_width['small']/2); ?>px !important; }
			<?php } ?>
			
			<?php // Small Mobile
			if( $logo_width['mobile'] ) { ?>
				@media only screen and (max-width: 1024px){
					#site-header #logo .site-title.mobile img { max-width: <?php echo intval($logo_width['mobile']/2); ?>px; }
				}
			<?php } ?>
			
		<?php } // if($logo_width) 
		
		
		//Set styles from metabox settings
		
		if( $title ){ ?>
			
			<?php // Title height
			if( $title['height'] && !is_category() && !is_date() && !is_tag() && !is_search()) { ?>
				header.entry-header.main { height: <?php echo $title['height']; ?>px; }
			<?php } ?>
			
			<?php // Title color
			if( $title['color'] && !is_category() && !is_date() && !is_tag() && !is_search()) { ?>
				header.entry-header.main * { color: <?php echo $title['color']; ?> !important; }
			<?php } ?>
			
			<?php // Title background image
			if( $title['bg_img'] && !is_category() && !is_date() && !is_tag() && !is_search()) { ?>
				header.entry-header.main { background: url('<?php echo $title['bg_img']; ?>'); }
			<?php } ?>
			
		<?php }// if($title) 
		
		//Set Header height
		
		if( $header ){ ?>
			<?php // Top Header height
			if( $header['top_header_height'] && is_single()) { ?>
				.inline-header #site-header.main .nav-holder { height: <?php echo $header['top_header_height']; ?>px; }
				.inline-header #site-header.main #logo { height: <?php echo $header['top_header_height']; ?>px; }
				.inline-header #site-header.main .nav-holder,
				.inline-header #site-header.main .main-nav ul > li,
				.inline-header #site-header.main .main-nav ul > li > a,
				#site-header.main .main-nav #menu-main-menu > li > span,
				#site-header.main .secondary-nav a,
				#site-header.main .secondary-nav span  { line-height: <?php echo $header['top_header_height']; ?>px; height: <?php echo $header['top_header_height']; ?>px;}
			<?php } ?>
			
			<?php // Mobile break point
			
			if( $header['mobile_breakpoint'] ) { ?>
				@media only screen and (max-width: <?php echo $header['mobile_breakpoint']; ?>px){
					.main-nav {	display: none !important; }
					#site-header .secondary-nav span.search-toggle.open { display: none; }
					#site-header .secondary-nav .menu-toggle.open { display: inline-block; }
					#slide-menu .widget-area.mobile { display: block; }
					#slide-panel .has-mobile-menu #slide-mobile-menu { display: block; }
					#slide-panel .has-mobile-menu #slide-main-menu { display: none;	}
					#slide-panel .widget-area.desktop { display: none; }
				}
			<?php } ?>
			
		<?php }// if($header) ?>
		
		<?php if (get_theme_mod('bramble_custom_css') ) {
			echo get_theme_mod('bramble_custom_css');
		} ?>
		
		</style>
		
<?php

	} // bramble_theme_head()
} // if()

add_action( 'wp_head','bramble_theme_head' );


// 2.3 Admin Scripts and Styles
if ( ! function_exists( 'bramble_admin_styles' ) ) {
	function bramble_admin_styles() {
		wp_enqueue_style( 'bramble-font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css', false, '4.0.3', 'all' );
		wp_enqueue_style( 'bramble-admin-css', get_template_directory_uri() . '/css/admin.css');
		wp_enqueue_style( 'bramble-icon-picker-css', get_template_directory_uri() . '/css/icon-picker.css');
		wp_enqueue_script( 'bramble-admin-js', get_bloginfo( 'template_url' ) . '/js/admin.js', array( 'jquery' ), '1.0', true );
		wp_enqueue_script( 'bramble-icon-picker', get_bloginfo( 'template_url' ) . '/js/icon-picker.js', array( 'jquery' ), '1.0', true );
	}	
}
add_action('admin_enqueue_scripts', 'bramble_admin_styles');

//////////////////////////////////////////////////////////////
// 3. Includes
/////////////////////////////////////////////////////////////

// 3.0.5 Megamenus
require get_template_directory() . '/inc/tt_abstract_class.php';

//	3.1 Custom template tags for this theme.
require get_template_directory() . '/inc/template-tags.php';

//	3.2 Custom functions that act independently of the theme templates.
require get_template_directory() . '/inc/extras.php';

//	3.3 Customizer additions.
require get_template_directory() . '/inc/customizer.php';

//	3.5 Widgets
require get_template_directory() . '/inc/widgets.php';

//	3.6 WooCommerce functions and template tags
require get_template_directory() . '/inc/woocommerce-functions.php';

// 3.7 Megamenus
require get_template_directory() . '/inc/megamenu.php';

//////////////////////////////////////////////////////////////
// 4. Fonts
/////////////////////////////////////////////////////////////

function bramble_fonts_url() {

    $fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by Lora, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	

	/* Translators: If there are characters in your language that are not
	 * supported by Open Sans, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$open_sans = _x( 'on', 'Open Sans font: on or off', 'bramble' );
	
	$raleway = _x( 'on', 'Raleway font: on or off', 'bramble' );

	if ( 'off' !== $raleway || 'off' !== $open_sans) {
	    $font_families = array();
	
	    if ( 'off' !== $raleway ) {
	        $font_families[] = 'Raleway:300,400,700,300italic,400italic,700italic';
	    }
	
	    if ( 'off' !== $open_sans ) {
	        $font_families[] = 'Open Sans:300,400,700,300italic,400italic,700italic';
	    }

	    $query_args = array(
		    'family' => urlencode( implode( '|', $font_families ) ),
		    'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );

	} // if()

    return $fonts_url;

} // bramble_fonts_url()

function bramble_gfonts() {

    wp_enqueue_style( 'bramble-fonts', bramble_fonts_url(), array(), null );

}

add_action( 'wp_enqueue_scripts', 'bramble_gfonts' );


//////////////////////////////////////////////////////////////
// 5. Set defaults for demo import plugin
/////////////////////////////////////////////////////////////

function ocdi_import_files() {
    return array(
        array(
            'import_file_name'             => 'Bramble Demo Content',
            'local_import_file'            => trailingslashit( get_template_directory() ) . '/inc/demo-import/demo-content/bramble-content.xml',
            'local_import_widget_file'     => trailingslashit( get_template_directory() ) . '/inc/demo-import/demo-content/bramble-widgets.json',
            'local_import_customizer_file' => '',
            'import_preview_image_url'     => '',
            'import_notice'                => __( '', 'bramble' ),
        ),
    );
}
add_filter( 'pt-ocdi/import_files', 'ocdi_import_files' );

function ocdi_before_widgets_import( $selected_import ) {
    
	// Set Menu Locations
	$locations = get_theme_mod('nav_menu_locations');
	$menus  = wp_get_nav_menus();

	if(!empty($menus)) {
		foreach($menus as $menu) {
			if(is_object($menu) && $menu->name == 'Main Menu') {
				$locations['primary'] = $menu->term_id;
				$locations['slide_panel_mobile'] = $menu->term_id;
			}
		}
	}
	set_theme_mod('nav_menu_locations', $locations);

	// Set Front Page
	$front_page = get_page_by_title('Home: Agency');

	if(isset($front_page->ID)) {
		update_option('show_on_front', 'page');
		update_option('page_on_front',  $front_page->ID);
	}


	if (class_exists('RevSlider')) { 

	ob_start();
	
	// Import Slider
	$_FILES["import_file"]["tmp_name"] = get_template_directory().'/inc/demo-import/demo-content/app.zip';
	$slider = new RevSlider();
	$response = $slider->importSliderFromPost();
	unset($slider);
	
	// Import Slider
	$_FILES["import_file"]["tmp_name"] = get_template_directory().'/inc/demo-import/demo-content/business.zip';
	$slider = new RevSlider();
	$response = $slider->importSliderFromPost();
	unset($slider);
	
	// Import Slider
	$_FILES["import_file"]["tmp_name"] = get_template_directory().'/inc/demo-import/demo-content/shop.zip';
	$slider = new RevSlider();
	$response = $slider->importSliderFromPost();
	unset($slider);
	
	// Import Slider
	$_FILES["import_file"]["tmp_name"] = get_template_directory().'/inc/demo-import/demo-content/valley.zip';
	$slider = new RevSlider();
	$response = $slider->importSliderFromPost();
	unset($slider);
	
	// Import Slider
	$_FILES["import_file"]["tmp_name"] = get_template_directory().'/inc/demo-import/demo-content/wave.zip';
	$slider = new RevSlider();
	$response = $slider->importSliderFromPost();
	unset($slider);
	
	// Import Slider
	$_FILES["import_file"]["tmp_name"] = get_template_directory().'/inc/demo-import/demo-content/title-scene.zip';
	$slider = new RevSlider();
	$response = $slider->importSliderFromPost();
	unset($slider);

	ob_end_clean();
	}

}
add_action( 'pt-ocdi/before_widgets_import', 'ocdi_before_widgets_import' );
?>