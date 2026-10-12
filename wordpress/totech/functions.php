<?php
/**
 * Funciones del tema Totech.
 *
 * @package Totech
 */

defined( 'ABSPATH' ) || exit;

define( 'TOTECH_VERSION', '1.0.0' );

require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/contacto.php';
require get_template_directory() . '/inc/menus.php';

/**
 * Configuración base del tema.
 */
function totech_setup() {
	load_theme_textdomain( 'totech', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 80,
			'width'       => 300,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	register_nav_menus(
		array(
			'principal' => __( 'Menú principal', 'totech' ),
			'pie'       => __( 'Menú del pie de página', 'totech' ),
		)
	);
}
add_action( 'after_setup_theme', 'totech_setup' );

/**
 * Estilos y scripts.
 */
function totech_assets() {
	wp_enqueue_style(
		'totech-fuentes',
		'https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,700&family=Poppins:wght@400;500;600;700&display=swap',
		array(),
		null
	);
	wp_enqueue_style( 'totech', get_stylesheet_uri(), array( 'totech-fuentes' ), TOTECH_VERSION );
	wp_enqueue_script( 'totech', get_template_directory_uri() . '/assets/js/main.js', array(), TOTECH_VERSION, array( 'in_footer' => true, 'strategy' => 'defer' ) );
}
add_action( 'wp_enqueue_scripts', 'totech_assets' );

/**
 * Preconexión con Google Fonts.
 *
 * @param array  $urls          URLs.
 * @param string $relation_type Tipo de relación.
 * @return array
 */
function totech_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = 'https://fonts.googleapis.com';
		$urls[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'totech_resource_hints', 10, 2 );

/**
 * Favicon, color de tema y descripción cuando no hay plugin SEO ni ícono de sitio.
 */
function totech_head_meta() {
	echo '<meta name="theme-color" content="#0B0F0D">' . "\n";
	if ( ! has_site_icon() ) {
		echo '<link rel="icon" href="' . esc_url( totech_asset( 'logo/simbolo.svg' ) ) . '" type="image/svg+xml">' . "\n";
	}
	if ( is_front_page() && ! defined( 'WPSEO_VERSION' ) && ! class_exists( 'RankMath' ) ) {
		echo '<meta name="description" content="' . esc_attr( totech_mod( 'meta_descripcion' ) ) . '">' . "\n";
	}
}
add_action( 'wp_head', 'totech_head_meta', 2 );

/**
 * Clase en body para páginas internas (navegación con fondo sólido).
 *
 * @param array $classes Clases.
 * @return array
 */
function totech_body_class( $classes ) {
	if ( ! is_front_page() ) {
		$classes[] = 'is-interior';
	}
	return $classes;
}
add_filter( 'body_class', 'totech_body_class' );

/**
 * URL de un recurso del tema.
 *
 * @param string $path Ruta relativa dentro de /assets.
 * @return string
 */
function totech_asset( $path ) {
	return get_template_directory_uri() . '/assets/' . ltrim( $path, '/' );
}

/**
 * Imprime la URL escapada de un recurso del tema.
 *
 * @param string $path Ruta relativa dentro de /assets.
 */
function totech_asset_e( $path ) {
	echo esc_url( totech_asset( $path ) );
}

/**
 * Enlace a una sección de la portada (funciona también desde páginas internas).
 *
 * @param string $id Ancla sin "#".
 * @return string
 */
function totech_section_url( $id ) {
	return is_front_page() ? '#' . $id : home_url( '/#' . $id );
}

/**
 * Logotipo: usa el logo personalizado si existe; si no, el logotipo blanco del tema.
 *
 * @param string $class Clase del enlace.
 * @param int    $height Alto en px.
 */
function totech_logo( $class = 'logo', $height = 35 ) {
	$custom_logo_id = get_theme_mod( 'custom_logo' );
	$name           = get_bloginfo( 'name' );
	echo '<a href="' . esc_url( home_url( '/' ) ) . '" class="' . esc_attr( $class ) . '" rel="home" aria-label="' . esc_attr( $name ) . '">';
	if ( $custom_logo_id ) {
		echo wp_get_attachment_image( $custom_logo_id, 'full', false, array( 'alt' => $name, 'style' => 'height:' . (int) $height . 'px;width:auto' ) );
	} else {
		$width = (int) round( $height * 3.75 );
		echo '<img src="' . esc_url( totech_asset( 'logo/logotipo-blanco.svg' ) ) . '" alt="' . esc_attr( $name ) . '" width="' . (int) $width . '" height="' . (int) $height . '">';
	}
	echo '</a>';
}

/**
 * Sprite de íconos usado en las plantillas.
 */
function totech_icon_sprite() {
	?>
	<svg width="0" height="0" style="position:absolute" aria-hidden="true" focusable="false">
		<symbol id="i-check" viewBox="0 0 24 24"><path d="M5 12.5l4.2 4.2L19 7" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></symbol>
		<symbol id="i-arrow" viewBox="0 0 24 24"><path d="M5 12h14M13 6l6 6-6 6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></symbol>
	</svg>
	<?php
}
add_action( 'wp_body_open', 'totech_icon_sprite' );
