<?php

namespace Inc;

final class Init{

  // Returns all classes stored in array
  public static function get_services(){
    return [
      Pages\Admin::class,
      Base\Enqueue::class,
      Base\SettingsLinks::class
    ];
  }

  // Loop through the classes, initialize them and call the register() method if it exists
  public static function register_services(){
    foreach(self::get_services() as $class){
      $service = self::instantiate($class);
      if(method_exists($service, 'register')){
        $service->register();
      }
    }
  }

  // Initialize the class from the $service array
  private static function instantiate($class){
    return new $class();
  }
}

// class DemoPlugin{

//   public $pluginName;

//   function __construct(){
//     // Activates custom post type from custom_post_type()
//     $this->activate_post_type();
//     $this->pluginName = plugin_basename(__FILE__);
//   }

//   // This is getting called after the class instance
//   function register(){
//     // Adding all styles and scripts via enqueue function
//     add_action('wp_enqueue_scripts', array($this, 'enqueue'));
//     // Adding the plugin admin page in menu
//     add_action('admin_menu', array($this, 'add_admin_pages'));
//     // Adding a settings link to your plugin form, created in settings_link()
//     add_filter("plugin_action_links_$this->pluginName", array($this, 'settings_link'));
//   }

//   // Creating settings link for your plugin form
//   function settings_link($links){
//     $settings_link = '<a href="admin.php?page=demo_plugin">Settings</a>';
//     array_push($links, $settings_link);
//     return $links;
//   }

//   // Creating the admin page
//   function add_admin_pages(){
//     add_menu_page('Demo-plugin', 'DemoPlugin', 'manage_options', 'demo_plugin', array($this, 'admin_index'), 'dashicons-admin-generic', 110);
//   }

//   // Require the admin page template
//   function admin_index(){
//     require_once plugin_dir_path(__FILE__) . 'templates/admin-index.php';
//   }

//   // Creating custom post type 'Book'
//   function custom_post_type(){
//     register_post_type('book', ['public' => true, 'label' => 'Books', 'menu_icon' => 'dashicons-book']);
//   }

//   // Activate your custom post type
//   protected function activate_post_type(){
//     add_action('init', array($this, 'custom_post_type'));
//   }

//   // Enqueue your styles and scripts
//   function enqueue(){
//     wp_enqueue_style('plugin-style', plugins_url('/assets/style.css', __FILE__));
//     wp_enqueue_script('plugin-script', plugins_url('/assets/script.js', __FILE__));
//   }

//   // Activate plugin via inc/Activate.php
//   function activate(){
//     Activate::activate();
//   }
//   // Deactivate plugin via inc/Deactivate.php
//   function deactivate(){
//     Deactivate::deactivate();
//   }
// }

// // Checking if class exists and creating a new instance if it does
// if(class_exists('DemoPlugin')){
//   $demoPlugin = new DemoPlugin();
//   $demoPlugin->register();
// }

// // Register activation
// register_activation_hook(__FILE__, array($demoPlugin, 'activate'));

// // Register deactivation
// register_deactivation_hook(__FILE__, array($demoPlugin, 'deactivate'));