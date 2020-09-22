<?php
/**
 * InterServer Portfolio functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package InterServer Portfolio
 */

if (!function_exists('interserver_portfolio_setup')):
   /**
    * Sets up theme defaults and registers support for various WordPress features.
    *
    * Note that this function is hooked into the after_setup_theme hook, which
    * runs before the init hook. The init hook is too late for some features, such
    * as indicating support for post thumbnails.
    */
   function interserver_portfolio_setup()
   {
      /*
      * Make theme available for translation.
      * to change 'interserver-portfolio' to the name of your theme in all the template files.
      */
      load_theme_textdomain('interserver-portfolio', get_template_directory() . '/languages');

      // Add default posts and comments RSS feed links to head.

      add_theme_support('automatic-feed-links');
      /*
      * Let WordPress manage the document title.
      * By adding theme support, we declare that this theme does not use a
      * hard-coded <title> tag in the document head, and expect WordPress to
      * provide it for us.
      */
      add_theme_support('title-tag');
      /*
      * Enable support for Post Thumbnails on posts and pages.
      *
      * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
      */
      add_theme_support('post-thumbnails');

      // This theme uses wp_nav_menu() in one location.

      register_nav_menus(array(
         'primary' => esc_html__('Primary', 'interserver-portfolio') ,
         'footer' => esc_html__('Footer', 'interserver-portfolio') ,
      ));
      /*
      * Switch default core markup for search form, comment form, and comments
      * to output valid HTML5.
      */
      add_theme_support('html5', array(
         'search-form',
         'comment-form',
         'comment-list',
         'gallery',
         'caption',
      ));
      /*
      * Enable support for Post Formats.
      * See https://developer.wordpress.org/themes/functionality/post-formats/
      */
      add_theme_support('post-formats', array(
         'aside',
         'image',
         'video',
         'quote',
         'link',
      ));
      add_theme_support('custom-logo', array(
         'height' => 250,
         'width' => 350,
         'flex-width' => true,
      ));

      // Set up the WordPress core custom background feature.

      add_theme_support('custom-background', apply_filters('interserver_portfolio_custom_background_args', array(
         'default-color' => 'ffffff',
         'default-image' => '',
      )));
      add_editor_style('css/custom-editor-style.css');
      add_theme_support('starter-content', array(
         'theme_mods' => array(
            'about_sec_title' => 'About Us',
            'about_sec_subtitle' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit',
            'services_sec_title' => 'Services',
            'services_sec_subtitle' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit',
            'portfolio_sec_title' => 'Portfolio',
            'portfolio_sec_subtitle' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit',
            'blog_sec_title' => 'From The Blog',
            'blog_sec_subtitle' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit',
         ) ,
      ));
   }

endif;
add_action('after_setup_theme', 'interserver_portfolio_setup');
/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */

function interserver_portfolio_content_width()
{
   $GLOBALS['content_width'] = apply_filters('interserver_portfolio_content_width', 640);
}

