<?php

namespace Inc\Base;

use \Inc\Base\BaseController;

class SettingsLinks extends BaseController{

  // Activates settings link from settings_link()
  public function register(){
    add_filter('plugin_action_links_' . $this->plugin_basename, array($this, 'settings_link'));
  }

  // Creating settings link for plugin form
  public function settings_link($links){
    $settings_link = '<a href="admin.php?page=predator_plugin">Settings</a>';
    array_push($links, $settings_link);
    return $links;
  }
}