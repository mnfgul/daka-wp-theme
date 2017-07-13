<?php
/**
 * The template for displaying search forms in Twenty Eleven
 */
?>
	<form method="get" id="searchform" class="navbar-search pull-right form-inline" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<label for="s" class="assistive-text"><?php _e( 'Search', 'nhcoa' ); ?></label>
		<input type="text" class="field search-query" name="s" id="s" placeholder="<?php esc_attr_e( 'Search', 'nhcoa' ); ?>" />
		<input type="submit" class="submit search-query" name="submit" id="searchsubmit" value="<?php esc_attr_e( 'Search', 'nhcoa' ); ?>" />
	</form>
