<?php
/**
 * Template Name: Fees Page Template
 *
 * @package wsd
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

if ( have_posts() ) {
	the_post();
}

$theme_uri                = get_template_directory_uri();
$fees_page_id             = get_the_ID();
$fees_hero_alt            = __( 'Family smiling after dental care', 'wsd' );
$fees_categories          = wsd_get_fees_membership_categories();
$fees_items_by_category   = wsd_get_fees_membership_items_grouped();

if ( empty( $fees_categories ) && ! empty( $fees_items_by_category ) ) {
	foreach ( array_keys( $fees_items_by_category ) as $slug ) {
		$term = get_term_by( 'slug', $slug, 'fees-membership-category' );
		if ( $term && ! is_wp_error( $term ) ) {
			$fees_categories[] = $term;
			continue;
		}

		$fees_categories[] = (object) array(
			'term_id' => 0,
			'slug'    => $slug,
			'name'    => ucwords( str_replace( array( '-', '_' ), ' ', $slug ) ),
		);
	}
}

$fees_hero_image = wsd_get_fees_hero_image_url( $fees_page_id );

if ( $fees_page_id && has_post_thumbnail( $fees_page_id ) ) {
	$thumbnail_alt = get_post_meta( (int) get_post_thumbnail_id( $fees_page_id ), '_wp_attachment_image_alt', true );
	if ( $thumbnail_alt ) {
		$fees_hero_alt = $thumbnail_alt;
	}
}

?>

<main id="main" class="site-main fees-page-main">

	<section class="fees-hero-page" aria-labelledby="fees-hero-heading">
		<div class="fees-hero-inner">
			<div class="fees-hero-content-col">
				<div class="fees-hero-copy">
					<h1 id="fees-hero-heading" class="fees-hero-title hero-title">
						<span class="fees-hero-title-main"><?php esc_html_e( 'Fees & Membership ', 'wsd' ); ?></span>
						<span class="fees-hero-title-accent"><?php esc_html_e( 'Plans', 'wsd' ); ?></span>
					</h1>
					<p class="fees-hero-description hero-description">
						<?php esc_html_e( 'Clear, honest pricing with no surprises. Every patient receives a written cost estimate before any treatment begins. We also offer flexible finance and membership options to suit every budget.', 'wsd' ); ?>
					</p>
				</div>
				<div class="hero-buttons">
					<a href="<?php echo esc_url( home_url( '/#book-appointment' ) ); ?>" class="btn btn-primary"><span><?php esc_html_e( 'Book an appointment', 'wsd' ); ?></span></a>
					<a href="<?php echo esc_url( home_url( '/#smile-gallery' ) ); ?>" class="btn btn-secondary"><?php esc_html_e( 'Smile Gallery', 'wsd' ); ?></a>
				</div>
			</div>
			<div class="fees-hero-image-col">
				<div class="fees-hero-image-frame hero-image-wrapper">
					<?php
					if ( $fees_page_id && has_post_thumbnail( $fees_page_id ) ) {
						echo wp_get_attachment_image(
							(int) get_post_thumbnail_id( $fees_page_id ),
							'full',
							false,
							array(
								'class'    => 'fees-hero-img',
								'alt'      => $fees_hero_alt,
								'loading'  => 'eager',
								'decoding' => 'async',
							)
						);
					} else {
						?>
					<img
						src="<?php echo esc_url( $fees_hero_image ); ?>"
						alt="<?php echo esc_attr( $fees_hero_alt ); ?>"
						class="fees-hero-img"
						width="840"
						height="788"
						loading="eager"
						decoding="async"
					>
						<?php
					}
					?>
				</div>
			</div>
		</div>
	</section>

	<section class="fees-info-section" aria-labelledby="fees-info-heading">
		<div class="fees-info-inner">
			<div class="fees-info-header">
				<h2 id="fees-info-heading" class="fees-info-title">
					<span class="fees-info-title-main"><?php esc_html_e( 'Consultation, Membership & Payment ', 'wsd' ); ?></span>
					<span class="fees-info-title-accent"><?php esc_html_e( 'Information', 'wsd' ); ?></span>
				</h2>
				<p class="fees-info-subtitle">
					<?php esc_html_e( 'Learn about consultation services, membership plans, fees, and flexible financing options.', 'wsd' ); ?>
				</p>
			</div>

			<?php if ( ! empty( $fees_categories ) ) : ?>
				<div class="fees-tabs" role="tablist" aria-label="<?php esc_attr_e( 'Fees and membership categories', 'wsd' ); ?>">
					<span class="fees-tabs-indicator" aria-hidden="true"></span>
					<?php foreach ( $fees_categories as $index => $category ) : ?>
						<?php
						$is_active = ( 0 === $index );
						$tab_id    = 'fees-tab-' . $category->slug;
						$panel_id  = 'fees-panel-' . $category->slug;
						$icon_url  = wsd_get_fees_membership_tab_icon_url( $category, $index );
						?>
						<button
							type="button"
							class="fees-tab<?php echo $is_active ? ' is-active' : ''; ?>"
							role="tab"
							aria-selected="<?php echo $is_active ? 'true' : 'false'; ?>"
							aria-controls="<?php echo esc_attr( $panel_id ); ?>"
							id="<?php echo esc_attr( $tab_id ); ?>"
							data-fees-tab="<?php echo esc_attr( $category->slug ); ?>"
							<?php echo $is_active ? '' : 'tabindex="-1"'; ?>
						>
							<span class="fees-tab-icon" aria-hidden="true">
								<img src="<?php echo esc_url( $icon_url ); ?>" alt="" width="24" height="24">
							</span>
							<span class="fees-tab-label"><?php echo esc_html( $category->name ); ?></span>
						</button>
					<?php endforeach; ?>
				</div>

				<div class="fees-panels">
					<?php foreach ( $fees_categories as $index => $category ) : ?>
						<?php
						$panel_id = 'fees-panel-' . $category->slug;
						$items    = $fees_items_by_category[ $category->slug ] ?? array();
						wsd_render_fees_accordion_panel( $panel_id, $items, 0 === $index );
						?>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>

</main>

<?php
get_footer();
