<?php
/**
 * Plantilla de comentarios.
 *
 * @package Gastrototem
 */

if ( post_password_required() ) {
	return;
}
?>

<section id="comments" class="gtt-template-comments">

	<?php if ( have_comments() ) : ?>

		<h2 class="gtt-template-comments-title">
			<?php
			$count = get_comments_number();
			if ( '1' === (string) $count ) {
				esc_html_e( 'Un comentario', 'gastrototem' );
			} else {
				printf(
					/* translators: %s: número de comentarios */
					esc_html( _n( '%s comentario', '%s comentarios', $count, 'gastrototem' ) ),
					esc_html( number_format_i18n( $count ) )
				);
			}
			?>
		</h2>

		<ol class="gtt-template-comments-list">
			<?php
			wp_list_comments(
				array(
					'style'      => 'ol',
					'short_ping' => true,
					'avatar_size' => 48,
				)
			);
			?>
		</ol>

		<?php
		the_comments_navigation(
			array(
				'prev_text' => esc_html__( 'Comentarios anteriores', 'gastrototem' ),
				'next_text' => esc_html__( 'Comentarios siguientes', 'gastrototem' ),
			)
		);
		?>

		<?php if ( ! comments_open() ) : ?>
			<p class="gtt-template-comments-closed">
				<?php esc_html_e( 'Los comentarios están cerrados.', 'gastrototem' ); ?>
			</p>
		<?php endif; ?>

	<?php endif; ?>

	<?php
	comment_form(
		array(
			'title_reply'         => esc_html__( 'Deja un comentario', 'gastrototem' ),
			'title_reply_to'      => esc_html__( 'Responder a %s', 'gastrototem' ),
			'cancel_reply_link'   => esc_html__( 'Cancelar respuesta', 'gastrototem' ),
			'label_submit'        => esc_html__( 'Publicar comentario', 'gastrototem' ),
			'class_form'          => 'gtt-template-comment-form',
			'class_submit'        => 'gtt-template-comment-submit',
		)
	);
	?>

</section>
