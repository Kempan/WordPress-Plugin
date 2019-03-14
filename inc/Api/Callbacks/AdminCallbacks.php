<?php

namespace Inc\Api\Callbacks;

use \Inc\Base\BaseController;

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
  public function widgetsDashboard(){
    return require_once("$this->plugin_path/templates/widgets-index.php");
  }
}