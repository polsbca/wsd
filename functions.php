<?php
/**
 * WSD Theme Functions
 *
 * @package wsd
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Set up theme defaults and register support for various WordPress features.
 */
function wsd_setup() {
	// Add theme support
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Register menus
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'wsd' ),
		'footer'  => esc_html__( 'Footer Menu', 'wsd' ),
	) );
}
add_action( 'after_setup_theme', 'wsd_setup' );

/**
 * Enqueue styles and scripts
 */
function wsd_scripts() {
	// Bootstrap 5 CSS
	wp_enqueue_style( 'bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css', array(), '5.3.3' );

	// Main stylesheet
	wp_enqueue_style( 'wsd-style', get_stylesheet_uri(), array( 'bootstrap' ), wp_get_theme()->get( 'Version' ) );

	// Additional custom stylesheet for page-specific designs
	wp_enqueue_style( 'wsd-custom', get_stylesheet_directory_uri() . '/assets/css/custom.css', array( 'wsd-style' ), time() );

	// Mobile responsive stylesheet
	wp_enqueue_style( 'wsd-responsive', get_stylesheet_directory_uri() . '/assets/css/responsive.css', array( 'wsd-custom' ), time() );

	// GSAP & ScrollTrigger for front-page, services template, and single services animations
	if ( is_front_page() || is_page_template( 'template-services.php' ) || is_singular( 'services' ) ) {
		wp_enqueue_script( 'gsap', 'https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js', array(), '3.12.5', true );
		wp_enqueue_script( 'gsap-scrolltrigger', 'https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js', array( 'gsap' ), '3.12.5', true );
		wp_enqueue_script( 'wsd-animations', get_stylesheet_directory_uri() . '/assets/js/animations.js', array( 'gsap', 'gsap-scrolltrigger' ), time(), true );
	}

	// jQuery (WordPress default)
	if ( ! is_admin() ) {
		wp_enqueue_script( 'jquery' );
	}

	// Mobile responsive scripts
	wp_enqueue_script( 'wsd-responsive-js', get_stylesheet_directory_uri() . '/assets/js/responsive.js', array( 'jquery' ), time(), true );

	// Comment reply script
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'wsd_scripts' );

/**
 * Register widget areas
 */
function wsd_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Primary Sidebar', 'wsd' ),
		'id'            => 'primary-sidebar',
		'description'   => esc_html__( 'Main sidebar', 'wsd' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'wsd_widgets_init' );

/**
 * Customize excerpt length
 */
function wsd_excerpt_length( $length ) {
	return 55;
}
add_filter( 'excerpt_length', 'wsd_excerpt_length' );

/**
 * Customize excerpt more text
 */
function wsd_excerpt_more( $more ) {
	return ' ... <a href="' . get_permalink() . '">' . esc_html__( 'Read More', 'wsd' ) . '</a>';
}
add_filter( 'excerpt_more', 'wsd_excerpt_more' );

/**
 * Register Custom Post Type "services" and custom taxonomy
 */
function wsd_register_services_cpt() {
	// Register Custom Taxonomy "service_category"
	$taxonomy_labels = array(
		'name'              => _x( 'Service Categories', 'taxonomy general name', 'wsd' ),
		'singular_name'     => _x( 'Service Category', 'taxonomy singular name', 'wsd' ),
		'search_items'      => __( 'Search Service Categories', 'wsd' ),
		'all_items'         => __( 'All Service Categories', 'wsd' ),
		'parent_item'       => __( 'Parent Service Category', 'wsd' ),
		'parent_item_colon' => __( 'Parent Service Category:', 'wsd' ),
		'edit_item'         => __( 'Edit Service Category', 'wsd' ),
		'update_item'       => __( 'Update Service Category', 'wsd' ),
		'add_new_item'      => __( 'Add New Service Category', 'wsd' ),
		'new_item_name'     => __( 'New Service Category Name', 'wsd' ),
		'menu_name'         => __( 'Service Categories', 'wsd' ),
	);

	$taxonomy_args = array(
		'hierarchical'      => true,
		'labels'            => $taxonomy_labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'service-category' ),
		'show_in_rest'      => true,
	);

	register_taxonomy( 'service_category', array( 'services' ), $taxonomy_args );

	// Register Custom Post Type "services"
	$labels = array(
		'name'               => _x( 'Services', 'post type general name', 'wsd' ),
		'singular_name'      => _x( 'Service', 'post type singular name', 'wsd' ),
		'menu_name'          => _x( 'Services', 'admin menu', 'wsd' ),
		'name_admin_bar'     => _x( 'Service', 'add new on admin bar', 'wsd' ),
		'add_new'            => _x( 'Add New', 'service', 'wsd' ),
		'add_new_item'       => __( 'Add New Service', 'wsd' ),
		'new_item'           => __( 'New Service', 'wsd' ),
		'edit_item'          => __( 'Edit Service', 'wsd' ),
		'view_item'          => __( 'View Service', 'wsd' ),
		'all_items'          => __( 'All Services', 'wsd' ),
		'search_items'       => __( 'Search Services', 'wsd' ),
		'parent_item_colon'  => __( 'Parent Services:', 'wsd' ),
		'not_found'          => __( 'No services found.', 'wsd' ),
		'not_found_in_trash' => __( 'No services found in Trash.', 'wsd' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'services' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 5,
		'menu_icon'          => 'dashicons-admin-tools',
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
		'show_in_rest'       => true,
	);

	register_post_type( 'services', $args );

	// Pre-populate terms if they don't exist
	if ( ! term_exists( 'cosmetic-dentistry', 'service_category' ) ) {
		wp_insert_term( 'Cosmetic Dentistry', 'service_category', array( 'slug' => 'cosmetic-dentistry' ) );
	}
	if ( ! term_exists( 'general-dentistry', 'service_category' ) ) {
		wp_insert_term( 'General Dentistry', 'service_category', array( 'slug' => 'general-dentistry' ) );
	}

	// Flush rewrite rules on CPT registration
	flush_rewrite_rules();
}
add_action( 'init', 'wsd_register_services_cpt' );
