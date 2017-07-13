<?php
/**
 * Makes a custom Widget for displaying Aside, Link, Status, and Quote Posts available with Twenty Eleven
 *
 * Learn more: http://codex.wordpress.org/Widgets_API#Developing_Widgets
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
class Twenty_Eleven_Ephemera_Widget extends WP_Widget {

	/**
	 * Constructor
	 *
	 * @return void
	 **/
	function Twenty_Eleven_Ephemera_Widget() {
		$widget_ops = array( 'classname' => 'widget_twentyeleven_ephemera', 'description' => __( 'Use this widget to list your recent Aside, Status, Quote, and Link posts', 'twentyeleven' ) );
		$this->WP_Widget( 'widget_twentyeleven_ephemera', __( 'Twenty Eleven Ephemera', 'twentyeleven' ), $widget_ops );
		$this->alt_option_name = 'widget_twentyeleven_ephemera';

		add_action( 'save_post', array(&$this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array(&$this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array(&$this, 'flush_widget_cache' ) );
	}

	/**
	 * Outputs the HTML for this widget.
	 *
	 * @param array An array of standard parameters for widgets in this theme
	 * @param array An array of settings for this widget instance
	 * @return void Echoes it's output
	 **/
	function widget( $args, $instance ) {
		$cache = wp_cache_get( 'widget_twentyeleven_ephemera', 'widget' );

		if ( !is_array( $cache ) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = null;

		if ( isset( $cache[$args['widget_id']] ) ) {
			echo $cache[$args['widget_id']];
			return;
		}

		ob_start();
		extract( $args, EXTR_SKIP );

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Ephemera', 'twentyeleven' ) : $instance['title'], $instance, $this->id_base);

		if ( ! isset( $instance['number'] ) )
			$instance['number'] = '10';

		if ( ! $number = absint( $instance['number'] ) )
 			$number = 10;

		$ephemera_args = array(
			'order' => 'DESC',
			'posts_per_page' => $number,
			'no_found_rows' => true,
			'post_status' => 'publish',
			'post__not_in' => get_option( 'sticky_posts' ),
			'tax_query' => array(
				array(
					'taxonomy' => 'post_format',
					'terms' => array( 'post-format-aside', 'post-format-link', 'post-format-status', 'post-format-quote' ),
					'field' => 'slug',
					'operator' => 'IN',
				),
			),
		);
		$ephemera = new WP_Query( $ephemera_args );

		if ( $ephemera->have_posts() ) :
			echo $before_widget;
			echo $before_title;
			echo $title; // Can set this with a widget option, or omit altogether
			echo $after_title;
			?>
			<ol>
			<?php while ( $ephemera->have_posts() ) : $ephemera->the_post(); ?>

				<?php if ( 'link' != get_post_format() ) : ?>

				<li class="widget-entry-title">
					<a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyeleven' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
					<span class="comments-link">
						<?php comments_popup_link( __( '0 <span class="reply">comments &rarr;</span>', 'twentyeleven' ), __( '1 <span class="reply">comment &rarr;</span>', 'twentyeleven' ), __( '% <span class="reply">comments &rarr;</span>', 'twentyeleven' ) ); ?>
					</span>
				</li>

				<?php else : ?>

				<li class="widget-entry-title">
					<?php
						// Grab first link from the post content. If none found, use the post permalink as fallback.
						$link_url = twentyeleven_url_grabber();

						if ( empty( $link_url ) )
							$link_url = get_permalink();
					?>
					<a href="<?php echo esc_url( $link_url ); ?>" title="<?php printf( esc_attr__( 'Link to %s', 'twentyeleven' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?>&nbsp;<span>&rarr;</span></a>
					<span class="comments-link">
						<?php comments_popup_link( __( '0 <span class="reply">comments &rarr;</span>', 'twentyeleven' ), __( '1 <span class="reply">comment &rarr;</span>', 'twentyeleven' ), __( '% <span class="reply">comments &rarr;</span>', 'twentyeleven' ) ); ?>
					</span>
				</li>

				<?php endif; ?>

			<?php endwhile; ?>
			</ol>
			<?php

			echo $after_widget;

			// Reset the post globals as this query will have stomped on it
			wp_reset_postdata();

		// end check for ephemeral posts
		endif;

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set( 'widget_twentyeleven_ephemera', $cache, 'widget' );
	}

	/**
	 * Deals with the settings when they are saved by the admin. Here is
	 * where any validation should be dealt with.
	 **/
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['number'] = (int) $new_instance['number'];
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset( $alloptions['widget_twentyeleven_ephemera'] ) )
			delete_option( 'widget_twentyeleven_ephemera' );

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete( 'widget_twentyeleven_ephemera', 'widget' );
	}

	/**
	 * Displays the form for this widget on the Widgets page of the WP Admin area.
	 **/
	function form( $instance ) {
		$title = isset( $instance['title']) ? esc_attr( $instance['title'] ) : '';
		$number = isset( $instance['number'] ) ? absint( $instance['number'] ) : 10;
?>
			<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'twentyeleven' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>

			<p><label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php _e( 'Number of posts to show:', 'twentyeleven' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" size="3" /></p>
		<?php
	}
}

/*
// Put functions into one big function we'll call at the plugins_loaded
// action. This ensures that all required plugin functions are defined.
function widget_subpages_init() {

	// Check for the required plugin functions. This will prevent fatal
	// errors occurring when you deactivate the dynamic-sidebar plugin.
	if ( !function_exists('wp_register_sidebar_widget') )
		return;

	// This is the function that outputs our little Google search form.
	function widget_subpages($args) {
		global $post;
		// $args is an array of strings that help widgets to conform to
		// the active theme: before_widget, before_title, after_widget,
		// and after_title are the array keys. Default tags: li and h2.
		extract($args);
    if (is_page())
    {
  		// Each widget can store its own options. We keep strings here.
  		$options = get_option('widget_subpages');
  		$title = $options['title'];
  		
  		// default values for the items added in version 1.1
		$useRoot = 1;  // we use the root page per default
		$onlyFirstLevel = 0; // display all children
		$parentIcon = '<='; // the default parent icon is "<="
		$parentPosition = 'top'; // the parent row is added at the top
		$addParent = 1; // add the parent row the list
  		
  		// If an old version is used where this config is not defined
  		// don't try to load the config value use the default instead
      if (isset($options['useRoot']))
		{		
			$useRoot = $options['useRoot'];
		}
  		
  		if (isset($options['onlyFirstLevel']))
      {		
  		   $onlyFirstLevel = $options['onlyFirstLevel'];
  		}  	
  		
  		if (isset($options['parentIcon']))
      {		
  		   $parentIcon = $options['parentIcon'];
  		}
  		
      if (isset($options['parentPosition']))
      {		
  		   $parentPosition = $options['parentPosition'];
  		}
  		
  		if (isset($options['addParent']))
      {		
  		   $addParent = $options['addParent'];
  		}
  
      $rootPost = $post;
      
      // find out the root page only when needed
      if ($useRoot)
      {
        // find the root page and use it
        while ($rootPost->post_parent != 0)
        {
          $rootPost = &get_post($rootPost->post_parent);
        }
      }      
      
      // If only the first level should be used set the
      // depthStr to the correct value.
      // see http://codex.wordpress.org/Template_Tags/wp_list_pages for more information
      $depthStr = '';
      if ($onlyFirstLevel && !$useRoot)
      {
        $depthStr='&depth=1';
      }
    
      // the title 
      $title = $title.$rootPost->post_title;
            
      $output = wp_list_pages('sort_column=menu_order'.$depthStr.'&title_li=&echo=0&child_of='.$rootPost->ID);
      
      // add the parent page if the parent page should not be used
      // and the parent page should be added
      // and the page has an parent page.  
      if (!$useRoot and $addParent and $rootPost->post_parent != 0)
    		{
    		   $parentPage = &get_post($rootPost->post_parent);
    		   $parentTitle = $parentPage->post_title;
    		   // do we add the parent page at the top or the bottom.
    		   if ($parentPosition=='top')
    		   {
				$output = '<li><a href="'.get_permalink($rootPost->post_parent).'">'.$parentIcon.'&nbsp;'.$parentTitle.'</a></li>'.$output;
    		    //$output = '<li><a href="'.get_permalink($rootPost->post_parent).'">'.$parentIcon.'&nbsp;'.$parentTitle.'</a></li>'.$output;
    		   }
    		   else
    		   {
    		    $output = $output.'<li><a href="'.get_permalink($rootPost->post_parent).'">'.$parentIcon.'&nbsp;'.$parentTitle.'</a></li>';
           }    		  
        }  
            
      if (!empty($output))
      {
    		// These lines generate our output. Widgets can be very complex
    		// but as you can see here, they can also be very, very simple.
    		echo $before_widget . $before_title;    		
        echo '<a href="'.get_permalink($rootPost->ID).'">'.$title.'</a>'.$after_title;            		
    		echo '<ul>';
    		
        echo $output;
        echo '</ul>';		
    		echo $after_widget;
  		}
		}
	}

	// This is the function that outputs the form to let the users edit
	// the widget's title. It's an optional feature that users cry for.
	function widget_subpages_control() {

		// Get our options and see if we're handling a form submission.
		$options = get_option('widget_subpages');
		if ( !is_array($options) )
		{
			$options = array('title'=>'', 'useRoot'=>1, 'onlyFirstLevel'=>0, 'parentIcon'=>'<=', 'parentPosition'=>'top');
		}
		
		if ( !empty($_POST['subpages-submit'])) 
		{
			// Remember to sanitize and format use input appropriately.
			$options['title'] = strip_tags(stripslashes($_POST['subpages-title']));
			$options['useRoot'] = isset($_POST['subpages-useRoot']);
			$options['onlyFirstLevel'] = isset($_POST['subpages-onlyFirstLevel']);
			$options['parentIcon'] = stripslashes($_POST['subpages-parentIcon']);
			$options['parentPosition'] = strip_tags(stripslashes($_POST['subpages-parentPosition']));
			$options['addParent'] = isset($_POST['subpages-addParent']);
			update_option('widget_subpages', $options);
		}

		// Be sure you format your options to be valid HTML attributes.
		$title = htmlspecialchars($options['title'], ENT_QUOTES);
		$useRoot = 'checked="checked"';
		$onlyFirstLevel='';
		$parentIcon = "<=";
		$parentPosition = 'top';
		$addParent = 'checked="checked"';
		
		if (isset($options['useRoot']))
    {
      $useRoot = $options['useRoot'] ? 'checked="checked"' : '';
    }
    
    if (isset($options['onlyFirstLevel']))
    {
      $onlyFirstLevel = $options['onlyFirstLevel'] ? 'checked="checked"' : '';
    }
    
    if (isset($options['parentIcon']))
    {
      $parentIcon = htmlspecialchars($options['parentIcon'], ENT_QUOTES);
    }
    
    if (isset($options['parentPosition']))
    {
      $parentPosition = htmlspecialchars($options['parentPosition'], ENT_QUOTES);
    }
    
    if (isset($options['addParent']))
    {
      $addParent = $options['addParent'] ? 'checked="checked"' : '';
    }
    
    $topSet = $parentPosition == 'top' ? 'checked="checked"' : '';
		$bottomSet = $parentPosition == 'bottom' ? 'checked="checked"' : '';
		
		// Here is our little form segment. Notice that we don't need a
		// complete form. This will be embedded into the existing form.
		echo '<p style=""><label for="subpages-title">' . __('Title:') . ' <input style="width: 200px;" id="subpages-title" name="subpages-title" type="text" value="'.$title.'" /></label></p>';
		echo '<p><label for="subpages-useRoot" style="text-align:right;">'.__('Use Root:').'<input class="checkbox" type="checkbox" '.$useRoot.' id="subpages-useRoot" name="subpages-useRoot" /></label></p>';		
		echo '<p><label for="subpages-onlyFirstLevel" style="text-align:right;">'.__('First level only:').'<input class="checkbox" type="checkbox" '.$onlyFirstLevel.' id="subpages-onlyFirstLevel" name="subpages-onlyFirstLevel" /></label></p>';
		echo '<p><label for="subpages-addParent" style="text-align:right;">'.__('Add Parent Page:').'<input class="checkbox" type="checkbox" '.$addParent.' id="subpages-addParent" name="subpages-addParent" /></label></p>';
		echo '<p><label for="subpages-parentIcon">' . __('Parent Icon:') . ' <input style="width: 200px;" id="subpages-parentIcon" name="subpages-parentIcon" type="text" value="'.$parentIcon.'" /></label></p>';    
		echo '<p><label for="subpages-parentPosition" style="text-align:right;">'.__('Position:').'<input type="radio" name="subpages-parentPosition" id="subpages-parentPosition-top" value="top"'.$topSet.'>&nbsp;Top&nbsp;&nbsp;<input type="radio" name="subpages-parentPosition" id="subpages-color-bottom" value="bottom"'.$bottomSet.'>&nbsp;Bottom&nbsp;</label></p>';
		echo '<input type="hidden" id="subpages-submit" name="subpages-submit" value="1" />';
	}
	
	// This registers our widget so it appears with the other available
	// widgets and can be dragged and dropped into any active sidebars.
	wp_register_sidebar_widget('widget-sub-pages', 'SubPage Menu', 'widget_subpages');

	// This registers our optional widget control form. Because of this
	// our widget will have a button that reveals a 300x100 pixel form.
	wp_register_widget_control('widget-sub-pages', 'SubPage Menu', 'widget_subpages_control');
}

// Run our code later in case this loads prior to any required plugins.
add_action('widgets_init', 'widget_subpages_init');
*/