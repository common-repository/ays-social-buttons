<?php
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) )
	exit();

function ays_sb_delete_plugin() {
	global $wpdb;

	$table_name = $wpdb->prefix."ayssocial_buttons";
	$wpdb->query( "DROP TABLE IF EXISTS $table_name" );
}

ays_sb_delete_plugin();
?>