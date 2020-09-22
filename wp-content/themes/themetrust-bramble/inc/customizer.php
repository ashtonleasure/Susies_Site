<?php
/**
 * Bramble Theme Customizer
 *
 * @package bramble
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function bramble_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	
	// remove controls
	$wp_customize->remove_control('blogdescription');

	// -- Sanitization Callbacks

	/**
	 * Sanitize boolean
	 *
	 * @param $input
	 *
	 * @return bool
	 */
	function bramble_sanitize_checkbox( $input ) {
	    if ( $input == 1 ) {
	        return 1;
	    } else {
	        return 0;
	    }
	}

	/**
	 * Sanitize numbers
	 *
	 * @param int $input
	 *
	 * @return int
	 */
	function bramble_sanitize_number( $input ) {
		if ( is_numeric( $input ) ) {
			return $input;
		} else {
			return '';
		}
	}

	/**
	 * Sanitize banner type
	 *
	 * @param string $input
	 *
	 * @return string
	 */
	function bramble_sanitize_banner_type( $input ){

		if( 'static' == $input || 'campaign' == $input )
			return $input;
		else
			return '';

	} // bramble_sanitize_banner_type()

	if ( ! class_exists( 'WP_Customize_Control' ) )
		return NULL;

	/**
	 * Class to add a text area for page and section descriptions
	 */

	class Bramble_Textarea_Control extends WP_Customize_Control {
		public $type = 'textarea';

		public function render_content() {
			?>
			<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
			</label>
			<?php
		}
	} // Bramble_Textarea_Control

	/**
	 * Class to add a header to certain sections
	 */
	class Bramble_Header_Control extends WP_Customize_Control {
		public $type = 'tag';
		public function render_content() {
			?>
			<h3 class="customize-control-title"><?php echo esc_html( $this->label ); ?></h3>
		<?php
		}
	}

	//Text Area Control
	class TTrust_Textarea_Control extends WP_Customize_Control {
		public $type = 'textarea';

		public function render_content() {
			?>
			<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
			</label>
			<?php
		}
	}

	
	
	// -- General --------------------------------------------------------------------------------------------------

	$wp_customize->add_panel( 'bramble_general', array(
		'priority'		 => 1,
	    'title'     	 => __( 'General', 'bramble' )
	) );
	
	// -- Loader
	
	$wp_customize->add_section( 'bramble_loader', array(
		'priority'		 => 1,
	    'title'     	 => __( 'Loader', 'bramble' ),
		'panel'			=> 'bramble_general'
	) );
	
	$wp_customize->add_setting( 'bramble_loader_enabled' , array(
	    'default'     		=> __( 'yes', 'bramble' ),
	    'type' 				=> 'theme_mod',
	    'transport' 		=> 'refresh',
	    'sanitize_callback'	=> 'esc_html'
	) );
	
	$wp_customize->add_control( 'bramble_loader_enabled', array(
		'type'      => 'select',
		'label'     => __( 'Enable Loader', 'bramble' ),
		'section'   => 'bramble_loader',
		'settings'  => 'bramble_loader_enabled',
		'choices'   => array(
		            'yes' => 'Yes',
		            'no' => 'No'
		        ),
		'priority'   => 1
	) );
	
	$wp_customize->add_setting( 'bramble_loader_animation' , array(
	    'default'     		=> __( 'rotating-plane', 'bramble' ),
	    'type' 				=> 'theme_mod',
	    'transport' 		=> 'refresh',
	    'sanitize_callback'	=> 'esc_html'
	) );
	
	$wp_customize->add_control( 'bramble_loader_animation', array(
		'type'      => 'select',
		'label'     => __( 'Loader Animation', 'bramble' ),
		'section'   => 'bramble_loader',
		'settings'  => 'bramble_loader_animation',
		'choices'   => array(
		            'rotating-plane' => 'Rotating Plane',
		            'double-bounce' => 'Double Bounce',
					'wave' => 'Wave',
		            'wandering-cubes' => 'Wandering Cubes',
					'pulse' => 'Pulse'
		        ),
		'priority'   => 2
	) );
	
	$wp_customize->add_setting( 'bramble_loader_color' );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bramble_loader_color', array(
			'label'      => __( 'Loader Icon Color', 'bramble' ),
			'section'    => 'bramble_loader',
			'settings'   => 'bramble_loader_color',
			'priority'   => 3
		) )
	);
	
	$wp_customize->add_setting( 'bramble_loader_bkg_color' );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bramble_loader_bkg_color', array(
			'label'      => __( 'Loader Background Color', 'bramble' ),
			'section'    => 'bramble_loader',
			'settings'   => 'bramble_loader_bkg_color',
			'priority'   => 4
		) )
	);
	
	
	
	// -- Header & Navigation --------------------------------------------------------------------------------------------------

	$wp_customize->add_panel( 'bramble_header_navigation', array(
		'priority'		 => 4,
	    'title'     	 => __( 'Header & Navigation', 'bramble' )
	) );
	
	// -- Logos
	
	$wp_customize->add_section( 'bramble_logos', array(
		'priority'		 => 1,
	    'title'     	 => __( 'Logos', 'bramble' ),
		'panel'			=> 'bramble_header_navigation'
	) );
	
	$wp_customize->add_setting( 'bramble_logo' , array(
	    'default'   		=> '',
	    'type'				=> 'theme_mod',
	    'transport'			=> 'refresh',
	    'sanitize_callback'	=> 'esc_url_raw'
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'bramble_logo', array(
		'label'      => __('Header Logo', 'bramble'),
		'section'    => 'bramble_logos',
		'settings'   => 'bramble_logo',
	    'priority'   => 1
	) ) );
	
	$wp_customize->add_setting( 'bramble_logo_width' , array(
	    'type' 				=> 'theme_mod',
	    'transport' 		=> 'refresh',
	    'sanitize_callback'	=> 'esc_html'
	) );
	
	$wp_customize->add_control( 'bramble_logo_width', array(
		'label'     => __( 'Header Logo Width', 'bramble' ),
		'type'      => 'text',
		'description'     => __( 'Enter the actual width of your logo image in pixels. Used for retina displays.', 'bramble' ),
		'section'   => 'bramble_logos',
		'settings'  => 'bramble_logo_width',
		'priority'   => 2.7
	) );
	
	$wp_customize->add_setting( 'bramble_logo_small' , array(
	    'default'   		=> '',
	    'type'				=> 'theme_mod',
	    'transport'			=> 'refresh',
	    'sanitize_callback'	=> 'esc_url_raw'
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'bramble_logo_small', array(
		'label'      => __('Header Logo Small', 'bramble'),
		'section'    => 'bramble_logos',
		'settings'   => 'bramble_logo_small',
	    'priority'   => 2.8
	) ) );
	
	$wp_customize->add_setting( 'bramble_logo_small_width' , array(
	    'type' 				=> 'theme_mod',
	    'transport' 		=> 'refresh',
	    'sanitize_callback'	=> 'esc_html'
	) );
	
	$wp_customize->add_control( 'bramble_logo_small_width', array(
		'label'     => __( 'Header Logo Width - Small ', 'bramble' ),
		'type'      => 'text',
		'description'     => __( 'Enter the actual width of your logo image in pixels. Used for retina displays. ', 'bramble' ),
		'section'   => 'bramble_logos',
		'settings'  => 'bramble_logo_small_width',
		'priority'   => 3.0
	) );
	
	$wp_customize->add_setting( 'bramble_logo_mobile' , array(
	    'default'   		=> '',
	    'type'				=> 'theme_mod',
	    'transport'			=> 'refresh',
	    'sanitize_callback'	=> 'esc_url_raw'
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'bramble_logo_mobile', array(
		'label'      => __('Header Logo Mobile', 'bramble'),
		'section'    => 'bramble_logos',
		'settings'   => 'bramble_logo_mobile',
	    'priority'   => 3.1
	) ) );
	
	$wp_customize->add_setting( 'bramble_logo_mobile_width' , array(
	    'type' 				=> 'theme_mod',
	    'transport' 		=> 'refresh',
	    'sanitize_callback'	=> 'esc_html'
	) );
	
	$wp_customize->add_control( 'bramble_logo_mobile_width', array(
		'label'     => __( 'Header Logo Width - Mobile ', 'bramble' ),
		'type'      => 'text',
		'description'     => __( 'Enter the actual width of your logo image in pixels. Used for retina displays. ', 'bramble' ),
		'section'   => 'bramble_logos',
		'settings'  => 'bramble_logo_mobile_width',
		'priority'   => 3.3
	) );
	
	$wp_customize->add_setting( 'bramble_favicon' , array(
	    'default'   		=> '',
	    'type'				=> 'theme_mod',
	    'transport'			=> 'refresh',
	    'sanitize_callback'	=> 'esc_url_raw'
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'bramble_favicon', array(
		'label'      => __('Favicon', 'bramble'),
		'section'    => 'bramble_logos',
		'settings'   => 'bramble_favicon',
	    'priority'   => 7
	) ) );
	
	
	
	// -- Position & Style
	
	$wp_customize->add_section( 'bramble_header', array(
		'priority'		 => 1,
	    'title'     	 => __( 'Position & Style', 'bramble' ),
		'panel'			=> 'bramble_header_navigation'
	) );
	
	$wp_customize->add_setting( 'bramble_header_layout' , array(
	    'default'     		=> __( 'full-width', 'bramble' ),
	    'type' 				=> 'theme_mod',
	    'transport' 		=> 'refresh',
	    'sanitize_callback'	=> 'esc_html'
	) );
	
	$wp_customize->add_control( 'bramble_header_layout', array(
		'type'      => 'select',
		'label'     => __( 'Header Layout', 'bramble' ),
		'section'   => 'bramble_header',
		'settings'  => 'bramble_header_layout',
		'choices'   => array(
		            'wide-header' => 'Wide',
					'narrow-header' => 'Narrow'
		        ),
		'priority'   => 1
	) );
	
	$wp_customize->add_setting( 'bramble_header_bkg_color' );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bramble_header_bkg_color', array(
			'label'      => __( 'Header Background Color', 'bramble' ),
			'section'    => 'bramble_header',
			'settings'   => 'bramble_header_bkg_color',
			'priority'   => 3
		) )
	);
	
	
	$wp_customize->add_setting( 'bramble_main_menu_color' );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bramble_main_menu_color', array(
			'label'      => __( 'Main Menu Color', 'bramble' ),
			'section'    => 'bramble_header',
			'settings'   => 'bramble_main_menu_color',
			'priority'   => 5
		) )
	);
	
	$wp_customize->add_setting( 'bramble_main_menu_hover_color' );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bramble_main_menu_hover_color', array(
			'label'      => __( 'Main Menu Hover Color', 'bramble' ),
			'section'    => 'bramble_header',
			'settings'   => 'bramble_main_menu_hover_color',
			'priority'   => 6
		) )
	);
	
	$wp_customize->add_setting( 'bramble_site_title_color' );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bramble_site_title_color', array(
			'label'      => __( 'Site Title Color', 'bramble' ),
			'section'    => 'bramble_header',
			'settings'   => 'bramble_site_title_color',
			'priority'   => 9
		) )
	);
	
	$wp_customize->add_setting( 'bramble_drop_down_bg_color' );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bramble_drop_down_bg_color', array(
			'label'      => __( 'Drop Down Background Color', 'bramble' ),
			'section'    => 'bramble_header',
			'settings'   => 'bramble_drop_down_bg_color',
			'priority'   => 11
		) )
	);
	
	$wp_customize->add_setting( 'bramble_drop_down_link_color' );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bramble_drop_down_link_color', array(
			'label'      => __( 'Drop Down Link Color', 'bramble' ),
			'section'    => 'bramble_header',
			'settings'   => 'bramble_drop_down_link_color',
			'priority'   => 12
		) )
	);
	
	$wp_customize->add_setting( 'bramble_drop_down_link_hover_color' );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bramble_drop_down_link_hover_color', array(
			'label'      => __( 'Drop Down Link Hover Color', 'bramble' ),
			'section'    => 'bramble_header',
			'settings'   => 'bramble_drop_down_link_hover_color',
			'priority'   => 13
		) )
	);
	
	$wp_customize->add_setting( 'bramble_drop_down_divider_color' );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bramble_drop_down_divider_color', array(
			'label'      => __( 'Drop Down Divider Color', 'bramble' ),
			'section'    => 'bramble_header',
			'settings'   => 'bramble_drop_down_divider_color',
			'priority'   => 14
		) )
	);
	
	$wp_customize->add_setting( 'bramble_header_accent_color' );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bramble_header_accent_color', array(
			'label'      => __( 'Accent Color', 'bramble' ),
			'section'    => 'bramble_header',
			'settings'   => 'bramble_header_accent_color',
			'priority'   => 15
		) )
	);
	
	// -- Slide Panel
	
	$wp_customize->add_section( 'bramble_slide_panel', array(
		'priority'		 => 2,
	    'title'     	 => __( 'Slide Panel (Mobile Nav)', 'bramble' ),
		'panel'			=> 'bramble_header_navigation'
	) );
	
	$wp_customize->add_setting( 'bramble_slide_panel_background', array(
		'default'     		=> '',
		'type'				=> 'theme_mod',
		'transport'			=> 'refresh',
		'sanitize_callback'	=> 'esc_url_raw'
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'bramble_slide_panel_background', array(
		'label'      => __( 'Slide Panel Background Image', 'bramble' ),
		'section'    => 'bramble_slide_panel',
		'settings'   => 'bramble_slide_panel_background',
		'priority'   => 3
	) ) );
	
	$wp_customize->add_setting( 'bramble_slide_panel_bg_color' );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bramble_slide_panel_bg_color', array(
			'label'      => __( 'Slide Panel Background Color', 'bramble' ),
			'section'    => 'bramble_slide_panel',
			'settings'   => 'bramble_slide_panel_bg_color',
			'priority'   => 4
		) )
	);
	
	$wp_customize->add_setting( 'bramble_slide_panel_text_color' );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bramble_slide_panel_text_color', array(
			'label'      => __( 'Slide Panel Text Color', 'bramble' ),
			'section'    => 'bramble_slide_panel',
			'settings'   => 'bramble_slide_panel_text_color',
			'priority'   => 5
		) )
	);
	
	$wp_customize->add_setting( 'bramble_slide_panel_link_color' );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bramble_slide_panel_link_color', array(
			'label'      => __( 'Slide Panel Link Color', 'bramble' ),
			'section'    => 'bramble_slide_panel',
			'settings'   => 'bramble_slide_panel_link_color',
			'priority'   => 6
		) )
	);
	
	$wp_customize->add_setting( 'bramble_slide_panel_link_hover_color' );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bramble_slide_panel_link_hover_color', array(
			'label'      => __( 'Slide Panel Link Hover Color', 'bramble' ),
			'section'    => 'bramble_slide_panel',
			'settings'   => 'bramble_slide_panel_link_hover_color',
			'priority'   => 7
		) )
	);
	
	$wp_customize->add_setting( 'bramble_slide_panel_divider_color' );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bramble_slide_panel_divider_color', array(
			'label'      => __( 'Slide Panel Divider Color', 'bramble' ),
			'section'    => 'bramble_slide_panel',
			'settings'   => 'bramble_slide_panel_divider_color',
			'priority'   => 8
		) )
	);
	
	
	// -- Search
	
	$wp_customize->add_section( 'bramble_header_search', array(
		'priority'		 => 3,
	    'title'     	 => __( 'Search', 'bramble' ),
		'panel'			=> 'bramble_header_navigation'
	) );
	
	$wp_customize->add_setting( 'bramble_enable_header_search' , array(
	    'type' 				=> 'theme_mod',
	    'transport' 		=> 'refresh',
	    'sanitize_callback'	=> 'esc_html'
	) );
	
	$wp_customize->add_control( 'bramble_enable_header_search', array(
		'type'      => 'select',
		'label'     => __( 'Enable Search Icon', 'bramble' ),
		'description'     => __( 'Shows the search icon in the top header.', 'bramble' ),
		'section'   => 'bramble_header_search',
		'settings'  => 'bramble_enable_header_search',
		'choices'   => array(
		            'no' => 'No',
					'yes' => 'Yes'
		        ),
		'priority'   => 1
	) );
	
	// -- Scroll To Top
	
	$wp_customize->add_section( 'bramble_header_scroll_to_top', array(
		'priority'		 => 3.5,
	    'title'     	 => __( 'Scroll to Top Button', 'bramble' ),
		'panel'			=> 'bramble_header_navigation'
	) );
	
	$wp_customize->add_setting( 'bramble_enable_header_scroll_to_top' , array(
	    'type' 				=> 'theme_mod',
	    'transport' 		=> 'refresh',
	    'sanitize_callback'	=> 'esc_html'
	) );
	
	$wp_customize->add_control( 'bramble_enable_header_scroll_to_top', array(
		'type'      => 'select',
		'label'     => __( 'Enable Scroll to Top Button', 'bramble' ),
		'description'     => __( 'Shows a button in the lower right that allows the user to scroll to the top.', 'bramble' ),
		'section'   => 'bramble_header_scroll_to_top',
		'settings'  => 'bramble_enable_header_scroll_to_top',
		'choices'   => array(
		            'yes' => 'Yes',
					'no' => 'No'
		        ),
		'priority'   => 1
	) );
	
	$wp_customize->add_setting( 'bramble_scroll_to_top_bg_color' );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bramble_scroll_to_top_bg_color', array(
			'label'      => __( 'Scroll to Top Background Color', 'bramble' ),
			'section'    => 'bramble_header_scroll_to_top',
			'settings'   => 'bramble_scroll_to_top_bg_color',
			'priority'   => 2
		) )
	);
	
	$wp_customize->add_setting( 'bramble_scroll_to_top_arrow_color' );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bramble_scroll_to_top_arrow_color', array(
			'label'      => __( 'Scroll to Top Arrow Color', 'bramble' ),
			'section'    => 'bramble_header_scroll_to_top',
			'settings'   => 'bramble_scroll_to_top_arrow_color',
			'priority'   => 3
		) )
	);
	
	
	// -- Page Titles --------------------------------------------------------------------------------------------------
	
	$wp_customize->add_section( 'bramble_page_titles', array(
		'priority'		 => 4.2,
	    'title'     	 => __( 'Page Titles', 'bramble' )
	) );
	
	$wp_customize->add_setting( 'bramble_page_title_alignment' , array(
	    'type' 				=> 'theme_mod',
	    'transport' 		=> 'refresh',
	    'sanitize_callback'	=> 'esc_html'
	) );
	
	$wp_customize->add_control( 'bramble_page_title_alignment', array(
		'type'      => 'select',
		'label'     => __( 'Text Alignment', 'bramble' ),
		'description'     => __( 'Set the text alignment of all page titles.', 'bramble' ),
		'section'   => 'bramble_page_titles',
		'settings'  => 'bramble_page_title_alignment',
		'choices'   => array(
					'left' => 'Left',
		            'center' => 'Center',
					'right' => 'Right'
		        ),
		'priority'   => 1
	) );
	
	// Page Title Text Color
	$wp_customize->add_setting( 'bramble_page_title_text_color' );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bramble_page_title_text_color', array(
			'label'      => __( 'Text Color', 'bramble' ),
			'section'    => 'bramble_page_titles',
			'settings'   => 'bramble_page_title_text_color',
			'priority'   => 2
		) )
	);
	
	// Page Title Area Background Color
	$wp_customize->add_setting( 'bramble_page_title_bg_color' );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bramble_page_title_bg_color', array(
			'label'      => __( 'Background Color', 'bramble' ),
			'section'    => 'bramble_page_titles',
			'settings'   => 'bramble_page_title_bg_color',
			'priority'   => 3
		) )
	);
	
	// -- Blog --------------------------------------------------------------------------------------------------

	$wp_customize->add_panel( 'bramble_blog', array(
		'priority'		 => 4.5,
	    'title'     	 => __( 'Blog', 'bramble' )
	) );
	
	// -- Meta
	
	$wp_customize->add_section( 'bramble_post_meta', array(
		'priority'		 => 1,
	    'title'     	 => __( 'Post Meta', 'bramble' ),
		'panel'			=> 'bramble_blog'
	) );
	
	$wp_customize->add_setting( 'bramble_show_meta_date' , array(
	    'type' 				=> 'theme_mod',
	    'transport' 		=> 'refresh',
	    'sanitize_callback'	=> 'esc_html'
	) );
	
	$wp_customize->add_control( 'bramble_show_meta_date', array(
		'type'      => 'select',
		'label'     => __( 'Show Date', 'bramble' ),
		'description'     => __( 'Show the date on each post', 'bramble' ),
		'section'   => 'bramble_post_meta',
		'settings'  => 'bramble_show_meta_date',
		'choices'   => array(
					'yes' => 'Yes',
		            'no' => 'No'
		        ),
		'priority'   => 1
	) );
	
	$wp_customize->add_setting( 'bramble_show_meta_author' , array(
	    'type' 				=> 'theme_mod',
	    'transport' 		=> 'refresh',
	    'sanitize_callback'	=> 'esc_html'
	) );
	
	$wp_customize->add_control( 'bramble_show_meta_author', array(
		'type'      => 'select',
		'label'     => __( 'Show Author', 'bramble' ),
		'description'     => __( 'Show the author on each post.', 'bramble' ),
		'section'   => 'bramble_post_meta',
		'settings'  => 'bramble_show_meta_author',
		'choices'   => array(
					'yes' => 'Yes',
		            'no' => 'No'
		        ),
		'priority'   => 1
	) );
	
	$wp_customize->add_setting( 'bramble_show_meta_categories' , array(
	    'type' 				=> 'theme_mod',
	    'transport' 		=> 'refresh',
	    'sanitize_callback'	=> 'esc_html'
	) );
	
	$wp_customize->add_control( 'bramble_show_meta_categories', array(
		'type'      => 'select',
		'label'     => __( 'Show Categories', 'bramble' ),
		'description'     => __( 'Show the categories on each post.', 'bramble' ),
		'section'   => 'bramble_post_meta',
		'settings'  => 'bramble_show_meta_categories',
		'choices'   => array(
					'yes' => 'Yes',
		            'no' => 'No'
		        ),
		'priority'   => 1
	) );
	
	$wp_customize->add_setting( 'bramble_show_meta_comments' , array(
	    'type' 				=> 'theme_mod',
	    'transport' 		=> 'refresh',
	    'sanitize_callback'	=> 'esc_html'
	) );
	
	$wp_customize->add_control( 'bramble_show_meta_comments', array(
		'type'      => 'select',
		'label'     => __( 'Show Comment Count', 'bramble' ),
		'description'     => __( 'Show the comment count on each post.', 'bramble' ),
		'section'   => 'bramble_post_meta',
		'settings'  => 'bramble_show_meta_comments',
		'choices'   => array(
					'yes' => 'Yes',
		            'no' => 'No'
		        ),
		'priority'   => 1
	) );
	
	
	// -- Archive Layout
	
	$wp_customize->add_section( 'bramble_archives', array(
		'priority'		 => 2,
	    'title'     	 => __( 'Archives', 'bramble' ),
		'panel'			=> 'bramble_blog'
	) );	
	
	$wp_customize->add_setting( 'bramble_archive_layout' , array(
	    'default'     		=> __( 'full-width', 'bramble' ),
	    'type' 				=> 'theme_mod',
	    'transport' 		=> 'refresh',
	    'sanitize_callback'	=> 'esc_html'
	) );
	
	$wp_customize->add_control( 'bramble_archive_layout', array(
		'type'      => 'select',
		'label'     => __( 'Archive Layout', 'bramble' ),
		'section'   => 'bramble_archives',
		'settings'  => 'bramble_archive_layout',
		'choices'   => array(
		            'standard' => 'Standard',
					'full-width' => 'Full Width',
		            'masonry' => 'Masonry',
					'masonry-full-width' => 'Masonry Full Width',
		        ),
		'priority'   => 1
	) );
	
	$wp_customize->add_setting( 'bramble_archive_show_excerpt' , array(
	    'type' 				=> 'theme_mod',
	    'transport' 		=> 'refresh',
	    'sanitize_callback'	=> 'esc_html'
	) );
	
	$wp_customize->add_control( 'bramble_archive_show_excerpt', array(
		'type'      => 'select',
		'label'     => __( 'Show Excerpts', 'bramble' ),
		'section'   => 'bramble_archives',
		'settings'  => 'bramble_archive_show_excerpt',
		'choices'   => array(
					'yes' => 'Yes',
		            'no' => 'No'
		        ),
		'priority'   => 2
	) );
	
	
	// -- Shop --------------------------------------------------------------------------------------------------

	$wp_customize->add_panel( 'bramble_shop', array(
		'priority'		 => 4.7,
	    'title'     	 => __( 'Shop', 'bramble' )
	) );
	
	// -- Layout
	
	$wp_customize->add_section( 'bramble_shop_layout_section', array(
		'priority'		 => 1,
	    'title'     	 => __( 'Layout', 'bramble' ),
		'panel'			=> 'bramble_shop'
	) );
	
	$wp_customize->add_setting( 'bramble_shop_layout' , array(
	    'type' 				=> 'theme_mod',
	    'transport' 		=> 'refresh',
	    'sanitize_callback'	=> 'esc_html'
	) );
	
	$wp_customize->add_control( 'bramble_shop_layout', array(
		'type'      => 'select',
		'label'     => __( 'Layout', 'bramble' ),
		'description'     => __( 'Choose the layout of your shop pages.', 'bramble' ),
		'section'   => 'bramble_shop_layout_section',
		'settings'  => 'bramble_shop_layout',
		'choices'   => array(
					'full-width' => 'Full Width',
		            'has-sidebar' => 'With Sidebar'
		        ),
		'priority'   => 1
	) );
	
	$wp_customize->add_setting( 'bramble_shop_product_count' , array(
	    'type' 				=> 'theme_mod',
	    'transport' 		=> 'refresh',
	    'sanitize_callback'	=> 'esc_html'
	) );
	
	$wp_customize->add_control('bramble_shop_product_count', array(
	        'label' => __( 'Products Per Page', 'bramble' ),
	        'section' => 'bramble_shop_layout_section',
	        'type' => 'text',
	    )
	);
	
	// -- Style
	
	$wp_customize->add_section( 'bramble_shop_style_section', array(
		'priority'		 => 2,
	    'title'     	 => __( 'Style', 'bramble' ),
		'panel'			=> 'bramble_shop'
	) );
	
	// Product Hover Color
	$wp_customize->add_setting( 'bramble_product_hover_color' );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bramble_product_hover_color', array(
			'label'      => __( 'Product Hover Color', 'bramble' ),
			'section'    => 'bramble_shop_style_section',
			'settings'   => 'bramble_product_hover_color',
			'priority'   => 1
		) )
	);
	
	// Shop Accent Color
	$wp_customize->add_setting( 'bramble_shop_accent_color' );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bramble_shop_accent_color', array(
			'label'      => __( 'Accent Color', 'bramble' ),
			'section'    => 'bramble_shop_style_section',
			'settings'   => 'bramble_shop_accent_color',
			'priority'   => 2
		) )
	);
	
	
	
	// -- Social Sharing --------------------------------------------------------------------------------------------------
	
	$wp_customize->add_section( 'bramble_social_sharing', array(
		'priority'		 => 5,
	    'title'     	 => __( 'Social Sharing', 'bramble' )
	) );
	
	$wp_customize->add_setting( 'bramble_show_social_on_posts' , array(
	    'type' 				=> 'theme_mod',
	    'transport' 		=> 'refresh',
	    'sanitize_callback'	=> 'esc_html'
	) );
	
	$wp_customize->add_control( 'bramble_show_social_on_posts', array(
		'type'      => 'select',
		'label'     => __( 'Show Sharing Links on Posts', 'bramble' ),
		'section'   => 'bramble_social_sharing',
		'settings'  => 'bramble_show_social_on_posts',
		'choices'   => array(
					'yes' => 'Yes',
		            'no' => 'No'
		        ),
		'priority'   => 1
	) );
	
	$wp_customize->add_setting( 'bramble_show_social_on_projects' , array(
	    'type' 				=> 'theme_mod',
	    'transport' 		=> 'refresh',
	    'sanitize_callback'	=> 'esc_html'
	) );
	
	$wp_customize->add_control( 'bramble_show_social_on_projects', array(
		'type'      => 'select',
		'label'     => __( 'Show Sharing Links on Projects', 'bramble' ),
		'section'   => 'bramble_social_sharing',
		'settings'  => 'bramble_show_social_on_projects',
		'choices'   => array(
					'no' => 'No',
					'yes' => 'Yes'
		        ),
		'priority'   => 1.1
	) );
	
	$wp_customize->add_setting( 'bramble_show_social_on_pages' , array(
	    'type' 				=> 'theme_mod',
	    'transport' 		=> 'refresh',
	    'sanitize_callback'	=> 'esc_html'
	) );
	
	$wp_customize->add_control( 'bramble_show_social_on_pages', array(
		'type'      => 'select',
		'label'     => __( 'Show Sharing Links on Pages', 'bramble' ),
		'section'   => 'bramble_social_sharing',
		'settings'  => 'bramble_show_social_on_pages',
		'choices'   => array(
					'no' => 'No',
					'yes' => 'Yes'
		        ),
		'priority'   => 1.2
	) );
	
	$wp_customize->add_setting( 'bramble_show_facebook' , array(
	    'type' 				=> 'theme_mod',
	    'transport' 		=> 'refresh',
	    'sanitize_callback'	=> 'esc_html'
	) );
	
	$wp_customize->add_control( 'bramble_show_facebook', array(
		'type'      => 'select',
		'label'     => __( 'Show Facebook', 'bramble' ),
		'section'   => 'bramble_social_sharing',
		'settings'  => 'bramble_show_facebook',
		'choices'   => array(
					'yes' => 'Yes',
		            'no' => 'No'
		        ),
		'priority'   => 2
	) );
	
	$wp_customize->add_setting( 'bramble_show_twitter' , array(
	    'type' 				=> 'theme_mod',
	    'transport' 		=> 'refresh',
	    'sanitize_callback'	=> 'esc_html'
	) );
	
	$wp_customize->add_control( 'bramble_show_twitter', array(
		'type'      => 'select',
		'label'     => __( 'Show Twitter', 'bramble' ),
		'section'   => 'bramble_social_sharing',
		'settings'  => 'bramble_show_twitter',
		'choices'   => array(
					'yes' => 'Yes',
		            'no' => 'No'
		        ),
		'priority'   => 3
	) );
	
	$wp_customize->add_setting( 'bramble_show_google' , array(
	    'type' 				=> 'theme_mod',
	    'transport' 		=> 'refresh',
	    'sanitize_callback'	=> 'esc_html'
	) );
	
	$wp_customize->add_control( 'bramble_show_google', array(
		'type'      => 'select',
		'label'     => __( 'Show Google Plus', 'bramble' ),
		'section'   => 'bramble_social_sharing',
		'settings'  => 'bramble_show_google',
		'choices'   => array(
					'yes' => 'Yes',
		            'no' => 'No'
		        ),
		'priority'   => 4
	) );
	
	$wp_customize->add_setting( 'bramble_show_linkedin' , array(
	    'type' 				=> 'theme_mod',
	    'transport' 		=> 'refresh',
	    'sanitize_callback'	=> 'esc_html'
	) );
	
	$wp_customize->add_control( 'bramble_show_linkedin', array(
		'type'      => 'select',
		'label'     => __( 'Show LinkedIn', 'bramble' ),
		'section'   => 'bramble_social_sharing',
		'settings'  => 'bramble_show_linkedin',
		'choices'   => array(
					'yes' => 'Yes',
		            'no' => 'No'
		        ),
		'priority'   => 5
	) );
	
	$wp_customize->add_setting( 'bramble_show_pinterest' , array(
	    'type' 				=> 'theme_mod',
	    'transport' 		=> 'refresh',
	    'sanitize_callback'	=> 'esc_html'
	) );
	
	$wp_customize->add_control( 'bramble_show_pinterest', array(
		'type'      => 'select',
		'label'     => __( 'Show Pinterest', 'bramble' ),
		'section'   => 'bramble_social_sharing',
		'settings'  => 'bramble_show_pinterest',
		'choices'   => array(
					'yes' => 'Yes',
		            'no' => 'No'
		        ),
		'priority'   => 6
	) );
	
	$wp_customize->add_setting( 'bramble_show_tumblr' , array(
	    'type' 				=> 'theme_mod',
	    'transport' 		=> 'refresh',
	    'sanitize_callback'	=> 'esc_html'
	) );
	
	$wp_customize->add_control( 'bramble_show_tumblr', array(
		'type'      => 'select',
		'label'     => __( 'Show Tumblr', 'bramble' ),
		'section'   => 'bramble_social_sharing',
		'settings'  => 'bramble_show_tumblr',
		'choices'   => array(
					'yes' => 'Yes',
		            'no' => 'No'
		        ),
		'priority'   => 7
	) );
	
	// -- Other Styles Panel
	
	$wp_customize->add_panel( 'bramble_other_styles', array(
		'priority'		 => 5.5,
	    'title'     	 => __( 'Other Styles', 'bramble' )
	) );
	
	// Global Text
	$wp_customize->add_section( 'bramble_base_text', array(
		'priority'		 => 1,
	    'title'     	 => __( 'Text', 'bramble' ),
		'panel'          => 'bramble_other_styles'
	) );
	
	// Link Color
	$wp_customize->add_setting( 'bramble_base_text_color' );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bramble_base_text_color', array(
			'label'      => __( 'Color', 'bramble' ),
			'section'    => 'bramble_base_text',
			'settings'   => 'bramble_base_text_color',
			'description'     	 => __( 'Set the base text color of your site.', 'bramble' ),
			'priority'   => 1
		) )
	);
	
	// Content Area
	$wp_customize->add_section( 'bramble_content_area', array(
		'priority'		 => 1,
	    'title'     	 => __( 'Content Area', 'bramble' ),
		'panel'          => 'bramble_other_styles'
	) );
	
	// Content Area Background Color
	$wp_customize->add_setting( 'bramble_content_background_color' );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bramble_content_background_color', array(
			'label'      => __( 'Background Color', 'bramble' ),
			'section'    => 'bramble_content_area',
			'settings'   => 'bramble_content_background_color',
			'description'     	 => __( 'Set the background color of the content area.', 'bramble' ),
			'priority'   => 1
		) )
	);

	// Links
	$wp_customize->add_section( 'bramble_links', array(
		'priority'		 => 2,
	    'title'     	 => __( 'Links', 'bramble' ),
		'description'     	 => __( 'Set the color of links that appear in the content text.', 'bramble' ),
		'panel'          => 'bramble_other_styles'
	) );
	
	// Link Color
	$wp_customize->add_setting( 'bramble_link_color' );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bramble_link_color', array(
			'label'      => __( 'Link Color', 'bramble' ),
			'section'    => 'bramble_links',
			'settings'   => 'bramble_link_color',
			'priority'   => 1
		) )
	);

	// Link Hover Color (Incl. Active)
	$wp_customize->add_setting( 'bramble_link_hover_color' );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bramble_link_hover_color', array(
			'label'      => __( 'Link Hover Color', 'bramble' ),
			'section'    => 'bramble_links',
			'settings'   => 'bramble_link_hover_color',
			'priority'   => 2
		) )
	);
	
	// Buttons
	$wp_customize->add_section( 'bramble_buttons', array(
		'priority'		 => 3,
	    'title'     	 => __( 'Buttons', 'bramble' ),
		'description'     	 => __( 'Set the color of buttons that appear on the site. This includes form and pagination buttons.', 'bramble' ),
		'panel'          => 'bramble_other_styles'
	) );
	
	// Button Color
	$wp_customize->add_setting( 'bramble_button_color' );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bramble_button_color', array(
			'label'      => __( 'Button Color', 'bramble' ),
			'section'    => 'bramble_buttons',
			'settings'   => 'bramble_button_color',
			'priority'   => 1
		) )
	);
	
	// Button Text Color
	$wp_customize->add_setting( 'bramble_button_text_color' );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bramble_button_text_color', array(
			'label'      => __( 'Button Text Color', 'bramble' ),
			'section'    => 'bramble_buttons',
			'settings'   => 'bramble_button_text_color',
			'priority'   => 2
		) )
	);
	
	
	// -- Custom  CSS Section

	$wp_customize->add_section( 'bramble_css' , array(
	    'title'     	=> __( 'Custom CSS', 'bramble' ),
	    'description'	=> __('Add your own custom CSS.', 'bramble'),
	    'priority'   	=> 59,
	) );
	
	$wp_customize->add_setting( 'bramble_custom_css' , array(
	    'default'     => __('', 'bramble'),
	    'type' => 'theme_mod',
	    'transport' => 'refresh',
	    'sanitize_callback'	 => 'wp_kses_post'
	) );

	$wp_customize->add_control( new TTrust_Textarea_Control( $wp_customize, 'bramble_custom_css', array(
		'label'        => __('CSS', 'bramble'),
		'section'    => 'bramble_css',
		'settings'   => 'bramble_custom_css',
		'priority'   => 62
	) ) );

	// -- Footer Section -----------------------------------

	$wp_customize->add_panel( 'bramble_footer' , array(
	    'title'      => __( 'Footer', 'port' ),
	    'priority'   => 62.5,
	) );
	
	$wp_customize->add_section( 'bramble_footer_layout', array(
		'priority'		 => 1,
		'panel'		 => 'bramble_footer',
	    'title'     	 => __( 'Layout', 'bramble' )
	) );
	
	$wp_customize->add_setting( 'bramble_footer_columns' , array(
	    'type' 				=> 'theme_mod',
	    'transport' 		=> 'refresh',
	    'sanitize_callback'	=> 'esc_html'
	) );
	
	$wp_customize->add_control( 'bramble_footer_columns', array(
		'type'      => 'select',
		'label'     => __( 'Widget Columns', 'bramble' ),
		'section'   => 'bramble_footer_layout',
		'settings'  => 'bramble_footer_columns',
		'choices'   => array(
					'3' => '3',
					'4' => '4',
					'1' => '1',
		            '2' => '2',
					'5' => '5'
		        ),
		'priority'   => 1
	) );
	
	$wp_customize->add_section( 'bramble_footer_style', array(
		'priority'		 => 2,
		'panel'		 => 'bramble_footer',
	    'title'     	 => __( 'Style', 'bramble' )
	) );
	
	// Footer Background Color
	$wp_customize->add_setting( 'bramble_footer_bg_color' );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bramble_footer_bg_color', array(
			'label'      => __( 'Background Color', 'bramble' ),
			'section'    => 'bramble_footer_style',
			'settings'   => 'bramble_footer_bg_color',
			'priority'   => 1
		) )
	);
	
	// Footer Widget Title Color
	$wp_customize->add_setting( 'bramble_footer_widget_title_color' );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bramble_footer_widget_title_color', array(
			'label'      => __( 'Widget Title Color', 'bramble' ),
			'section'    => 'bramble_footer_style',
			'settings'   => 'bramble_footer_widget_title_color',
			'priority'   => 1.5
		) )
	);
	
	// Footer Text Color
	$wp_customize->add_setting( 'bramble_footer_text_color' );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bramble_footer_text_color', array(
			'label'      => __( 'Text Color', 'bramble' ),
			'section'    => 'bramble_footer_style',
			'settings'   => 'bramble_footer_text_color',
			'priority'   => 2
		) )
	);
	
	// Footer Link Color
	$wp_customize->add_setting( 'bramble_footer_link_color' );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bramble_footer_link_color', array(
			'label'      => __( 'Link Color', 'bramble' ),
			'section'    => 'bramble_footer_style',
			'settings'   => 'bramble_footer_link_color',
			'priority'   => 3
		) )
	);

	// Footer Link Hover Color
	$wp_customize->add_setting( 'bramble_footer_link_hover_color' );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bramble_footer_link_hover_color', array(
			'label'      => __( 'Link Hover Color', 'bramble' ),
			'section'    => 'bramble_footer_style',
			'settings'   => 'bramble_footer_link_hover_color',
			'priority'   => 4
		) )
	);
	
	// Footer Content
	$wp_customize->add_section( 'bramble_footer_text', array(
		'priority'		 => 2,
		'panel'		 => 'bramble_footer',
	    'title'     	 => __( 'Content', 'bramble' )
	) );

	// Left Footer Text (Custom Control)
	$wp_customize->add_setting( 'bramble_footer_left' , array(
	    'default'     => '',
	    'type' => 'theme_mod',
	    'transport' => 'refresh',
	    'sanitize_callback'	 => 'wp_kses_post'
	) );

	$wp_customize->add_control( new Bramble_Textarea_Control( $wp_customize, 'footer_left', array(
	    'label'   => __('Primary Footer Text', 'port'),
	    'section' => 'bramble_footer_text',
	    'settings'   => 'bramble_footer_left',
	    'priority'   => 71
	) ) );

	// Right Footer Text (Custom Control)
	$wp_customize->add_setting( 'bramble_footer_right' , array(
	    'default'     => '',
	    'type' => 'theme_mod',
	    'transport' => 'refresh',
	    'sanitize_callback'	 => 'wp_kses_post'
	) );

	$wp_customize->add_control( new Bramble_Textarea_Control( $wp_customize, 'footer_right', array(
	    'label'   => __('Secondary Footer Text', 'port'),
	    'section' => 'bramble_footer_text',
	    'settings'   => 'bramble_footer_right',
	    'priority'   => 72
	) ) );

}
add_action( 'customize_register', 'bramble_customize_register' );

// Require the gfonts picker class
require_once('google-fonts/gfonts.class.php');


// Instantiate the class
$tt_gfp = new bramble_gfonts();


