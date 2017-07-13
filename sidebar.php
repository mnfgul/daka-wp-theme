<?php
/**
 * The Sidebar containing the main widget area.
 */


?>
		<div id="eventsWidget" class="widget-area sidebar" role="complementary">
			<?php if ( ! dynamic_sidebar( 'events-widget' ) ) : ?>
				<?php dynamic_sidebar('events-widget');?>
			<?php endif; // end sidebar widget area ?>
		</div><!-- #secondary .widget-area -->
