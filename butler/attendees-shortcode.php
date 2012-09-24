<?php
/**
 * Displays the amount of slots left for guys and girls
 *
 * Gets the amount of people attending an event.  Subtracts
 * the amount of guys and girls from their slotted amounts.
 * Returns a small HTML snippet
 */

function jon_show_attendees()
{
	global $post, $wpdb;

	$get_people = "SELECT person_id FROM " . $wpdb->prefix . "em_bookings
	WHERE `event_id` = " . $post->ID;

	$people_ids = $wpdb->get_col( $wpdb->prepare( $get_people ) );

	$males = 0;
	$females = 0;

	if( $people_ids )
	{
		foreach( $person in $people_ids )
		{
			$get_sex = "SELECT value WHERE `user_id` = `$person` AND field_id = `2`";
			$user_row = $wpdb->getrow( $wpdb->prepare( $get_sex ) );

			if( $get_sex == "Female")
				$females++;

			if( $get_sex == "Male")
				$males++;
		}
	}

	echo'There are ' . $males . ' coming <br />';
	echo'There are ' . $females . ' coming <br />';
}