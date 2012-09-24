<?php
/*
Plugin Name:  OWC Butler
Plugin URI:  http://onewebcentric.com
Description:  Adds some useful shortcode to WordPress
Version:  .01
Author URI:  http://onewebcentric.com
Author:  Jon McDonald of OneWebCentric
*/

/*
 * Define our plugin path
 */
define( 'OWC_PATH', plugin_dir_path(__FILE__) );

//Includes code to create sliders
include_once( OWC_PATH . '/slider.php');

// Basic short code that will show post ID, and contains comments for skeleton for getting event attendees
function jon_show_attendees()
{
	global $post, $wpdb;

	$event_id = $wpdb->get_row( "SELECT event_id FROM " . $wpdb->prefix . "em_events WHERE `post_id` = " . $post->ID);

	$get_people = "SELECT person_id FROM " . $wpdb->prefix . "em_bookings
	WHERE `event_id` = " . $event_id->event_id;

	$people_ids = $wpdb->get_col( $wpdb->prepare( $get_people ) );
	$males = 0;
	$females = 0;

	if( $people_ids )
	{
		foreach( $people_ids as $person )
		{
			$get_sex = "SELECT value FROM " . $wpdb->prefix . "bp_xprofile_data WHERE `user_id` = $person AND field_id = 2";
			$user_row = $wpdb->get_row( $wpdb->prepare( $get_sex ) );

			if( $user_row->value == "Female")
				$females++;

			if( $user_row->value == "Male")
				$males++;
		}
	}

	echo'There are ' . $males . ' males coming <br />';
	echo'There are ' . $females . ' females coming <br />';
}

add_shortcode( 'post_id', 'jon_show_attendees' );
?>