<?php 

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if (!isset( $content_width ) ){ $content_width = 584;}

/* Tell WordPress to run nhcoa_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'nhcoa_setup' );
if (!function_exists( 'nhcoa_setup' )):
function nhcoa_setup(){

	/* Make Twenty Eleven available for translation.
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Twenty Eleven, use a find and replace
	 * to change 'twentyeleven' to the name of your theme in all the template files.
	 */
	//load_theme_textdomain( 'twentyeleven', get_template_directory() . '/languages' );

	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Load up our theme options page and related code.
	require( get_template_directory() . '/inc/theme-options.php' );

	// Grab Twenty Eleven's Ephemera widget.
	require( get_template_directory() . '/inc/widgets.php' );

	// Add default posts and comments RSS feed links to <head>.
	add_theme_support( 'automatic-feed-links' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
		'top-menu' => __( 'Top Menu' ),
		'main-menu' => __( 'Main Menu' ),
		'social-menu' => __( 'Social Links on Main Menu' ),
		'footer-menu' => __( 'Footer Menu' )
		)
	);

	// Add support for a variety of post formats
	add_theme_support( 'post-formats', array( 'aside', 'link', 'gallery', 'status', 'quote', 'image' ) );
	//add_theme_support( 'post-formats', array( 'blog', 'feature', 'event', 'status', 'quote', 'image' ) );
	
	//define image size
	add_image_size( 'banner-full', 920, 275);
	add_image_size( 'mini-thumb', 64, 64, true);
	add_image_size( 'entry-thumb', 220, 150);
	add_image_size( 'general-big', 360, 268);
	add_image_size( 'general-mid', 260, 180);
	add_image_size( 'general-small', 160, 120);
	
	// Add support for custom backgrounds
	add_custom_background();

	// This theme uses Featured Images (also known as post thumbnails) for per-post/per-page Custom Header images
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 160, 120 );
}
endif; // nhcoa_setup


/**
 * Register our sidebars and widgetized areas. Also register the default widget.
 *
 */
function daka_widgets_init() {

	//Events Sidebar
	
	register_sidebar( array(
		'name' => __( 'Etkinlik Alani', 'daka' ),
		'id' => 'events-widget',
		'description' => __( 'Etkinlik takvimi alani', 'daka' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	
}
add_action( 'widgets_init', 'daka_widgets_init' );


/**
 * Register custom post types: Banner
 */
 /*
function register_banner_post_type() {
	$args = array(
		'label' => __('Banners'),
		'singular_label' => __('Banner'),
		'public' => true,
		'show_ui' => true,
		'capability_type' => 'post',
		'hierarchical' => true,
		'rewrite' => true,
		'supports' => array('title', 'editor', 'thumbnail','excerpt','page-attributes'),
		'labels'=>array(
			'add_new_item'=>__('Add a New Banner'),
			'edit_item'=>__('Edit Banner'),
			'new_item'=>__('New Banner'),
			'view_item'=>__('View Banner'),
			'search_items'=>__('Search Banners'),
			'not_found'=>__('No Banners Found'),
			'not_found_in_trash'=>__('No Banners Found in Trash')
		)
	);
	register_post_type( 'banner' , $args );
}
add_action('init', 'register_banner_post_type');
*/


/*Setup menu for bootstarp compability*/
// Menu output mods
class Main_Nav_Walker extends Walker_Nav_Menu
{
      function start_el(&$output, $item, $depth, $args)
      {
			global $wp_query;
			$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
			
			$class_names = $value = '';
			
			// If the item has children, add the dropdown class for bootstrap
			if ( $args->has_children ) {
				$class_names = "dropdown ";
			}
			
			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			
			$class_names .= join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
			$class_names = ' class="'. esc_attr( $class_names ).'"';
           
           	$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

           	$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
           	$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
           	$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
           	$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
           	// if the item has children add these two attributes to the anchor tag
           	if ( $args->has_children ) {
				$attributes .= 'class="dropdown-toggle" data-toggle="dropdown"';
			}
			
			$item_output = $args->before;
			$item_output .= '<a'. $attributes .'>';
			$item_output .= $args->link_before .apply_filters( 'the_title', $item->title, $item->ID );
			$item_output .= $args->link_after;
			            
			
            // if the item has children add the caret just before closing the anchor tag
            if ( $args->has_children ) {
            	$item_output .= '<b class="caret"></b></a>';
            }
            else{
            	$item_output .= '</a>';
            }
			$item_output .= $args->after;
			
			//if no link
			if($item->url == '')
			{
				$item_output = $item->title;
				
				//if it is nav-header class
				if(in_array('nav-header',$item->classes))
				{
					$item_output = $item->title;
				}
			}
			

            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
            }
            
        function start_lvl(&$output, $depth) {
            $indent = str_repeat("\t", $depth);
            $output .= "\n$indent<ul class=\"dropdown-menu\">\n";
        }
            
      	function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output )
      	    {
      	        $id_field = $this->db_fields['id'];
      	        if ( is_object( $args[0] ) ) {
      	            $args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
      	        }
      	        return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
      	    }	
            
}

// Maintainance Mode
/*
function wpr_maintenance_mode() {
    if ( !current_user_can( 'edit_themes' ) || !is_user_logged_in() ) {
        wp_die('Sitemiz onarim asamasindadir. Lutfen daha sonra tekrar deneyiniz!');
    }
}
add_action('get_header', 'wpr_maintenance_mode');
*/

//Filters, Utils functions and All other include files
include_once('inc/filters-utils.php');

//Custom Admin Area Options
include_once('inc/admin.php');
