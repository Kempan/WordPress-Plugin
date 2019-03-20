<?php

namespace Inc\Base;

use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\CptCallbacks;
use Inc\Api\Callbacks\AdminCallbacks;

class CustomPostTypeController extends BaseController{

  public $settings;
  public $callbacks;
  public $cpt_callbacks;

  public $subpages = [];
  public $cpt = [];
  
  public function register(){

    $option = get_option('predator_plugin');
    $activated = isset($option['cpt_manager']) ? $option['cpt_manager'] : false;
    
    if( ! $activated){
      return;
    }

    $this->settings = new SettingsApi;
    $this->callbacks = new AdminCallbacks;
    $this->cpt_callbacks = new CptCallbacks;

    $this->setSubPages();

    $this->setSettings();
    $this->setSections();
    $this->setFields();

    $this->settings->addSubPages($this->subpages)->register();

    $this->storeCustomPostTypes();

    if( ! empty($this->cpt)){
      add_action('init', array($this, 'registerCpt'));
    }
  }

  // Create your sub pages here
  public function setSubPages(){

    $this->subpages = [
      [
        'parent_slug' => 'predator_plugin',
        'page_title' => 'Custom Post Types',
        'menu_title' => 'CPT Manager',
        'capability' => 'manage_options',
        'menu_slug' => 'predator_cpt',
        'callback' => array($this->callbacks, 'cptDashboard'),
      ],
    ];
  }

  // ---------- CUSTOM CPT FIELDS ----------

  // SETTINGS
  public function setSettings(){
    $args = [
      [
        'option_group' => 'predator_plugin_cpt_settings',
        'option_name' => 'predator_plugin_cpt',
        'callback' => array($this->cpt_callbacks, 'cptSanitize'),
      ]
    ];

    $this->settings->setSettings($args);
  }

  // SECTIONS
  public function setSections(){
    $args = [
      [
        'id' => 'predator_cpt_index',
        'title' => 'CPT Manager',
        'callback' => array($this->cpt_callbacks, 'cptSection'),
        'page' => 'predator_cpt'
      ],
    ];

    $this->settings->setSections($args);
  }

  // FIELDS
  public function setFields(){
    $args = [
      [
        'id' => 'post_type',
        'title' => 'Custom Post Type ID',
        'callback' => array($this->cpt_callbacks, 'textField'),
        'page' => 'predator_cpt',
        'section' => 'predator_cpt_index',
        'args' => [
          'label_for' => 'post_type',
          'placeholder' => 'Ex. Predator Products',
          'option_name' => 'predator_plugin_cpt',
        ]
      ],
      [
        'id' => 'singular_name',
        'title' => 'Singular Name',
        'callback' => array($this->cpt_callbacks, 'textField'),
        'page' => 'predator_cpt',
        'section' => 'predator_cpt_index',
        'args' => [
          'label_for' => 'singular_name',
          'option_name' => 'predator_plugin_cpt',
          'placeholder' => 'Ex. Product',
        ]
      ],
      [
        'id' => 'plural_name',
        'title' => 'Plural Name',
        'callback' => array($this->cpt_callbacks, 'textField'),
        'page' => 'predator_cpt',
        'section' => 'predator_cpt_index',
        'args' => [
          'label_for' => 'plural_name',
          'option_name' => 'predator_plugin_cpt',
          'placeholder' => 'Ex. Products',
        ]
      ],
      [
        'id' => 'public',
        'title' => 'Public',
        'callback' => array($this->cpt_callbacks, 'checkboxField'),
        'page' => 'predator_cpt',
        'section' => 'predator_cpt_index',
        'args' => [
          'class' => 'ui-toggle',
          'label_for' => 'public',
          'option_name' => 'predator_plugin_cpt',
        ]
      ],
      [
        'id' => 'has_archive',
        'title' => 'Archive',
        'callback' => array($this->cpt_callbacks, 'checkboxField'),
        'page' => 'predator_cpt',
        'section' => 'predator_cpt_index',
        'args' => [
          'class' => 'ui-toggle',
          'label_for' => 'has_archive',
          'option_name' => 'predator_plugin_cpt',
        ]
      ],
    ];

    $this->settings->setFields($args);
  }

