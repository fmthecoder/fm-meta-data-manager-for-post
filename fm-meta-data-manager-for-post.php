<?php
/**
 * Plugin Name:       FM: Meta Data Manager for Post
 * Plugin URI:        https://wordpress.org/plugins/fm-meta-data-manager-for-post/
 * Description:       View, Edit, and Delete Post Meta directly from the post edit screen using an AJAX-powered interface.
 * Version:           1.0.1
 * Author:            Faiq Masood
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       fm-meta-data-manager-for-post
 * Domain Path:       /languages
 * Requires at least: 5.8
 * Tested up to:      6.8
 * Requires PHP:      7.4
 *
 * @package fmthecoder
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add Meta Data Manager meta box to all post types.
 */
add_action(
	'add_meta_boxes',
	function () {
		add_meta_box(
			'fm_meta_data_manager_box',
			__( 'FM: Meta Data Manager', 'fm-meta-data-manager-for-post' ),
			'fmmetadata_render_meta_data_manager_box',
			null,
			'normal',
			'default'
		);
	}
);

/**
 * Render meta data table for post.
 *
 * @param WP_Post $post Post object.
 */
function fmmetadata_render_meta_data_manager_box( $post ) {
	$meta = get_post_meta( $post->ID );

	echo '<div class="fm-meta-data-wrap">';
	echo '<div class="fm-meta-message" style="margin-bottom:8px;"></div>';
	echo '<table class="wp-list-table widefat fixed striped fm-meta-table">';
	echo '<thead><tr><th>' . esc_html__( 'Meta Key', 'fm-meta-data-manager-for-post' ) . '</th><th>' . esc_html__( 'Meta Value', 'fm-meta-data-manager-for-post' ) . '</th><th>' . esc_html__( 'Actions', 'fm-meta-data-manager-for-post' ) . '</th></tr></thead><tbody>';

	if ( ! empty( $meta ) ) {
		foreach ( $meta as $key => $values ) {
			foreach ( $values as $value ) {
				echo '<tr data-key="' . esc_attr( $key ) . '">';
				echo '<td class="meta-key"><code>' . esc_html( $key ) . '</code></td>';
				echo '<td class="meta-value-cell"><input type="text" class="meta-value" value="' . esc_attr( $value ) . '" /></td>';
				echo '<td class="meta-actions">
						<button class="button button-primary fm-save-meta" title="' . esc_attr__( 'Save Meta', 'fm-meta-data-manager-for-post' ) . '"><span class="dashicons dashicons-yes-alt"></span></button>
						<button class="button button-secondary fm-delete-meta" title="' . esc_attr__( 'Delete Meta', 'fm-meta-data-manager-for-post' ) . '"><span class="dashicons dashicons-trash"></span></button>
					  </td>';
				echo '</tr>';
			}
		}
	} else {
		echo '<tr><td colspan="3" style="text-align:center;">' . esc_html__( 'No meta data found for this post.', 'fm-meta-data-manager-for-post' ) . '</td></tr>';
	}

	echo '</tbody></table>';
	echo '<div class="fm-add-meta" style="margin-top:15px; border-top:1px solid #ddd; padding-top:10px;">';
	echo '<h4>' . esc_html__( 'FM Add New Custom Meta', 'fm-meta-data-manager-for-post' ) . '</h4>';
	echo '<input type="text" id="fm-new-meta-key" placeholder="' . esc_attr__( 'Meta Key', 'fm-meta-data-manager-for-post' ) . '" style="margin-right:10px; width:30%;" />';
	echo '<input type="text" id="fm-new-meta-value" placeholder="' . esc_attr__( 'Meta Value', 'fm-meta-data-manager-for-post' ) . '" style="margin-right:10px; width:40%;" />';
	echo '<button class="button button-primary" id="fm-add-meta-btn">' . esc_html__( 'Add Meta', 'fm-meta-data-manager-for-post' ) . '</button>';
	echo '</div>';
	echo '<p style="font-size:12px; color:#777;">' . esc_html__( 'Tip: Edit or delete post meta directly. Changes are saved instantly using AJAX.', 'fm-meta-data-manager-for-post' ) . '</p>';
	echo '<div class="fm-meta-message" style="margin-bottom:8px;"></div>';
	echo '</div>';
}

