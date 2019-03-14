<?php

namespace Inc\Api\Callbacks;

use \Inc\Base\BaseController;

class ManagerCallbacks extends BaseController{

  public function checkboxSanitize($input){

    // return filter_var($input, FILTER_SANITIZE_NUMBER_INT);
    return(isset($input) ? true : false);
  }

  public function adminSectionManager(){
    echo 'Activate the Sections and Features of this Predator-Plugin!';
  }

  public function checkboxField($args){
    $name = $args['label_for'];
    $class = $args['class'];
    $checkbox = get_option($name);
    echo '<div class="'.$class.'"><input type="checkbox" id="'.$name.'" name="'.$name.'" class="'.$class.'" 
    value="1" class="" '.($checkbox ? 'checked' : '').'><label for="'.$name.'"><div></div></label></div>';
  }
 
}