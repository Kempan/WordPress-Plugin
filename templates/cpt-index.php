<div class="wrap">
  <h1>CPT Manager</h1>
  <?php settings_errors(); ?>

  <ul class="nav nav-tabs">
    <li class="<?php echo isset($_POST['edit_post']) ? '' : 'active' ?>">
      <a href="#tab-1">Your Custom Post Types</a>
    </li>

    <li class="<?php echo isset($_POST['edit_post']) ? 'active' : '' ?>">
      <a href="#tab-2"><?php echo isset($_POST['edit_post']) ? 'Edit' : 'Create' ?> Custom Post Type</a>
    </li>
    
    <li><a href="#tab-3">Export</a></li>
  </ul>

  <div class="tab-content">
    <div id="tab-1" class="tab-pane <?php echo isset($_POST['edit_post']) ? '' : 'active' ?>">

      <h3>Manage Your Custom Post Types</h3>

      <?php
      
        echo '<table class="cpt-table"><tr><th>Custom Post ID</th><th>Singular Name</th><th>Plural Name</th>
        <th>Public?</th><th>Has Archive?</th><th class="text-center">Actions</th></tr>';

        $values = get_option('predator_plugin_cpt') ?: array();

        foreach($values as $value){
          $public = isset($value['public']) ? 'YES' : 'NO';
          $archive = isset($value['has_archive']) ? 'YES' : 'NO';

          echo "<tr><td>{$value["post_type"]}</td><td>{$value["singular_name"]}</td><td>{$value["plural_name"]}</td>
          <td>{$public}</td><td>{$archive}</td><td class=\"text-center\">";

          echo '<form method="POST" action="" class="inline-block">';

          echo '<input type="hidden" name="edit_post" value="'.$value['post_type'].'">';

          submit_button('Edit', 'primary small', 'submit', false);

          echo '</form> ';

          echo '<form method="POST" action="options.php" class="inline-block">';

          settings_fields('predator_plugin_cpt_settings');

          echo '<input type="hidden" name="remove" value="'.$value['post_type'].'">';

          submit_button('Delete', 'delete small', 'submit', false, array(
            'onclick' => 'return confirm("Are you sure you want to delete this Custom Post Type?");'
          ));

          echo '</form></td></tr>';

        }

        echo '</table>';
      ?>

    </div>

    <div id="tab-2" class="tab-pane <?php echo isset($_POST['edit_post']) ? 'active' : '' ?>">
      <form method="POST" action="options.php">
        <?php
          settings_fields('predator_plugin_cpt_settings');
          do_settings_sections('predator_cpt');
          submit_button();
        ?>
      </form>
    </div>

    <div id="tab-3" class="tab-pane">
      
      <?php
      foreach($values as $value ){ ?>

        <h3>Custom Post Type: <?php echo $value['singular_name']; ?></h3>
        <pre class="prettyprint">
          // Register Custom Post Type
          function custom_post_type() {

            $args = array(
              'post_type'             => '<?php echo $value['post_type'] ?>',
              'name'                  => '<?php echo $value['plural_name'] ?>',
              'singular_name'         => '<?php echo $value['singular_name'] ?>',
              'menu_name'             => '<?php echo $value['plural_name'] ?>',
              'name_admin_bar'        => '<?php echo $value['singular_name'] ?>',
              'archives'              => '<?php echo $value['singular_name'] ?> Archives',
              'attributes'            => '<?php echo $value['singular_name'] ?> Attributes',
              'parent_item_colon'     => 'Parent <?php echo $value['singular_name'] ?>',
              'all_items'             => 'All <?php echo $value['singular_name'] ?>',
              'add_new_item'          => 'Add New <?php echo $value['singular_name'] ?>',
              'add_new'               => 'Add New',
              'new_item'              => 'New <?php echo $value['singular_name'] ?>',
              'edit_item'             => 'Edit <?php echo $value['singular_name'] ?>',
              'update_item'           => 'Update <?php echo $value['singular_name'] ?>',
              'view_item'             => 'View <?php echo $value['singular_name'] ?>',
              'view_items'            => 'View <?php echo $value['plural_name'] ?>',
              'search_items'          => 'Search <?php echo $value['plural_name'] ?>',
              'not_found'             => 'No <?php echo $value['singular_name'] ?> Found',
              'not_found_in_trash'    => 'No <?php echo $value['singular_name'] ?> Found in Trash',
              'featured_image'        => 'Featured Image',
              'set_featured_image'    => 'Set Featured Image',
              'remove_featured_image' => 'Remove Featured Image',
              'use_featured_image'    => 'Use Featured Image',
              'insert_into_item'      => 'Insert into <?php echo $value['singular_name'] ?>',
              'uploaded_to_this_item' => 'Upload to this <?php echo $value['singular_name'] ?>',
              'items_list'            => <?php echo $value['plural_name'] ?> List',
              'items_list_navigation' => <?php echo $value['plural_name'] ?> List Navigation',
              'filter_items_list'     => 'Filter <?php echo $value['plural_name'] ?> List',
              'label'                 => <?php echo $value['singular_name'] ?>',
              'description'           => <?php echo $value['plural_name'] ?> Custom Post Types',
              'supports'              => false,
              'taxonomies'            => array('category', 'post_tag'),
              'hierarchical'          => false,
              'public'                => <?php echo isset($value['public']) ? 'true' : 'false' ?>,
              'show_ui'               => true,
              'show_in_menu'          => true,
              'show_in_admin_bar'     => true,
              'show_in_nav_menus'     => true,
              'can_export'            => true,
              'has_archive'           => <?php echo isset($value['has_archive']) ? 'true' : 'false' ?>,
              'exclude_from_search'   => false,
              'publicly_queryable'    => true,
              'capability_type'       => 'post'
            );
            
            register_post_type( '<?php echo $value['post_type']; ?>' );

          }
          add_action( 'init', 'custom_post_type', 0 );
        </pre>
        <?php
      } 
      ?>
    </div>
  </div>
</div>