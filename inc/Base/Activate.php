<?php

namespace Inc\Base;

class Activate{

  // Activates plugin and flush
  public static function activate(){
    flush_rewrite_rules();

    // Check if the plugin options has been set
    if(get_option('predator-plugin')){
      return;
    }
    
    $default = [];
    update_option('predator-plugin', $default);
  }
}