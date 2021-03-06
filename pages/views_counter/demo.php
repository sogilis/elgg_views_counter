<?php
	/**
	 * @file views_counter/demo.php
	 * @brief Provide a demo of how to use the views_counter plugin
	 */

	$title = elgg_echo('views_counter:demo');
	elgg_push_breadcrumb($title);

	$area2 .= elgg_view_title($title);

	// Displays the demon page for views counter plugin
	$area2 .= elgg_view('views_counter/demo_entity_create_button');
	$area2 .= '<hr />';

	$options = array(
		'type'=>'object',
		'subtypes'=>'views_counter_demo',
		'order_by'=>'desc' // Change for 'asc' if You want to change the order
		);
	$area2 .= list_entities_by_most_viewed($options);

	$page_body = elgg_view_layout('two_column_left_sidebar',$area1,$area2);

	echo elgg_view_page($title,$page_body);
?>
