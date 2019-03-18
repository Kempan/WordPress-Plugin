<?php

namespace Inc\Base;

use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;

class MembershipController extends BaseController{

  public $settings;
  public $callbacks;
  public $subpages = [];
  
  public function register(){

    $option = get_option('predator_plugin');
    $activated = isset($option['membership_manager']) ? $option['membership_manager'] : false;
    
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
        'page_title' => 'Membership Manager',
        'menu_title' => 'Membership Manager',
        'capability' => 'manage_options',
        'menu_slug' => 'predator_membership',
        'callback' => array($this->callbacks, 'membershipDashboard'),
      ],
    ];
  }
}