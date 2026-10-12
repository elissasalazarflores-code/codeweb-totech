<?php
/**
 * Páginas y entradas individuales.
 *
 * @package Totech
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<main id="contenido">
		<header class="page-hero">
			<div class="wrap">
				<?php if ( is_singular( 'post' ) ) : ?>
					<p class="tag tag--dark"><?php echo esc_html( get_the_date() ); ?></p>
				<?php endif; ?>
				<h1 class="h2 h2--light"><?php the_title(); ?></h1>
			</div>
		</header>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'wrap page-body' ); ?>>
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="entry__img"><?php the_post_thumbnail( 'large' ); ?></div>
			<?php endif; ?>
			<div class="entry__content">
				<?php
				the_content();
				wp_link_pages();
				?>
			</div>
			<?php
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
			?>
		</article>
	</main>
	<?php
endwhile;

get_footer();
