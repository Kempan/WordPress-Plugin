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