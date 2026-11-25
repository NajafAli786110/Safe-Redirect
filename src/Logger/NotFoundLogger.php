<?php
/**
 * Saves every 404 request in the log table.
 *
 * @package EngineWP\SafeRedirect
 */

namespace EngineWP\SafeRedirect\Logger;

use EngineWP\SafeRedirect\Database\LogTable;

/**
 * Logs 404 URLs and counts how many times each one was hit.
 */
class NotFoundLogger {

	/**
	 * Saves the current URL if the request is a 404.
	 *
	 * A new URL gets a new row. A URL that is already logged gets hits + 1.
	 *
	 * @return void
	 */
	public function log_404() {
		if ( ! is_404() ) {
			return;
		}
		global $wpdb;

		if ( ! isset( $_SERVER['REQUEST_URI'] ) ) {
			return;
		}

		$url = esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) );

		if ( empty( $url ) ) {
			return;
		}

		$log_table  = new LogTable();
		$table_name = $log_table->table_name();

		// Custom table: no WordPress API exists for it, and 404 counts must not be cached.
        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
		$hits = $wpdb->get_var( $wpdb->prepare( 'SELECT hits FROM %i WHERE url = %s', $table_name, $url ) );

		if ( null !== $hits ) {
            // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
			$wpdb->update(
				$table_name,
				array(
					'hits'      => $hits + 1,
					'last_seen' => current_time( 'mysql' ),
				),
				array(
					'url' => $url,
				)
			);
		} else {
            // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
			$wpdb->insert(
				$table_name,
				array(
					'url'        => $url,
					'hits'       => 1,
					'last_seen'  => current_time( 'mysql' ),
					'created_at' => current_time( 'mysql' ),
				)
			);
		}
	}
}
