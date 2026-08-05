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
 * Make front-end search global across all public, searchable post types.
 *
 * @param WP_Query $query Main query.
 */
function wsd_global_search_query( $query ) {
	if ( is_admin() || ! $query->is_main_query() || ! $query->is_search() ) {
		return;
	}

	$post_types = get_post_types(
		array(
			'public'              => true,
			'exclude_from_search' => false,
		),
		'names'
	);

	if ( empty( $post_types ) ) {
		return;
	}

	// Keep attachment out of front-end search results.
	unset( $post_types['attachment'] );

	$query->set( 'post_type', array_values( $post_types ) );
}
add_action( 'pre_get_posts', 'wsd_global_search_query' );

/**
 * Enqueue styles and scripts
 */
function wsd_scripts() {
	// Bootstrap 5 CSS
	wp_enqueue_style( 'bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css', array(), '5.3.3' );

	// Bootstrap 5 JS
	wp_enqueue_script( 'bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js', array(), '5.3.3', true );

	// Main stylesheet
	wp_enqueue_style( 'wsd-style', get_stylesheet_uri(), array( 'bootstrap' ), wp_get_theme()->get( 'Version' ) );

	// Additional custom stylesheet for page-specific designs
	wp_enqueue_style( 'wsd-custom', get_stylesheet_directory_uri() . '/assets/css/custom.css', array( 'wsd-style' ), time() );

	// Mobile responsive stylesheet
	wp_enqueue_style( 'wsd-responsive', get_stylesheet_directory_uri() . '/assets/css/responsive.css', array( 'wsd-custom' ), time() );

	// GSAP, ScrollTrigger, and site-wide smooth scrolling.
	wp_enqueue_script( 'gsap', 'https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js', array(), '3.12.5', true );
	wp_enqueue_script( 'gsap-scrolltrigger', 'https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js', array( 'gsap' ), '3.12.5', true );
	wp_enqueue_script( 'wsd-smooth-scroll', get_stylesheet_directory_uri() . '/assets/js/smooth-scroll.js', array( 'gsap', 'gsap-scrolltrigger' ), time(), true );

	// Front-page, services template, single services, and contact page animations.
	if ( is_front_page() || is_page_template( 'template-services.php' ) || is_page_template( 'template-contact.php' ) || is_page_template( 'template-privacy-policy.php' ) || is_page_template( 'template-dental-referrals.php' ) || is_page_template( 'template-teams.php' ) || is_page_template( 'template-fees.php' ) || is_page_template( 'template-smile-gallery.php' ) || is_page_template( 'template-blogs.php' ) || is_page_template( 'template-dental-implants.php' ) || is_page_template( 'template-invisalign.php' ) || is_singular( 'services' ) || is_singular( 'post' ) ) {
		wp_enqueue_script( 'wsd-animations', get_stylesheet_directory_uri() . '/assets/js/animations.js', array( 'gsap', 'gsap-scrolltrigger', 'jquery', 'bootstrap-js' ), time(), true );
	}

	if ( is_page_template( 'template-dental-implants.php' ) ) {
		wp_enqueue_script( 'wsd-dental-implants', get_stylesheet_directory_uri() . '/assets/js/dental-implants.js', array( 'jquery', 'gsap' ), time(), true );
	}

	if ( is_page_template( 'template-invisalign.php' ) ) {
		wp_enqueue_script( 'wsd-invisalign', get_stylesheet_directory_uri() . '/assets/js/invisalign.js', array( 'jquery', 'gsap', 'gsap-scrolltrigger' ), time(), true );
	}

	if ( is_page_template( 'template-teams.php' ) ) {
		wp_enqueue_script( 'wsd-teams', get_stylesheet_directory_uri() . '/assets/js/teams.js', array( 'jquery' ), time(), true );
	}

	if ( is_page_template( 'template-fees.php' ) ) {
		wp_enqueue_script( 'wsd-fees', get_stylesheet_directory_uri() . '/assets/js/fees.js', array( 'jquery' ), time(), true );
	}

	if ( is_page_template( 'template-smile-gallery.php' ) ) {
		wp_enqueue_script( 'wsd-smile-gallery', get_stylesheet_directory_uri() . '/assets/js/smile-gallery.js', array( 'jquery', 'gsap', 'gsap-scrolltrigger' ), time(), true );
	}

	if ( is_page_template( 'template-blogs.php' ) ) {
		wp_enqueue_script( 'wsd-blogs', get_stylesheet_directory_uri() . '/assets/js/blogs.js', array( 'jquery' ), time(), true );
	}

	if ( is_singular( 'post' ) ) {
		wp_enqueue_script( 'wsd-blog-single', get_stylesheet_directory_uri() . '/assets/js/blog-single.js', array( 'jquery' ), time(), true );
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
 * Force Smile Gallery Category taxonomy to use checkbox UI in admin.
 *
 * ACF-created taxonomies default to tag-style input when non-hierarchical.
 */
function wsd_smile_gallery_category_checkbox_ui( $args, $taxonomy ) {
	$smile_gallery_taxonomies = array(
		'smile_gallery_category',
		'smile-gallery-category',
	);

	if ( in_array( $taxonomy, $smile_gallery_taxonomies, true ) ) {
		$args['hierarchical']      = true;
		$args['meta_box_cb']       = 'post_categories_meta_box';
		$args['show_admin_column'] = true;
		$args['show_in_rest']      = true;
	}

	return $args;
}
add_filter( 'register_taxonomy_args', 'wsd_smile_gallery_category_checkbox_ui', 10, 2 );

/**
 * Get Smile Gallery CPT slides assigned to one or more pages/services.
 */
function wsd_get_smile_gallery_slides( $page_ids = array() ) {
	$page_ids = array_filter( array_map( 'absint', (array) $page_ids ) );

	$base_args = array(
		'post_type'      => 'smile-gallery',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => array(
			'menu_order' => 'ASC',
			'date'       => 'DESC',
		),
	);

	$meta_query = array( 'relation' => 'OR' );
	foreach ( $page_ids as $page_id ) {
		$meta_query[] = array(
			'key'     => 'shown_in_page',
			'value'   => '"' . $page_id . '"',
			'compare' => 'LIKE',
		);
		$meta_query[] = array(
			'key'     => 'shown_in_page',
			'value'   => 'i:' . $page_id . ';',
			'compare' => 'LIKE',
		);
	}

	if ( count( $meta_query ) > 1 ) {
		$base_args['meta_query'] = $meta_query;
	}

	$gallery_posts = get_posts( $base_args );

	if ( empty( $gallery_posts ) && ! empty( $page_ids ) ) {
		unset( $base_args['meta_query'] );
		$gallery_posts = get_posts( $base_args );
	}

	$image_fallback = get_template_directory_uri() . '/assets/images/about1.png';
	$normalize_image = function ( $image ) use ( $image_fallback ) {
		if ( is_array( $image ) && ! empty( $image['url'] ) ) {
			return $image['url'];
		}

		if ( is_string( $image ) && '' !== trim( $image ) ) {
			return $image;
		}

		return $image_fallback;
	};
	$slides = array();

	foreach ( $gallery_posts as $gallery_post ) {
		$before_image = get_field( 'before_image', $gallery_post->ID );
		$after_image  = get_field( 'after_image', $gallery_post->ID );

		$category_slugs = array();
		$category_names = array();
		$category_taxonomies = array(
			'smile-gallery-category',
			'smile_gallery_category',
		);

		foreach ( $category_taxonomies as $category_taxonomy ) {
			if ( ! taxonomy_exists( $category_taxonomy ) ) {
				continue;
			}

			$terms = get_the_terms( $gallery_post->ID, $category_taxonomy );
			if ( is_wp_error( $terms ) || empty( $terms ) ) {
				continue;
			}

			foreach ( $terms as $term ) {
				$category_slugs[] = $term->slug;
				$category_names[] = $term->name;
			}
			break;
		}

		$slides[] = array(
			'before_image'     => $normalize_image( $before_image ),
			'after_image'      => $normalize_image( $after_image ),
			'treatment'        => get_field( 'treatment', $gallery_post->ID ) ?: get_the_title( $gallery_post->ID ),
			'concern'          => get_field( 'main_concern', $gallery_post->ID ) ?: 'Worn & Discoloured Teeth',
			'duration'         => get_field( 'duration', $gallery_post->ID ) ?: '3 months',
			'visits'           => get_field( 'visits', $gallery_post->ID ) ?: '2 visits',
			'category_slugs'   => $category_slugs,
			'category_names'   => $category_names,
			'primary_category' => ! empty( $category_names ) ? $category_names[0] : '',
			'post_id'          => $gallery_post->ID,
			'permalink'        => get_permalink( $gallery_post->ID ),
		);
	}

	return $slides;
}

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
		'hierarchical'       => true,
		'menu_position'      => 5,
		'menu_icon'          => 'dashicons-admin-tools',
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes' ),
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

/**
 * Show custom taxonomy columns in CPT admin list tables.
 */
function wsd_enable_acf_taxonomy_admin_columns() {
	$taxonomies = array(
		'fees-membership-category',
		'support-team-category',
	);

	foreach ( $taxonomies as $taxonomy_slug ) {
		$taxonomy = get_taxonomy( $taxonomy_slug );
		if ( $taxonomy ) {
			$taxonomy->show_admin_column = true;
		}
	}
}
add_action( 'init', 'wsd_enable_acf_taxonomy_admin_columns', 99 );


add_filter( 'wp_image_editors', 'wpse_prefer_gd_over_imagick' );
function wpse_prefer_gd_over_imagick($array) {
    return array( 'WP_Image_Editor_GD', 'WP_Image_Editor_Imagick' );
}

/**
 * Save ACF field groups to theme acf-json directory.
 */
function wsd_acf_json_save_point( $path ) {
	return get_stylesheet_directory() . '/acf-json';
}
add_filter( 'acf/settings/save_json', 'wsd_acf_json_save_point' );

/**
 * Load ACF field groups from theme acf-json directory.
 */
function wsd_acf_json_load_point( $paths ) {
	$paths[] = get_stylesheet_directory() . '/acf-json';
	return $paths;
}
add_filter( 'acf/settings/load_json', 'wsd_acf_json_load_point' );

/**
 * Get a contact page ACF field with a fallback default.
 *
 * @param string $field_name ACF field name.
 * @param mixed  $default    Default value when field is empty.
 * @return mixed
 */
function wsd_get_contact_page_field( $field_name, $default = '' ) {
	if ( ! function_exists( 'get_field' ) ) {
		return $default;
	}

	$value = get_field( $field_name );

	if ( null === $value || false === $value || '' === $value ) {
		return $default;
	}

	return $value;
}

/**
 * Get the permalink for a page using a given template file.
 *
 * @param string $template Template filename.
 * @param string $fallback Fallback URL.
 * @return string
 */
function wsd_get_page_url_by_template( $template, $fallback = '' ) {
	$pages = get_pages(
		array(
			'meta_key'   => '_wp_page_template',
			'meta_value' => $template,
			'number'     => 1,
		)
	);

	if ( ! empty( $pages ) ) {
		return get_permalink( $pages[0]->ID );
	}

	return $fallback;
}

/**
 * Get the permalink for the Contact page template.
 *
 * @return string
 */
function wsd_get_contact_page_url() {
	return wsd_get_page_url_by_template( 'template-contact.php', home_url( '/#contact-us' ) );
}

/**
 * Get the permalink for the Dental Referrals page template.
 *
 * @return string
 */
function wsd_get_referrals_page_url() {
	return wsd_get_page_url_by_template( 'template-dental-referrals.php', home_url( '/#referrals' ) );
}

/**
 * Get the permalink for the Fees page template.
 *
 * @return string
 */
function wsd_get_fees_page_url() {
	return wsd_get_page_url_by_template( 'template-fees.php', home_url( '/fees-membership-plans/' ) );
}

/**
 * Get the permalink for the Smile Gallery page template.
 *
 * @return string
 */
function wsd_get_smile_gallery_page_url() {
	return wsd_get_page_url_by_template( 'template-smile-gallery.php', home_url( '/smile-gallery/' ) );
}

/**
 * Get the permalink for the Blogs page template.
 *
 * @return string
 */
function wsd_get_blogs_page_url() {
	return wsd_get_page_url_by_template( 'template-blogs.php', home_url( '/blogs/' ) );
}

/**
 * Get a services CPT post by path (slug path under the services post type).
 *
 * @param string $path Path like 'all-about-general-dentistry-services'.
 * @return WP_Post|null
 */
function wsd_get_services_post_by_path( $path ) {
	$post = get_page_by_path( $path, OBJECT, 'services' );
	return ( $post instanceof WP_Post ) ? $post : null;
}

/**
 * Permalink for a services CPT post path, with optional treatment hash.
 *
 * @param string $path           Parent service path.
 * @param string $fallback_path  Fallback path segment.
 * @param string $treatment_slug Optional child treatment slug for #hash.
 * @return string
 */
function wsd_get_services_url_by_path( $path, $fallback_path = '', $treatment_slug = '' ) {
	$post = wsd_get_services_post_by_path( $path );
	$url  = $post ? get_permalink( $post ) : home_url( '/services/' . ( $fallback_path ? $fallback_path : $path ) . '/' );

	if ( $treatment_slug ) {
		$url = untrailingslashit( $url ) . '/#' . sanitize_title( $treatment_slug );
	}

	return $url;
}

/**
 * General Dentistry parent page URL (optional treatment tab hash).
 *
 * @param string $treatment_slug Optional child slug, e.g. 'bridges'.
 * @return string
 */
function wsd_get_general_dentistry_url( $treatment_slug = '' ) {
	return wsd_get_services_url_by_path(
		'all-about-general-dentistry-services',
		'all-about-general-dentistry-services',
		$treatment_slug
	);
}

/**
 * Cosmetic Dentistry parent page URL (optional treatment tab hash).
 *
 * @param string $treatment_slug Optional child slug, e.g. 'dental-veneers'.
 * @return string
 */
function wsd_get_cosmetic_dentistry_url( $treatment_slug = '' ) {
	return wsd_get_services_url_by_path(
		'all-about-cosmetic-dentistry-services',
		'all-about-cosmetic-dentistry-services',
		$treatment_slug
	);
}

/**
 * Get the permalink for the Dental Implants page template.
 *
 * @return string
 */
function wsd_get_dental_implants_page_url() {
	return wsd_get_page_url_by_template( 'template-dental-implants.php', home_url( '/dental-implants/' ) );
}

/**
 * Build All About Dental Implants tab panels from ACF (with Figma fallbacks).
 *
 * @param int $page_id Optional page ID.
 * @return array{process: array<int, array>, types: array<int, array>, benefits: array<int, array>}
 */
function wsd_get_dental_implants_about_panels( $page_id = 0 ) {
	$page_id = $page_id ? (int) $page_id : (int) get_queried_object_id();

	$defaults = array(
		'process'  => array(
			array(
				'num'   => '1',
				'title' => 'Consultation & Assessment',
				'desc'  => 'Digital scans and examination to plan your implant treatment.',
			),
			array(
				'num'   => '2',
				'title' => 'Implant Placement',
				'desc'  => 'The titanium implant is placed securely into the jawbone.',
			),
			array(
				'num'   => '3',
				'title' => 'Healing & Integration',
				'desc'  => 'The implant naturally bonds with the bone over several months.',
			),
			array(
				'num'   => '4',
				'title' => 'Crown Fitting & Aftercare',
				'desc'  => 'Your custom crown is fitted, followed by ongoing care and review appointments.',
			),
		),
		'types'    => array(
			array(
				'type'  => 'Most common',
				'title' => 'Single Tooth Implant',
				'desc'  => 'A single titanium post and crown used to replace one missing tooth. Leaves adjacent healthy teeth completely untouched and prevents bone loss at the site.',
				'ideal' => 'One or two missing teeth in otherwise healthy jaw',
			),
			array(
				'type'  => 'Multiple teeth',
				'title' => 'Implant-Supported Bridge',
				'desc'  => 'Two or more implant posts support a bridge that spans a gap of several teeth — eliminating the need to crown healthy adjacent teeth as traditional bridges do.',
				'ideal' => '3–4 consecutive missing teeth',
			),
			array(
				'type'  => 'Full arch',
				'title' => 'All-on-4 / All-on-6',
				'desc'  => 'A full arch of teeth supported by just four or six strategically placed implants. A fixed, permanent solution for patients with extensive tooth loss or failing dentition.',
				'ideal' => 'Full arch replacement or denture upgrade',
			),
			array(
				'type'  => 'Implant-retained',
				'title' => 'Implant-Retained Dentures',
				'desc'  => 'Existing or new dentures that clip securely onto two or more implants — dramatically improving stability and eliminating the embarrassment of loose dentures.',
				'ideal' => 'Current denture wearers seeking more security',
			),
			array(
				'type'  => 'Same-day',
				'title' => 'Immediate Loading (Teeth in a Day)',
				'desc'  => 'In select cases, a temporary crown is fitted on the same day as implant placement, so you leave with a tooth rather than waiting months for the final crown.',
				'ideal' => 'Suitable bone density, front teeth',
			),
			array(
				'type'  => 'Bone graft',
				'title' => 'Implants with Bone Grafting',
				'desc'  => 'If you\'ve experienced bone loss following tooth extraction, a bone graft can rebuild the area to create a secure foundation for the implant post.',
				'ideal' => 'Patients with insufficient bone density',
			),
		),
		'benefits' => array(
			array(
				'num'   => '1',
				'title' => 'Looks & Feels Natural',
				'desc'  => 'Custom crowns match shade, shape and bite so your implant blends with your smile.',
			),
			array(
				'num'   => '2',
				'title' => 'Protects Your Jawbone',
				'desc'  => 'The implant stimulates bone like a natural root, helping prevent long-term bone loss.',
			),
			array(
				'num'   => '3',
				'title' => 'Spares Healthy Teeth',
				'desc'  => 'No need to grind down neighbouring teeth as you would for a traditional bridge.',
			),
			array(
				'num'   => '4',
				'title' => 'Built to Last',
				'desc'  => 'With good hygiene and reviews, implants can provide a lifetime of reliable function.',
			),
		),
	);

	if ( ! function_exists( 'get_field' ) || ! $page_id ) {
		return $defaults;
	}

	$panels = $defaults;

	$process_group = get_field( 'process', $page_id );
	if ( is_array( $process_group ) ) {
		$process_cards = array();
		for ( $i = 1; $i <= 4; $i++ ) {
			$title = isset( $process_group[ "process_title_{$i}" ] ) ? trim( (string) $process_group[ "process_title_{$i}" ] ) : '';
			$desc  = isset( $process_group[ "process_descreption_{$i}" ] ) ? trim( (string) $process_group[ "process_descreption_{$i}" ] ) : '';
			if ( '' === $title && '' === $desc ) {
				continue;
			}
			$process_cards[] = array(
				'num'   => (string) $i,
				'title' => $title,
				'desc'  => $desc,
			);
		}
		if ( ! empty( $process_cards ) ) {
			$panels['process'] = $process_cards;
		}
	}

	$types_group = get_field( 'types_of_implant', $page_id );
	if ( is_array( $types_group ) ) {
		$type_cards = array();
		for ( $i = 1; $i <= 6; $i++ ) {
			$type  = isset( $types_group[ "implant_type_{$i}" ] ) ? trim( (string) $types_group[ "implant_type_{$i}" ] ) : '';
			$title = isset( $types_group[ "implant_title_{$i}" ] ) ? trim( (string) $types_group[ "implant_title_{$i}" ] ) : '';
			$desc  = isset( $types_group[ "implant_content_{$i}" ] ) ? trim( (string) $types_group[ "implant_content_{$i}" ] ) : '';
			$ideal = isset( $types_group[ "implant_ideal_for_{$i}" ] ) ? trim( (string) $types_group[ "implant_ideal_for_{$i}" ] ) : '';
			$ideal = preg_replace( '/^ideal\s*for\s*:\s*/i', '', $ideal );
			if ( '' === $type && '' === $title && '' === $desc && '' === $ideal ) {
				continue;
			}
			$type_cards[] = array(
				'type'  => $type,
				'title' => $title,
				'desc'  => $desc,
				'ideal' => $ideal,
			);
		}
		if ( ! empty( $type_cards ) ) {
			$panels['types'] = $type_cards;
		}
	}

	$benefits_group = get_field( 'key_benefits', $page_id );
	if ( is_array( $benefits_group ) ) {
		$benefit_cards = array();
		for ( $i = 1; $i <= 4; $i++ ) {
			$title = isset( $benefits_group[ "key_benefits_title_{$i}" ] ) ? trim( (string) $benefits_group[ "key_benefits_title_{$i}" ] ) : '';
			$desc  = isset( $benefits_group[ "key_benefits_content_{$i}" ] ) ? trim( (string) $benefits_group[ "key_benefits_content_{$i}" ] ) : '';
			if ( '' === $title && '' === $desc ) {
				continue;
			}
			$benefit_cards[] = array(
				'num'   => (string) $i,
				'title' => $title,
				'desc'  => $desc,
			);
		}
		if ( ! empty( $benefit_cards ) ) {
			$panels['benefits'] = $benefit_cards;
		}
	}

	return $panels;
}

/**
 * Get Invisalign page URL by template, with path fallback.
 *
 * @return string
 */
function wsd_get_invisalign_page_url() {
	return wsd_get_page_url_by_template( 'template-invisalign.php', home_url( '/invisalign/' ) );
}

/**
 * Get the Blogs page hero image URL (featured image, then theme fallback).
 *
 * @param int $page_id Optional page ID.
 * @return string
 */
function wsd_get_blogs_hero_image_url( $page_id = 0 ) {
	$page_id = $page_id ? (int) $page_id : (int) get_queried_object_id();
	$scheme  = is_ssl() ? 'https' : 'http';

	if ( $page_id && has_post_thumbnail( $page_id ) ) {
		$featured_url = get_the_post_thumbnail_url( $page_id, 'full' );
		if ( $featured_url ) {
			return set_url_scheme( $featured_url, $scheme );
		}
	}

	$fallback_path = get_theme_file_path( 'assets/images/blogs-hero.png' );
	$fallback_url  = get_theme_file_uri( 'assets/images/blogs-hero.png' );

	if ( file_exists( $fallback_path ) ) {
		$fallback_url .= '?ver=' . filemtime( $fallback_path );
	}

	return set_url_scheme( $fallback_url, $scheme );
}

/**
 * Estimate a blog post read time in minutes.
 *
 * @param int $post_id Post ID.
 * @return int
 */
function wsd_get_blog_read_time_minutes( $post_id ) {
	$post_id = (int) $post_id;
	$content = get_post_field( 'post_content', $post_id );
	$words   = str_word_count( wp_strip_all_tags( (string) $content ) );
	$minutes = (int) max( 1, (int) ceil( $words / 200 ) );

	/**
	 * Filter estimated blog read time.
	 *
	 * @param int $minutes Estimated minutes.
	 * @param int $post_id Post ID.
	 */
	return (int) apply_filters( 'wsd_blog_read_time_minutes', $minutes, $post_id );
}

/**
 * Build a normalized blog post card data array.
 *
 * @param int|WP_Post $post Post object or ID.
 * @return array<string, mixed>|null
 */
function wsd_get_blog_post_card_data( $post ) {
	$post = get_post( $post );
	if ( ! $post ) {
		return null;
	}

	$post_id       = (int) $post->ID;
	$comment_count = (int) get_comments_number( $post_id );
	$categories    = get_the_category( $post_id );
	$category_slugs = array();

	if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
		foreach ( $categories as $category ) {
			$category_slugs[] = sanitize_title( $category->slug );
		}
	}

	$image_url = get_the_post_thumbnail_url( $post_id, 'large' );
	if ( ! $image_url ) {
		$image_url = get_theme_file_uri( 'assets/images/blogs-hero.png' );
	}

	$excerpt = get_the_excerpt( $post );
	$excerpt = wp_strip_all_tags( $excerpt );
	$excerpt = preg_replace( '/\s+/', ' ', (string) $excerpt );
	$excerpt = trim( (string) $excerpt );

	return array(
		'id'             => $post_id,
		'title'          => get_the_title( $post ),
		'permalink'      => get_permalink( $post ),
		'date'           => get_the_date( 'd M Y', $post ),
		'comment_count'  => $comment_count,
		'comments_label' => sprintf(
			/* translators: %d: number of comments */
			_n( '%d Comment', '%d Comments', $comment_count, 'wsd' ),
			$comment_count
		),
		'read_time'      => sprintf(
			/* translators: %d: estimated minutes to read */
			_n( '%d min read', '%d min read', wsd_get_blog_read_time_minutes( $post_id ), 'wsd' ),
			wsd_get_blog_read_time_minutes( $post_id )
		),
		'excerpt'        => $excerpt,
		'image_url'      => $image_url,
		'image_alt'      => get_post_meta( (int) get_post_thumbnail_id( $post_id ), '_wp_attachment_image_alt', true ) ?: get_the_title( $post ),
		'category_slugs' => $category_slugs,
	);
}

/**
 * Get published blog posts for the blogs page.
 *
 * @param int $limit Number of posts.
 * @return array<int, array<string, mixed>>
 */
function wsd_get_blog_posts( $limit = 7 ) {
	$query = new WP_Query(
		array(
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'posts_per_page'      => (int) $limit,
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
		)
	);

	$posts = array();
	if ( $query->have_posts() ) {
		foreach ( $query->posts as $post ) {
			$card = wsd_get_blog_post_card_data( $post );
			if ( $card ) {
				$posts[] = $card;
			}
		}
	}
	wp_reset_postdata();

	return $posts;
}

/**
 * Get blog categories used for filters.
 *
 * @return WP_Term[]
 */
function wsd_get_blog_filter_categories() {
	$terms = get_categories(
		array(
			'hide_empty' => true,
			'orderby'    => 'name',
			'order'      => 'ASC',
		)
	);

	if ( empty( $terms ) || is_wp_error( $terms ) ) {
		return array();
	}

	return $terms;
}

/**
 * Split a blog title into main + accent parts (last two words accented).
 *
 * @param string $title Post title.
 * @return array{main: string, accent: string}
 */
function wsd_get_blog_title_parts( $title ) {
	$title = trim( wp_strip_all_tags( (string) $title ) );
	$words = preg_split( '/\s+/u', $title, -1, PREG_SPLIT_NO_EMPTY );

	if ( empty( $words ) ) {
		return array(
			'main'   => '',
			'accent' => '',
		);
	}

	if ( count( $words ) === 1 ) {
		return array(
			'main'   => '',
			'accent' => $words[0],
		);
	}

	$accent_words = array_splice( $words, -2 );

	return array(
		'main'   => implode( ' ', $words ) . ' ',
		'accent' => implode( ' ', $accent_words ),
	);
}

/**
 * Get blog like count from post meta (defaults to 0).
 *
 * @param int $post_id Post ID.
 * @return int
 */
function wsd_get_blog_like_count( $post_id ) {
	$post_id = (int) $post_id;
	$count   = (int) get_post_meta( $post_id, 'wsd_like_count', true );

	/**
	 * Filter blog like count displayed on the detail page.
	 *
	 * @param int $count   Like count.
	 * @param int $post_id Post ID.
	 */
	return (int) apply_filters( 'wsd_blog_like_count', max( 0, $count ), $post_id );
}

/**
 * Get related blog posts for the single post page.
 *
 * @param int $post_id Current post ID.
 * @param int $limit   Number of posts.
 * @return array<int, array<string, mixed>>
 */
function wsd_get_related_blog_posts( $post_id, $limit = 6 ) {
	$post_id    = (int) $post_id;
	$limit      = (int) $limit;
	$categories = wp_get_post_categories( $post_id );

	$args = array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => $limit,
		'post__not_in'        => array( $post_id ),
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	);

	if ( ! empty( $categories ) ) {
		$args['category__in'] = $categories;
	}

	$query = new WP_Query( $args );
	$posts = array();

	if ( $query->have_posts() ) {
		foreach ( $query->posts as $post ) {
			$card = wsd_get_blog_post_card_data( $post );
			if ( $card ) {
				$posts[] = $card;
			}
		}
	}

	// Fallback: recent posts when the category has too few articles.
	if ( count( $posts ) < min( 3, $limit ) ) {
		$exclude_ids = array_merge(
			array( $post_id ),
			wp_list_pluck( $posts, 'id' )
		);

		$fallback = new WP_Query(
			array(
				'post_type'           => 'post',
				'post_status'         => 'publish',
				'posts_per_page'      => $limit - count( $posts ),
				'post__not_in'        => $exclude_ids,
				'ignore_sticky_posts' => true,
				'no_found_rows'       => true,
			)
		);

		if ( $fallback->have_posts() ) {
			foreach ( $fallback->posts as $post ) {
				$card = wsd_get_blog_post_card_data( $post );
				if ( $card ) {
					$posts[] = $card;
				}
			}
		}
		wp_reset_postdata();
	}

	wp_reset_postdata();

	return $posts;
}

