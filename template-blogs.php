<?php
/**
 * Template Name: Blogs Page Template
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

$theme_uri       = get_template_directory_uri();
$page_id         = get_the_ID();
$hero_alt        = __( 'Dental clinician providing patient care', 'wsd' );
$hero_image      = wsd_get_blogs_hero_image_url( $page_id );
$blog_posts      = wsd_get_blog_posts( 6 );
$featured_post   = ! empty( $blog_posts ) ? $blog_posts[0] : null;
$grid_posts      = $blog_posts;
$blog_categories = wsd_get_blog_filter_categories();
$smile_gallery_url = wsd_get_smile_gallery_page_url();

if ( $page_id && has_post_thumbnail( $page_id ) ) {
	$thumbnail_alt = get_post_meta( (int) get_post_thumbnail_id( $page_id ), '_wp_attachment_image_alt', true );
	if ( $thumbnail_alt ) {
		$hero_alt = $thumbnail_alt;
	}
}

/**
 * Render blog meta row (date, comments, read time).
 *
 * @param array  $post_data Post card data.
 * @param string $variant   gold|white.
 */
$render_blog_meta = static function ( $post_data, $variant = 'gold' ) use ( $theme_uri ) {
	$suffix = ( 'white' === $variant ) ? '-white' : '';
	?>
	<div class="blogs-meta blogs-meta--<?php echo esc_attr( $variant ); ?>">
		<span class="blogs-meta-item">
			<img src="<?php echo esc_url( $theme_uri . '/assets/images/blog-icon-calendar' . $suffix . '.svg' ); ?>" alt="" width="20" height="20" class="blogs-meta-icon">
			<span><?php echo esc_html( $post_data['date'] ); ?></span>
		</span>
		<span class="blogs-meta-item">
			<img src="<?php echo esc_url( $theme_uri . '/assets/images/blog-icon-comments' . $suffix . '.svg' ); ?>" alt="" width="20" height="20" class="blogs-meta-icon">
			<span><?php echo esc_html( $post_data['comments_label'] ); ?></span>
		</span>
		<span class="blogs-meta-item">
			<img src="<?php echo esc_url( $theme_uri . '/assets/images/blog-icon-timer' . $suffix . '.svg' ); ?>" alt="" width="20" height="20" class="blogs-meta-icon">
			<span><?php echo esc_html( $post_data['read_time'] ); ?></span>
		</span>
	</div>
	<?php
};

?>

