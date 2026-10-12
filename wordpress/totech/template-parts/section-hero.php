<?php
/**
 * Sección: Hero
 *
 * @package Totech
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="hero" id="inicio">
  <svg class="flow" id="flow" aria-hidden="true" preserveAspectRatio="none"></svg>
  <div class="hero__glow" aria-hidden="true"></div>

  <div class="hero__inner wrap">
    <div class="hero__copy">
      <p class="eyebrow reveal"><span class="dot"></span> <?php echo esc_html( totech_mod( 'hero_eyebrow' ) ); ?></p>
      <h1 class="hero__title reveal">
        <?php echo wp_kses( totech_mod( 'hero_titulo' ), array( 'span' => array( 'class' => true ), 'br' => array() ) ); ?>
      </h1>
      <p class="hero__lead reveal">
        <?php echo esc_html( totech_mod( 'hero_texto' ) ); ?>
      </p>
      <div class="hero__actions reveal">
        <a href="#contacto" class="btn btn--lime"><?php echo esc_html( totech_mod( 'cta_texto' ) ); ?> <svg><use href="#i-arrow"/></svg></a>
        <a href="#servicios" class="btn btn--ghost">Ver servicios</a>
      </div>
      <ul class="hero__chips reveal" aria-label="Especialidades">
        <li>Preventivo</li><li>Correctivo</li><li>Calibración</li><li>Trazabilidad</li><li>Urgencias</li>
      </ul>
    </div>

    <div class="hero__visual reveal" aria-hidden="true">
      <div class="orbit orbit--1"></div>
      <div class="orbit orbit--2"></div>
      <div class="capsule capsule--hero">
        <img src="<?php totech_asset_e( 'img/textura-seda.jpg' ); ?>" alt="">
      </div>
      <div class="hero__sym"><img src="<?php totech_asset_e( 'logo/simbolo.svg' ); ?>" alt=""></div>

      <div class="glass glass--a">
        <span class="glass__k">&lt;4 h</span>
        <span class="glass__t">Respuesta técnica para equipo crítico</span>
      </div>
      <div class="glass glass--b">
        <span class="pulse"></span>
        <span class="glass__t"><strong>Equipo operativo</strong>Intervenido · calibrado · documentado</span>
      </div>
      <div class="glass glass--c">
        <span class="glass__k">-60%</span>
        <span class="glass__t">Fallas no planificadas con mantenimiento preventivo</span>
      </div>
    </div>
  </div>

  <div class="hero__foot wrap">
    <span>Precisión técnica con visión humana</span>
    <span class="tribar"><i></i><i></i><i></i></span>
    <a href="#nosotros" class="scroll-cue">Desliza <svg><use href="#i-arrow"/></svg></a>
  </div>
</section>
