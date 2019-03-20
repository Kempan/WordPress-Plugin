<?php

namespace Inc\Api\Callbacks;

class CptCallbacks{

  public function cptSection(){
    echo 'Create your own custom post types!';
  }

  // sanitize your input if needed
  public function cptSanitize($input){

    // var_dump($_POST['remove']);
    // die();
    
    $output = get_option('predator_plugin_cpt');
    
    // delete your custom post type
    if(isset($_POST['remove'])){
      unset($output[$_POST['remove']]);
      return $output;
    }

    // if predator_plugin_cpt is empty, like when you activate the plugin
    // for the first time, just fill the output with the input
    if(count($output) == 0){
      $output[$input['post_type']] = $input;
      return $output;
    }
    
    //check to make sure we dont add the same post type
    foreach($output as $key => $value){
      if($input['post_type'] === $key){
        $output[$key] = $input;
      } else {
        $output[$input['post_type']] = $input;
      }
    }

    return $output;
  }

  public function textField($args){

    $name = $args['label_for'];
    $option_name = $args['option_name'];
    $value = '';

    if(isset($_POST['edit_post'])){
      $input = get_option($option_name);
      $value = $input[$_POST['edit_post']][$name];
    }

    echo '<input type="text" class="regular-text" id="'.$name.'" name="'.$option_name.'['.$name.']" value="'.$value.'" placeholder="'.$args['placeholder'].'" required>';
  }

  public function checkboxField($args){
    
    $class = $args['class'];
    $name = $args['label_for'];
    $option_name = $args['option_name'];
    $checked = false;

    if(isset($_POST['edit_post'])){
      $checkbox = get_option($option_name);
      $checked = isset($checkbox[$_POST['edit_post']][$name]) ?: false;
    }
    
    echo '<div class="'.$class.'"><input type="checkbox" class="'.$class.'" id="'.$name.'" name="'.$option_name.'['.$name.']" 
    value="1" class="" '.($checked ? 'checked' : '').'><label for="'.$name.'"><div></div></label></div>';
  }
 
}