/**
 * Enqueue admin assets.
 */
add_action(
	'admin_enqueue_scripts',
	function ( $hook ) {
		if ( in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
			wp_enqueue_script(
				'fmmetadata_manager_js',
				plugin_dir_url( __FILE__ ) . 'assets/js/fm-meta-data-manager.js',
				array( 'jquery' ),
				'1.0.1',
				true
			);

			wp_localize_script(
				'fmmetadata_manager_js',
				'FM_MetaDataManager',
				array(
					'ajaxurl' => admin_url( 'admin-ajax.php' ),
					'nonce'   => wp_create_nonce( 'fm_meta_data_manager_nonce' ),
					'success' => __( 'Saved successfully!', 'fm-meta-data-manager-for-post' ),
					'deleted' => __( 'Deleted successfully!', 'fm-meta-data-manager-for-post' ),
					'error'   => __( 'Something went wrong.', 'fm-meta-data-manager-for-post' ),
				)
			);

			wp_enqueue_style(
				'fmmetadata_manager_css',
				plugin_dir_url( __FILE__ ) . 'assets/css/fm-meta-data-manager.css',
				array(),
				'1.0.0'
			);
		}
	}
);

/**
 * AJAX - Add new meta.
 */
add_action(
	'wp_ajax_fmmetadata_add_meta_value',
	function () {
		check_ajax_referer( 'fm_meta_data_manager_nonce', 'nonce' );

		$post_id = isset( $_POST['post_id'] ) ? intval( wp_unslash( $_POST['post_id'] ) ) : 0;
		$key     = isset( $_POST['key'] ) ? sanitize_text_field( wp_unslash( $_POST['key'] ) ) : '';
		$value   = isset( $_POST['value'] ) ? sanitize_text_field( wp_unslash( $_POST['value'] ) ) : '';

		if ( $post_id && $key ) {
			add_post_meta( $post_id, $key, $value );
			wp_send_json_success(
				array(
					'message' => __( 'Meta added successfully.', 'fm-meta-data-manager-for-post' ),
					'key'     => $key,
					'value'   => $value,
				)
			);
		}

		wp_send_json_error( array( 'message' => __( 'Invalid meta data.', 'fm-meta-data-manager-for-post' ) ) );
	}
);

/**
 * AJAX - Update meta.
 */
add_action(
	'wp_ajax_fmmetadata_update_meta_value',
	function () {
		check_ajax_referer( 'fm_meta_data_manager_nonce', 'nonce' );

		$post_id = isset( $_POST['post_id'] ) ? intval( wp_unslash( $_POST['post_id'] ) ) : 0;
		$key     = isset( $_POST['key'] ) ? sanitize_text_field( wp_unslash( $_POST['key'] ) ) : '';
		$value   = isset( $_POST['value'] ) ? sanitize_text_field( wp_unslash( $_POST['value'] ) ) : '';

		if ( $post_id && $key ) {
			update_post_meta( $post_id, $key, $value );
			wp_send_json_success( array( 'message' => __( 'Meta updated successfully.', 'fm-meta-data-manager-for-post' ) ) );
		}

		wp_send_json_error( array( 'message' => __( 'Invalid meta data.', 'fm-meta-data-manager-for-post' ) ) );
	}
);

/**
 * AJAX - Delete meta.
 */
add_action(
	'wp_ajax_fmmetadata_delete_meta_value',
	function () {
		check_ajax_referer( 'fm_meta_data_manager_nonce', 'nonce' );

		$post_id = isset( $_POST['post_id'] ) ? intval( wp_unslash( $_POST['post_id'] ) ) : 0;
		$key     = isset( $_POST['key'] ) ? sanitize_text_field( wp_unslash( $_POST['key'] ) ) : '';

		if ( $post_id && $key ) {
			delete_post_meta( $post_id, $key );
			wp_send_json_success( array( 'message' => __( 'Meta deleted successfully.', 'fm-meta-data-manager-for-post' ) ) );
		}

		wp_send_json_error( array( 'message' => __( 'Invalid request.', 'fm-meta-data-manager-for-post' ) ) );
	}
);
