<?php

namespace Inc\Base;

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
      'cpt_manager' => 'CPT Manager:',
      'taxonomy_manager' => 'Taxonomy Manager:',
      'widget_manager' => 'Media Widget Manager:',
      'gallery_manager' => 'Gallery Manager:',
      'testimonial_manager' => 'Testimonial Manager:',
      'template_manager' => 'Template Manager:',
      'auth_manager' => 'Ajax Login Manager:',
      'membership_manager' => 'Membership Manager:',
      'chat_manager' => 'Chat Manager:',
    ];
  }
}