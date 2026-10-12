<?php
/**
 * Pie del sitio.
 *
 * @package Totech
 */

defined( 'ABSPATH' ) || exit;
?>
<footer class="footer">
	<div class="wrap footer__inner">
		<div class="footer__brand">
			<?php totech_logo( 'footer__logo', 40 ); ?>
			<p class="footer__tag"><?php esc_html_e( 'Precisión técnica con visión humana', 'totech' ); ?></p>
		</div>
		<nav class="footer__nav" aria-label="<?php esc_attr_e( 'Pie de página', 'totech' ); ?>">
			<?php totech_menu( 'pie' ); ?>
		</nav>
		<div class="footer__legal">
			<p><?php echo esc_html( totech_mod( 'razon_social' ) ); ?> <span class="sep"></span> <?php echo esc_html( totech_mod( 'contacto_web' ) ); ?></p>
			<p>© <?php echo esc_html( wp_date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'Todos los derechos reservados.', 'totech' ); ?></p>
		</div>
	</div>
	<div class="tribar tribar--full"><i></i><i></i><i></i></div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
