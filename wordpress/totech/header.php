<?php
/**
 * Encabezado del sitio.
 *
 * @package Totech
 */

defined( 'ABSPATH' ) || exit;
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#contenido"><?php esc_html_e( 'Saltar al contenido', 'totech' ); ?></a>

<header class="nav" id="nav">
	<div class="nav__inner wrap">
		<?php totech_logo( 'logo', 35 ); ?>
		<nav class="nav__links" id="navLinks" aria-label="<?php esc_attr_e( 'Principal', 'totech' ); ?>">
			<?php totech_menu( 'principal' ); ?>
			<a href="<?php echo esc_url( totech_section_url( 'contacto' ) ); ?>" class="nav__mcta"><?php echo esc_html( totech_mod( 'cta_texto' ) ); ?></a>
		</nav>
		<a href="<?php echo esc_url( totech_section_url( 'contacto' ) ); ?>" class="btn btn--lime nav__cta"><?php echo esc_html( totech_mod( 'cta_texto' ) ); ?></a>
		<button class="nav__burger" id="burger" aria-label="<?php esc_attr_e( 'Abrir menú', 'totech' ); ?>" aria-expanded="false" aria-controls="navLinks"><span></span><span></span></button>
	</div>
</header>
