<?php
/**
 * Template Name: Invisalign Page Template
 *
 * @package wsd
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$theme_uri     = get_template_directory_uri();
$fees_url      = function_exists( 'wsd_get_fees_page_url' ) ? wsd_get_fees_page_url() : home_url( '/fees/' );
$gallery_url   = function_exists( 'wsd_get_smile_gallery_page_url' ) ? wsd_get_smile_gallery_page_url() : home_url( '/smile-gallery/' );
$book_url      = home_url( '/#book-appointment' );
$page_id       = (int) get_queried_object_id();
if ( ! $page_id ) {
	$page_id = (int) get_the_ID();
}
$hero_alt      = __( 'Patient smiling after Invisalign treatment', 'wsd' );
$hero_image_id = $page_id ? (int) get_post_thumbnail_id( $page_id ) : 0;

if ( $hero_image_id ) {
	$thumbnail_alt = get_post_meta( $hero_image_id, '_wp_attachment_image_alt', true );
	if ( $thumbnail_alt ) {
		$hero_alt = $thumbnail_alt;
	}
}

$invisalign_fees = array(
	array(
		'title' => 'Invisalign Comprehensive',
		'desc'  => 'Full arch correction for complex cases — unlimited refinements included',
		'price' => 'From £390',
	),
	array(
		'title' => 'Invisalign Moderate',
		'desc'  => 'Mid-range cases with up to 26 aligner sets per arch',
		'price' => 'From £390',
	),
	array(
		'title' => 'Invisalign Lite',
		'desc'  => 'Mild corrections — up to 14 aligner sets, ideal for minor crowding',
		'price' => 'From £390',
	),
	array(
		'title' => 'Invisalign Go',
		'desc'  => 'Front six teeth only — perfect for minor aesthetic concerns',
		'price' => 'From £390',
	),
	array(
		'title' => 'iTero Digital Scan',
		'desc'  => 'Includes 3D preview of your final result (redeemable against treatment)',
		'price' => 'From £390',
	),
	array(
		'title' => 'Retainer (post-treatment)',
		'desc'  => 'Essential for maintaining your new smile — included in all comprehensive plans',
		'price' => 'From £390',
	),
);

$about_panels = array(
	'process'  => array(
		array(
			'num'   => '1',
			'title' => 'Free Consultation & Assessment',
			'desc'  => 'We assess your teeth, discuss your goals, and confirm whether Invisalign is the right option for you — completely free of charge.',
		),
		array(
			'num'   => '2',
			'title' => 'Digital Scan & Treatment Plan',
			'desc'  => 'Using our iTero scanner, we take precise 3D impressions and generate a digital preview of your final smile before treatment begins.',
		),
		array(
			'num'   => '3',
			'title' => 'Wearing Your Aligners',
			'desc'  => 'You receive your custom aligner sets and wear each for approximately two weeks, 20–22 hours per day. Progress check-ins every 6–8 weeks.',
		),
		array(
			'num'   => '4',
			'title' => 'Retention & Long-Term Results',
			'desc'  => 'Once your treatment is complete, we fit you with a retainer to maintain your new smile for the long term.',
		),
	),
	'who'      => array(
		array(
			'title' => 'Teeth Crowding',
			'image' => $theme_uri . '/assets/images/invisalign/invisalign-who-teeth-crowding.png',
			'desc'  => 'For overlapping teeth caused by limited jaw space.',
		),
		array(
			'title' => 'Teeth Gaps',
			'image' => $theme_uri . '/assets/images/invisalign/invisalign-who-teeth-gaps.png',
			'desc'  => 'Visible gaps between one or more teeth.',
		),
		array(
			'title' => 'Bite Issues',
			'image' => $theme_uri . '/assets/images/invisalign/invisalign-who-bite-issues.png',
			'desc'  => 'Improper tooth and jaw alignment when biting down.',
		),
		array(
			'title' => 'Shifted Teeth',
			'image' => $theme_uri . '/assets/images/invisalign/invisalign-who-shifted-teeth.png',
			'desc'  => 'Changes in tooth alignment following braces.',
		),
	),
	'benefits' => array(
		array(
			'num'   => '1',
			'title' => 'Nearly Invisible',
			'desc'  => 'Clear aligners mean most people won\'t notice you\'re in treatment — ideal for professional and social settings.',
		),
		array(
			'num'   => '2',
			'title' => 'Removable',
			'desc'  => 'Take them out to eat anything you like and to brush and floss with ease — no dietary restrictions.',
		),
		array(
			'num'   => '3',
			'title' => 'Comfortable',
			'desc'  => 'Smooth BPA-free plastic with no metal wires or brackets — far fewer irritation-related appointments.',
		),
		array(
			'num'   => '4',
			'title' => 'Predictable Results',
			'desc'  => 'Your digital treatment plan maps every tooth movement in advance so you can see the outcome before you commit.',
		),
	),
);

$treatment_points = array(
	'Treats crowding, spacing, overbite, underbite & crossbite',
	'Removable for eating, brushing and flossing',
	'Virtually invisible — most people will not notice',
	'Digital preview of your final smile before you start',
);

$process_steps = array(
	array(
		'label' => 'Crooked teeth',
		'image' => $theme_uri . '/assets/images/invisalign/invisalign-process-1.png',
	),
	array(
		'label' => 'Aligner fitted',
		'image' => $theme_uri . '/assets/images/invisalign/invisalign-process-2.png',
	),
	array(
		'label' => 'Straightened teeth',
		'image' => $theme_uri . '/assets/images/invisalign/invisalign-process-3.png',
	),
);

$compare_columns = array(
	array(
		'label'  => 'Invisalign',
		'image'  => $theme_uri . '/assets/images/invisalign/invisalign-compare-left.png',
		'icon'   => $theme_uri . '/assets/images/invisalign/invisalign-check-white.svg',
		'side'   => 'left',
		'points' => array( 'Removable', 'Invisible', 'Pain-free' ),
	),
	array(
		'label'  => 'Braces',
		'image'  => $theme_uri . '/assets/images/invisalign/invisalign-compare-right.png',
		'icon'   => $theme_uri . '/assets/images/invisalign/invisalign-x-white.svg',
		'side'   => 'right',
		'points' => array( 'Removable', 'Invisible', 'Pain-free' ),
	),
);

$more_services_query = new WP_Query(
	array(
		'post_type'      => 'services',
		'posts_per_page' => 6,
		'post_status'    => 'publish',
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
		'tax_query'      => array(
			array(
				'taxonomy' => 'service_category',
				'field'    => 'slug',
				'terms'    => array( 'general-dentistry', 'all-about-general-dentistry-services' ),
			),
		),
	)
);

if ( ! $more_services_query->have_posts() ) {
	$more_services_query = new WP_Query(
		array(
			'post_type'      => 'services',
			'posts_per_page' => 6,
			'post_status'    => 'publish',
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
		)
	);
}

get_header();
?>
<main id="main" class="site-main invisalign-main">

	<!-- Hero -->
	<section class="invisalign-hero">
		<div class="invisalign-hero-inner">
			<div class="invisalign-hero-content">
				<div class="invisalign-hero-copy">
					<h1 class="invisalign-hero-title">
						Invisalign Clear <span class="accent">Aligners</span>
					</h1>
					<p class="invisalign-hero-desc">
						Straighten your teeth discreetly with removable, virtually invisible aligners, no wires, no brackets, just a confident smile at every stage of your journey.
					</p>
				</div>
				<div class="invisalign-hero-stats" aria-label="<?php esc_attr_e( 'Practice highlights', 'wsd' ); ?>">
					<div class="invisalign-hero-stat">
						<span class="invisalign-hero-stat-value">4.5</span>
						<p class="invisalign-hero-stat-label">
							<span class="gold-label"><?php esc_html_e( 'Google rating', 'wsd' ); ?></span>
							<?php esc_html_e( 'Based on 200+ reviews', 'wsd' ); ?>
						</p>
					</div>
					<div class="invisalign-hero-stat">
						<span class="invisalign-hero-stat-value">15+</span>
						<p class="invisalign-hero-stat-label"><?php esc_html_e( 'Clinical Dental Excellence', 'wsd' ); ?></p>
					</div>
					<div class="invisalign-hero-stat">
						<span class="invisalign-hero-stat-value">GDC</span>
						<p class="invisalign-hero-stat-label"><?php esc_html_e( 'Fully regulated by the General Dental Council', 'wsd' ); ?></p>
					</div>
				</div>
				<div class="invisalign-hero-ctas">
					<a href="<?php echo esc_url( $book_url ); ?>" class="btn btn-primary invisalign-btn"><?php esc_html_e( 'Book an appointment', 'wsd' ); ?></a>
					<a href="<?php echo esc_url( $fees_url ); ?>" class="btn btn-secondary invisalign-btn"><?php esc_html_e( 'Fees & Membership', 'wsd' ); ?></a>
				</div>
			</div>
			<div class="invisalign-hero-image-col">
				<div class="invisalign-hero-image-wrapper">
					<?php
					if ( $hero_image_id ) {
						echo wp_get_attachment_image(
							$hero_image_id,
							'full',
							false,
							array(
								'class'    => 'invisalign-hero-img',
								'alt'      => $hero_alt,
								'loading'  => 'eager',
								'decoding' => 'async',
							)
						);
					} elseif ( has_post_thumbnail() ) {
						the_post_thumbnail(
							'full',
							array(
								'class'    => 'invisalign-hero-img',
								'alt'      => $hero_alt,
								'loading'  => 'eager',
								'decoding' => 'async',
							)
						);
					} else {
						?>
						<img
							src="<?php echo esc_url( $theme_uri . '/assets/images/invisalign/invisalign-hero.png' ); ?>"
							alt="<?php echo esc_attr( $hero_alt ); ?>"
							class="invisalign-hero-img"
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

	<!-- All About Invisible Treatment -->
	<section class="invisalign-about-section" id="invisalign-about">
		<div class="invisalign-about-inner">
			<div class="invisalign-about-header">
				<div class="invisalign-section-badge">
					<h2 class="invisalign-section-title">
						All About <span class="accent">invisible treatment</span>
					</h2>
				</div>
			</div>

			<p class="invisalign-about-lead">
				<?php esc_html_e( 'Invisalign straightens teeth discreetly with clear, removable aligners — planned digitally so you can see your new smile before treatment begins.', 'wsd' ); ?>
			</p>

			<div class="invisalign-about-body">
				<div class="invisalign-about-tabs" role="tablist" aria-label="<?php esc_attr_e( 'Invisalign topics', 'wsd' ); ?>">
					<button type="button" class="invisalign-tab-btn active" role="tab" aria-selected="true" data-tab="process"><?php esc_html_e( 'Process', 'wsd' ); ?></button>
					<button type="button" class="invisalign-tab-btn" role="tab" aria-selected="false" data-tab="who"><?php esc_html_e( 'Who is it for', 'wsd' ); ?></button>
					<button type="button" class="invisalign-tab-btn" role="tab" aria-selected="false" data-tab="benefits"><?php esc_html_e( 'Key Benefits', 'wsd' ); ?></button>
				</div>

				<?php foreach ( $about_panels as $panel_key => $cards ) : ?>
					<div
						class="invisalign-about-panel <?php echo 'process' === $panel_key ? 'active' : ''; ?>"
						data-panel="<?php echo esc_attr( $panel_key ); ?>"
						role="tabpanel"
						<?php echo 'process' !== $panel_key ? 'hidden' : ''; ?>
					>
						<div class="invisalign-card-grid">
							<?php foreach ( $cards as $card ) : ?>
								<?php if ( 'who' === $panel_key ) : ?>
									<article class="invisalign-who-card">
										<img
											src="<?php echo esc_url( $card['image'] ); ?>"
											alt=""
											aria-hidden="true"
											class="invisalign-who-card-img"
										>
										<div class="invisalign-who-card-overlay">
											<h3 class="invisalign-who-card-title"><?php echo esc_html( $card['title'] ); ?></h3>
											<p class="invisalign-who-card-desc"><?php echo esc_html( $card['desc'] ); ?></p>
										</div>
									</article>
								<?php else : ?>
									<article class="invisalign-step-card">
										<div class="invisalign-step-number" aria-hidden="true"><?php echo esc_html( $card['num'] ); ?></div>
										<h3 class="invisalign-step-title"><?php echo esc_html( $card['title'] ); ?></h3>
										<p class="invisalign-step-desc"><?php echo esc_html( $card['desc'] ); ?></p>
									</article>
								<?php endif; ?>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endforeach; ?>

				<div class="invisalign-about-dots" aria-hidden="true"></div>
			</div>
		</div>
	</section>

	<!-- Straight teeth, invisible treatment -->
	<section class="invisalign-treatment-section">
		<div class="invisalign-treatment-inner">
			<div class="invisalign-treatment-content">
				<div class="invisalign-treatment-intro">
					<h2 class="invisalign-treatment-title">
						Straight teeth, <span class="accent">invisible treatment</span>
					</h2>
					<div class="invisalign-treatment-lead">
						<p>Invisalign uses a series of custom-made, clear plastic aligners that gently shift your teeth into position over time. Each set of aligners is worn for about two weeks before progressing to the next, gradually guiding your smile toward its ideal alignment.</p>
					</div>
				</div>
				<div class="invisalign-treatment-details" id="invisalign-treatment-details">
					<div class="invisalign-treatment-lead invisalign-treatment-lead--extra">
						<p>Unlike traditional braces, Invisalign aligners are removable — you take them out to eat, brush, and floss — and because they're virtually clear, most people won't even notice you're wearing them.</p>
					</div>
					<ul class="invisalign-treatment-list">
						<?php foreach ( $treatment_points as $point ) : ?>
							<li class="invisalign-treatment-item">
								<img
									src="<?php echo esc_url( $theme_uri . '/assets/images/implants-check-circle.svg' ); ?>"
									alt=""
									class="invisalign-treatment-icon"
									aria-hidden="true"
								>
								<span><?php echo esc_html( $point ); ?></span>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>

			<div class="invisalign-treatment-visual">
				<?php foreach ( $process_steps as $index => $step ) : ?>
					<div class="invisalign-process-step">
						<div class="invisalign-process-step-label">
							<span class="invisalign-process-step-num" aria-hidden="true"><?php echo esc_html( (string) ( $index + 1 ) ); ?></span>
							<span class="invisalign-process-step-text"><?php echo esc_html( $step['label'] ); ?></span>
						</div>
						<div class="invisalign-process-step-image">
							<img
								src="<?php echo esc_url( $step['image'] ); ?>"
								alt=""
								aria-hidden="true"
							>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<button
			type="button"
			class="invisalign-treatment-disclosure"
			aria-expanded="false"
			aria-controls="invisalign-treatment-details"
		>
			<span class="invisalign-treatment-disclosure-label"><?php esc_html_e( 'Read more about Invisalign', 'wsd' ); ?></span>
			<img
				src="<?php echo esc_url( $theme_uri . '/assets/images/implants-plus.svg' ); ?>"
				alt=""
				class="invisalign-treatment-disclosure-icon"
				aria-hidden="true"
			>
		</button>
	</section>

	<!-- Why Invisalign is Better -->
	<section class="invisalign-compare-section">
		<div class="invisalign-compare-inner">
			<h2 class="invisalign-compare-title">
				Why Invisalign is <span class="accent">Better</span>
			</h2>
			<div class="invisalign-compare-cards">
				<?php foreach ( $compare_columns as $column ) : ?>
					<article class="invisalign-compare-card invisalign-compare-card--<?php echo esc_attr( $column['side'] ); ?>">
						<img
							src="<?php echo esc_url( $column['image'] ); ?>"
							alt="<?php echo esc_attr( $column['label'] ); ?>"
							class="invisalign-compare-card-img"
							loading="lazy"
							decoding="async"
						>
						<span class="invisalign-compare-badge"><?php echo esc_html( $column['label'] ); ?></span>
						<ul class="invisalign-compare-points">
							<?php foreach ( $column['points'] as $point ) : ?>
								<li>
									<img src="<?php echo esc_url( $column['icon'] ); ?>" alt="" aria-hidden="true">
									<span><?php echo esc_html( $point ); ?></span>
								</li>
							<?php endforeach; ?>
						</ul>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<?php
	$smile_gallery_slides = function_exists( 'wsd_get_smile_gallery_slides' )
		? wsd_get_smile_gallery_slides( get_queried_object_id() )
		: array();

	if ( empty( $smile_gallery_slides ) ) {
		$front_page_id = (int) get_option( 'page_on_front' );
		if ( $front_page_id && function_exists( 'wsd_get_smile_gallery_slides' ) ) {
			$smile_gallery_slides = wsd_get_smile_gallery_slides( $front_page_id );
		}
	}

	if ( empty( $smile_gallery_slides ) ) {
		$smile_gallery_slides = array(
			array(
				'before_image' => $theme_uri . '/assets/images/smile_gallery/BeforeImage_1.png',
				'after_image'  => $theme_uri . '/assets/images/smile_gallery/AfterImage_1.png',
				'treatment'    => 'Invisalign',
				'concern'      => 'Crowded Teeth',
				'duration'     => 'Effective results in 6–12 months',
				'visits'       => 'Check-ins every 6–8 weeks',
			),
		);
	}
	?>

	<!-- Smile Gallery -->
	<section
		class="smile-gallery-section invisalign-smile-gallery"
		id="smile-gallery"
		style="--smile-gallery-track-height: <?php echo esc_attr( max( 1, count( $smile_gallery_slides ) ) * 75 ); ?>vh;"
	>
		<div class="gallery-sticky-wrapper">
			<div class="gallery-container">
				<div class="gallery-header-row">
					<div class="gallery-header-badge">
						<h2 class="gallery-header-title">
							<span class="light">Smile </span><span class="accent">Gallery</span>
						</h2>
					</div>
					<p class="gallery-header-desc">These joyful smiles from our patients truly reflect their trust in the services provided by Waterside Dental</p>
				</div>

				<div class="gallery-content-layout">
					<div class="gallery-left-col">
						<div class="gallery-interactive-wrapper">
							<?php foreach ( $smile_gallery_slides as $gallery_slide_index => $gallery_slide ) : ?>
								<div class="gallery-slide <?php echo ( 0 === $gallery_slide_index ) ? 'active' : ''; ?>" data-index="<?php echo esc_attr( $gallery_slide_index + 1 ); ?>">
									<div class="gallery-image-pair-container">
										<div class="gallery-card before-card">
											<div class="gallery-card-image-wrapper">
												<img src="<?php echo esc_url( $gallery_slide['before_image'] ); ?>" alt="<?php esc_attr_e( 'Before treatment', 'wsd' ); ?>" class="gallery-img before-img-crop1">
											</div>
											<div class="gallery-card-label"><?php esc_html_e( 'Before', 'wsd' ); ?></div>
										</div>
										<div class="gallery-connecting-arrow">
											<img src="<?php echo esc_url( $theme_uri . '/assets/images/gallery_arrow.svg' ); ?>" alt="" class="arrow-vector-svg">
										</div>
										<div class="gallery-card after-card">
											<div class="gallery-card-image-wrapper">
												<img src="<?php echo esc_url( $gallery_slide['after_image'] ); ?>" alt="<?php esc_attr_e( 'After treatment', 'wsd' ); ?>" class="gallery-img after-img-crop1">
											</div>
											<div class="gallery-card-label"><?php esc_html_e( 'After', 'wsd' ); ?></div>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>

					<div class="gallery-right-col">
						<div class="gallery-info-wrapper">
							<div class="gallery-details-grid">
								<?php foreach ( $smile_gallery_slides as $gallery_slide_index => $gallery_slide ) : ?>
									<div class="gallery-details-data <?php echo ( 0 === $gallery_slide_index ) ? 'active' : ''; ?>" data-index="<?php echo esc_attr( $gallery_slide_index + 1 ); ?>">
										<div class="gallery-detail-card">
											<span class="detail-label"><?php esc_html_e( 'Treatment', 'wsd' ); ?></span>
											<span class="detail-value"><?php echo esc_html( $gallery_slide['treatment'] ); ?></span>
										</div>
										<div class="gallery-detail-card">
											<span class="detail-label"><?php esc_html_e( 'Main Concern', 'wsd' ); ?></span>
											<span class="detail-value"><?php echo esc_html( $gallery_slide['concern'] ); ?></span>
										</div>
										<div class="gallery-detail-card">
											<span class="detail-label"><?php esc_html_e( 'Duration', 'wsd' ); ?></span>
											<span class="detail-value"><?php echo esc_html( $gallery_slide['duration'] ); ?></span>
										</div>
										<div class="gallery-detail-card">
											<span class="detail-label"><?php esc_html_e( 'Visits', 'wsd' ); ?></span>
											<span class="detail-value"><?php echo esc_html( $gallery_slide['visits'] ); ?></span>
										</div>
									</div>
								<?php endforeach; ?>
							</div>

							<div class="gallery-btn-wrapper">
								<div class="gallery-slider-dots invisalign-gallery-dots" aria-hidden="true"></div>
								<a href="<?php echo esc_url( $gallery_url ); ?>" class="btn btn-gallery-action"><?php esc_html_e( 'View Smile Gallery', 'wsd' ); ?></a>
							</div>
						</div>

						<div class="gallery-scroll-indicator-container">
							<div class="gallery-scroll-indicator-track"></div>
							<div class="gallery-scroll-indicator-handle"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Fees -->
	<section class="invisalign-fees-section" id="invisalign-fees">
		<div class="invisalign-fees-box">
			<div class="invisalign-fees-header">
				<h2 class="invisalign-fees-title">
					Invisalign <span class="accent">Fees</span>
				</h2>
				<p class="invisalign-fees-lead">
					We offer flexible payment plans to make Invisalign accessible. All treatment includes your digital preview, aligners, progress appointments, and a retainer on completion.
				</p>
			</div>
			<div class="invisalign-fees-list">
				<?php foreach ( $invisalign_fees as $index => $fee ) : ?>
					<div class="invisalign-fee-row<?php echo ( $index === count( $invisalign_fees ) - 1 ) ? ' is-last' : ''; ?>">
						<div class="invisalign-fee-copy">
							<span class="invisalign-fee-name"><?php echo esc_html( $fee['title'] ); ?></span>
							<span class="invisalign-fee-desc"><?php echo esc_html( $fee['desc'] ); ?></span>
						</div>
						<span class="invisalign-fee-price"><?php echo esc_html( $fee['price'] ); ?></span>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- Membership -->
	<section class="cosmetic-membership-section invisalign-membership-section">
		<div class="container-fluid px-lg-0">
			<div class="cosmetic-membership-card">
				<div class="cosmetic-membership-img-col">
					<div class="cosmetic-membership-badge">
						<span class="cosmetic-membership-badge-dot"></span>
						<span class="cosmetic-membership-badge-text"><?php esc_html_e( '2 visits / year included', 'wsd' ); ?></span>
					</div>
					<img
						src="<?php echo esc_url( $theme_uri . '/assets/images/cosmetic-membership.png' ); ?>"
						alt="<?php esc_attr_e( 'View Membership', 'wsd' ); ?>"
					>
				</div>
				<div class="cosmetic-membership-content-col">
					<div class="cosmetic-membership-info">
						<h2 class="cosmetic-membership-title">
							View <span class="accent"><?php esc_html_e( 'membership', 'wsd' ); ?></span>
						</h2>
						<p class="cosmetic-membership-desc">
							<?php esc_html_e( 'Members save 15% on hygiene visits. Our monthly plan includes two hygiene appointments per year plus routine examinations — all for one simple monthly payment.', 'wsd' ); ?>
						</p>
						<p class="cosmetic-membership-price">
							From <span class="price-amount">£14.95/</span><span class="price-amount">month</span>
						</p>
					</div>
					<div class="cosmetic-membership-benefits">
						<div class="cosmetic-membership-benefit-item">
							<img src="<?php echo esc_url( $theme_uri . '/assets/images/check-gold.svg' ); ?>" class="cosmetic-membership-benefit-icon" alt="">
							<p class="cosmetic-membership-benefit-text"><?php esc_html_e( '2 hygiene appointments every year', 'wsd' ); ?></p>
						</div>
						<div class="cosmetic-membership-benefit-item">
							<img src="<?php echo esc_url( $theme_uri . '/assets/images/check-gold.svg' ); ?>" class="cosmetic-membership-benefit-icon" alt="">
							<p class="cosmetic-membership-benefit-text"><?php esc_html_e( 'Routine examinations included', 'wsd' ); ?></p>
						</div>
						<div class="cosmetic-membership-benefit-item">
							<img src="<?php echo esc_url( $theme_uri . '/assets/images/check-gold.svg' ); ?>" class="cosmetic-membership-benefit-icon" alt="">
							<p class="cosmetic-membership-benefit-text"><?php esc_html_e( '15% off additional treatments', 'wsd' ); ?></p>
						</div>
					</div>
					<div class="cosmetic-membership-ctas">
						<a href="<?php echo esc_url( $fees_url ); ?>" class="btn-view-plan"><?php esc_html_e( 'View membership', 'wsd' ); ?></a>
						<a href="<?php echo esc_url( $book_url ); ?>" class="btn-book-outline"><?php esc_html_e( 'Book an appointment', 'wsd' ); ?></a>
					</div>
				</div>
			</div>
		</div>
	</section>

	<?php if ( $more_services_query->have_posts() ) : ?>
		<!-- More General Dentistry services -->
		<section class="invisalign-more-services-section">
			<div class="invisalign-more-services-inner">
				<div class="more-services-header">
					<h2 class="more-services-title"><?php esc_html_e( 'More General Dentistry services', 'wsd' ); ?></h2>
					<div class="more-services-nav">
						<button class="more-services-nav-btn prev-btn" aria-label="<?php esc_attr_e( 'Previous service', 'wsd' ); ?>" type="button">
							<img src="<?php echo esc_url( $theme_uri . '/assets/images/left_arrow.svg' ); ?>" alt="">
						</button>
						<button class="more-services-nav-btn next-btn" aria-label="<?php esc_attr_e( 'Next service', 'wsd' ); ?>" type="button">
							<img src="<?php echo esc_url( $theme_uri . '/assets/images/right_arrow.svg' ); ?>" alt="">
						</button>
					</div>
				</div>

				<div class="more-services-slider-container">
					<div class="more-services-slider-track">
						<?php
						while ( $more_services_query->have_posts() ) :
							$more_services_query->the_post();
							$card_img = get_the_post_thumbnail_url( get_the_ID(), 'large' );
							if ( ! $card_img ) {
								$card_img = $theme_uri . '/assets/images/cosmetic-hero.png';
							}
							?>
							<div class="more-service-card-wrapper">
								<a href="<?php the_permalink(); ?>" class="more-service-card">
									<div class="more-service-card-image">
										<img src="<?php echo esc_url( $card_img ); ?>" alt="<?php the_title_attribute(); ?>">
									</div>
									<div class="more-service-card-footer">
										<span class="more-service-card-title"><?php the_title(); ?></span>
										<div class="more-service-card-arrow">
											<img class="more-service-card-arrow-img" src="<?php echo esc_url( $theme_uri . '/assets/images/arrow-gold-circle.svg' ); ?>" alt="" width="40" height="40">
										</div>
									</div>
								</a>
							</div>
						<?php endwhile; ?>
						<?php wp_reset_postdata(); ?>
					</div>
				</div>

				<div class="more-services-progress-wrapper">
					<div class="more-services-progress-track">
						<div class="more-services-progress-bar"></div>
					</div>
				</div>
			</div>
		</section>
	<?php endif; ?>

</main>
<?php
get_footer();
