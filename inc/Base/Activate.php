<?php

namespace Inc\Base;

class Activate{

  // Activates plugin and flush
  public static function activate(){
    flush_rewrite_rules();
    
    $default = [];

    // Check if the plugin options has been set
    if( ! get_option('predator_plugin')){
      update_option('predator_plugin', $default);
    }

    // Check if the cpt options has been set
    if( ! get_option('predator_plugin_cpt')){
      update_option('predator_plugin_cpt', $default);
    }

    // Check if the cpt options has been set
    if( ! get_option('predator_plugin_tax')){
      update_option('predator_plugin_tax', $default);
    }
  }
}