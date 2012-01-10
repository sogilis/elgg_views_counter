<?php
	/**
	 * @file views/default/views_counter/views_statistics.php
	 * @brief Displays the views statistics for one entity
	 */

	$entity = ($vars['entity']) ? ($vars['entity']) : (get_entity(get_input('entity_guid')));
	
	if ($entity) {
		if ($html = list_annotations($vars['entity']->guid,'views_counter',20)) {
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