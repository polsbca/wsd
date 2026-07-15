<?php
/**
 * Template Name: Dental Implants Page Template
 *
 * @package wsd
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$theme_uri      = get_template_directory_uri();
$fees_url       = function_exists( 'wsd_get_fees_page_url' ) ? wsd_get_fees_page_url() : home_url( '/fees/' );
$gallery_url    = function_exists( 'wsd_get_smile_gallery_page_url' ) ? wsd_get_smile_gallery_page_url() : home_url( '/smile-gallery/' );
$book_url       = home_url( '/#book-appointment' );
$page_id        = get_queried_object_id();
$hero_alt       = __( 'Dental implant instruments', 'wsd' );
$hero_image_id  = ( $page_id && has_post_thumbnail( $page_id ) ) ? (int) get_post_thumbnail_id( $page_id ) : 0;

if ( $hero_image_id ) {
	$thumbnail_alt = get_post_meta( $hero_image_id, '_wp_attachment_image_alt', true );
	if ( $thumbnail_alt ) {
		$hero_alt = $thumbnail_alt;
	}
}
$implants_fees  = array(
	array(
		'title' => 'Single Tooth Implant (incl. crown)',
		'desc'  => 'Titanium post, abutment and custom porcelain or zirconia crown',
		'price' => 'From £2,400',
	),
	array(
		'title' => 'Implant-Supported Bridge (per unit)',
		'desc'  => 'Two implant posts supporting a fixed bridge across multiple teeth',
		'price' => 'From £390',
	),
	array(
		'title' => 'All-on-4 (full arch)',
		'desc'  => 'Full arch of fixed teeth supported by four implants — per arch',
		'price' => 'From £390',
	),
	array(
		'title' => 'All-on-6 (full arch)',
		'desc'  => 'Increased stability with six implants for a full arch — per arch',
		'price' => 'From £390',
	),
	array(
		'title' => 'Implant-Retained Dentures',
		'desc'  => 'Snap-on dentures supported by two or more implants per arch',
		'price' => 'From £390',
	),
	array(
		'title' => 'Bone Graft (if required)',
		'desc'  => 'Required when jawbone density is insufficient to support an implant post',
		'price' => 'From £390',
	),
	array(
		'title' => 'CBCT Scan & Consultation',
		'desc'  => 'Detailed 3D imaging and full treatment planning session (redeemable against treatment)',
		'price' => 'From £390',
	),
);

$about_panels = array(
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
			'num'   => '1',
			'title' => 'Single Tooth Implant',
			'desc'  => 'A standalone implant and crown that replaces one missing tooth without affecting neighbours.',
		),
		array(
			'num'   => '2',
			'title' => 'Implant-Supported Bridge',
			'desc'  => 'Two or more implants supporting a fixed bridge across several missing teeth.',
		),
		array(
			'num'   => '3',
			'title' => 'Full Arch (All-on-4 / All-on-6)',
			'desc'  => 'A complete arch of teeth fixed on four or six implants for a stable, non-removable smile.',
		),
		array(
			'num'   => '4',
			'title' => 'Implant-Retained Dentures',
			'desc'  => 'Snap-on dentures secured by implants for comfort, retention and easier eating.',
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

$built_parts = array(
	array(
		'title' => 'The Crown',
		'desc'  => 'The visible part of the implant — a custom-made porcelain or zirconia tooth crafted to precisely match the shade, shape and size of your natural teeth. Made in our lab from detailed digital impressions.',
	),
	array(
		'title' => 'The Abutment',
		'desc'  => 'The precision connector that sits between the implant post and the crown, transferring bite forces while keeping everything aligned and stable.',
	),
	array(
		'title' => 'The Implant',
		'desc'  => 'A biocompatible titanium post placed into the jawbone. Over time it integrates with the bone to act as an artificial tooth root.',
	),
	array(
		'title' => 'The Gum',
		'desc'  => 'Healthy soft tissue forms a natural seal around the abutment, protecting the underlying bone and giving the crown a lifelike emergence profile.',
	),
);

$compare_rows = array(
	array(
		'label'    => 'Appearance',
		'implants' => 'Indistinguishable from natural',
		'bridge'   => 'Good, but visible margins',
		'denture'  => 'Visible clasps or plate',
	),
	array(
		'label'    => 'Bone Preservation',
		'implants' => 'Actively stimulates bone',
		'bridge'   => 'Bone loss continues',
		'denture'  => 'Bone loss continues',
	),
	array(
		'label'    => 'Adjacent Teeth',
		'implants' => 'No impact at all',
		'bridge'   => 'Must crown adjacent teeth',
		'denture'  => 'Puts stress on nearby teeth',
	),
	array(
		'label'    => 'Lifespan',
		'implants' => 'Lifetime with care',
		'bridge'   => '10–15 years typically',
		'denture'  => '5–10 years, re-fitting needed',
	),
	array(
		'label'    => 'Eating & Comfort',
		'implants' => 'Eat anything, no restrictions',
		'bridge'   => 'Good, some care needed',
		'denture'  => 'Restricted, may slip',
	),
	array(
		'label'    => 'Cleaning',
		'implants' => 'Brush & floss as normal',
		'bridge'   => 'Special floss required',
		'denture'  => 'Must be removed to clean',
	),
);

get_header();
?>
<main id="main" class="site-main dental-implants-main">

	<!-- Hero -->
	<section class="implants-hero">
		<div class="implants-hero-inner">
			<div class="implants-hero-content">
				<div class="implants-hero-copy">
					<h1 class="implants-hero-title">
						Dental <span class="accent">Implants</span>
					</h1>
					<p class="implants-hero-desc">
						Replace missing teeth with a permanent, natural-feeling solution that looks, feels, and functions exactly like your own teeth — designed to last a lifetime.
					</p>
				</div>
				<div class="implants-hero-ctas">
					<a href="<?php echo esc_url( $book_url ); ?>" class="btn btn-primary implants-btn"><?php esc_html_e( 'Book an appointment', 'wsd' ); ?></a>
					<a href="<?php echo esc_url( $fees_url ); ?>" class="btn btn-secondary implants-btn"><?php esc_html_e( 'Fees & Membership', 'wsd' ); ?></a>
				</div>
			</div>
			<div class="implants-hero-image-col">
				<div class="implants-hero-image-wrapper">
					<?php
					if ( $hero_image_id ) {
						echo wp_get_attachment_image(
							$hero_image_id,
							'full',
							false,
							array(
								'class'    => 'implants-hero-img',
								'alt'      => $hero_alt,
								'loading'  => 'eager',
								'decoding' => 'async',
							)
						);
					} else {
						?>
						<img
							src="<?php echo esc_url( $theme_uri . '/assets/images/dental-implants-hero.png' ); ?>"
							alt="<?php echo esc_attr( $hero_alt ); ?>"
							class="implants-hero-img"
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

	<!-- All About Dental Implants -->
	<section class="implants-about-section" id="implants-about">
		<div class="implants-about-sticky">
			<div class="implants-about-header">
				<div class="implants-section-badge">
					<h2 class="implants-section-title">
						All About <span class="accent">Dental Implants</span>
					</h2>
				</div>
			</div>

			<div class="implants-about-body">
				<div class="implants-about-tabs" role="tablist" aria-label="<?php esc_attr_e( 'Dental implant topics', 'wsd' ); ?>">
					<button type="button" class="implants-tab-btn active" role="tab" aria-selected="true" data-tab="process"><?php esc_html_e( 'Process', 'wsd' ); ?></button>
					<button type="button" class="implants-tab-btn" role="tab" aria-selected="false" data-tab="types"><?php esc_html_e( 'Types of Implant', 'wsd' ); ?></button>
					<button type="button" class="implants-tab-btn" role="tab" aria-selected="false" data-tab="benefits"><?php esc_html_e( 'Key Benefits', 'wsd' ); ?></button>
				</div>

				<?php foreach ( $about_panels as $panel_key => $cards ) : ?>
					<div
						class="implants-about-panel <?php echo 'process' === $panel_key ? 'active' : ''; ?>"
						data-panel="<?php echo esc_attr( $panel_key ); ?>"
						role="tabpanel"
						<?php echo 'process' !== $panel_key ? 'hidden' : ''; ?>
					>
						<div class="implants-card-grid">
							<?php foreach ( $cards as $card ) : ?>
								<article class="implants-step-card">
									<div class="implants-step-number" aria-hidden="true"><?php echo esc_html( $card['num'] ); ?></div>
									<h3 class="implants-step-title"><?php echo esc_html( $card['title'] ); ?></h3>
									<p class="implants-step-desc"><?php echo esc_html( $card['desc'] ); ?></p>
								</article>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- How an implant is built -->
	<section class="implants-built-section">
		<div class="implants-built-sticky">
			<div class="implants-built-inner">
				<div class="implants-built-diagram">
					<img
						src="<?php echo esc_url( $theme_uri . '/assets/images/dental-implants-diagram.png' ); ?>"
						alt="<?php esc_attr_e( 'Diagram of crown, abutment and implant in the jawbone', 'wsd' ); ?>"
					>
				</div>
				<div class="implants-built-content">
					<div class="implants-built-intro">
						<h2 class="implants-built-title">
							How an implant is <span class="accent">built</span>
						</h2>
						<p class="implants-built-lead">
							Every dental implant has three parts that work together to replicate a natural tooth from root to crown.
						</p>
					</div>
					<ul class="implants-built-list">
						<?php foreach ( $built_parts as $part ) : ?>
							<li class="implants-built-item">
								<img
									src="<?php echo esc_url( $theme_uri . '/assets/images/implants-check-circle.svg' ); ?>"
									alt=""
									class="implants-built-icon"
									aria-hidden="true"
								>
								<div class="implants-built-item-copy">
									<h3 class="implants-built-item-title"><?php echo esc_html( $part['title'] ); ?></h3>
									<p class="implants-built-item-desc"><?php echo esc_html( $part['desc'] ); ?></p>
								</div>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
		</div>
	</section>

	<!-- Implants vs other options -->
	<section class="implants-compare-section">
		<div class="implants-compare-sticky">
			<div class="implants-compare-inner">
				<div class="implants-compare-intro">
					<h2 class="implants-compare-title">
						Implants vs <span class="accent">other options</span>
					</h2>
					<p class="implants-compare-lead">
						Understanding how implants compare helps you make the right choice for your situation.
					</p>
				</div>

				<div class="implants-compare-table" role="table" aria-label="<?php esc_attr_e( 'Implants compared with bridges and dentures', 'wsd' ); ?>">
					<div class="implants-compare-labels" role="rowgroup">
						<div class="implants-compare-corner" role="columnheader"></div>
						<?php foreach ( $compare_rows as $row ) : ?>
							<div class="implants-compare-label" role="rowheader"><?php echo esc_html( $row['label'] ); ?></div>
						<?php endforeach; ?>
					</div>

					<div class="implants-compare-col implants-compare-col--highlight" role="column">
						<div class="implants-compare-col-head" role="columnheader"><?php esc_html_e( 'Implants', 'wsd' ); ?></div>
						<?php foreach ( $compare_rows as $row ) : ?>
							<div class="implants-compare-cell" role="cell" data-label="<?php echo esc_attr( $row['label'] ); ?>">
								<img src="<?php echo esc_url( $theme_uri . '/assets/images/implants-check-circle.svg' ); ?>" alt="" aria-hidden="true">
								<span><?php echo esc_html( $row['implants'] ); ?></span>
							</div>
						<?php endforeach; ?>
					</div>

					<div class="implants-compare-col" role="column">
						<div class="implants-compare-col-head" role="columnheader"><?php esc_html_e( 'Bridge', 'wsd' ); ?></div>
						<?php foreach ( $compare_rows as $row ) : ?>
							<div class="implants-compare-cell" role="cell" data-label="<?php echo esc_attr( $row['label'] ); ?>">
								<img src="<?php echo esc_url( $theme_uri . '/assets/images/implants-indeterminate-circle.svg' ); ?>" alt="" aria-hidden="true">
								<span><?php echo esc_html( $row['bridge'] ); ?></span>
							</div>
						<?php endforeach; ?>
					</div>

					<div class="implants-compare-col" role="column">
						<div class="implants-compare-col-head" role="columnheader"><?php esc_html_e( 'Denture', 'wsd' ); ?></div>
						<?php foreach ( $compare_rows as $row ) : ?>
							<div class="implants-compare-cell" role="cell" data-label="<?php echo esc_attr( $row['label'] ); ?>">
								<img src="<?php echo esc_url( $theme_uri . '/assets/images/implants-indeterminate-circle.svg' ); ?>" alt="" aria-hidden="true">
								<span><?php echo esc_html( $row['denture'] ); ?></span>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
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
				'treatment'    => 'Dental Implant',
				'concern'      => 'Worn & Discoloured Teeth',
				'duration'     => 'Effective results in 3 months',
				'visits'       => '2 visits in 5 months',
			),
		);
	}
	?>

	<!-- Smile Gallery (same structure as front-page) -->
	<section
		class="smile-gallery-section implants-smile-gallery"
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
	<section class="implants-fees-section" id="implants-fees">
		<div class="implants-fees-box">
			<div class="implants-fees-header">
				<h2 class="implants-fees-title">
					Dental Implant <span class="accent">Fees</span>
				</h2>
				<p class="implants-fees-lead">
					All implant fees include your initial consultation, CBCT scan, implant placement, abutment and final crown. We offer 0% finance plans to spread the cost comfortably.
				</p>
			</div>
			<div class="implants-fees-list">
				<?php foreach ( $implants_fees as $index => $fee ) : ?>
					<div class="implants-fee-row<?php echo ( $index === count( $implants_fees ) - 1 ) ? ' is-last' : ''; ?>">
						<div class="implants-fee-copy">
							<span class="implants-fee-name"><?php echo esc_html( $fee['title'] ); ?></span>
							<span class="implants-fee-desc"><?php echo esc_html( $fee['desc'] ); ?></span>
						</div>
						<span class="implants-fee-price"><?php echo esc_html( $fee['price'] ); ?></span>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- Membership -->
	<section class="cosmetic-membership-section implants-membership-section">
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

</main>
<?php
get_footer();
