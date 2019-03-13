<?php

namespace Inc\Base;

class Activate{

  // Activates plugin and flush
  public static function activate(){
    flush_rewrite_rules();
  }
}