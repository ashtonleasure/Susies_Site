<?php

//Set page builder defaults
function bramble_siteorgin_defaults($defaults){
	// Post types
	$defaults['post-types'] = array('page', 'post', 'project');
	$defaults['margin-bottom'] = '0';
	return $defaults;
}
add_filter( 'siteorigin_panels_settings_defaults', 'bramble_siteorgin_defaults' );

//Remove the built-in posts carousel widget
function bramble_panels_widgets( $widgets ){
	unset($widgets['SiteOrigin_Widget_PostCarousel_Widget']);
	return $widgets;
}
add_filter( 'siteorigin_panels_widgets', 'bramble_panels_widgets', 11);



function bramble_filter_siteorigin_active_widgets($active){
    $active['so-price-table-widget'] = true;
	$active['so-headline-widget'] = true;
	$active['so-social-media-buttons-widget'] = true;
	$active['so-post-carousel-widget'] = false;
    return $active;
}
add_filter('siteorigin_widgets_active_widgets', 'bramble_filter_siteorigin_active_widgets');

function bramble_siteoriginpanels_row_attributes($attr, $row) {
  if(!empty($row['style']['class'])) {
    if(empty($attr['style'])) $attr['style'] = '';
    $attr['style'] .= 'margin-bottom: 0px;';
    $attr['style'] .= 'margin-left: 0px;';
    $attr['style'] .= 'margin-right: 0px;';
  }

  return $attr;
}
add_filter('siteorigin_panels_row_attributes', 'bramble_siteoriginpanels_row_attributes', 10, 2);


//Add custom row styles
function bramble_panels_row_background_styles($fields) {
 
  $fields['custom_row_id'] = array(
	     'name'      => __('Custom ID', 'bramble'),
	     'type'      => 'text',
	     'group'     => 'attributes',
	     'priority'  => 1,
  );

  $fields['equal_column_height'] = array(
        'name'      => __('Equal Column Height', 'bramble'),
        'type'      => 'select',
        'group'     => 'layout',
        'default'   => 'no',
        'priority'  => 10,
        'options'   => array(
             "no"      => __("No", "bramble"),
             "yes"   => __("Yes", "bramble"),
              ),
  );

  $fields['padding_top'] = array(
        'name'      => __('Padding Top', 'bramble'),
        'type'      => 'measurement',
        'group'     => 'layout',
        'priority'  => 8,
  );
  $fields['padding_bottom'] = array(
        'name'      => __('Padding Bottom', 'bramble'),
        'type'      => 'measurement',
        'group'     => 'layout',
        'priority'  => 8.5,
  );
  $fields['padding_left'] = array(
        'name'      => __('Padding Left', 'bramble'),
        'type'      => 'measurement',
        'group'     => 'layout',
        'priority'  => 9,
      );
  $fields['padding_right'] = array(
        'name'      => __('Padding Right', 'bramble'),
        'type'      => 'measurement',
        'group'     => 'layout',
        'priority'  => 9,
      );
  $fields['background_image'] = array(
        'name'      => __('Background Image', 'bramble'),
        'group'     => 'design',
        'type'      => 'image',
        'priority'  => 5,
      );
  $fields['background_image_position'] = array(
        'name'      => __('Background Image Position', 'bramble'),
        'type'      => 'select',
        'group'     => 'design',
        'default'   => 'center top',
        'priority'  => 6,
        'options'   => array(
               "left top"       => __("Left Top", "bramble"),
               "left center"    => __("Left Center", "bramble"),
               "left bottom"    => __("Left Bottom", "bramble"),
               "center top"     => __("Center Top", "bramble"),
               "center center"  => __("Center Center", "bramble"),
               "center bottom"  => __("Center Bottom", "bramble"),
               "right top"      => __("Right Top", "bramble"),
               "right center"   => __("Right Center", "bramble"),
               "right bottom"   => __("Right Bottom", "bramble")
                ),
      );
  $fields['background_image_style'] = array(
        'name'      => __('Background Image Style', 'bramble'),
        'type'      => 'select',
        'group'     => 'design',
        'default'   => 'cover',
        'priority'  => 6,
        'options'   => array(
             "cover"      => __("Cover", "bramble"),
             "parallax"   => __("Parallax", "bramble"),
             "no-repeat"  => __("No Repeat", "bramble"),
             "repeat"     => __("Repeat", "bramble"),
             "repeat-x"   => __("Repeat-X", "bramble"),
             "repeat-y"   => __("Repeat-y", "bramble"),
              ),
        );
  $fields['border_top'] = array(
        'name'      => __('Border Top Size', 'bramble'),
        'type'      => 'measurement',
        'group'     => 'design',
        'priority'  => 8,
  );
  $fields['border_top_color'] = array(
        'name'      => __('Border Top Color', 'bramble'),
        'type'      => 'color',
        'group'     => 'design',
        'priority'  => 8.5,
      );
  $fields['border_bottom'] = array(
        'name'      => __('Border Bottom Size', 'bramble'),
        'type'      => 'measurement',
        'group'     => 'design',
        'priority'  => 9,
  );
  $fields['border_bottom_color'] = array(
        'name' => __('Border Bottom Color', 'bramble'),
        'type' => 'color',
        'group' => 'design',
        'priority' => 9.5,
  );
  $fields['canvas_animation_effect'] = array(
        'name'      => __('Canvas Animation Effect', 'bramble'),
        'type'      => 'select',
        'group'     => 'design',
        'default'   => 'none',
        'priority'  => 10,
        'options'   => array(
             "none"      => __("None", "bramble"),
             "constellation"   => __("Constellation", "bramble"),
              ),
  );
  return $fields;
}
add_filter('siteorigin_panels_row_style_fields', 'bramble_panels_row_background_styles');

function bramble_panels_remove_row_background_styles($fields) {
 unset( $fields['background_image_attachment'] );
 unset( $fields['background_display'] );
 unset( $fields['padding'] );
 unset( $fields['border_color'] );
 return $fields;
}
add_filter('siteorigin_panels_row_style_fields', 'bramble_panels_remove_row_background_styles');

function bramble_panels_row_background_styles_attributes($attributes, $args) {

  if(!empty($args['background_image'])) {
    $url = wp_get_attachment_image_src( $args['background_image'], 'full' );
	$unique_class = 'row-'.uniqid();
    if(empty($url) || $url[0] == site_url() ) {
		$bg_img = $args['background_image'];
      } else {
		$bg_img = $url[0];
      }
	  $attributes['style'] .= 'background-image: url(' . $bg_img . ');';
      if(!empty($args['background_image_style'])) {
            switch( $args['background_image_style'] ) {
              case 'no-repeat':
                $attributes['style'] .= 'background-repeat: no-repeat;';
                break;
              case 'repeat':
                $attributes['style'] .= 'background-repeat: repeat;';
                break;
              case 'repeat-x':
                $attributes['style'] .= 'background-repeat: repeat-x;';
                break;
              case 'repeat-y':
                $attributes['style'] .= 'background-repeat: repeat-y;';
                break;
              case 'cover':
                $attributes['style'] .= 'background-size: cover;';
                break;
              case 'parallax':
				//$attributes['style'] = '';
				wp_enqueue_script( 'bramble-parallax-scroll');
                $attributes['class'][] .= 'parallax-section';
				$attributes['class'][] .= $unique_class;
				$attributes['data-parallax-image'] = $bg_img;
				$attributes['data-parallax-id'] = '.'.$unique_class;
                break;
            }
        }
  }

  if(!empty($args['background_image_position'])) { 
      $attributes['style'] .= 'background-position: '.esc_attr($args['background_image_position']).'; ';
  }
  
  if(!empty($args['padding_top'])) {
    if( function_exists('is_numeric' ) ) {
      if (is_numeric($args['padding_top'])) {
        $attributes['style'] .= 'padding-top: '.esc_attr($args['padding_top']).'px; ';
      } else {
         $attributes['style'] .= 'padding-top: '.esc_attr($args['padding_top']).'; ';
      }
    } else {
       $attributes['style'] .= 'padding-top: '.esc_attr($args['padding_top']).'; ';
    }
  }
  if(!empty($args['padding_bottom'])){
    if( function_exists('is_numeric' ) ) {
      if (is_numeric($args['padding_bottom'])) {
        $attributes['style'] .= 'padding-bottom: '.esc_attr($args['padding_bottom']).'px; ';
      } else {
        $attributes['style'] .= 'padding-bottom: '.esc_attr($args['padding_bottom']).'; ';
      }
    } else {
      $attributes['style'] .= 'padding-bottom: '.esc_attr($args['padding_bottom']).'; ';
    }
 }
 
 if(!empty($args['padding_left'])){
   $attributes['style'] .= 'padding-left: '.esc_attr($args['padding_left']).'; ';
 }
 if(!empty($args['padding_right'])){
   $attributes['style'] .= 'padding-right: '.esc_attr($args['padding_right']).'; ';
 }
 if(!empty($args['border_top'])){
   $attributes['style'] .= 'border-top: '.esc_attr($args['border_top']).' solid; ';
 }
 if(!empty($args['border_top_color'])){
   $attributes['style'] .= 'border-top-color: '.$args['border_top_color'].'; ';
 }
 if(!empty($args['border_bottom'])){
   $attributes['style'] .= 'border-bottom: '.esc_attr($args['border_bottom']).' solid; ';
 }
  if(!empty($args['border_bottom_color'])){
   $attributes['style'] .= 'border-bottom-color: '.$args['border_bottom_color'].'; ';
 }

if(!empty($args['custom_row_id'])){
   $attributes['data-row-id'] = $args['custom_row_id'];
 }

if(!empty($args['equal_column_height'])){
	if($args['equal_column_height']=="yes"){
   		$attributes['class'][] = 'equal-column-height';
	}
 }

if(!empty($args['canvas_animation_effect'])){
	if($args['canvas_animation_effect']!="none"){
		wp_enqueue_script('bramble-constellation');
   		$attributes['class'][] = 'canvas-' . $args['canvas_animation_effect'];
	}
 }

  return $attributes;
}
add_filter('siteorigin_panels_row_style_attributes', 'bramble_panels_row_background_styles_attributes', 10, 2);




//////////////////////////////////////////////
//Prebuilt Layouts
//////////////////////////////////////////////

