<?php
	/**
	 * @file mod/views_counter/views_statistics.php
	 * @brief Displays the views statistics for one entity
	 */

	require_once(dirname(dirname(dirname(__FILE__))).'/engine/start.php');
	
	admin_gatekeeper();
	
	$entity_guid = get_input('entity_guid');
	$entity = get_entity($entity_guid);
	
	$title = elgg_echo('views_counter:views_statistics');	
	
	$area2 = elgg_view_title($title);
	// Shows the views statistics for an elgg entity
	$area2 .= elgg_view('views_counter/views_statistics',array('entity'=>$entity));
	
	$page_body = elgg_view_layout('two_column_left_sidebar',$area1,$area2);
	
	page_draw($title,$page_body);
?>