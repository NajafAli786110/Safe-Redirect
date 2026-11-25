<?php
/**
 * Creating custom table.
 *
 * @package EngineWP\SafeRedirect
 */

namespace EngineWP\SafeRedirect\Database;

/**
 * Create Log Table Class.
 */
class LogTable {

	/**
	 * Create custom table to save 404 logs.
	 *
	 * @return void
	 */
	public function create_table() {
		global $wpdb;

		// Set my table's prefix.
		$table_name = $this->table_name();

		// Set WordPress's database default character's settings.
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
        id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        url varchar(255) NOT NULL,
        hits int unsigned NOT NULL DEFAULT 0,
        last_seen datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        PRIMARY KEY  (id),
        UNIQUE KEY url (url)
        ) $charset_collate; ";

		// dbDelta() lives in this file, so it must be loaded first.
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );
	}

	/**
	 * Full table name with the site's prefix.
	 *
	 * @return string
	 */
	public function table_name() {
		global $wpdb;
		return $wpdb->prefix . 'safe_redirect_404_log';
	}
}
