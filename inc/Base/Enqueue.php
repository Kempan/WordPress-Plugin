<?php

namespace Inc\Base;

use \Inc\Base\BaseController;

class Enqueue extends BaseController{

  // Activate scripts from enqueue()
  public function register(){
    add_action('admin_enqueue_scripts', array($this, 'enqueue'));
  }
  
  // Enqueue your styles and scripts
  public function enqueue(){
    wp_enqueue_style('plugin-style', $this->plugin_url . 'assets/style.css', __FILE__);
    wp_enqueue_script('plugin-script', $this->plugin_url . 'assets/style.css', __FILE__);
  }
}