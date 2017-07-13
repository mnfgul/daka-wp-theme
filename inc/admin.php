<?php 

//Custom Admin Login
function login_css() 
{
    wp_enqueue_style( 'login_css', get_template_directory_uri() . '/css/admin.css' );
}
add_action('login_head', 'login_css');

// Admin Footer Remover
function remove_footer_admin () {
    echo '&copy; DAKA - Sen de Soz Sahibi Ol';
}
add_filter('admin_footer_text', 'remove_footer_admin'); 


//Admin Css
// Custom WordPress Admin Color Scheme
function admin_css() {
    wp_enqueue_style( 'admin_css', get_template_directory_uri() . '/css/admin.css' );
}
add_action('admin_print_styles', 'admin_css' );

// Dashboard widget remover
function remove_dashboard_widgets() {
    remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_browser_nag', 'dashboard', 'normal' );
    
    remove_meta_box( 'tribe_dashboard_widget', 'dashboard', 'normal' );    
} 
add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );

/* Remove the WordPress Logo from the WordPress Admin Bar */
function remove_wp_logo() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('wp-logo');
}
add_action( 'wp_before_admin_bar_render', 'remove_wp_logo' );

?>