/**
 * Get Smile Gallery category terms for page filters.
 *
 * @return WP_Term[]
 */
function wsd_get_smile_gallery_categories() {
	$taxonomies = array(
		'smile-gallery-category',
		'smile_gallery_category',
	);

	foreach ( $taxonomies as $taxonomy ) {
		if ( ! taxonomy_exists( $taxonomy ) ) {
			continue;
		}

		$terms = get_terms(
			array(
				'taxonomy'   => $taxonomy,
				'hide_empty' => false,
				'orderby'    => 'term_id',
				'order'      => 'ASC',
			)
		);

		if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
			return $terms;
		}
	}

	return array();
}

/**
 * Split a category title into main and accent parts for the page badge.
 *
 * @param string $name Category name.
 * @return array{main:string,accent:string}
 */
function wsd_split_smile_gallery_category_title( $name ) {
	$name = trim( (string) $name );

	if ( '' === $name ) {
		return array(
			'main'   => '',
			'accent' => '',
		);
	}

	$parts = preg_split( '/\s+/', $name, 2 );

	if ( count( $parts ) === 2 ) {
		return array(
			'main'   => $parts[0] . ' ',
			'accent' => $parts[1],
		);
	}

	return array(
		'main'   => $name,
		'accent' => '',
	);
}

