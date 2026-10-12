<?php
/**
 * Envío del formulario de contacto por correo (wp_mail).
 *
 * @package Totech
 */

defined( 'ABSPATH' ) || exit;

/**
 * Servicios disponibles en el formulario.
 *
 * @return array
 */
function totech_servicios_form() {
	return array(
		'preventivo'  => __( 'Preventivo', 'totech' ),
		'correctivo'  => __( 'Correctivo', 'totech' ),
		'calibracion' => __( 'Calibración', 'totech' ),
		'urgencia'    => __( 'Urgencia', 'totech' ),
		'asesoria'    => __( 'Asesoría', 'totech' ),
	);
}

/**
 * Procesa el formulario.
 */
function totech_procesar_contacto() {
	$volver = wp_get_referer() ? wp_get_referer() : home_url( '/' );
	$volver = remove_query_arg( 'contacto', strtok( $volver, '#' ) );

	$redirigir = static function ( $estado ) use ( $volver ) {
		wp_safe_redirect( add_query_arg( 'contacto', $estado, $volver ) . '#contacto' );
		exit;
	};

	if ( ! isset( $_POST['totech_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['totech_nonce'] ) ), 'totech_contacto' ) ) {
		$redirigir( 'error' );
	}

	// Campo trampa contra spam: los humanos no lo ven.
	if ( ! empty( $_POST['sitio_web'] ) ) {
		$redirigir( 'enviado' );
	}

	$nombre      = isset( $_POST['nombre'] ) ? sanitize_text_field( wp_unslash( $_POST['nombre'] ) ) : '';
	$institucion = isset( $_POST['institucion'] ) ? sanitize_text_field( wp_unslash( $_POST['institucion'] ) ) : '';
	$correo      = isset( $_POST['correo'] ) ? sanitize_email( wp_unslash( $_POST['correo'] ) ) : '';
	$telefono    = isset( $_POST['telefono'] ) ? sanitize_text_field( wp_unslash( $_POST['telefono'] ) ) : '';
	$mensaje     = isset( $_POST['mensaje'] ) ? sanitize_textarea_field( wp_unslash( $_POST['mensaje'] ) ) : '';
	$elegidos    = isset( $_POST['servicio'] ) ? array_map( 'sanitize_key', (array) wp_unslash( $_POST['servicio'] ) ) : array();
	$servicios   = array_intersect_key( totech_servicios_form(), array_flip( $elegidos ) );

	if ( '' === $nombre || '' === $institucion || ! is_email( $correo ) ) {
		$redirigir( 'incompleto' );
	}

	$destino = totech_mod( 'form_destinatario' );
	if ( ! is_email( $destino ) ) {
		$destino = get_option( 'admin_email' );
	}

	$asunto = sprintf( /* translators: 1: institución */ __( 'Solicitud de diagnóstico · %s', 'totech' ), $institucion );
	$cuerpo = implode(
		"\n",
		array(
			__( 'Nueva solicitud desde el sitio web:', 'totech' ),
			'',
			__( 'Nombre: ', 'totech' ) . $nombre,
			__( 'Institución: ', 'totech' ) . $institucion,
			__( 'Correo: ', 'totech' ) . $correo,
			__( 'Teléfono: ', 'totech' ) . ( $telefono ? $telefono : '—' ),
			__( 'Servicios: ', 'totech' ) . ( $servicios ? implode( ', ', $servicios ) : '—' ),
			'',
			__( 'Equipo y situación:', 'totech' ),
			$mensaje ? $mensaje : '—',
		)
	);
	$headers = array( 'Reply-To: ' . $nombre . ' <' . $correo . '>' );

	$redirigir( wp_mail( $destino, $asunto, $cuerpo, $headers ) ? 'enviado' : 'error' );
}
add_action( 'admin_post_nopriv_totech_contacto', 'totech_procesar_contacto' );
add_action( 'admin_post_totech_contacto', 'totech_procesar_contacto' );

/**
 * Mensaje de resultado tras enviar el formulario.
 *
 * @return array{0:string,1:bool} Texto y si es error.
 */
function totech_estado_contacto() {
	$estado = isset( $_GET['contacto'] ) ? sanitize_key( wp_unslash( $_GET['contacto'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	switch ( $estado ) {
		case 'enviado':
			return array( __( 'Gracias. Un especialista de Totech te contactará en breve.', 'totech' ), false );
		case 'incompleto':
			return array( __( 'Revisa los campos obligatorios para continuar.', 'totech' ), true );
		case 'error':
			return array( __( 'No pudimos enviar tu solicitud. Inténtalo de nuevo o escríbenos por correo.', 'totech' ), true );
	}
	return array( '', false );
}