function bramble_prebuilt_layouts($layouts){
    
	$layouts['home-agency'] = array(
		'name' => __('Home: Agency', 'bramble'),
		'description' => __('Layout for demo Home: Agency', 'bramble'),
		'widgets' => 
		  array (
		    0 => 
		    array (
		      'title' => '',
		      'text' => '<h1><span style="font-size: 66px;">Bramble.<br /> </span><span style="font-size: 66px;">WordPress.</span></h1><p style="text-align: left;"><span style="font-size: 18px;">A powerful and flexible multipurpose WordPress theme. Use it to build a wide range of web projects, such as websites for agencies, business, or online shops.</span></p>',
		      'autop' => true,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Editor_Widget',
		        'raw' => false,
		        'grid' => 0,
		        'cell' => 1,
		        'id' => 0,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		          'font_color' => '#ffffff',
		        ),
		      ),
		    ),
		    1 => 
		    array (
		      'text' => 'BUY NOW',
		      'url' => 'http://themetrust.com/themes/bramble',
		      'button_icon' => 
		      array (
		        'icon_selected' => '',
		        'icon_color' => false,
		        'icon' => 0,
		      ),
		      'design' => 
		      array (
		        'align' => 'left',
		        'theme' => 'wire',
		        'button_color' => '#ffffff',
		        'text_color' => '#17aec6',
		        'hover' => true,
		        'font_size' => '1',
		        'rounding' => '1.5',
		        'padding' => '1',
		      ),
		      'attributes' => 
		      array (
		        'id' => '',
		        'title' => '',
		        'onclick' => '',
		      ),
		      'new_window' => false,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Button_Widget',
		        'raw' => false,
		        'grid' => 0,
		        'cell' => 1,
		        'id' => 1,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    2 => 
		    array (
		      'features' => 
		      array (
		        0 => 
		        array (
		          'container_color' => '#17aec6',
		          'icon' => 'fontawesome-codepen',
		          'icon_color' => '#FFFFFF',
		          'icon_image' => 0,
		          'title' => 'Page Builder',
		          'text' => 'Layout pages how you want. Drag and drop to reorder elements.',
		          'more_text' => '',
		          'more_url' => '',
		        ),
		      ),
		      'fonts' => 
		      array (
		        'title_options' => 
		        array (
		          'font' => 'default',
		          'size' => 'px',
		          'size_unit' => 'px',
		          'color' => false,
		          'so_field_container_state' => 'closed',
		        ),
		        'text_options' => 
		        array (
		          'font' => 'default',
		          'size' => 'px',
		          'size_unit' => 'px',
		          'color' => false,
		          'so_field_container_state' => 'closed',
		        ),
		        'more_text_options' => 
		        array (
		          'font' => 'default',
		          'size' => 'px',
		          'size_unit' => 'px',
		          'color' => false,
		          'so_field_container_state' => 'closed',
		        ),
		        'so_field_container_state' => 'closed',
		      ),
		      'container_shape' => 'round',
		      'container_size' => '58px',
		      'container_size_unit' => 'px',
		      'icon_size' => '24px',
		      'icon_size_unit' => 'px',
		      'per_row' => 1,
		      'responsive' => true,
		      '_sow_form_id' => '569505db630bb',
		      'title_link' => false,
		      'icon_link' => false,
		      'new_window' => false,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Features_Widget',
		        'raw' => false,
		        'grid' => 1,
		        'cell' => 0,
		        'id' => 2,
		        'style' => 
		        array (
		          'padding' => '50px',
		          'background' => '#282828',
		          'background_display' => 'tile',
		          'font_color' => '#ffffff',
		        ),
		      ),
		    ),
		    3 => 
		    array (
		      'features' => 
		      array (
		        0 => 
		        array (
		          'container_color' => '#17aec6',
		          'icon' => 'fontawesome-tablet',
		          'icon_color' => '#FFFFFF',
		          'icon_image' => 0,
		          'title' => 'Responsive',
		          'text' => 'Your site will amazing on all screen sizes.',
		          'more_text' => '',
		          'more_url' => '',
		        ),
		      ),
		      'fonts' => 
		      array (
		        'title_options' => 
		        array (
		          'font' => 'default',
		          'size' => 'px',
		          'size_unit' => 'px',
		          'color' => false,
		          'so_field_container_state' => 'closed',
		        ),
		        'text_options' => 
		        array (
		          'font' => 'default',
		          'size' => 'px',
		          'size_unit' => 'px',
		          'color' => false,
		          'so_field_container_state' => 'closed',
		        ),
		        'more_text_options' => 
		        array (
		          'font' => 'default',
		          'size' => 'px',
		          'size_unit' => 'px',
		          'color' => false,
		          'so_field_container_state' => 'closed',
		        ),
		        'so_field_container_state' => 'closed',
		      ),
		      'container_shape' => 'round',
		      'container_size' => '58px',
		      'container_size_unit' => 'px',
		      'icon_size' => '24px',
		      'icon_size_unit' => 'px',
		      'per_row' => 1,
		      'responsive' => true,
		      '_sow_form_id' => '569505f17d78e',
		      'title_link' => false,
		      'icon_link' => false,
		      'new_window' => false,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Features_Widget',
		        'raw' => false,
		        'grid' => 1,
		        'cell' => 1,
		        'id' => 3,
		        'style' => 
		        array (
		          'padding' => '50px',
		          'background' => '#2d2d2d',
		          'background_display' => 'tile',
		          'font_color' => '#ffffff',
		        ),
		      ),
		    ),
		    4 => 
		    array (
		      'features' => 
		      array (
		        0 => 
		        array (
		          'container_color' => '#17aec6',
		          'icon' => 'fontawesome-laptop',
		          'icon_color' => '#FFFFFF',
		          'icon_image' => 0,
		          'title' => 'Retina Ready',
		          'text' => 'Built with the latest technology in mind, your site will look crisp on retina displays.',
		          'more_text' => '',
		          'more_url' => '',
		        ),
		      ),
		      'fonts' => 
		      array (
		        'title_options' => 
		        array (
		          'font' => 'default',
		          'size' => 'px',
		          'size_unit' => 'px',
		          'color' => false,
		          'so_field_container_state' => 'closed',
		        ),
		        'text_options' => 
		        array (
		          'font' => 'default',
		          'size' => 'px',
		          'size_unit' => 'px',
		          'color' => false,
		          'so_field_container_state' => 'closed',
		        ),
		        'more_text_options' => 
		        array (
		          'font' => 'default',
		          'size' => 'px',
		          'size_unit' => 'px',
		          'color' => false,
		          'so_field_container_state' => 'closed',
		        ),
		        'so_field_container_state' => 'closed',
		      ),
		      'container_shape' => 'round',
		      'container_size' => '58px',
		      'container_size_unit' => 'px',
		      'icon_size' => '24px',
		      'icon_size_unit' => 'px',
		      'per_row' => 1,
		      'responsive' => true,
		      '_sow_form_id' => '56950618f3db5',
		      'title_link' => false,
		      'icon_link' => false,
		      'new_window' => false,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Features_Widget',
		        'raw' => false,
		        'grid' => 1,
		        'cell' => 2,
		        'id' => 4,
		        'style' => 
		        array (
		          'padding' => '50px',
		          'background' => '#3f3f3f',
		          'background_display' => 'tile',
		          'font_color' => '#ffffff',
		        ),
		      ),
		    ),
		    5 => 
		    array (
		      'title' => '',
		      'text' => '<h3 style="text-align: center;"><span style="color: #333333;">Our Work</span></h3><p style="text-align: center;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur ut porttitor enim, vel condimentum eros. Nullam tellus metus, rutrum at nibh quis, porta viverra orci. Pellentesque cursus dolor leo, eget porta mauris lobortis ut. Sed imperdiet magna a magna blandit auctor.</p>',
		      'autop' => true,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Editor_Widget',
		        'raw' => false,
		        'grid' => 2,
		        'cell' => 1,
		        'id' => 5,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    6 => 
		    array (
		      'text' => 'View Full Portfolio',
		      'url' => 'http://demos.themetrust.com/bramble/portfolio-masonry/',
		      'button_icon' => 
		      array (
		        'icon_selected' => '',
		        'icon_color' => false,
		        'icon' => 0,
		        'so_field_container_state' => 'open',
		      ),
		      'design' => 
		      array (
		        'align' => 'center',
		        'theme' => 'flat',
		        'button_color' => '#17aec6',
		        'text_color' => '#ffffff',
		        'hover' => true,
		        'font_size' => '1',
		        'rounding' => '1.5',
		        'padding' => '1',
		        'so_field_container_state' => 'closed',
		      ),
		      'attributes' => 
		      array (
		        'id' => '',
		        'title' => '',
		        'onclick' => '',
		        'so_field_container_state' => 'closed',
		      ),
		      '_sow_form_id' => '56ba0caab1bec',
		      'new_window' => false,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Button_Widget',
		        'raw' => false,
		        'grid' => 2,
		        'cell' => 1,
		        'id' => 6,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    7 => 
		    array (
		      'title' => '',
		      'show_filter' => 'no',
		      'filter_selected_color' => '#21b9d1',
		      'filter_alignment' => 'center',
		      'count' => '6',
		      'thumb_proportions' => 'square',
		      'layout' => 'rows without gutter',
		      'columns' => '3',
		      'orderby' => 'date',
		      'order' => 'DESC',
		      'hover_effect' => 'effect-1',
		      'hover_color' => '',
		      'hover_text_color' => '',
		      'show_skills' => 'no',
		      'show_load_more' => 'no',
		      'load_more_color' => '',
		      'load_more_text_color' => '',
		      'enable_lightbox' => 'no',
		      'skills' => '',
		      'panels_info' => 
		      array (
		        'class' => 'TTrust_Portfolio',
		        'raw' => false,
		        'grid' => 3,
		        'cell' => 0,
		        'id' => 7,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    8 => 
		    array (
		      'title' => '',
		      'text' => '<h3 style="text-align: center;">Meet Our Team</h3><p style="text-align: center;"><span style="color: #808080;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur ut porttitor enim, vel condimentum eros. Nullam tellus metus, rutrum at nibh quis, porta viverra orci. Pellentesque cursus dolor leo, eget porta mauris lobortis ut. Sed imperdiet magna.</span></p>',
		      'autop' => true,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Editor_Widget',
		        'grid' => 4,
		        'cell' => 1,
		        'id' => 8,
		        'style' => 
		        array (
		          'background_image_attachment' => false,
		          'background_display' => 'tile',
		          'font_color' => '#ffffff',
		        ),
		      ),
		    ),
		    9 => 
		    array (
		      'image' => 52,
		      'image_fallback' => '',
		      'size' => 'full',
		      'title' => '',
		      'alt' => '',
		      'url' => '',
		      'bound' => true,
		      'full_width' => true,
		      '_sow_form_id' => '568d62f39160d',
		      'new_window' => false,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Image_Widget',
		        'raw' => false,
		        'grid' => 5,
		        'cell' => 1,
		        'id' => 9,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    10 => 
		    array (
		      'title' => '',
		      'text' => '<p class="member-role" style="text-align: center;"><span style="color: #ffffff;"><strong>Frank Thompson<br /></strong></span><span style="color: #999999;">CEO</span></p>',
		      'text_selected_editor' => 'tinymce',
		      'autop' => true,
		      '_sow_form_id' => '568d630311a84',
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Editor_Widget',
		        'raw' => false,
		        'grid' => 5,
		        'cell' => 1,
		        'id' => 10,
		        'style' => 
		        array (
		          'padding' => '10px',
		          'background_display' => 'tile',
		          'font_color' => '#ffffff',
		        ),
		      ),
		    ),
		    11 => 
		    array (
		      'image' => 60,
		      'image_fallback' => '',
		      'size' => 'full',
		      'title' => '',
		      'alt' => '',
		      'url' => '',
		      'bound' => true,
		      'full_width' => true,
		      'new_window' => false,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Image_Widget',
		        'raw' => false,
		        'grid' => 5,
		        'cell' => 2,
		        'id' => 11,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    12 => 
		    array (
		      'title' => '',
		      'text' => '<p class="member-role" style="text-align: center;"><span style="color: #ffffff;"><strong>Shawn Carson</strong></span><br /><span style="color: #999999;">Senior Designer</span></p>',
		      'text_selected_editor' => 'tinymce',
		      'autop' => true,
		      '_sow_form_id' => '568d635033c50',
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Editor_Widget',
		        'raw' => false,
		        'grid' => 5,
		        'cell' => 2,
		        'id' => 12,
		        'style' => 
		        array (
		          'padding' => '10px',
		          'background_display' => 'tile',
		          'font_color' => '#ffffff',
		        ),
		      ),
		    ),
		    13 => 
		    array (
		      'image' => 69,
		      'image_fallback' => '',
		      'size' => 'full',
		      'title' => '',
		      'alt' => '',
		      'url' => '',
		      'bound' => true,
		      'full_width' => true,
		      'new_window' => false,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Image_Widget',
		        'raw' => false,
		        'grid' => 5,
		        'cell' => 3,
		        'id' => 13,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    14 => 
		    array (
		      'title' => '',
		      'text' => '<p class="member-role" style="text-align: center;"><span style="color: #ffffff;"><strong>Jessica Clark</strong></span><br /><span style="color: #999999;">Senior Developer</span></p>',
		      'text_selected_editor' => 'tinymce',
		      'autop' => true,
		      '_sow_form_id' => '568d635822144',
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Editor_Widget',
		        'raw' => false,
		        'grid' => 5,
		        'cell' => 3,
		        'id' => 14,
		        'style' => 
		        array (
		          'padding' => '10px',
		          'background_display' => 'tile',
		          'font_color' => '#ffffff',
		        ),
		      ),
		    ),
		    15 => 
		    array (
		      'title' => '',
		      'text' => '<h3 style="text-align: center;"><span style="color: #333333;">Recent News</span></h3>',
		      'autop' => true,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Editor_Widget',
		        'raw' => false,
		        'grid' => 6,
		        'cell' => 0,
		        'id' => 15,
		        'style' => 
		        array (
		          'padding' => '40px',
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    16 => 
		    array (
		      'title' => '',
		      'count' => '3',
		      'category' => '',
		      'layout' => 'grid',
		      'columns' => '3',
		      'alignment' => 'left',
		      'orderby' => 'date',
		      'order' => 'DESC',
		      'boxed' => 'yes',
		      'show_excerpt' => 'no',
		      'carousel-nav-color' => '',
		      'panels_info' => 
		      array (
		        'class' => 'TTrust_Blog',
		        'raw' => false,
		        'grid' => 6,
		        'cell' => 0,
		        'id' => 16,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    17 => 
		    array (
		      'text' => 'READ MORE NEWS',
		      'url' => '',
		      'button_icon' => 
		      array (
		        'icon_selected' => '',
		        'icon_color' => false,
		        'icon' => 0,
		      ),
		      'design' => 
		      array (
		        'align' => 'center',
		        'theme' => 'flat',
		        'button_color' => '#17aec6',
		        'text_color' => '#ffffff',
		        'hover' => true,
		        'font_size' => '1',
		        'rounding' => '1.5',
		        'padding' => '1',
		      ),
		      'attributes' => 
		      array (
		        'id' => '',
		        'title' => '',
		        'onclick' => '',
		      ),
		      'new_window' => false,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Button_Widget',
		        'raw' => false,
		        'grid' => 6,
		        'cell' => 0,
		        'id' => 17,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    18 => 
		    array (
		      'title' => '',
		      'text' => '',
		      'autop' => true,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Editor_Widget',
		        'raw' => false,
		        'grid' => 6,
		        'cell' => 0,
		        'id' => 18,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		  ),
		  'grids' => 
		  array (
		    0 => 
		    array (
		      'cells' => 3,
		      'style' => 
		      array (
		        'bottom_margin' => '0px',
		        'row_stretch' => 'full',
		        'equal_column_height' => 'no',
		        'padding_top' => '20%',
		        'padding_bottom' => '20%',
		        'background_image' => 100,
		        'background_image_position' => 'center bottom',
		        'background_image_style' => 'cover',
		        'canvas_animation_effect' => 'constellation',
		      ),
		    ),
		    1 => 
		    array (
		      'cells' => 3,
		      'style' => 
		      array (
		        'bottom_margin' => '0px',
		        'gutter' => '0px',
		        'row_stretch' => 'full-stretched',
		        'equal_column_height' => 'yes',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		        'canvas_animation_effect' => 'none',
		      ),
		    ),
		    2 => 
		    array (
		      'cells' => 3,
		      'style' => 
		      array (
		        'bottom_margin' => '0px',
		        'gutter' => '0px',
		        'row_stretch' => 'full',
		        'background' => '#efefef',
		        'equal_column_height' => 'no',
		        'padding_top' => '15%',
		        'padding_bottom' => '15%',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		        'canvas_animation_effect' => 'none',
		      ),
		    ),
		    3 => 
		    array (
		      'cells' => 1,
		      'style' => 
		      array (
		        'bottom_margin' => '0px',
		        'row_stretch' => 'full-stretched',
		        'equal_column_height' => 'no',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		        'canvas_animation_effect' => 'none',
		      ),
		    ),
		    4 => 
		    array (
		      'cells' => 3,
		      'style' => 
		      array (
		        'bottom_margin' => '0px',
		        'gutter' => '0px',
		        'row_stretch' => 'full',
		        'background' => '#272727',
		        'equal_column_height' => 'no',
		        'padding_top' => '10%',
		        'padding_bottom' => '10%',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		        'canvas_animation_effect' => 'none',
		      ),
		    ),
		    5 => 
		    array (
		      'cells' => 5,
		      'style' => 
		      array (
		        'bottom_margin' => '0px',
		        'gutter' => '30px',
		        'row_stretch' => 'full',
		        'background' => '#272727',
		        'equal_column_height' => 'no',
		        'padding_bottom' => '10%',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		        'canvas_animation_effect' => 'none',
		      ),
		    ),
		    6 => 
		    array (
		      'cells' => 1,
		      'style' => 
		      array (
		        'row_stretch' => 'full',
		        'background' => '#f4f4f4',
		        'equal_column_height' => 'no',
		        'padding_top' => '30px',
		        'padding_bottom' => '60px',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		        'canvas_animation_effect' => 'none',
		      ),
		    ),
		  ),
		  'grid_cells' => 
		  array (
		    0 => 
		    array (
		      'grid' => 0,
		      'weight' => 0.20120483747533,
		    ),
		    1 => 
		    array (
		      'grid' => 0,
		      'weight' => 0.60447683300694,
		    ),
		    2 => 
		    array (
		      'grid' => 0,
		      'weight' => 0.19431832951773,
		    ),
		    3 => 
		    array (
		      'grid' => 1,
		      'weight' => 0.33333333333333,
		    ),
		    4 => 
		    array (
		      'grid' => 1,
		      'weight' => 0.33333333333333,
		    ),
		    5 => 
		    array (
		      'grid' => 1,
		      'weight' => 0.33333333333333,
		    ),
		    6 => 
		    array (
		      'grid' => 2,
		      'weight' => 0.19025401762571,
		    ),
		    7 => 
		    array (
		      'grid' => 2,
		      'weight' => 0.61949196474858,
		    ),
		    8 => 
		    array (
		      'grid' => 2,
		      'weight' => 0.19025401762571,
		    ),
		    9 => 
		    array (
		      'grid' => 3,
		      'weight' => 1,
		    ),
		    10 => 
		    array (
		      'grid' => 4,
		      'weight' => 0.19025401762571,
		    ),
		    11 => 
		    array (
		      'grid' => 4,
		      'weight' => 0.61949196474858,
		    ),
		    12 => 
		    array (
		      'grid' => 4,
		      'weight' => 0.19025401762571,
		    ),
		    13 => 
		    array (
		      'grid' => 5,
		      'weight' => 0.101,
		    ),
		    14 => 
		    array (
		      'grid' => 5,
		      'weight' => 0.266,
		    ),
		    15 => 
		    array (
		      'grid' => 5,
		      'weight' => 0.266,
		    ),
		    16 => 
		    array (
		      'grid' => 5,
		      'weight' => 0.266,
		    ),
		    17 => 
		    array (
		      'grid' => 5,
		      'weight' => 0.101,
		    ),
		    18 => 
		    array (
		      'grid' => 6,
		      'weight' => 1,
		    ),
		  ),
	);
	
	$layouts['home-business'] = array(
		'name' => __('Home: Business', 'bramble'),
		'description' => __('Layout for demo Home: Business', 'bramble'),
		'widgets' => 
		  array (
		    0 => 
		    array (
		      'title' => '',
		      'text' => '[rev_slider alias="business"]',
		      'filter' => false,
		      'panels_info' => 
		      array (
		        'class' => 'WP_Widget_Text',
		        'raw' => false,
		        'grid' => 0,
		        'cell' => 0,
		        'id' => 0,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    1 => 
		    array (
		      'features' => 
		      array (
		        0 => 
		        array (
		          'container_color' => '#5cb2a7',
		          'icon' => 'fontawesome-codepen',
		          'icon_color' => '#ffffff',
		          'icon_image' => 0,
		          'title' => 'Page Builder',
		          'text' => 'Bramble comes with a page builder that allows you to bramble pages exactly how you want. ',
		          'more_text' => '',
		          'more_url' => '',
		        ),
		        1 => 
		        array (
		          'container_color' => '#5cb2a7',
		          'icon' => 'fontawesome-mobile',
		          'icon_color' => '#ffffff',
		          'icon_image' => 0,
		          'title' => 'Responsive Layout',
		          'text' => 'Bramble is a responsive theme. Its layout adjusts to look great on any screen size or device.',
		          'more_text' => '',
		          'more_url' => '',
		        ),
		        2 => 
		        array (
		          'container_color' => '#5cb2a7',
		          'icon' => 'fontawesome-eye',
		          'icon_color' => '#ffffff',
		          'icon_image' => 0,
		          'title' => 'Retina Ready',
		          'text' => 'Built with the latest technology in mind, rest assured that your site will look crisp on retina displays.',
		          'more_text' => '',
		          'more_url' => '',
		        ),
		      ),
		      'container_shape' => 'round',
		      'container_size' => 50,
		      'icon_size' => 25,
		      'per_row' => 1,
		      'responsive' => true,
		      'title_link' => false,
		      'icon_link' => false,
		      'new_window' => false,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Features_Widget',
		        'raw' => false,
		        'grid' => 1,
		        'cell' => 0,
		        'id' => 1,
		        'style' => 
		        array (
		          'class' => 'left',
		          'widget_css' => 'p{opacity: .5}',
		          'padding' => '10%',
		          'background' => '#f7f7f7',
		          'background_display' => 'tile',
		          'font_color' => '#161616',
		        ),
		      ),
		    ),
		    2 => 
		    array (
		      'title' => '',
		      'text' => '<h3 style="text-align: left;"><span style="color: #242424;">Beautiful Style.</span></h3><p style="text-align: left;">Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequ</p>',
		      'autop' => true,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Editor_Widget',
		        'grid' => 1,
		        'cell' => 1,
		        'id' => 2,
		        'style' => 
		        array (
		          'class' => 'v-center',
		          'padding' => '10%',
		          'background' => '#ffffff',
		          'background_image_attachment' => false,
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    3 => 
		    array (
		      'title' => 'Our Work',
		      'sub_title' => '',
		      'design' => 
		      array (
		        'background_color' => '#303030',
		        'border_color' => false,
		        'button_align' => 'right',
		        'so_field_container_state' => 'open',
		      ),
		      'button' => 
		      array (
		        'text' => 'View More',
		        'url' => '',
		        'button_icon' => 
		        array (
		          'icon_selected' => '',
		          'icon_color' => false,
		          'icon' => 0,
		          'so_field_container_state' => 'open',
		        ),
		        'design' => 
		        array (
		          'theme' => 'flat',
		          'button_color' => '#5cb2a7',
		          'text_color' => '#ffffff',
		          'hover' => true,
		          'font_size' => '1',
		          'rounding' => '1.5',
		          'padding' => '1',
		          'so_field_container_state' => 'open',
		        ),
		        'attributes' => 
		        array (
		          'id' => '',
		          'title' => '',
		          'onclick' => '',
		          'so_field_container_state' => 'closed',
		        ),
		        'new_window' => false,
		      ),
		      '_sow_form_id' => '5694ff47515c1',
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Cta_Widget',
		        'raw' => false,
		        'grid' => 2,
		        'cell' => 0,
		        'id' => 3,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		          'font_color' => '#ffffff',
		        ),
		      ),
		    ),
		    4 => 
		    array (
		      'title' => '',
		      'show_filter' => 'no',
		      'filter_selected_color' => '',
		      'filter_alignment' => 'center',
		      'count' => '3',
		      'thumb_proportions' => 'landscape',
		      'layout' => 'rows without gutter',
		      'columns' => '3',
		      'orderby' => 'date',
		      'order' => 'DESC',
		      'hover_effect' => 'effect-1',
		      'hover_color' => '',
		      'hover_text_color' => '',
		      'show_skills' => 'yes',
		      'show_load_more' => 'no',
		      'load_more_color' => '#20b8c9',
		      'load_more_text_color' => '#ffffff',
		      'enable_lightbox' => 'no',
		      'skills' => '',
		      'panels_info' => 
		      array (
		        'class' => 'TTrust_Portfolio',
		        'raw' => false,
		        'grid' => 3,
		        'cell' => 0,
		        'id' => 4,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    5 => 
		    array (
		      'title' => '',
		      'text' => '<h3 style="text-align: center;"><span style="color: #242424;">FROM THE BLOG</span></h3><p style="text-align: center;">This is a blog widget that you can add anywhere. Display recent posts as a grid</p>',
		      'autop' => true,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Editor_Widget',
		        'raw' => false,
		        'grid' => 4,
		        'cell' => 0,
		        'id' => 5,
		        'style' => 
		        array (
		          'padding' => '5%',
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    6 => 
		    array (
		      'title' => '',
		      'count' => '3',
		      'category' => '',
		      'layout' => 'grid',
		      'columns' => '3',
		      'alignment' => 'left',
		      'orderby' => 'date',
		      'order' => 'DESC',
		      'boxed' => 'yes',
		      'show_excerpt' => 'yes',
		      'carousel-nav-color' => '',
		      'panels_info' => 
		      array (
		        'class' => 'TTrust_Blog',
		        'raw' => false,
		        'grid' => 4,
		        'cell' => 0,
		        'id' => 6,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    7 => 
		    array (
		      'title' => '',
		      'text' => '<h3>What Our Clients are Saying</h3>',
		      'autop' => true,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Editor_Widget',
		        'raw' => false,
		        'grid' => 5,
		        'cell' => 0,
		        'id' => 7,
		        'style' => 
		        array (
		          'class' => 'v-center',
		          'padding' => '15%',
		          'background_image_attachment' => 507,
		          'background_display' => 'cover',
		          'font_color' => '#ffffff',
		        ),
		      ),
		    ),
		    8 => 
		    array (
		      'title' => '',
		      'count' => '3',
		      'layout' => 'carousel',
		      'columns' => '1',
		      'alignment' => 'center',
		      'order' => 'rand',
		      'carousel-nav-color' => '',
		      'panels_info' => 
		      array (
		        'class' => 'TTrust_Testimonials',
		        'raw' => false,
		        'grid' => 5,
		        'cell' => 1,
		        'id' => 8,
		        'style' => 
		        array (
		          'padding' => '15%',
		          'background' => '#ffffff',
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    9 => 
		    array (
		      'title' => '',
		      'text' => '<p><img class="aligncenter size-full wp-image-703" src="http://demos.themetrust.com/bramble/wp-content/uploads/sites/2/2016/01/client_logos_light.png" alt="client_logos_light" width="1823" height="238" /></p>',
		      'autop' => true,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Editor_Widget',
		        'raw' => false,
		        'grid' => 6,
		        'cell' => 0,
		        'id' => 9,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    10 => 
		    array (
		      'map_center' => '350 5th Ave, New York, NY 10118',
		      'settings' => 
		      array (
		        'map_type' => 'interactive',
		        'width' => '640',
		        'height' => '480',
		        'zoom' => 12,
		        'scroll_zoom' => true,
		        'draggable' => true,
		        'so_field_container_state' => 'open',
		        'disable_default_ui' => false,
		        'keep_centered' => false,
		      ),
		      'markers' => 
		      array (
		        'marker_at_center' => true,
		        'marker_icon' => 0,
		        'info_display' => 'click',
		        'so_field_container_state' => 'closed',
		        'markers_draggable' => false,
		        'marker_positions' => 
		        array (
		        ),
		      ),
		      'styles' => 
		      array (
		        'style_method' => 'raw_json',
		        'styled_map_name' => '',
		        'raw_json_map_styles' => '[{"featureType":"landscape","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"stylers":[{"hue":"#00aaff"},{"saturation":-100},{"gamma":2.15},{"lightness":12}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"visibility":"on"},{"lightness":24}]},{"featureType":"road","elementType":"geometry","stylers":[{"lightness":57}]}]',
		        'so_field_container_state' => 'open',
		        'custom_map_styles' => 
		        array (
		        ),
		      ),
		      'directions' => 
		      array (
		        'origin' => '',
		        'destination' => '',
		        'travel_mode' => 'driving',
		        'so_field_container_state' => 'closed',
		        'avoid_highways' => false,
		        'avoid_tolls' => false,
		        'waypoints' => 
		        array (
		        ),
		        'optimize_waypoints' => false,
		      ),
		      'api_key_section' => 
		      array (
		        'api_key' => '',
		        'so_field_container_state' => 'closed',
		      ),
		      '_sow_form_id' => '569502e42094a',
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_GoogleMap_Widget',
		        'raw' => false,
		        'grid' => 7,
		        'cell' => 0,
		        'id' => 10,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		  ),
		  'grids' => 
		  array (
		    0 => 
		    array (
		      'cells' => 1,
		      'style' => 
		      array (
		        'row_stretch' => 'full-stretched',
		        'equal_column_height' => 'no',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		      ),
		    ),
		    1 => 
		    array (
		      'cells' => 2,
		      'style' => 
		      array (
		        'gutter' => '0px',
		        'row_stretch' => 'full-stretched',
		        'equal_column_height' => 'yes',
		        'padding_top' => '0px',
		        'padding_bottom' => '0px',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		        'canvas_animation_effect' => 'none',
		      ),
		    ),
		    2 => 
		    array (
		      'cells' => 1,
		      'style' => 
		      array (
		        'row_stretch' => 'full',
		        'background' => '#303030',
		        'equal_column_height' => 'no',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		        'canvas_animation_effect' => 'none',
		      ),
		    ),
		    3 => 
		    array (
		      'cells' => 1,
		      'style' => 
		      array (
		        'bottom_margin' => '0px',
		        'row_stretch' => 'full-stretched',
		        'background' => '#f9f8f4',
		        'equal_column_height' => 'no',
		        'padding_top' => '0px',
		        'padding_bottom' => '0px',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		      ),
		    ),
		    4 => 
		    array (
		      'cells' => 1,
		      'style' => 
		      array (
		        'equal_column_height' => 'no',
		        'padding_top' => '40px',
		        'padding_bottom' => '40px',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		      ),
		    ),
		    5 => 
		    array (
		      'cells' => 2,
		      'style' => 
		      array (
		        'gutter' => '0px',
		        'row_stretch' => 'full-stretched',
		        'equal_column_height' => 'yes',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		        'canvas_animation_effect' => 'none',
		      ),
		    ),
		    6 => 
		    array (
		      'cells' => 1,
		      'style' => 
		      array (
		        'row_stretch' => 'full',
		        'background' => '#2d2d2d',
		        'equal_column_height' => 'no',
		        'padding_top' => '70px',
		        'padding_bottom' => '50px',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		        'canvas_animation_effect' => 'none',
		      ),
		    ),
		    7 => 
		    array (
		      'cells' => 1,
		      'style' => 
		      array (
		        'row_stretch' => 'full-stretched',
		        'background' => '#f4f4f4',
		        'equal_column_height' => 'no',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'parallax',
		        'canvas_animation_effect' => 'none',
		      ),
		    ),
		  ),
		  'grid_cells' => 
		  array (
		    0 => 
		    array (
		      'grid' => 0,
		      'weight' => 1,
		    ),
		    1 => 
		    array (
		      'grid' => 1,
		      'weight' => 0.5,
		    ),
		    2 => 
		    array (
		      'grid' => 1,
		      'weight' => 0.5,
		    ),
		    3 => 
		    array (
		      'grid' => 2,
		      'weight' => 1,
		    ),
		    4 => 
		    array (
		      'grid' => 3,
		      'weight' => 1,
		    ),
		    5 => 
		    array (
		      'grid' => 4,
		      'weight' => 1,
		    ),
		    6 => 
		    array (
		      'grid' => 5,
		      'weight' => 0.5,
		    ),
		    7 => 
		    array (
		      'grid' => 5,
		      'weight' => 0.5,
		    ),
		    8 => 
		    array (
		      'grid' => 6,
		      'weight' => 1,
		    ),
		    9 => 
		    array (
		      'grid' => 7,
		      'weight' => 1,
		    ),
		  ),
	);
	
	$layouts['home-app'] = array(
		'name' => __('Home: App', 'bramble'),
		'description' => __('Layout for demo Home: App', 'bramble'),
		'widgets' => 
		  array (
		    0 => 
		    array (
		      'title' => '',
		      'text' => '[rev_slider alias="app"]',
		      'filter' => false,
		      'panels_info' => 
		      array (
		        'class' => 'WP_Widget_Text',
		        'raw' => false,
		        'grid' => 0,
		        'cell' => 0,
		        'id' => 0,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    1 => 
		    array (
		      'title' => '',
		      'text' => '<h1 style="text-align: left;">Easy to Use Interface.</h1>
		<p style="text-align: left;"><span style="color: #89929d;">Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</span></p>

		<a class="button" style="background-color: #ff7f66" href="http://demos.themetrust.com/bramble/features">Learn More</a>
		',
		      'text_selected_editor' => 'html',
		      'autop' => true,
		      '_sow_form_id' => '5672d4e5916b7',
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Editor_Widget',
		        'raw' => false,
		        'grid' => 1,
		        'cell' => 0,
		        'id' => 1,
		        'style' => 
		        array (
		          'class' => '.v-center',
		          'padding' => '30px',
		          'background_display' => 'tile',
		          'font_color' => '#ffffff',
		        ),
		      ),
		    ),
		    2 => 
		    array (
		      'image' => 292,
		      'image_fallback' => '',
		      'size' => 'full',
		      'title' => '',
		      'alt' => '',
		      'url' => '',
		      'bound' => true,
		      '_sow_form_id' => '56964b5c5a72a',
		      'new_window' => false,
		      'full_width' => false,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Image_Widget',
		        'raw' => false,
		        'grid' => 1,
		        'cell' => 1,
		        'id' => 2,
		        'style' => 
		        array (
		          'padding' => '80px',
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    3 => 
		    array (
		      'features' => 
		      array (
		        0 => 
		        array (
		          'container_color' => false,
		          'icon' => 'icomoon-image2',
		          'icon_color' => '#159db3',
		          'icon_image' => 0,
		          'title' => 'Parallax Backgrounds',
		          'text' => 'Easily create sections that have a parallax background using the Page Builder. ',
		          'more_text' => '',
		          'more_url' => '',
		        ),
		        1 => 
		        array (
		          'container_color' => false,
		          'icon' => 'icomoon-paint-format',
		          'icon_color' => '#159db3',
		          'icon_image' => 0,
		          'title' => 'Custom Colors',
		          'text' => 'You can set custom colors for just about every aspect of the theme, giving you the ability to create truly unique websites.',
		          'more_text' => '',
		          'more_url' => '',
		        ),
		        2 => 
		        array (
		          'container_color' => false,
		          'icon' => 'icomoon-stack',
		          'icon_color' => '#159db3',
		          'icon_image' => 0,
		          'title' => 'Page Builder',
		          'text' => 'Bramble comes with a page builder that allows you to create pages exactly how you want.',
		          'more_text' => '',
		          'more_url' => '',
		        ),
		      ),
		      'fonts' => 
		      array (
		        'title_options' => 
		        array (
		          'font' => 'default',
		          'size' => 'px',
		          'size_unit' => 'px',
		          'color' => false,
		          'so_field_container_state' => 'closed',
		        ),
		        'text_options' => 
		        array (
		          'font' => 'default',
		          'size' => 'px',
		          'size_unit' => 'px',
		          'color' => false,
		          'so_field_container_state' => 'closed',
		        ),
		        'more_text_options' => 
		        array (
		          'font' => 'default',
		          'size' => 'px',
		          'size_unit' => 'px',
		          'color' => false,
		          'so_field_container_state' => 'closed',
		        ),
		        'so_field_container_state' => 'closed',
		      ),
		      'container_shape' => 'round',
		      'container_size' => '84px',
		      'container_size_unit' => 'px',
		      'icon_size' => '34px',
		      'icon_size_unit' => 'px',
		      'per_row' => 3,
		      'responsive' => true,
		      '_sow_form_id' => '5671c02d695b5',
		      'title_link' => false,
		      'icon_link' => false,
		      'new_window' => false,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Features_Widget',
		        'raw' => false,
		        'grid' => 2,
		        'cell' => 1,
		        'id' => 3,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		          'font_color' => '#191919',
		        ),
		      ),
		    ),
		    4 => 
		    array (
		      'image' => 150,
		      'image_fallback' => '',
		      'size' => 'full',
		      'title' => '',
		      'alt' => '',
		      'url' => '',
		      'bound' => true,
		      '_sow_form_id' => '5669d771d05ff',
		      'new_window' => false,
		      'full_width' => false,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Image_Widget',
		        'raw' => false,
		        'grid' => 3,
		        'cell' => 1,
		        'id' => 4,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    5 => 
		    array (
		      'features' => 
		      array (
		        0 => 
		        array (
		          'container_color' => false,
		          'icon' => 'icomoon-download',
		          'icon_color' => '#159db3',
		          'icon_image' => 0,
		          'title' => 'One-click Demo Import',
		          'text' => 'Use the one-click demo import to start with the beautiful layouts you see here in the demo.',
		          'more_text' => '',
		          'more_url' => '',
		        ),
		        1 => 
		        array (
		          'container_color' => false,
		          'icon' => 'icomoon-menu',
		          'icon_color' => '#159db3',
		          'icon_image' => 0,
		          'title' => 'One Page Navigation',
		          'text' => 'Set up your main navigation to scroll to different sections on a single page. Includes navigation highlighting as you scroll.',
		          'more_text' => '',
		          'more_url' => '',
		        ),
		        2 => 
		        array (
		          'container_color' => false,
		          'icon' => 'icomoon-envelope',
		          'icon_color' => '#159db3',
		          'icon_image' => 0,
		          'title' => 'Contact Forms',
		          'text' => 'Full compatibility with the awesome Contact Form 7 plugin is baked right in to Create.',
		          'more_text' => '',
		          'more_url' => '',
		        ),
		      ),
		      'fonts' => 
		      array (
		        'title_options' => 
		        array (
		          'font' => 'default',
		          'size' => 'px',
		          'size_unit' => 'px',
		          'color' => false,
		          'so_field_container_state' => 'closed',
		        ),
		        'text_options' => 
		        array (
		          'font' => 'default',
		          'size' => 'px',
		          'size_unit' => 'px',
		          'color' => false,
		          'so_field_container_state' => 'closed',
		        ),
		        'more_text_options' => 
		        array (
		          'font' => 'default',
		          'size' => 'px',
		          'size_unit' => 'px',
		          'color' => false,
		          'so_field_container_state' => 'closed',
		        ),
		        'so_field_container_state' => 'closed',
		      ),
		      'container_shape' => 'round',
		      'container_size' => '84px',
		      'container_size_unit' => 'px',
		      'icon_size' => '34px',
		      'icon_size_unit' => 'px',
		      'per_row' => 3,
		      'responsive' => true,
		      '_sow_form_id' => '5672ded827c8a',
		      'title_link' => false,
		      'icon_link' => false,
		      'new_window' => false,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Features_Widget',
		        'raw' => false,
		        'grid' => 4,
		        'cell' => 1,
		        'id' => 5,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		          'font_color' => '#191919',
		        ),
		      ),
		    ),
		    6 => 
		    array (
		      'title' => '',
		      'text' => '<h1 style="text-align: center;">What People Are Saying</h1>',
		      'text_selected_editor' => 'tinymce',
		      'autop' => true,
		      '_sow_form_id' => '5672f2ec1a038',
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Editor_Widget',
		        'raw' => false,
		        'grid' => 5,
		        'cell' => 1,
		        'id' => 6,
		        'style' => 
		        array (
		          'padding' => '30px',
		          'background_display' => 'tile',
		          'font_color' => '#ffffff',
		        ),
		      ),
		    ),
		    7 => 
		    array (
		      'title' => '',
		      'count' => '3',
		      'layout' => 'carousel',
		      'columns' => '1',
		      'alignment' => 'center',
		      'order' => 'rand',
		      'carousel-nav-color' => '#ff7f66',
		      'panels_info' => 
		      array (
		        'class' => 'TTrust_Testimonials',
		        'raw' => false,
		        'grid' => 5,
		        'cell' => 1,
		        'id' => 7,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		          'font_color' => '#ffffff',
		        ),
		      ),
		    ),
		    8 => 
		    array (
		      'title' => '',
		      'text' => '<h1 style="text-align: center;">Affordable Prices</h1><p style="text-align: center;">This is an example of a pricing table. It is super easy to create using the pricing table widget.</p>',
		      'autop' => true,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Editor_Widget',
		        'raw' => false,
		        'grid' => 6,
		        'cell' => 1,
		        'id' => 8,
		        'style' => 
		        array (
		          'padding' => '5%',
		          'background_display' => 'tile',
		          'font_color' => '#262626',
		        ),
		      ),
		    ),
		    9 => 
		    array (
		      'title' => '',
		      'columns' => 
		      array (
		        0 => 
		        array (
		          'title' => 'Bronze',
		          'subtitle' => '',
		          'image' => 0,
		          'price' => '$58',
		          'per' => '',
		          'button' => 'Buy Now',
		          'url' => '',
		          'features' => 
		          array (
		            0 => 
		            array (
		              'text' => '3 Users',
		              'hover' => '',
		              'icon_new' => 'fontawesome-child',
		              'icon_color' => false,
		            ),
		            1 => 
		            array (
		              'text' => '3 Mb Storage',
		              'hover' => '',
		              'icon_new' => 'fontawesome-database',
		              'icon_color' => false,
		            ),
		            2 => 
		            array (
		              'text' => 'Unlimited Options',
		              'hover' => '',
		              'icon_new' => 'fontawesome-cogs',
		              'icon_color' => false,
		            ),
		          ),
		          'featured' => false,
		        ),
		        1 => 
		        array (
		          'featured' => true,
		          'title' => 'Gold',
		          'subtitle' => '',
		          'image' => 0,
		          'price' => '$58',
		          'per' => '',
		          'button' => 'Buy Now',
		          'url' => '',
		          'features' => 
		          array (
		            0 => 
		            array (
		              'text' => '3 Mb Storage',
		              'hover' => '',
		              'icon_new' => 'fontawesome-database',
		              'icon_color' => false,
		            ),
		            1 => 
		            array (
		              'text' => '3 Users',
		              'hover' => '',
		              'icon_new' => 'fontawesome-child',
		              'icon_color' => false,
		            ),
		            2 => 
		            array (
		              'text' => 'Unlimited Options',
		              'hover' => '',
		              'icon_new' => 'fontawesome-cogs',
		              'icon_color' => false,
		            ),
		          ),
		        ),
		        2 => 
		        array (
		          'title' => 'Silver',
		          'subtitle' => '',
		          'image' => 0,
		          'price' => '$58',
		          'per' => '',
		          'button' => 'Buy Now',
		          'url' => '',
		          'features' => 
		          array (
		            0 => 
		            array (
		              'text' => 'Unlimited Options',
		              'hover' => '',
		              'icon_new' => 'fontawesome-cogs',
		              'icon_color' => false,
		            ),
		            1 => 
		            array (
		              'text' => '3 Users',
		              'hover' => '',
		              'icon_new' => 'fontawesome-child',
		              'icon_color' => false,
		            ),
		            2 => 
		            array (
		              'text' => '3 Mb Storage',
		              'hover' => '',
		              'icon_new' => 'fontawesome-database',
		              'icon_color' => false,
		            ),
		          ),
		          'featured' => false,
		        ),
		      ),
		      'theme' => 'flat',
		      'header_color' => '#515151',
		      'featured_header_color' => '#55b7c6',
		      'button_color' => '#55b7c6',
		      'featured_button_color' => '#55b7c6',
		      '_sow_form_id' => '568c3746716b8',
		      'button_new_window' => false,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_PriceTable_Widget',
		        'raw' => false,
		        'grid' => 6,
		        'cell' => 1,
		        'id' => 9,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		  ),
		  'grids' => 
		  array (
		    0 => 
		    array (
		      'cells' => 1,
		      'style' => 
		      array (
		        'row_stretch' => 'full',
		        'background' => '#f2f2f2',
		        'equal_column_height' => 'no',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		        'canvas_animation_effect' => 'none',
		      ),
		    ),
		    1 => 
		    array (
		      'cells' => 2,
		      'style' => 
		      array (
		        'row_stretch' => 'full',
		        'background' => '#212b35',
		        'equal_column_height' => 'yes',
		        'padding_top' => '10%',
		        'padding_bottom' => '10%',
		        'background_image_position' => 'center center',
		        'background_image_style' => 'cover',
		        'canvas_animation_effect' => 'none',
		      ),
		    ),
		    2 => 
		    array (
		      'cells' => 3,
		      'style' => 
		      array (
		        'row_stretch' => 'full',
		        'background' => '#f6f6f6',
		        'equal_column_height' => 'no',
		        'padding_top' => '5%',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		        'canvas_animation_effect' => 'none',
		      ),
		    ),
		    3 => 
		    array (
		      'cells' => 3,
		      'style' => 
		      array (
		        'row_stretch' => 'full',
		        'background' => '#f6f6f6',
		        'equal_column_height' => 'no',
		        'padding_top' => '0px',
		        'padding_bottom' => '0px',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		        'canvas_animation_effect' => 'none',
		      ),
		    ),
		    4 => 
		    array (
		      'cells' => 3,
		      'style' => 
		      array (
		        'row_stretch' => 'full',
		        'background' => '#f6f6f6',
		        'equal_column_height' => 'no',
		        'padding_bottom' => '10%',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		        'canvas_animation_effect' => 'none',
		      ),
		    ),
		    5 => 
		    array (
		      'cells' => 3,
		      'style' => 
		      array (
		        'row_stretch' => 'full',
		        'background' => '#212b36',
		        'equal_column_height' => 'no',
		        'padding_top' => '10%',
		        'padding_bottom' => '10%',
		        'background_image' => 551,
		        'background_image_position' => 'center bottom',
		        'background_image_style' => 'parallax',
		        'canvas_animation_effect' => 'none',
		      ),
		    ),
		    6 => 
		    array (
		      'cells' => 3,
		      'style' => 
		      array (
		        'row_stretch' => 'full',
		        'background' => '#f9f9f9',
		        'equal_column_height' => 'no',
		        'padding_top' => '5%',
		        'padding_bottom' => '10%',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		        'canvas_animation_effect' => 'none',
		      ),
		    ),
		  ),
		  'grid_cells' => 
		  array (
		    0 => 
		    array (
		      'grid' => 0,
		      'weight' => 1,
		    ),
		    1 => 
		    array (
		      'grid' => 1,
		      'weight' => 0.5,
		    ),
		    2 => 
		    array (
		      'grid' => 1,
		      'weight' => 0.5,
		    ),
		    3 => 
		    array (
		      'grid' => 2,
		      'weight' => 0.047632153778947,
		    ),
		    4 => 
		    array (
		      'grid' => 2,
		      'weight' => 0.90664045434687,
		    ),
		    5 => 
		    array (
		      'grid' => 2,
		      'weight' => 0.045727391874185,
		    ),
		    6 => 
		    array (
		      'grid' => 3,
		      'weight' => 0.15670245867732,
		    ),
		    7 => 
		    array (
		      'grid' => 3,
		      'weight' => 0.68195471141567,
		    ),
		    8 => 
		    array (
		      'grid' => 3,
		      'weight' => 0.16134282990701,
		    ),
		    9 => 
		    array (
		      'grid' => 4,
		      'weight' => 0.047632153778947,
		    ),
		    10 => 
		    array (
		      'grid' => 4,
		      'weight' => 0.90664045434687,
		    ),
		    11 => 
		    array (
		      'grid' => 4,
		      'weight' => 0.045727391874185,
		    ),
		    12 => 
		    array (
		      'grid' => 5,
		      'weight' => 0.15670245867732,
		    ),
		    13 => 
		    array (
		      'grid' => 5,
		      'weight' => 0.68195471141567,
		    ),
		    14 => 
		    array (
		      'grid' => 5,
		      'weight' => 0.16134282990701,
		    ),
		    15 => 
		    array (
		      'grid' => 6,
		      'weight' => 0.07034632034632,
		    ),
		    16 => 
		    array (
		      'grid' => 6,
		      'weight' => 0.86011904761905,
		    ),
		    17 => 
		    array (
		      'grid' => 6,
		      'weight' => 0.069534632034632,
		    ),
		  ),
	);
	
	$layouts['home-blocks'] = array(
		'name' => __('Home: Blocks', 'bramble'),
		'description' => __('Layout for demo Home: Blocks', 'bramble'),
		'widgets' => 
		  array (
		    0 => 
		    array (
		      'title' => '',
		      'text' => '[rev_slider alias="valley"]',
		      'filter' => false,
		      'panels_info' => 
		      array (
		        'class' => 'WP_Widget_Text',
		        'raw' => false,
		        'grid' => 0,
		        'cell' => 0,
		        'id' => 0,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    1 => 
		    array (
		      'min_height' => '160',
		      'panels_info' => 
		      array (
		        'class' => 'TTrust_Spacer',
		        'raw' => false,
		        'grid' => 1,
		        'cell' => 0,
		        'id' => 1,
		        'style' => 
		        array (
		          'background_image_attachment' => 240,
		          'background_display' => 'cover',
		        ),
		      ),
		    ),
		    2 => 
		    array (
		      'title' => '',
		      'text' => '<h2 style="text-align: center;">The benefits of working with us.</h2><p style="text-align: center;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc accumsan velit ut ex dapibus, vitae dignissim lorem eleifend. Cras leo ipsum, porttitor at iaculis venenatis, hendrerit sed sapien.</p><p style="text-align: center;"><a class="button" style="background-color: #909b96;" href="http://demos.themetrust.com/bramble/features/">Learn More</a></p>',
		      'autop' => true,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Editor_Widget',
		        'raw' => false,
		        'grid' => 1,
		        'cell' => 1,
		        'id' => 2,
		        'style' => 
		        array (
		          'class' => 'v-center',
		          'padding' => '12%',
		          'background' => '#262626',
		          'background_display' => 'tile',
		          'font_color' => '#ffffff',
		        ),
		      ),
		    ),
		    3 => 
		    array (
		      'title' => '',
		      'text' => '<h2 style="text-align: center;">Providing the tools that you need.</h2>
		<p style="text-align: center;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc accumsan velit ut ex dapibus, vitae dignissim lorem eleifend. Cras leo ipsum, porttitor at iaculis venenatis, hendrerit sed sapien.</p>
		<p style="text-align: center;"><a class="button" style="background-color: #da993c;">Learn More</a></p>',
		      'autop' => true,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Editor_Widget',
		        'raw' => false,
		        'grid' => 2,
		        'cell' => 0,
		        'id' => 3,
		        'style' => 
		        array (
		          'class' => 'v-center',
		          'padding' => '12%',
		          'background_display' => 'tile',
		          'font_color' => '#1c1c1c',
		        ),
		      ),
		    ),
		    4 => 
		    array (
		      'min_height' => '160',
		      'panels_info' => 
		      array (
		        'class' => 'TTrust_Spacer',
		        'raw' => false,
		        'grid' => 2,
		        'cell' => 1,
		        'id' => 4,
		        'style' => 
		        array (
		          'background_image_attachment' => 245,
		          'background_display' => 'cover',
		        ),
		      ),
		    ),
		    5 => 
		    array (
		      'min_height' => '160',
		      'panels_info' => 
		      array (
		        'class' => 'TTrust_Spacer',
		        'raw' => false,
		        'grid' => 3,
		        'cell' => 0,
		        'id' => 5,
		        'style' => 
		        array (
		          'background_image_attachment' => 207,
		          'background_display' => 'cover',
		        ),
		      ),
		    ),
		    6 => 
		    array (
		      'title' => '',
		      'text' => '<h2 style="text-align: center;">Unparalleled customer service.</h2>
		<p style="text-align: center;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc accumsan velit ut ex dapibus, vitae dignissim lorem eleifend. Cras leo ipsum, porttitor at iaculis venenatis, hendrerit sed sapien.</p>
		<p style="text-align: center;"><a class="button" style="background-color: #8a8352;">Learn More</a></p>',
		      'autop' => true,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Editor_Widget',
		        'raw' => false,
		        'grid' => 3,
		        'cell' => 1,
		        'id' => 6,
		        'style' => 
		        array (
		          'class' => 'v-center',
		          'padding' => '12%',
		          'background' => '#232323',
		          'background_display' => 'tile',
		          'font_color' => '#ffffff',
		        ),
		      ),
		    ),
		    7 => 
		    array (
		      'title' => '',
		      'text' => '<h2 style="text-align: center;">What People are Saying</h2>',
		      'autop' => true,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Editor_Widget',
		        'raw' => false,
		        'grid' => 4,
		        'cell' => 1,
		        'id' => 7,
		        'style' => 
		        array (
		          'padding' => '5%',
		          'background_display' => 'tile',
		          'font_color' => '#2d2d2d',
		        ),
		      ),
		    ),
		    8 => 
		    array (
		      'title' => '',
		      'count' => '3',
		      'layout' => 'grid',
		      'columns' => '3',
		      'alignment' => 'center',
		      'order' => 'rand',
		      'carousel-nav-color' => '',
		      'panels_info' => 
		      array (
		        'class' => 'TTrust_Testimonials',
		        'raw' => false,
		        'grid' => 4,
		        'cell' => 1,
		        'id' => 8,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		  ),
		  'grids' => 
		  array (
		    0 => 
		    array (
		      'cells' => 1,
		      'style' => 
		      array (
		        'row_stretch' => 'full',
		        'equal_column_height' => 'no',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		        'canvas_animation_effect' => 'none',
		      ),
		    ),
		    1 => 
		    array (
		      'cells' => 2,
		      'style' => 
		      array (
		        'bottom_margin' => '0px',
		        'gutter' => '0px',
		        'row_stretch' => 'full-stretched',
		        'equal_column_height' => 'yes',
		        'padding_top' => '0px',
		        'padding_bottom' => '0px',
		        'padding_left' => '0px',
		        'padding_right' => '0px',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		        'canvas_animation_effect' => 'none',
		      ),
		    ),
		    2 => 
		    array (
		      'cells' => 2,
		      'style' => 
		      array (
		        'bottom_margin' => '0px',
		        'gutter' => '0px',
		        'row_stretch' => 'full-stretched',
		        'equal_column_height' => 'yes',
		        'padding_top' => '0px',
		        'padding_bottom' => '0px',
		        'padding_left' => '0px',
		        'padding_right' => '0px',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		        'canvas_animation_effect' => 'none',
		      ),
		    ),
		    3 => 
		    array (
		      'cells' => 2,
		      'style' => 
		      array (
		        'bottom_margin' => '0px',
		        'gutter' => '0px',
		        'row_stretch' => 'full-stretched',
		        'equal_column_height' => 'yes',
		        'padding_top' => '0px',
		        'padding_bottom' => '0px',
		        'padding_left' => '0px',
		        'padding_right' => '0px',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		        'canvas_animation_effect' => 'none',
		      ),
		    ),
		    4 => 
		    array (
		      'cells' => 3,
		      'style' => 
		      array (
		        'row_stretch' => 'full',
		        'background' => '#f7f7f7',
		        'equal_column_height' => 'no',
		        'padding_top' => '50px',
		        'padding_bottom' => '50px',
		        'background_image' => false,
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		        'canvas_animation_effect' => 'none',
		      ),
		    ),
		  ),
		  'grid_cells' => 
		  array (
		    0 => 
		    array (
		      'grid' => 0,
		      'weight' => 1,
		    ),
		    1 => 
		    array (
		      'grid' => 1,
		      'weight' => 0.5,
		    ),
		    2 => 
		    array (
		      'grid' => 1,
		      'weight' => 0.5,
		    ),
		    3 => 
		    array (
		      'grid' => 2,
		      'weight' => 0.5,
		    ),
		    4 => 
		    array (
		      'grid' => 2,
		      'weight' => 0.5,
		    ),
		    5 => 
		    array (
		      'grid' => 3,
		      'weight' => 0.5,
		    ),
		    6 => 
		    array (
		      'grid' => 3,
		      'weight' => 0.5,
		    ),
		    7 => 
		    array (
		      'grid' => 4,
		      'weight' => 0.10014306151645,
		    ),
		    8 => 
		    array (
		      'grid' => 4,
		      'weight' => 0.7997138769671,
		    ),
		    9 => 
		    array (
		      'grid' => 4,
		      'weight' => 0.10014306151645,
		    ),
		  ),
	);
	
	$layouts['home-freelancer'] = array(
		'name' => __('Home: Freelancer', 'bramble'),
		'description' => __('Layout for demo Home: Freelancer', 'bramble'),
		'widgets' => 
		  array (
		    0 => 
		    array (
		      'title' => '',
		      'text' => '<h1><span style="font-size: 66px;">Hi. <br /></span><span style="font-size: 66px;">I\'m Sarah.</span></h1><p style="text-align: left;"><span style="font-size: 18px;">I\'m a freelance web designer. Scroll down and take a look at my work. If you like what you see, don\'t hesitate to get in touch</span></p>',
		      'autop' => true,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Editor_Widget',
		        'raw' => false,
		        'grid' => 0,
		        'cell' => 1,
		        'id' => 0,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		          'font_color' => '#ffffff',
		        ),
		      ),
		    ),
		    1 => 
		    array (
		      'text' => 'CONTACT ME',
		      'url' => 'http://demos.themetrust.com/bramble/contact-us/',
		      'button_icon' => 
		      array (
		        'icon_selected' => '',
		        'icon_color' => false,
		        'icon' => 0,
		        'so_field_container_state' => 'open',
		      ),
		      'design' => 
		      array (
		        'align' => 'left',
		        'theme' => 'flat',
		        'button_color' => '#ffffff',
		        'text_color' => '#2d0000',
		        'hover' => true,
		        'font_size' => '1',
		        'rounding' => '1.5',
		        'padding' => '1',
		        'so_field_container_state' => 'closed',
		      ),
		      'attributes' => 
		      array (
		        'id' => '',
		        'title' => '',
		        'onclick' => '',
		        'so_field_container_state' => 'closed',
		      ),
		      '_sow_form_id' => '56ba07547de57',
		      'new_window' => false,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Button_Widget',
		        'raw' => false,
		        'grid' => 0,
		        'cell' => 1,
		        'id' => 1,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    2 => 
		    array (
		      'title' => '',
		      'text' => '<h3 style="text-align: left;">A little bit about me.</h3>',
		      'autop' => true,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Editor_Widget',
		        'grid' => 1,
		        'cell' => 1,
		        'id' => 2,
		        'style' => 
		        array (
		          'background_image_attachment' => false,
		          'background_display' => 'tile',
		          'font_color' => '#1e1e1e',
		        ),
		      ),
		    ),
		    3 => 
		    array (
		      'title' => '',
		      'text' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In facilisis id magna vel cursus. Cras ipsum neque, varius vitae arcu non, ullamcorper cursus est. Donec finibus risus felis, eget facilisis urna ultrices et. Aenean velit mauris, pulvinar vel purus at, dapibus bibendum purus. Etiam finibus diam quis suscipit pellentesque.</p>',
		      'text_selected_editor' => 'tinymce',
		      'autop' => true,
		      '_sow_form_id' => '56a00af57a00b',
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Editor_Widget',
		        'raw' => false,
		        'grid' => 2,
		        'cell' => 1,
		        'id' => 3,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		          'font_color' => '#8c8c8c',
		        ),
		      ),
		    ),
		    4 => 
		    array (
		      'title' => '',
		      'text' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In facilisis id magna vel cursus. Cras ipsum neque, varius vitae arcu non, ullamcorper cursus est. Donec finibus risus felis, eget facilisis urna ultrices et. Aenean velit mauris, pulvinar vel purus at, dapibus bibendum purus. Etiam finibus diam quis suscipit pellentesque.</p>',
		      'autop' => true,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Editor_Widget',
		        'raw' => false,
		        'grid' => 2,
		        'cell' => 2,
		        'id' => 4,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		          'font_color' => '#8c8c8c',
		        ),
		      ),
		    ),
		    5 => 
		    array (
		      'networks' => 
		      array (
		        0 => 
		        array (
		          'name' => 'linkedin',
		          'url' => 'https://www.linkedin.com/',
		          'icon_color' => '#ffffff',
		          'button_color' => false,
		        ),
		        1 => 
		        array (
		          'name' => 'twitter',
		          'url' => 'https://twitter.com/',
		          'icon_color' => '#ffffff',
		          'button_color' => false,
		        ),
		        2 => 
		        array (
		          'name' => 'google-plus',
		          'url' => 'https://plus.google.com/',
		          'icon_color' => '#ffffff',
		          'button_color' => false,
		        ),
		        3 => 
		        array (
		          'name' => 'envelope',
		          'url' => 'mailto:',
		          'icon_color' => '#ffffff',
		          'button_color' => false,
		        ),
		      ),
		      'design' => 
		      array (
		        'new_window' => true,
		        'theme' => 'flat',
		        'hover' => true,
		        'icon_size' => '2',
		        'rounding' => '0.25',
		        'padding' => '1',
		        'align' => 'center',
		        'margin' => '0.1',
		        'so_field_container_state' => 'open',
		      ),
		      '_sow_form_id' => '566736fdba902',
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_SocialMediaButtons_Widget',
		        'raw' => false,
		        'grid' => 3,
		        'cell' => 1,
		        'id' => 5,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		          'font_color' => '#595959',
		        ),
		      ),
		    ),
		    6 => 
		    array (
		      'title' => '',
		      'text' => '<h3 style="text-align: center;"><span style="color: #333333;">My Work</span></h3>',
		      'autop' => true,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Editor_Widget',
		        'raw' => false,
		        'grid' => 4,
		        'cell' => 1,
		        'id' => 6,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    7 => 
		    array (
		      'title' => '',
		      'show_filter' => 'no',
		      'filter_selected_color' => '#874962',
		      'filter_alignment' => 'center',
		      'count' => '8',
		      'thumb_proportions' => 'square',
		      'layout' => 'rows without gutter',
		      'columns' => '4',
		      'orderby' => 'menu_order',
		      'order' => 'DESC',
		      'hover_effect' => 'effect-1',
		      'hover_color' => '#874962',
		      'hover_text_color' => '',
		      'show_skills' => 'no',
		      'show_load_more' => 'no',
		      'load_more_color' => '#874962',
		      'load_more_text_color' => '#ffffff',
		      'enable_lightbox' => 'no',
		      'skills' => '',
		      'panels_info' => 
		      array (
		        'class' => 'TTrust_Portfolio',
		        'raw' => false,
		        'grid' => 5,
		        'cell' => 0,
		        'id' => 7,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    8 => 
		    array (
		      'title' => '',
		      'text' => '<h3 style="text-align: center;"><span style="color: #333333;">My Clients</span></h3>',
		      'autop' => true,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Editor_Widget',
		        'raw' => false,
		        'grid' => 6,
		        'cell' => 1,
		        'id' => 8,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    9 => 
		    array (
		      'title' => '',
		      'count' => '3',
		      'layout' => 'grid',
		      'columns' => '3',
		      'alignment' => 'center',
		      'order' => 'rand',
		      'carousel-nav-color' => '',
		      'panels_info' => 
		      array (
		        'class' => 'TTrust_Testimonials',
		        'raw' => false,
		        'grid' => 7,
		        'cell' => 1,
		        'id' => 9,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    10 => 
		    array (
		      'title' => '',
		      'text' => '<p><img class="aligncenter size-full wp-image-693" src="http://demos.themetrust.com/bramble/wp-content/uploads/sites/2/2015/12/client_logos_dark.png" alt="client_logos_dark" width="1823" height="238" /></p>',
		      'autop' => true,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Editor_Widget',
		        'raw' => false,
		        'grid' => 7,
		        'cell' => 1,
		        'id' => 10,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		  ),
		  'grids' => 
		  array (
		    0 => 
		    array (
		      'cells' => 3,
		      'style' => 
		      array (
		        'bottom_margin' => '0px',
		        'row_stretch' => 'full',
		        'equal_column_height' => 'no',
		        'padding_top' => '250px',
		        'padding_bottom' => '250px',
		        'background_image' => 121,
		        'background_image_position' => 'center top',
		        'background_image_style' => 'cover',
		        'canvas_animation_effect' => 'none',
		      ),
		    ),
		    1 => 
		    array (
		      'cells' => 4,
		      'style' => 
		      array (
		        'bottom_margin' => '0px',
		        'gutter' => '30px',
		        'row_stretch' => 'full',
		        'background' => '#f7f7f7',
		        'equal_column_height' => 'no',
		        'padding_top' => '100px',
		        'padding_bottom' => '30px',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'parallax',
		        'canvas_animation_effect' => 'none',
		      ),
		    ),
		    2 => 
		    array (
		      'cells' => 4,
		      'style' => 
		      array (
		        'bottom_margin' => '0px',
		        'gutter' => '30px',
		        'row_stretch' => 'full',
		        'background' => '#f7f7f7',
		        'equal_column_height' => 'no',
		        'padding_top' => '0px',
		        'padding_bottom' => '100px',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'parallax',
		        'canvas_animation_effect' => 'none',
		      ),
		    ),
		    3 => 
		    array (
		      'cells' => 3,
		      'style' => 
		      array (
		        'bottom_margin' => '0px',
		        'gutter' => '0px',
		        'row_stretch' => 'full',
		        'background' => '#efefef',
		        'equal_column_height' => 'yes',
		        'padding_top' => '200px',
		        'padding_bottom' => '200px',
		        'background_image' => 130,
		        'background_image_position' => 'left top',
		        'background_image_style' => 'parallax',
		        'canvas_animation_effect' => 'none',
		      ),
		    ),
		    4 => 
		    array (
		      'cells' => 3,
		      'style' => 
		      array (
		        'bottom_margin' => '0px',
		        'gutter' => '0px',
		        'row_stretch' => 'full',
		        'background' => '#efefef',
		        'equal_column_height' => 'no',
		        'padding_top' => '70px',
		        'padding_bottom' => '50px',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		        'canvas_animation_effect' => 'none',
		      ),
		    ),
		    5 => 
		    array (
		      'cells' => 1,
		      'style' => 
		      array (
		        'bottom_margin' => '0px',
		        'row_stretch' => 'full-stretched',
		        'equal_column_height' => 'no',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		        'canvas_animation_effect' => 'none',
		      ),
		    ),
		    6 => 
		    array (
		      'cells' => 3,
		      'style' => 
		      array (
		        'bottom_margin' => '0px',
		        'gutter' => '0px',
		        'row_stretch' => 'full',
		        'background' => '#efefef',
		        'equal_column_height' => 'no',
		        'padding_top' => '70px',
		        'padding_bottom' => '0px',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		        'canvas_animation_effect' => 'none',
		      ),
		    ),
		    7 => 
		    array (
		      'cells' => 3,
		      'style' => 
		      array (
		        'bottom_margin' => '0px',
		        'gutter' => '0px',
		        'row_stretch' => 'full',
		        'background' => '#efefef',
		        'equal_column_height' => 'no',
		        'padding_top' => '70px',
		        'padding_bottom' => '70px',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		        'canvas_animation_effect' => 'none',
		      ),
		    ),
		  ),
		  'grid_cells' => 
		  array (
		    0 => 
		    array (
		      'grid' => 0,
		      'weight' => 0.094885880604718,
		    ),
		    1 => 
		    array (
		      'grid' => 0,
		      'weight' => 0.43496830743021,
		    ),
		    2 => 
		    array (
		      'grid' => 0,
		      'weight' => 0.47014581196507,
		    ),
		    3 => 
		    array (
		      'grid' => 1,
		      'weight' => 0.14983585569024,
		    ),
		    4 => 
		    array (
		      'grid' => 1,
		      'weight' => 0.50925505340067,
		    ),
		    5 => 
		    array (
		      'grid' => 1,
		      'weight' => 0.19730764918394,
		    ),
		    6 => 
		    array (
		      'grid' => 1,
		      'weight' => 0.14360144172515,
		    ),
		    7 => 
		    array (
		      'grid' => 2,
		      'weight' => 0.14983585569024,
		    ),
		    8 => 
		    array (
		      'grid' => 2,
		      'weight' => 0.35016414430976,
		    ),
		    9 => 
		    array (
		      'grid' => 2,
		      'weight' => 0.35639855827485,
		    ),
		    10 => 
		    array (
		      'grid' => 2,
		      'weight' => 0.14360144172515,
		    ),
		    11 => 
		    array (
		      'grid' => 3,
		      'weight' => 0.20030581039755,
		    ),
		    12 => 
		    array (
		      'grid' => 3,
		      'weight' => 0.5993883792049,
		    ),
		    13 => 
		    array (
		      'grid' => 3,
		      'weight' => 0.20030581039755,
		    ),
		    14 => 
		    array (
		      'grid' => 4,
		      'weight' => 0.19025401762571,
		    ),
		    15 => 
		    array (
		      'grid' => 4,
		      'weight' => 0.61949196474858,
		    ),
		    16 => 
		    array (
		      'grid' => 4,
		      'weight' => 0.19025401762571,
		    ),
		    17 => 
		    array (
		      'grid' => 5,
		      'weight' => 1,
		    ),
		    18 => 
		    array (
		      'grid' => 6,
		      'weight' => 0.19025401762571,
		    ),
		    19 => 
		    array (
		      'grid' => 6,
		      'weight' => 0.61949196474858,
		    ),
		    20 => 
		    array (
		      'grid' => 6,
		      'weight' => 0.19025401762571,
		    ),
		    21 => 
		    array (
		      'grid' => 7,
		      'weight' => 0.081163108534801,
		    ),
		    22 => 
		    array (
		      'grid' => 7,
		      'weight' => 0.82988157513819,
		    ),
		    23 => 
		    array (
		      'grid' => 7,
		      'weight' => 0.088955316327009,
		    ),
		  ),
	);
	
	$layouts['home-one-page'] = array(
		'name' => __('Home: One Page', 'bramble'),
		'description' => __('Layout for demo Home: One Page', 'bramble'),
		'widgets' => 
		  array (
		    0 => 
		    array (
		      'title' => '',
		      'text' => '[rev_slider alias="wave"]',
		      'filter' => false,
		      'panels_info' => 
		      array (
		        'class' => 'WP_Widget_Text',
		        'raw' => false,
		        'grid' => 0,
		        'cell' => 0,
		        'id' => 0,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    1 => 
		    array (
		      'title' => '',
		      'text' => '<h3 style="text-align: center;"><span style="color: #242424;">Limited only by your imagination.</span></h3><p style="text-align: center;">Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip.</p>',
		      'autop' => true,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Editor_Widget',
		        'grid' => 1,
		        'cell' => 1,
		        'id' => 1,
		        'style' => 
		        array (
		          'class' => 'v-center',
		          'padding' => '5%',
		          'background_image_attachment' => false,
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    2 => 
		    array (
		      'title' => '',
		      'text' => '<p><img class="size-full wp-image-569 alignleft" src="http://demos.themetrust.com/bramble/wp-content/uploads/sites/2/2016/02/led_cinema_display-copy.jpg" alt="led_cinema_display copy" width="980" height="734" /></p>',
		      'autop' => true,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Editor_Widget',
		        'raw' => false,
		        'grid' => 2,
		        'cell' => 1,
		        'id' => 2,
		        'style' => 
		        array (
		          'padding' => '0px',
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    3 => 
		    array (
		      'title' => '',
		      'text' => '<h3 style="text-align: center;">Our Services</h3><p style="text-align: center;"><span style="color: #e0e0e0;">Nam liber tempor cum soluta nobis eleifend optio.</span></p>',
		      'autop' => true,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Editor_Widget',
		        'raw' => false,
		        'grid' => 3,
		        'cell' => 0,
		        'id' => 3,
		        'style' => 
		        array (
		          'class' => 'v-center',
		          'padding' => '3%',
		          'background_display' => 'tile',
		          'font_color' => '#ffffff',
		        ),
		      ),
		    ),
		    4 => 
		    array (
		      'features' => 
		      array (
		        0 => 
		        array (
		          'container_color' => false,
		          'icon' => 'fontawesome-codepen',
		          'icon_color' => '#21d1d1',
		          'icon_image' => 0,
		          'title' => 'Page Builder',
		          'text' => 'Bramble comes with a page builder that allows you to bramble pages exactly how you want. ',
		          'more_text' => '',
		          'more_url' => '',
		        ),
		        1 => 
		        array (
		          'container_color' => false,
		          'icon' => 'fontawesome-mobile',
		          'icon_color' => '#21d1d1',
		          'icon_image' => 0,
		          'title' => 'Responsive Layout',
		          'text' => 'Bramble is a responsive theme. Its layout adjusts to look great on any screen size or device.',
		          'more_text' => '',
		          'more_url' => '',
		        ),
		        2 => 
		        array (
		          'container_color' => false,
		          'icon' => 'fontawesome-eye',
		          'icon_color' => '#21d1d1',
		          'icon_image' => 0,
		          'title' => 'Retina Ready',
		          'text' => 'Built with the latest technology in mind, rest assured that your site will look crisp on retina displays.',
		          'more_text' => '',
		          'more_url' => '',
		        ),
		        3 => 
		        array (
		          'container_color' => false,
		          'icon' => 'fontawesome-google',
		          'icon_color' => '#21d1d1',
		          'icon_image' => 0,
		          'title' => 'Google Fonts',
		          'text' => 'Take control of the typography by selecting your favorite Google font from the built-in typography customizer.',
		          'more_text' => '',
		          'more_url' => '',
		        ),
		        4 => 
		        array (
		          'container_color' => false,
		          'icon' => 'fontawesome-image',
		          'icon_color' => '#21d1d1',
		          'icon_image' => 0,
		          'title' => 'Parallax Backgrounds',
		          'text' => 'Easily create sections that have a parallax background using the Page Builder. Upload your image and select "Parallax" from the drop down. It\'s that easy!',
		          'more_text' => '',
		          'more_url' => '',
		        ),
		        5 => 
		        array (
		          'container_color' => false,
		          'icon' => 'fontawesome-th-large',
		          'icon_color' => '#21d1d1',
		          'icon_image' => 0,
		          'title' => 'Portfolios',
		          'text' => 'Multiple layout options, hover effects, filtering animations, lightbox, and ajax loading will make your projects look amazing.',
		          'more_text' => '',
		          'more_url' => '',
		        ),
		      ),
		      'fonts' => 
		      array (
		        'title_options' => 
		        array (
		          'font' => 'default',
		          'size' => 'px',
		          'size_unit' => 'px',
		          'color' => false,
		          'so_field_container_state' => 'closed',
		        ),
		        'text_options' => 
		        array (
		          'font' => 'default',
		          'size' => 'px',
		          'size_unit' => 'px',
		          'color' => false,
		          'so_field_container_state' => 'closed',
		        ),
		        'more_text_options' => 
		        array (
		          'font' => 'default',
		          'size' => 'px',
		          'size_unit' => 'px',
		          'color' => false,
		          'so_field_container_state' => 'closed',
		        ),
		        'so_field_container_state' => 'closed',
		      ),
		      'container_shape' => 'round',
		      'container_size' => '50px',
		      'container_size_unit' => 'px',
		      'icon_size' => '25px',
		      'icon_size_unit' => 'px',
		      'per_row' => 3,
		      'responsive' => true,
		      '_sow_form_id' => '56985f55334b7',
		      'title_link' => false,
		      'icon_link' => false,
		      'new_window' => false,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Features_Widget',
		        'raw' => false,
		        'grid' => 3,
		        'cell' => 0,
		        'id' => 4,
		        'style' => 
		        array (
		          'widget_css' => 'p{opacity: .1 !important;}',
		          'padding' => '0px',
		          'background_display' => 'tile',
		          'font_color' => '#ffffff',
		        ),
		      ),
		    ),
		    5 => 
		    array (
		      'title' => '',
		      'text' => '<h3 style="text-align: center;"><span style="color: #242424;">Our Work</span></h3>',
		      'autop' => true,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Editor_Widget',
		        'raw' => false,
		        'grid' => 4,
		        'cell' => 0,
		        'id' => 5,
		        'style' => 
		        array (
		          'class' => 'v-center',
		          'padding' => '3%',
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    6 => 
		    array (
		      'title' => '',
		      'show_filter' => 'yes',
		      'filter_selected_color' => '#2bbfbf',
		      'filter_alignment' => 'center',
		      'count' => '6',
		      'thumb_proportions' => 'landscape',
		      'layout' => 'rows with gutter',
		      'columns' => '3',
		      'orderby' => 'date',
		      'order' => 'DESC',
		      'hover_effect' => 'effect-1',
		      'hover_color' => '',
		      'hover_text_color' => '',
		      'show_skills' => 'yes',
		      'show_load_more' => 'no',
		      'load_more_color' => '#33b3b7',
		      'load_more_text_color' => '#ffffff',
		      'enable_lightbox' => 'no',
		      'skills' => '',
		      'panels_info' => 
		      array (
		        'class' => 'TTrust_Portfolio',
		        'raw' => false,
		        'grid' => 4,
		        'cell' => 0,
		        'id' => 6,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    7 => 
		    array (
		      'title' => '',
		      'text' => '<h3 style="text-align: center;"><span style="color: #242424;">Recent News</span></h3><p style="text-align: center;">Nam liber tempor cum soluta nobis eleifend optio.</p>',
		      'autop' => true,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Editor_Widget',
		        'raw' => false,
		        'grid' => 5,
		        'cell' => 0,
		        'id' => 7,
		        'style' => 
		        array (
		          'padding' => '3%',
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    8 => 
		    array (
		      'title' => '',
		      'count' => '6',
		      'category' => '',
		      'layout' => 'grid',
		      'columns' => '3',
		      'alignment' => 'left',
		      'orderby' => 'date',
		      'order' => 'DESC',
		      'boxed' => 'yes',
		      'show_excerpt' => 'no',
		      'carousel-nav-color' => '',
		      'panels_info' => 
		      array (
		        'class' => 'TTrust_Blog',
		        'raw' => false,
		        'grid' => 5,
		        'cell' => 0,
		        'id' => 8,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    9 => 
		    array (
		      'title' => '',
		      'text' => '<h2>Get In Touch</h2><p><span style="color: #b8b8b8;">Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpa</span></p>',
		      'autop' => true,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Editor_Widget',
		        'raw' => false,
		        'grid' => 6,
		        'cell' => 0,
		        'id' => 9,
		        'style' => 
		        array (
		          'class' => 'v-center',
		          'padding' => '15%',
		          'background_image_attachment' => 327,
		          'background_display' => 'cover',
		          'font_color' => '#ffffff',
		        ),
		      ),
		    ),
		    10 => 
		    array (
		      'title' => '',
		      'text' => '[contact-form-7 id="732" title="Contact form 1"]',
		      'filter' => false,
		      'panels_info' => 
		      array (
		        'class' => 'WP_Widget_Text',
		        'raw' => false,
		        'grid' => 6,
		        'cell' => 1,
		        'id' => 10,
		        'style' => 
		        array (
		          'padding' => '8%',
		          'background' => '#3f3f3f',
		          'background_display' => 'tile',
		          'font_color' => '#ffffff',
		        ),
		      ),
		    ),
		    11 => 
		    array (
		      'map_center' => '350 5th Ave, New York, NY 10118',
		      'settings' => 
		      array (
		        'map_type' => 'interactive',
		        'width' => '640',
		        'height' => '480',
		        'zoom' => 12,
		        'scroll_zoom' => true,
		        'draggable' => true,
		        'so_field_container_state' => 'open',
		        'disable_default_ui' => false,
		        'keep_centered' => false,
		      ),
		      'markers' => 
		      array (
		        'marker_at_center' => true,
		        'marker_icon' => 0,
		        'info_display' => 'click',
		        'so_field_container_state' => 'closed',
		        'markers_draggable' => false,
		        'marker_positions' => 
		        array (
		        ),
		      ),
		      'styles' => 
		      array (
		        'style_method' => 'raw_json',
		        'styled_map_name' => '',
		        'raw_json_map_styles' => '[{"featureType":"all","elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#000000"},{"lightness":40}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#000000"},{"lightness":16}]},{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":17},{"weight":1.2}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":21}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":16}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":19}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":17}]}]',
		        'so_field_container_state' => 'open',
		        'custom_map_styles' => 
		        array (
		        ),
		      ),
		      'directions' => 
		      array (
		        'origin' => '',
		        'destination' => '',
		        'travel_mode' => 'driving',
		        'so_field_container_state' => 'closed',
		        'avoid_highways' => false,
		        'avoid_tolls' => false,
		        'waypoints' => 
		        array (
		        ),
		        'optimize_waypoints' => false,
		      ),
		      'api_key_section' => 
		      array (
		        'api_key' => '',
		        'so_field_container_state' => 'closed',
		      ),
		      '_sow_form_id' => '569502e42094a',
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_GoogleMap_Widget',
		        'raw' => false,
		        'grid' => 7,
		        'cell' => 0,
		        'id' => 11,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		  ),
		  'grids' => 
		  array (
		    0 => 
		    array (
		      'cells' => 1,
		      'style' => 
		      array (
		        'id' => 'intro',
		        'row_stretch' => 'full-stretched',
		        'custom_row_id' => 'intro',
		        'equal_column_height' => 'no',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		        'canvas_animation_effect' => 'none',
		      ),
		    ),
		    1 => 
		    array (
		      'cells' => 3,
		      'style' => 
		      array (
		        'gutter' => '0px',
		        'row_stretch' => 'full',
		        'equal_column_height' => 'yes',
		        'padding_top' => '5%',
		        'padding_bottom' => '0px',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		        'canvas_animation_effect' => 'none',
		      ),
		    ),
		    2 => 
		    array (
		      'cells' => 3,
		      'style' => 
		      array (
		        'gutter' => '0px',
		        'row_stretch' => 'full-stretched',
		        'equal_column_height' => 'yes',
		        'padding_top' => '0px',
		        'padding_bottom' => '0px',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		        'canvas_animation_effect' => 'none',
		      ),
		    ),
		    3 => 
		    array (
		      'cells' => 1,
		      'style' => 
		      array (
		        'id' => 'our-services',
		        'gutter' => '0px',
		        'row_stretch' => 'full',
		        'background' => '#333333',
		        'custom_row_id' => 'our-services',
		        'equal_column_height' => 'yes',
		        'padding_top' => '5%',
		        'padding_bottom' => '10%',
		        'background_image' => 317,
		        'background_image_position' => 'center center',
		        'background_image_style' => 'cover',
		        'canvas_animation_effect' => 'none',
		      ),
		    ),
		    4 => 
		    array (
		      'cells' => 1,
		      'style' => 
		      array (
		        'id' => 'our-work',
		        'bottom_margin' => '0px',
		        'row_stretch' => 'full',
		        'background' => '#f7f7f7',
		        'custom_row_id' => 'our-work',
		        'equal_column_height' => 'no',
		        'padding_top' => '5%',
		        'padding_bottom' => '5%',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		        'canvas_animation_effect' => 'none',
		      ),
		    ),
		    5 => 
		    array (
		      'cells' => 1,
		      'style' => 
		      array (
		        'id' => 'recent-news',
		        'row_stretch' => 'full',
		        'background' => '#efefef',
		        'custom_row_id' => 'recent-news',
		        'equal_column_height' => 'no',
		        'padding_top' => '5%',
		        'padding_bottom' => '10%',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		        'canvas_animation_effect' => 'none',
		      ),
		    ),
		    6 => 
		    array (
		      'cells' => 2,
		      'style' => 
		      array (
		        'id' => 'contact-us',
		        'gutter' => '0px',
		        'row_stretch' => 'full-stretched',
		        'custom_row_id' => 'contact-us',
		        'equal_column_height' => 'yes',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		        'canvas_animation_effect' => 'none',
		      ),
		    ),
		    7 => 
		    array (
		      'cells' => 1,
		      'style' => 
		      array (
		        'row_stretch' => 'full-stretched',
		        'background' => '#f4f4f4',
		        'equal_column_height' => 'no',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		        'canvas_animation_effect' => 'none',
		      ),
		    ),
		  ),
		  'grid_cells' => 
		  array (
		    0 => 
		    array (
		      'grid' => 0,
		      'weight' => 1,
		    ),
		    1 => 
		    array (
		      'grid' => 1,
		      'weight' => 0.19967945168463,
		    ),
		    2 => 
		    array (
		      'grid' => 1,
		      'weight' => 0.60030417838576,
		    ),
		    3 => 
		    array (
		      'grid' => 1,
		      'weight' => 0.20001636992961,
		    ),
		    4 => 
		    array (
		      'grid' => 2,
		      'weight' => 0.21009055989637,
		    ),
		    5 => 
		    array (
		      'grid' => 2,
		      'weight' => 0.57983026582008,
		    ),
		    6 => 
		    array (
		      'grid' => 2,
		      'weight' => 0.21007917428355,
		    ),
		    7 => 
		    array (
		      'grid' => 3,
		      'weight' => 1,
		    ),
		    8 => 
		    array (
		      'grid' => 4,
		      'weight' => 1,
		    ),
		    9 => 
		    array (
		      'grid' => 5,
		      'weight' => 1,
		    ),
		    10 => 
		    array (
		      'grid' => 6,
		      'weight' => 0.5,
		    ),
		    11 => 
		    array (
		      'grid' => 6,
		      'weight' => 0.5,
		    ),
		    12 => 
		    array (
		      'grid' => 7,
		      'weight' => 1,
		    ),
		  ),
	);
	
	$layouts['home-portfolio'] = array(
		'name' => __('Home: Portfolio', 'bramble'),
		'description' => __('Layout for demo Home: Portfolio', 'bramble'),
    	'widgets' => 
		  array (
		    0 => 
		    array (
		      'title' => '',
		      'text' => '<h2>Hello. My name is <span style="color: #5bc2c0;">Bramble</span>. Check out my awesome work below.</h2>',
		      'autop' => true,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Editor_Widget',
		        'grid' => 0,
		        'cell' => 0,
		        'id' => 0,
		        'style' => 
		        array (
		          'background_image_attachment' => false,
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    1 => 
		    array (
		      'title' => '',
		      'show_filter' => 'yes',
		      'filter_selected_color' => '#5bc2c0',
		      'filter_alignment' => 'left',
		      'count' => '9',
		      'thumb_proportions' => 'square',
		      'layout' => 'rows with gutter',
		      'columns' => '3',
		      'orderby' => 'date',
		      'order' => 'DESC',
		      'hover_effect' => 'effect-1',
		      'hover_color' => '#5bc2c0',
		      'hover_text_color' => '',
		      'show_skills' => 'no',
		      'show_load_more' => 'no',
		      'load_more_color' => '#5bc2c0',
		      'load_more_text_color' => '#ffffff',
		      'enable_lightbox' => 'no',
		      'skills' => '',
		      'panels_info' => 
		      array (
		        'class' => 'TTrust_Portfolio',
		        'raw' => false,
		        'grid' => 1,
		        'cell' => 0,
		        'id' => 1,
		        'style' => 
		        array (
		          'padding' => '10px',
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		  ),
		  'grids' => 
		  array (
		    0 => 
		    array (
		      'cells' => 3,
		      'style' => 
		      array (
		        'equal_column_height' => 'no',
		        'padding_top' => '10%',
		        'padding_bottom' => '10%',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		        'canvas_animation_effect' => 'none',
		      ),
		    ),
		    1 => 
		    array (
		      'cells' => 1,
		      'style' => 
		      array (
		        'row_stretch' => 'full-stretched',
		        'equal_column_height' => 'no',
		        'padding_top' => '5%',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		        'canvas_animation_effect' => 'none',
		      ),
		    ),
		  ),
		  'grid_cells' => 
		  array (
		    0 => 
		    array (
		      'grid' => 0,
		      'weight' => 0.54358974358974,
		    ),
		    1 => 
		    array (
		      'grid' => 0,
		      'weight' => 0.21684981684982,
		    ),
		    2 => 
		    array (
		      'grid' => 0,
		      'weight' => 0.23956043956044,
		    ),
		    3 => 
		    array (
		      'grid' => 1,
		      'weight' => 1,
		    ),
		  ),
	);
	
	$layouts['home-professional'] = array(
		'name' => __('Home: Professional', 'bramble'),
		'description' => __('Layout for demo Home: Professional', 'bramble'),
		'widgets' => 
		  array (
		    0 => 
		    array (
		      'title' => '',
		      'text' => '<h1 style="text-align: center;">Striving for excellence.</h1>',
		      'autop' => true,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Editor_Widget',
		        'raw' => false,
		        'grid' => 0,
		        'cell' => 0,
		        'id' => 0,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		          'font_color' => '#ffffff',
		        ),
		      ),
		    ),
		    1 => 
		    array (
		      'text' => 'Buy Now',
		      'url' => 'http://themetrust.com/themes/bramble',
		      'button_icon' => 
		      array (
		        'icon_selected' => '',
		        'icon_color' => false,
		        'icon' => 0,
		        'so_field_container_state' => 'open',
		      ),
		      'design' => 
		      array (
		        'align' => 'center',
		        'theme' => 'flat',
		        'button_color' => '#0b6ad4',
		        'text_color' => '#ffffff',
		        'hover' => true,
		        'font_size' => '1',
		        'rounding' => '1.5',
		        'padding' => '1',
		        'so_field_container_state' => 'open',
		      ),
		      'attributes' => 
		      array (
		        'id' => '',
		        'title' => '',
		        'onclick' => '',
		        'so_field_container_state' => 'closed',
		      ),
		      '_sow_form_id' => '56b502260f923',
		      'new_window' => false,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Button_Widget',
		        'raw' => false,
		        'grid' => 0,
		        'cell' => 0,
		        'id' => 1,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    2 => 
		    array (
		      'title' => '',
		      'text' => '<h2><span style="font-size: 36px;">We love what we do, and it shows.</span></h2>',
		      'autop' => true,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Editor_Widget',
		        'raw' => false,
		        'grid' => 1,
		        'cell' => 1,
		        'id' => 2,
		        'style' => 
		        array (
		          'class' => 'v-center',
		          'padding' => '5%',
		          'background_display' => 'tile',
		          'font_color' => '#ffffff',
		        ),
		      ),
		    ),
		    3 => 
		    array (
		      'title' => '',
		      'text' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In facilisis id magna vel cursus. Cras ipsum neque, varius vitae arcu non, ullamcorper cursus est. Donec finibus risus felis, eget facilisis urna ultrices et. Aenean velit mauris, pulvinar vel purus at, dapibus bibendum purus. Etiam finibus diam quis suscipit pellentesque.</p>',
		      'autop' => true,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Editor_Widget',
		        'raw' => false,
		        'grid' => 1,
		        'cell' => 2,
		        'id' => 3,
		        'style' => 
		        array (
		          'class' => 'v-center',
		          'padding' => '5%',
		          'background_display' => 'tile',
		          'font_color' => '#afc1d4',
		        ),
		      ),
		    ),
		    4 => 
		    array (
		      'features' => 
		      array (
		        0 => 
		        array (
		          'container_color' => false,
		          'icon' => 'elegantline-desktop',
		          'icon_color' => '#0b6ad4',
		          'icon_image' => 0,
		          'title' => 'Web Design',
		          'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum at diam odio. Mauris purus ligula, pulvinar non iaculis sit amet, lobortis ut tellus.',
		          'more_text' => '',
		          'more_url' => '',
		        ),
		      ),
		      'fonts' => 
		      array (
		        'title_options' => 
		        array (
		          'font' => 'default',
		          'size' => 'px',
		          'size_unit' => 'px',
		          'color' => false,
		          'so_field_container_state' => 'closed',
		        ),
		        'text_options' => 
		        array (
		          'font' => 'default',
		          'size' => 'px',
		          'size_unit' => 'px',
		          'color' => false,
		          'so_field_container_state' => 'closed',
		        ),
		        'more_text_options' => 
		        array (
		          'font' => 'default',
		          'size' => 'px',
		          'size_unit' => 'px',
		          'color' => false,
		          'so_field_container_state' => 'closed',
		        ),
		        'so_field_container_state' => 'closed',
		      ),
		      'container_shape' => 'round',
		      'container_size' => '84px',
		      'container_size_unit' => 'px',
		      'icon_size' => '55px',
		      'icon_size_unit' => 'px',
		      'per_row' => 1,
		      'responsive' => true,
		      '_sow_form_id' => '56b501c2c36b1',
		      'title_link' => false,
		      'icon_link' => false,
		      'new_window' => false,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Features_Widget',
		        'raw' => false,
		        'grid' => 2,
		        'cell' => 0,
		        'id' => 4,
		        'style' => 
		        array (
		          'padding' => '40px',
		          'background_display' => 'tile',
		          'font_color' => '#0a0a0a',
		        ),
		      ),
		    ),
		    5 => 
		    array (
		      'min_height' => '250',
		      'panels_info' => 
		      array (
		        'class' => 'TTrust_Spacer',
		        'raw' => false,
		        'grid' => 2,
		        'cell' => 1,
		        'id' => 5,
		        'style' => 
		        array (
		          'background_image_attachment' => 104,
		          'background_display' => 'cover',
		        ),
		      ),
		    ),
		    6 => 
		    array (
		      'features' => 
		      array (
		        0 => 
		        array (
		          'container_color' => false,
		          'icon' => 'elegantline-tools',
		          'icon_color' => '#0b6ad4',
		          'icon_image' => 0,
		          'title' => 'Print',
		          'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.  Vestibulum at diam odio. Mauris purus ligula, pulvinar non iaculis sit amet, lobortis ut tellus. ',
		          'more_text' => '',
		          'more_url' => '',
		        ),
		      ),
		      'fonts' => 
		      array (
		        'title_options' => 
		        array (
		          'font' => 'default',
		          'size' => 'px',
		          'size_unit' => 'px',
		          'color' => false,
		          'so_field_container_state' => 'closed',
		        ),
		        'text_options' => 
		        array (
		          'font' => 'default',
		          'size' => 'px',
		          'size_unit' => 'px',
		          'color' => false,
		          'so_field_container_state' => 'closed',
		        ),
		        'more_text_options' => 
		        array (
		          'font' => 'default',
		          'size' => 'px',
		          'size_unit' => 'px',
		          'color' => false,
		          'so_field_container_state' => 'closed',
		        ),
		        'so_field_container_state' => 'closed',
		      ),
		      'container_shape' => 'round',
		      'container_size' => '84px',
		      'container_size_unit' => 'px',
		      'icon_size' => '55px',
		      'icon_size_unit' => 'px',
		      'per_row' => 1,
		      'responsive' => true,
		      '_sow_form_id' => '56b501ef38076',
		      'title_link' => false,
		      'icon_link' => false,
		      'new_window' => false,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Features_Widget',
		        'raw' => false,
		        'grid' => 2,
		        'cell' => 2,
		        'id' => 6,
		        'style' => 
		        array (
		          'padding' => '40px',
		          'background_display' => 'tile',
		          'font_color' => '#0a0a0a',
		        ),
		      ),
		    ),
		    7 => 
		    array (
		      'min_height' => '250',
		      'panels_info' => 
		      array (
		        'class' => 'TTrust_Spacer',
		        'raw' => false,
		        'grid' => 3,
		        'cell' => 0,
		        'id' => 7,
		        'style' => 
		        array (
		          'background_image_attachment' => 109,
		          'background_display' => 'cover',
		        ),
		      ),
		    ),
		    8 => 
		    array (
		      'features' => 
		      array (
		        0 => 
		        array (
		          'container_color' => false,
		          'icon' => 'elegantline-circle-compass',
		          'icon_color' => '#0b6ad4',
		          'icon_image' => 0,
		          'title' => 'Branding',
		          'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum at diam odio. Mauris purus ligula, pulvinar non iaculis sit amet, lobortis ut tellus.',
		          'more_text' => '',
		          'more_url' => '',
		        ),
		      ),
		      'fonts' => 
		      array (
		        'title_options' => 
		        array (
		          'font' => 'default',
		          'size' => 'px',
		          'size_unit' => 'px',
		          'color' => false,
		          'so_field_container_state' => 'closed',
		        ),
		        'text_options' => 
		        array (
		          'font' => 'default',
		          'size' => 'px',
		          'size_unit' => 'px',
		          'color' => false,
		          'so_field_container_state' => 'closed',
		        ),
		        'more_text_options' => 
		        array (
		          'font' => 'default',
		          'size' => 'px',
		          'size_unit' => 'px',
		          'color' => false,
		          'so_field_container_state' => 'closed',
		        ),
		        'so_field_container_state' => 'closed',
		      ),
		      'container_shape' => 'round',
		      'container_size' => '84px',
		      'container_size_unit' => 'px',
		      'icon_size' => '55px',
		      'icon_size_unit' => 'px',
		      'per_row' => 1,
		      'responsive' => true,
		      '_sow_form_id' => '56b501e41ecd7',
		      'title_link' => false,
		      'icon_link' => false,
		      'new_window' => false,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Features_Widget',
		        'raw' => false,
		        'grid' => 3,
		        'cell' => 1,
		        'id' => 8,
		        'style' => 
		        array (
		          'padding' => '40px',
		          'background_display' => 'tile',
		          'font_color' => '#0a0a0a',
		        ),
		      ),
		    ),
		    9 => 
		    array (
		      'min_height' => '250',
		      'panels_info' => 
		      array (
		        'class' => 'TTrust_Spacer',
		        'raw' => false,
		        'grid' => 3,
		        'cell' => 2,
		        'id' => 9,
		        'style' => 
		        array (
		          'background_image_attachment' => 107,
		          'background_display' => 'cover',
		        ),
		      ),
		    ),
		    10 => 
		    array (
		      'title' => '',
		      'text' => '<h2><span style="font-size: 36px; color: #000000;">Recent News.</span></h2><p>Donec finibus risus felis, eget facilisis urna ultrices et. Aenean velit mauris, pulvinar vel purus at, dapibus bibendum purus. Etiam finibus diam quis suscipit pellentesque.</p><p><strong><span style="color: #0b6ad4;"><a style="color: #0b6ad4;" href="http://demos.themetrust.com/bramble/blog/">Read more from the Blog</a></span></strong></p>',
		      'text_selected_editor' => 'tinymce',
		      'autop' => true,
		      '_sow_form_id' => '56b5031d17fa6',
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Editor_Widget',
		        'raw' => false,
		        'grid' => 4,
		        'cell' => 0,
		        'id' => 10,
		        'style' => 
		        array (
		          'class' => 'v-center',
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    11 => 
		    array (
		      'title' => '',
		      'count' => '4',
		      'category' => '',
		      'layout' => 'grid',
		      'columns' => '2',
		      'alignment' => 'left',
		      'orderby' => 'date',
		      'order' => 'DESC',
		      'boxed' => 'yes',
		      'show_excerpt' => 'no',
		      'carousel-nav-color' => '#0b6ad4',
		      'panels_info' => 
		      array (
		        'class' => 'TTrust_Blog',
		        'raw' => false,
		        'grid' => 4,
		        'cell' => 1,
		        'id' => 11,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    12 => 
		    array (
		      'title' => '',
		      'text' => '<h2><span style="font-size: 36px; color: #000000;">Recent Work.</span></h2>
		<p>Donec finibus risus felis, eget facilisis urna ultrices et. Aenean velit mauris, pulvinar vel purus at, dapibus bibendum purus. Etiam finibus diam quis suscipit pellentesque.</p>

		<strong><span style="color: #0b6ad4;"><a style="color: #0b6ad4;" href="http://demos.themetrust.com/bramble/portfolio/">See more of our work</a></span></strong>',
		      'text_selected_editor' => 'html',
		      'autop' => true,
		      '_sow_form_id' => '56b5079172af3',
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Editor_Widget',
		        'raw' => false,
		        'grid' => 5,
		        'cell' => 0,
		        'id' => 12,
		        'style' => 
		        array (
		          'class' => 'v-center',
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    13 => 
		    array (
		      'title' => '',
		      'show_filter' => 'no',
		      'filter_selected_color' => '',
		      'filter_alignment' => 'center',
		      'count' => '4',
		      'thumb_proportions' => 'square',
		      'layout' => 'rows with gutter',
		      'columns' => '2',
		      'orderby' => 'date',
		      'order' => 'DESC',
		      'hover_effect' => 'effect-1',
		      'hover_color' => '',
		      'hover_text_color' => '',
		      'show_skills' => 'no',
		      'show_load_more' => 'no',
		      'load_more_color' => '',
		      'load_more_text_color' => '',
		      'enable_lightbox' => 'no',
		      'skills' => '',
		      'panels_info' => 
		      array (
		        'class' => 'TTrust_Portfolio',
		        'raw' => false,
		        'grid' => 5,
		        'cell' => 1,
		        'id' => 13,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		  ),
		  'grids' => 
		  array (
		    0 => 
		    array (
		      'cells' => 1,
		      'style' => 
		      array (
		        'bottom_margin' => '0px',
		        'row_stretch' => 'full',
		        'equal_column_height' => 'no',
		        'padding_top' => '25%',
		        'padding_bottom' => '25%',
		        'background_image' => 711,
		        'background_image_position' => 'left center',
		        'background_image_style' => 'cover',
		        'canvas_animation_effect' => 'none',
		      ),
		    ),
		    1 => 
		    array (
		      'cells' => 4,
		      'style' => 
		      array (
		        'row_stretch' => 'full',
		        'background' => '#0b6ad4',
		        'equal_column_height' => 'yes',
		        'padding_top' => '10%',
		        'padding_bottom' => '10%',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		        'canvas_animation_effect' => 'none',
		      ),
		    ),
		    2 => 
		    array (
		      'cells' => 3,
		      'style' => 
		      array (
		        'bottom_margin' => '0px',
		        'gutter' => '0px',
		        'row_stretch' => 'full-stretched',
		        'background' => '#f4f4f4',
		        'equal_column_height' => 'yes',
		        'padding_left' => '0px',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		        'canvas_animation_effect' => 'none',
		      ),
		    ),
		    3 => 
		    array (
		      'cells' => 3,
		      'style' => 
		      array (
		        'bottom_margin' => '0px',
		        'gutter' => '0px',
		        'row_stretch' => 'full-stretched',
		        'background' => '#ffffff',
		        'equal_column_height' => 'yes',
		        'padding_top' => '0px',
		        'padding_bottom' => '0px',
		        'padding_left' => '0px',
		        'padding_right' => '0px',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		        'canvas_animation_effect' => 'none',
		      ),
		    ),
		    4 => 
		    array (
		      'cells' => 2,
		      'style' => 
		      array (
		        'row_stretch' => 'full',
		        'background' => '#f2f2f2',
		        'equal_column_height' => 'no',
		        'padding_top' => '80px',
		        'padding_bottom' => '60px',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		        'canvas_animation_effect' => 'none',
		      ),
		    ),
		    5 => 
		    array (
		      'cells' => 2,
		      'style' => 
		      array (
		        'row_stretch' => 'full',
		        'background' => '#eaeaea',
		        'equal_column_height' => 'no',
		        'padding_top' => '80px',
		        'padding_bottom' => '60px',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		        'canvas_animation_effect' => 'none',
		      ),
		    ),
		  ),
		  'grid_cells' => 
		  array (
		    0 => 
		    array (
		      'grid' => 0,
		      'weight' => 1,
		    ),
		    1 => 
		    array (
		      'grid' => 1,
		      'weight' => 0.059804146572489,
		    ),
		    2 => 
		    array (
		      'grid' => 1,
		      'weight' => 0.44019585342751,
		    ),
		    3 => 
		    array (
		      'grid' => 1,
		      'weight' => 0.44019585342751,
		    ),
		    4 => 
		    array (
		      'grid' => 1,
		      'weight' => 0.059804146572489,
		    ),
		    5 => 
		    array (
		      'grid' => 2,
		      'weight' => 0.33333333333333,
		    ),
		    6 => 
		    array (
		      'grid' => 2,
		      'weight' => 0.33333333333333,
		    ),
		    7 => 
		    array (
		      'grid' => 2,
		      'weight' => 0.33333333333333,
		    ),
		    8 => 
		    array (
		      'grid' => 3,
		      'weight' => 0.33333333333333,
		    ),
		    9 => 
		    array (
		      'grid' => 3,
		      'weight' => 0.33333333333333,
		    ),
		    10 => 
		    array (
		      'grid' => 3,
		      'weight' => 0.33333333333333,
		    ),
		    11 => 
		    array (
		      'grid' => 4,
		      'weight' => 0.34258210645527,
		    ),
		    12 => 
		    array (
		      'grid' => 4,
		      'weight' => 0.65741789354473,
		    ),
		    13 => 
		    array (
		      'grid' => 5,
		      'weight' => 0.34258210645527,
		    ),
		    14 => 
		    array (
		      'grid' => 5,
		      'weight' => 0.65741789354473,
		    ),
		  ),
	);
	
	$layouts['home-shop'] = array(
		'name' => __('Home: Shop', 'bramble'),
		'description' => __('Layout for demo Home: Shop', 'bramble'),
		'widgets' => 
		  array (
		    0 => 
		    array (
		      'title' => '',
		      'text' => '[rev_slider alias="shop"]',
		      'filter' => false,
		      'panels_info' => 
		      array (
		        'class' => 'WP_Widget_Text',
		        'raw' => false,
		        'grid' => 0,
		        'cell' => 0,
		        'id' => 0,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    1 => 
		    array (
		      'min_height' => '70',
		      'panels_info' => 
		      array (
		        'class' => 'TTrust_Spacer',
		        'grid' => 1,
		        'cell' => 0,
		        'id' => 1,
		        'style' => 
		        array (
		          'background_image_attachment' => 515,
		          'background_display' => 'cover',
		        ),
		      ),
		    ),
		    2 => 
		    array (
		      'title' => 'Featured Products',
		      'count' => '2',
		      'layout' => 'grid',
		      'columns' => '2',
		      'orderby' => 'date',
		      'order' => 'DESC',
		      'categories' => 
		      array (
		        't-shirts' => 't-shirts',
		      ),
		      'show_featured' => 'no',
		      'alignment' => 'left',
		      'carousel-nav-color' => '',
		      'panels_info' => 
		      array (
		        'class' => 'TTrust_Products',
		        'raw' => false,
		        'grid' => 1,
		        'cell' => 1,
		        'id' => 2,
		        'style' => 
		        array (
		          'class' => '.v-center',
		          'padding' => '10%',
		          'background_display' => 'tile',
		          'font_color' => '#212121',
		        ),
		      ),
		    ),
		    3 => 
		    array (
		      'title' => '',
		      'text' => '<h2 style="text-align: center;">CHECK OUT OUR BEST DEALS</h2><p style="text-align: center;"><span style="font-size: 18px; color: #c4c4c4;">These bargains are too goo to pass up.</span></p>',
		      'autop' => true,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Editor_Widget',
		        'grid' => 2,
		        'cell' => 1,
		        'id' => 3,
		        'style' => 
		        array (
		          'background_image_attachment' => false,
		          'background_display' => 'tile',
		          'font_color' => '#ffffff',
		        ),
		      ),
		    ),
		    4 => 
		    array (
		      'text' => 'SAVE NOW',
		      'url' => 'http://demos.themetrust.com/bramble/shop/',
		      'button_icon' => 
		      array (
		        'icon_selected' => '',
		        'icon_color' => false,
		        'icon' => 0,
		        'so_field_container_state' => 'closed',
		      ),
		      'design' => 
		      array (
		        'align' => 'center',
		        'theme' => 'flat',
		        'button_color' => '#33a5a3',
		        'text_color' => '#ffffff',
		        'hover' => true,
		        'font_size' => '1',
		        'rounding' => '1.5',
		        'padding' => '1',
		        'so_field_container_state' => 'open',
		      ),
		      'attributes' => 
		      array (
		        'id' => '',
		        'title' => '',
		        'onclick' => '',
		        'so_field_container_state' => 'closed',
		      ),
		      '_sow_form_id' => '56a3ddeea94d9',
		      'new_window' => false,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Button_Widget',
		        'raw' => false,
		        'grid' => 2,
		        'cell' => 1,
		        'id' => 4,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    5 => 
		    array (
		      'title' => '',
		      'count' => '8',
		      'layout' => 'grid',
		      'columns' => '4',
		      'orderby' => 'date',
		      'order' => 'DESC',
		      'show_featured' => 'no',
		      'alignment' => 'left',
		      'carousel-nav-color' => '',
		      'categories' => 
		      array (
		      ),
		      'panels_info' => 
		      array (
		        'class' => 'TTrust_Products',
		        'raw' => false,
		        'grid' => 3,
		        'cell' => 0,
		        'id' => 5,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		  ),
		  'grids' => 
		  array (
		    0 => 
		    array (
		      'cells' => 1,
		      'style' => 
		      array (
		        'bottom_margin' => '0px',
		        'row_stretch' => 'full',
		        'equal_column_height' => 'no',
		        'background_image_position' => 'center top',
		        'background_image_style' => 'cover',
		        'canvas_animation_effect' => 'none',
		      ),
		    ),
		    1 => 
		    array (
		      'cells' => 2,
		      'style' => 
		      array (
		        'bottom_margin' => '0px',
		        'gutter' => '0px',
		        'row_stretch' => 'full-stretched',
		        'background' => '#f7f7f7',
		        'equal_column_height' => 'yes',
		        'padding_top' => '0px',
		        'padding_bottom' => '0px',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'parallax',
		        'canvas_animation_effect' => 'none',
		      ),
		    ),
		    2 => 
		    array (
		      'cells' => 3,
		      'style' => 
		      array (
		        'bottom_margin' => '0px',
		        'gutter' => '0px',
		        'row_stretch' => 'full',
		        'background' => '#2d2d2d',
		        'equal_column_height' => 'no',
		        'padding_top' => '10%',
		        'padding_bottom' => '10%',
		        'background_image' => 528,
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		        'canvas_animation_effect' => 'none',
		      ),
		    ),
		    3 => 
		    array (
		      'cells' => 1,
		      'style' => 
		      array (
		        'bottom_margin' => '0px',
		        'gutter' => '0px',
		        'row_stretch' => 'full',
		        'background' => '#f7f7f7',
		        'equal_column_height' => 'no',
		        'padding_top' => '10%',
		        'padding_bottom' => '10%',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'parallax',
		        'canvas_animation_effect' => 'none',
		      ),
		    ),
		  ),
		  'grid_cells' => 
		  array (
		    0 => 
		    array (
		      'grid' => 0,
		      'weight' => 1,
		    ),
		    1 => 
		    array (
		      'grid' => 1,
		      'weight' => 0.5,
		    ),
		    2 => 
		    array (
		      'grid' => 1,
		      'weight' => 0.5,
		    ),
		    3 => 
		    array (
		      'grid' => 2,
		      'weight' => 0.14969869965113,
		    ),
		    4 => 
		    array (
		      'grid' => 2,
		      'weight' => 0.70060260069774,
		    ),
		    5 => 
		    array (
		      'grid' => 2,
		      'weight' => 0.14969869965113,
		    ),
		    6 => 
		    array (
		      'grid' => 3,
		      'weight' => 1,
		    ),
		  ),
	);
	
	$layouts['contact'] = array(
		'name' => __('Contact Page', 'bramble'),
		'description' => __('Layout for Contact page', 'bramble'),
		'widgets' => 
		  array (
		    0 => 
		    array (
		      'title' => '',
		      'text' => '<h1 style="text-align: center;">Get In Touch</h1>',
		      'text_selected_editor' => 'tinymce',
		      'autop' => true,
		      '_sow_form_id' => '56732dbe884d1',
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Editor_Widget',
		        'raw' => false,
		        'grid' => 0,
		        'cell' => 1,
		        'id' => 0,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		          'font_color' => '#ffffff',
		        ),
		      ),
		    ),
		    1 => 
		    array (
		      'title' => '',
		      'text' => '<h3><span style="color: #242424;">Contact Us</span></h3><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus posuere interdum diam eget semper. Pellentesque purus turpis, vehicula et posuere ultrices, dictum vitae turpis. Cras porta enim justo, a tempus arcu ullamcorper in.</p><p>[contact-form-7 id="4" title="Contact form 1"]</p>',
		      'autop' => true,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Editor_Widget',
		        'grid' => 1,
		        'cell' => 0,
		        'id' => 1,
		        'style' => 
		        array (
		          'background_image_attachment' => false,
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		    2 => 
		    array (
		      'title' => '',
		      'text' => '<h4><span style="color: #242424;">Address</span></h4><p>1234 Main St.<br />New York, NY 10021</p><h4><span style="color: #242424;">Phone</span></h4><p>555-456-7892 <em>New York Office<br /></em>555-376-4532 Los Angeles<em> Office</em></p><h4><span style="color: #242424;">Email</span></h4><p>contact@bramble-digital.com</p>',
		      'autop' => true,
		      'panels_info' => 
		      array (
		        'class' => 'SiteOrigin_Widget_Editor_Widget',
		        'raw' => false,
		        'grid' => 1,
		        'cell' => 1,
		        'id' => 2,
		        'style' => 
		        array (
		          'background_display' => 'tile',
		        ),
		      ),
		    ),
		  ),
		  'grids' => 
		  array (
		    0 => 
		    array (
		      'cells' => 3,
		      'style' => 
		      array (
		        'bottom_margin' => '50px',
		        'row_stretch' => 'full',
		        'equal_column_height' => 'no',
		        'padding_top' => '200px',
		        'padding_bottom' => '200px',
		        'background_image' => 186,
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		        'canvas_animation_effect' => 'none',
		      ),
		    ),
		    1 => 
		    array (
		      'cells' => 2,
		      'style' => 
		      array (
		        'bottom_margin' => '60px',
		        'equal_column_height' => 'no',
		        'padding_bottom' => '60px',
		        'background_image_position' => 'left top',
		        'background_image_style' => 'cover',
		      ),
		    ),
		  ),
		  'grid_cells' => 
		  array (
		    0 => 
		    array (
		      'grid' => 0,
		      'weight' => 0.1098233995585,
		    ),
		    1 => 
		    array (
		      'grid' => 0,
		      'weight' => 0.77952538631346,
		    ),
		    2 => 
		    array (
		      'grid' => 0,
		      'weight' => 0.11065121412804,
		    ),
		    3 => 
		    array (
		      'grid' => 1,
		      'weight' => 0.63971539456662,
		    ),
		    4 => 
		    array (
		      'grid' => 1,
		      'weight' => 0.36028460543338,
		    ),
		  ),
	);
	
	return $layouts;

}
add_filter('siteorigin_panels_prebuilt_layouts','bramble_prebuilt_layouts');



?>