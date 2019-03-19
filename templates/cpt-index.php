<div class="wrap">
  <h1>CPT Manager</h1>
  <?php settings_errors(); ?>

  <ul class="nav nav-tabs">
    <li class="active"><a href="#tab-1">Your Custom Post Types</a></li>
    <li><a href="#tab-2">Create Custom Post Type</a></li>
    <li><a href="#tab-3">Export</a></li>
  </ul>

  <div class="tab-content">
    <div id="tab-1" class="tab-pane active">
      <h3>Manage Your Custom Post Types</h3>
      <?php
        echo '<table class="cpt-table"><tr><th>Custom Post ID</th><th>Singular Name</th><th>Plural Name</th><th>Public?</th><th>Has Archive?</th></tr>';
        $values = get_option('predator_plugin_cpt');
        foreach($values as $value){
          echo "<tr><td>{$value["post_type"]}</td><td>{$value["singular_name"]}</td><td>{$value["plural_name"]}</td><td>{$value["public"]}</td><td>{$value["has_archive"]}</td></tr>";
        }
        echo '</table>';
      ?>
    </div>
    <div id="tab-2" class="tab-pane">
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