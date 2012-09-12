<?php 
/* 
 * This file generates a tabular list of tickets for the event booking forms with input values for choosing ticket spaces.
 * If you want to add to this form this, you'd be better off hooking into the actions below.
 */
/* @var $EM_Event EM_Event */
global $allowedposttags;
$EM_Tickets = $EM_Event->get_bookings()->get_tickets(); //already instantiated, so should be a quick retrieval.
/*
 * This variable can be overriden, by hooking into the em_booking_form_tickets_cols filter and adding your collumns into this array.
 * Then, you should create a em_booking_form_tickets_col_arraykey action for your collumn data, which will pass a ticket and event object.
 */
$collumns = $EM_Tickets->get_ticket_collumns(); //array of collumn type => title
/*
 * 
 * Added by Jonathon McDonald on July 16, 2012
 *
 */

//First get an array of possible attributes, and declare age variables
$attributes = em_get_attributes();
$min_age = '';
$max_age = '';

//Loop through the arrays, check to see if the min age and max age are declared
foreach( $attributes['names'] as $name ) {

	//Get the value of the attribute
	$att_value = htmlspecialchars($EM_Event->event_attributes[$name], ENT_QUOTES); 

	if( $name == 'Min Age' ) {
		if( $att_value != '' ) {
			//A min age is declared, so we'll set our min age variable to it
			$min_age = $att_value;
		}
	}

	if( $name == 'Max Age' ) {
		if( $att_value != '' ) {
			$max_age = $att_value;
		}
	}

}

//Get the user age
$user_age = bp_get_profile_field_data('field=Age&user_id='.bp_loggedin_user_id());
?>
<?php if( !is_user_logged_in() ): ?>
<?php foreach( $EM_Tickets->tickets as $EM_Ticket ): /* @var $EM_Ticket EM_Ticket */ ?>

		<?php if( $EM_Ticket->ticket_name == 'Girls' || $EM_Ticket->ticket_name == 'Guys'): continue; endif; ?>

		<?php if( $EM_Ticket->is_available() || get_option('dbem_bookings_tickets_show_unavailable') ): ?>
			<?php do_action('em_booking_form_tickets_loop_header', $EM_Ticket); //do not delete ?>

			<div class="em-ticket" id="em-ticket-<?php echo $EM_Ticket->ticket_id; ?>">
				<?php foreach( $collumns as $type => $name ): ?>
					<?php
					//output collumn by type, or call a custom action 
					switch($type){
						case 'type':
							//echo $EM_Ticket->ticket_name;
							break;
						case 'price':
							?>
							<span style="font-size: 3em;"><?php echo $EM_Ticket->get_price(true); ?></span>
							<?php
							break;
						case 'spaces':
							?>
								<?php 
									 //$default = !empty($_REQUEST['em_tickets'][$EM_Ticket->ticket_id]['spaces']) ? $_REQUEST['em_tickets'][$EM_Ticket->ticket_id]['spaces']:0;
									 //$spaces_options = $EM_Ticket->get_spaces_options(true,$default);
									 //echo ( $spaces_options ) ? $spaces_options:"<strong>".__('N/A','dbem')."</strong>";
								?>
								<input type="hidden" name="em_tickets[<?php echo $EM_Ticket->ticket_id; ?>][spaces]" value="1" />
							<?php
							break;
						default:
							do_action('em_booking_form_tickets_col_'.$type, $EM_Ticket, $EM_Event);
							break;
					}
					?>
				<?php endforeach; ?>
			<?php do_action('em_booking_form_tickets_loop_footer', $EM_Ticket); //do not delete ?>
		<?php endif; ?>
	<?php endforeach; ?>
<?php elseif( ( $user_age < $min_age || $user_age > $max_age ) && ( $min_age != '' || $max_age != '') ): //Check user age ?>
<strong>This event is only for people aged <?php echo $min_age; ?> to <?php echo $max_age; ?></strong>
<?php else: ?>
	<?php foreach( $EM_Tickets->tickets as $EM_Ticket ): /* @var $EM_Ticket EM_Ticket */ ?>

		<?php $user_sex = bp_get_profile_field_data('field=Sex&user_id='.bp_loggedin_user_id()); /* Begin modifications by Jon McDonald, 07/13/2012 */?>
		<?php if($EM_Ticket->ticket_name == 'Girls' && $user_sex == 'Male' && !is_admin() ) : ?>
			<?php continue; ?>
		<?php endif; ?>
		<?php if($EM_Ticket->ticket_name == 'Guys' && $user_sex == 'Female' && !is_admin() ) : ?>
			<?php continue; ?>
		<?php endif; /* End modifications by Jon McDonald, 07/13/2012 */?>
		<?php if($EM_Ticket->ticket_name == 'General' && !is_admin() ): ?>
			<?php continue; ?>
		<?php endif; /* End modifications by Jon McDonald, 07/13/2012 */?>

		<?php if( $EM_Ticket->is_available() || get_option('dbem_bookings_tickets_show_unavailable') ): ?>
			<?php do_action('em_booking_form_tickets_loop_header', $EM_Ticket); //do not delete ?>
			<div class="em-ticket" id="em-ticket-<?php echo $EM_Ticket->ticket_id; ?>">
				<?php foreach( $collumns as $type => $name ): ?>
					<?php
					//output collumn by type, or call a custom action 
					switch($type){
						case 'type':
							break;
						case 'price':
							?>
							<span style="font-size: 3em;"><?php echo $EM_Ticket->get_price(true); ?></span>
							<?php
							break;
						case 'spaces':
							?>
								<?php 
									 //$default = !empty($_REQUEST['em_tickets'][$EM_Ticket->ticket_id]['spaces']) ? $_REQUEST['em_tickets'][$EM_Ticket->ticket_id]['spaces']:0;
									 //$spaces_options = $EM_Ticket->get_spaces_options(true,$default);
									 //echo ( $spaces_options ) ? $spaces_options:"<strong>".__('N/A','dbem')."</strong>";
								?>
								<input type="hidden" name="em_tickets[<?php echo $EM_Ticket->ticket_id; ?>][spaces]" value="1" />
							<?php
							break;
						default:
							do_action('em_booking_form_tickets_col_'.$type, $EM_Ticket, $EM_Event);
							break;
					}
					?>
				<?php endforeach; ?>
			<?php do_action('em_booking_form_tickets_loop_footer', $EM_Ticket); //do not delete ?>
		<?php endif; ?>
	<?php endforeach; ?>
<?php endif; //End user age check ?>