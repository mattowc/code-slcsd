<?php 

// A small fix that only allows admins to view the members page
if(!current_user_can('manage_options')): 
// Add redirect code here
else:
?>
	<div id="BP-Container">
		<div id="BP-Content">

			<form action="" method="post" id="members-directory-form" class="dir-form">
	
				<header class="entry-header">

					<div id="members-dir-search" class="dir-search">
						<?php bp_directory_members_search_form() ?>
					</div><!-- #members-dir-search -->	

					<!-- Title / Page Headline -->
					<h1 class="entry-title"><?php _e( 'Members Directory', 'buddypress' ) ?></h1>
					
				</header>
				
	
				<div class="item-list-tabs bp-content-tabs">
					<ul>
						<li class="selected" id="members-all"><a href="<?php bp_root_domain() ?>"><?php printf( __( 'All Members (%s)', 'buddypress' ), bp_get_total_member_count() ) ?></a></li>
	
						<?php if ( is_user_logged_in() && function_exists( 'bp_get_total_friend_count' ) && bp_get_total_friend_count( bp_loggedin_user_id() ) ) : ?>
							<li id="members-personal"><a href="<?php echo bp_loggedin_user_domain() . BP_FRIENDS_SLUG . '/my-friends/' ?>"><?php printf( __( 'My Friends (%s)', 'buddypress' ), bp_get_total_friend_count( bp_loggedin_user_id() ) ) ?></a></li>
						<?php endif; ?>
	
						<?php do_action( 'bp_members_directory_member_types' ) ?>
	
					</ul>
				</div><!-- .item-list-tabs -->
	

				<div class="item-list-tabs no-ajax" id="subnav">
					<ul>
						<li id="members-order-select" class="last filter">
	
							<?php _e( 'Order By:', 'buddypress' ) ?>
							<select>
								<option value="active"><?php _e( 'Last Active', 'buddypress' ) ?></option>
								<option value="newest"><?php _e( 'Newest Registered', 'buddypress' ) ?></option>
	
								<?php if ( bp_is_active( 'xprofile' ) ) : ?>
									<option value="alphabetical"><?php _e( 'Alphabetical', 'buddypress' ) ?></option>
								<?php endif; ?>
	
								<?php do_action( 'bp_members_directory_order_options' ) ?>
							</select>
						</li>
					</ul>
				</div><!-- .item-list-tabs -->


				<div id="members-dir-list" class="members dir-list">
					<?php locate_template( array( 'members/members-loop.php' ), true ) ?>
				</div><!-- #members-dir-list -->
	
				<?php do_action( 'bp_directory_members_content' ) ?>
	
				<?php wp_nonce_field( 'directory_members', '_wpnonce-member-filter' ) ?>
	
				<?php do_action( 'bp_after_directory_members_content' ) ?>
	
			</form><!-- #members-directory-form -->


		</div><!-- #content -->
	</div><!-- #container -->
<?php endif;?>
	<?php //locate_template( array( 'sidebar.php' ), true ) ?>