/**
 * Get the Smile Gallery page hero image URL (featured image, then theme fallback).
 *
 * @param int $page_id Optional page ID.
 * @return string
 */
function wsd_get_smile_gallery_hero_image_url( $page_id = 0 ) {
	$page_id = $page_id ? (int) $page_id : (int) get_queried_object_id();
	$scheme  = is_ssl() ? 'https' : 'http';

	if ( $page_id && has_post_thumbnail( $page_id ) ) {
		$featured_url = get_the_post_thumbnail_url( $page_id, 'full' );
		if ( $featured_url ) {
			return set_url_scheme( $featured_url, $scheme );
		}
	}

	$fallback_path = get_theme_file_path( 'assets/images/fees-hero.png' );
	$fallback_url  = get_theme_file_uri( 'assets/images/fees-hero.png' );

	if ( file_exists( $fallback_path ) ) {
		$fallback_url .= '?ver=' . filemtime( $fallback_path );
	}

	return set_url_scheme( $fallback_url, $scheme );
}

/**
 * Get the Teams page hero image URL (featured image, then theme fallback).
 *
 * @param int $page_id Optional page ID.
 * @return string
 */
function wsd_get_teams_hero_image_url( $page_id = 0 ) {
	$page_id = $page_id ? (int) $page_id : (int) get_queried_object_id();
	$scheme  = is_ssl() ? 'https' : 'http';

	if ( $page_id && has_post_thumbnail( $page_id ) ) {
		$featured_url = get_the_post_thumbnail_url( $page_id, 'full' );
		if ( $featured_url ) {
			return set_url_scheme( $featured_url, $scheme );
		}
	}

	$fallback_path = get_theme_file_path( 'assets/images/teams-hero.png' );
	$fallback_url  = get_theme_file_uri( 'assets/images/teams-hero.png' );

	if ( file_exists( $fallback_path ) ) {
		$fallback_url .= '?ver=' . filemtime( $fallback_path );
	}

	return set_url_scheme( $fallback_url, $scheme );
}

