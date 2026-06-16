<?php
/**
 * The template for displaying archive pages
 *
 * @package wsd
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

	<main id="main" class="site-main">

		<?php
		if ( have_posts() ) {
			?>
			<header class="page-header">
				<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</header>

			<?php
			while ( have_posts() ) {
				the_post();
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' ); ?>

						<div class="entry-meta">
							<?php
							printf(
								esc_html__( 'Posted on %1$s', 'wsd' ),
								'<time class="entry-date published updated" datetime="' . esc_attr( get_the_date( 'c' ) ) . '">' . esc_html( get_the_date() ) . '</time>'
							);
							?>
						</div>
					</header>

					<?php
					if ( has_post_thumbnail() ) {
						?>
						<div class="post-thumbnail">
							<a href="<?php echo esc_url( get_permalink() ); ?>">
								<?php the_post_thumbnail( 'medium' ); ?>
							</a>
						</div>
						<?php
					}
					?>

					<div class="entry-content">
						<?php the_excerpt(); ?>
					</div>

					<footer class="entry-footer">
						<a href="<?php echo esc_url( get_permalink() ); ?>" class="read-more"><?php esc_html_e( 'Read More', 'wsd' ); ?></a>
					</footer>
				</article>
				<?php
			}

			// Posts pagination
			the_posts_pagination( array(
				'prev_text' => esc_html__( 'Previous', 'wsd' ),
				'next_text' => esc_html__( 'Next', 'wsd' ),
			) );
		} else {
			?>
			<p><?php esc_html_e( 'No posts found.', 'wsd' ); ?></p>
			<?php
		}
		?>

	</main>

	<?php get_sidebar(); ?>

<?php
get_footer();
