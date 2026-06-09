<?php
/**
 * Gastrototem · Meta "Titular de la banda".
 *
 * Caja clásica (add_meta_box) en el editor de páginas que guarda el meta
 * "_gtt_titular": el titular editorial que la plantilla Documento muestra como
 * <h1> de la banda de apertura, relegando el nombre de página a kicker.
 *
 * @package Gastrototem
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registra la caja en el post_type 'page'.
 */
function gtt_titular_add_meta_box() {
	add_meta_box(
		'gtt-titular',
		__( 'Titular de la banda', 'gastrototem' ),
		'gtt_titular_render_meta_box',
		'page',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'gtt_titular_add_meta_box' );

/**
 * Pinta el campo de texto.
 *
 * @param WP_Post $post Página en edición.
 */
function gtt_titular_render_meta_box( $post ) {
	wp_nonce_field( 'gtt_titular_save', 'gtt_titular_nonce' );

	$titular = (string) get_post_meta( $post->ID, '_gtt_titular', true );
	?>
	<p>
		<label for="gtt-titular-field">
			<?php esc_html_e( 'Titular editorial que aparece como <h1> de la banda. Si se deja vacío, la banda usa el nombre de la página y oculta el kicker.', 'gastrototem' ); ?>
		</label>
	</p>
	<input
		type="text"
		id="gtt-titular-field"
		name="gtt_titular"
		value="<?php echo esc_attr( $titular ); ?>"
		class="widefat"
	/>
	<?php
}

/**
 * Guarda el meta con verificación de nonce y capacidad.
 *
 * @param int $post_id ID de la página.
 */
function gtt_titular_save_meta_box( $post_id ) {
	if ( ! isset( $_POST['gtt_titular_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['gtt_titular_nonce'] ) ), 'gtt_titular_save' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_page', $post_id ) ) {
		return;
	}

	$titular = isset( $_POST['gtt_titular'] ) ? sanitize_text_field( wp_unslash( $_POST['gtt_titular'] ) ) : '';

	if ( '' === $titular ) {
		delete_post_meta( $post_id, '_gtt_titular' );
	} else {
		update_post_meta( $post_id, '_gtt_titular', $titular );
	}
}
add_action( 'save_post_page', 'gtt_titular_save_meta_box' );