/**
 * Get the Fees page hero image URL (featured image, then theme fallback).
 *
 * @param int $page_id Optional page ID.
 * @return string
 */
function wsd_get_fees_hero_image_url( $page_id = 0 ) {
	$page_id = $page_id ? (int) $page_id : (int) get_queried_object_id();
	$scheme  = is_ssl() ? 'https' : 'http';

	if ( $page_id && has_post_thumbnail( $page_id ) ) {
		$featured_url = get_the_post_thumbnail_url( $page_id, 'full' );
		if ( $featured_url ) {
			return set_url_scheme( $featured_url, $scheme );
		}
	}

	$fallback_path = get_theme_file_path( 'assets/images/fees-hero.png' );
	$fallback_url  = get_theme_file_uri( 'assets/images/fees-hero.png' );

	if ( file_exists( $fallback_path ) ) {
		$fallback_url .= '?ver=' . filemtime( $fallback_path );
	}

	return set_url_scheme( $fallback_url, $scheme );
}

/**
 * Get fees membership category terms for the Fees page tabs.
 *
 * @return WP_Term[]
 */
function wsd_get_fees_membership_categories() {
	if ( ! taxonomy_exists( 'fees-membership-category' ) ) {
		return array();
	}

	$terms = get_terms(
		array(
			'taxonomy'   => 'fees-membership-category',
			'hide_empty' => false,
			'orderby'    => 'term_id',
			'order'      => 'ASC',
		)
	);

	if ( is_wp_error( $terms ) || empty( $terms ) ) {
		return array();
	}

	return $terms;
}

/**
 * Format one fees-and-membership post for the accordion.
 *
 * @param WP_Post $post Fees post.
 * @return array<string, mixed>
 */
function wsd_format_fees_membership_item( $post ) {
	$content = '';

	if ( ! empty( $post->post_content ) ) {
		$content = apply_filters( 'the_content', $post->post_content );
	} elseif ( has_excerpt( $post ) ) {
		$content = '<p>' . esc_html( get_the_excerpt( $post ) ) . '</p>';
	}

	$rows  = wsd_parse_fees_treatment_rows( $content );
	$notes = wsd_parse_fees_treatment_notes( $content );

	if ( empty( $rows ) && '' === trim( wp_strip_all_tags( $content ) ) ) {
		$content = '<p>' . esc_html__( 'A full written estimate will be provided before any treatment begins. Please speak to our team for the latest pricing.', 'wsd' ) . '</p>';
	}

	return array(
		'id'      => $post->ID,
		'title'   => get_the_title( $post ),
		'content' => $content,
		'rows'    => $rows,
		'notes'   => $notes,
	);
}

/**
 * Parse treatment/price rows from fees accordion HTML content.
 *
 * Prefers WordPress table markup; also supports lines ending with a £ price.
 * Supports 2-column (name | price) and 3-column (name | description | price) tables.
 * Name cells may include a <br> to separate title and description.
 *
 * @param string $html Filtered post content HTML.
 * @return array<int, array{name: string, description: string, price: string}>
 */
function wsd_parse_fees_treatment_rows( $html ) {
	$rows = array();
	$html = (string) $html;

	if ( '' === trim( $html ) ) {
		return $rows;
	}

	if ( preg_match_all( '/<tr\b[^>]*>(.*?)<\/tr>/is', $html, $tr_matches ) ) {
		foreach ( $tr_matches[1] as $tr_html ) {
			if ( ! preg_match_all( '/<t[dh]\b[^>]*>(.*?)<\/t[dh]>/is', $tr_html, $cell_matches ) ) {
				continue;
			}

			$raw_cells = $cell_matches[1];
			$cells     = array_map(
				static function ( $cell ) {
					$cell = preg_replace( '/<br\s*\/?>/i', "\n", (string) $cell );
					$text = wp_strip_all_tags( html_entity_decode( $cell, ENT_QUOTES | ENT_HTML5, 'UTF-8' ) );
					$text = preg_replace( "/[ \t]+/u", ' ', (string) $text );
					$text = preg_replace( "/\n+/u", "\n", (string) $text );
					return trim( (string) $text );
				},
				$raw_cells
			);

			if ( count( $cells ) < 2 ) {
				continue;
			}

			$name        = $cells[0];
			$description = '';
			$price       = '';

			if ( count( $cells ) >= 3 ) {
				$description = $cells[1];
				$price       = $cells[2];
			} else {
				$price = $cells[1];
			}

			if ( '' === $description && false !== strpos( $name, "\n" ) ) {
				$parts       = preg_split( '/\n+/', $name, 2 );
				$name        = trim( (string) ( $parts[0] ?? '' ) );
				$description = trim( (string) ( $parts[1] ?? '' ) );
			}

			// Skip header rows like "Treatment".
			if ( '' === $name || 0 === strcasecmp( $name, 'treatment' ) ) {
				continue;
			}

			if ( '' === $price || 0 === strcasecmp( $price, 'price' ) || 0 === strcasecmp( $price, 'from' ) ) {
				continue;
			}

			$rows[] = array(
				'name'        => $name,
				'description' => $description,
				'price'       => $price,
			);
		}
	}

	if ( ! empty( $rows ) ) {
		return $rows;
	}

	$plain = wp_strip_all_tags( html_entity_decode( $html, ENT_QUOTES | ENT_HTML5, 'UTF-8' ) );
	$plain = preg_replace( "/\r\n|\r/", "\n", (string) $plain );
	$lines = preg_split( '/\n+/', (string) $plain );

	foreach ( (array) $lines as $line ) {
		$line = trim( preg_replace( '/\s+/u', ' ', (string) $line ) );
		if ( '' === $line ) {
			continue;
		}

		if ( preg_match( '/^(.*?)\s+((?:From\s+)?£\s?[\d,]+(?:\.\d{1,2})?)\s*$/iu', $line, $match ) ) {
			$name = trim( $match[1] );
			if ( '' === $name || 0 === strcasecmp( $name, 'treatment' ) ) {
				continue;
			}
			$rows[] = array(
				'name'        => $name,
				'description' => '',
				'price'       => trim( $match[2] ),
			);
		}
	}

	return $rows;
}

/**
 * Parse footer notes from fees content (paragraphs outside tables).
 *
 * @param string $html Filtered post content HTML.
 * @return array<int, string>
 */
function wsd_parse_fees_treatment_notes( $html ) {
	$notes = array();
	$html  = (string) $html;

	if ( '' === trim( $html ) ) {
		return $notes;
	}

	// Ignore table markup so only standalone paragraphs become notes.
	$html = preg_replace( '/<figure\b[^>]*>.*?<\/figure>/is', '', $html );
	$html = preg_replace( '/<table\b[^>]*>.*?<\/table>/is', '', $html );

	if ( preg_match_all( '/<p\b[^>]*>(.*?)<\/p>/is', (string) $html, $p_matches ) ) {
		foreach ( $p_matches[1] as $p_html ) {
			$text = trim( wp_strip_all_tags( html_entity_decode( $p_html, ENT_QUOTES | ENT_HTML5, 'UTF-8' ) ) );
			$text = preg_replace( '/\s+/u', ' ', (string) $text );
			if ( '' !== $text ) {
				$notes[] = $text;
			}
		}
	}

	return $notes;
}

/**
 * Format a fees treatment price label for display.
 *
 * @param string $price Raw price text.
 * @return string
 */
function wsd_format_fees_treatment_price( $price ) {
	$price = trim( preg_replace( '/\s+/u', ' ', (string) $price ) );

	if ( '' === $price ) {
		return '';
	}

	if ( preg_match( '/^from\b/i', $price ) ) {
		return preg_replace( '/^from\s+/i', 'From ', $price );
	}

	if ( preg_match( '/^£/', $price ) ) {
		return 'From ' . $price;
	}

	return $price;
}

/**
 * Get published fees-and-membership posts grouped by category slug.
 *
 * @return array<string, array<int, array<string, mixed>>>
 */
function wsd_get_fees_membership_items_grouped() {
	if ( ! post_type_exists( 'fees-and-membership' ) ) {
		return array();
	}

	$posts = get_posts(
		array(
			'post_type'      => 'fees-and-membership',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => array(
				'menu_order' => 'ASC',
				'title'      => 'ASC',
			),
			'order'          => 'ASC',
		)
	);

	if ( empty( $posts ) ) {
		return array();
	}

	$grouped = array();

	foreach ( $posts as $post ) {
		$terms = get_the_terms( $post, 'fees-membership-category' );
		$slug  = 'uncategorized';

		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
			$slug = $terms[0]->slug;
		}

		if ( ! isset( $grouped[ $slug ] ) ) {
			$grouped[ $slug ] = array();
		}

		$grouped[ $slug ][] = wsd_format_fees_membership_item( $post );
	}

	return $grouped;
}

/**
 * Get tab icon URL for a fees membership category.
 *
 * @param WP_Term $term  Category term.
 * @param int     $index Tab index fallback.
 * @return string
 */
