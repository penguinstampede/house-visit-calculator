<?php

class HouseCall {

  public function __construct(){
    add_action( 'the_content', array( $this, 'add_housevisit' ) );
  }

  public function add_housevisit($content){
    if(is_page()){
      $options = get_option('hv_settings');
      if( isset($options['hv_addtopage']) && $options['hv_addtopage'] == get_the_ID()) {
        $js_src = plugins_url( '../assets/hv_calc.js',  __FILE__ );
        wp_enqueue_script('hv-calc', $js_src, ['jquery']);
        wp_enqueue_script('hv-gmaps', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyAMi-DNji2s2jaWG76-TgJvYA5BKwlHHkw', ['jquery']);

        $content .= $this->get_hvtemplate($options);
      }
    }
    return $content;
  }

  public function get_hvtemplate($options){
    ob_start();
    require_once( 'frontend-form.php' );
    return ob_get_clean();
  }

}

new HouseCall();
