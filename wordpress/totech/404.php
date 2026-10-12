<?php
/**
 * Página no encontrada.
 *
 * @package Totech
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="contenido">
	<header class="page-hero page-hero--full">
		<div class="wrap">
			<p class="tag tag--dark">Error 404</p>
			<h1 class="h2 h2--light"><?php esc_html_e( 'Esta página no está disponible.', 'totech' ); ?></h1>
			<p class="contact__lead"><?php esc_html_e( 'Puede que el enlace haya cambiado. Vuelve al inicio para encontrar lo que buscas.', 'totech' ); ?></p>
			<p style="margin-top:32px"><a class="btn btn--lime" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Volver al inicio', 'totech' ); ?> <svg><use href="#i-arrow"/></svg></a></p>
		</div>
	</header>
</main>
<?php
get_footer();
