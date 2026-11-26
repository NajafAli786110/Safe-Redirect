<?php
/**
 * Create table for redirect page.
 *
 * @package EngineWP\SafeRedirect
 */

namespace EngineWP\SafeRedirect\Database;

/**
 * Custom table that stores redirects (old URL, new URL, 301 or 302).
 */
class RedirectTable {

	/**
	 * Creates or updates the redirects table with dbDelta.
	 *
	 * @return void
	 */
	public function create_table() {
		global $wpdb;

		$table_name      = $this->table_name();
		$charset_collate = $wpdb->get_charset_collate();

		$query = "CREATE TABLE $table_name (
        id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        old_url varchar(255) NOT NULL,
        new_url varchar(255) NOT NULL,
        redirect_type int NOT NULL,
        created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        updated_at datetime NOT NULL,
        PRIMARY KEY  (id),
        UNIQUE KEY old_url (old_url)
        ) $charset_collate; ";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $query );
	}

	/**
	 * Full table name with the site's prefix.
	 *
	 * @return string
	 */
	public function table_name() {
		global $wpdb;
		return $wpdb->prefix . 'safe_redirect_redirects';
	}
}
