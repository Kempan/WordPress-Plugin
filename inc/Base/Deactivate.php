<?php

namespace Inc\Base;

class Deactivate{

  // Deactivates plugin and flush
  public static function deactivate(){
    flush_rewrite_rules();
  }
}