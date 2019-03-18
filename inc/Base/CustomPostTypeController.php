<?php

namespace Inc\Base;

use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;

class CustomPostTypeController extends BaseController{

  public $settings;
  public $callbacks;
  public $subpages = [];
  
  public function register(){

    $option = get_option('predator_plugin');
    $activated = isset($option['cpt_manager']) ? $option['cpt_manager'] : false;
    
    if( ! $activated){
      return;
    }

    $this->callbacks = new AdminCallbacks;
    $this->settings = new SettingsApi;

    $this->setSubPages();

    $this->settings->addSubPages($this->subpages)->register();

    add_action('init', array($this, 'activate'));
  }

  public function setSubPages(){

    // Create your admin sub pages here
    $this->subpages = [
      [
        'parent_slug' => 'predator_plugin',
        'page_title' => 'Custom Post Types',
        'menu_title' => 'CPT Manager',
        'capability' => 'manage_options',
        'menu_slug' => 'predator_cpt',
        'callback' => array($this->callbacks, 'cptDashboard'),
      ],
    ];
  }

  public function activate(){
    register_post_type('predator_products', [
      'labels' => [
        'name' => 'Products',
        'singular_name' => 'Product'
      ],
      'public' => true,
      'has_archive' => true
    ]);
  }
}