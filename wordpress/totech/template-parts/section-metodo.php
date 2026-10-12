<?php
/**
 * Sección: Metodo
 *
 * @package Totech
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="method" id="metodo">
  <img class="method__bg" src="<?php totech_asset_e( 'img/textura-hojas.jpg' ); ?>" alt="" aria-hidden="true">
  <div class="method__veil" aria-hidden="true"></div>
  <div class="wrap method__inner">
    <div class="method__head">
      <p class="tag tag--dark reveal">Cómo trabajamos</p>
      <h2 class="h2 h2--light reveal">Tu equipo médico,<br>operando al <span class="counter" data-to="100">0</span>%.</h2>
      <p class="method__quote reveal">“Intervenimos, calibramos y documentamos el proceso. Aquí está el reporte.”</p>
    </div>
    <ol class="steps">
      <li class="step reveal"><span class="step__n">01</span><h3>Diagnóstico</h3><p>Evaluamos el estado del equipo y su criticidad dentro de la operación clínica.</p></li>
      <li class="step reveal"><span class="step__n">02</span><h3>Intervención</h3><p>Ejecutamos el mantenimiento preventivo o correctivo con rigor profesional.</p></li>
      <li class="step reveal"><span class="step__n">03</span><h3>Calibración</h3><p>Verificamos parámetros y confirmamos que el equipo opere dentro de especificación.</p></li>
      <li class="step reveal"><span class="step__n">04</span><h3>Reporte</h3><p>Entregamos documentación detallada y trazable de cada intervención.</p></li>
    </ol>
    <div class="progress" aria-hidden="true"><span id="progressFill"></span></div>
  </div>
</section>