function wsd_get_fees_membership_tab_icon_url( $term, $index = 0 ) {
	$theme_uri = get_template_directory_uri();
	$slug      = is_object( $term ) ? $term->slug : (string) $term;

	if ( function_exists( 'get_field' ) && is_object( $term ) ) {
		$icon_field = get_field( 'tab_icon', 'fees-membership-category_' . $term->term_id );
		if ( empty( $icon_field ) ) {
			$icon_field = get_field( 'category_icon', 'fees-membership-category_' . $term->term_id );
		}

		$icon_url = wsd_normalize_media_url( $icon_field, '' );
		if ( $icon_url ) {
			return $icon_url;
		}
	}

	$icon_map = array(
		'service-fees'         => 'fees-icon-pound.svg',
		'service'              => 'fees-icon-pound.svg',
		'consultation-charges' => 'fees-icon-calendar.svg',
		'consultation'         => 'fees-icon-calendar.svg',
		'membership-plan'      => 'fees-icon-heart.svg',
		'membership'           => 'fees-icon-heart.svg',
		'finance-options'      => 'fees-icon-wallet.svg',
		'finance'              => 'fees-icon-wallet.svg',
	);

	if ( isset( $icon_map[ $slug ] ) ) {
		return $theme_uri . '/assets/images/' . $icon_map[ $slug ];
	}

	foreach ( $icon_map as $map_slug => $icon_file ) {
		if ( false !== strpos( $slug, strtok( $map_slug, '-' ) ) ) {
			return $theme_uri . '/assets/images/' . $icon_file;
		}
	}

	$fallback_icons = array(
		'fees-icon-pound.svg',
		'fees-icon-calendar.svg',
		'fees-icon-heart.svg',
		'fees-icon-wallet.svg',
	);

	$icon_file = $fallback_icons[ $index % count( $fallback_icons ) ];

	return $theme_uri . '/assets/images/' . $icon_file;
}

/**
 * Get a short mobile tab label for a fees membership category.
 *
 * @param WP_Term|object $term Category term.
 * @return string
 */
function wsd_get_fees_membership_tab_short_label( $term ) {
	$slug = is_object( $term ) && isset( $term->slug ) ? $term->slug : '';
	$name = is_object( $term ) && isset( $term->name ) ? $term->name : '';

	$short_map = array(
		'service-fees'         => __( 'Service', 'wsd' ),
		'service'              => __( 'Service', 'wsd' ),
		'consultation-charges' => __( 'Consultation', 'wsd' ),
		'consultation'         => __( 'Consultation', 'wsd' ),
		'membership-plan'      => __( 'Membership', 'wsd' ),
		'membership'           => __( 'Membership', 'wsd' ),
		'finance-options'      => __( 'Finance', 'wsd' ),
		'finance'              => __( 'Finance', 'wsd' ),
	);

	if ( $slug && isset( $short_map[ $slug ] ) ) {
		return $short_map[ $slug ];
	}

	if ( $name ) {
		$parts = preg_split( '/\s+/', trim( $name ) );
		if ( ! empty( $parts[0] ) ) {
			return $parts[0];
		}
	}

	return $name;
}

/**
 * Whether a fees category uses the consultation cards layout (not accordion).
 *
 * @param string $slug Category slug.
 * @return bool
 */
function wsd_is_fees_consultation_category( $slug ) {
	$slug = sanitize_title( (string) $slug );

	return in_array( $slug, array( 'consultation-charges', 'consultation' ), true );
}

/**
 * Whether a fees category uses the membership plan card layout (not accordion).
 *
 * @param string $slug Category slug.
 * @return bool
 */
function wsd_is_fees_membership_category( $slug ) {
	$slug = sanitize_title( (string) $slug );

	return in_array( $slug, array( 'membership-plan', 'membership' ), true );
}

/**
 * Whether a fees category uses the finance options card layout (not accordion).
 *
 * @param string $slug Category slug.
 * @return bool
 */
function wsd_is_fees_finance_category( $slug ) {
	$slug = sanitize_title( (string) $slug );

	return in_array( $slug, array( 'finance-options', 'finance' ), true );
}

/**
 * Build consultation card data from fees membership items.
 *
 * @param array<int, array<string, mixed>> $items Fees items.
 * @return array<int, array<string, mixed>>
 */
function wsd_get_fees_consultation_cards( $items ) {
	$cards = array();

	foreach ( (array) $items as $item_index => $item ) {
		$html  = isset( $item['content'] ) ? (string) $item['content'] : '';
		$title = isset( $item['title'] ) ? (string) $item['title'] : '';

		if ( '' === trim( wp_strip_all_tags( $html ) ) ) {
			continue;
		}

		if ( ! preg_match_all( '/<h2\b[^>]*>(.*?)<\/h2>/is', $html, $heading_matches, PREG_OFFSET_CAPTURE ) ) {
			$parsed = wsd_parse_fees_consultation_card_chunk( $html, 0 === $item_index ? $title : '' );
			if ( $parsed ) {
				$cards[] = $parsed;
			}
			continue;
		}

		$heading_count = count( $heading_matches[0] );

		for ( $i = 0; $i < $heading_count; $i++ ) {
			$heading_html = $heading_matches[1][ $i ][0];
			$start        = $heading_matches[0][ $i ][1] + strlen( $heading_matches[0][ $i ][0] );
			$end          = ( $i + 1 < $heading_count ) ? $heading_matches[0][ $i + 1 ][1] : strlen( $html );
			$chunk_html   = substr( $html, $start, max( 0, $end - $start ) );
			$badge        = ( 0 === $item_index && 0 === $i ) ? $title : '';

			$parsed = wsd_parse_fees_consultation_card_chunk( $chunk_html, $badge, $heading_html );
			if ( $parsed ) {
				$cards[] = $parsed;
			}
		}
	}

	return $cards;
}

/**
 * Parse one consultation card chunk into structured data.
 *
 * @param string $html         Body HTML.
 * @param string $badge        Optional badge label.
 * @param string $heading_html Optional heading HTML (may include <em>).
 * @return array<string, mixed>|null
 */
function wsd_parse_fees_consultation_card_chunk( $html, $badge = '', $heading_html = '' ) {
	$html = (string) $html;
	$cta  = null;

	if ( preg_match( '/<a\b[^>]*href=["\']([^"\']+)["\'][^>]*>(.*?)<\/a>/is', $html, $link_match ) ) {
		$cta_label = trim( wp_strip_all_tags( html_entity_decode( $link_match[2], ENT_QUOTES | ENT_HTML5, 'UTF-8' ) ) );
		$cta_url   = esc_url_raw( html_entity_decode( $link_match[1], ENT_QUOTES | ENT_HTML5, 'UTF-8' ) );

		if ( $cta_label ) {
			$book_url = wsd_get_contact_page_url();
			if ( ! $cta_url || false !== stripos( (string) $cta_url, 'claudeusercontent.com' ) ) {
				$cta_url = $book_url;
			}

			// Figma CTA label for consultation card.
			if ( preg_match( '/book/i', $cta_label ) ) {
				$cta_label = __( 'Book an appointment', 'wsd' );
			}

			$cta = array(
				'label' => $cta_label,
				'url'   => $cta_url,
			);
		}

		$html = str_replace( $link_match[0], '', $html );
	}

	$body = trim( $html );
	$body = preg_replace( '/<p>\s*<\/p>/i', '', $body );
	$body = trim( (string) $body );

	$title_main   = '';
	$title_accent = '';
	$heading_html = trim( (string) $heading_html );

	if ( $heading_html ) {
		$heading_html = preg_replace( '/&nbsp;/i', ' ', $heading_html );

		if ( preg_match( '/^(.*?)<em\b[^>]*>(.*?)<\/em>(.*)$/is', $heading_html, $heading_parts ) ) {
			$title_main   = trim( wp_strip_all_tags( html_entity_decode( $heading_parts[1], ENT_QUOTES | ENT_HTML5, 'UTF-8' ) ) );
			$title_accent = trim( wp_strip_all_tags( html_entity_decode( $heading_parts[2] . $heading_parts[3], ENT_QUOTES | ENT_HTML5, 'UTF-8' ) ) );
			if ( '' !== $title_main ) {
				$title_main .= ' ';
			}
		} else {
			$title_parts  = wsd_get_blog_title_parts( wp_strip_all_tags( html_entity_decode( $heading_html, ENT_QUOTES | ENT_HTML5, 'UTF-8' ) ) );
			$title_main   = $title_parts['main'];
			$title_accent = $title_parts['accent'];
		}
	}

	if ( '' === $title_main && '' === $title_accent && '' === $badge && '' === trim( wp_strip_all_tags( $body ) ) ) {
		return null;
	}

	return array(
		'badge'        => $badge ? $badge : '',
		'title_main'   => $title_main,
		'title_accent' => $title_accent,
		'body_html'    => $body,
		'cta'          => $cta,
	);
}

/**
 * Render consultation charges cards panel (non-accordion).
 *
 * @param string                             $panel_id  Panel id.
 * @param array<int, array<string, mixed>>   $items     Fees items.
 * @param bool                               $is_active Whether panel is visible.
 */
