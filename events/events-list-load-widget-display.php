<?php 
/**
 * This is the template for the output of the events list widget. 
 * All the items are turned on and off through the widget admin.
 * There is currently no default styling, which is highly needed.
 *
 * You can customize this view by putting a replacement file of the same name (events-list-load-widget-display.php) in the events/ directory of your theme.
 *
 * @return string
 */

// Vars set:
// '$event->AllDay',
// '$event->StartDate',
// '$event->EndDate',
// '$event->ShowMapLink',
// '$event->ShowMap',
// '$event->Cost',
// '$event->Phone',

// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

$event = array();
$tribe_ecp = TribeEvents::instance();
reset($tribe_ecp->metaTags); // Move pointer to beginning of array.
foreach($tribe_ecp->metaTags as $tag){
	$var_name = str_replace('_Event','',$tag);
	$event[$var_name] = tribe_get_event_meta( $post->ID, $tag, true );
}

$event = (object) $event; //Easier to work with.

ob_start();
if ( !isset($alt_text) ) { $alt_text = ''; }
post_class($alt_text,$post->ID);
$class = ob_get_contents();
ob_end_clean();
?>
<li <?php echo $class ?>>
	<div class="clearfix">
		<div class="event-when pull-left">
			<?php
			
				$space = false;
				$output = ''; 			
				$date = tribe_get_start_date($post->ID, false, 'd/M/Y');
                list($day, $month, $year) = explode('/', $date);               
		  ?>
		  <span class="event-day"><?php echo $day?></span> 
		  <span class="event-my"><?php echo $month.'-'.$year ?></span>
		</div>
		<div class="event-title">
			<?php echo $post->post_title; ?>
		</div>
	</div>
</li>
