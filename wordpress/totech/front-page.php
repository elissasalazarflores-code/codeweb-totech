<?php
/**
 * Portada: landing completa de Totech.
 *
 * @package Totech
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<main id="contenido">
	<?php
	foreach ( array( 'hero', 'marquee', 'nosotros', 'servicios', 'metodo', 'diferenciadores', 'clientes', 'valores', 'contacto' ) as $totech_seccion ) {
		get_template_part( 'template-parts/section', $totech_seccion );
	}
	?>
</main>
<?php
get_footer();