function wsd_render_fees_consultation_panel( $panel_id, $items, $is_active = false ) {
	$cards = wsd_get_fees_consultation_cards( $items );
	?>
	<div
		class="fees-accordion-panel fees-consult-panel<?php echo $is_active ? ' is-active' : ''; ?>"
		id="<?php echo esc_attr( $panel_id ); ?>"
		role="tabpanel"
		<?php echo $is_active ? '' : 'hidden'; ?>
	>
		<?php if ( ! empty( $cards ) ) : ?>
			<div class="fees-consult-cards">
				<?php foreach ( $cards as $card ) : ?>
					<article class="fees-consult-card">
						<?php if ( ! empty( $card['badge'] ) ) : ?>
							<p class="fees-consult-badge">
								<span class="fees-consult-badge-dot" aria-hidden="true"></span>
								<span class="fees-consult-badge-label"><?php echo esc_html( $card['badge'] ); ?></span>
							</p>
						<?php endif; ?>

						<?php if ( ! empty( $card['title_main'] ) || ! empty( $card['title_accent'] ) ) : ?>
							<h3 class="fees-consult-title">
								<?php if ( ! empty( $card['title_main'] ) ) : ?>
									<span class="fees-consult-title-main"><?php echo esc_html( $card['title_main'] ); ?></span>
								<?php endif; ?>
								<?php if ( ! empty( $card['title_accent'] ) ) : ?>
									<span class="fees-consult-title-accent"><?php echo esc_html( $card['title_accent'] ); ?></span>
								<?php endif; ?>
							</h3>
						<?php endif; ?>

						<?php if ( ! empty( $card['body_html'] ) ) : ?>
							<div class="fees-consult-body">
								<?php echo wp_kses_post( $card['body_html'] ); ?>
							</div>
						<?php endif; ?>

						<?php if ( ! empty( $card['cta']['url'] ) && ! empty( $card['cta']['label'] ) ) : ?>
							<a class="btn btn-primary fees-consult-cta" href="<?php echo esc_url( $card['cta']['url'] ); ?>">
								<span><?php echo esc_html( $card['cta']['label'] ); ?></span>
							</a>
						<?php endif; ?>
					</article>
				<?php endforeach; ?>
			</div>
		<?php else : ?>
			<div class="fees-consult-cards">
				<article class="fees-consult-card fees-consult-card--empty">
					<p><?php esc_html_e( 'No consultation information is available yet.', 'wsd' ); ?></p>
				</article>
			</div>
		<?php endif; ?>
	</div>
	<?php
}

/**
 * Build membership plan card data from fees membership items.
 *
 * @param array<int, array<string, mixed>> $items Fees items.
 * @return array<string, mixed>|null
 */
function wsd_get_fees_membership_plan_data( $items ) {
	if ( empty( $items ) || ! is_array( $items ) ) {
		return null;
	}

	$item    = $items[0];
	$title   = isset( $item['title'] ) ? (string) $item['title'] : __( 'Dental Memberships', 'wsd' );
	$html    = isset( $item['content'] ) ? (string) $item['content'] : '';
	$badge   = __( 'Patient Plan Direct', 'wsd' );
	$paras   = array();
	$benefits = array();

	$title       = trim( wp_strip_all_tags( $title ) );
	$title_words = preg_split( '/\s+/u', $title, -1, PREG_SPLIT_NO_EMPTY );
	$title_main  = '';
	$title_accent = $title;

	if ( is_array( $title_words ) && count( $title_words ) > 1 ) {
		$title_accent = array_pop( $title_words );
		$title_main   = implode( ' ', $title_words ) . ' ';
	}

	if ( preg_match( '/Patient Plan Direct/i', wp_strip_all_tags( $html ) ) ) {
		$badge = 'Patient Plan Direct';
	}

	if ( preg_match_all( '/<p\b[^>]*>(.*?)<\/p>/is', $html, $p_matches ) ) {
		foreach ( $p_matches[1] as $p_html ) {
			$text = trim( wp_strip_all_tags( html_entity_decode( $p_html, ENT_QUOTES | ENT_HTML5, 'UTF-8' ) ) );
			$text = preg_replace( '/\s+/u', ' ', (string) $text );
			if ( '' !== $text ) {
				$paras[] = $text;
			}
		}
	}

	if ( preg_match_all( '/<li\b[^>]*>(.*?)<\/li>/is', $html, $li_matches ) ) {
		foreach ( $li_matches[1] as $li_html ) {
			$text = trim( wp_strip_all_tags( html_entity_decode( $li_html, ENT_QUOTES | ENT_HTML5, 'UTF-8' ) ) );
			$text = preg_replace( '/\s+/u', ' ', (string) $text );
			$text = preg_replace( '/^[✓✔√]\s*/u', '', (string) $text );
			$text = trim( (string) $text );
			if ( '' !== $text ) {
				$benefits[] = $text;
			}
		}
	}

	if ( empty( $paras ) && empty( $benefits ) && '' === trim( wp_strip_all_tags( $html ) ) ) {
		return null;
	}

	return array(
		'badge'        => $badge,
		'title_main'   => $title_main,
		'title_accent' => $title_accent,
		'paragraphs'   => $paras,
		'benefits'     => $benefits,
	);
}

/**
 * Render membership plan panel (non-accordion). Figma 4562:605.
 *
 * @param string                             $panel_id  Panel id.
 * @param array<int, array<string, mixed>>   $items     Fees items.
 * @param bool                               $is_active Whether panel is visible.
 */
function wsd_render_fees_membership_panel( $panel_id, $items, $is_active = false ) {
	$data = wsd_get_fees_membership_plan_data( $items );
	?>
	<div
		class="fees-accordion-panel fees-membership-panel<?php echo $is_active ? ' is-active' : ''; ?>"
		id="<?php echo esc_attr( $panel_id ); ?>"
		role="tabpanel"
		<?php echo $is_active ? '' : 'hidden'; ?>
	>
		<?php if ( $data ) : ?>
			<article class="fees-membership-card">
				<?php if ( ! empty( $data['badge'] ) ) : ?>
					<p class="fees-membership-badge">
						<span class="fees-membership-badge-dot" aria-hidden="true"></span>
						<span class="fees-membership-badge-label"><?php echo esc_html( $data['badge'] ); ?></span>
					</p>
				<?php endif; ?>

				<h3 class="fees-membership-title">
					<?php if ( ! empty( $data['title_main'] ) ) : ?>
						<span class="fees-membership-title-main"><?php echo esc_html( $data['title_main'] ); ?></span>
					<?php endif; ?>
					<?php if ( ! empty( $data['title_accent'] ) ) : ?>
						<span class="fees-membership-title-accent"><?php echo esc_html( $data['title_accent'] ); ?></span>
					<?php endif; ?>
				</h3>

				<div class="fees-membership-body">
					<?php foreach ( $data['paragraphs'] as $paragraph ) : ?>
						<p><?php echo esc_html( $paragraph ); ?></p>
					<?php endforeach; ?>

					<?php if ( ! empty( $data['benefits'] ) ) : ?>
						<ul class="fees-membership-benefits">
							<?php foreach ( $data['benefits'] as $benefit ) : ?>
								<li>
									<span class="fees-membership-check" aria-hidden="true">✓</span>
									<span class="fees-membership-benefit-text"><?php echo esc_html( $benefit ); ?></span>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</div>
			</article>
		<?php else : ?>
			<article class="fees-membership-card fees-membership-card--empty">
				<p><?php esc_html_e( 'No membership plan information is available yet.', 'wsd' ); ?></p>
			</article>
		<?php endif; ?>
	</div>
	<?php
}

/**
 * Build finance options card data from fees membership items.
 *
 * @param array<int, array<string, mixed>> $items Fees items.
 * @return array<string, mixed>|null
 */
function wsd_get_fees_finance_plan_data( $items ) {
	if ( empty( $items ) || ! is_array( $items ) ) {
		return null;
	}

	$item         = $items[0];
	$title        = isset( $item['title'] ) ? (string) $item['title'] : __( 'Dental Finance', 'wsd' );
	$html         = isset( $item['content'] ) ? (string) $item['content'] : '';
	$badge        = __( 'Flexible payment', 'wsd' );
	$paragraphs   = array();
	$disclaimer   = '';
	$cta          = array(
		'label' => __( 'Explore Finance Options', 'wsd' ),
		'url'   => home_url( '/#finance-calculator' ),
	);

	$title        = trim( wp_strip_all_tags( $title ) );
	$title_words  = preg_split( '/\s+/u', $title, -1, PREG_SPLIT_NO_EMPTY );
	$title_main   = '';
	$title_accent = $title;

	if ( is_array( $title_words ) && count( $title_words ) > 1 ) {
		$title_accent = array_pop( $title_words );
		$title_main   = implode( ' ', $title_words ) . ' ';
	}

	if ( preg_match( '/<a\b[^>]*href=["\']([^"\']+)["\'][^>]*>(.*?)<\/a>/is', $html, $link_match ) ) {
		$cta_label = trim( wp_strip_all_tags( html_entity_decode( $link_match[2], ENT_QUOTES | ENT_HTML5, 'UTF-8' ) ) );
		$cta_url   = esc_url_raw( html_entity_decode( $link_match[1], ENT_QUOTES | ENT_HTML5, 'UTF-8' ) );

		if ( $cta_label ) {
			if ( ! $cta_url || false !== stripos( (string) $cta_url, 'claudeusercontent.com' ) ) {
				$cta_url = home_url( '/#finance-calculator' );
			}

			$cta = array(
				'label' => $cta_label,
				'url'   => $cta_url,
			);
		}

		$html = str_replace( $link_match[0], '', $html );
	}

	if ( preg_match_all( '/<p\b[^>]*>(.*?)<\/p>/is', $html, $p_matches ) ) {
		foreach ( $p_matches[1] as $p_html ) {
			$text = trim( wp_strip_all_tags( html_entity_decode( $p_html, ENT_QUOTES | ENT_HTML5, 'UTF-8' ) ) );
			$text = preg_replace( '/\s+/u', ' ', (string) $text );
			if ( '' === $text ) {
				continue;
			}

			if (
				'' === $disclaimer
				&& (
					false !== stripos( $text, 'Financial Conduct Authority' )
					|| false !== stripos( $text, 'Introducer Appointed Representative' )
					|| false !== stripos( $text, 'credit broker' )
				)
			) {
				$disclaimer = $text;
				continue;
			}

			$paragraphs[] = $text;
		}
	}

	if ( empty( $paragraphs ) && '' === $disclaimer && '' === trim( wp_strip_all_tags( $html ) ) ) {
		return null;
	}

	return array(
		'badge'        => $badge,
		'title_main'   => $title_main,
		'title_accent' => $title_accent,
		'paragraphs'   => $paragraphs,
		'disclaimer'   => $disclaimer,
		'cta'          => $cta,
	);
}

/**
 * Render finance options panel (non-accordion). Figma 4562:674.
 *
 * @param string                             $panel_id  Panel id.
 * @param array<int, array<string, mixed>>   $items     Fees items.
 * @param bool                               $is_active Whether panel is visible.
 */
