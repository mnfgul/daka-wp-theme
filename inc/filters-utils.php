<?php 

/* ---------------------------------------- WP MAIN FILTERS ------------------------------------------------------------------------- */



/* --------------------------------  TEMPLATE STRUCTURE FUNCTIONS ------------------------------------------------------------------ */

/*Add function to support single template for categories*/
add_filter('single_template', create_function(
	'$the_template',
	'foreach( (array) get_the_category() as $cat ) {
		if ( file_exists(TEMPLATEPATH . "/single-{$cat->slug}.php") )
		return TEMPLATEPATH . "/single-{$cat->slug}.php"; }
	return $the_template;' )
);


/*Add function to support category template inheritence*/
add_action('template_redirect', 'inherit_cat_template');
function inherit_cat_template() 
{
	if (is_category()) 
	{
		$catid = get_query_var('cat');
		$cat = &get_category($catid);
		$parent = $cat->category_parent;
		while ($parent)
		{
			$cat = &get_category($parent);
			if ( file_exists(TEMPLATEPATH . '/category-' . $cat->slug . '.php') ) 
			{
				include (TEMPLATEPATH . '/category-' . $cat->slug . '.php');
				exit;
			}
			$parent = $cat->category_parent;
		}
	}
}

/* ------------------------------------------------------------- BREADCRUMB ---------------------------------------------------------------------------- */
//Breadcrumb Function
function the_breadcrumb() 
{
	global $post;
	$pageId = '';
	$postType = '';
	$pageTitle = '';
	$output = '';
	
	if(!is_home())
	{
		
		$output .= '<ul class="breadcrumb breadcrumb-'.$postType.'"><li class="homeLink"><a href="'.get_option('home').'" title="NHCOA homepage">Home</a><span class="divider">></span></li>';
		
		if(is_page())
		{
			$pageId = $post->ID;
			$postType = get_post_type($post);
			$pageTitle = get_the_title($pageId);
			$list = get_ancestors($pageId, $postType);
			$list = array_reverse($list);
		}
		if(is_category())
		{
			$pageId =  get_query_var('cat');
			$postType = 'category';
			$pageTitle = get_the_category_by_ID($pageId);
			$list = get_ancestors($pageId, $postType);
			//$list = array_reverse($list);
		}
		if(is_single())
		{
			$pageId = $post->ID;
			$postType = get_post_type($post);
			$pageTitle = get_the_title($pageId);
			$cats =  get_the_category($pageId);
			usort($cats,'cmp');
			foreach($cats as $cat)
			{
				$output .='<li><a href="'.get_category_link($cat->term_id ).'">'.$cat->cat_name.'</a><span class="divider">></span></li>';
			}
		}
				
		if(is_category() || is_page())
		{
			foreach($list as $item)
			{
				$itemTitle = get_the_title($item);
				$output .= '<li><a href="'.get_permalink($item).'" title="'.$itemTitle.'">'.$itemTitle.'</a><span class="divider">></span></li>';
			}
		}			
		$output .= $pageTitle.'</ul>';		
	}	
	echo $output;
}
function cmp( $a, $b )
{ 
  if(  $a->category_parent ==  $b->category_parent ){ return 0 ; } 
  return ($a->category_parent < $b->category_parent) ? -1 : 1;
} 



/* ------------------------------------------------------------- PAGINATION ----------------------------------------------------------------------------*/
/*Pagination Function*/
function paginate()
{
	global $wp_query;
	$big = 999999999; // need an unlikely integer
	echo paginate_func( array(
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '?paged=%#%',
		'type' => 'list',
		'current' => max( 1, get_query_var('paged') ),
		'total' => $wp_query->max_num_pages
	));

}

