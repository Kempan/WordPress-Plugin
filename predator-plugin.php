<?php

/*
Plugin Name: PredatorPlugin
Description: Awesome plugin for predators.
Version: 1.0.0
Author: PredatorJocke
*/

// Intruders must die!
if(!defined('ABSPATH')){
  die;
}

// Activating autoload with composer
if(file_exists(dirname(__FILE__) . '/vendor/autoload.php')){
  require_once dirname(__FILE__) . '/vendor/autoload.php';
}

// Defines global variables for scripts, templates and filters
// Templates path
define('PLUGIN_PATH', plugin_dir_path(__FILE__));
// Scripts url
define('PLUGIN_URL', plugin_dir_url(__FILE__));
// Filter plugin name
define('PLUGIN', plugin_basename(__FILE__));

// Activate touch
function activate_predator_plugin(){
  Inc\Base\Activate::activate();
}
register_activation_hook(__FILE__, 'activate_predator_plugin');

// Deactivate touch
function deactivate_predator_plugin(){
  Inc\Base\Deactivate::deactivate();
}
register_deactivation_hook(__FILE__, 'deactivate_predator_plugin');

// Check for Init class and initialize it's register_services() if found
if(class_exists('Inc\\Init')){
  Inc\Init::register_services();
}