function wsd_render_fees_finance_panel( $panel_id, $items, $is_active = false ) {
	$data = wsd_get_fees_finance_plan_data( $items );
	?>
	<div
		class="fees-accordion-panel fees-finance-panel<?php echo $is_active ? ' is-active' : ''; ?>"
		id="<?php echo esc_attr( $panel_id ); ?>"
		role="tabpanel"
		<?php echo $is_active ? '' : 'hidden'; ?>
	>
		<?php if ( $data ) : ?>
			<article class="fees-finance-card">
				<?php if ( ! empty( $data['badge'] ) ) : ?>
					<p class="fees-finance-badge">
						<span class="fees-finance-badge-dot" aria-hidden="true"></span>
						<span class="fees-finance-badge-label"><?php echo esc_html( $data['badge'] ); ?></span>
					</p>
				<?php endif; ?>

				<h3 class="fees-finance-title">
					<?php if ( ! empty( $data['title_main'] ) ) : ?>
						<span class="fees-finance-title-main"><?php echo esc_html( $data['title_main'] ); ?></span>
					<?php endif; ?>
					<?php if ( ! empty( $data['title_accent'] ) ) : ?>
						<span class="fees-finance-title-accent"><?php echo esc_html( $data['title_accent'] ); ?></span>
					<?php endif; ?>
				</h3>

				<?php if ( ! empty( $data['paragraphs'] ) ) : ?>
					<div class="fees-finance-body">
						<?php foreach ( $data['paragraphs'] as $index => $paragraph ) : ?>
							<p<?php echo 0 === $index ? '' : ' class="fees-finance-body-spaced"'; ?>><?php echo esc_html( $paragraph ); ?></p>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $data['cta']['url'] ) && ! empty( $data['cta']['label'] ) ) : ?>
					<a class="btn btn-primary fees-finance-cta" href="<?php echo esc_url( $data['cta']['url'] ); ?>">
						<span><?php echo esc_html( $data['cta']['label'] ); ?></span>
					</a>
				<?php endif; ?>

				<?php if ( ! empty( $data['disclaimer'] ) ) : ?>
					<p class="fees-finance-disclaimer"><?php echo esc_html( $data['disclaimer'] ); ?></p>
				<?php endif; ?>
			</article>
		<?php else : ?>
			<article class="fees-finance-card fees-finance-card--empty">
				<p><?php esc_html_e( 'No finance information is available yet.', 'wsd' ); ?></p>
			</article>
		<?php endif; ?>
	</div>
	<?php
}

/**
 * Render a fees accordion panel.
 *
 * @param string                             $panel_id      Panel id.
 * @param array<int, array<string, mixed>>   $items         Accordion items.
 * @param bool                               $is_active     Whether this panel is visible.
 * @param string                             $category_slug Category slug.
 */
function wsd_render_fees_accordion_panel( $panel_id, $items, $is_active = false, $category_slug = '' ) {
	if ( wsd_is_fees_consultation_category( $category_slug ) ) {
		wsd_render_fees_consultation_panel( $panel_id, $items, $is_active );
		return;
	}

	if ( wsd_is_fees_membership_category( $category_slug ) ) {
		wsd_render_fees_membership_panel( $panel_id, $items, $is_active );
		return;
	}

	if ( wsd_is_fees_finance_category( $category_slug ) ) {
		wsd_render_fees_finance_panel( $panel_id, $items, $is_active );
		return;
	}

	$theme_uri = get_template_directory_uri();
	?>
	<div
		class="fees-accordion-panel<?php echo $is_active ? ' is-active' : ''; ?>"
		id="<?php echo esc_attr( $panel_id ); ?>"
		role="tabpanel"
		<?php echo $is_active ? '' : 'hidden'; ?>
	>
		<div class="fees-accordion-list">
			<?php if ( ! empty( $items ) ) : ?>
				<?php foreach ( $items as $item ) : ?>
					<div class="fees-accordion-item">
						<button
							type="button"
							class="fees-accordion-trigger"
							aria-expanded="false"
						>
							<span class="fees-accordion-title"><?php echo esc_html( $item['title'] ); ?></span>
							<span class="fees-accordion-icon" aria-hidden="true">
								<img src="<?php echo esc_url( $theme_uri . '/assets/images/fees-accordion-arrow.svg' ); ?>" alt="" width="25" height="25">
							</span>
						</button>
						<div class="fees-accordion-content" hidden>
							<div class="fees-accordion-content-inner">
								<?php if ( ! empty( $item['rows'] ) ) : ?>
									<div class="fees-treatment-table">
										<div class="fees-treatment-rows">
											<?php foreach ( $item['rows'] as $row ) : ?>
												<div class="fees-treatment-row">
													<div class="fees-treatment-copy">
														<span class="fees-treatment-name"><?php echo esc_html( $row['name'] ); ?></span>
														<?php if ( ! empty( $row['description'] ) ) : ?>
															<span class="fees-treatment-desc"><?php echo esc_html( $row['description'] ); ?></span>
														<?php endif; ?>
													</div>
													<span class="fees-treatment-price"><?php echo esc_html( wsd_format_fees_treatment_price( $row['price'] ) ); ?></span>
												</div>
											<?php endforeach; ?>
										</div>
										<?php if ( ! empty( $item['notes'] ) ) : ?>
											<div class="fees-treatment-notes">
												<?php foreach ( $item['notes'] as $note ) : ?>
													<p class="fees-treatment-note"><?php echo esc_html( $note ); ?></p>
												<?php endforeach; ?>
											</div>
										<?php endif; ?>
									</div>
								<?php else : ?>
									<?php echo wp_kses_post( $item['content'] ); ?>
								<?php endif; ?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			<?php else : ?>
				<div class="fees-accordion-item fees-accordion-item--empty">
					<div class="fees-accordion-content-inner">
						<p><?php esc_html_e( 'No items are available in this category yet.', 'wsd' ); ?></p>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
	<?php
}

/**
 * Get the permalink for the Teams page template.
 *
 * @return string
 */
function wsd_get_teams_page_url() {
	return wsd_get_page_url_by_template( 'template-teams.php', home_url( '/#team' ) );
}

/**
 * Normalize an ACF image field or URL string to a URL.
 *
 * @param mixed  $image    Image field value.
 * @param string $fallback Fallback URL.
 * @return string
 */
function wsd_normalize_media_url( $image, $fallback = '' ) {
	if ( is_array( $image ) && ! empty( $image['url'] ) ) {
		return $image['url'];
	}

	if ( is_numeric( $image ) ) {
		$url = wp_get_attachment_image_url( (int) $image, 'full' );
		if ( $url ) {
			return $url;
		}
	}

	if ( is_string( $image ) && '' !== trim( $image ) ) {
		return $image;
	}

	return $fallback;
}

/**
 * Split a doctor or team member title into prefix and name.
 *
 * @param string $title          Post title.
 * @param string $default_prefix Default prefix when none is present.
 * @return array{prefix:string,name:string}
 */
function wsd_parse_team_name_parts( $title, $default_prefix = 'Dr' ) {
	$title = trim( wp_strip_all_tags( (string) $title ) );

	foreach ( array( 'Dr', 'Mr', 'Mrs', 'Ms', 'Miss' ) as $prefix ) {
		if ( 0 === stripos( $title, $prefix . ' ' ) ) {
			return array(
				'prefix' => $prefix,
				'name'   => trim( substr( $title, strlen( $prefix ) ) ),
			);
		}
	}

	return array(
		'prefix' => $default_prefix,
		'name'   => $title,
	);
}

/**
 * Parse a clinical focus string into tag labels.
 *
 * @param mixed $focus_text Focus field value.
 * @return string[]
 */
function wsd_parse_focus_tags( $focus_text ) {
	if ( empty( $focus_text ) ) {
		return array();
	}

	if ( is_array( $focus_text ) ) {
		return array_values(
			array_filter(
				array_map(
					static function ( $item ) {
						return trim( (string) $item );
					},
					$focus_text
				)
			)
		);
	}

	$parts = preg_split( '/\s*[,;|]\s*|\r\n|\n/', (string) $focus_text );

	return array_values(
		array_filter(
			array_map( 'trim', is_array( $parts ) ? $parts : array() )
		)
	);
}

/**
 * Parse an experience label for the modal progress meter width.
 *
 * @param string $experience_text Experience label.
 * @return float
 */
function wsd_parse_experience_meter_percent( $experience_text ) {
	if ( preg_match( '/(\d+(?:\.\d+)?)\s*%/', (string) $experience_text, $matches ) ) {
		return min( 100, max( 0, (float) $matches[1] ) );
	}

	return 37;
}

/**
 * Build modal clinical focus cards from the ACF group field.
 *
 * @param int $post_id Clinical specialist post ID.
 * @return array<int, array{title:string,content:string,experience:string,meter_percent:float}>
 */
function wsd_get_clinical_specialist_focus_cards( $post_id ) {
	$group = function_exists( 'get_field' ) ? get_field( 'our_clinical_specialist', $post_id ) : array();
	$cards = array();

	if ( ! is_array( $group ) ) {
		return $cards;
	}

	for ( $index = 1; $index <= 4; $index++ ) {
		$title       = trim( (string) ( $group[ "ocs_title_{$index}" ] ?? '' ) );
		$content     = trim( (string) ( $group[ "ocs_content_{$index}" ] ?? '' ) );
		$experience  = trim( (string) ( $group[ "ocs_exp_{$index}" ] ?? '' ) );

		if ( '' === $title && '' === $content && '' === $experience ) {
			continue;
		}

		$cards[] = array(
			'title'         => $title,
			'content'       => $content,
			'experience'    => $experience,
			'meter_percent' => wsd_parse_experience_meter_percent( $experience ),
		);
	}

	return $cards;
}

/**
 * Format one clinical specialist post for the Teams page.
 *
 * @param WP_Post $post Clinical specialist post.
 * @return array<string, mixed>
 */
