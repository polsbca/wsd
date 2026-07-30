<?php
/**
 * The template for displaying search results
 *
 * @package wsd
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$search_query = get_search_query();
$result_count = (int) $GLOBALS['wp_query']->found_posts;
?>

	<main id="main" class="site-main search-results-main">
		<section class="search-results-section">
			<div class="container-fluid px-lg-120">
				<header class="search-results-header">
					<h1 class="search-results-title">
						<?php
						if ( $search_query ) {
							printf(
								/* translators: %s: search query */
								esc_html__( 'Search results for “%s”', 'wsd' ),
								esc_html( $search_query )
							);
						} else {
							esc_html_e( 'Search', 'wsd' );
						}
						?>
					</h1>
					<p class="search-results-count">
						<?php
						printf(
							/* translators: %d: number of search results */
							esc_html( _n( '%d result found', '%d results found', $result_count, 'wsd' ) ),
							$result_count
						);
						?>
					</p>
				</header>

				<?php if ( have_posts() ) : ?>
					<div class="search-results-list">
						<?php
						while ( have_posts() ) {
							the_post();
							$post_type_object = get_post_type_object( get_post_type() );
							$type_label       = $post_type_object && ! empty( $post_type_object->labels->singular_name )
								? $post_type_object->labels->singular_name
								: __( 'Content', 'wsd' );
							?>
							<article id="post-<?php the_ID(); ?>" <?php post_class( 'search-result-card' ); ?>>
								<span class="search-result-type"><?php echo esc_html( $type_label ); ?></span>
								<h2 class="search-result-title">
									<a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a>
								</h2>
								<?php if ( has_excerpt() || get_the_content() ) : ?>
									<div class="search-result-excerpt">
										<?php echo esc_html( wp_trim_words( get_the_excerpt() ? get_the_excerpt() : wp_strip_all_tags( get_the_content() ), 28 ) ); ?>
									</div>
								<?php endif; ?>
								<a class="search-result-link" href="<?php echo esc_url( get_permalink() ); ?>">
									<?php esc_html_e( 'View details', 'wsd' ); ?>
								</a>
							</article>
							<?php
						}
						?>
					</div>

					<div class="search-results-pagination">
						<?php
						the_posts_pagination(
							array(
								'prev_text' => esc_html__( 'Previous', 'wsd' ),
								'next_text' => esc_html__( 'Next', 'wsd' ),
							)
						);
						?>
					</div>
				<?php else : ?>
					<div class="search-results-empty">
						<p><?php esc_html_e( 'Nothing matched your search. Try a different keyword.', 'wsd' ); ?></p>
						<a class="search-results-home-link" href="<?php echo esc_url( home_url( '/' ) ); ?>">
							<?php esc_html_e( 'Back to home', 'wsd' ); ?>
						</a>
					</div>
				<?php endif; ?>
			</div>
		</section>
	</main>

<?php
get_footer();
