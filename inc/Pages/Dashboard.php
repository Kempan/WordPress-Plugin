<?php

namespace Inc\Pages;

use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\Callbacks\ManagerCallbacks;

class Dashboard extends BaseController{

  // ---------- CLASS DECLARATIONS ----------

  // Instance of SettingsApi, declared in register();
  public $settings;
  // Instance of AdminCallbacks, declared in register();
  public $callbacks;
  // Instance of ManagerCallbacks, declared in register();
  public $callbacks_manager;

  // ---------- ADMIN PAGES DECLARATIONS ----------
  // The admin pages you want to generate, declared in setPages();
  public $pages = array();
  // The admin subpages you want to generate, declared in setSubPages();
  // public $subpages = array();

  
  public function register(){

    // SettingsApi contains functions that creates admin pages and sub pages from the $pages/$subpages.
    // Update: It now also creates custom admin sections and fields
    $this->settings = new SettingsApi();

    // AdminCallbacks contains callback functions for the admin templates
    $this->callbacks = new AdminCallbacks();

    // ManagerCallbacks contains functions to print the diffrent option checkboxes
    $this->callbacks_manager = new ManagerCallbacks();

    // I set my custom admin fields with these functions
    $this->setSettings();
    $this->setSections();
    $this->setFields();

    // I set my admin pages and admin sub pages with these functions
    $this->setPages();
    // $this->setSubPages();

    // Now I can touch the SettingsApi functions with my generated pages
    $this->settings->addPages($this->pages)->withSubPage('Dashboard')->register();
  }

  // I was using the construct first but rebuilt using these functions to set pages because I want
  // to leave the construct untouched for BaseController plugin_path access
  public function setPages(){

    // Create your admin pages here
    $this->pages = [
      [
        'page_title' => 'Predator Plugin',
        'menu_title' => 'PredatorPlugin',
        'capability' => 'manage_options',
        'menu_slug' => 'predator_plugin',
        'callback' => array($this->callbacks, 'adminDashboard'),
        'icon_url' => 'dashicons-admin-generic',
        'position' => 110
      ]
    ];
  }
  
  // ---------- CUSTOM ADMIN FIELDS ----------

  // SETTINGS
  public function setSettings(){

    // I do this to not create a table in the DB for each option name
    // like I did in the loop below
    $args = [
      [
        'option_group' => 'predator_option_group',
        'option_name' => 'predator_plugin',
        'callback' => array($this->callbacks_manager, 'checkboxSanitize'),
      ]
    ];

    // foreach($this->managers as $key => $value){
    //   $args[] = [
    //     'option_group' => 'predator_option_group',
    //     'option_name' => $key,
    //     'callback' => array($this->callbacks_manager, 'checkboxSanitize'),
    //   ];
    // }

    $this->settings->setSettings($args);
  }

  // SECTIONS
  public function setSections(){
    $args = [
      [
        'id' => 'predator_admin_index',
        'title' => 'Settings Manager',
        'callback' => array($this->callbacks_manager, 'adminSectionManager'),
        'page' => 'predator_plugin'
      ],
    ];

    $this->settings->setSections($args);
  }

  // FIELDS
  public function setFields(){
    $args = [];

    foreach($this->managers as $key => $value){
      $args[] = [
        'id' => $key,
        'title' => $value,
        'callback' => array($this->callbacks_manager, 'checkboxField'),
        'page' => 'predator_plugin',
        'section' => 'predator_admin_index',
        'args' => [
          'label_for' => $key,
          'class' => 'ui-toggle',
          'option_name' => 'predator_plugin',
        ]
      ];
    }

    $this->settings->setFields($args);
  }
}