<main id="main" class="site-main blogs-page-main">

	<section class="blogs-hero-page" aria-labelledby="blogs-hero-heading">
		<div class="blogs-hero-inner">
			<div class="blogs-hero-content-col">
				<div class="blogs-hero-copy">
					<h1 id="blogs-hero-heading" class="blogs-hero-title hero-title">
						<span class="blogs-hero-title-main"><?php esc_html_e( 'Dental insights & practice ', 'wsd' ); ?></span>
						<span class="blogs-hero-title-accent"><?php esc_html_e( 'news', 'wsd' ); ?></span>
					</h1>
					<p class="blogs-hero-description hero-description">
						<?php esc_html_e( 'Tips, treatment guides and updates from our clinical team in Rochdale — written to help you make confident decisions about your smile.', 'wsd' ); ?>
					</p>
				</div>
				<div class="hero-buttons">
					<a href="<?php echo esc_url( home_url( '/#book-appointment' ) ); ?>" class="btn btn-primary hero-book-appointment-btn"><span><?php esc_html_e( 'Book an appointment', 'wsd' ); ?></span></a>
					<a href="<?php echo esc_url( $smile_gallery_url ); ?>" class="btn btn-secondary blogs-hero-cta">
						<span><?php esc_html_e( 'Smile Gallery', 'wsd' ); ?></span>
					</a>
				</div>
			</div>
			<div class="blogs-hero-image-col">
				<div class="blogs-hero-image-frame hero-image-wrapper">
					<?php
					if ( $page_id && has_post_thumbnail( $page_id ) ) {
						echo wp_get_attachment_image(
							(int) get_post_thumbnail_id( $page_id ),
							'full',
							false,
							array(
								'class'    => 'blogs-hero-img',
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
						class="blogs-hero-img"
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

	<?php if ( $featured_post ) : ?>
	<section class="blogs-featured-section" aria-labelledby="blogs-featured-heading">
		<div class="blogs-featured-inner">
			<article class="blogs-featured-card">
				<div class="blogs-featured-media">
					<img
						src="<?php echo esc_url( $featured_post['image_url'] ); ?>"
						alt="<?php echo esc_attr( $featured_post['image_alt'] ); ?>"
						class="blogs-featured-img"
						width="872"
						height="533"
						loading="eager"
						decoding="async"
					>
					<span class="blogs-featured-badge"><?php esc_html_e( 'Featured article', 'wsd' ); ?></span>
				</div>
				<div class="blogs-featured-content">
					<p id="blogs-featured-heading" class="blogs-featured-eyebrow"><?php esc_html_e( 'Most recent article', 'wsd' ); ?></p>
					<div class="blogs-featured-body">
						<h2 class="blogs-featured-title">
							<a href="<?php echo esc_url( $featured_post['permalink'] ); ?>"><?php echo esc_html( $featured_post['title'] ); ?></a>
						</h2>
						<?php $render_blog_meta( $featured_post, 'gold' ); ?>
						<?php if ( ! empty( $featured_post['excerpt'] ) ) : ?>
							<p class="blogs-featured-excerpt"><?php echo esc_html( $featured_post['excerpt'] ); ?></p>
						<?php endif; ?>
					</div>
					<a href="<?php echo esc_url( $featured_post['permalink'] ); ?>" class="btn btn-primary blogs-read-btn blogs-read-btn--featured">
						<span><?php esc_html_e( 'Read Full Article', 'wsd' ); ?></span>
					</a>
				</div>
			</article>
		</div>
	</section>
	<?php endif; ?>

	<section id="all-blogs" class="blogs-listing-section" aria-labelledby="blogs-listing-heading">
		<div class="blogs-listing-inner">
			<div class="blogs-listing-header">
				<h2 id="blogs-listing-heading" class="blogs-listing-title">
					<span class="blogs-listing-title-main"><?php esc_html_e( 'All ', 'wsd' ); ?></span>
					<span class="blogs-listing-title-accent"><?php esc_html_e( 'blogs', 'wsd' ); ?></span>
				</h2>
				<div class="blogs-filters">
					<button type="button" class="blogs-filter-all is-active" data-filter="all" aria-pressed="true">
						<span><?php esc_html_e( 'All', 'wsd' ); ?></span>
					</button>
					<button
						type="button"
						class="blogs-filter-browse"
						aria-expanded="false"
						aria-controls="blogs-filter-panel"
					>
						<span class="blogs-filter-browse-label"><?php esc_html_e( 'Browse by Filters', 'wsd' ); ?></span>
						<img src="<?php echo esc_url( $theme_uri . '/assets/images/filter-equalizer.svg' ); ?>" alt="" width="24" height="24" class="blogs-filter-browse-icon">
					</button>
				</div>
			</div>

			<div
				id="blogs-filter-panel"
				class="blogs-filter-panel"
				role="dialog"
				aria-modal="true"
				aria-labelledby="blogs-filter-panel-title"
				hidden
			>
				<button type="button" class="blogs-filter-panel-backdrop" aria-label="<?php esc_attr_e( 'Close filters', 'wsd' ); ?>"></button>
				<div class="blogs-filter-panel-sheet">
					<div class="blogs-filter-panel-header">
						<h3 id="blogs-filter-panel-title" class="blogs-filter-panel-title"><?php esc_html_e( 'Browse by Filters', 'wsd' ); ?></h3>
						<button type="button" class="blogs-filter-panel-close" aria-label="<?php esc_attr_e( 'Close', 'wsd' ); ?>">&times;</button>
					</div>
					<div class="blogs-filter-panel-options" role="listbox" aria-label="<?php esc_attr_e( 'Blog categories', 'wsd' ); ?>">
						<?php foreach ( $blog_categories as $category ) : ?>
							<button
								type="button"
								class="blogs-filter-panel-option"
								role="option"
								data-filter="<?php echo esc_attr( $category->slug ); ?>"
								data-label="<?php echo esc_attr( $category->name ); ?>"
							>
								<span><?php echo esc_html( $category->name ); ?></span>
							</button>
						<?php endforeach; ?>
					</div>
				</div>
			</div>

			<?php if ( ! empty( $grid_posts ) ) : ?>
			<div class="blogs-grid" data-blogs-grid>
				<?php foreach ( $grid_posts as $blog_post ) : ?>
					<?php
					$category_attr = ! empty( $blog_post['category_slugs'] )
						? implode( ' ', array_map( 'sanitize_title', $blog_post['category_slugs'] ) )
						: '';
					?>
					<article
						class="blogs-card"
						data-category-slugs="<?php echo esc_attr( $category_attr ); ?>"
					>
						<div class="blogs-card-media">
							<img
								src="<?php echo esc_url( $blog_post['image_url'] ); ?>"
								alt="<?php echo esc_attr( $blog_post['image_alt'] ); ?>"
								class="blogs-card-img"
								width="535"
								height="797"
								loading="lazy"
								decoding="async"
							>
							<div class="blogs-card-overlay" aria-hidden="true"></div>
						</div>
						<div class="blogs-card-content">
							<div class="blogs-card-copy">
								<h3 class="blogs-card-title">
									<a href="<?php echo esc_url( $blog_post['permalink'] ); ?>"><?php echo esc_html( $blog_post['title'] ); ?></a>
								</h3>
								<?php $render_blog_meta( $blog_post, 'white' ); ?>
								<?php if ( ! empty( $blog_post['excerpt'] ) ) : ?>
									<p class="blogs-card-excerpt"><?php echo esc_html( $blog_post['excerpt'] ); ?></p>
								<?php endif; ?>
							</div>
							<a href="<?php echo esc_url( $blog_post['permalink'] ); ?>" class="btn btn-primary blogs-read-btn blogs-read-btn--card">
								<span><?php esc_html_e( 'Read Full Article', 'wsd' ); ?></span>
							</a>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
			<p class="blogs-empty-state" hidden><?php esc_html_e( 'No articles found for this filter.', 'wsd' ); ?></p>
			<?php else : ?>
			<p class="blogs-empty-state is-visible"><?php esc_html_e( 'No blog articles published yet.', 'wsd' ); ?></p>
			<?php endif; ?>
		</div>
	</section>

</main>

<?php
get_footer();
