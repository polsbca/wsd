<?php
/**
 * Template Name: Smile Gallery Page Template
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

$theme_uri              = get_template_directory_uri();
$page_id                = get_the_ID();
$hero_alt               = __( 'Patient smiling after dental treatment', 'wsd' );
$gallery_cases          = wsd_get_smile_gallery_slides( $page_id );
$gallery_categories     = wsd_get_smile_gallery_categories();
$hero_image             = wsd_get_smile_gallery_hero_image_url( $page_id );

if ( $page_id && has_post_thumbnail( $page_id ) ) {
	$thumbnail_alt = get_post_meta( (int) get_post_thumbnail_id( $page_id ), '_wp_attachment_image_alt', true );
	if ( $thumbnail_alt ) {
		$hero_alt = $thumbnail_alt;
	}
}

$gallery_title_defaults = array(
	'desktop' => array(
		'light'  => __( 'Smile ', 'wsd' ),
		'accent' => __( 'Gallery', 'wsd' ),
	),
	'mobile'  => array(
		'light'  => __( 'All Treatment', 'wsd' ),
		'accent' => __( ' Results', 'wsd' ),
	),
	'tablet'  => array(
		'light'  => __( 'All ', 'wsd' ),
		'accent' => __( 'Treatments', 'wsd' ),
	),
);

$split_gallery_title = static function ( $text ) {
	$text = trim( wp_strip_all_tags( $text ) );
	$pos  = strrpos( $text, ' ' );

	if ( false === $pos ) {
		return array(
			'light'  => '',
			'accent' => $text,
		);
	}

	return array(
		'light'  => substr( $text, 0, $pos + 1 ),
		'accent' => substr( $text, $pos + 1 ),
	);
};

$gallery_title_for_label = static function ( $label ) use ( $split_gallery_title ) {
	$parts = $split_gallery_title( $label );

	return array(
		'desktop' => $parts,
		'mobile'  => $parts,
		'tablet'  => $parts,
	);
};

$render_gallery_title_attrs = static function ( $titles ) {
	$attrs = array();

	foreach ( array( 'desktop', 'mobile', 'tablet' ) as $viewport ) {
		$attrs[] = sprintf(
			'data-title-%1$s-light="%2$s"',
			esc_attr( $viewport ),
			esc_attr( $titles[ $viewport ]['light'] ?? '' )
		);
		$attrs[] = sprintf(
			'data-title-%1$s-accent="%2$s"',
			esc_attr( $viewport ),
			esc_attr( $titles[ $viewport ]['accent'] ?? '' )
		);
	}

	return implode( ' ', $attrs );
};

?>

<main id="main" class="site-main smile-gallery-page-main">

	<section class="smile-gallery-hero-page" aria-labelledby="smile-gallery-hero-heading">
		<div class="smile-gallery-hero-inner">
			<div class="smile-gallery-hero-content-col">
				<div class="smile-gallery-hero-copy">
					<h1 id="smile-gallery-hero-heading" class="smile-gallery-hero-title hero-title">
						<span class="smile-gallery-hero-title-main"><?php esc_html_e( 'Smile ', 'wsd' ); ?></span>
						<span class="smile-gallery-hero-title-accent"><?php esc_html_e( 'Gallery', 'wsd' ); ?></span>
					</h1>
					<p class="smile-gallery-hero-description hero-description">
						<?php esc_html_e( 'Every case is a real patient, a real result. Drag the slider on any card to reveal the before & after. Tap a card for full case details.', 'wsd' ); ?>
					</p>
				</div>
				<div class="hero-buttons">
					<a href="<?php echo esc_url( wsd_get_contact_page_url() ); ?>" class="btn btn-primary hero-book-appointment-btn"><span><?php esc_html_e( 'Book an appointment', 'wsd' ); ?></span></a>
					<a href="#smile-gallery-cases" class="btn btn-secondary smile-gallery-hero-cta">
						<span class="smile-gallery-section-heading-desktop"><?php esc_html_e( 'Smile Gallery', 'wsd' ); ?></span>
						<span class="smile-gallery-section-heading-tablet"><?php esc_html_e( 'Fees & Membership', 'wsd' ); ?></span>
						<span class="smile-gallery-section-heading-mobile"><?php esc_html_e( 'Fees & Membership', 'wsd' ); ?></span>
					</a>
				</div>
			</div>
			<div class="smile-gallery-hero-image-col">
				<div class="smile-gallery-hero-image-frame hero-image-wrapper">
					<?php
					if ( $page_id && has_post_thumbnail( $page_id ) ) {
						echo wp_get_attachment_image(
							(int) get_post_thumbnail_id( $page_id ),
							'full',
							false,
							array(
								'class'    => 'smile-gallery-hero-img',
								'alt'      => $hero_alt,
								'loading'  => 'eager',
								'decoding' => 'async',
							)
						);
					} else {
						?>
					<img
						src="<?php echo esc_url( $hero_image ); ?>"
						alt="<?php echo esc_attr( $hero_alt ); ?>"
						class="smile-gallery-hero-img"
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

	<?php if ( ! empty( $gallery_cases ) ) : ?>
	<section
		id="smile-gallery-cases"
		class="smile-gallery-cases-section"
		style="--smile-gallery-track-height: <?php echo esc_attr( max( 1, count( $gallery_cases ) ) * 75 ); ?>vh;"
		aria-labelledby="smile-gallery-section-heading"
		data-smile-gallery-total="<?php echo esc_attr( count( $gallery_cases ) ); ?>"
		data-gallery-title-defaults="<?php echo esc_attr( wp_json_encode( $gallery_title_defaults ) ); ?>"
	>
		<div class="smile-gallery-cases-sticky">
			<div class="smile-gallery-cases-inner">
				<div class="smile-gallery-cases-header">
					<div class="smile-gallery-section-badge">
						<h2 id="smile-gallery-section-heading" class="smile-gallery-section-title" data-smile-gallery-title>
							<span class="smile-gallery-section-heading-desktop">
								<span class="light" data-title-part="light"><?php echo esc_html( $gallery_title_defaults['desktop']['light'] ); ?></span><span class="accent" data-title-part="accent"><?php echo esc_html( $gallery_title_defaults['desktop']['accent'] ); ?></span>
							</span>
							<span class="smile-gallery-section-heading-mobile">
								<span class="light" data-title-part="light"><?php echo esc_html( $gallery_title_defaults['mobile']['light'] ); ?></span><span class="accent" data-title-part="accent"><?php echo esc_html( $gallery_title_defaults['mobile']['accent'] ); ?></span>
							</span>
							<span class="smile-gallery-section-heading-tablet">
								<span class="light" data-title-part="light"><?php echo esc_html( $gallery_title_defaults['tablet']['light'] ); ?></span><span class="accent" data-title-part="accent"><?php echo esc_html( $gallery_title_defaults['tablet']['accent'] ); ?></span>
							</span>
						</h2>
					</div>

					<div class="smile-gallery-filters smile-gallery-filters--desktop" role="tablist" aria-label="<?php esc_attr_e( 'Smile gallery categories', 'wsd' ); ?>">
					<button
						type="button"
						class="smile-gallery-filter is-active"
						role="tab"
						aria-selected="true"
						data-filter="all"
						<?php echo $render_gallery_title_attrs( $gallery_title_defaults ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					>
						<span><?php esc_html_e( 'All', 'wsd' ); ?></span>
					</button>
					<?php foreach ( $gallery_categories as $category ) : ?>
						<?php $category_titles = $gallery_title_for_label( $category->name ); ?>
						<button
							type="button"
							class="smile-gallery-filter"
							role="tab"
							aria-selected="false"
							data-filter="<?php echo esc_attr( $category->slug ); ?>"
							data-label="<?php echo esc_attr( $category->name ); ?>"
							<?php echo $render_gallery_title_attrs( $category_titles ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						>
							<span><?php echo esc_html( $category->name ); ?></span>
						</button>
					<?php endforeach; ?>
					</div>

					<div class="smile-gallery-mobile-filters">
						<button
							type="button"
							class="smile-gallery-filter smile-gallery-mobile-all is-active"
							data-filter="all"
							aria-pressed="true"
							<?php echo $render_gallery_title_attrs( $gallery_title_defaults ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						>
							<span><?php esc_html_e( 'All', 'wsd' ); ?></span>
						</button>
						<button
							type="button"
							class="smile-gallery-mobile-browse"
							aria-expanded="false"
							aria-controls="smile-gallery-filter-panel"
						>
							<span class="smile-gallery-mobile-browse-label"><?php esc_html_e( 'Browse by Filters', 'wsd' ); ?></span>
							<img src="<?php echo esc_url( $theme_uri . '/assets/images/filter-equalizer.svg' ); ?>" alt="" width="14" height="14" class="smile-gallery-mobile-browse-icon">
						</button>
					</div>
				</div>

				<div
					id="smile-gallery-filter-panel"
					class="smile-gallery-filter-panel"
					role="dialog"
					aria-modal="true"
					aria-labelledby="smile-gallery-filter-panel-title"
					hidden
				>
					<button type="button" class="smile-gallery-filter-panel-backdrop" aria-label="<?php esc_attr_e( 'Close filters', 'wsd' ); ?>"></button>
					<div class="smile-gallery-filter-panel-sheet">
						<div class="smile-gallery-filter-panel-header">
							<h3 id="smile-gallery-filter-panel-title" class="smile-gallery-filter-panel-title"><?php esc_html_e( 'Browse by Filters', 'wsd' ); ?></h3>
							<button type="button" class="smile-gallery-filter-panel-close" aria-label="<?php esc_attr_e( 'Close', 'wsd' ); ?>">&times;</button>
						</div>
						<div class="smile-gallery-filter-panel-options" role="listbox" aria-label="<?php esc_attr_e( 'Filter categories', 'wsd' ); ?>">
							<?php foreach ( $gallery_categories as $category ) : ?>
								<?php $category_titles = $gallery_title_for_label( $category->name ); ?>
								<button
									type="button"
									class="smile-gallery-filter-panel-option"
									role="option"
									data-filter="<?php echo esc_attr( $category->slug ); ?>"
									data-label="<?php echo esc_attr( $category->name ); ?>"
									<?php echo $render_gallery_title_attrs( $category_titles ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								>
									<span><?php echo esc_html( $category->name ); ?></span>
								</button>
							<?php endforeach; ?>
						</div>
					</div>
				</div>

				<div class="smile-gallery-cases-body" data-smile-gallery-cases>
					<div class="smile-gallery-cases-row">
						<div class="smile-gallery-cases-main">
							<div class="smile-gallery-page-images">
								<div class="gallery-interactive-wrapper smile-gallery-page-interactive">
									<?php foreach ( $gallery_cases as $case_index => $gallery_case ) : ?>
										<?php
										$category_slugs = ! empty( $gallery_case['category_slugs'] ) ? implode( ' ', array_map( 'sanitize_title', $gallery_case['category_slugs'] ) ) : '';
										?>
										<div
											class="gallery-slide smile-gallery-page-slide <?php echo ( 0 === $case_index ) ? 'active' : ''; ?>"
											data-index="<?php echo esc_attr( $case_index ); ?>"
											data-category-slugs="<?php echo esc_attr( $category_slugs ); ?>"
										>
											<div class="gallery-image-pair-container">
												<div class="gallery-card before-card">
													<div class="gallery-card-image-wrapper">
														<img src="<?php echo esc_url( $gallery_case['before_image'] ); ?>" alt="<?php esc_attr_e( 'Before treatment', 'wsd' ); ?>" class="gallery-img before-img-crop1">
													</div>
													<div class="gallery-card-label"><?php esc_html_e( 'Before', 'wsd' ); ?></div>
												</div>
												<div class="gallery-connecting-arrow">
													<img src="<?php echo esc_url( $theme_uri . '/assets/images/gallery_arrow.svg' ); ?>" alt="" class="arrow-vector-svg">
												</div>
												<div class="gallery-card after-card">
													<div class="gallery-card-image-wrapper">
														<img src="<?php echo esc_url( $gallery_case['after_image'] ); ?>" alt="<?php esc_attr_e( 'After treatment', 'wsd' ); ?>" class="gallery-img after-img-crop1">
													</div>
													<div class="gallery-card-label"><?php esc_html_e( 'After', 'wsd' ); ?></div>
												</div>
											</div>
										</div>
									<?php endforeach; ?>
								</div>
							</div>

							<div class="smile-gallery-page-info">
								<div class="gallery-info-wrapper">
									<div class="gallery-details-grid smile-gallery-page-details-grid">
										<?php foreach ( $gallery_cases as $case_index => $gallery_case ) : ?>
											<?php
											$category_slugs = ! empty( $gallery_case['category_slugs'] ) ? implode( ' ', array_map( 'sanitize_title', $gallery_case['category_slugs'] ) ) : '';
											?>
											<div
												class="gallery-details-data smile-gallery-page-details <?php echo ( 0 === $case_index ) ? 'active' : ''; ?>"
												data-index="<?php echo esc_attr( $case_index ); ?>"
												data-category-slugs="<?php echo esc_attr( $category_slugs ); ?>"
											>
												<div class="smile-gallery-page-details-row">
													<div class="gallery-detail-card">
														<span class="detail-label"><?php esc_html_e( 'Treatment', 'wsd' ); ?></span>
														<span class="detail-value"><?php echo esc_html( $gallery_case['treatment'] ); ?></span>
													</div>
													<div class="gallery-detail-card">
														<span class="detail-label"><?php esc_html_e( 'Main Concern', 'wsd' ); ?></span>
														<span class="detail-value"><?php echo esc_html( $gallery_case['concern'] ); ?></span>
													</div>
												</div>
												<div class="smile-gallery-page-details-row">
													<div class="gallery-detail-card">
														<span class="detail-label"><?php esc_html_e( 'Duration', 'wsd' ); ?></span>
														<span class="detail-value"><?php echo esc_html( $gallery_case['duration'] ); ?></span>
													</div>
													<div class="gallery-detail-card">
														<span class="detail-label"><?php esc_html_e( 'Visits', 'wsd' ); ?></span>
														<span class="detail-value"><?php echo esc_html( $gallery_case['visits'] ); ?></span>
													</div>
												</div>
											</div>
										<?php endforeach; ?>
									</div>

									<div class="gallery-btn-wrapper smile-gallery-view-btn-wrap">
										<a href="#smile-gallery-cases" class="btn btn-gallery-action smile-gallery-view-btn"><?php esc_html_e( 'View Smile Gallery', 'wsd' ); ?></a>
									</div>

									<div class="gallery-slider-dots smile-gallery-page-dots" aria-hidden="true"></div>
								</div>
							</div>
						</div>

						<div class="gallery-scroll-indicator-container smile-gallery-page-indicator" aria-hidden="true">
							<div class="gallery-scroll-indicator-track"></div>
							<div class="gallery-scroll-indicator-handle"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php endif; ?>

</main>

<?php
get_footer();
