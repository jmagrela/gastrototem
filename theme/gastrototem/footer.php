<?php
/**
 * Pie del documento.
 *
 * @package Gastrototem
 */
?>
</main><!-- #gtt-content -->

<footer class="gtt-template-site-footer" role="contentinfo">
	<p class="gtt-template-footer-copy">
		&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?>
		<?php echo esc_html( get_bloginfo( 'name' ) ); ?>
	</p>
</footer>

<?php wp_footer(); ?>
</body>
</html>
