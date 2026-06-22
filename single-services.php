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
		if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
			$category_name = $categories[0]->name;
		}
		?>

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

		<!-- Book Appointment CTA Section -->
		<section class="book-appointment-section" id="appointment-cta">
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
		</section>

	<?php endwhile; ?>

</main>

<?php
get_footer();