function wsd_format_clinical_specialist( $post ) {
	$post_id       = $post->ID;
	$name_parts    = wsd_parse_team_name_parts( get_the_title( $post ) );
	$image_fallback = get_template_directory_uri() . '/assets/images/team-andrew.png';
	$image         = get_the_post_thumbnail_url( $post, 'full' ) ?: $image_fallback;
	$detail_image  = wsd_normalize_media_url(
		function_exists( 'get_field' ) ? get_field( 'detail_image', $post_id ) : '',
		$image
	);
	$feature_image = wsd_normalize_media_url(
		function_exists( 'get_field' ) ? get_field( 'doctor_details_middle_image', $post_id ) : '',
		$image
	);
	$bio_raw       = has_excerpt( $post ) ? get_the_excerpt( $post ) : wp_strip_all_tags( $post->post_content );
	$bio           = wp_trim_words( $bio_raw, 45, '...' );
	$trusted       = function_exists( 'get_field' ) ? (string) get_field( 'trusted_expertise', $post_id ) : '';
	$journey_raw   = function_exists( 'get_field' ) ? (string) get_field( 'qualifications_&_professional', $post_id ) : '';

	if ( '' !== trim( $journey_raw ) ) {
		$journey_html = wpautop( wp_kses_post( $journey_raw ) );
	} else {
		$journey_html = apply_filters( 'the_content', $post->post_content );
	}

	return array(
		'image'                  => $image,
		'detail_image'           => $detail_image,
		'feature_image'          => $feature_image,
		'role'                   => function_exists( 'get_field' ) ? (string) get_field( 'positions_title', $post_id ) : '',
		'prefix'                 => $name_parts['prefix'],
		'name'                   => $name_parts['name'],
		'gdc'                    => function_exists( 'get_field' ) ? (string) get_field( 'gdc_number', $post_id ) : '',
		'bio'                    => $bio,
		'qualifications'         => function_exists( 'get_field' ) ? (string) get_field( 'doctor_degere', $post_id ) : '',
		'focus'                  => wsd_parse_focus_tags( function_exists( 'get_field' ) ? get_field( 'clinical_focus', $post_id ) : '' ),
		'trusted_expertise_html' => $trusted ? wpautop( wp_kses_post( $trusted ) ) : '',
		'journey_html'           => $journey_html,
		'clinical_focus_cards'   => wsd_get_clinical_specialist_focus_cards( $post_id ),
	);
}

/**
 * Get published clinical specialists for the Teams page.
 *
 * @return array<int, array<string, mixed>>
 */
function wsd_get_clinical_specialists() {
	if ( ! post_type_exists( 'clinical-specialist' ) ) {
		return array();
	}

	$posts = get_posts(
		array(
			'post_type'      => 'clinical-specialist',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => array(
				'menu_order' => 'ASC',
				'title'      => 'ASC',
			),
			'order'          => 'ASC',
		)
	);

	if ( empty( $posts ) ) {
		return array();
	}

	return array_map( 'wsd_format_clinical_specialist', $posts );
}

/**
 * Format one support team post for the Teams page.
 *
 * @param WP_Post $post Support team post.
 * @return array<string, string>
 */
function wsd_format_support_team_member( $post ) {
	$post_id      = $post->ID;
	$terms        = get_the_terms( $post, 'support-team-category' );
	$category     = '';
	$image_fallback = get_template_directory_uri() . '/assets/images/team-kim.png';

	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
		$category = $terms[0]->slug;
	}

	$bio_raw = has_excerpt( $post ) ? get_the_excerpt( $post ) : wp_strip_all_tags( $post->post_content );

	return array(
		'category' => $category,
		'image'    => get_the_post_thumbnail_url( $post, 'full' ) ?: $image_fallback,
		'role'     => function_exists( 'get_field' ) ? (string) get_field( 'position_name', $post_id ) : '',
		'name'     => get_the_title( $post ),
		'gdc'      => function_exists( 'get_field' ) ? (string) get_field( 'gdc_number', $post_id ) : '',
		'bio'      => wp_trim_words( $bio_raw, 45, '...' ),
		'focus'    => function_exists( 'get_field' ) ? (string) get_field( 'clinical_focus', $post_id ) : '',
	);
}

/**
 * Get support team category tabs.
 *
 * @return array<string, string> Slug => label.
 */
function wsd_get_support_team_categories() {
	$categories = array();

	if ( taxonomy_exists( 'support-team-category' ) ) {
		$terms = get_terms(
			array(
				'taxonomy'   => 'support-team-category',
				'hide_empty' => false,
				'orderby'    => 'menu_order',
				'order'      => 'ASC',
			)
		);

		if ( ! is_wp_error( $terms ) ) {
			foreach ( $terms as $term ) {
				$categories[ $term->slug ] = $term->name;
			}
		}
	}

	return $categories;
}

/**
 * Get published support team members for the Teams page.
 *
 * @return array<int, array<string, string>>
 */
function wsd_get_support_team_members() {
	if ( ! post_type_exists( 'support-team' ) ) {
		return array();
	}

	$posts = get_posts(
		array(
			'post_type'      => 'support-team',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => array(
				'menu_order' => 'ASC',
				'title'      => 'ASC',
			),
			'order'          => 'ASC',
		)
	);

	if ( empty( $posts ) ) {
		return array();
	}

	return array_map( 'wsd_format_support_team_member', $posts );
}

/**
 * Get the Teams page hero description from ACF or the page excerpt.
 *
 * @param int $page_id Teams page ID.
 * @return string
 */
function wsd_get_teams_hero_description( $page_id = 0 ) {
	$page_id = $page_id ? (int) $page_id : (int) get_queried_object_id();
	$default = __( 'Our team combines clinical expertise with patient-focused care to create healthy, confident smiles in a calm and welcoming environment.', 'wsd' );

	if ( $page_id && function_exists( 'get_field' ) ) {
		foreach ( array( 'teams_hero_description', 'hero_description' ) as $field_name ) {
			$value = trim( (string) get_field( $field_name, $page_id ) );
			if ( '' !== $value ) {
				return $value;
			}
		}
	}

	if ( $page_id ) {
		$excerpt = trim( (string) get_post_field( 'post_excerpt', $page_id ) );
		if ( '' !== $excerpt ) {
			return $excerpt;
		}
	}

	return $default;
}

/**
 * Build the doctor modal JSON payload from clinical specialists.
 *
 * @param array<int, array<string, mixed>> $clinical_specialists Formatted specialists.
 * @return array<int, array<string, mixed>>
 */
function wsd_get_teams_doctor_modal_payload( $clinical_specialists ) {
	return array_map(
		static function ( $doctor ) {
			return array(
				'image'                  => $doctor['image'] ?? '',
				'detail_image'           => $doctor['detail_image'] ?? ( $doctor['image'] ?? '' ),
				'feature_image'          => $doctor['feature_image'] ?? ( $doctor['image'] ?? '' ),
				'role'                   => $doctor['role'] ?? '',
				'prefix'                 => $doctor['prefix'] ?? '',
				'name'                   => $doctor['name'] ?? '',
				'gdc'                    => $doctor['gdc'] ?? '',
				'bio'                    => $doctor['bio'] ?? '',
				'qualifications'         => $doctor['qualifications'] ?? '',
				'focus'                  => $doctor['focus'] ?? array(),
				'trusted_expertise_html' => $doctor['trusted_expertise_html'] ?? '',
				'journey_html'           => $doctor['journey_html'] ?? '',
				'clinical_focus_cards'   => $doctor['clinical_focus_cards'] ?? array(),
			);
		},
		$clinical_specialists
	);
}

/**
 * Format a phone number for display.
 *
 * @param string|int $phone Raw phone value.
 * @return string
 */
function wsd_format_phone_number( $phone ) {
	$raw = trim( (string) $phone );

	if ( '' === $raw ) {
		return '';
	}

	if ( preg_match( '/\s/', $raw ) ) {
		return $raw;
	}

	$digits = preg_replace( '/\D+/', '', $raw );

	if ( str_starts_with( $digits, '44' ) ) {
		$digits = '0' . substr( $digits, 2 );
	}

	if ( 11 === strlen( $digits ) && str_starts_with( $digits, '0' ) ) {
		return substr( $digits, 0, 5 ) . ' ' . substr( $digits, 5, 3 ) . ' ' . substr( $digits, 8 );
	}

	return $raw;
}

/**
 * Build a tel: URI from a phone number.
 *
 * @param string|int $phone Raw phone value.
 * @return string
 */
function wsd_get_phone_tel_uri( $phone ) {
	$digits = preg_replace( '/\D+/', '', (string) $phone );

	if ( '' === $digits ) {
		return '';
	}

	if ( str_starts_with( $digits, '0' ) ) {
		$digits = '44' . substr( $digits, 1 );
	}

	return 'tel:+' . $digits;
}

/**
 * Parse opening hours textarea into trimmed lines.
 *
 * @param string $textarea Opening hours field value.
 * @return string[]
 */
function wsd_parse_opening_hours_lines( $textarea ) {
	$lines = preg_split( '/\r\n|\r|\n/', (string) $textarea );
	$lines = array_map( 'trim', $lines );
	$lines = array_filter( $lines, 'strlen' );

	return array_values( $lines );
}

/**
 * Render the global floating Contact us side tab.
 */
function wsd_render_call_us_tab() {
	if ( is_page_template( 'template-contact.php' ) || is_page_template( 'template-dental-referrals.php' ) ) {
		return;
	}

	$contact_url = wsd_get_contact_page_url();
	$theme_uri   = get_template_directory_uri();
	?>
	<div class="call-us-tab">
		<a href="<?php echo esc_url( $contact_url ); ?>" class="btn-call-us">
			<span class="call-text"><?php esc_html_e( 'Contact us', 'wsd' ); ?></span>
			<img src="<?php echo esc_url( $theme_uri . '/assets/images/phone-icon1.svg' ); ?>" alt="" class="phone-icon" width="24" height="24">
		</a>
	</div>
	<?php
}

/**
 * Render the dental referrals mobile accordion toggle icons.
 */
function wsd_dental_referrals_accordion_icon() {
	?>
	<span class="dental-referrals-accordion-icon" aria-hidden="true">
		<svg class="dental-referrals-accordion-icon-svg dental-referrals-accordion-icon-plus" xmlns="http://www.w3.org/2000/svg" width="9" height="9" viewBox="0 0 9 9" fill="none" aria-hidden="true" focusable="false">
			<path d="M3.75 3.75V0H5V3.75H8.75V5H5V8.75H3.75V5H0V3.75H3.75Z" fill="currentColor"/>
		</svg>
		<svg class="dental-referrals-accordion-icon-svg dental-referrals-accordion-icon-cross" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none" aria-hidden="true" focusable="false">
			<path d="M6.6158 7.5L3.96415 4.84835L4.84803 3.96447L7.49968 6.61612L10.1513 3.96447L11.0352 4.84835L8.38357 7.5L11.0352 10.1517L10.1513 11.0355L7.49968 8.38388L4.84803 11.0355L3.96415 10.1517L6.6158 7.5Z" fill="currentColor"/>
		</svg>
	</span>
	<?php
}


function allow_svg_uploads( $mimes ) {
    $mimes['svg'] = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';
    return $mimes;
}
add_filter( 'upload_mimes', 'allow_svg_uploads' );





