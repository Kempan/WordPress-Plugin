<?php

namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;

class ManagerCallbacks extends BaseController{

  public function checkboxSanitize($input){

    $output = [];
    //looping thru DB to check if checkboxes are checked
    foreach($this->managers as $key => $value){
      $output[$key] = (isset($input[$key]) && $input[$key] == 1) ? true : false; 
    }
    return $output;

  }

  public function adminSection(){
    echo 'Activate / Deactivate The Features of This Predator-Plugin';
  }

  public function checkboxField($args){
    
    $class = $args['class'];
    $name = $args['label_for'];
    $option_name = $args['option_name'];
    $checkbox = get_option($option_name);
    // have to double check because first time it will be set but value is null
    $checked = isset($checkbox[$name]) ? ($checkbox[$name] ? true : false) : false;

    echo '<div class="'.$class.'"><input type="checkbox" id="'.$name.'" name="'.$option_name.'['.$name.']" class="'.$class.'" 
    value="1" class="" '.($checked ? 'checked' : '').'><label for="'.$name.'"><div></div></label></div>';
  }
 
}