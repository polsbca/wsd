<?php
/**
 * Front Page Template
 *
 * Displays a hero area and recent posts preview
 *
 * @package wsd
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="main" class="site-main">

	<section class="hero-section">
		<!-- Background waves vector -->
		<div class="hero-bg-waves-wrapper">
			<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/hero-bg-waves.svg' ); ?>" alt="" class="hero-bg-waves">
		</div>

		<div class="container-fluid px-lg-120 h-100 position-relative z-3">
			<div class="row align-items-center h-100">
				<div class="col-lg-6 hero-content-col">
					<div class="hero-content">
						<h1 class="hero-title">Personalised <span class="accent">Care</span></h1>
						<p class="hero-description">Our team combines clinical expertise with patient-focused care to create healthy, confident smiles in a calm and welcoming environment.</p>

						<div class="hero-stats">
							<div class="stat">
								<div class="stat-number" data-count="4.5" data-decimals="1">4.5</div>
								<div class="stat-label">
									<span class="gold-label">Google rating</span><br>
									Based on 200+ reviews
								</div>
							</div>
							<div class="stat">
								<div class="stat-number">GDC</div>
								<div class="stat-label">Fully regulated by the General Dental Council</div>
							</div>
							<div class="stat">
								<div class="stat-number" data-count="15" data-suffix="+">15+</div>
								<div class="stat-label">Clinical Dental Excellence</div>
							</div>
						</div>

						<div class="hero-buttons">
							<a href="#book-appointment" class="btn btn-primary">Book an appointment</a>
							<a href="#fees" class="btn btn-secondary">Fees & Membership</a>
						</div>
					</div>
				</div>

				<div class="col-lg-6 hero-image-col">
					<div class="hero-image-wrapper">
						<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/hero-woman.webp' ); ?>" alt="Professional dental care" class="hero-img">
					</div>
				</div>
			</div>
		</div>

		<!-- Call Us Side Tab -->
		<div class="call-us-tab">
			<a href="tel:+441234567890" class="btn-call-us">
				<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/phone-icon.svg' ); ?>" alt="" class="phone-icon">
				<span class="call-text">Call Us</span>
			</a>
		</div>
	</section>

	<!-- Our Key Treatments Section -->
	<section class="key-treatments-section">
		<div class="treatments-sticky-wrapper">
			<div class="treatments-header-badge">
				<h2 class="treatments-header-title">Our Key <span class="accent">Treatments</span></h2>
			</div>

			<div class="container-fluid px-lg-120 treatments-main-container">
				<div class="row align-items-center treatments-row">
					<!-- Left Column: Counter & Active Image -->
					<div class="col-lg-6 treatments-left-col">
						<div class="treatments-interactive-wrapper">
							<div class="treatment-slide-counter">
								<span class="active-slide">01</span>
								<span class="total-slides">/ 04</span>
							</div>
							<div class="treatment-image-frame">
								<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/general-dentistry.png' ); ?>" alt="General Dentistry" class="active-treatment-image">
							</div>
						</div>
					</div>

					<!-- Right Column: Interactive Accordion/Tabs -->
					<div class="col-lg-6 treatments-right-col">
						<div class="treatment-accordion-wrapper">
							
							<!-- Tab 1: General Dentistry -->
							<div class="accordion-tab active" data-index="01" data-image="<?php echo esc_url( get_template_directory_uri() . '/assets/images/general-dentistry.png' ); ?>">
								<div class="accordion-tab-header">
									<h3 class="accordion-tab-title">General Dentistry</h3>
								</div>
								<div class="accordion-tab-content">
									<div class="mobile-treatment-image-wrapper d-lg-none">
										<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/general-dentistry.png' ); ?>" alt="General Dentistry" class="mobile-treatment-img">
									</div>
									<p class="tab-desc">From routine hygiene to nervous patient care — we provide everything you need to maintain a healthy, confident smile with our comfort-first approach.</p>
									<div class="tab-includes-wrapper">
										<p class="includes-label">General Dentistry Includes:</p>
										<div class="includes-items">
											<span>Hygiene</span>
											<span>Oral Health</span>
											<span>Nervous patients</span>
											<span>Fillings</span>
											<span>Crowns</span>
											<span>Bridges</span>
											<span class="gold-underlined">Dentures</span>
										</div>
									</div>
									<div class="tab-button-wrapper">
										<a href="#general-dentistry" class="btn btn-primary tab-action-btn">View General Dentistry</a>
									</div>
								</div>
							</div>

							<!-- Tab 2: Cosmetic Dentistry -->
							<div class="accordion-tab" data-index="02" data-image="<?php echo esc_url( get_template_directory_uri() . '/assets/images/cosmetic-dentistry.png' ); ?>">
								<div class="accordion-tab-header">
									<h3 class="accordion-tab-title">Cosmetic Dentistry</h3>
								</div>
								<div class="accordion-tab-content">
									<div class="mobile-treatment-image-wrapper d-lg-none">
										<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/cosmetic-dentistry.png' ); ?>" alt="Cosmetic Dentistry" class="mobile-treatment-img">
									</div>
									<p class="tab-desc">Transform your smile with our advanced cosmetic treatments. From teeth whitening to complete smile makeovers, we create natural-looking results that boost your confidence.</p>
									<div class="tab-includes-wrapper">
										<p class="includes-label">Cosmetic Dentistry Includes:</p>
										<div class="includes-items">
											<span>Whitening</span>
											<span>Straightening</span>
											<span>Smile Make Over</span>
											<span class="gold-underlined">Veneers</span>
										</div>
									</div>
									<div class="tab-button-wrapper">
										<a href="#cosmetic-dentistry" class="btn btn-primary tab-action-btn">View Cosmetic Dentistry</a>
									</div>
								</div>
							</div>

							<!-- Tab 3: Dental Implants -->
							<div class="accordion-tab" data-index="03" data-image="<?php echo esc_url( get_template_directory_uri() . '/assets/images/dental-implants.png' ); ?>">
								<div class="accordion-tab-header">
									<h3 class="accordion-tab-title">Dental Implants</h3>
								</div>
								<div class="accordion-tab-content">
									<div class="mobile-treatment-image-wrapper d-lg-none">
										<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/dental-implants.png' ); ?>" alt="Dental Implants" class="mobile-treatment-img">
									</div>
									<p class="tab-desc">Restore your smile and chew with confidence again. Our premium dental implants provide a permanent, natural-looking solution for missing teeth, customized to your oral health.</p>
									<div class="tab-includes-wrapper">
										<p class="includes-label">Dental Implants Includes:</p>
										<div class="includes-items">
											<span>Single Implants</span>
											<span>Multiple Implants</span>
											<span>All-on-4</span>
											<span class="gold-underlined">Implant Bridges</span>
										</div>
									</div>
									<div class="tab-button-wrapper">
										<a href="#dental-implants" class="btn btn-primary tab-action-btn">View Dental Implants</a>
									</div>
								</div>
							</div>

							<!-- Tab 4: Invisalign -->
							<div class="accordion-tab" data-index="04" data-image="<?php echo esc_url( get_template_directory_uri() . '/assets/images/invisalign.png' ); ?>">
								<div class="accordion-tab-header">
									<h3 class="accordion-tab-title">Invisalign</h3>
								</div>
								<div class="accordion-tab-content">
									<div class="mobile-treatment-image-wrapper d-lg-none">
										<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/invisalign.png' ); ?>" alt="Invisalign" class="mobile-treatment-img">
									</div>
									<p class="tab-desc">Straighten your teeth discreetly with Invisalign clear aligners. Enjoy a comfortable, removable orthodontic solution designed to fit seamlessly into your active lifestyle.</p>
									<div class="tab-includes-wrapper">
										<p class="includes-label">Invisalign Includes:</p>
										<div class="includes-items">
											<span>Clear Aligners</span>
											<span>Consultations</span>
											<span>Teen Invisalign</span>
											<span class="gold-underlined">Retainers</span>
										</div>
									</div>
									<div class="tab-button-wrapper">
										<a href="#invisalign" class="btn btn-primary tab-action-btn">View Invisalign</a>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- About Waterside Dental Care Section -->
	<section class="about-waterside-section">
		<div class="about-sticky-wrapper">
			<div class="about-container">
				<!-- Left Column: Content -->
				<div class="about-left-col">
					<div class="about-header-badge">
						<h2 class="about-header-title">
							<span class="light">About </span><span class="accent">Waterside Dental Care</span>
						</h2>
					</div>
					<div class="about-text-content-wrapper">
						<div class="about-text-content active" data-index="1">
							<h3 class="about-subtitle">Built on trust, Driven by results</h3>
							<p class="about-description">At Waterside Dental Care, we believe every patient deserves expert, personal care. Our skilled team takes time to listen, making every visit comfortable, precise and life-changing — from routine hygiene to advanced cosmetic dentistry.</p>
						</div>
						<div class="about-text-content" data-index="2">
							<h3 class="about-subtitle">Modern facilities, Exceptional care</h3>
							<p class="about-description">Our modern surgery is equipped with the latest dental technology, ensuring you receive the highest standard of treatment. We focus on prevention and education to keep your smile healthy for life.</p>
						</div>
						<div class="about-text-content" data-index="3">
							<h3 class="about-subtitle">Transforming smiles, Boosting confidence</h3>
							<p class="about-description">Whether you want a simple refresh or a complete smile makeover, our cosmetic dental services are customized to your unique needs. We create natural, beautiful results that you will love to show off.</p>
						</div>
					</div>
				</div>

				<!-- Right Column: Interactive Images & Scroll Indicator -->
				<div class="about-right-col">
					<div class="about-interactive-wrapper">
						<div class="about-image-frame-container">
							<div class="about-image-frame">
								<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/about1.png' ); ?>" alt="Waterside Dental Care surgery" class="about-scroll-img active" data-index="1">
								<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/general-dentistry.png' ); ?>" alt="Waterside Dental Care office" class="about-scroll-img" data-index="2">
								<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/cosmetic-dentistry.png' ); ?>" alt="Waterside Dental Care treatment" class="about-scroll-img" data-index="3">
								
								<div class="about-scroll-badge">
									<p class="scroll-badge-text">Scroll Here</p>
								</div>
							</div>
						</div>
						
						<!-- Scrollbar Indicator -->
						<div class="about-scroll-indicator-container">
							<div class="about-scroll-indicator-track"></div>
							<div class="about-scroll-indicator-handle"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Smile Gallery Section -->
	<section class="smile-gallery-section">
		<div class="gallery-sticky-wrapper">
			<div class="gallery-container">
				<!-- Header Row -->
				<div class="gallery-header-row">
					<div class="gallery-header-badge">
						<h2 class="gallery-header-title">
							<span class="light">Smile </span><span class="accent">Gallery</span>
						</h2>
					</div>
					<p class="gallery-header-desc">These joyful smiles from our patients truly reflect their trust in the services provided by Waterside Dental Care</p>
				</div>

				<!-- Main Content Layout -->
				<div class="gallery-content-layout">
					<!-- Left Column: Before/After Images -->
					<div class="gallery-left-col">
						<div class="gallery-interactive-wrapper">
							<!-- Slide 1 -->
							<div class="gallery-slide active" data-index="1">
								<div class="gallery-image-pair-container">
									<!-- Before Card -->
									<div class="gallery-card before-card">
										<div class="gallery-card-image-wrapper">
											<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/smile_gallery/BeforeImage_1.png' ); ?>" alt="Before treatment" class="gallery-img before-img-crop1">
										</div>
										<div class="gallery-card-label">Before</div>
									</div>
									<!-- Connecting Arrow Vector -->
									<div class="gallery-connecting-arrow">
										<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/gallery_arrow.svg' ); ?>" alt="" class="arrow-vector-svg">
									</div>
									<!-- After Card -->
									<div class="gallery-card after-card">
										<div class="gallery-card-image-wrapper">
											<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/smile_gallery/AfterImage_1.png' ); ?>" alt="After treatment" class="gallery-img after-img-crop1">
										</div>
										<div class="gallery-card-label">After</div>
									</div>
								</div>
							</div>

							<!-- Slide 2 -->
							<div class="gallery-slide" data-index="2">
								<div class="gallery-image-pair-container">
									<!-- Before Card -->
									<div class="gallery-card before-card">
										<div class="gallery-card-image-wrapper">
											<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/smile_gallery/BeforeImage_2.png' ); ?>" alt="Before treatment" class="gallery-img">
										</div>
										<div class="gallery-card-label">Before</div>
									</div>
									<!-- Connecting Arrow Vector -->
									<div class="gallery-connecting-arrow">
										<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/gallery_arrow.svg' ); ?>" alt="" class="arrow-vector-svg">
									</div>
									<!-- After Card -->
									<div class="gallery-card after-card">
										<div class="gallery-card-image-wrapper">
											<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/smile_gallery/AfterImage_2.png' ); ?>" alt="After treatment" class="gallery-img">
										</div>
										<div class="gallery-card-label">After</div>
									</div>
								</div>
							</div>

							<!-- Slide 3 -->
							<div class="gallery-slide" data-index="3">
								<div class="gallery-image-pair-container">
									<!-- Before Card -->
									<div class="gallery-card before-card">
										<div class="gallery-card-image-wrapper">
											<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/smile_gallery/BeforeImage_3.png' ); ?>" alt="Before treatment" class="gallery-img">
										</div>
										<div class="gallery-card-label">Before</div>
									</div>
									<!-- Connecting Arrow Vector -->
									<div class="gallery-connecting-arrow">
										<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/gallery_arrow.svg' ); ?>" alt="" class="arrow-vector-svg">
									</div>
									<!-- After Card -->
									<div class="gallery-card after-card">
										<div class="gallery-card-image-wrapper">
											<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/smile_gallery/AfterImage_3.png' ); ?>" alt="After treatment" class="gallery-img after-img-crop1">
										</div>
										<div class="gallery-card-label">After</div>
									</div>
								</div>
							</div>

							<!-- Slide 4 -->
							<div class="gallery-slide" data-index="4">
								<div class="gallery-image-pair-container">
									<!-- Before Card -->
									<div class="gallery-card before-card">
										<div class="gallery-card-image-wrapper">
											<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/smile_gallery/BeforeImage_4.png' ); ?>" alt="Before treatment" class="gallery-img">
										</div>
										<div class="gallery-card-label">Before</div>
									</div>
									<!-- Connecting Arrow Vector -->
									<div class="gallery-connecting-arrow">
										<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/gallery_arrow.svg' ); ?>" alt="" class="arrow-vector-svg">
									</div>
									<!-- After Card -->
									<div class="gallery-card after-card">
										<div class="gallery-card-image-wrapper">
											<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/smile_gallery/AfterImage_4.png' ); ?>" alt="After treatment" class="gallery-img after-img-crop1">
										</div>
										<div class="gallery-card-label">After</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Right Column: Detail Cards & Button & Scroll Indicator -->
					<div class="gallery-right-col">
						<div class="gallery-info-wrapper">
							<!-- Detail Cards Grid (Changes dynamically or stays synced with active slide) -->
							<div class="gallery-details-grid">
								<!-- Slide 1 Data -->
								<div class="gallery-details-data active" data-index="1">
									<div class="gallery-detail-card">
										<span class="detail-label">Treatment</span>
										<span class="detail-value">Dental Implant</span>
									</div>
									<div class="gallery-detail-card">
										<span class="detail-label">Main Concern</span>
										<span class="detail-value">Worn & Discoloured Teeth</span>
									</div>
									<div class="gallery-detail-card">
										<span class="detail-label">Duration</span>
										<span class="detail-value">Effective results in 3 months</span>
									</div>
									<div class="gallery-detail-card">
										<span class="detail-label">Visits</span>
										<span class="detail-value">2 visits in 5 months</span>
									</div>
								</div>
								
								<!-- Slide 2 Data -->
								<div class="gallery-details-data" data-index="2">
									<div class="gallery-detail-card">
										<span class="detail-label">Treatment</span>
										<span class="detail-value">Cosmetic Smile Makeover</span>
									</div>
									<div class="gallery-detail-card">
										<span class="detail-label">Main Concern</span>
										<span class="detail-value">Crooked & Uneven Teeth</span>
									</div>
									<div class="gallery-detail-card">
										<span class="detail-label">Duration</span>
										<span class="detail-value">Stunning results in 6 months</span>
									</div>
									<div class="gallery-detail-card">
										<span class="detail-label">Visits</span>
										<span class="detail-value">4 visits in 6 months</span>
									</div>
								</div>

								<!-- Slide 3 Data -->
								<div class="gallery-details-data" data-index="3">
									<div class="gallery-detail-card">
										<span class="detail-label">Treatment</span>
										<span class="detail-value">Invisalign Clear Aligners</span>
									</div>
									<div class="gallery-detail-card">
										<span class="detail-label">Main Concern</span>
										<span class="detail-value">Gaps & Spaced Teeth</span>
									</div>
									<div class="gallery-detail-card">
										<span class="detail-label">Duration</span>
										<span class="detail-value">Perfect alignment in 9 months</span>
									</div>
									<div class="gallery-detail-card">
										<span class="detail-label">Visits</span>
										<span class="detail-value">6 visits in 9 months</span>
									</div>
								</div>

								<!-- Slide 4 Data -->
								<div class="gallery-details-data" data-index="4">
									<div class="gallery-detail-card">
										<span class="detail-label">Treatment</span>
										<span class="detail-value">Composite Bonding</span>
									</div>
									<div class="gallery-detail-card">
										<span class="detail-label">Main Concern</span>
										<span class="detail-value">Chipped & Misaligned Teeth</span>
									</div>
									<div class="gallery-detail-card">
										<span class="detail-label">Duration</span>
										<span class="detail-value">Completed in 1 day</span>
									</div>
									<div class="gallery-detail-card">
										<span class="detail-label">Visits</span>
										<span class="detail-value">1 visit</span>
									</div>
								</div>
							</div>

							<!-- Button -->
							<div class="gallery-btn-wrapper">
								<a href="#smile-gallery" class="btn btn-gallery-action">View Smile Gallery</a>
							</div>
						</div>

						<!-- Vertical Scroll indicator -->
						<div class="gallery-scroll-indicator-container">
							<div class="gallery-scroll-indicator-track"></div>
							<div class="gallery-scroll-indicator-handle"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<?php
	// Reviews CPT slides.
	$review_slides = array();
	if ( post_type_exists( 'review' ) ) {
		$review_posts = get_posts(
			array(
				'post_type'      => 'review',
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'orderby'        => array(
					'menu_order' => 'ASC',
					'date'       => 'DESC',
				),
			)
		);

		$get_review_field = function ( $review_id, $field_names ) {
			foreach ( $field_names as $field_name ) {
				$field_value = function_exists( 'get_field' ) ? get_field( $field_name, $review_id ) : get_post_meta( $review_id, $field_name, true );

				if ( is_string( $field_value ) && '' !== trim( $field_value ) ) {
					return $field_value;
				}

				if ( is_numeric( $field_value ) ) {
					return $field_value;
				}
			}

			return '';
		};

		foreach ( $review_posts as $review_post ) {
			$review_post_id = $review_post->ID;
			$review_title   = $get_review_field( $review_post_id, array( 'review_title', 'testimonial_title', 'patient_review_title', 'review_heading' ) );
			$review_text    = $get_review_field( $review_post_id, array( 'review_text', 'review_content', 'testimonial_text', 'patient_review', 'review_description' ) );
			$review_author  = $get_review_field( $review_post_id, array( 'review_author', 'reviewer_name', 'patient_name', 'testimonial_author', 'author_name' ) );
			$review_rating  = $get_review_field( $review_post_id, array( 'review_rating', 'rating', 'testimonial_rating', 'star_rating' ) );

			if ( ! $review_title ) {
				$review_title = get_the_title( $review_post_id );
			}

			if ( ! $review_text ) {
				$review_text = has_excerpt( $review_post_id ) ? get_the_excerpt( $review_post_id ) : wp_strip_all_tags( apply_filters( 'the_content', $review_post->post_content ) );
			}

			if ( ! $review_author && $review_title !== get_the_title( $review_post_id ) ) {
				$review_author = get_the_title( $review_post_id );
			}

			if ( $review_title || $review_text || $review_author ) {
				$review_slides[] = array(
					'title'  => wp_strip_all_tags( $review_title ),
					'text'   => wp_strip_all_tags( $review_text ),
					'author' => wp_strip_all_tags( $review_author ),
					'rating' => max( 0, min( 5, intval( $review_rating ?: 5 ) ) ),
				);
			}
		}
	}
	?>

	<?php if ( ! empty( $review_slides ) ) : ?>
	<!-- Testimonials Section -->
	<section class="testimonials-section" id="testimonials">
		<div class="testimonials-sticky-wrapper">
			<div class="testimonials-container">
				<!-- Header -->
				<div class="testimonials-header">
					<div class="testimonials-rating-badge">
						<span class="google-logo-wrapper">
							<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/google.svg' ); ?>" alt="Google" class="google-logo-img">
						</span>
						<a href="https://www.google.com" target="_blank" rel="noopener noreferrer" class="testimonials-rating-link">4.9/5 Rating</a>
						<span class="testimonials-dot">
							<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/dot-sep.svg' ); ?>" alt="" class="dot-separator-img">
						</span>
						<span class="testimonials-header-title">What Our Patients think</span>
					</div>
					<?php if ( count( $review_slides ) > 1 ) : ?>
						<div class="testimonials-nav-buttons">
							<button class="testimonials-nav-btn prev-btn" aria-label="Previous testimonial">
								<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/left_arrow.svg' ); ?>" alt="Previous" class="nav-btn-img">
							</button>
							<button class="testimonials-nav-btn next-btn" aria-label="Next testimonial">
								<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/right_arrow.svg' ); ?>" alt="Next" class="nav-btn-img">
							</button>
						</div>
					<?php endif; ?>
				</div>

				<!-- Testimonial Slider Body -->
				<div class="testimonials-content-row">
					<div class="testimonial-quote-mark left-quote">“</div>
					
					<div class="testimonials-slider">
						<?php foreach ( $review_slides as $review_slide_index => $review_slide ) : ?>
							<div class="testimonial-slide <?php echo ( 0 === $review_slide_index ) ? 'active' : ''; ?>" data-index="<?php echo esc_attr( $review_slide_index ); ?>">
								<h3 class="testimonial-title"><?php echo esc_html( $review_slide['title'] ); ?></h3>
								<p class="testimonial-text"><?php echo esc_html( $review_slide['text'] ); ?></p>
								<div class="testimonial-stars">
									<?php for ( $i = 0; $i < intval( $review_slide['rating'] ); $i++ ) : ?>
										<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/star.svg' ); ?>" alt="" class="star-icon-img">
									<?php endfor; ?>
								</div>
								<p class="testimonial-author"><?php echo esc_html( $review_slide['author'] ); ?></p>
							</div>
						<?php endforeach; ?>
					</div>

					<div class="testimonial-quote-mark right-quote">”</div>
				</div>
			</div>

			<!-- Progress Bar Indicator at bottom -->
			<?php if ( count( $review_slides ) > 1 ) : ?>
				<div class="testimonials-progress-track">
					<div class="testimonials-progress-bar"></div>
				</div>
			<?php endif; ?>
		</div>
	</section>
	<?php endif; ?>

	<!-- Principal Dentist Section -->
	<section class="principal-dentist-section" id="principal-dentist">
		<div class="dentist-sticky-wrapper">
			<!-- Background Images for Tabs -->
			<div class="dentist-bg-wrapper">
				<div class="dentist-bg-img active" data-tab="1">
					<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/anddruw.webp' ); ?>" alt="Dr Andrew Parashchak" class="dentist-img-tag tab1-img">
				</div>
				<div class="dentist-bg-img" data-tab="2">
					<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/team.webp' ); ?>" alt="Waterside Team" class="dentist-img-tag tab2-img">
				</div>
				<div class="dentist-gradient-overlay"></div>
			</div>

			<!-- Content Wrapper -->
			<div class="dentist-content-container">
				<div class="dentist-content-inner">
					<h2 class="dentist-section-title">Our Principal Dentist</h2>
					
					<!-- Description block that swaps contents -->
					<div class="dentist-desc-wrapper">
						<div class="dentist-desc-text active" data-tab="1">
							<p>As the Principal Dentist at Waterside Dental Care, Dr Andrew Parashchak brings over 15 years of experience in cosmetic and restorative dentistry. Known for his calm approach and attention to detail, he is dedicated to providing expert, personalised care that patients can trust.</p>
						</div>
						<div class="dentist-desc-text" data-tab="2">
							<p>At Waterside, great dentistry is a team effort. From our treatment coordinator Kim who puts nervous patients at ease, to our skilled hygienists and support staff — every member of our team is here to make your experience as comfortable and positive as it can be.</p>
						</div>
					</div>

					<!-- Tab Navigation Buttons -->
					<div class="dentist-tabs-nav">
						<button class="dentist-tab-btn active" data-target="1">More about Andrew</button>
						<button class="dentist-tab-btn" data-target="2">Meet the Team</button>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Flexible Payment Options Section -->
	<section class="payment-options-section" id="payment-options">
		<style>
			@media (max-width: 991.98px) {
				.payment-options-section .payment-card {
					min-height: 158px !important;
					height: auto !important;
					display: flex !important;
					align-items: center !important;
				}
				.payment-options-section .payment-card.active {
					min-height: 158px !important;
					height: auto !important;
				}
			}
		</style>
		<div class="payment-sticky-wrapper">
			<div class="payment-options-container">
				<!-- Header -->
				<div class="payment-header">
					<h2 class="payment-title">Flexible <span class="accent">Payment Options</span></h2>
					<p class="payment-desc">Choose how you'd like to pay for your dental care at Waterside Dental Care — we offer a range of plans to suit every budget.</p>
				</div>

				<!-- Options Grid -->
				<div class="payment-grid">
					<!-- Option 1: Interest Free Finance -->
					<div class="payment-card border-left-round">
						<div class="payment-card-content">
							<h3 class="payment-card-title">Interest Free Finance</h3>
							<p class="payment-card-text">We are able to arrange finance for your dental treatment at Waterside Dental Care.</p>
						</div>
						<div class="payment-card-button-wrapper">
							<a href="#finance-calculator" class="payment-btn btn-primary-calc">Calculate My Rate</a>
						</div>
					</div>

					<!-- Option 2: Dental Plans -->
					<div class="payment-card">
						<div class="payment-card-content">
							<h3 class="payment-card-title">Dental Plans</h3>
							<p class="payment-card-text">Patients get monthly dental checks and hygienist visits for routine care.</p>
						</div>
						<div class="payment-card-button-wrapper">
							<a href="#dental-plans" class="payment-btn btn-secondary-plan">View All plan</a>
						</div>
					</div>

					<!-- Option 3: Treatment Pricing -->
					<div class="payment-card border-right-round">
						<div class="payment-card-content">
							<h3 class="payment-card-title">Treatment Pricing</h3>
							<p class="payment-card-text">Quality care with transparent and budget-friendly costs for every smile</p>
						</div>
						<div class="payment-card-button-wrapper">
							<a href="#pricing" class="payment-btn btn-secondary-price">view All Pricing</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Book an Appointment CTA Section -->
	<!-- <section class="book-appointment-section" id="book-appointment">
		<div class="book-appointment-bg-wrapper">
			<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/book-bg.webp' ); ?>" alt="" class="book-appointment-bg">
		</div>
		<div class="book-appointment-container">
			<div class="book-appointment-card">
				<div class="book-appointment-content">
					<h2 class="book-appointment-title">Book an appointment</h2>
					<p class="book-appointment-text">To book an appointment straight away you can use our online booking form</p>
				</div>
				<div class="book-appointment-btn-wrapper">
					<a href="#book-appointment-form" class="book-appointment-btn">Book an appointment</a>
				</div>
			</div>
		</div>
	</section> -->

	<!-- <section class="services-section container">
		<h2 class="section-title">Our Services</h2>
		<?php
		$home_query = new WP_Query( array(
			'posts_per_page' => 6,
		) );

		if ( $home_query->have_posts() ) :
			echo '<div class="services-grid">';
			while ( $home_query->have_posts() ) : $home_query->the_post();
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'service-card' ); ?>>
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="service-thumb">
							<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'medium' ); ?></a>
						</div>
					<?php endif; ?>
					<header class="service-header">
						<?php the_title( '<h3 class="service-title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h3>' ); ?>
					</header>
					<div class="service-summary">
						<?php the_excerpt(); ?>
					</div>
				</article>
				<?php
			endwhile;
			echo '</div>';
			wp_reset_postdata();
		endif;
		?>
	</section> -->

</main>

<?php
get_footer();
