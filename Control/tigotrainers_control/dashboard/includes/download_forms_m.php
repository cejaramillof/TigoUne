<?php

if ( ! isset( $_POST['form'], $_POST['init-date'], $_POST['end-date'] ) ) {
	die( 'Hackeando? Caca paopao!' );
}

define( 'PATH_TO_WORDPRESS', $_SERVER["DOCUMENT_ROOT"]);

require PATH_TO_WORDPRESS . '/wp-load.php';

$form     = sanitize_text_field( $_POST['form'] );
$initDate = sanitize_text_field( $_POST['init-date'] );
$endDate  = sanitize_text_field( $_POST['end-date'] );

$init = DateTime::createFromFormat( "d/m/Y", $initDate );
$init = $init->format( 'Y-m-d' );
$end  = DateTime::createFromFormat( "d/m/Y", $endDate );
$end  = $end->format( 'Y-m-d' );

switch ( $form ) {
	case 'for_vas_mark':
		query_forvas_mark( $init, $end, $form );
		break;
	case 'for_vas_novelty':
		query_forvas_novelty( $init, $end, $form );
		break;
	case 'for_vas_07':
		query_forvas_07( $init, $end, $form );
		break;
	case 'for_vas_07_2':
		query_forvas_07_2( $init, $end, $form );
		break;
	case 'for_vas_33':
		query_forvas_33( $init, $end, $form );
		break;
	case 'for_vas_33_2':
		query_forvas_33_2( $init, $end, $form );
		break;
	case 'for_vas_34':
		query_forvas_34( $init, $end, $form );
		break;
	case 'for_vas_34_2':
		query_forvas_34_2( $init, $end, $form );
		break;
	case 'for_vas_34_3':
		query_forvas_34_3( $init, $end, $form );
		break;
	case 'for_vas_35':
		query_forvas_35( $init, $end, $form );
		break;
	case 'for_vas_38':
		query_forvas_38( $init, $end, $form );
		break;
	default:
		break;
}

