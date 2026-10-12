<?php
/**
 * Sección: Contacto (formulario enviado con admin-post.php y wp_mail).
 *
 * @package Totech
 */

defined( 'ABSPATH' ) || exit;

list( $totech_msg, $totech_es_error ) = totech_estado_contacto();
$totech_correo   = totech_mod( 'contacto_correo' );
$totech_telefono = totech_mod( 'contacto_telefono' );
$totech_web      = totech_mod( 'contacto_web' );
?>
<section class="contact" id="contacto">
  <svg class="flow flow--contact" id="flow2" aria-hidden="true" preserveAspectRatio="none"></svg>
  <div class="wrap contact__grid">
    <div class="contact__copy">
      <p class="tag tag--dark reveal">Contacto</p>
      <h2 class="h2 h2--light reveal">Cuéntanos qué equipo necesitas <span class="hl">mantener en operación.</span></h2>
      <p class="contact__lead reveal">Agenda un diagnóstico técnico. Un especialista revisa tu caso y te responde con un plan claro de intervención.</p>
      <ul class="contact__info reveal">
        <?php if ( $totech_web ) : ?>
          <li><span>Web</span><a href="<?php echo esc_url( 'https://' . preg_replace( '#^https?://#', '', $totech_web ) ); ?>"><?php echo esc_html( $totech_web ); ?></a></li>
        <?php endif; ?>
        <?php if ( $totech_correo ) : ?>
          <li><span>Correo</span><a href="<?php echo esc_url( 'mailto:' . antispambot( $totech_correo ) ); ?>"><?php echo esc_html( antispambot( $totech_correo ) ); ?></a></li>
        <?php endif; ?>
        <?php if ( $totech_telefono ) : ?>
          <li><span>Teléfono</span><a href="<?php echo esc_url( 'tel:' . preg_replace( '/[^0-9+]/', '', $totech_telefono ) ); ?>"><?php echo esc_html( $totech_telefono ); ?></a></li>
        <?php endif; ?>
      </ul>
    </div>

    <form class="form reveal" id="form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" novalidate>
      <input type="hidden" name="action" value="totech_contacto">
      <?php wp_nonce_field( 'totech_contacto', 'totech_nonce', false ); ?>
      <div class="form__hp" aria-hidden="true"><label>Sitio web<input type="text" name="sitio_web" tabindex="-1" autocomplete="off"></label></div>
      <div class="form__row">
        <label>Nombre<input name="nombre" type="text" autocomplete="name" required placeholder="Nombre y apellido"></label>
        <label>Institución<input name="institucion" type="text" autocomplete="organization" required placeholder="Hospital, clínica o unidad"></label>
      </div>
      <div class="form__row">
        <label>Correo<input name="correo" type="email" autocomplete="email" required placeholder="nombre@institucion.mx"></label>
        <label>Teléfono<input name="telefono" type="tel" autocomplete="tel" placeholder="+52"></label>
      </div>
      <fieldset class="form__chips">
        <legend>¿Qué necesitas?</legend>
        <?php foreach ( totech_servicios_form() as $totech_valor => $totech_etiqueta ) : ?>
          <label><input type="checkbox" name="servicio[]" value="<?php echo esc_attr( $totech_valor ); ?>"><span><?php echo esc_html( $totech_etiqueta ); ?></span></label>
        <?php endforeach; ?>
      </fieldset>
      <label>Equipo y situación<textarea name="mensaje" rows="4" placeholder="Ej. Equipo de rayos X con falla intermitente, área de imagenología."></textarea></label>
      <button type="submit" class="btn btn--lime btn--block"><?php echo esc_html( totech_mod( 'cta_texto' ) ); ?> <svg><use href="#i-arrow"/></svg></button>
      <p class="form__msg<?php echo $totech_es_error ? ' is-error' : ''; ?>" id="formMsg" role="status" aria-live="polite"><?php echo esc_html( $totech_msg ); ?></p>
    </form>
  </div>
</section>
