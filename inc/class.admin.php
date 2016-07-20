<?php

class HouseCall_Admin {

  public function __construct(){
    $options = get_option('hv_settings');
    add_action( 'admin_menu', array( $this, 'add_settings_page' ) );
    add_action( 'admin_footer', array( $this, 'add_map_js' ) );
  }

  public function add_settings_page() {
    add_options_page(
      'House Visit Settings',
      'House Visits',
      'manage_options',
      'house-visits',
      array( $this, 'load_settings_page' )
    );

    $options = get_option('hv_settings');

    register_setting(
        'housevisit_settings_options',
        'hv_settings',
        array($this, 'sanitize')
    );

    add_settings_section(
        'housevisit_settings_section',
        '',
        null,
        'house-visits'
    );

    add_settings_field(
        'hv_address',
        'Starting Address',
        array($this, 'hv_address_callback'),
        'house-visits',
        'housevisit_settings_section'
    );

    add_settings_field(
        'hv_baseprice',
        'Base Price',
        array($this, 'hv_baseprice_callback'),
        'house-visits',
        'housevisit_settings_section'
    );

    add_settings_field(
        'hv_radius',
        'Free/Included Miles',
        array($this, 'hv_radius_callback'),
        'house-visits',
        'housevisit_settings_section'
    );

    add_settings_field(
        'hv_mileageprice',
        'Price Per Extra Mile',
        array($this, 'hv_mileageprice_callback'),
        'house-visits',
        'housevisit_settings_section'
    );

    add_settings_field(
      'hv_addtopage',
      'Add To Page',
      array($this, 'hv_addtopage_callback'),
      'house-visits',
      'housevisit_settings_section'
    );

  }

  public function add_map_js(){
    $src = plugins_url( '../assets/hv_map.js',  __FILE__ );

    wp_enqueue_script('hv-map',  $src, ['jquery']);
  }

  public function load_settings_page() {
    require_once( 'admin-page.php' );
  }

  public function hv_address_callback(){
    $options = get_option('hv_settings');
    $address  = ( isset($options['hv_address']) && $options['hv_address'] ? $options['hv_address'] : '' );

    printf(
      '<textarea name="hv_settings[hv_address]" rows="5" cols="10" id="hv_address" class="large-text" placeholder="Address, City, State, ZIP">%s</textarea>',
      $address
    );
  }

  public function hv_baseprice_callback(){
    $options = get_option('hv_settings');
    $baseprice  = ( isset($options['hv_baseprice']) && $options['hv_baseprice'] ? $options['hv_baseprice'] : '' );

    printf(
      '<input name="hv_settings[hv_baseprice]" type="number" step="1" id="hv_baseprice" class="regular-text" value="%s" placeholder="$20, $40, $60 etc.">',
      $baseprice
    );
  }

  public function hv_radius_callback(){
    $options = get_option('hv_settings');
    $radius  = ( isset($options['hv_radius']) && $options['hv_radius'] ? $options['hv_radius'] : '' );

    printf(
      '<input name="hv_settings[hv_radius]" type="number" step="1" id="hv_radius" class="regular-text" value="%s" placeholder="0">
      <p><small>The map will display a rough estimate of your "free" zone.</small></p>',
      $radius
    );
  }

  public function hv_mileageprice_callback(){
    $options = get_option('hv_settings');
    $mileageprice  = ( isset($options['hv_mileageprice']) && $options['hv_mileageprice'] ? $options['hv_mileageprice'] : '' );

    printf(
      '<input name="hv_settings[hv_mileageprice]" type="number" step="0.01" id="hv_mileageprice" class="regular-text" value="%s" placeholder="0.00">
      <p><small>The IRS reimbursement rate is 54 cents/mile.</small></p>',
      $mileageprice
    );
  }

  public function hv_addtopage_callback(){
    $options = get_option('hv_settings');
    $page_choice = ( isset($options['hv_addtopage']) && $options['hv_addtopage'] ? $options['hv_addtopage'] : '' );

    $pageargs = array(
      'sort_order' => 'asc',
      'sort_column' => 'menu_order',
    	'post_type' => 'page',
    	'post_status' => 'publish'
    );
    $pages = get_pages($pageargs);

    $page_options = '';

    foreach( $pages as $page ){
      if( $page->ID == $page_choice ){
        $page_options .= '<option value="' . $page->ID . '" selected>' . $page->post_title . '</option>';
      } else {
        $page_options .= '<option value="' . $page->ID . '">' . $page->post_title . '</option>';
      }
    }

    print_r(
      '<select name="hv_settings[hv_addtopage]">' . $page_options . '</select>
      <p><small>Choose which page to display the estimator on.</small></p>'
    );

  }

  public function sanitize ( $input )
  {
      $new_input = array();

      $options = get_option('hv_settings');

      if ( isset($input['hv_address']) )
          $new_input['hv_address'] = $input['hv_address'];

      if ( isset($input['hv_baseprice']) )
          $new_input['hv_baseprice'] = $input['hv_baseprice'];

      if ( isset($input['hv_radius']) )
          $new_input['hv_radius'] = $input['hv_radius'];

      if ( isset($input['hv_mileageprice']) )
          $new_input['hv_mileageprice'] = $input['hv_mileageprice'];

      if ( isset($input['hv_addtopage']) )
          $new_input['hv_addtopage'] = $input['hv_addtopage'];

      return $new_input;
  }


}

new HouseCall_Admin();