  public function storeCustomPostTypes(){

    $values = get_option('predator_plugin_cpt') ?: array();

    foreach($values as $value ){
      $this->cpt[] = [
        'post_type'             => $value['post_type'],
        'name'                  => $value['plural_name'],
        'singular_name'         => $value['singular_name'],
        'menu_name'             => $value['plural_name'],
        'name_admin_bar'        => $value['singular_name'],
        'archives'              => $value['singular_name'] . 'Archives',
        'attributes'            => $value['singular_name'] . 'Attributes',
        'parent_item_colon'     => 'Parent' . $value['singular_name'],
        'all_items'             => 'All ' . $value['singular_name'],
        'add_new_item'          => 'Add New ' . $value['singular_name'],
        'add_new'               => 'Add New',
        'new_item'              => 'New ' . $value['singular_name'],
        'edit_item'             => 'Edit ' . $value['singular_name'],
        'update_item'           => 'Update ' . $value['singular_name'],
        'view_item'             => 'View ' . $value['singular_name'],
        'view_items'            => 'View ' . $value['plural_name'],
        'search_items'          => 'Search ' . $value['plural_name'],
        'not_found'             => 'No ' . $value['singular_name'] . ' Found',
        'not_found_in_trash'    => 'No ' . $value['singular_name'] . ' Found in Trash',
        'featured_image'        => 'Featured Image',
        'set_featured_image'    => 'Set Featured Image',
        'remove_featured_image' => 'Remove Featured Image',
        'use_featured_image'    => 'Use Featured Image',
        'insert_into_item'      => 'Insert into ' . $value['singular_name'],
        'uploaded_to_this_item' => 'Upload to this ' . $value['singular_name'],
        'items_list'            => $value['plural_name'] . ' List',
        'items_list_navigation' => $value['plural_name'] . ' List Navigation',
        'filter_items_list'     => 'Filter ' . $value['plural_name'] . ' List',
        'label'                 => $value['singular_name'],
        'description'           => $value['plural_name'] . ' Custom Post Types',
        'supports'              => false,
        'taxonomies'            => array('category', 'post_tag'),
        'hierarchical'          => false,
        'public'                => isset($value['public']) ?: false,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => isset($value['has_archive']) ?: false,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post'
      ];
    }
  }

  public function registerCpt(){

    foreach($this->cpt as $post_type){
      register_post_type($post_type['post_type'], [
        'labels' => array(
          'name'                  => $post_type['name'],
          'singular_name'         => $post_type['singular_name'],
          'menu_name'             => $post_type['menu_name'],
          'name_admin_bar'        => $post_type['name_admin_bar'],
          'archives'              => $post_type['archives'],
          'attributes'            => $post_type['attributes'],
          'parent_item_colon'     => $post_type['parent_item_colon'],
          'all_items'             => $post_type['all_items'],
          'add_new_item'          => $post_type['add_new_item'],
          'add_new'               => $post_type['add_new'],
          'new_item'              => $post_type['new_item'],
          'edit_item'             => $post_type['edit_item'],
          'update_item'           => $post_type['update_item'],
          'view_item'             => $post_type['view_item'],
          'view_items'            => $post_type['view_items'],
          'search_items'          => $post_type['search_items'],
          'not_found'             => $post_type['not_found'],
          'not_found_in_trash'    => $post_type['not_found_in_trash'],
          'featured_image'        => $post_type['featured_image'],
          'set_featured_image'    => $post_type['set_featured_image'],
          'remove_featured_image' => $post_type['remove_featured_image'],
          'use_featured_image'    => $post_type['use_featured_image'],
          'insert_into_item'      => $post_type['insert_into_item'],
          'uploaded_to_this_item' => $post_type['uploaded_to_this_item'],
          'items_list'            => $post_type['items_list'],
          'items_list_navigation' => $post_type['items_list_navigation'],
          'filter_items_list'     => $post_type['filter_items_list']
        ),
        'label'                     => $post_type['label'],
        'description'               => $post_type['description'],
        'supports'                  => $post_type['supports'],
        'taxonomies'                => $post_type['taxonomies'],
        'hierarchical'              => $post_type['hierarchical'],
        'public'                    => $post_type['public'],
        'show_ui'                   => $post_type['show_ui'],
        'show_in_menu'              => $post_type['show_in_menu'],
        'show_in_admin_bar'         => $post_type['show_in_admin_bar'],
        'show_in_nav_menus'         => $post_type['show_in_nav_menus'],
        'can_export'                => $post_type['can_export'],
        'has_archive'               => $post_type['has_archive'],
        'exclude_from_search'       => $post_type['exclude_from_search'],
        'publicly_queryable'        => $post_type['publicly_queryable'],
        'capability_type'           => $post_type['capability_type'],
      ]);
    }
    
  }
}