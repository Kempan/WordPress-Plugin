<?php

namespace Inc\Base;

use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;

class ChatController extends BaseController{

  public $settings;
  public $callbacks;
  public $subpages = [];
  
  public function register(){

    $option = get_option('predator_plugin');
    $activated = isset($option['chat_manager']) ? $option['chat_manager'] : false;
    
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
        'page_title' => 'Chat Manager',
        'menu_title' => 'Chat Manager',
        'capability' => 'manage_options',
        'menu_slug' => 'predator_chat',
        'callback' => array($this->callbacks, 'chatDashboard'),
      ],
    ];
  }
}