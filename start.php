<?php
	/**
	 * @file start.php
	 * @brief Set the views_counter plugin on elgg system
	 */

	/**
	 * Set the views_counter basic configuration on elgg system
	 */
	function views_counter_init() {
		$CONFIG;

		// Try to add a views counter for the entities selected through the plugin settings
		set_views_counter();
		
		register_translations($CONFIG->pluginspath.'views_counter/languages',true);
		elgg_register_page_handler('views_counter','views_counter_page_handler');
		elgg_extend_view('css','views_counter/css');
	}
	
	include('lib/views_counter.php');
	
	/**
	 * Set some views_counter links on elgg system
	 */
	function views_counter_pagesetup() {
		if (isadminloggedin() && (get_context()=='admin') || (get_context()=='views_counter')) {
			global $CONFIG;
			
			add_submenu_item(elgg_echo('views_counter:admin_page'),$CONFIG->wwwroot.'views_counter/list_entities/user','views_counter');
			add_submenu_item(elgg_echo('views_counter:demo'),$CONFIG->wwwroot.'views_counter/demo','views_counter');
			add_submenu_item(elgg_echo('views_counter:doc'),$CONFIG->wwwroot.'mod/views_counter/doc/index.html','views_counter');
		}
	}
	
	/**
	 * To control the views_counter pages exhibition
	 * 
	 * @param $page
	 */
	function views_counter_page_handler($page) {
	  $pages = dirname(__FILE__) . '/pages/views_counter';
		if (isset($page[0])) {
			global $CONFIG;
			
			switch($page[0]) {
				case 'list_entities':
					admin_gatekeeper();
					set_input('entity_type',$page[1]);
				  include "$pages/list_entities.php";
					break;
				case 'demo':
				  include "$pages/demo.php";
					break;
				case 'doc':
				  include "$pages/doc.php";
					break;
				case 'views_statistics':
				  admin_gatekeeper();
					set_input('entity_guid',$page[1]);
				  include "$pages/views_statistics.php";
					break;
			}
		}
	}

	/**
	 * To manage the settings inputs are more than one value for input (checkboxes)
	 * 
	 * @param $hook
	 * @param $type
	 * @param $returnvalue
	 * @param $params
	 */
	function views_counter_settings_handler($hook,$type,$returnvalue,$params) {
		if ($params['plugin'] == 'views_counter') {
			if (is_array($params['value'])) {
				if ($params['name'] == 'add_views_counter') {
					// Get the removed types saved in database
					$removed_types = unserialize(get_plugin_setting('remove_views_counter','views_counter'));
					$removed_types = ($removed_types) ? ($removed_types) : array();
					// Get the previous added types
					$previous_types = unserialize(get_plugin_setting('add_views_counter','views_counter'));
					// Checking which types were removed for the admin right now and include them in the remove_views_counter array
					foreach($previous_types as $previous_type) {
						// If the type was removed right now and It was not already added as a removed type then let's add It now
						if ((!in_array($previous_type,$params['value'])) && (!in_array($previous_type,$removed_types))) {
							$removed_types[] = $previous_type;
						}
					}
					// Save It on the plugin settings
					set_plugin_setting('remove_views_counter',serialize($removed_types),'views_counter');
					
					// Save the add_views_counter settings as a serialized value
					return serialize($params['value']);
				}
			}
		}
	}
	
	/**
	 * To indicate that a view couting system exists
	 * 
	 * @param $hook
	 * @param $type
	 * @param $returnvalue
	 * @param $params
	 */
	function views_counter_register($hook,$type,$returnvalue,$params) {
		return 'views_counter';
	}
	
	/**
	 * To register a function that get the hooks from another plugins for list entities by number of views
	 * 
	 * @param $hook
	 * @param $type
	 * @param $returnvalue
	 * @param $params
	 */
	function list_entities_by_views_counter_hook($hook,$type,$returnvalue,$params) {
		$options = $params;
		return list_entities_by_views_counter($options);
	}
	
	/**
	 * To register a function that get the hooks from another plugins for get entities by number of views
	 * 
	 * @param $hook
	 * @param $type
	 * @param $returnvalue
	 * @param $params
	 */
	function get_entities_by_views_counter_hook($hook,$type,$returnvalue,$params) {
		$options = $params;

		return get_entities_by_views_counter($options);
	}
	
	/**
	 * A hook that may be used by other plugins that want to get the number of views for an entity
	 * 
	 * @param $hook
	 * @param $type
	 * @param $returnvalue
	 * @param $params
	 */
	function get_views_counter_hook($hook,$type,$returnvalue,$params) {
		if ($params['entity']) {
			// We get the entity as a hook params instead of the entity_guid just for follow the elgg pattern of pass the entity instead of the entity_guid
			return get_views_counter($params['entity']->guid,$params['owner_guid']);
		}
	}

	/**
	 * Hook that allow other plugins to get the last view time for an entity
	 * 
	 * @param $hook
	 * @param $type
	 * @param $returnvalue
	 * @param $params
	 */
	function get_last_view_time_hook($hook,$type,$returnvalue,$params) {
		if($params['entity']) {
			// We get the entity as a hook params instead of the entity_guid just for follow the elgg pattern of pass the entity instead of the entity_guid
			$user_guid = (isset($params['user_guid'])) ? ($params['user_guid']) : 0;
			return get_last_view_time($params['entity']->guid,$user_guid);
		}
	}
	
	/**
	 * Hook that allow other plugins to update the last view time for an entity
	 * 
	 * @param $hook
	 * @param $type
	 * @param $returnvalue
	 * @param $params
	 */
	function update_last_view_time_hook($hook,$type,$returnvalue,$params) {
		if($params['entity']) {
			$user_guid = ($params['user']) ? ($params['user']->guid) : 0;
			return update_last_view_time($params['entity']->guid,$user_guid);
		}
	}
	
	/**
	 * Hook that allow other plugins to check if a user had seen the last update of an entity
	 * 
	 * @param $hook
	 * @param $type
	 * @param $returnvalue
	 * @param $params
	 */
	function did_see_last_update_hook($hook,$type,$returnvalue,$params) {
		if($params['entity']) {
			$user_guid = ($params['user']) ? ($params['user']->guid) : 0;
			return did_see_last_update($params['entity']->guid,$user_guid);
		}
	}
	
	register_elgg_event_handler('init','system','views_counter_init');
	register_elgg_event_handler('pagesetup','system','views_counter_pagesetup');
	
	// To manage the settings inputs are more than one value for input (checkboxes)
	register_plugin_hook('plugin:setting','plugin','views_counter_settings_handler');
	// Get the hook 'view_counting_system' from other plugins that may be asking if some view counting system exists
	register_plugin_hook('views_counting_system','plugin','views_counter_register');
	// A hook that may be used by other plugins that want to list the entities by number of views but without get dependent of any specific plugin
	// Obs.: Maybe the job of trigger a hook is on account of elgg_list_entities() function  
	register_plugin_hook('list_entities_by_views_counter_hook','plugin','list_entities_by_views_counter_hook');
	// A hook that may be used by other plugins that want to get the entities by the number of views without get depedent of any specific plugin
	register_plugin_hook('get_entities_by_views_counter_hook','plugin','get_entities_by_views_counter_hook');
	// A hook that may be used by other plugins that want to get the number of views for an entity
	register_plugin_hook('get_views_counter_hook','plugin','get_views_counter_hook');
	// A hook that may be used by other plugins that want to get the last view time for an entity
	register_plugin_hook('get_last_view_time_hook','plugin','get_last_view_time_hook');
	// A hook that may be used by other plugin that want to update the last view time of an entity
	register_plugin_hook('update_last_view_time_hook','plugin','update_last_view_time_hook');
	// A hook thay may be used by other plugins that want to check if an user had seen the last update of an elgg entity
	register_plugin_hook('did_see_last_update_hook','plugin','did_see_last_update_hook');
	
	global $CONFIG;
	$action_dir = dirname(__FILE__) . "/actions";
	
	register_action('views_counter/create_demo_entity', false, "$action_dir/views_counter/create_demo_entity.php", true);
	register_action('entities/delete',                  false, "$action_dir/entities/delete.php");
	register_action('views_counter/list_entities',      false, "$action_dir/views_counter/list_entities.php");
?>