add_action('after_setup_theme', 'interserver_portfolio_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */

function interserver_portfolio_widgets_init()
{
   register_sidebar(array(
      'name' => esc_html__('Sidebar', 'interserver-portfolio') ,
      'id' => 'sidebar-1',
      'description' => 'This displays the default sidebar',
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget' => '</section>',
      'before_title' => '<h2 class="widget-title">',
      'after_title' => '</h2>',
   ));
   register_sidebar(array(
      'name' => esc_html__('Footer column 1', 'interserver-portfolio') ,
      'id' => 'footer-1',
      'description' => 'This displays the footer column 1',
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget' => '</section>',
      'before_title' => '<h2 class="footer-title">',
      'after_title' => '</h2>',
   ));
   register_sidebar(array(
      'name' => esc_html__('Footer column 2', 'interserver-portfolio') ,
      'id' => 'footer-2',
      'description' => 'This displays the footer column 2',
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget' => '</section>',
      'before_title' => '<h2 class="footer-title">',
      'after_title' => '</h2>',
   ));
   register_sidebar(array(
      'name' => esc_html__('Footer column 3', 'interserver-portfolio') ,
      'id' => 'footer-3',
      'description' => 'This displays the footer column 3',
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget' => '</section>',
      'before_title' => '<h2 class="footer-title">',
      'after_title' => '</h2>',
   ));
   register_sidebar(array(
      'name' => esc_html__('Footer column 4', 'interserver-portfolio') ,
      'id' => 'footer-4',
      'description' => 'This displays the footer column 4',
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget' => '</section>',
      'before_title' => '<h2 class="footer-title">',
      'after_title' => '</h2>',
   ));
   register_sidebar(array(
      'name' => esc_html__('Footer bottom', 'interserver-portfolio') ,
      'id' => 'footer-bottom',
      'description' => 'This displays the after footer widgetized secton',
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget' => '</section>',
      'before_title' => '<h2 class="footer-title">',
      'after_title' => '</h2>',
   ));
}

add_action('widgets_init', 'interserver_portfolio_widgets_init');
/**
 * Enqueue fonts
 */

function interserver_portfolio_add_google_fonts()
{
   wp_enqueue_style('interserver-portfolio-dancing-fonts', 'https://fonts.googleapis.com/css?family=Dancing+Script:400,700', false);
   wp_enqueue_style('interserver-portfolio-opensans-fonts', 'https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic&subset=latin,greek,greek-ext,vietnamese,cyrillic-ext,latin-ext,cyrillic', false);
   wp_enqueue_style('interserver-portfolio-quickstand-fonts', 'https://fonts.googleapis.com/css?family=Quicksand:400,300,700', false);
}

add_action('wp_enqueue_scripts', 'interserver_portfolio_add_google_fonts');
/**
 * Enqueue scripts and styles.
 */

function interserver_portfolio_scripts() {
   wp_enqueue_style('bootstrap.min', get_template_directory_uri() . '/css/bootstrap.min.css');
   wp_enqueue_style('interserver-portfolio-style', get_stylesheet_uri());
   wp_enqueue_style('interserver-portfolio-nivo-slider', get_template_directory_uri() . '/css/nivo-slider.css');
   wp_enqueue_style('interserver-portfolio-fontawesome', get_template_directory_uri() . '/font-awesome/css/all.min.css', array() , true);
   wp_enqueue_style('interserver-portfolio-magnific', get_template_directory_uri() . '/css/magnific-popup.css');
   wp_enqueue_style('interserver-portfolio-layout', get_template_directory_uri() . '/css/layout.css');
   wp_enqueue_style('interserver-portfolio-responsive', get_template_directory_uri() . '/css/responsive.min.css');
   wp_enqueue_script('bootstrap-min', get_template_directory_uri() . '/js/bootstrap.min.js', array(
      'jquery'
   ) , '20151215', true);
   wp_enqueue_script('interserver-portfolio-jquery-nivoslider', get_template_directory_uri() . '/js/jquery.nivo.slider.js', array() , '20151215', true);
   wp_enqueue_script('interserver-portfolio-jquery.mixitup.min', get_template_directory_uri() . '/js/jquery.mixitup.min.js', array(
      'jquery'
   ) , '20151215', true);
   wp_enqueue_script('interserver-portfolio-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array() , '20151215', true);
   wp_enqueue_script('interserver-portfolio-magnific-js', get_template_directory_uri() . '/js/jquery.magnific-popup.min.js', array(
      'jquery'
   ));
   wp_enqueue_script('interserver-portfolio-navigation', get_template_directory_uri() . '/js/responsive-nav.js', array() , '20151215', true);
   if (is_singular() && comments_open() && get_option('thread_comments')) {
      wp_enqueue_script('comment-reply');
   }

   wp_enqueue_script('portfolio-custom', get_template_directory_uri() . '/js/custom.js', array() , '20151215', true);
}

add_action('wp_enqueue_scripts', 'interserver_portfolio_scripts');
/**
 * Implement the Custom   feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

if (!function_exists('interserver_portfolio_custom_pagination')):
   function interserver_portfolio_custom_pagination($nav_query = false)
   {
      global $wp_query, $wp_rewrite;

      // Don't print empty markup if there's only one page.

      $query = $nav_query ? $nav_query : $wp_query;

      // Prepare variables

      $max = $query->max_num_pages;
      $current_page = max(1, get_query_var('paged'));
      $big = 999999;
?>
    <div class='page-navi-wrap'>
        <nav class='custom-pagination'>
        <?php
      echo '' . paginate_links(array(
         'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))) ,
         'format' => '?paged=%#%',
         'current' => $current_page,
         'total' => $max,
         'type' => 'plain',
         'prev_text' => __('&laquo;', 'interserver-portfolio') ,
         'next_text' => __('&raquo;', 'interserver-portfolio')
      )) . ' ';
?>        
        </nav><!-- .page-nav -->
    </div>
        <?php
   }

endif;

function interserver_portfolio_archive_title($title) {
   if (is_category()) {
      $title = single_cat_title('', false);
   }
   elseif (is_tag()) {
      $title = single_tag_title('', false);
   }
   elseif (is_date()) {

   }
   elseif (is_author()) {
      $title = '<span class="vcard">' . get_the_author() . '</span>';
   }
   elseif (is_post_type_archive()) {
      $title = post_type_archive_title('', false);
   }
   elseif (is_tax()) {
      $title = single_term_title('', false);
   }
   elseif (is_404()) {
      $title = "Page not found";
   }
   elseif (is_search()) {
      $title = "Search Results for:" . get_search_query();
   }
   else {
      $title = get_the_title('', false);
   }
   return $title;
}

add_filter('get_the_archive_title', 'interserver_portfolio_archive_title');

function interserver_portfolio_custom_excerpt($limit)
{
   $excerpt = explode(' ', get_the_excerpt() , $limit);
   if (count($excerpt) >= $limit) {
      array_pop($excerpt);
      $excerpt = implode(" ", $excerpt) . '...';
   }
   else {
      $excerpt = implode(" ", $excerpt);
   }

   $excerpt = preg_replace('`[[^]]*]`', '', $excerpt);
   return $excerpt;
}

function interserver_portfolio_gallery_defaults($settings)
{
   $settings['galleryDefaults']['link'] = 'file'; // Change this to 'none' to disable links on images
   $settings['galleryDefaults']['columns'] = '5'; // Change this value to set the number of columns
   return $settings;
}
add_filter('media_view_settings', 'interserver_portfolio_gallery_defaults');

add_filter('shortcode_atts_gallery', function ($out) {
   $out['size'] = 'medium';
   return $out;
});

function interserver_portfolio_header_image() {
   global $post;
   if(is_front_page() || is_home()){
      $archive_title = get_the_title( get_option('page_on_front') );
   }else{
      $archive_title = get_the_archive_title();
   }

   $image = '';
   $header_image = get_header_image();
   if ($post && $post->ID) {
      $image = get_the_post_thumbnail_url($post->ID, 'full');
   }

   if ($image) {
      echo '<div class="header_bg"><img src="' . esc_url($image) . '"/></div>';
   }
   elseif ( has_header_image() ){
      echo '<div class="header_bg"><div class="overlap"></div><img src="'. $header_image .'"/></div>';
   }
   else {
      echo '<div class="header_bg without_header_img"><div class="overlap"></div></div>';
   }

   echo '<div class="page-header"><h1 class="entry-title">' . $archive_title . '</h1></div>';
}

add_filter('body_class', 'interserver_portfolio_browser_body_class');

function interserver_portfolio_browser_body_class($classes) {
   global $is_IE, $is_safari, $is_chrome;
   if ($is_safari) $classes[] = 'safari';
   elseif ($is_chrome) $classes[] = 'chrome';
   elseif ($is_IE) $classes[] = 'ie';
   return $classes;
}
