<?php

namespace Inc\Base;

// Extends classes to give access to root directory
class BaseController{

  public $plugin_path;
  public $plugin_url;
  public $plugin_basename;
  public $managers = array();
  
  public function __construct(){
    
    $this->plugin_path = plugin_dir_path(dirname(__FILE__, 2));
    $this->plugin_url = plugin_dir_url(dirname(__FILE__, 2));
    $this->plugin_basename = plugin_basename(dirname(__FILE__, 3)) . '/predator-plugin.php';
    
    $this->managers = [
      'cpt_manager',
      'taxonomy_manager',
      'media_manager',
      'gallery_manager',
      'testimonial_manager',
      'template_manager',
      'login_manager',
      'membership_manager',
      'chat_manager',
    ];
  }
}