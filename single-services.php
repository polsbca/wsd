<?php
/**
 * The template for displaying single service posts
 *
 * @package wsd
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="main" class="site-main single-service-main">

	<?php
	while ( have_posts() ) :
		the_post();
		
		// Get category name
		$categories = get_the_terms( get_the_ID(), 'service_category' );
		$category_name = '';
		$category_slug = '';
		if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
			$category_name = $categories[0]->name;
			$category_slug = $categories[0]->slug;
		}

		if ( in_array( $category_slug, array( 'all-about-cosmetic-dentistry-services', 'cosmetic-dentistry', 'all-about-general-dentistry-services', 'general-dentistry' ) ) ) :
			// Custom Figma Layout for Service Categories
			?>

			<!-- Custom Cosmetic Service Hero Section -->
			<section class="cosmetic-service-hero">
				<div class="container-fluid px-lg-0 position-relative z-3">
					<div class="row">
						<div class="col-lg-6 hero-content-col align-self-center">
							<div class="cosmetic-hero-content">
								<h1 class="cosmetic-hero-title">
									All About <br>
									<span class="accent"><?php echo esc_html( $category_name ); ?></span>
								</h1>
								<p class="cosmetic-hero-desc">
									<?php 
									if ( has_excerpt() ) {
										echo get_the_excerpt();
									} else {
										echo 'Transform your smile with bespoke dental treatments designed to enhance appearance, boost confidence, and deliver naturally beautiful results tailored to you.';
									}
									?>
								</p>
							</div>
						</div>
						<div class="col-lg-6 hero-image-col align-self-end">
							<div class="cosmetic-hero-image-wrapper">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php the_post_thumbnail( 'large', array( 'class' => 'img-fluid' ) ); ?>
								<?php else : ?>
									<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/cosmetic-hero.png' ); ?>" alt="<?php the_title_attribute(); ?>" class="img-fluid">
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>

				<!-- Floating Call Us Badge -->
				<div class="floating-call-badge">
					<a href="tel:01706632661" class="floating-call-badge-content">
						<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/phone-icon.svg' ); ?>" alt="" style="width: 24px; height: 19px; filter: brightness(0) invert(1);">
						Call Us
					</a>
				</div>
			</section>

			<?php
			// Get child posts (sub-services) dynamically
			$sub_services_query = new WP_Query( array(
				'post_type'      => 'services',
				'post_parent'    => get_the_ID(),
				'posts_per_page' => -1,
				'orderby'        => 'menu_order',
				'order'          => 'ASC'
			) );
			?>

			<!-- Custom Treatments Accordion/Card list -->
			<div class="cosmetic-treatments-container">
				<?php 
				if ( $sub_services_query->have_posts() ) :
					$index = 0;
					while ( $sub_services_query->have_posts() ) : $sub_services_query->the_post();
						?>
						<a href="javascript:void(0)" class="cosmetic-treatment-row <?php echo ($index === 0) ? 'active' : ''; ?>" data-bs-toggle="modal" data-bs-target="#sub-service-modal-<?php the_ID(); ?>">
							<h3 class="cosmetic-treatment-title"><?php the_title(); ?></h3>
							<div class="cosmetic-treatment-arrow">
								<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-gold-circle.svg' ); ?>" alt="" style="filter: brightness(0) invert(1);">
							</div>
						</a>
						<?php
						$index++;
					endwhile;
					$sub_services_query->rewind_posts(); // Rewind for printing the modals
				else :
					?>
					<div class="p-5 text-center text-muted" style="font-family: 'Montserrat', sans-serif; background-color: #faf3e6;">No sub-services found. Please assign sub-services under this parent page in WordPress Admin.</div>
				<?php endif; ?>
			</div>

			<?php 
			if ( $sub_services_query->have_posts() ) :
				while ( $sub_services_query->have_posts() ) : $sub_services_query->the_post();
					$modal_id = 'sub-service-modal-' . get_the_ID();
					
					// ACF fields with fallbacks
					$parent_id = wp_get_post_parent_id(get_the_ID());
					$parent_show_gallery = $parent_id ? get_field('show_smile_gallery', $parent_id) : null;
					$child_show_gallery = get_field('show_smile_gallery');
					
					if ($parent_show_gallery === false || $child_show_gallery === false) {
						$show_smile_gallery = false;
					} else {
						$show_smile_gallery = true;
					}
					$subtitle = get_field('service_subtitle') ?: 'A smile makeover combines cosmetic and restorative treatments to improve the appearance of your smile. Each plan is tailored to your goals and desired results.';
					$duration = get_field('service_duration') ?: '3 months';
					$price = get_field('service_price') ?: 'From £95';
					
					// Process Group
					$process = get_field('process');
					$p_num1 = (!empty($process['process_number_1'])) ? $process['process_number_1'] : '1';
					$p_title1 = (!empty($process['process_title_1'])) ? $process['process_title_1'] : 'Consultation & Smile Assessment';
					$p_desc1 = (!empty($process['process_content_1'])) ? $process['process_content_1'] : 'Discuss your concerns and desired smile outcome.';

					$p_num2 = (!empty($process['process_number_2'])) ? $process['process_number_2'] : '2';
					$p_title2 = (!empty($process['process_title_2'])) ? $process['process_title_2'] : 'Personalised Treatment Planning';
					$p_desc2 = (!empty($process['process_content_2'])) ? $process['process_content_2'] : 'Create a customised plan based on your smile goals.';

					$p_num3 = (!empty($process['process_number_3'])) ? $process['process_number_3'] : '3';
					$p_title3 = (!empty($process['process_title_3'])) ? $process['process_title_3'] : 'Treatment Phase';
					$p_desc3 = (!empty($process['process_content_3'])) ? $process['process_content_3'] : 'Complete recommended cosmetic and restorative procedures.';

					$p_num4 = (!empty($process['process_number_4'])) ? $process['process_number_4'] : '4';
					$p_title4 = (!empty($process['process_title_4'])) ? $process['process_title_4'] : 'Final Review';
					$p_desc4 = (!empty($process['process_content_4'])) ? $process['process_content_4'] : 'Assess results and ensure a natural-looking finish.';

					// Symptoms Group
					$symptoms = get_field('symptoms');
					$s_title1 = (!empty($symptoms['symptoms_title_1'])) ? $symptoms['symptoms_title_1'] : 'Stained Teeth';
					$s_desc1 = (!empty($symptoms['symptoms_sub_title_1'])) ? $symptoms['symptoms_sub_title_1'] : 'Discolouration caused by food, drinks, or smoking.';
					$s_img1 = (!empty($symptoms['symptoms_image_1'])) ? $symptoms['symptoms_image_1'] : esc_url( get_template_directory_uri() . '/assets/images/stained-teeth.png' );

					$s_title2 = (!empty($symptoms['symptoms_title_2'])) ? $symptoms['symptoms_title_2'] : 'Yellowing With Age';
					$s_desc2 = (!empty($symptoms['symptoms_sub_title_2'])) ? $symptoms['symptoms_sub_title_2'] : 'Teeth becoming darker over time.';
					$s_img2 = (!empty($symptoms['symptoms_image_2'])) ? $symptoms['symptoms_image_2'] : esc_url( get_template_directory_uri() . '/assets/images/yellowing.png' );

					$s_title3 = (!empty($symptoms['symptoms_title_3'])) ? $symptoms['symptoms_title_3'] : 'Dull Smile Appearance';
					$s_desc3 = (!empty($symptoms['symptoms_sub_title_3'])) ? $symptoms['symptoms_sub_title_3'] : 'Loss of natural brightness and shine.';
					$s_img3 = (!empty($symptoms['symptoms_image_3'])) ? $symptoms['symptoms_image_3'] : esc_url( get_template_directory_uri() . '/assets/images/dull-smile.png' );

					$s_title4 = (!empty($symptoms['symptoms_title_4'])) ? $symptoms['symptoms_title_4'] : 'Special Occasion';
					$s_desc4 = (!empty($symptoms['symptoms_sub_title_4'])) ? $symptoms['symptoms_sub_title_4'] : 'Preparing for weddings, events, or important occasions.';
					$s_img4 = (!empty($symptoms['symptoms_image_4'])) ? $symptoms['symptoms_image_4'] : esc_url( get_template_directory_uri() . '/assets/images/special-occasion.png' );

					// Key Benefits Group
					$key_benefits = get_field('key_benefits');
					$b_num1 = (!empty($key_benefits['key_benefits_number_1'])) ? $key_benefits['key_benefits_number_1'] : '1';
					$b_title1 = (!empty($key_benefits['key_benefits_title_1'])) ? $key_benefits['key_benefits_title_1'] : 'Brighter Smile';
					$b_desc1 = (!empty($key_benefits['key_benefits_sub_title_1'])) ? $key_benefits['key_benefits_sub_title_1'] : 'Noticeably whiter and fresher-looking teeth.';

					$b_num2 = (!empty($key_benefits['key_benefits_number_2'])) ? $key_benefits['key_benefits_number_2'] : '2';
					$b_title2 = (!empty($key_benefits['key_benefits_title_2'])) ? $key_benefits['key_benefits_title_2'] : 'Improved Confidence';
					$b_desc2 = (!empty($key_benefits['key_benefits_sub_title_2'])) ? $key_benefits['key_benefits_sub_title_2'] : 'Feel more comfortable smiling and speaking.';

					$b_num3 = (!empty($key_benefits['key_benefits_number_3'])) ? $key_benefits['key_benefits_number_3'] : '3';
					$b_title3 = (!empty($key_benefits['key_benefits_title_3'])) ? $key_benefits['key_benefits_title_3'] : 'Safe & Non-Invasive';
					$b_desc3 = (!empty($key_benefits['key_benefits_sub_title_3'])) ? $key_benefits['key_benefits_sub_title_3'] : 'No drilling or damage to healthy tooth structure.';

					$b_num4 = (!empty($key_benefits['key_benefits_number_4'])) ? $key_benefits['key_benefits_number_4'] : '4';
					$b_title4 = (!empty($key_benefits['key_benefits_title_4'])) ? $key_benefits['key_benefits_title_4'] : 'Long-Lasting Results';
					$b_desc4 = (!empty($key_benefits['key_benefits_sub_title_4'])) ? $key_benefits['key_benefits_sub_title_4'] : 'Maintain results with good oral hygiene habits.';

					$gallery_page_ids = array( get_the_ID() );
					if ( $parent_id ) {
						$gallery_page_ids[] = $parent_id;
					}
					$gallery_slides = function_exists( 'wsd_get_smile_gallery_slides' ) ? wsd_get_smile_gallery_slides( $gallery_page_ids ) : array();

					// Fees Group
					$fees = get_field('fees');
					$fees = is_array( $fees ) ? $fees : array();
					$fee_rows = array();
					for ( $fee_index = 1; $fee_index <= 4; $fee_index++ ) {
						$fee_title = ! empty( $fees[ 'fee_title_' . $fee_index ] ) ? $fees[ 'fee_title_' . $fee_index ] : '';
						$fee_value = ! empty( $fees[ 'fee_value_' . $fee_index ] ) ? $fees[ 'fee_value_' . $fee_index ] : '';

						if ( $fee_title || $fee_value ) {
							$fee_rows[] = array(
								'title' => $fee_title,
								'value' => $fee_value,
							);
						}
					}

					// Accordion Section Group
					$accordion_section = get_field('accordion_section');
					$accordion_section = is_array( $accordion_section ) ? $accordion_section : array();
					$accordion_title_part_1 = ! empty( $accordion_section['acc_section_title_part_1'] ) ? $accordion_section['acc_section_title_part_1'] : '';
					$accordion_title_part_2 = ! empty( $accordion_section['acc_section_title_part_2'] ) ? $accordion_section['acc_section_title_part_2'] : '';
					$accordion_sub_title = ! empty( $accordion_section['acc_section_sub_title'] ) ? $accordion_section['acc_section_sub_title'] : '';
					$accordion_rows = array();
					for ( $accordion_index = 1; $accordion_index <= 4; $accordion_index++ ) {
						$accordion_title = ! empty( $accordion_section[ 'acc_title_' . $accordion_index ] ) ? $accordion_section[ 'acc_title_' . $accordion_index ] : '';
						$accordion_content = ! empty( $accordion_section[ 'acc_content_' . $accordion_index ] ) ? $accordion_section[ 'acc_content_' . $accordion_index ] : '';

						if ( $accordion_title || $accordion_content ) {
							$accordion_rows[] = array(
								'title'   => $accordion_title,
								'content' => $accordion_content,
							);
						}
					}

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
					<!-- Full-Screen Modal for <?php the_title(); ?> -->
					<div class="modal fade cosmetic-full-modal" id="<?php echo esc_attr( $modal_id ); ?>" tabindex="-1" aria-hidden="true">
						<div class="modal-dialog modal-fullscreen">
							<div class="modal-content cosmetic-modal-content">
								<!-- Modal Header Bar -->
								<div class="cosmetic-modal-header d-flex align-items-center justify-content-between">
									<button type="button" class="btn-close-circle" data-bs-dismiss="modal" aria-label="Close">
										<span class="close-x">&times;</span>
									</button>
									<div class="cosmetic-modal-nav d-none d-md-flex align-items-center gap-4">
										<a href="#modal-about-<?php the_ID(); ?>" class="modal-nav-link active">About <?php the_title(); ?></a>
										<?php if ( ( $show_smile_gallery && ! empty( $gallery_slides ) ) || ! empty( $review_slides ) ) : ?>
											<a href="#modal-gallery-<?php the_ID(); ?>" class="modal-nav-link"><?php echo ( $show_smile_gallery && ! empty( $gallery_slides ) ) ? 'Results' : 'Reviews'; ?></a>
										<?php endif; ?>
										<a href="#modal-fees-<?php the_ID(); ?>" class="modal-nav-link">Treatment fees</a>
									</div>
								</div>
 
								<div class="modal-body cosmetic-modal-body">
									<!-- About Section -->
									<div id="modal-about-<?php the_ID(); ?>" class="modal-section cosmetic-modal-about-section">
										<div class="d-flex flex-column flex-lg-row align-items-lg-center" style="gap: 100px;">
											<div class="cosmetic-modal-title-col shrink-0">
												<div class="cosmetic-modal-title-badge">
													<h2>All About <span class="accent"><?php the_title(); ?></span></h2>
												</div>
											</div>
											<div class="flex-grow-1 mt-4 mt-lg-0">
												<p class="cosmetic-modal-desc-text">
													<?php echo esc_html( $subtitle ); ?>
												</p>
											</div>
										</div>
 
										<!-- Process Steps Tabs & Cards -->
										<div class="cosmetic-modal-process-tabs">
											<div class="d-flex flex-wrap cosmetic-tab-grp" id="modal-tabs-<?php the_ID(); ?>" role="tablist">
												<button class="btn btn-process-tab active" id="process-tab-<?php the_ID(); ?>" data-bs-toggle="pill" data-bs-target="#process-content-<?php the_ID(); ?>" type="button" role="tab" aria-controls="process-content-<?php the_ID(); ?>" aria-selected="true">Process</button>
												<button class="btn btn-process-tab" id="symptoms-tab-<?php the_ID(); ?>" data-bs-toggle="pill" data-bs-target="#symptoms-content-<?php the_ID(); ?>" type="button" role="tab" aria-controls="symptoms-content-<?php the_ID(); ?>" aria-selected="false">Symptoms</button>
												<button class="btn btn-process-tab" id="benefits-tab-<?php the_ID(); ?>" data-bs-toggle="pill" data-bs-target="#benefits-content-<?php the_ID(); ?>" type="button" role="tab" aria-controls="benefits-content-<?php the_ID(); ?>" aria-selected="false">Key Benefits</button>
											</div>
 
											<div class="tab-content" id="modal-tab-content-<?php the_ID(); ?>">
												<!-- Process Tab Content -->
												<div class="tab-pane fade show active" id="process-content-<?php the_ID(); ?>" role="tabpanel" aria-labelledby="process-tab-<?php the_ID(); ?>">
													<div class="row g-4">
														<!-- Step 1 -->
														<div class="col-xl-3 col-md-6">
															<div class="process-step-card">
																<div class="step-number-circle"><?php echo esc_html($p_num1); ?></div>
																<h4 class="step-card-title"><?php echo esc_html( $p_title1 ); ?></h4>
																<p class="step-card-desc"><?php echo esc_html( $p_desc1 ); ?></p>
															</div>
														</div>
														<!-- Step 2 -->
														<div class="col-xl-3 col-md-6">
															<div class="process-step-card">
																<div class="step-number-circle"><?php echo esc_html($p_num2); ?></div>
																<h4 class="step-card-title"><?php echo esc_html( $p_title2 ); ?></h4>
																<p class="step-card-desc"><?php echo esc_html( $p_desc2 ); ?></p>
															</div>
														</div>
														<!-- Step 3 -->
														<div class="col-xl-3 col-md-6">
															<div class="process-step-card">
																<div class="step-number-circle"><?php echo esc_html($p_num3); ?></div>
																<h4 class="step-card-title"><?php echo esc_html( $p_title3 ); ?></h4>
																<p class="step-card-desc"><?php echo esc_html( $p_desc3 ); ?></p>
															</div>
														</div>
														<!-- Step 4 -->
														<div class="col-xl-3 col-md-6">
															<div class="process-step-card">
																<div class="step-number-circle"><?php echo esc_html($p_num4); ?></div>
																<h4 class="step-card-title"><?php echo esc_html( $p_title4 ); ?></h4>
																<p class="step-card-desc"><?php echo esc_html( $p_desc4 ); ?></p>
															</div>
														</div>
													</div>
												</div>

												<!-- Symptoms Tab Content -->
												<div class="tab-pane fade" id="symptoms-content-<?php the_ID(); ?>" role="tabpanel" aria-labelledby="symptoms-tab-<?php the_ID(); ?>">
													<div class="row g-4">
														<!-- Symptom 1 -->
														<div class="col-xl-3 col-md-6">
															<div class="symptom-card">
																<img src="<?php echo esc_url($s_img1); ?>" alt="<?php echo esc_attr($s_title1); ?>">
																<div class="symptom-card-overlay">
																	<h4 class="symptom-card-title"><?php echo esc_html($s_title1); ?></h4>
																	<p class="symptom-card-desc"><?php echo esc_html($s_desc1); ?></p>
																</div>
															</div>
														</div>
														<!-- Symptom 2 -->
														<div class="col-xl-3 col-md-6">
															<div class="symptom-card">
																<img src="<?php echo esc_url($s_img2); ?>" alt="<?php echo esc_attr($s_title2); ?>">
																<div class="symptom-card-overlay">
																	<h4 class="symptom-card-title"><?php echo esc_html($s_title2); ?></h4>
																	<p class="symptom-card-desc"><?php echo esc_html($s_desc2); ?></p>
																</div>
															</div>
														</div>
														<!-- Symptom 3 -->
														<div class="col-xl-3 col-md-6">
															<div class="symptom-card">
																<img src="<?php echo esc_url($s_img3); ?>" alt="<?php echo esc_attr($s_title3); ?>">
																<div class="symptom-card-overlay">
																	<h4 class="symptom-card-title"><?php echo esc_html($s_title3); ?></h4>
																	<p class="symptom-card-desc"><?php echo esc_html($s_desc3); ?></p>
																</div>
															</div>
														</div>
														<!-- Symptom 4 -->
														<div class="col-xl-3 col-md-6">
															<div class="symptom-card">
																<img src="<?php echo esc_url($s_img4); ?>" alt="<?php echo esc_attr($s_title4); ?>">
																<div class="symptom-card-overlay">
																	<h4 class="symptom-card-title"><?php echo esc_html($s_title4); ?></h4>
																	<p class="symptom-card-desc"><?php echo esc_html($s_desc4); ?></p>
																</div>
															</div>
														</div>
													</div>
												</div>

												<!-- Key Benefits Tab Content -->
												<div class="tab-pane fade" id="benefits-content-<?php the_ID(); ?>" role="tabpanel" aria-labelledby="benefits-tab-<?php the_ID(); ?>">
													<div class="row g-4">
														<!-- Benefit 1 -->
														<div class="col-xl-3 col-md-6">
															<div class="benefits-step-card">
																<div class="step-number-circle"><?php echo esc_html($b_num1); ?></div>
																<h4 class="benefits-card-title"><?php echo esc_html( $b_title1 ); ?></h4>
																<p class="benefits-card-desc"><?php echo esc_html( $b_desc1 ); ?></p>
															</div>
														</div>
														<!-- Benefit 2 -->
														<div class="col-xl-3 col-md-6">
															<div class="benefits-step-card">
																<div class="step-number-circle"><?php echo esc_html($b_num2); ?></div>
																<h4 class="benefits-card-title"><?php echo esc_html( $b_title2 ); ?></h4>
																<p class="benefits-card-desc"><?php echo esc_html( $b_desc2 ); ?></p>
															</div>
														</div>
														<!-- Benefit 3 -->
														<div class="col-xl-3 col-md-6">
															<div class="benefits-step-card">
																<div class="step-number-circle"><?php echo esc_html($b_num3); ?></div>
																<h4 class="benefits-card-title"><?php echo esc_html( $b_title3 ); ?></h4>
																<p class="benefits-card-desc"><?php echo esc_html( $b_desc3 ); ?></p>
															</div>
														</div>
														<!-- Benefit 4 -->
														<div class="col-xl-3 col-md-6">
															<div class="benefits-step-card">
																<div class="step-number-circle"><?php echo esc_html($b_num4); ?></div>
																<h4 class="benefits-card-title"><?php echo esc_html( $b_title4 ); ?></h4>
																<p class="benefits-card-desc"><?php echo esc_html( $b_desc4 ); ?></p>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>

									<!-- Results / Reviews Section -->
									<?php if ( $show_smile_gallery && ! empty( $gallery_slides ) ) : ?>
										<!-- Smile Gallery Section -->
										<div id="modal-gallery-<?php the_ID(); ?>" class="modal-section cosmetic-modal-gallery-section <?php echo ( count( $gallery_slides ) > 1 ) ? 'has-gallery-slides' : ''; ?>" style="--modal-gallery-slides: <?php echo esc_attr( max( 1, count( $gallery_slides ) ) ); ?>;">
											<div class="modal-gallery-sticky-wrapper">
												<div class="gallery-header-row mb-5">
													<div class="gallery-header-badge">
														<h2 class="gallery-header-title">
															<span class="light">Smile </span><span class="accent">Gallery</span>
														</h2>
													</div>
													<p class="gallery-header-desc">These joyful smiles from our patients truly reflect their trust in the services provided by Waterside Dental.</p>
												</div>

												<div class="gallery-content-layout">
													<div class="gallery-left-col">
														<div class="gallery-interactive-wrapper">
															<?php foreach ( $gallery_slides as $gallery_slide_index => $gallery_slide ) : ?>
																<div class="gallery-slide <?php echo ( 0 === $gallery_slide_index ) ? 'active' : ''; ?>" data-index="<?php echo esc_attr( $gallery_slide_index + 1 ); ?>">
																	<div class="gallery-image-pair-container">
																		<!-- Before Card -->
																		<div class="gallery-card before-card">
																			<div class="gallery-card-image-wrapper">
																				<img src="<?php echo esc_url( $gallery_slide['before_image'] ); ?>" alt="Before treatment" class="gallery-img before-img-crop1">
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
																				<img src="<?php echo esc_url( $gallery_slide['after_image'] ); ?>" alt="After treatment" class="gallery-img after-img-crop1">
																			</div>
																			<div class="gallery-card-label">After</div>
																		</div>
																	</div>
																</div>
															<?php endforeach; ?>
														</div>
													</div>

													<!-- Right Column: Detail Cards & Button & Scroll Indicator -->
													<div class="gallery-right-col">
														<div class="gallery-info-wrapper">
															<!-- Detail Cards Grid -->
															<div class="gallery-details-grid">
																<?php foreach ( $gallery_slides as $gallery_slide_index => $gallery_slide ) : ?>
																	<div class="gallery-details-data <?php echo ( 0 === $gallery_slide_index ) ? 'active' : ''; ?>" data-index="<?php echo esc_attr( $gallery_slide_index + 1 ); ?>">
																		<div class="gallery-detail-card">
																			<span class="detail-label">Treatment</span>
																			<span class="detail-value"><?php echo esc_html( $gallery_slide['treatment'] ); ?></span>
																		</div>
																		<div class="gallery-detail-card">
																			<span class="detail-label">Main Concern</span>
																			<span class="detail-value"><?php echo esc_html( $gallery_slide['concern'] ); ?></span>
																		</div>
																		<div class="gallery-detail-card">
																			<span class="detail-label">Duration</span>
																			<span class="detail-value"><?php echo esc_html( $gallery_slide['duration'] ); ?></span>
																		</div>
																		<div class="gallery-detail-card">
																			<span class="detail-label">Visits</span>
																			<span class="detail-value"><?php echo esc_html( $gallery_slide['visits'] ); ?></span>
																		</div>
																	</div>
																<?php endforeach; ?>
															</div>
															<div class="gallery-btn-wrapper">
																<a href="<?php echo esc_url( home_url( '/smile-gallery/' ) ); ?>" class="btn btn-gallery-action">View Smile Gallery</a>
															</div>
														</div>

														<!-- Scroll Indicator vertical track/handle -->
														<div class="gallery-scroll-indicator-container">
															<div class="gallery-scroll-indicator-track"></div>
															<div class="gallery-scroll-indicator-handle"></div>
														</div>
													</div>
												</div>
											</div>
										</div>
									<?php elseif ( ! empty( $review_slides ) ) : ?>
										<!-- Review Design Section -->
										<div id="modal-gallery-<?php the_ID(); ?>" class="modal-section cosmetic-modal-reviews-section">
											<div class="reviews-header-row">
												<div class="reviews-rating-badge">
													<span class="google-logo-wrapper">
														<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/google.svg' ); ?>" alt="Google" style="width: 32px; height: 33px;">
													</span>
													<a href="https://www.google.com" target="_blank" rel="noopener noreferrer" class="reviews-rating-link">4.9/5 Rating</a>
													<span class="reviews-dot"></span>
													<span class="reviews-header-title">What Our Patients think</span>
												</div>
												<?php if ( count( $review_slides ) > 1 ) : ?>
													<div class="reviews-nav-buttons">
														<button class="reviews-nav-btn prev-btn" aria-label="Previous testimonial" type="button">
															<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/left_arrow.svg' ); ?>" alt="Previous">
														</button>
														<button class="reviews-nav-btn next-btn" aria-label="Next testimonial" type="button">
															<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/right_arrow.svg' ); ?>" alt="Next">
														</button>
													</div>
												<?php endif; ?>
											</div>

											<div class="reviews-content-row">
												<div class="review-quote-mark left-quote">“</div>
												
												<div class="reviews-slider-container">
													<?php foreach ( $review_slides as $review_slide_index => $review_slide ) : ?>
														<div class="modal-review-slide <?php echo ( 0 === $review_slide_index ) ? 'active' : ''; ?>" data-index="<?php echo esc_attr( $review_slide_index ); ?>">
															<h3 class="review-slide-title">“<?php echo esc_html( $review_slide['title'] ); ?>”</h3>
															<p class="review-slide-text"><?php echo esc_html( $review_slide['text'] ); ?></p>
															<div class="review-author">
																<div class="review-slide-stars">
																	<?php for ( $i = 0; $i < intval( $review_slide['rating'] ); $i++ ) : ?>
																		<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/star.svg' ); ?>" alt="">
																	<?php endfor; ?>
																</div>
																<?php if ( $review_slide['author'] ) : ?>
																	<p class="review-slide-author"><?php echo esc_html( $review_slide['author'] ); ?></p>
																<?php endif; ?>
																</div>
														</div>
													<?php endforeach; ?>
												</div>

												<div class="review-quote-mark right-quote">”</div>
											</div>

											<?php if ( count( $review_slides ) > 1 ) : ?>
												<div class="reviews-progress-track">
													<div class="reviews-progress-bar"></div>
												</div>
											<?php endif; ?>
										</div>
									<?php endif; ?>

									<!-- Fees Section -->
									<div id="modal-fees-<?php the_ID(); ?>" class="modal-section cosmetic-modal-fees-section">
										<?php if ( ! empty( $fee_rows ) ) : ?>
											<div class="cosmetic-fees-box mx-auto">
												<div class="fees-box-header">
													<h3><?php the_title(); ?> <span class="accent">Fees</span></h3>
													<p>Smile makeovers are tailored to each patient's needs and may involve a combination of cosmetic treatments. Following your consultation, a personalised treatment plan and fee estimate will be provided.</p>
												</div>
												<div class="fees-box-body">
													<?php foreach ( $fee_rows as $fee_row_index => $fee_row ) : ?>
														<div class="fee-row d-flex justify-content-between align-items-center <?php echo ( $fee_row_index < count( $fee_rows ) - 1 ) ? 'border-bottom' : ''; ?>">
															<span class="fee-name"><?php echo esc_html( $fee_row['title'] ); ?></span>
															<span class="fee-price"><?php echo esc_html( $fee_row['value'] ); ?></span>
														</div>
													<?php endforeach; ?>
												</div>
											</div>
										<?php elseif ( ! empty( $accordion_rows ) ) : ?>
											<div class="cosmetic-accordion-box mx-auto">
												<?php if ( $accordion_title_part_1 || $accordion_title_part_2 || $accordion_sub_title ) : ?>
													<div class="cosmetic-accordion-section-header">
														<?php if ( $accordion_title_part_1 || $accordion_title_part_2 ) : ?>
															<h3>
																<?php echo esc_html( $accordion_title_part_1 ); ?>
																<?php if ( $accordion_title_part_2 ) : ?>
																	<span class="accent"><?php echo esc_html( $accordion_title_part_2 ); ?></span>
																<?php endif; ?>
															</h3>
														<?php endif; ?>
														<?php if ( $accordion_sub_title ) : ?>
															<p><?php echo esc_html( $accordion_sub_title ); ?></p>
														<?php endif; ?>
													</div>
												<?php endif; ?>

												<div class="cosmetic-accordion-list" id="modal-accordion-<?php the_ID(); ?>">
													<?php foreach ( $accordion_rows as $accordion_row_index => $accordion_row ) : 
														$accordion_collapse_id = 'modal-accordion-' . get_the_ID() . '-' . $accordion_row_index;
														$is_first_accordion_row = ( 0 === $accordion_row_index );
														?>
														<div class="cosmetic-accordion-item">
															<button class="cosmetic-accordion-trigger <?php echo $is_first_accordion_row ? '' : 'collapsed'; ?>" type="button" aria-expanded="<?php echo $is_first_accordion_row ? 'true' : 'false'; ?>" aria-controls="<?php echo esc_attr( $accordion_collapse_id ); ?>">
																<span><?php echo esc_html( $accordion_row['title'] ); ?></span>
																<span class="cosmetic-accordion-icon" aria-hidden="true">
																	<svg class="cosmetic-accordion-icon-svg accordion-icon-up" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
																		<path d="M12.854 7.35463C12.8076 7.40112 12.7524 7.438 12.6917 7.46316C12.631 7.48832 12.566 7.50127 12.5003 7.50127C12.4346 7.50127 12.3695 7.48832 12.3088 7.46316C12.2481 7.438 12.193 7.40112 12.1465 7.35463L8.50028 3.70776L8.50028 13.5009C8.50028 13.6335 8.4476 13.7607 8.35383 13.8544C8.26007 13.9482 8.13289 14.0009 8.00028 14.0009C7.86767 14.0009 7.74049 13.9482 7.64673 13.8544C7.55296 13.7607 7.50028 13.6335 7.50028 13.5009L7.50028 3.70776L3.85403 7.35463C3.76021 7.44845 3.63296 7.50116 3.50028 7.50116C3.3676 7.50116 3.24035 7.44845 3.14653 7.35463C3.05271 7.26081 3 7.13356 3 7.00088C3 6.8682 3.05271 6.74095 3.14653 6.64713L7.64653 2.14713C7.69296 2.10064 7.74811 2.06376 7.80881 2.0386C7.86951 2.01344 7.93457 2.00049 8.00028 2.00049C8.06599 2.00049 8.13105 2.01344 8.19175 2.0386C8.25245 2.06376 8.30759 2.10064 8.35403 2.14713L12.854 6.64713C12.9005 6.69357 12.9374 6.74871 12.9626 6.80941C12.9877 6.87011 13.0007 6.93517 13.0007 7.00088C13.0007 7.06659 12.9877 7.13165 12.9626 7.19235C12.9374 7.25305 12.9005 7.30819 12.854 7.35463Z" fill="currentColor"/>
																	</svg>
																	<svg class="cosmetic-accordion-icon-svg accordion-icon-down" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
																		<path d="M3.12797 8.49969C3.17578 8.45462 3.23201 8.41941 3.29344 8.39609C3.35487 8.37277 3.42029 8.36178 3.48597 8.36376C3.55165 8.36573 3.61629 8.38064 3.67621 8.40761C3.73612 8.43459 3.79013 8.47311 3.83515 8.52098L7.37 12.2759L7.66471 2.48724C7.6687 2.35469 7.72518 2.22916 7.82173 2.13826C7.91828 2.04735 8.04698 1.99852 8.17953 2.00251C8.31208 2.00651 8.43761 2.06299 8.52852 2.15953C8.61942 2.25608 8.66825 2.38479 8.66426 2.51734L8.36954 12.306L12.1239 8.77053C12.2205 8.67958 12.3493 8.63072 12.4819 8.63471C12.6145 8.63871 12.7401 8.69522 12.8311 8.79182C12.922 8.88842 12.9709 9.0172 12.9669 9.14982C12.9629 9.28244 12.9064 9.40805 12.8098 9.499L8.1764 13.8615C8.12858 13.9066 8.07235 13.9418 8.01092 13.9651C7.94949 13.9885 7.88407 13.9994 7.81839 13.9975C7.75272 13.9955 7.68807 13.9806 7.62816 13.9536C7.56824 13.9266 7.51423 13.8881 7.46922 13.8402L3.10668 9.20687C3.06161 9.15905 3.0264 9.10282 3.00308 9.04139C2.97975 8.97997 2.96877 8.91454 2.97074 8.84886C2.97272 8.78319 2.98763 8.71854 3.0146 8.65863C3.04158 8.59871 3.0801 8.5447 3.12797 8.49969Z" fill="currentColor"/>
																	</svg>
																</span>
															</button>
															<div id="<?php echo esc_attr( $accordion_collapse_id ); ?>" class="cosmetic-accordion-panel <?php echo $is_first_accordion_row ? 'active' : ''; ?>">
																<div class="cosmetic-accordion-content">
																	<?php echo esc_html( $accordion_row['content'] ); ?>
																</div>
															</div>
														</div>
													<?php endforeach; ?>
												</div>
											</div>
										<?php endif; ?>
									</div>

									<!-- More Services Section -->
									<?php
									$other_services_query = new WP_Query( array(
										'post_type'      => 'services',
										'post_parent'    => $parent_id,
										'posts_per_page' => -1,
										'post__not_in'   => array( get_the_ID() ),
										'orderby'        => 'menu_order',
										'order'          => 'ASC'
									) );
									
									if ( $other_services_query->have_posts() ) :
									?>
									<div class="cosmetic-modal-more-services-section">
										<div class="more-services-header d-flex align-items-center justify-content-between mb-5">
											<h3 class="more-services-title">More <?php echo esc_html( $category_name ); ?> services</h3>
											<div class="more-services-nav d-flex gap-3">
												<button class="more-services-nav-btn prev-btn" aria-label="Previous service" type="button">
													<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/left_arrow.svg' ); ?>" alt="Previous">
												</button>
												<button class="more-services-nav-btn next-btn" aria-label="Next service" type="button">
													<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/right_arrow.svg' ); ?>" alt="Next">
												</button>
											</div>
										</div>

										<div class="more-services-slider-container">
											<div class="more-services-slider-track d-flex gap-4">
												<?php 
												foreach ( $other_services_query->posts as $other_post ) :
													$card_img = get_the_post_thumbnail_url( $other_post->ID, 'large' );
													if ( !$card_img ) {
														$card_img = get_template_directory_uri() . '/assets/images/cosmetic-hero.png';
													}
													$fallback_card_img = get_template_directory_uri() . '/assets/images/cosmetic-hero.png';
												?>
												<div class="more-service-card-wrapper">
													<a href="javascript:void(0)" class="more-service-card" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#sub-service-modal-<?php echo $other_post->ID; ?>">
														<div class="more-service-card-image">
															<img src="<?php echo esc_url( $card_img ); ?>" alt="<?php echo esc_attr( $other_post->post_title ); ?>" onerror="this.onerror=null;this.src='<?php echo esc_url( $fallback_card_img ); ?>';">
														</div>
														<div class="more-service-card-footer d-flex align-items-center justify-content-between mt-3">
															<span class="more-service-card-title"><?php echo esc_html( $other_post->post_title ); ?></span>
															<div class="more-service-card-arrow">
																<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-gold-circle.svg' ); ?>" alt="" style="width: 40px; height: 40px;">
															</div>
														</div>
													</a>
												</div>
												<?php endforeach; ?>
											</div>
										</div>

										<div class="more-services-progress-wrapper mt-5">
											<div class="more-services-progress-track">
												<div class="more-services-progress-bar"></div>
											</div>
										</div>
									</div>
									<?php 
									endif; 
									?>
								</div>
							</div>
						</div>
					</div>
					<?php 
				endwhile;
				wp_reset_postdata();
			endif;
			?>

			<!-- Custom Membership Section -->
			<section class="cosmetic-membership-section">
				<div class="container-fluid px-lg-0">
					<div class="cosmetic-membership-card">
						<div class="cosmetic-membership-img-col">
							<!-- 2 visits / year included Badge -->
							<div class="cosmetic-membership-badge">
								<span class="cosmetic-membership-badge-dot"></span>
								<span class="cosmetic-membership-badge-text">2 visits / year included</span>
							</div>
							<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/cosmetic-membership.png' ); ?>" alt="View Membership">
						</div>
						<div class="cosmetic-membership-content-col">
							<div class="cosmetic-membership-info">
								<h2 class="cosmetic-membership-title">
									View <span class="accent">Membership</span>
								</h2>
								<p class="cosmetic-membership-desc">
									Members save 15% on hygiene visits. Our monthly plan includes two hygiene appointments per year plus routine examinations — all for one simple monthly payment.
								</p>
								<p class="cosmetic-membership-price">
									From <span class="price-amount">£14.95/</span><span class="price-amount">month</span>
								</p>
							</div>

							<!-- Benefits List -->
							<div class="cosmetic-membership-benefits">
								<div class="cosmetic-membership-benefit-item">
									<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/check-gold.svg' ); ?>" class="cosmetic-membership-benefit-icon" alt="">
									<p class="cosmetic-membership-benefit-text">2 hygiene appointments every year</p>
								</div>
								<div class="cosmetic-membership-benefit-item">
									<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/check-gold.svg' ); ?>" class="cosmetic-membership-benefit-icon" alt="">
									<p class="cosmetic-membership-benefit-text">Routine examinations included</p>
								</div>
								<div class="cosmetic-membership-benefit-item">
									<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/check-gold.svg' ); ?>" class="cosmetic-membership-benefit-icon" alt="">
									<p class="cosmetic-membership-benefit-text">15% off additional treatments</p>
								</div>
							</div>

							<!-- CTAs -->
							<div class="cosmetic-membership-ctas">
								<a href="<?php echo esc_url( home_url( '/membership/' ) ); ?>" class="btn-view-plan">View membership</a>
								<a href="#appointment-cta" class="btn-book-outline">Book an appointment</a>
							</div>
						</div>
					</div>
				</div>
			</section>

		<?php else : ?>

			<!-- Service Hero Section -->
			<section class="hero-section service-single-hero">
				<!-- Background waves vector -->
				<div class="hero-bg-waves-wrapper">
					<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/hero-bg-waves.svg' ); ?>" alt="" class="hero-bg-waves">
				</div>

				<div class="container-fluid px-lg-120 h-100 position-relative z-3">
					<div class="row align-items-center h-100">
						<div class="col-lg-7 hero-content-col">
							<div class="hero-content">
								<?php if ( $category_name ) : ?>
									<div class="service-category-badge mb-3">
										<span class="gold-badge-text"><?php echo esc_html( $category_name ); ?></span>
									</div>
								<?php endif; ?>
								
								<h1 class="hero-title"><?php the_title(); ?></h1>
								
								<?php if ( has_excerpt() ) : ?>
									<p class="hero-description"><?php echo get_the_excerpt(); ?></p>
								<?php endif; ?>
								
								<div class="hero-buttons">
									<a href="#appointment-cta" class="btn btn-primary">Book an appointment</a>
									<a href="javascript:history.back()" class="btn btn-secondary">Back to Services</a>
								</div>
							</div>
						</div>
						<div class="col-lg-5 hero-image-col">
							<div class="hero-image-wrapper">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php the_post_thumbnail( 'large', array( 'class' => 'hero-img' ) ); ?>
								<?php else : ?>
									<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/general-dentistry.png' ); ?>" alt="<?php the_title_attribute(); ?>" class="hero-img">
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			</section>

			<!-- Service Content Details -->
			<section class="service-details-section py-5">
				<div class="container-fluid px-lg-120">
					<div class="row justify-content-center">
						<div class="col-lg-10">
							<div class="service-content-body">
								<div class="entry-content">
									<?php the_content(); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>

		<?php endif; ?>

		<!-- Book Appointment CTA Section -->
		<!-- <section class="book-appointment-section" id="appointment-cta">
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

	<?php endwhile; ?>

</main>

<?php
get_footer();
