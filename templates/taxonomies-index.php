<div class="wrap">
  <h1>Taxonomy Manager</h1>
  <?php settings_errors(); ?>

  <ul class="nav nav-tabs">
    <li class="<?php echo isset($_POST['edit_taxonomy']) ? '' : 'active' ?>">
      <a href="#tab-1">Your Custom Taxonomies</a>
    </li>

    <li class="<?php echo isset($_POST['edit_taxonomy']) ? 'active' : '' ?>">
      <a href="#tab-2"><?php echo isset($_POST['edit_taxonomy']) ? 'Edit' : 'Create' ?> Custom Taxonomy</a>
    </li>
    
    <li><a href="#tab-3">Export</a></li>
  </ul>

  <div class="tab-content">
    <div id="tab-1" class="tab-pane <?php echo isset($_POST['edit_taxonomy']) ? '' : 'active' ?>">

      <h3>Manage Your Custom Taxonomy</h3>

      <?php
      
        echo '<table class="cpt-table"><tr><th>Taxonomy ID</th><th>Singular Name</th>
        <th>Hierarchical</th><th class="text-center">Actions</th></tr>';

        $values = get_option('predator_plugin_tax') ?: array();

        foreach($values as $value){

          $hierarchical = isset($value["hierarchical"]) ? 'YES' : 'NO';

          echo "<tr><td>{$value["taxonomy"]}</td><td>{$value["singular_name"]}</td>
          <td>{$hierarchical}</td><td class=\"text-center\">";

          echo '<form method="POST" action="" class="inline-block">';

          echo '<input type="hidden" name="edit_taxonomy" value="'.$value['taxonomy'].'">';

          submit_button('Edit', 'primary small', 'submit', false);

          echo '</form> ';

          echo '<form method="POST" action="options.php" class="inline-block">';

          settings_fields('predator_plugin_tax_settings');

          echo '<input type="hidden" name="remove" value="'.$value['taxonomy'].'">';

          submit_button('Delete', 'delete small', 'submit', false, array(
            'onclick' => 'return confirm("Are you sure you want to delete this Taxonomy?");'
          ));

          echo '</form></td></tr>';

        }

        echo '</table>';
      ?>

    </div>

    <div id="tab-2" class="tab-pane <?php echo isset($_POST['edit_taxonomy']) ? 'active' : '' ?>">
      <form method="POST" action="options.php">
        <?php
          settings_fields('predator_plugin_tax_settings');
          do_settings_sections('predator_taxonomy');
          submit_button();
        ?>
      </form>
    </div>

    <div id="tab-3" class="tab-pane">

      <h3>Export Your Custom Taxonomies</h3>
      
    </div>
  </div>
</div>