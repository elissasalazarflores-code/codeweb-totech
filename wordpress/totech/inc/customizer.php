<?php
/**
 * Opciones editables desde Apariencia → Personalizar → Totech.
 *
 * @package Totech
 */

defined( 'ABSPATH' ) || exit;

/**
 * Valores por defecto de las opciones del tema.
 *
 * @return array
 */
function totech_defaults() {
	return array(
		'hero_eyebrow'      => 'Ingeniería biomédica hospitalaria · México',
		'hero_titulo'       => 'El socio técnico que mantiene <span class="hl">vivo</span> el equipamiento que salva vidas.',
		'hero_texto'        => 'Mantenemos operativos los equipos que hacen posible la atención médica, con la velocidad, la precisión y el compromiso que el entorno hospitalario exige.',
		'cta_texto'         => 'Agenda un diagnóstico',
		'contacto_web'      => 'totech.com.mx',
		'contacto_correo'   => 'contacto@totech.com.mx',
		'contacto_telefono' => '+52 (55) 0000 0000',
		'form_destinatario' => '',
		'razon_social'      => 'Totech SA de CV',
		'meta_descripcion'  => 'Totech mantiene operativos los equipos que hacen posible la atención médica. Mantenimiento preventivo y correctivo de equipo médico para hospitales, clínicas y unidades de salud en México.',
	);
}

/**
 * Lee una opción del tema con su valor por defecto.
 *
 * @param string $key Clave.
 * @return string
 */
function totech_mod( $key ) {
	$defaults = totech_defaults();
	$value    = get_theme_mod( 'totech_' . $key, $defaults[ $key ] ?? '' );
	return ( '' === $value && 'form_destinatario' !== $key ) ? ( $defaults[ $key ] ?? '' ) : $value;
}

/**
 * Sanitiza el título del inicio: solo permite <span class="..."> y <br>.
 *
 * @param string $value Valor.
 * @return string
 */
function totech_sanitize_titulo( $value ) {
	return wp_kses( $value, array( 'span' => array( 'class' => true ), 'br' => array() ) );
}

/**
 * Registra el panel del Personalizador.
 *
 * @param WP_Customize_Manager $wp_customize Gestor.
 */
function totech_customize_register( $wp_customize ) {
	$wp_customize->add_panel(
		'totech',
		array(
			'title'    => __( 'Totech', 'totech' ),
			'priority' => 30,
		)
	);

	$wp_customize->add_section(
		'totech_inicio',
		array(
			'title' => __( 'Inicio', 'totech' ),
			'panel' => 'totech',
		)
	);
	$wp_customize->add_section(
		'totech_contacto',
		array(
			'title'       => __( 'Contacto y formulario', 'totech' ),
			'panel'       => 'totech',
			'description' => __( 'Datos que aparecen en la sección de contacto y destinatario del formulario.', 'totech' ),
		)
	);

	$fields = array(
		'hero_eyebrow'      => array( 'totech_inicio', __( 'Etiqueta superior', 'totech' ), 'text', 'sanitize_text_field' ),
		'hero_titulo'       => array( 'totech_inicio', __( 'Título principal', 'totech' ), 'textarea', 'totech_sanitize_titulo', __( 'Para resaltar una palabra en lima: <span class="hl">palabra</span>', 'totech' ) ),
		'hero_texto'        => array( 'totech_inicio', __( 'Texto de apoyo', 'totech' ), 'textarea', 'sanitize_textarea_field' ),
		'cta_texto'         => array( 'totech_inicio', __( 'Texto del botón principal', 'totech' ), 'text', 'sanitize_text_field' ),
		'meta_descripcion'  => array( 'totech_inicio', __( 'Descripción para buscadores', 'totech' ), 'textarea', 'sanitize_textarea_field', __( 'Se omite si usas Yoast o Rank Math.', 'totech' ) ),
		'contacto_web'      => array( 'totech_contacto', __( 'Sitio web', 'totech' ), 'text', 'sanitize_text_field' ),
		'contacto_correo'   => array( 'totech_contacto', __( 'Correo visible', 'totech' ), 'email', 'sanitize_email' ),
		'contacto_telefono' => array( 'totech_contacto', __( 'Teléfono', 'totech' ), 'text', 'sanitize_text_field' ),
		'form_destinatario' => array( 'totech_contacto', __( 'Correo que recibe las solicitudes', 'totech' ), 'email', 'sanitize_email', __( 'Si lo dejas vacío se usa el correo de administración de WordPress.', 'totech' ) ),
		'razon_social'      => array( 'totech_contacto', __( 'Razón social (pie de página)', 'totech' ), 'text', 'sanitize_text_field' ),
	);

	$defaults = totech_defaults();
	foreach ( $fields as $key => $f ) {
		$wp_customize->add_setting(
			'totech_' . $key,
			array(
				'default'           => $defaults[ $key ],
				'sanitize_callback' => $f[3],
			)
		);
		$wp_customize->add_control(
			'totech_' . $key,
			array(
				'section'     => $f[0],
				'label'       => $f[1],
				'type'        => $f[2],
				'description' => $f[4] ?? '',
			)
		);
	}
}
add_action( 'customize_register', 'totech_customize_register' );
