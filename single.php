<?php
/**
 * The template for displaying single blog posts.
 *
 * Desktop design: Figma 4078:37103
 *
 * @package wsd
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$theme_uri = get_template_directory_uri();

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
			<img src="<?php echo esc_url( $theme_uri . '/assets/images/blog-icon-timer' . $suffix . '.svg' ); ?>" alt="" width="20" height="20" class="blogs-meta-icon">
			<span><?php echo esc_html( $post_data['comments_label'] ); ?></span>
		</span>
		<span class="blogs-meta-item">
			<img src="<?php echo esc_url( $theme_uri . '/assets/images/blog-icon-comments' . $suffix . '.svg' ); ?>" alt="" width="20" height="20" class="blogs-meta-icon">
			<span><?php echo esc_html( $post_data['read_time'] ); ?></span>
		</span>
	</div>
	<?php
};
?>

<main id="main" class="site-main blog-detail-main">

	<?php
	while ( have_posts() ) {
		the_post();

		$post_id         = get_the_ID();
		$comment_count   = (int) get_comments_number( $post_id );
		$like_count      = wsd_get_blog_like_count( $post_id );
		$title_parts     = wsd_get_blog_title_parts( get_the_title() );
		$categories      = get_the_category( $post_id );
		$category_name   = ! empty( $categories ) ? $categories[0]->name : __( 'Dental Advice', 'wsd' );
		$author_name     = get_the_author() ? get_the_author() : __( 'Waterside Dental', 'wsd' );
		$image_url       = get_the_post_thumbnail_url( $post_id, 'full' );
		$image_alt       = '';
		$related_posts   = wsd_get_related_blog_posts( $post_id, 6 );

		if ( ! $image_url ) {
			$image_url = get_theme_file_uri( 'assets/images/blogs-hero.png' );
			$image_alt = get_the_title();
		} else {
			$image_alt = get_post_meta( (int) get_post_thumbnail_id( $post_id ), '_wp_attachment_image_alt', true );
			if ( ! $image_alt ) {
				$image_alt = get_the_title();
			}
		}

		$day   = get_the_date( 'd' );
		$month = get_the_date( 'M' );
		$time  = get_the_date( 'H:i' ) . 'h';
		?>

		<article id="post-<?php the_ID(); ?>" <?php post_class( 'blog-detail-article' ); ?>>

			<section class="blog-detail-hero" aria-label="<?php esc_attr_e( 'Article header', 'wsd' ); ?>">
				<div class="blog-detail-hero-pattern" aria-hidden="true">
					<img
						src="<?php echo esc_url( $theme_uri . '/assets/images/blog-detail-hero-pattern.svg' ); ?>"
						alt=""
						class="blog-detail-hero-pattern-img"
						width="2038"
						height="2015"
						loading="eager"
						decoding="async"
					>
				</div>
				<div class="blog-detail-hero-inner">
					<div class="blog-detail-hero-date">
						<span class="blog-detail-hero-day"><?php echo esc_html( $day ); ?></span>
						<span class="blog-detail-hero-month"><?php echo esc_html( $month ); ?></span>
					</div>

					<div class="blog-detail-hero-media">
						<img
							src="<?php echo esc_url( $image_url ); ?>"
							alt="<?php echo esc_attr( $image_alt ); ?>"
							class="blog-detail-hero-img"
							width="1234"
							height="664"
							loading="eager"
							decoding="async"
						>
					</div>

					<div class="blog-detail-hero-meta">
						<p class="blog-detail-hero-posted">
							<?php esc_html_e( 'Posted at', 'wsd' ); ?>
							<span class="blog-detail-hero-time"><?php echo esc_html( $time ); ?></span>
							<?php
							printf(
								/* translators: 1: category name, 2: author name */
								esc_html__( 'in %1$s by %2$s', 'wsd' ),
								esc_html( $category_name ),
								esc_html( $author_name )
							);
							?>
						</p>
						<div class="blog-detail-hero-stats">
							<p class="blog-detail-hero-stat">
								<span class="blog-detail-hero-stat-count"><?php echo esc_html( (string) $comment_count ); ?></span>
								<span class="blog-detail-hero-stat-label"><?php echo esc_html( _n( 'Comment', 'Comments', $comment_count, 'wsd' ) ); ?></span>
							</p>
							<p class="blog-detail-hero-stat">
								<span class="blog-detail-hero-stat-count"><?php echo esc_html( (string) $like_count ); ?></span>
								<span class="blog-detail-hero-stat-label"><?php echo esc_html( _n( 'Like', 'Likes', $like_count, 'wsd' ) ); ?></span>
							</p>
						</div>
					</div>
				</div>
			</section>

			<section class="blog-detail-content-section" aria-labelledby="blog-detail-title">
				<div class="blog-detail-content-inner">
					<header class="blog-detail-header">
						<h1 id="blog-detail-title" class="blog-detail-title">
							<?php if ( ! empty( $title_parts['main'] ) ) : ?>
								<span class="blog-detail-title-main"><?php echo esc_html( $title_parts['main'] ); ?></span>
							<?php endif; ?>
							<?php if ( ! empty( $title_parts['accent'] ) ) : ?>
								<span class="blog-detail-title-accent"><?php echo esc_html( $title_parts['accent'] ); ?></span>
							<?php endif; ?>
						</h1>
						<?php if ( has_excerpt() ) : ?>
							<p class="blog-detail-lead"><?php echo esc_html( get_the_excerpt() ); ?></p>
						<?php endif; ?>
					</header>

					<div class="blog-detail-body entry-content">
						<?php
						the_content();

						wp_link_pages(
							array(
								'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'wsd' ),
								'after'  => '</div>',
							)
						);
						?>
					</div>

					<?php if ( comments_open() || get_comments_number() ) : ?>
						<div class="blog-detail-comments-wrap">
							<?php comments_template(); ?>
						</div>
					<?php endif; ?>
				</div>
			</section>

		</article>

		<?php if ( ! empty( $related_posts ) ) : ?>
		<section class="blog-detail-related" aria-labelledby="blog-detail-related-heading">
			<div class="blog-detail-related-header">
				<h2 id="blog-detail-related-heading" class="blog-detail-related-title">
					<span class="blog-detail-related-title-main"><?php esc_html_e( 'Explore related ', 'wsd' ); ?></span>
					<span class="blog-detail-related-title-accent"><?php esc_html_e( 'blogs', 'wsd' ); ?></span>
				</h2>
				<?php if ( count( $related_posts ) > 3 ) : ?>
				<div class="blog-detail-related-nav" role="group" aria-label="<?php esc_attr_e( 'Related blogs navigation', 'wsd' ); ?>">
					<button type="button" class="blog-detail-related-nav-btn blog-detail-related-nav-btn--prev" aria-label="<?php esc_attr_e( 'Previous related blogs', 'wsd' ); ?>" disabled>
						<img src="<?php echo esc_url( $theme_uri . '/assets/images/left_arrow.svg' ); ?>" alt="" width="26" height="26">
					</button>
					<button type="button" class="blog-detail-related-nav-btn blog-detail-related-nav-btn--next is-active" aria-label="<?php esc_attr_e( 'Next related blogs', 'wsd' ); ?>">
						<img src="<?php echo esc_url( $theme_uri . '/assets/images/right_arrow.svg' ); ?>" alt="" width="26" height="26">
					</button>
				</div>
				<?php endif; ?>
			</div>

			<div class="blog-detail-related-viewport" data-related-viewport>
				<div class="blog-detail-related-track" data-related-track>
					<?php foreach ( $related_posts as $blog_post ) : ?>
						<article class="blogs-card blog-detail-related-card">
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
			</div>

			<?php if ( count( $related_posts ) > 1 ) : ?>
			<div
				class="blog-detail-related-dots"
				data-related-dots
				role="tablist"
				aria-label="<?php esc_attr_e( 'Related blogs pagination', 'wsd' ); ?>"
			></div>
			<?php endif; ?>
		</section>
		<?php endif; ?>

		<?php
	}
	?>

</main>

<?php
get_footer();
