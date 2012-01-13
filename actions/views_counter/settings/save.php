<?php

  $params = get_input('params');
  $plugin_id = get_input('plugin_id');
  $plugin = elgg_get_plugin_from_id($plugin_id);
  
  // Get the removed types saved in database
  $removed_types = unserialize($plugin->remove_views_counter);
  $removed_types = ($removed_types) ? ($removed_types) : array();
  // Get the previous added types
  $previous_types = unserialize($plugin->add_views_counter);
  // Checking which types were removed for the admin right now and include them
  // in the remove_views_counter array
  foreach($previous_types as $previous_type) {
    // If the type was removed right now and It was not already added as a
    // removed type then let's add It now
    if (!in_array($previous_type, $params['add_views_counter']) and
        !in_array($previous_type,$removed_types))
    {
      $removed_types[] = $previous_type;
    }
  }
  // Save It on the plugin settings
  $params['remove_views_counter'] = $removed_types;

  foreach ($params as $k => $v) {
    if($k == 'add_views_counter' || $k == 'remove_views_counter') {
      $v = serialize($v);
    }

    $result = $plugin->setSetting($k, $v);

    if (!$result) {
      register_error(elgg_echo('plugins:settings:save:fail', array($plugin_name)));
      forward(REFERER);
      exit;
    }
  }

?>
