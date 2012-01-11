<?php
	/**
	 * @file views/default/views_counter/views_statistics.php
	 * @brief Displays the views statistics for one entity
	 */

	$entity = ($vars['entity']) ? ($vars['entity']) : (get_entity(get_input('entity_guid')));
	
	if ($entity) {
	  $html = elgg_list_annotations(array(
	    'guid'     => $vars['entity']->guid,
	    'limit'    => 20,
	    'order_by' => "n_table.time_created asc"));
		if ($html) {
?>
			<table>
				<tr>
					<th class="id_column"><?php echo elgg_echo('views_counter:id'); ?></th>
					<th class="name_column"><?php echo elgg_echo('views_counter:name_or_title'); ?></th>
					<th class="user_name_column"><?php echo elgg_echo('views_counter:user_name'); ?></th>
					<th class="views_column"><?php echo elgg_echo('views_counter:views_by_user'); ?></th>
					<th class="first_view_column"><?php echo elgg_echo('views_counter:first_view'); ?></th>
				</tr>
				<?php echo $html; ?>
			</table>
<?php
		}
	}
?>
