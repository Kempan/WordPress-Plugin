<?php

namespace Inc\Base;

use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\Callbacks\TaxonomyCallbacks;

class TaxonomyController extends BaseController{

  public $settings;
  public $callbacks;
  public $tax_callbacks;
  public $subpages = [];
  public $taxonomies = [];
  
  public function register(){

    $option = get_option('predator_plugin');
    $activated = isset($option['taxonomy_manager']) ?: false;
    
    if( ! $activated){
      return;
    }

    $this->settings = new SettingsApi;
    $this->callbacks = new AdminCallbacks;
    $this->tax_callbacks = new TaxonomyCallbacks;

    $this->setSubPages();

    $this->setSettings();

    $this->setSections();

    $this->setFields();

    $this->settings->addSubPages($this->subpages)->register();

    $this->storeCustomTaxonomies();

    if( ! empty($this->taxonomies)){
      add_action('init', array($this, 'registerTaxonomies'));
    }

  }

  public function setSubPages(){

    // Create your admin sub pages here
    $this->subpages = [
      [
        'parent_slug' => 'predator_plugin',
        'page_title' => 'Custom Taxonomies',
        'menu_title' => 'Taxonomy Manager',
        'capability' => 'manage_options',
        'menu_slug' => 'predator_taxonomy',
        'callback' => array($this->callbacks, 'taxonomiesDashboard'),
      ],
    ];
  }

  public function setSettings(){
    $args = [
      [
        'option_group' => 'predator_plugin_tax_settings',
        'option_name' => 'predator_plugin_tax',
        'callback' => array($this->tax_callbacks, 'taxSanitize')
      ]
    ];

    $this->settings->setSettings($args);
  }

  public function setSections(){
    $args = [
      [
        'id' => 'predator_tax_index',
        'title' => 'Taxonomy Manager',
        'callback' => array($this->tax_callbacks, 'taxSection'),
        'page' => 'predator_taxonomy'
      ]
    ];

    $this->settings->setSections($args);
  }

  public function setFields(){
    $args = [
      [
        'id' => 'taxonomy',
        'title' => 'Custom Taxonomy ID',
        'callback' => array($this->tax_callbacks, 'textField'),
        'page' => 'predator_taxonomy',
        'section' => 'predator_tax_index',
        'args' => [
          'array' => 'taxonomy',
          'label_for' => 'taxonomy',
          'placeholder' => 'eg. genre',
          'option_name' => 'predator_plugin_tax',
        ]
      ],
      [
        'id' => 'singular_name',
        'title' => 'Singular Name',
        'callback' => array($this->tax_callbacks, 'textField'),
        'page' => 'predator_taxonomy',
        'section' => 'predator_tax_index',
        'args' => [
          'array' => 'taxonomy',
          'placeholder' => 'eg. genre',
          'label_for' => 'singular_name',
          'option_name' => 'predator_plugin_tax',
        ]
      ],
      [
        'id' => 'hierarchical',
        'title' => 'hierarchical',
        'callback' => array($this->tax_callbacks, 'checkboxField'),
        'page' => 'predator_taxonomy',
        'section' => 'predator_tax_index',
        'args' => [
          'class' => 'ui-toggle',
          'array' => 'post_type',
          'label_for' => 'hierarchical',
          'option_name' => 'predator_plugin_tax',
        ]
      ],
    ];

    $this->settings->setFields($args);
  }

  public function storeCustomTaxonomies(){

    $values = get_option('predator_plugin_tax');

    foreach($values as $value ){

      $labels = array(
        'name'              => _x( $value['singular_name'], 'taxonomy general name' ),
        'singular_name'     => _x( $value['singular_name'], 'taxonomy singular name' ),
        'search_items'      => __( 'Search ' . $value['singular_name'] ),
        'all_items'         => __( 'All ' . $value['singular_name'] ),
        'parent_item'       => __( 'Parent ' . $value['singular_name'] ),
        'parent_item_colon' => __( 'Parent: ' . $value['singular_name'] ),
        'edit_item'         => __( 'Edit ' . $value['singular_name'] ),
        'update_item'       => __( 'Update ' . $value['singular_name'] ),
        'add_new_item'      => __( 'Add New ' . $value['singular_name'] ),
        'new_item_name'     => __( 'New ' . $value['singular_name'] . ' Name' ),
        'menu_name'         => __( $value['singular_name'] ),
      );

      $this->taxonomies[] = [
        'hierarchical'      => isset($value['hierarchical']) ?: false,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => $value['taxonomy'] ),
      ];

    }
  }
  
  public function registerTaxonomies(){
    foreach($this->taxonomies as $taxonomy){
      register_taxonomy($taxonomy['rewrite']['slug'], array('post'), $taxonomy);
    }
  }
}