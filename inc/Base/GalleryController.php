<?php

namespace Inc\Base;

use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;

class GalleryController extends BaseController{

  public $settings;
  public $callbacks;
  public $subpages = [];
  
  public function register(){

    $option = get_option('predator_plugin');
    $activated = isset($option['gallery_manager']) ? $option['gallery_manager'] : false;
    
    if( ! $activated){
      return;
    }

    $this->callbacks = new AdminCallbacks;
    $this->settings = new SettingsApi;

    $this->setSubPages();

    $this->settings->addSubPages($this->subpages)->register();

  }

  public function setSubPages(){

    // Create your admin sub pages here
    $this->subpages = [
      [
        'parent_slug' => 'predator_plugin',
        'page_title' => 'Gallery Manager',
        'menu_title' => 'Gallery Manager',
        'capability' => 'manage_options',
        'menu_slug' => 'predator_gallery',
        'callback' => array($this->callbacks, 'galleryDashboard'),
      ],
    ];
  }
}