<?php
/**
 * Plantilla general: blog, archivos y búsquedas.
 *
 * @package Totech
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="contenido">
	<header class="page-hero">
		<div class="wrap">
			<p class="tag tag--dark"><?php bloginfo( 'name' ); ?></p>
			<h1 class="h2 h2--light">
				<?php
				if ( is_home() ) {
					single_post_title();
				} elseif ( is_search() ) {
					/* translators: %s: término de búsqueda */
					printf( esc_html__( 'Resultados para “%s”', 'totech' ), esc_html( get_search_query() ) );
				} else {
					the_archive_title();
				}
				?>
			</h1>
		</div>
	</header>

	<div class="wrap page-body">
		<?php if ( have_posts() ) : ?>
			<div class="post-grid">
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?>>
						<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php the_permalink(); ?>" class="post-card__img"><?php the_post_thumbnail( 'medium_large' ); ?></a>
						<?php endif; ?>
						<p class="post-card__date"><?php echo esc_html( get_the_date() ); ?></p>
						<h2 class="post-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<div class="post-card__excerpt"><?php the_excerpt(); ?></div>
					</article>
				<?php endwhile; ?>
			</div>
			<?php the_posts_pagination(); ?>
		<?php else : ?>
			<p class="lead"><?php esc_html_e( 'No encontramos contenido aquí.', 'totech' ); ?></p>
		<?php endif; ?>
	</div>
</main>
<?php
get_footer();
