<?php

namespace Inc\Pages;

use \Inc\Base\BaseController;
use \Inc\Api\SettingsApi;

class Admin extends BaseController{

  // Instance of SettingsApi, declared register();
  public $settings;
  // The admin pages you want to generate, declared in setPages();
  public $pages = array();
  // The admin subpages you want to generate, declared in setSubPages();
  public $subpages = array();

  
  public function register(){

    // SettingsApi is a class that dynamicly creates admin pages and sub pages from the $pages/$subpages.
    // So first I create a new instance of SettingsApi and store it in $settings
    $this->settings = new SettingsApi();

    // Now I set my admin pages and admin sub pages with these functions
    $this->setPages();
    $this->setSubPages();

    // Now I can touch the SettingsApi functions with my generated pages
    $this->settings->addPages($this->pages)->withSubPage('Dashboard')->addSubPages($this->subpages)->register();
  }

  // I'am using these functions to set pages because I want
  // to leave the construct untouched for BaseController plugin_path access
  public function setPages(){

    // Create your admin pages here
    $this->pages = [
      [
        'page_title' => 'Demo-plugin',
        'menu_title' => 'DemoPlugin',
        'capability' => 'manage_options',
        'menu_slug' => 'demo_plugin',
        'callback' => function(){ return require_once("$this->plugin_path/templates/admin-index.php"); },
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
        'parent_slug' => 'demo_plugin',
        'page_title' => 'Custom Post Types',
        'menu_title' => 'CPT',
        'capability' => 'manage_options',
        'menu_slug' => 'demo_cpt',
        'callback' => function(){echo '<h1>CPT Options</h1>';},
      ],
      [
        'parent_slug' => 'demo_plugin',
        'page_title' => 'Custom Taxonomies',
        'menu_title' => 'Taxonomies',
        'capability' => 'manage_options',
        'menu_slug' => 'demo_taxonomies',
        'callback' => function(){echo '<h1>Taxonomies Options</h1>';},
      ],
      [
        'parent_slug' => 'demo_plugin',
        'page_title' => 'Custom Widgets',
        'menu_title' => 'Widgets',
        'capability' => 'manage_options',
        'menu_slug' => 'demo_widgets',
        'callback' => function(){echo '<h1>Widgets Options</h1>';},
      ],
    ];
  }

  // Other way to add admin pages below --

  // Adding the plugin admin page in menu
    // add_action('admin_menu', array($this, 'add_admin_pages'));

  // Creating the admin page
    // public function add_admin_pages(){
    //   add_menu_page('Demo-plugin', 'DemoPlugin', 'manage_options', 'demo_plugin', array($this, 'admin_index'), 'dashicons-admin-generic', 110);
    // }

  // Require the admin page template
  // plugin_path is defined in BaseController
    // public function admin_index(){
    //   require_once $this->plugin_path . 'templates/admin-index.php';
    // }
}