function add_csv_headers( $formName ) {
	$now = date( 'dmYHis' );

	header( 'Content-Type: text/csv' );
	header( 'Content-Disposition: attachment;filename="control_report_form_' . $formName . ' - ' . $now . '.csv"' );
	header( 'Cache-Control: max-age=0' );
// If you're serving to IE 9, then the following may be needed
	header( 'Cache-Control: max-age=1' );
// If you're serving to IE over SSL, then the following may be needed
	header( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' ); // Date in the past
	header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' ); // always modified
	header( 'Cache-Control: cache, must-revalidate' ); // HTTP/1.1
	header( 'Pragma: public' ); // HTTP/1.0
}

function download_csv( $filename, $data, $columns ) {

	$outstream = fopen( "php://output", "w" );

	fputs( $outstream, $bom = ( chr( 0xEF ) . chr( 0xBB ) . chr( 0xBF ) ) );

	fputcsv( $outstream, array( $filename ) );
	fputcsv( $outstream, array( '' ) );
	fputcsv( $outstream, $columns, ";", '"' );

	foreach ( $data as $res ) {
		fputcsv( $outstream, $res, ";", '"' );
	}

	fclose( $outstream );
	exit();
}

function query_forvas_mark( $i, $e, $formName ) {

	global $wpdb;

	$sql = "SELECT
	ttr_control_forms.id AS id,
	ttr_control_forms.user_id AS usuario,
	CONVERT_TZ(ttr_control_forms.timestamp, '-00:00', '-05:00') AS fecha_registro,
	latitud,
	longitud,
	pos_circuito,
	observaciones,
	estado,
	CONCAT('http://www.maps.google.com/?q=',latitud,',',longitud) AS Geolocalizar

	FROM ttr_control_forms

	INNER JOIN

	(SELECT
	 ttr_control_forms_meta.form_id AS id,
	 MAX(CASE WHEN ttr_control_forms_meta.meta = 'latitude' THEN ttr_control_forms_meta.value END) latitud,
	 MAX(CASE WHEN ttr_control_forms_meta.meta = 'longitude' THEN ttr_control_forms_meta.value END) longitud,
	 MAX(CASE WHEN ttr_control_forms_meta.meta = 'training_time' THEN ttr_control_forms_meta.value END) estado,
	 MAX(CASE WHEN ttr_control_forms_meta.meta = 'poscode_circuit' THEN ttr_control_forms_meta.value END) pos_circuito,
	 IFNULL(MAX(CASE WHEN ttr_control_forms_meta.meta = 'field_notes' THEN ttr_control_forms_meta.value END), '') observaciones
	 FROM ttr_control_forms_meta
	GROUP BY ttr_control_forms_meta.form_id
	) AS form_data

	ON form_data.id = ttr_control_forms.id

	AND ttr_control_forms.timestamp BETWEEN CONVERT_TZ('$i 00:00:00', '-05:00', '+00:00') AND CONVERT_TZ('$e 23:59:59', '-05:00', '+00:00')
	AND ttr_control_forms.user_id != ''
	AND ttr_control_forms.form = 'for_vas_mark_movil'";

	$result   = $wpdb->get_results( $sql, ARRAY_A );
	$nameCols = $wpdb->get_col_info( 'name' );

	if ( ! $result ) {
		echo "No hay resultados";
		die();
	}

	$filename = 'FORVAS_MARK - Reporte de formulario del ' . $i . ' al ' . $e;
	add_csv_headers( $formName );
	download_csv( $filename, $result, $nameCols );
}

function query_forvas_novelty( $i, $e, $formName ) {

	global $wpdb;

	$sql = "SELECT
	ttr_control_forms.id AS id,
	ttr_control_forms.user_id AS usuario,
	CONVERT_TZ(ttr_control_forms.timestamp, '-00:00', '-05:00') AS fecha_registro,
	form_data.fecha_actividad AS fecha_novedad,
	form_data.coordinador AS usuario_registrador,
	form_data.novedad/60 AS tiempo_novedad,
	form_data.tipo_novedad,
	form_data.descripcion

	FROM ttr_control_forms

	INNER JOIN

	(SELECT
	 ttr_control_forms_meta.form_id AS id,
	 MAX(CASE WHEN ttr_control_forms_meta.meta = 'activity_date' THEN ttr_control_forms_meta.value END) fecha_actividad,
	 MAX(CASE WHEN ttr_control_forms_meta.meta = 'user_registrar' THEN ttr_control_forms_meta.value END) coordinador,
	 MAX(CASE WHEN ttr_control_forms_meta.meta = 'novelty_time' THEN ttr_control_forms_meta.value END) novedad,
	 MAX(CASE WHEN ttr_control_forms_meta.meta = 'novelty_type' THEN ttr_control_forms_meta.value END) tipo_novedad,
	 MAX(CASE WHEN ttr_control_forms_meta.meta = 'novelty_description' THEN ttr_control_forms_meta.value END) descripcion
	 FROM ttr_control_forms_meta
	GROUP BY ttr_control_forms_meta.form_id
	) AS form_data

	ON form_data.id = ttr_control_forms.id
	AND ttr_control_forms.user_id != ''
	AND ttr_control_forms.timestamp BETWEEN CONVERT_TZ('$i 00:00:00', '-05:00', '+00:00') AND CONVERT_TZ('$e 23:59:59', '-05:00', '+00:00')
	AND ttr_control_forms.form = 'for_vas_novelty_movil'";

	$result   = $wpdb->get_results( $sql, ARRAY_A );
	$nameCols = $wpdb->get_col_info( 'name' );

	if ( ! $result ) {
		echo "No hay resultados";
		die();
	}

	$filename = 'NOVEDADES - Reporte de formulario del ' . $i . ' al ' . $e;
	add_csv_headers( $formName );
	download_csv( $filename, $result, $nameCols );
}

function query_forvas_07( $i, $e, $formName ) {
	global $wpdb;

	$sql = "SELECT * FROM trnrs_forvas07 WHERE fecha_actividad BETWEEN '$i' AND '$e'";

	$result   = $wpdb->get_results( $sql, ARRAY_A );
	$nameCols = $wpdb->get_col_info( 'name' );

	if ( ! $result ) {
		echo "No hay resultados";
		die();
	}

	$filename = 'FORVAS_07 - Reporte de formulario del ' . $i . ' al ' . $e;
	add_csv_headers( $formName );
	download_csv( $filename, $result, $nameCols );
}

function query_forvas_07_2( $i, $e, $formName ) {
	global $wpdb;

	$sql = "SELECT * FROM trnrs_forvas07_3 WHERE fecha_actividad BETWEEN '$i' AND '$e'";

	$result   = $wpdb->get_results( $sql, ARRAY_A );
	$nameCols = $wpdb->get_col_info( 'name' );

	if ( ! $result ) {
		echo "No hay resultados";
		die();
	}

	$filename = 'FORVAS_07 - Reporte de formulario del ' . $i . ' al ' . $e;
	add_csv_headers( $formName );
	download_csv( $filename, $result, $nameCols );
}


function query_forvas_33( $i, $e, $formName ) {
	global $wpdb;

	$sql = "SELECT * FROM trnrs_forvas33 WHERE fecha_actividad BETWEEN '$i' AND '$e'";

	$result   = $wpdb->get_results( $sql, ARRAY_A );
	$nameCols = $wpdb->get_col_info( 'name' );

	if ( ! $result ) {
		echo "No hay resultados";
		die();
	}

	$filename = 'FORVAS_33 - Reporte de formulario del ' . $i . ' al ' . $e;
	add_csv_headers( $formName );
	download_csv( $filename, $result, $nameCols );
}

function query_forvas_33_2( $i, $e, $formName ) {
	global $wpdb;

	$sql = "SELECT * FROM trnrs_forvas33_2 WHERE fecha_actividad BETWEEN '$i' AND '$e'";

	$result   = $wpdb->get_results( $sql, ARRAY_A );
	$nameCols = $wpdb->get_col_info( 'name' );

	if ( ! $result ) {
		echo "No hay resultados";
		die();
	}

	$filename = 'FORVAS_33 - Reporte de formulario del ' . $i . ' al ' . $e;
	add_csv_headers( $formName );
	download_csv( $filename, $result, $nameCols );
}

function query_forvas_34( $i, $e, $formName ) {
	global $wpdb;

	$sql = "SELECT * FROM trnrs_forvas34 WHERE fecha_actividad BETWEEN '$i' AND '$e'";

	$result   = $wpdb->get_results( $sql, ARRAY_A );
	$nameCols = $wpdb->get_col_info( 'name' );

	if ( ! $result ) {
		echo "No hay resultados";
		die();
	}

	$filename = 'FORVAS_34 - Reporte de formulario del ' . $i . ' al ' . $e;
	add_csv_headers( $formName );
	download_csv( $filename, $result, $nameCols );
}

function query_forvas_34_2( $i, $e, $formName ) {
	global $wpdb;

	$sql = "SELECT * FROM trnrs_forvas34_3 WHERE fecha_actividad BETWEEN '$i' AND '$e'";

	$result   = $wpdb->get_results( $sql, ARRAY_A );
	$nameCols = $wpdb->get_col_info( 'name' );

	if ( ! $result ) {
		echo "No hay resultados";
		die();
	}

	$filename = 'FORVAS_34 - Reporte de formulario del ' . $i . ' al ' . $e;
	add_csv_headers( $formName );
	download_csv( $filename, $result, $nameCols );
}

function query_forvas_34_3( $i, $e, $formName ) {
	global $wpdb;

	$sql = "SELECT * FROM trnrs_forvas34_3 WHERE fecha_actividad BETWEEN '$i' AND '$e'";

	while (($fila = mysqli_fetch_array($sql))!=NULL){
		$temas = explode(",", $fila['temas_entrenamiento']);

		foreach ($temas as $v) {
			$fila['temas_entrenamiento'] = $v
			$sql2 = array_merge($sql, $fila);
		}

	}

	$result   = $wpdb->get_results( $sql2, ARRAY_A );
	$nameCols = $wpdb->get_col_info( 'name' );

	if ( ! $result ) {
		echo "No hay resultados";
		die();
	}

	$filename = 'FORVAS_34 - Reporte de formulario del ' . $i . ' al ' . $e;
	add_csv_headers( $formName );
	download_csv( $filename, $result, $nameCols );
}

function query_forvas_38( $i, $e, $formName ) {
	global $wpdb;

	$sql = "SELECT * FROM trnrs_forvas38 WHERE fecha_actividad BETWEEN '$i' AND '$e'";

	$result   = $wpdb->get_results( $sql, ARRAY_A );
	$nameCols = $wpdb->get_col_info( 'name' );

	if ( ! $result ) {
		echo "No hay resultados";
		die();
	}

	$filename = 'FORVAS_38 - Reporte de formulario del ' . $i . ' al ' . $e;
	add_csv_headers( $formName );
	download_csv( $filename, $result, $nameCols );
}

function query_forvas_35( $i, $e, $formName ) {
	global $wpdb;

	$sql = "SELECT
	ttr_control_forms . id AS id,
	ttr_control_forms . user_id AS usuario,
	CONVERT_TZ( ttr_control_forms . timestamp, '+00:00', '-05:00' ) AS fecha_registro,
	fecha_actividad,
	latitud,
	longitud,
	circuito,
	tipo_entrenamiento,
	cedula_asesor,
	movil_asesor,
	coaching_1,
	coaching_2,
	coaching_3,
	coaching_4,
	coaching_5,
	tiempo_entrenamiento,
	id_punto_visitado,
	temas_entrenamiento,
	observaciones


	FROM ttr_control_forms

	INNER JOIN

	( SELECT
	 ttr_control_forms_meta . form_id AS ID,
	 MAX(CASE WHEN ttr_control_forms_meta . meta = 'latitude' THEN ttr_control_forms_meta . value END) latitud,
	 MAX(CASE WHEN ttr_control_forms_meta . meta = 'longitude' THEN ttr_control_forms_meta . value END) longitud,
	 MAX(CASE WHEN ttr_control_forms_meta . meta = 'activity_date' THEN ttr_control_forms_meta . value END) fecha_actividad,
	 MAX(CASE WHEN ttr_control_forms_meta . meta = 'poscode_circuit' THEN ttr_control_forms_meta . value END) circuito,
	 MAX(CASE WHEN ttr_control_forms_meta . meta = 'training_type' THEN ttr_control_forms_meta . value END) tipo_entrenamiento,
	 IFNULL( MAX(CASE WHEN ttr_control_forms_meta . meta = 'asesor_cc' THEN ttr_control_forms_meta . value END), '') cedula_asesor,
	 IFNULL( MAX(CASE WHEN ttr_control_forms_meta . meta = 'asesor_msisdn' THEN ttr_control_forms_meta . value END), '') movil_asesor,
	 IFNULL( MAX(CASE WHEN ttr_control_forms_meta . meta = 'coaching_1' THEN ttr_control_forms_meta . value END), '') coaching_1,
	 IFNULL( MAX(CASE WHEN ttr_control_forms_meta . meta = 'coaching_2' THEN ttr_control_forms_meta . value END), '') coaching_2,
	 IFNULL( MAX(CASE WHEN ttr_control_forms_meta . meta = 'coaching_3' THEN ttr_control_forms_meta . value END), '') coaching_3,
	 IFNULL( MAX(CASE WHEN ttr_control_forms_meta . meta = 'coaching_4' THEN ttr_control_forms_meta . value END), '') coaching_4,
	 IFNULL( MAX(CASE WHEN ttr_control_forms_meta . meta = 'coaching_5' THEN ttr_control_forms_meta . value END), '') coaching_5,
	 IFNULL( MAX(CASE WHEN ttr_control_forms_meta . meta = 'training_time' THEN ttr_control_forms_meta . value END), '') tiempo_entrenamiento,
	 IFNULL( MAX(CASE WHEN ttr_control_forms_meta . meta = 'id_visited' THEN ttr_control_forms_meta . value END), '') id_punto_visitado,
	 GROUP_CONCAT(CASE WHEN ttr_control_forms_meta . meta = 'training_theme' THEN
	              IFNULL( ( SELECT
	               ttr_control_training_themes . title
	               FROM ttr_control_training_themes
	               WHERE ttr_control_training_themes . id = ttr_control_forms_meta . value), ttr_control_forms_meta . value)
	              END SEPARATOR ', ') temas_entrenamiento,
	 IFNULL( MAX(CASE WHEN ttr_control_forms_meta . meta = 'field_notes' THEN ttr_control_forms_meta . value END), '') observaciones

	 FROM ttr_control_forms_meta
	GROUP BY ttr_control_forms_meta . form_id
	) AS form_data

	ON form_data . id = ttr_control_forms . id

	   AND ttr_control_forms . timestamp BETWEEN CONVERT_TZ( '$i 00:00:00', '-05:00', '+00:00' ) AND CONVERT_TZ( '$e 23:59:59', '-05:00', '+00:00' )
	                                                                                                 AND ttr_control_forms . user_id != ''
	                                                                                                     AND ttr_control_forms . form = 'for_vas_35_movil'
	";

	$result   = $wpdb->get_results( $sql, ARRAY_A );
	$nameCols = $wpdb->get_col_info( 'name' );

	if ( ! $result ) {
		echo "No hay resultados";
		die();
	}

	$filename = 'FORVAS_35 - Reporte de formulario del ' . $i . ' al ' . $e;
	add_csv_headers( $formName );
	download_csv( $filename, $result, $nameCols );
}
