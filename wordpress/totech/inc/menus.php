<?php
/**
 * Menús: enlaces planos (sin <li>) para conservar el diseño, con menú por defecto.
 *
 * @package Totech
 */

defined( 'ABSPATH' ) || exit;

/**
 * Walker que imprime cada elemento como un <a> directo.
 */
class Totech_Walker_Plano extends Walker_Nav_Menu {
	// phpcs:disable Generic.CodeAnalysis.UnusedFunctionParameter
	public function start_lvl( &$output, $depth = 0, $args = null ) {}
	public function end_lvl( &$output, $depth = 0, $args = null ) {}
	public function end_el( &$output, $data_object, $depth = 0, $args = null ) {}
	// phpcs:enable

	/**
	 * Elemento de menú.
	 *
	 * @param string   $output      Salida.
	 * @param WP_Post  $data_object Elemento.
	 * @param int      $depth       Profundidad.
	 * @param stdClass $args        Argumentos.
	 * @param int      $id          ID.
	 */
	public function start_el( &$output, $data_object, $depth = 0, $args = null, $id = 0 ) {
		if ( $depth > 0 ) {
			return;
		}
		$url = $data_object->url;
		// En la portada, convierte "https://sitio/#seccion" en "#seccion" para el desplazamiento suave.
		if ( is_front_page() && false !== strpos( $url, '#' ) && 0 === strpos( $url, home_url() ) ) {
			$url = substr( $url, strpos( $url, '#' ) );
		}
		$current = in_array( 'current-menu-item', (array) $data_object->classes, true ) && false === strpos( $url, '#' );
		$output .= sprintf(
			'<a href="%1$s"%2$s%3$s>%4$s</a>',
			esc_url( $url ),
			$current ? ' class="is-active" aria-current="page"' : '',
			$data_object->target ? ' target="' . esc_attr( $data_object->target ) . '" rel="noopener"' : '',
			esc_html( $data_object->title )
		);
	}
}

/**
 * Enlaces por defecto (secciones de la portada).
 *
 * @param bool $pie Variante para el pie (sin "Método", con "Contacto").
 * @return array
 */
function totech_enlaces_defecto( $pie = false ) {
	$enlaces = array(
		'nosotros'        => __( 'Nosotros', 'totech' ),
		'servicios'       => __( 'Servicios', 'totech' ),
		'metodo'          => __( 'Método', 'totech' ),
		'diferenciadores' => __( 'Por qué Totech', 'totech' ),
		'clientes'        => __( 'Para quién', 'totech' ),
	);
	if ( $pie ) {
		unset( $enlaces['metodo'] );
		$enlaces['contacto'] = __( 'Contacto', 'totech' );
	}
	return $enlaces;
}

/**
 * Imprime un menú en formato plano.
 *
 * @param string $location Ubicación registrada.
 */
function totech_menu( $location ) {
	if ( has_nav_menu( $location ) ) {
		wp_nav_menu(
			array(
				'theme_location' => $location,
				'container'      => false,
				'items_wrap'     => '%3$s',
				'depth'          => 1,
				'walker'         => new Totech_Walker_Plano(),
			)
		);
		return;
	}
	foreach ( totech_enlaces_defecto( 'pie' === $location ) as $id => $label ) {
		printf( '<a href="%1$s">%2$s</a>', esc_url( totech_section_url( $id ) ), esc_html( $label ) );
	}
}
