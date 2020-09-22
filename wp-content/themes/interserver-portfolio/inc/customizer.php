<?php
/**
 * Interserver Portfolio Theme Customizer.
 *
 * @package InterServer Portfolio
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function interserver_portfolio_customize_register($wp_customize) {
   $wp_customize->get_setting('blogname')->transport = 'postMessage';
   $wp_customize->get_setting('blogdescription')->transport = 'postMessage';
   $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';
   $wp_customize->get_setting('background_color')->transport = 'postMessage';

   if (!class_exists('WP_Customize_Control')) return NULL;
   /**
    * A class to create a dropdown for all categories in your wordpress site
    */
   class interserver_portfolio_Customize_Category_Control extends WP_Customize_Control {
      private $cats = false;
      public function __construct($manager, $id, $args = array() , $options = array()) {
         $this->cats = get_categories($options);
         parent::__construct($manager, $id, $args);
      }
      /**
       * Render the content of the category dropdown
       *
       * @return HTML
       */
      public function render_content() {
         if (!empty($this->cats)) {
		?>
         <label>
         <span class="customize-category-select-control"><?php echo esc_html( $this->label ); ?></span>
         <select <?php $this->link(); ?>>
            <?php
            foreach($this->cats as $cat) {
               printf('<option value="%s" %s>%s</option>', esc_attr($cat->term_id) , selected($this->value() , $cat->term_id, false) , esc_attr($cat->name));
            }
				?>
         </select>
         </label>
      <?php
         }
      }
   }
   if (class_exists('WP_Customize_Control')) {
      class interserver_portfolio_Customizer_Number_Control extends WP_Customize_Control {
         public $type = 'number';
         public function render_content() {
	?>
       	<label>
        	<span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
       	<input type="number" <?php $this->link(); ?> value="<?php echo intval($this->value()); ?>" />
         </label>
      <?php
         }
      }
   }
   // Custom customizer section
   $wp_customize->add_panel('homepage_panel', array(
      'title' => __('Home Page Sections', 'interserver-portfolio') ,
      'description' => __('Change home page sections from here', 'interserver-portfolio') ,
      'priority' => 160, // Mixed with top-level-section hierarchy.
   ));
   $wp_customize->add_section('slider_sec', array(
      'title' => __('Slider Section', 'interserver-portfolio') ,
      'panel' => 'homepage_panel',
      'priority' => 110,
   ));
   $wp_customize->add_setting('hide_slider_sec', array(
      'default' => 0,
      'sanitize_callback' => 'interserver_portfolio_sanitize_checkbox',
      'capability' => 'edit_theme_options',
   ));
   $wp_customize->add_control('hide_slider_sec', array(
      'settings' => 'hide_slider_sec',
      'section' => 'slider_sec',
      'label' => __('Check this to Hide Slider Section', 'interserver-portfolio') ,
      'type' => 'checkbox'
   ));
   $wp_customize->add_setting('hide_slider_captions', array(
      'sanitize_callback' => 'interserver_portfolio_sanitize_checkbox'
   ));
   $wp_customize->add_control('hide_slider_captions', array(
      'label' => __('Hide Slide Captions', 'interserver-portfolio') ,
      'setting' => 'hide_slider_captions',
      'section' => 'slider_sec',
      'type' => 'checkbox'
   ));
   $wp_customize->add_setting('slider_loop', array(
      'default' => '3',
      'sanitize_callback' => 'interserver_portfolio_sanitize_integer',
   ));
   $wp_customize->add_control(new interserver_portfolio_Customizer_Number_Control($wp_customize, 'slider_loop', array(
      'label' => __('No. of posts to display', 'interserver-portfolio') ,
      'section' => 'slider_sec',
      'setting' => 'slider_loop',
      'type' => 'number',
   )));
   $wp_customize->add_section('about_sec', array(
      'title' => __('About Section', 'interserver-portfolio') ,
      'panel' => 'homepage_panel',
      'priority' => 130,
   ));
   $wp_customize->add_setting('hide_about_sec', array(
      'default' => 0,
      'sanitize_callback' => 'interserver_portfolio_sanitize_checkbox',
      'capability' => 'edit_theme_options',
   ));
   $wp_customize->add_control('hide_about_sec', array(
      'settings' => 'hide_about_sec',
      'section' => 'about_sec',
      'label' => __('Check this to Hide About Section', 'interserver-portfolio') ,
      'type' => 'checkbox'
   ));
   $wp_customize->add_setting('about_background_color', array(
      'default' => '#fff',
      'sanitize_callback' => 'sanitize_hex_color',
   ));
   $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'about_background_color', array(
      'label' => 'Section Background Color',
      'settings' => 'about_background_color',
      'section' => 'about_sec'
   )));
   $wp_customize->add_setting('about_sec_title', array(
      'sanitize_callback' => 'interserver_portfolio_sanitize_text',
      'default' => __('About Us', 'interserver-portfolio') ,
   ));
   $wp_customize->add_control('about_sec_title', array(
      'label' => 'Add section title',
      'setting' => 'about_sec_title',
      'section' => 'about_sec',
      'type' => 'text',
   ));
   $wp_customize->add_setting('about_sec_subtitle', array(
      'sanitize_callback' => 'interserver_portfolio_sanitize_text',
   ));
   $wp_customize->add_control('about_sec_subtitle', array(
      'label' => 'Add section sub title',
      'setting' => 'about_sec_subtitle',
      'section' => 'about_sec',
      'type' => 'text',
   ));
   $wp_customize->add_setting('about_sec_page_1', array(
      'sanitize_callback' => 'interserver_portfolio_sanitize_integer',
   ));
   $wp_customize->add_control('about_sec_page_1', array(
      'label' => 'Choose page for box 1',
      'setting' => 'about_sec_page_1',
      'section' => 'about_sec',
      'type' => 'dropdown-pages',
   ));
   $wp_customize->add_setting('about_sec_page_2', array(
      'sanitize_callback' => 'interserver_portfolio_sanitize_integer',
   ));
   $wp_customize->add_control('about_sec_page_2', array(
      'label' => 'Choose page for box 2',
      'setting' => 'about_sec_page_2',
      'section' => 'about_sec',
      'type' => 'dropdown-pages',
   ));
   $wp_customize->add_setting('about_sec_page_3', array(
      'sanitize_callback' => 'interserver_portfolio_sanitize_integer',
   ));
   $wp_customize->add_control('about_sec_page_3', array(
      'label' => 'Choose page for box 3',
      'setting' => 'about_sec_page_3',
      'section' => 'about_sec',
      'type' => 'dropdown-pages',
   ));
   $wp_customize->add_setting('about_sec_page_4', array(
      'sanitize_callback' => 'interserver_portfolio_sanitize_integer',
   ));
   $wp_customize->add_control('about_sec_page_4', array(
      'label' => 'Choose page for box 4',
      'setting' => 'about_sec_page_4',
      'section' => 'about_sec',
      'type' => 'dropdown-pages',
   ));
   $wp_customize->add_setting('about_sec_page_5', array(
      'sanitize_callback' => 'interserver_portfolio_sanitize_integer',
   ));
   $wp_customize->add_control('about_sec_page_5', array(
      'label' => 'Choose page for box 5',
      'setting' => 'about_sec_page_5',
      'section' => 'about_sec',
      'type' => 'dropdown-pages',
   ));
   // Service Section
   $wp_customize->add_section('services_sec', array(
      'title' => __('Services Section', 'interserver-portfolio') ,
      'panel' => 'homepage_panel',
      'priority' => 130,
   ));
   $wp_customize->add_setting('hide_services_sec', array(
      'default' => 0,
      'sanitize_callback' => 'interserver_portfolio_sanitize_checkbox',
      'capability' => 'edit_theme_options',
   ));
   $wp_customize->add_control('hide_services_sec', array(
      'settings' => 'hide_services_sec',
      'section' => 'services_sec',
      'label' => __('Check this to Hide Services Section', 'interserver-portfolio') ,
      'type' => 'checkbox'
   ));
   $wp_customize->add_setting('services_background_color', array(
      'default' => '#000',
      'sanitize_callback' => 'sanitize_hex_color'
   ));
   $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'services_background_color', array(
      'label' => 'Section Background Color',
      'settings' => 'services_background_color',
      'section' => 'services_sec'
   )));
   $wp_customize->add_setting('services_sec_title', array(
      'sanitize_callback' => 'interserver_portfolio_sanitize_text',
      'default' => __('Services', 'interserver-portfolio') ,
   ));
   $wp_customize->add_control('services_sec_title', array(
      'label' => 'Add section title',
      'setting' => 'services_sec_title',
      'section' => 'services_sec',
      'type' => 'text',
   ));
   $wp_customize->add_setting('services_sec_subtitle', array(
      'sanitize_callback' => 'interserver_portfolio_sanitize_text',
   ));
   $wp_customize->add_control('services_sec_subtitle', array(
      'label' => 'Add section sub title',
      'setting' => 'services_sec_subtitle',
      'section' => 'services_sec',
      'type' => 'text',
   ));
   $wp_customize->add_setting('services_setting', array(
      'default' => 1,
      'sanitize_callback' => 'interserver_portfolio_sanitize_integer',
   ));
   $wp_customize->add_control(new interserver_portfolio_Customize_Category_Control($wp_customize, 'services_setting', array(
      'label' => __('Select Category', 'interserver-portfolio') ,
      'description' => __('Choose post category to display as services', 'interserver-portfolio') ,
      'section' => 'services_sec',
      'settings' => 'services_setting'
   )));
   // Service Section
   $wp_customize->add_section('portfolio_sec', array(
      'title' => __('Portfolio Section', 'interserver-portfolio') ,
      'panel' => 'homepage_panel',
      'priority' => 130,
   ));
   $wp_customize->add_setting('hide_portfolio_sec', array(
      'default' => 0,
      'sanitize_callback' => 'interserver_portfolio_sanitize_checkbox',
      'capability' => 'edit_theme_options',
   ));
   $wp_customize->add_control('hide_portfolio_sec', array(
      'settings' => 'hide_portfolio_sec',
      'section' => 'portfolio_sec',
      'label' => __('Check this to Hide Portfolio Section', 'interserver-portfolio') ,
      'type' => 'checkbox'
   ));
   $wp_customize->add_setting('portfolio_background_color', array(
      'default' => '#fff',
      'sanitize_callback' => 'sanitize_hex_color'
   ));
   $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'portfolio_background_color', array(
      'label' => 'Section Background Color',
      'settings' => 'portfolio_background_color',
      'section' => 'portfolio_sec'
   )));
   $wp_customize->add_setting('portfolio_sec_title', array(
      'sanitize_callback' => 'interserver_portfolio_sanitize_text',
      'default' => __('Portfolio', 'interserver-portfolio') ,
   ));
   $wp_customize->add_control('portfolio_sec_title', array(
      'label' => 'Add section title',
      'setting' => 'portfolio_sec_title',
      'section' => 'portfolio_sec',
      'type' => 'text',
   ));
   $wp_customize->add_setting('portfolio_sec_subtitle', array(
      'sanitize_callback' => 'interserver_portfolio_sanitize_text',
   ));
   $wp_customize->add_control('portfolio_sec_subtitle', array(
      'label' => 'Add section sub title',
      'setting' => 'portfolio_sec_subtitle',
      'section' => 'portfolio_sec',
      'type' => 'text',
   ));
   $wp_customize->add_setting('portfolio_cat_setting', array(
      'default' => 1,
      'sanitize_callback' => 'interserver_portfolio_sanitize_text',
   ));
   $wp_customize->add_control(new interserver_portfolio_Customize_Category_Control($wp_customize, 'portfolio_cat_setting', array(
      'label' => __('Select Category', 'interserver-portfolio') ,
      'description' => __('Choose post category to display as portfolio', 'interserver-portfolio') ,
      'section' => 'portfolio_sec',
      'settings' => 'portfolio_cat_setting'
   )));
   // Blog Section
   $wp_customize->add_section('blog_sec', array(
      'title' => __('Blog Section', 'interserver-portfolio') ,
      'panel' => 'homepage_panel',
      'priority' => 130,
   ));
   $wp_customize->add_setting('hide_blog_sec', array(
      'default' => 0,
      'sanitize_callback' => 'sanitize_text_field',
      'capability' => 'edit_theme_options',
   ));
   $wp_customize->add_control('hide_blog_sec', array(
      'settings' => 'hide_blog_sec',
      'section' => 'blog_sec',
      'label' => __('Check this to Hide Blog Section', 'interserver-portfolio') ,
      'type' => 'checkbox'
   ));
   $wp_customize->add_setting('blog_background_color', array(
      'default' => '#000',
      'sanitize_callback' => 'sanitize_hex_color'
   ));
   $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'blog_background_color', array(
      'label' => 'Section Background Color',
      'settings' => 'blog_background_color',
      'section' => 'blog_sec'
   )));
   $wp_customize->add_setting('blog_sec_title', array(
      'sanitize_callback' => 'interserver_portfolio_sanitize_text',
   ));
   $wp_customize->add_control('blog_sec_title', array(
      'label' => 'Add section title',
      'setting' => 'blog_sec_title',
      'section' => 'blog_sec',
      'type' => 'text',
   ));
   $wp_customize->add_setting('blog_sec_subtitle', array(
      'sanitize_callback' => 'interserver_portfolio_sanitize_text',
   ));
   $wp_customize->add_control('blog_sec_subtitle', array(
      'label' => 'Add section sub title',
      'setting' => 'blog_sec_subtitle',
      'section' => 'blog_sec',
      'type' => 'text',
   ));
   function interserver_portfolio_sanitize_text($input)
   {
      return wp_kses_post(force_balance_tags($input));
   }
   function interserver_portfolio_sanitize_integer($input)
   {
      if (is_numeric($input)) {
         return intval($input);
      }
   }
   function interserver_portfolio_sanitize_checkbox($input)
   {
      if ($input == 1) {
         return 1;
      }
      else {
         return '';
      }
   }
}
add_action('customize_register', 'interserver_portfolio_customize_register');

