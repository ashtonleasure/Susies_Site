<?php
/**
 * @category Bramble
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/WebDevStudios/CMB2
 */

/**
 * Get the bootstrap! If using the plugin from wordpress.org, REMOVE THIS!
 */

if ( file_exists( dirname( __FILE__ ) . '/cmb2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/cmb2/init.php';
} elseif ( file_exists( dirname( __FILE__ ) . '/CMB2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/CMB2/init.php';
}


//Header Options

add_action( 'cmb2_init', 'bramble_register_header_metabox' );
function bramble_register_header_metabox() {
	
	$prefix = '_bramble_header_';

	$cmb_header = new_cmb2_box( array(
		'id'            => $prefix . 'options',
		'title'         => __( 'Header Options', 'bramble' ),
		'object_types'  => array( 'project','page','post', 'product' ), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true
	) );
	
	$cmb_header->add_field( array(
		'name'             => __( 'Layout', 'bramble' ),
		'desc'             => __( 'Choose between a wide or narrow header', 'bramble' ),
		'id'               => $prefix . 'layout',
		'type'             => 'select',
		'options'          => array(
			'default'   => __( 'Default', 'bramble' ),
			'wide-header' => __( 'Wide', 'bramble' ),
			'narrow-header' => __( 'Narrow', 'bramble' )
		),
	) );
	
	$cmb_header->add_field( array(
	    'name' => __( 'Site Title Color', 'bramble' ),
	    'id'   => $prefix . 'site_title_color',
	    'type' => 'colorpicker',
	    'default'  => ''
	) );
	
	$cmb_header->add_field( array(
	    'name' => __( 'Background Color', 'bramble' ),
	    'id'   => $prefix . 'background_color',
	    'type' => 'colorpicker',
	    'default'  => ''
	) );
	
	$cmb_header->add_field( array(
	    'name' => __( 'Menu Color', 'bramble' ),
	    'id'   => $prefix . 'menu_color',
	    'type' => 'colorpicker',
	    'default'  => ''
	) );
	
	$cmb_header->add_field( array(
	    'name' => __( 'Menu Color Hover', 'bramble' ),
	    'id'   => $prefix . 'menu_hover_color',
	    'type' => 'colorpicker',
	    'default'  => ''
	) );
	
	$cmb_header->add_field( array(
		'name'             => __( 'Main Menu', 'bramble' ),
		'desc'             => __( 'Select a different main menu to show on this page.', 'bramble' ),
		'id'               => $prefix . 'menu_main',
		'type'             => 'select',
		'options'          => customMenus(),
	) );
	
	$cmb_header->add_field( array(
		'name'             => __( 'Mobile Menu', 'bramble' ),
		'desc'             => __( 'Select a different mobile menu to show on this page.', 'bramble' ),
		'id'               => $prefix . 'menu_mobile',
		'type'             => 'select',
		'options'          => customMenus(),
	) );
	
}

//Title Options

add_action( 'cmb2_init', 'bramble_register_title_metabox' );
function bramble_register_title_metabox() {

	$prefix = '_bramble_title_';

	$cmb_title = new_cmb2_box( array(
		'id'            => $prefix . 'options',
		'title'         => __( 'Title Area Options', 'bramble' ),
		'object_types'  => array( 'page', 'project', 'post', 'product'), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true
	) );
	
	$cmb_title->add_field( array(
		'name'             => __( 'Show Title Area', 'bramble' ),
		'desc'             => __( 'Hide or show the page title area.', 'bramble' ),
		'id'               => $prefix . 'show',
		'type'             => 'select',
		'show_option_none' => false,
		'options'          => array(
			'yes' => __( 'Yes', 'bramble' ),
			'no'   => __( 'No', 'bramble' ),
		),
	) );
	
	$cmb_title->add_field( array(
		'name'       => __( 'Subtitle Text', 'bramble' ),
		'desc'       => __( 'This text will be displayed below the title on pages and projects.', 'bramble' ),
		'id'         => $prefix . 'subtitle',
		'type'       => 'text'
	) );
	
	$cmb_title->add_field( array(
		'name'             => __( 'Hide Text', 'bramble' ),
		'id'               => $prefix . 'hide_text',
		'type'             => 'select',
		'options'          => array(
			'no'     => __( 'No', 'bramble' ),
			'yes'   => __( 'Yes', 'bramble' ),
		),
	) );
	
	$cmb_title->add_field( array(
		'name' => __( 'Title Image', 'bramble' ),
		'desc' => __( 'This image will appear above the title text.', 'bramble' ),
		'id'   => $prefix . 'img',
		'type' => 'file',
	) );
	
	$cmb_title->add_field( array(
		'name'             => __( 'Title Alignment', 'bramble' ),
		'id'               => $prefix . 'alignment',
		'type'             => 'select',
		'options'          => array(
			''     => __( 'Default', 'bramble' ),
			'center'     => __( 'Center', 'bramble' ),
			'left'   => __( 'Left', 'bramble' ),
			'right'   => __( 'Right', 'bramble' )
		),
	) );

	$cmb_title->add_field( array(
		'name' => __( 'Title Area Height', 'bramble' ),
		'desc' => __( 'Set the height of the title area in pixels. (ex. 400)', 'bramble' ),
		'id'   => $prefix . 'area_height',
		'type' => 'text_small'
	) );
	
	$cmb_title->add_field( array(
		'name' => __( 'Title Background Image', 'bramble' ),
		'desc' => __( 'Upload an image or enter a URL.', 'bramble' ),
		'id'   => $prefix . 'bg_img',
		'type' => 'file',
	) );
	
	$cmb_title->add_field( array(
		'name'             => __( 'Enable Background Parallax', 'bramble' ),
		'id'               => $prefix . 'parallax',
		'type'             => 'select',
		'options'          => array(
			'no'     => __( 'No', 'bramble' ),
			'yes'   => __( 'Yes', 'bramble' ),
		),
	) );
	
	$cmb_title->add_field( array(
	    'name' => __( 'Title Text Color', 'bramble' ),
	    'id'   => $prefix . 'color',
	    'type' => 'colorpicker',
	    'default'  => '#191919'
	) );
	
}

//Project Options

add_action( 'cmb2_init', 'bramble_register_project_metabox' );
function bramble_register_project_metabox() {
	
	$prefix = '_bramble_project_';

	$cmb_project = new_cmb2_box( array(
		'id'            => $prefix . 'options',
		'title'         => __( 'Project Options', 'bramble' ),
		'object_types'  => array( 'project', ), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true
	) );
	
	$cmb_project->add_field( array(
		'name'             => __( 'Featured Image Size', 'bramble' ),
		'desc'             => __( 'Select the size of the featured image for this project.', 'bramble' ),
		'id'               => $prefix . 'featured_image_size',
		'type'             => 'select',
		'options'          => array(
			'square' => __( 'Default', 'bramble' ),
			'wide'   => __( 'Wide', 'bramble' ),
			'tall'     => __( 'Tall', 'bramble' ),
			'wide_tall'     => __( 'Wide and Tall', 'bramble' ),
		),
	) );
	
	$cmb_project->add_field( array(
		'name' => __( 'Lightbox Image', 'bramble' ),
		'desc' => __( 'This image will open if lightbox mode is enabled.', 'bramble' ),
		'id'   => $prefix . 'lightbox_img',
		'type' => 'file',
	) );
	
	$cmb_project->add_field( array(
		'name' => __( 'Lightbox Video', 'bramble' ),
		'desc' => __( 'Enter the URL of your video. This video will open if lightbox mode is enabled.', 'bramble' ),
		'id'   => $prefix . 'lightbox_video',
		'type' => 'text',
	) );
}

//Blog Options

add_action( 'cmb2_init', 'bramble_register_blog_metabox' );
function bramble_register_blog_metabox() {
	
	$prefix = '_bramble_blog_';

	$cmb_blog = new_cmb2_box( array(
		'id'            => $prefix . 'options',
		'title'         => __( 'Blog Options', 'bramble' ),
		'object_types'  => array( 'page', ), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true
	) );
	
	$cmb_blog->add_field( array(
		'name'             => __( 'Posts per Page', 'bramble' ),
		'desc'             => __( 'Select the number of posts per page.', 'bramble' ),
		'id'               => $prefix . 'posts_per_page',
		'type'             => 'text_small',
		'default' => '10'
	) );
	
	$cmb_blog->add_field( array(
		'name'             => __( 'Show Excerpt', 'bramble' ),
		'desc'             => __( 'Show an excerpt for each post.', 'bramble' ),
		'id'               => $prefix . 'show_excerpt',
		'type'             => 'select',
		'options'          => array(
			'yes' => __( 'Yes', 'bramble' ),
			'no'   => __( 'No', 'bramble' )
		),
	) );
	
	$cmb_blog->add_field( array(
		'name'             => __( 'Featured Image Size', 'bramble' ),
		'desc'             => __( 'Select the size of the featured image for standard blog layouts.', 'bramble' ),
		'id'               => $prefix . 'featured_img_size',
		'type'             => 'select',
		'options'          => array(
			'large' => __( 'Large', 'bramble' ),
			'small'   => __( 'Small', 'bramble' )
		),
	) );
}

//Post Options

add_action( 'cmb2_init', 'bramble_register_post_metabox' );
function bramble_register_post_metabox() {
	
	$prefix = '_bramble_post_';

	$cmb_post = new_cmb2_box( array(
		'id'            => $prefix . 'options',
		'title'         => __( 'Post Options', 'bramble' ),
		'object_types'  => array( 'post', ), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true
	) );
	
	$cmb_post->add_field( array(
		'name'             => __( 'Featured Image Size', 'bramble' ),
		'desc'             => __( 'Select the size of the featured image for this post on masonry layouts.', 'bramble' ),
		'id'               => $prefix . 'featured_image_size',
		'type'             => 'select',
		'options'          => array(
			'landscape' => __( 'Landscape', 'bramble' ),
			'portrait'   => __( 'Portrait', 'bramble' ),
			'square'     => __( 'Square', 'bramble' )
		),
	) );
	
	$cmb_post->add_field( array(
		'name'             => __( 'Show Featured Image', 'bramble' ),
		'desc'             => __( 'Show featured image on single post.', 'bramble' ),
		'id'               => $prefix . 'show_featured_img',
		'type'             => 'select',
		'options'          => array(
			'yes' => __( 'Yes', 'bramble' ),
			'no'   => __( 'No', 'bramble' )
		),
	) );
	
	$cmb_post->add_field( array(
		'name'             => __( 'Full Width Content', 'bramble' ),
		'desc'             => __( 'Make the content full width with no sidebar.', 'bramble' ),
		'id'               => $prefix . 'full_width',
		'type'             => 'select',
		'options'          => array(
			'no'   => __( 'No', 'bramble' ),
			'yes' => __( 'Yes', 'bramble' )
		),
	) );
		
}

//Sidebar Options

add_action( 'cmb2_init', 'bramble_register_sidebar_metabox' );
function bramble_register_sidebar_metabox() {

	$prefix = '_bramble_sidebar_';

	$cmb_title = new_cmb2_box( array(
		'id'            => $prefix . 'options',
		'title'         => __( 'Sidebar Options', 'bramble' ),
		'object_types'  => array( 'page', 'post'), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true
	) );
	
	$cmb_title->add_field( array(
		'name'             => __( 'Custom Widget Area', 'bramble' ),
		'desc'             => __( 'Select a custom widget area to show in this sidebar.', 'bramble' ),
		'id'               => $prefix . 'custom_widget_area',
		'type'             => 'select',
		'show_option_none' => false,
		'options'          => array_merge(array('' => ''), get_custom_sidebars()),
	) );
	
}

//Footer Options

add_action( 'cmb2_init', 'bramble_register_footer_metabox' );
function bramble_register_footer_metabox() {

	$prefix = '_bramble_footer_';

	$cmb_footer = new_cmb2_box( array(
		'id'            => $prefix . 'options',
		'title'         => __( 'Footer Options', 'bramble' ),
		'object_types'  => array( 'page', 'post', 'project'), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true
	) );
	
	$cmb_footer->add_field( array(
		'name'             => __( 'Hide Footer', 'bramble' ),
		'desc'             => __( 'Choose to hide or show the footer on this page.', 'bramble' ),
		'id'               => $prefix . 'hide',
		'type'             => 'select',
		'options'          => array(
			'no'   => __( 'No', 'bramble' ),
			'yes' => __( 'Yes', 'bramble' )
		),
	) );
	
	$cmb_footer->add_field( array(
		'name'             => __( 'Custom Widget Area', 'bramble' ),
		'desc'             => __( 'Select a custom widget area to show in this footer.', 'bramble' ),
		'id'               => $prefix . 'custom_widget_area',
		'type'             => 'select',
		'show_option_none' => false,
		'options'          => array_merge(array('' => ''), get_custom_sidebars()),
	) );
	
}

