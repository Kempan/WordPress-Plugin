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
      <h3>Export</h3>
    </div>

  </div>
</div>