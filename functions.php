<?php
/**
 * Astra Child 2021 Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Astra Child 2021
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define( 'CHILD_THEME_ASTRA_CHILD_2021_VERSION', '1.0.0' );

/**
 * Enqueue styles
 */
function child_enqueue_styles() {

	wp_enqueue_style( 'astra-child-2021-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_ASTRA_CHILD_2021_VERSION, 'all' );

}

add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );

// --- Fix Authorize.Net script dependency timing (final working version) ---
function fix_authorize_net_dependency_order() {
    // Define plugin paths and URLs
    $plugin_slug       = 'woocommerce-gateway-authorize-net-cim';
    $plugin_dir_path   = WP_PLUGIN_DIR . '/' . $plugin_slug;
    $plugin_dir_url    = plugins_url( $plugin_slug . '/' );

    // The plugin sometimes uses the old SkyVerge path, sometimes the new one
    $old_path = 'assets/js/frontend/sv-wc-payment-gateway-payment-form.min.js';
    // Use the unminified version since only this exists
    $new_path = 'vendor/skyverge/wc-plugin-framework/woocommerce/payment-gateway/assets/dist/frontend/sv-wc-payment-gateway-payment-form.js';

    // Detect which version actually exists
    $chosen_path = file_exists( $plugin_dir_path . '/' . $new_path ) ? $new_path : $old_path;

    // Enqueue local jQuery.payment (required by SkyVerge)
    wp_enqueue_script(
        'jquery-payment',
        get_stylesheet_directory_uri() . '/js/jquery.payment.min.js',
        array('jquery'),
        '3.0.0',
        true
    );

    // Enqueue the SkyVerge payment form handler
    wp_enqueue_script(
        'sv-wc-payment-gateway-payment-form',
        $plugin_dir_url . $chosen_path,
        array('jquery', 'jquery-payment', 'wc-checkout'),
        '5.15.13',
        true
    );

    // Enqueue Authorize.Net CIM script, depending on the handler
    wp_enqueue_script(
        'wc-authorize-net-cim',
        $plugin_dir_url . 'assets/js/frontend/wc-authorize-net-cim.min.js',
        array('jquery', 'sv-wc-payment-gateway-payment-form'),
        '3.10.13',
        true
    );

    // Add console confirmation
    wp_add_inline_script(
        'wc-authorize-net-cim',
        'console.log("Authorize.Net CIM scripts loaded in correct order ✅");'
    );
}
add_action( 'wp_enqueue_scripts', 'fix_authorize_net_dependency_order', 5 );




if (!function_exists('state_cpt')) {
    
    // Register Custom Post Type
    function state_cpt()
    {
        
        $labels = array(
            'name' => 'State Pages',
            'singular_name' => 'State Page',
            'menu_name' => 'State Page',
            'name_admin_bar' => 'State Page',
            'archives' => 'State Page Archives',
            'attributes' => 'State Page Attributes',
            'parent_item_colon' => 'Parent State Page:',
            'all_items' => 'All State Pages',
            'add_new_item' => 'Add New State Page',
            'add_new' => 'Add New',
            'new_item' => 'New State Page',
            'edit_item' => 'Edit State Page',
            'update_item' => 'Update State Page',
            'view_item' => 'View State Page',
            'view_items' => 'View State Pages',
            'search_items' => 'Search State Page',
            'not_found' => 'Not found',
            'not_found_in_trash' => 'Not found in Trash',
            'featured_image' => 'Featured Image',
            'set_featured_image' => 'Set featured image',
            'remove_featured_image' => 'Remove featured image',
            'use_featured_image' => 'Use as featured image',
            'insert_into_item' => 'Insert into state page',
            'uploaded_to_this_item' => 'Uploaded to this state page',
            'items_list' => 'State page list',
            'items_list_navigation' => 'State page list navigation',
            'filter_items_list' => 'Filter state pages list'
        );
        $args   = array(
            'label' => 'State Page',
            'description' => 'Post Type Description',
            'labels' => $labels,
            'supports' => array(
                'title',
                'editor',
                'thumbnail',
                'comments',
                'trackbacks',
                'revisions',
                'custom-fields',
                'page-attributes'
            ),
            'hierarchical' => true,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 5,
            'menu_icon' => 'dashicons-store',
            'show_in_admin_bar' => true,
            'show_in_nav_menus' => true,
            'can_export' => true,
            'has_archive' => true,
            'exclude_from_search' => false,
            'publicly_queryable' => true,
            'capability_type' => 'page',
            'show_in_rest' => true
        );
        register_post_type('state', $args);
        
    }
    add_action('init', 'state_cpt', 0);
    
}

if ( ! function_exists( 'custom_navigation_menus' ) ) {

// Register Navigation Menus
function custom_navigation_menus() {

	$locations = array(
		'Shop' => __( 'Shop Categories', 'text_domain' ),
		'Blog' => __( 'Blog Categories', 'text_domain' ),
		'Resources' => __( 'Resources', 'text_domain' ),
	);
	register_nav_menus( $locations );

}
add_action( 'init', 'custom_navigation_menus' );

}