<?php

/*
Plugin Name: Tigotrainers Planner
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: Planeador de Entrenadores Tigotrainers.
Version: 1.0
Author: Juan Felipe Tobon Gutierrez
Author URI: http://URI_Of_The_Plugin_Author
License: GPLv2
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit( "Do not access this file directly." );
}

if ( ! class_exists( 'tigotrainersControl' ) ) {
	exit ( "Please install Tigotrainers Control to use this plugin" );
};

global $wpdb;

$holidays = [
	'2016-1-1',
	'2016-1-11',
	'2016-3-21',
	'2016-3-24',
	'2016-3-25',
	'2016-5-9',
	'2016-5-30',
	'2016-6-6',
	'2016-7-4',
	'2016-7-20',
	'2016-8-15',
	'2016-10-17',
	'2016-11-07',
	'2016-11-14',
	'2016-12-8',
	'2017-1-9',
];

$months = array(
	'enero',
	'febrero',
	'marzo',
	'abril',
	'mayo',
	'junio',
	'julio',
	'agosto',
	'septiembre',
	'octubre',
	'noviembre',
	'diciembre'
);

define( 'PLANNER_DIR', plugin_dir_url( __FILE__ ) );
define( 'PLANNER_TB_CODES', $wpdb->prefix . 'planner_poscodes' );
define( 'PLANNER_TB_STRUCTURE', $wpdb->prefix . 'control_structure' );
define( 'PLANNER_TB_DATA', $wpdb->prefix . 'planner_registry' );
define( 'PLANNER_TB_CHARSET', $wpdb->get_charset_collate() );
define( 'PLANNER_HOLIDAYS', serialize( $holidays ) );
define( 'PLANNER_MONTHS', serialize( $months ) );

include_once( 'includes/class-planner-setup.php' );
include_once( 'includes/class-planner.php' );
include_once( 'includes/class-planner-editor-interface.php' );
include_once( 'includes/class-planner-viewer.php' );
include_once( 'includes/class-planner-dashboard.php' );
include_once( 'includes/class-planner-ajax.php' );

$plannerSetup    = new Planner_Setup();
$plannerMain     = new Planner();
$editorInterface = new Planner_Editor_Interface();
$dashboardInterface = new Planner_Dashboard($plannerMain, $editorInterface);
$ajaxInterface   = new Planner_AJAX_Interface( $plannerMain, $editorInterface );

register_activation_hook( __FILE__, array( $plannerSetup, 'install' ) );