function paginate_func( $args = '' ) {
	$defaults = array(
			'base' => '%_%', // http://example.com/all_posts.php%_% : %_% is replaced by format (below)
			'format' => '?page=%#%', // ?page=%#% : %#% is replaced by the page number
			'total' => 1,
			'current' => 0,
			'show_all' => false,
			'prev_next' => true,
			'prev_text' => __('&laquo; Previous'),
			'next_text' => __('Next &raquo;'),
			'end_size' => 5,
			'mid_size' => 4,
			'type' => 'plain',
			'add_args' => false, // array of query args to add
			'add_fragment' => ''
	);
	$args = wp_parse_args( $args, $defaults );
	extract($args, EXTR_SKIP);
	
	// Who knows what else people pass in $args
	$total = (int) $total;
	if ( $total < 2 )
			return;
	
	$current  = (int) $current;
	$end_size = 0  < (int) $end_size ? (int) $end_size : 1; // Out of bounds?  Make it the default.
	$mid_size = 0 <= (int) $mid_size ? (int) $mid_size : 2;
	$add_args = is_array($add_args) ? $add_args : false;
	$r = '';
	$page_links = array();
	$n = 0;
	$dots = false;
	
	if ( $prev_next && $current && 1 < $current ) :
			$link = str_replace('%_%', 2 == $current ? '' : $format, $base);
			$link = str_replace('%#%', $current - 1, $link);
			if ( $add_args )
					$link = add_query_arg( $add_args, $link );
			$link .= $add_fragment;
			$page_links[] = '<li><a class="prev page-numbers" href="' . esc_url( apply_filters( 'paginate_links', $link ) ) . '">' . $prev_text . '</a></li>';
	endif;
	for ( $n = 1; $n <= $total; $n++ ) :
			$n_display = number_format_i18n($n);
			if ( $n == $current ) :
				$page_links[] = '<li class="active"><a class="page-numbers" href="#">'.$n_display.'</a></li>';
				//$page_links[] = "<span class='page-numbers current'>$n_display</span>";
				$dots = true;
			else :
					if ( $show_all || ( $n <= $end_size || ( $current && $n >= $current - $mid_size && $n <= $current + $mid_size ) || $n > $total - $end_size ) ) :
							$link = str_replace('%_%', 1 == $n ? '' : $format, $base);
							$link = str_replace('%#%', $n, $link);
							if ( $add_args )
									$link = add_query_arg( $add_args, $link );
							$link .= $add_fragment;
							$page_links[] = "<li><a class='page-numbers' href='" . esc_url( apply_filters( 'paginate_links', $link ) ) . "'>$n_display</a></li>";
							$dots = true;
					elseif ( $dots && !$show_all ) :
							$page_links[] = '<span class="page-numbers dots">' . __( '&hellip;' ) . '</span>';
							$dots = false;
					endif;
			endif;
	endfor;
	if ( $prev_next && $current && ( $current < $total || -1 == $total ) ) :
			$link = str_replace('%_%', $format, $base);
			$link = str_replace('%#%', $current + 1, $link);
			if ( $add_args )
					$link = add_query_arg( $add_args, $link );
			$link .= $add_fragment;
			$page_links[] = '<li><a class="next page-numbers" href="' . esc_url( apply_filters( 'paginate_links', $link ) ) . '">' . $next_text . '</a></li>';
	endif;
	switch ( $type ) :
			case 'array' :
					return $page_links;
					break;
			case 'list' :
					$r .= "<ul>\n\t";
					$r .= join("", $page_links);
					//$r .= "<ul class='pagination'>\n\t<li>";
					//$r .= join("</li>\n\t<li>", $page_links);
					//$r .= "</li>\n</ul>\n";
					$r .= "\n</ul>\n";
					break;
			default :
					$r = join("\n", $page_links);
					break;
	endswitch;
	return $r;
}



/* ----------------------------------------------------------------- EXCERT OPTION  -------------------------------------------------------------------------------*/
function custom_excerpt_length( $length ) {
	return 35;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

function new_excerpt_more( $more ) {
	return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');



/* ----------------------------------------------------------------- Customize Gallery --------------------------------------------------------*/
add_filter('wp_get_attachment_link', 'add_gallery_id_rel');
function add_gallery_id_rel($link) {
    global $post;
    return str_replace('<a href', '<a rel="gallery['. $post->ID .']" href', $link);
}
