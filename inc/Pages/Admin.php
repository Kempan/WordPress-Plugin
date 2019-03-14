<?php

namespace Inc\Pages;

use \Inc\Api\SettingsApi;
use \Inc\Base\BaseController;
use \Inc\Api\Callbacks\AdminCallbacks;
use \Inc\Api\Callbacks\ManagerCallbacks;

class Admin extends BaseController{

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
  public $subpages = array();

  
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
    $this->setSubPages();

    // Now I can touch the SettingsApi functions with my generated pages
    $this->settings->addPages($this->pages)->withSubPage('Dashboard')->addSubPages($this->subpages)->register();
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

  // I'am using these functions to set pages because I want
  // to leave the construct untouched for BaseController plugin_path access
  public function setSubPages(){

    // Create your admin sub pages here
    $this->subpages = [
      [
        'parent_slug' => 'predator_plugin',
        'page_title' => 'Custom Post Types',
        'menu_title' => 'CPT',
        'capability' => 'manage_options',
        'menu_slug' => 'predator_cpt',
        'callback' => array($this->callbacks, 'cptDashboard'),
      ],
      [
        'parent_slug' => 'predator_plugin',
        'page_title' => 'Custom Taxonomies',
        'menu_title' => 'Taxonomies',
        'capability' => 'manage_options',
        'menu_slug' => 'predator_taxonomies',
        'callback' => array($this->callbacks, 'taxonomiesDashboard'),
      ],
      [
        'parent_slug' => 'predator_plugin',
        'page_title' => 'Custom Widgets',
        'menu_title' => 'Widgets',
        'capability' => 'manage_options',
        'menu_slug' => 'predator_widgets',
        'callback' => array($this->callbacks, 'widgetsDashboard'),
      ],
    ];
  }



  
  // ---------- CUSTOM ADMIN FIELDS ----------

  // SETTINGS
  public function setSettings(){
    $args = [];

    foreach($this->managers as $manager){
      $args[] =
        [
          'option_group' => 'predator_option_group',
          'option_name' => $manager,
          'callback' => array($this->callbacks_manager, 'checkboxSanitize'),
        ];
    }

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
    $args = [
      [
        'id' => 'cpt_manager',
        'title' => 'CPT Manager:',
        'callback' => array($this->callbacks_manager, 'checkboxField'),
        'page' => 'predator_plugin',
        'section' => 'predator_admin_index',
        'args' => [
          'label_for' => 'cpt_manager',
          'class' => 'ui-toggle'
        ]
      ],
      [
        'id' => 'taxonomy_manager',
        'title' => 'Taxonomy Manager:',
        'callback' => array($this->callbacks_manager, 'checkboxField'),
        'page' => 'predator_plugin',
        'section' => 'predator_admin_index',
        'args' => [
          'label_for' => 'taxonomy_manager',
          'class' => 'ui-toggle'
        ]
      ],
      [
        'id' => 'media_manager',
        'title' => 'Media Manager:',
        'callback' => array($this->callbacks_manager, 'checkboxField'),
        'page' => 'predator_plugin',
        'section' => 'predator_admin_index',
        'args' => [
          'label_for' => 'media_manager',
          'class' => 'ui-toggle'
        ]
      ],
      [
        'id' => 'gallery_manager',
        'title' => 'Gallery Manager:',
        'callback' => array($this->callbacks_manager, 'checkboxField'),
        'page' => 'predator_plugin',
        'section' => 'predator_admin_index',
        'args' => [
          'label_for' => 'gallery_manager',
          'class' => 'ui-toggle'
        ]
      ],
      [
        'id' => 'testimonial_manager',
        'title' => 'Testimonial Manager:',
        'callback' => array($this->callbacks_manager, 'checkboxField'),
        'page' => 'predator_plugin',
        'section' => 'predator_admin_index',
        'args' => [
          'label_for' => 'testimonial_manager',
          'class' => 'ui-toggle'
        ]
      ],
      [
        'id' => 'template_manager',
        'title' => 'Template Manager:',
        'callback' => array($this->callbacks_manager, 'checkboxField'),
        'page' => 'predator_plugin',
        'section' => 'predator_admin_index',
        'args' => [
          'label_for' => 'template_manager',
          'class' => 'ui-toggle'
        ]
      ],
      [
        'id' => 'login_manager',
        'title' => 'Ajax Login Manager:',
        'callback' => array($this->callbacks_manager, 'checkboxField'),
        'page' => 'predator_plugin',
        'section' => 'predator_admin_index',
        'args' => [
          'label_for' => 'login_manager',
          'class' => 'ui-toggle'
        ]
      ],
      [
        'id' => 'membership_manager',
        'title' => 'Membership Manager:',
        'callback' => array($this->callbacks_manager, 'checkboxField'),
        'page' => 'predator_plugin',
        'section' => 'predator_admin_index',
        'args' => [
          'label_for' => 'membership_manager',
          'class' => 'ui-toggle'
        ]
      ],
      [
        'id' => 'chat_manager',
        'title' => 'Chat Manager:',
        'callback' => array($this->callbacks_manager, 'checkboxField'),
        'page' => 'predator_plugin',
        'section' => 'predator_admin_index',
        'args' => [
          'label_for' => 'chat_manager',
          'class' => 'ui-toggle'
        ]
      ],
    ];

    $this->settings->setFields($args);
  }
}