function interserver_portfolio_customize_css() {
   $header_text_color = get_header_textcolor();
   $about_bg = get_theme_mod('about_background_color', '#fff');
   $services_bg = get_theme_mod('services_background_color', '#000');
   $portfolio_bg = get_theme_mod('portfolio_background_color', '#fff');
   $blog_bg = get_theme_mod('blog_background_color', '#000');
?>
   <style type="text/css">
	   .nivo-caption { <?php if ( get_theme_mod( 'hide_slider_captions') == 1) { ?> display:none !important; <?php } ?> }
	   .archive-header h1, .page-header h1,.site-title a,#cssmenu > ul > li > a{ color: #<?php echo esc_attr($header_text_color); ?>; }
	   #about{ background-color:<?php echo esc_html($about_bg); ?>; } 
	   #services{width:100%;background-color: <?php echo esc_html($services_bg); ?>;}
	   #interserver_portfolio_sec{background-color:<?php echo esc_html($portfolio_bg); ?>;} 
	   #blog{background-color:<?php echo esc_html($blog_bg); ?>;} 
   </style>
   <?php
}
add_action('wp_head', 'interserver_portfolio_customize_css');

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function interserver_portfolio_customize_preview_js() {
   wp_enqueue_script('interserver_portfolio_customizer', get_template_directory_uri() . '/js/customizer.js', array(
      'customize-preview'
   ) , '20151215', true);
}
add_action('customize_preview_init', 'interserver_portfolio_customize_preview_js');
