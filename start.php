<?php
	/**
	 * @file start.php
	 * @brief Set the views_counter plugin on elgg system
	 */

	/**
	 * Set the views_counter basic configuration on elgg system
	 */
	function views_counter_init() {
		// Try to add a views counter for the entities selected through the plugin settings
		set_views_counter();
		
		register_translations(dirname(__FILE__).'/languages',true);
		elgg_register_page_handler('views_counter','views_counter_page_handler');
		elgg_extend_view('css','views_counter/css');
	}
	
	include('lib/views_counter.php');
	
	/**
	 * Set some views_counter links on elgg system
	 */
	function views_counter_pagesetup() {
	  $context = elgg_get_context();
		if (elgg_is_admin_logged_in() && ($context=='admin') || ($context=='views_counter')) {
			global $CONFIG;

			elgg_register_menu_item('page', array(
			  'name'    => elgg_echo('views_counter:admin_page'),
			  'text'    => elgg_echo('views_counter:admin_page'),
			  'href'    => $CONFIG->wwwroot.'views_counter/list_entities/user',
			  'context' => $context,
			  'section' => 'views_counter'));
			elgg_register_menu_item('page', array(
			  'name'    => elgg_echo('views_counter:demo'),
			  'text'    => elgg_echo('views_counter:demo'),
			  'href'    => $CONFIG->wwwroot.'views_counter/demo',
			  'context' => $context,
			  'section' => 'views_counter'));
			elgg_register_menu_item('page', array(
			  'name'    => elgg_echo('views_counter:doc'),
			  'text'    => elgg_echo('views_counter:doc'),
			  'href'    => $CONFIG->wwwroot.'mod/views_counter/doc/index.html',
			  'context' => $context,
			  'section' => 'views_counter'));
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
			switch($page[0]) {
				case 'list_entities':	
					admin_gatekeeper();
					set_input('entity_type', $page[1]);
				  include "$pages/list_entities.php";
					return true;
				case 'demo':
				  include "$pages/demo.php";
					return true;
				case 'doc':
				  include "$pages/doc.php";
					return true;
				case 'views_statistics':
				  admin_gatekeeper();
					set_input('entity_guid', $page[1]);
				  include "$pages/views_statistics.php";
					return true;
			}
		}
		return false;
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
	
	elgg_register_event_handler('init','system','views_counter_init');
	elgg_register_event_handler('pagesetup','system','views_counter_pagesetup');
	
	// Get the hook 'view_counting_system' from other plugins that may be asking if some view counting system exists
	elgg_register_plugin_hook_handler('views_counting_system','plugin','views_counter_register');
	// A hook that may be used by other plugins that want to list the entities by number of views but without get dependent of any specific plugin
	// Obs.: Maybe the job of trigger a hook is on account of elgg_list_entities() function  
	elgg_register_plugin_hook_handler('list_entities_by_views_counter_hook','plugin','list_entities_by_views_counter_hook');
	// A hook that may be used by other plugins that want to get the entities by the number of views without get depedent of any specific plugin
	elgg_register_plugin_hook_handler('get_entities_by_views_counter_hook','plugin','get_entities_by_views_counter_hook');
	// A hook that may be used by other plugins that want to get the number of views for an entity
	elgg_register_plugin_hook_handler('get_views_counter_hook','plugin','get_views_counter_hook');
	// A hook that may be used by other plugins that want to get the last view time for an entity
	elgg_register_plugin_hook_handler('get_last_view_time_hook','plugin','get_last_view_time_hook');
	// A hook that may be used by other plugin that want to update the last view time of an entity
	elgg_register_plugin_hook_handler('update_last_view_time_hook','plugin','update_last_view_time_hook');
	// A hook thay may be used by other plugins that want to check if an user had seen the last update of an elgg entity
	elgg_register_plugin_hook_handler('did_see_last_update_hook','plugin','did_see_last_update_hook');
	
	global $CONFIG;
	$action_dir = dirname(__FILE__) . "/actions";
	
	elgg_register_action('views_counter/create_demo_entity', "$action_dir/views_counter/create_demo_entity.php", 'admin');
	elgg_register_action('entities/delete',                  "$action_dir/entities/delete.php");
	elgg_register_action('views_counter/list_entities',      "$action_dir/views_counter/list_entities.php");
  elgg_register_action('views_counter/settings/save',      "$action_dir/views_counter/settings/save.php", 'admin');
?>
