<?php

namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;

class AdminCallbacks extends BaseController{

  // Callbacks that returns templates to the admin pages
  public function adminDashboard(){
    return require_once("$this->plugin_path/templates/admin-index.php");
  }
  // CPT
  public function cptDashboard(){
    return require_once("$this->plugin_path/templates/cpt-index.php");
  }
  // Taxonomies
  public function taxonomiesDashboard(){
    return require_once("$this->plugin_path/templates/taxonomies-index.php");
  }
  // Widgets
  public function widgetDashboard(){
    return require_once("$this->plugin_path/templates/widgets-index.php");
  }
  // Gallery
  public function galleryDashboard(){
    return require_once("$this->plugin_path/templates/gallery-index.php");
  }
  // Membership
  public function membershipDashboard(){
    return require_once("$this->plugin_path/templates/membership-index.php");
  }
  // Template
  public function templateDashboard(){
    return require_once("$this->plugin_path/templates/template-index.php");
  }
  // Testimonials
  public function testimonialDashboard(){
    return require_once("$this->plugin_path/templates/testimonials-index.php");
  }
  // Login
  public function authDashboard(){
    return require_once("$this->plugin_path/templates/auth-index.php");
  }
  // Login
  public function chatDashboard(){
    return require_once("$this->plugin_path/templates/chat-index.php");
  }
}