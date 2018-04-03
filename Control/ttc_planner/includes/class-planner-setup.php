<?php

class Planner_Setup {

	public function __construct() {

	}

	public static function install() {
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		global $wpdb;

		$tableCodes     = $wpdb->prefix . "planner_poscodes";
		$tablePlanner   = $wpdb->prefix . "planner_registry";
		$charsetCollate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE IF NOT EXISTS $tableCodes(
            poscode VARCHAR(40) NOT NULL,
            poscode_name VARCHAR(140) NOT NULL,
            channel VARCHAR(20) NOT NULL,
            regional VARCHAR(20) NOT NULL,
            department VARCHAR(20) NOT NULL,
            city VARCHAR(30) NOT NULL,
            PRIMARY KEY poscode (poscode)
            )$charsetCollate;";
		dbDelta( $sql );

		$sql = "CREATE TABLE IF NOT EXISTS $tablePlanner(
            id INT AUTO_INCREMENT NOT NULL,
            user_id VARCHAR (40) NOT NULL,
            timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            date DATE,
            poscode VARCHAR (40) NOT NULL,
            poscode_name VARCHAR(140) NOT NULL,
            channel VARCHAR(20) NOT NULL,
            regional VARCHAR(20) NOT NULL,
            department VARCHAR(20) NOT NULL,
            city VARCHAR(30) NOT NULL,
            activity VARCHAR(140),
            notes VARCHAR(140),
            PRIMARY KEY id (id)
            )$charsetCollate;";
		dbDelta( $sql );
	}
}