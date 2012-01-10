<?php
	/**
	 * @file automatic_doc_for_doxygen.php
	 * @brief Provides some information for doxygen
	 */

	/**
	 * @mainpage forum
	 * 
	 * Provides a view counter system that may be include automatically for any entities, based on subtypes, that follow some specific elgg patterns that comes from the elgg_view_entity() function
	 * 
	 * <br />
	 * <br />
	 * 
	 * <b>Author: </b>José Gomes; email: juniordesiron@gmail.com
	 * <br />
	 * <b>Elgg Version: </b>1.7.6
	 * <br />
	 * <b>Published: </b>17/01/2011
	 * <br />
	 * <b>Last update: </b>17/01/2011
	 * <br />
	 * <b>Functionality: </b><br />
	 * (version 1.0.0)<br />
	 * 1 - A view system for any elgg entity that may be used easily through the function add_views_counter(ENTITY_GUID)<br />
	 * 2 - A view that may be used for add a views counter to any elgg entity<br />
	 * 3 - System that allow the admin add automatically a views counter to: users, groups, grouptopics and all subtypes of object that follow the patterns of the elgg_view_entity() function<br />
	 * 4 - A function for retrieve the views counter for any elgg entity easily: get_views_counter(ENTITY_GUID)<br />
	 * 5 - A elgg view that displays the views counter for any elgg entity: "views_counter/display_views_counter"<br />
	 * 6 - A admin page where the admin can see the views for the entities<br />
	 * 7 - A demo of how to use the views_counter plugin that makes more easy to use It and makes sure if It is working or not<br />
	 * (version 1.1.0)<br />
	 * 8 - A common view name for include the views counter system by another views counter plugins<br />
	 * (version 1.5.0)<br />
	 * 9 - A new function that will be very useful for developers: list_entities_by_most_viewed($options)). Allows to retrieve a list of entities ordered by number of views<br />
	 * 10 - Some new functions registered for get hooks from another plugins that wants to use the views counting system but in a neutral way, just triggering elgg hooks.<br />
	 * 11 - Basic CSS customization through plugin settings<br />
	 * 12 - Now It is possible to include the views counter number via Javascript, just setting the container input ID on plugin settings<br />
	 * (version 1.6.0)<br />
	 * 13 - Plugin setting for display or no display the views counter<br />
	 * (version 1.6.3)<br />
	 * 14 - Bug correction: The functions list_entities_by_most_viewed() and get_entities_by_most_viewed() were corrected. There was a bug: Only the views of 1 user was beeing considered before.<br />
	 * 15 - Bug correction: The functions list_entities_by_most_viewed() and get_entities_by_most_viewed() were renamed to list_entities_by_views_counter() and get_entities_by_views_counter()<br />
	 * 16 - Bug correction: The hooks list_entities_by_most_viewed_hook() and get_entities_by_most_viewed_hook() were renamed to list_entities_by_views_counter_hook() and get_entities_by_views_counter_hook()<br />
	 * (version 1.9.3)<br />
	 * 17 - New function: get_last_view_time() and its hook get_last_view_time_hook() created <br />
	 * 18 - New function: update_last_view_time() and its hook update_last_view_time_hook() created<br />
	 * 19 - New function: did_see_last_update() and its hook did_see_last_update_hook() created<br />
	 * <br />
	 */
?>