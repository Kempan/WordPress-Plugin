<?php

namespace Inc\Api;

class SettingsApi{

  // Admin pages and sub pages
  public $admin_pages = array();
  public $admin_subpages = array();

  // Custom admin fields
  public $settings = array();
  public $sections = array();
  public $fields = array();

  // --------- ADMIN PAGES AND SUB PAGES ---------

  // Check for pages and activate addAdminMenu();
  public function register(){
    if( ! empty($this->admin_pages)){
      add_action('admin_menu', array($this, 'addAdminMenu'));
    }
    if( ! empty($this->settings)){
      add_action('admin_init', array($this, 'registerCustomFields'));
    }
  }

  // Recieves array of admin menu pages from Admin.php and stores in $admin_pages
  public function addPages(array $pages){
    $this->admin_pages = $pages;
    return $this;
  }

  // Creates a sub menu page wich is required by WordPress
  // to have the same slug but I made it so you can change the title
  public function withSubPage(string $title = null){

    if(empty($this->admin_pages)){
      return $this;
    }

    // Take the first admin page values and use on the first sub page
    // This is required by wordpress but you can change the menu_title
    $admin_page = $this->admin_pages[0];

    $sub_page = [
      [
        'parent_slug' => $admin_page['menu_slug'],
        'page_title' => $admin_page['page_title'],
        'menu_title' => ($title) ? $title : $admin_page['menu_title'],
        'capability' => $admin_page['capability'],
        'menu_slug' => $admin_page['menu_slug'],
        'callback' => $admin_page['callback']
      ]
    ];

    $this->admin_subpages = $sub_page;

    return $this;
  }

  // Merging/adding the rest of your admin sub pages to $admin_subpages
  public function addSubPages(array $pages){
    $this->admin_subpages = array_merge($this->admin_subpages, $pages);
    return $this;
  }

  // Creates admin menu pages and sub pages with $admin_pages && $admin_subpages
  public function addAdminMenu(){
    foreach($this->admin_pages as $page){
      add_menu_page($page['page_title'], $page['menu_title'], $page['capability'], $page['menu_slug'], $page['callback'], $page['icon_url'], $page['page_title']);
    }
    foreach($this->admin_subpages as $page){
      add_submenu_page($page['parent_slug'], $page['page_title'], $page['menu_title'], $page['capability'], $page['menu_slug'], $page['callback']);
    }
  }

  // --------- ADMIN CUSTOM FIELDS ---------

  // Recieves array of setting values from Admin.php and stores it in $settings
  public function setSettings(array $settings){
    $this->settings = $settings;
    return $this;
  }
  // Recieves array of section values from Admin.php and stores it in $sections
  public function setSections(array $sections){
    $this->sections = $sections;
    return $this;
  }
  // Recieves array of field values from Admin.php and stores it in $fields
  public function setFields(array $fields){
    $this->fields = $fields;
    return $this;
  }

  public function registerCustomFields(){
    // Register the setting
    foreach($this->settings as $setting){
      register_setting($setting["option_group"], $setting["option_name"], (isset($setting["callback"]) ? $setting["callback"] : ''));
    }
    // Add the settings section
    foreach($this->sections as $section){
      add_settings_section($section["id"], $section["title"], (isset($section["callback"]) ? $section["callback"] : ''), $section["page"]);
    }
    // Add settings field
    foreach($this->fields as $field){
      add_settings_field($field["id"], $field["title"], (isset($field["callback"]) ? $field["callback"] : ''), $field["page"], $field["section"], (isset($field["args"]) ? $field["args"] : ''));
    }
  }
}