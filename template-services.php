<?php
/**
 * Template Name: Services Page Template
 *
 * @package wsd
 */

get_header();
?>

<main id="main" class="site-main services-page-main">

	<!-- Services Hero Section -->
	<section class="hero-section services-hero">
		<!-- Background waves vector -->
		<div class="hero-bg-waves-wrapper">
			<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/hero-bg-waves.svg' ); ?>" alt="" class="hero-bg-waves">
		</div>

		<div class="container-fluid px-lg-120 h-100 position-relative z-3">
			<div class="row align-items-center h-100">
				<div class="col-lg-7 hero-content-col">
					<div class="hero-content">
						<h1 class="hero-title">Our Dental <span class="accent">Services</span></h1>
						<p class="hero-description">Discover our comprehensive range of treatments designed to keep your smile healthy, bright, and confident. From routine checkups to complete cosmetic transformations, we provide comfortable care tailored to you.</p>
						<div class="hero-buttons">
							<a href="#general-dentistry" class="btn btn-primary">General Dentistry</a>
							<a href="#cosmetic-dentistry" class="btn btn-secondary">Cosmetic Dentistry</a>
						</div>
					</div>
				</div>
				<div class="col-lg-5 hero-image-col">
					<div class="hero-image-wrapper">
						<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/general-dentistry.png' ); ?>" alt="Premium dental services" class="hero-img">
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- General Dentistry Section -->
	<section id="general-dentistry" class="services-list-section py-5">
		<div class="container-fluid px-lg-120">
			<div class="services-section-header mb-5">
				<h2 class="section-title">General <span class="accent">Dentistry</span></h2>
				<p class="section-desc">Maintain and restore your oral health with our comfort-first treatments.</p>
			</div>

			<div class="row g-4">
				<?php
				$general_query = new WP_Query( array(
					'post_type'      => 'services',
					'posts_per_page' => -1,
					'tax_query'      => array(
						array(
							'taxonomy' => 'service_category',
							'field'    => 'slug',
							'terms'    => 'general-dentistry',
						),
					),
				) );

				if ( $general_query->have_posts() ) :
					while ( $general_query->have_posts() ) : $general_query->the_post();
						?>
						<div class="col-lg-4 col-md-6">
							<div class="service-display-card">
								<?php if ( has_post_thumbnail() ) : ?>
									<div class="service-card-thumbnail">
										<?php the_post_thumbnail( 'large', array( 'class' => 'img-fluid' ) ); ?>
									</div>
								<?php else : ?>
									<div class="service-card-thumbnail placeholder-thumb">
										<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/general-dentistry.png' ); ?>" alt="<?php the_title_attribute(); ?>">
									</div>
								<?php endif; ?>
								
								<div class="service-card-body">
									<h3 class="service-card-title"><?php the_title(); ?></h3>
									<div class="service-card-excerpt">
										<?php the_excerpt(); ?>
									</div>
									<a href="<?php the_permalink(); ?>" class="btn btn-secondary w-100 mt-3">Learn More</a>
								</div>
							</div>
						</div>
						<?php
					endwhile;
					wp_reset_postdata();
				else :
					?>
					<div class="col-12 text-center py-5">
						<p class="no-services-found">No General Dentistry services found. Please add them in the WordPress admin.</p>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<!-- Cosmetic Dentistry Section -->
	<section id="cosmetic-dentistry" class="services-list-section py-5 bg-white">
		<div class="container-fluid px-lg-120">
			<div class="services-section-header mb-5">
				<h2 class="section-title">Cosmetic <span class="accent">Dentistry</span></h2>
				<p class="section-desc">Enhance your smile and boost your confidence with our customized cosmetic options.</p>
			</div>

			<div class="row g-4">
				<?php
				$cosmetic_query = new WP_Query( array(
					'post_type'      => 'services',
					'posts_per_page' => -1,
					'tax_query'      => array(
						array(
							'taxonomy' => 'service_category',
							'field'    => 'slug',
							'terms'    => 'cosmetic-dentistry',
						),
					),
				) );

				if ( $cosmetic_query->have_posts() ) :
					while ( $cosmetic_query->have_posts() ) : $cosmetic_query->the_post();
						?>
						<div class="col-lg-4 col-md-6">
							<div class="service-display-card">
								<?php if ( has_post_thumbnail() ) : ?>
									<div class="service-card-thumbnail">
										<?php the_post_thumbnail( 'large', array( 'class' => 'img-fluid' ) ); ?>
									</div>
								<?php else : ?>
									<div class="service-card-thumbnail placeholder-thumb">
										<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/cosmetic-dentistry.png' ); ?>" alt="<?php the_title_attribute(); ?>">
									</div>
								<?php endif; ?>
								
								<div class="service-card-body">
									<h3 class="service-card-title"><?php the_title(); ?></h3>
									<div class="service-card-excerpt">
										<?php the_excerpt(); ?>
									</div>
									<a href="<?php the_permalink(); ?>" class="btn btn-secondary w-100 mt-3">Learn More</a>
								</div>
							</div>
						</div>
						<?php
					endwhile;
					wp_reset_postdata();
				else :
					?>
					<div class="col-12 text-center py-5">
						<p class="no-services-found">No Cosmetic Dentistry services found. Please add them in the WordPress admin.</p>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>

</main>

<?php
get_footer();
