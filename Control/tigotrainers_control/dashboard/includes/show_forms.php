<?php

if ( ! isset( $_POST['form'] ) ) {
	die( 'Error, en vista. Intentalo de nuevo!' );
}

define( 'PATH_TO_WORDPRESS', $_SERVER["DOCUMENT_ROOT"]);

require PATH_TO_WORDPRESS . '/wp-load.php';

$form     = sanitize_text_field( $_POST['form'] );

switch ( $form ) {
	case 'for_vas_mark':
		query_forvas_mark( $form );
		break;
	case 'for_vas_novelty':
		query_forvas_novelty( $form );
		break;
	case 'for_vas_07':
		query_forvas_07( $form );
		break;
	case 'for_vas_07_2':
		query_forvas_07_2( $form );
		break;
	case 'for_vas_33':
		query_forvas_33( $form );
		break;
	case 'for_vas_33_2':
		query_forvas_33_2( $form );
		break;
	case 'for_vas_34':
		query_forvas_34( $form );
		break;
	case 'for_vas_34_2':
		query_forvas_34_2( $form );
		break;
	case 'for_vas_34_3':
		query_forvas_34_3( $form );
		break;
	case 'for_vas_34_4':
		query_forvas_34_4( $form );
		break;
	case 'for_vas_35':
		query_forvas_35( $form );
		break;
	case 'for_vas_38':
		query_forvas_38( $form );
		break;
	default:
		break;
}

function query_forvas_mark($formName ) {

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

	AND ttr_control_forms.user_id != ''
	AND ttr_control_forms.form = 'for_vas_mark_movil'";

	$result   = $wpdb->get_results( $sql, ARRAY_A );
	$nameCols = $wpdb->get_col_info( 'name' );

	if ( ! $result ) {
		echo "No hay resultados";
		die();
	}

	download_csv( $filename, $result, $nameCols );
}

function query_forvas_novelty($formName ) {

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
	AND ttr_control_forms.form = 'for_vas_novelty_movil'";

	$result   = $wpdb->get_results( $sql, ARRAY_A );
	$nameCols = $wpdb->get_col_info( 'name' );

	if ( ! $result ) {
		echo "No hay resultados";
		die();
	}

	download_csv( $filename, $result, $nameCols );
}

function query_forvas_07($formName ) {
	global $wpdb;

	$sql = "SELECT * FROM trnrs_forvas07";

	$result   = $wpdb->get_results( $sql, ARRAY_A );
	$nameCols = $wpdb->get_col_info( 'name' );

	if ( ! $result ) {
		echo "No hay resultados";
		die();
	}

	download_csv( $filename, $result, $nameCols );
}

function query_forvas_07_2($formName ) {
	global $wpdb;

	$sql = "SELECT * FROM trnrs_forvas07_3";

	$result   = $wpdb->get_results( $sql, ARRAY_A );
	$nameCols = $wpdb->get_col_info( 'name' );

	if ( ! $result ) {
		echo "No hay resultados";
		die();
	}

	download_csv( $filename, $result, $nameCols );
}


function query_forvas_33($formName ) {
	global $wpdb;

	$sql = "SELECT * FROM trnrs_forvas33";

	$result   = $wpdb->get_results( $sql, ARRAY_A );
	$nameCols = $wpdb->get_col_info( 'name' );

	if ( ! $result ) {
		echo "No hay resultados";
		die();
	}

	download_csv( $filename, $result, $nameCols );
}

function query_forvas_33_2($formName ) {
	global $wpdb;

	$sql = "SELECT * FROM trnrs_forvas33_3";

	$result   = $wpdb->get_results( $sql, ARRAY_A );
	$nameCols = $wpdb->get_col_info( 'name' );

	if ( ! $result ) {
		echo "No hay resultados";
		die();
	}

	download_csv( $filename, $result, $nameCols );
}

function query_forvas_34($formName ) {
	global $wpdb;

	$sql = "SELECT * FROM trnrs_forvas34";

	$result   = $wpdb->get_results( $sql, ARRAY_A );
	$nameCols = $wpdb->get_col_info( 'name' );

	if ( ! $result ) {
		echo "No hay resultados";
		die();
	}

	download_csv( $filename, $result, $nameCols );
}

function query_forvas_34_2($formName ) {
	global $wpdb;

	$sql = "SELECT * FROM trnrs_forvas34_3";

	$result   = $wpdb->get_results( $sql, ARRAY_A );
	$nameCols = $wpdb->get_col_info( 'name' );

	if ( ! $result ) {
		echo "No hay resultados";
		die();
	}

	download_csv( $filename, $result, $nameCols );
}

function query_forvas_34_3($formName ) {
	global $wpdb;

	$sql = "SELECT * FROM trnrs_forvas34";
	$result = $wpdb->get_results( $sql, ARRAY_A );

	if ( ! $result ) {
		echo "No hay resultados";
		die();
	}

	$result2 = array();

	foreach ($result as $fila){
		$temas = explode(", ", $fila['temas_entrenamiento']);
		foreach ($temas as $v) {
			$fila['temas_entrenamiento'] = $v;
			$result2[] = $fila;
		}
 	}

	$nameCols = $wpdb->get_col_info( 'name' );

	download_csv( $filename, $result2, $nameCols );
}

function query_forvas_34_4($formName ) {
	global $wpdb;

	$sql = "SELECT * FROM trnrs_forvas34_3";
	$result = $wpdb->get_results( $sql, ARRAY_A );

	if ( ! $result ) {
		echo "No hay resultados";
		die();
	}

	$result2 = array();

	foreach ($result as $fila){
		$temas = explode(", ", $fila['temas_entrenamiento']);
		foreach ($temas as $v) {
			$fila['temas_entrenamiento'] = $v;
			$result2[] = $fila;
		}
 	}

	$nameCols = $wpdb->get_col_info( 'name' );

	download_csv( $filename, $result2, $nameCols );
}

function query_forvas_38($formName ) {
	global $wpdb;

	$sql = "SELECT * FROM trnrs_forvas38";

	$result   = $wpdb->get_results( $sql, ARRAY_A );
	$nameCols = $wpdb->get_col_info( 'name' );

	if ( ! $result ) {
		echo "No hay resultados";
		die();
	}

	download_csv( $filename, $result, $nameCols );
}

function query_forvas_35($formName ) {
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

	   AND ttr_control_forms . user_id != ''
	                                                                                                     AND ttr_control_forms . form = 'for_vas_35_movil'
	";

	$result   = $wpdb->get_results( $sql, ARRAY_A );
	$nameCols = $wpdb->get_col_info( 'name' );

	if ( ! $result ) {
		echo "No hay resultados";
		die();
	}

	download_csv( $filename, $result, $nameCols );
}
