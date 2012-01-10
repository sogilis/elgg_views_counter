<?php
	/**
	 * @file views/default/views_counter.php
	 * @brief A common view name for include the views counter system by another views counter plugins
	 */


	// Add the views counter to any elgg entity
	echo elgg_view('views_counter/add',$vars);
	
	// Shows the views counter number
	echo elgg_view('views_counter/display_views_counter',$vars);
?>