<?php
/**
 * Sends visitors from an old URL to its new URL.
 *
 * @package EngineWP\SafeRedirect
 */

namespace EngineWP\SafeRedirect\Redirect;

use EngineWP\SafeRedirect\Database\RedirectTable;

/**
 * Looks up the current URL in the redirects table and redirects when a match is found.
 */
class RedirectHandler {

	/**
	 * Redirects the current request if an admin has saved a redirect for its path.
	 *
	 * Runs on template_redirect before the 404 logger, so a redirected URL is never logged.
	 *
	 * @return void
	 */
	public function page_redirect() {
		$url = isset( $_SERVER['REQUEST_URI'] ) ? wp_parse_url( wp_unslash( esc_url_raw( $_SERVER['REQUEST_URI'] ) ), PHP_URL_PATH ) : null;
		if ( null === $url ) {
			return;
		}

		global $wpdb;

		$redirect_table = new RedirectTable();
		$table_name     = $redirect_table->table_name();

		$get_url_info = $wpdb->get_row( $wpdb->prepare( 'SELECT old_url, new_url, redirect_type FROM %i WHERE old_url = %s', $table_name, $url ), ARRAY_A );

		if ( ! empty( $get_url_info ) ) {
			wp_redirect( $get_url_info['new_url'], $get_url_info['redirect_type'] );
			exit;
		}
		return;
	}
}
