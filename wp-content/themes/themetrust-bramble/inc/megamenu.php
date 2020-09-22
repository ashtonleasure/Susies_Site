<?php
/**
 *
 * Bramble Mega Menu 
 * @since 1.0.0
 * @version 1.0.0
 *
 */
locate_template( 'inc/custom_walker_nav_menu.php', true );

class Bramble_Megamenu extends TT_Abstract{

  public $extra_fields = array( 'highlight', 'highlight_type', 'icon', 'mega', 'mega_width', 'mega_position', 'mega_custom_width', 'column_title', 'column_title_link', 'column_width', 'content' );
  public $walker = null;

  public function __construct() {

    $this->addFilter( 'wp_nav_menu_args', 'wp_nav_menu_args', 99 );
    $this->addFilter( 'wp_edit_nav_menu_walker', 'wp_edit_nav_menu_walker', 10, 2 );
    $this->addFilter( 'wp_setup_nav_menu_item', 'wp_setup_nav_menu_item', 10, 1 );

    $this->addAction( 'wp_update_nav_menu_item', 'wp_update_nav_menu_item', 10, 3 );
    $this->addAction( 'bramble_mega_menu_fields', 'bramble_mega_menu_fields', 10, 2 );
    $this->addAction( 'bramble_mega_menu_labels', 'bramble_mega_menu_labels' );

  }

  /**
   *
   * Menu Fields
   * @since 1.0.0
   * @version 1.0.0
   *
   */
  public function bramble_mega_menu_fields( $item_id, $item ) {
  ?>

  <div class="field-icon description description-wide">
    <?php
      $hidden = ( empty( $item->icon ) ) ? ' hidden' : '';
      $icon   = ( !empty( $item->icon ) ) ? ' class="'. bramble_icon_class( $item->icon ) . '"' : '';
    ?>
    <div class="bramble_field bramble_field_icon">
      <div class="icon-select">
        <span class="button icon-picker <?php echo $item->icon; ?>"><?php _e(" Icon", 'bramble'); ?></span>
        <input type="hidden" name="menu-item-icon[<?php echo $item_id; ?>]" value="<?php echo $item->icon; ?>" class="widefat code edit-menu-item-icon icon-value"/>
	  </div>
    </div>
  </div>

  <div class="clear"></div>
  <?php
  }
  public function bramble_mega_menu_labels() {

    $out   = '<span class="item-mega"><span class="label label-primary">Mega Menu</span></span>';
    $out  .= '<span class="item-mega-column"><span class="label label-success">Column</span></span>';
    echo $out;

  }

  /**
   *
   * Custom Menu Args
   * @since 1.0.0
   * @version 1.0.0
   *
   */
  public function wp_nav_menu_args( $args ) {

    if( $args['theme_location'] == 'primary' && ! isset( $args['mobile'] ) ) {
      $this->walker       = new Walker_Nav_Menu_Custom();
      $args['container']  = false;
      $args['menu_class'] = 'main-menu sf-menu sf-vertical';
      $args['walker']     = $this->walker;
      $args['items_wrap'] = $this->walker->custom_wrap();
    } else if ( isset( $args['mobile'] ) ) {
      $args['after']      = '<div class="dropdown-plus"><i class="fa fa-plus"></i></div>';
    }

    return $args;
  }

  /**
   *
   * Custom Nav Menu Edit
   * @since 1.0.0
   * @version 1.0.0
   *
   */
  public function wp_edit_nav_menu_walker( $walker, $menu_id ) {
    return 'Walker_Nav_Menu_Edit_Custom';
  }

  /**
   *
   * Save Custom Fields
   * @since 1.0.0
   * @version 1.0.0
   *
   */
  public function wp_setup_nav_menu_item( $item ) {

    foreach ( $this->extra_fields as $key ) {
      $item->$key = get_post_meta( $item->ID, '_menu_item_'. $key, true );
    }

    return $item;
  }

  /**
   *
   * Update Custom Fields
   * @since 1.0.0
   * @version 1.0.0
   *
   */
  public function wp_update_nav_menu_item( $menu_id, $menu_item_db_id, $args ) {

    foreach ( $this->extra_fields as $key ) {
      $value = ( isset( $_REQUEST['menu-item-'.$key][$menu_item_db_id] ) ) ? $_REQUEST['menu-item-'.$key][$menu_item_db_id] : '';
      update_post_meta( $menu_item_db_id, '_menu_item_'. $key, $value );
    }

  }
}
new Bramble_Megamenu();