<?php global $theLayout, $theHeader; 

// showcase content wrapper
$sc_content_before = '<div class="theContent">';
$sc_content_after = '</div>';
// showcase design options based on style setting
switch ($theHeader['curve_style']) {
	case 'curve-showcase': 
		$sub_class = 'class="curve"';
		$sc_class = 'pageWrapper';
		break;
	case 'straight': 
		$sub_class = 'class="straight"';
		$sc_class = 'pageWrapper';
		break;
	case 'full-width': 
		$sub_class = 'class="fullWidth"';
		$sc_content_before ='<div class="theContent pageWrapper">';
		break;
	default: 
		$sc_class = 'pageWrapper';
}
// showcase background
if ($theHeader['showcase_background'] == 'closed') $sc_class .= ' inContainer';
// Showcase content
$sc_content = $sc_content_before . prep_content($theHeader['showcase_content'], 1, 1) . $sc_content_after;
// menu classes
$mm_class = 'class="pageWrapper"';
$mm_nav = '';
if ($theHeader['menu_width'] == 'full') {
	$mm_class = '';
	$mm_nav = 'class="pageWrapper"';
}

?>
<header class="pageWrapper clearfix">
	<h1 id="Logo"><?php echo get_theme_logo(); ?></h1>
	<div id="HeaderRight" class="ugc clearfix">
		<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('generated_sidebar-'.$theHeader['top_sidebar'])) : endif; ?>
	</div>
</header>

<?php if ( $theHeader['menu_left'] || $theHeader['menu_right'] ) { ?>
<div id="MainMenu" <?php echo $mm_class; ?>>
	<div class="inner-1">
		<div class="inner-2">
			<nav <?php echo $mm_nav; ?>>
			
			<?php if ($theHeader['menu_left']) { ?>
				<div id="MM" class="slideMenu">
					<?php wp_nav_menu( array( 'container' => false, 'fallback_cb' => 'no_menu_set', 'theme_location' => 'MainMenuLeft' ) ); ?>
					<div style="clear:left"></div>
				</div>
			<?php } ?>

			<?php if ($theHeader['menu_right']) { ?>
				<div id="MM-Right" class="slideMenu">
					<?php wp_nav_menu( array( 'container' => false, 'fallback_cb' => 'no_menu_set', 'theme_location' => 'MainMenuRight' ) ); ?>
					<div style="clear:left"></div>
				</div>
			<?php } ?>
																	
			</nav>
		</div>
	</div>
</div>
<?php } ?>

<div id="SubHeader" <?php echo $sub_class; ?>>
	<?php 
	if ($theHeader['content']) {	
		// outputs the header graphic or slide show
		echo '<div class="pageWrapper">';
		show_header_content($theHeader['content']);
		echo '</div>';
	} 
	?>
	<?php if(is_home() || is_front_page()): ?>
	<section id="Showcase" class="clearfix <?php echo $sc_class; ?>">
		<div class="inner-1">
			<div class="inner-2">
				<div class="inner-3 ugc">
					<?php echo $sc_content; ?>
				</div>
			</div>
		</div>
	</section>
	<?php endif; ?>
</div>
