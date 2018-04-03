<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

$meses     = [ 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre' ];
$trainerID = $_GET['trainerID'];

if ( ! isset( $_GET['date'] ) ) {
	$month = date( 'm' );
} else {
	$month = $_GET['date'];
}

$year      = date( 'Y' );
$today     = date( 'd' );
$daysMonth = date('j');

$sql         = "SELECT user_name FROM ttr_control_structure WHERE id=$trainerID";
$trainerName = $wpdb->get_var( $sql );

if ( ! $trainerName ) {
	echo '<div class="ctrl-dashboard-main">';
	echo '<h2>Registro de actividad - ' . $meses[ ( $month * 1 ) - 1 ] . '</h2>';
	echo '<p>El entrenador no existe.</p>';
	echo '</div>';
} else {

	$sql = "CREATE TEMPORARY TABLE IF NOT EXISTS filterForms
		(SELECT
		 id,
		 user_id,
		 form,
		 CONVERT_TZ(timestamp, '+00:00', '-05:00') AS timestamp
		 FROM ttr_control_forms
		 WHERE ttr_control_forms.timestamp BETWEEN CONVERT_TZ('$year-$month-01 00:00:00', '-05:00', '+00:00') AND CONVERT_TZ('$year-$month-$today 23:59:59', '-05:00', '+00:00')
		 AND ttr_control_forms.user_id = '$trainerID'
		 AND ttr_control_forms.form != 'for_vas_mark');";

	$wpdb->query( $sql );

	$sql = "ALTER TABLE filterForms ADD INDEX (id);";

	$wpdb->query( $sql );

	$sql = "CREATE TEMPORARY TABLE IF NOT EXISTS formData
		(SELECT
		 form_id AS id,
		 MAX(CASE WHEN meta = 'training_time' THEN value END) tiempo_entrenamiento,
		 MAX(CASE WHEN meta = 'activity_date' THEN STR_TO_DATE(value, '%d/%m/%Y') END) fecha_actividad
		 FROM ttr_control_forms_meta
		GROUP BY ttr_control_forms_meta.form_id );";

	$wpdb->query( $sql );

	$sql = "ALTER TABLE formData ADD INDEX (id);";

	$wpdb->query( $sql );

	$sql = "SELECT DAY(formData.fecha_actividad) AS fecha,
		ROUND(SUM(formData.tiempo_entrenamiento)/60,1) AS tiempo

		FROM filterForms

		LEFT JOIN formData

		ON filterForms.id = formData.id

		GROUP BY formData.fecha_actividad";

	$result = $wpdb->get_results( $sql );
	$hoursData = array();
	if ($result){
		foreach ($result as $item){
			$hoursData[$item->fecha] = $item->tiempo;
		}
		$hoursData = json_encode($hoursData);
	}

	$sql = "SELECT filterForms.user_id,
		DAY(formData.fecha_actividad) AS fecha,
		filterForms.form,
		COUNT(filterForms.form) AS cantidad

		FROM filterForms

		LEFT JOIN formData

		ON filterForms.id = formData.id

		GROUP BY formData.fecha_actividad, filterForms.form";

	$result = $wpdb->get_results( $sql );
	$forvas07Data = [];
	$forvas34Data = [];
	$forvas33Data = [];
	$forvas35Data = [];

	if ($result){
		foreach ($result as $item){
			switch($item->form){
				case 'for_vas_07':
					$forvas07Data[$item->fecha] = $item->cantidad;
					break;
				case 'for_vas_33':
					$forvas33Data[$item->fecha] = $item->cantidad;
					break;
				case 'for_vas_34':
					$forvas34Data[$item->fecha] = $item->cantidad;
					break;
				case 'for_vas_35':
					$forvas35Data[$item->fecha] = $item->cantidad;
					break;
				default:
					break;
			}

		}
		$forvas07Data = json_encode($forvas07Data);
		$forvas33Data = json_encode($forvas33Data);
		$forvas34Data = json_encode($forvas34Data);
		$forvas35Data = json_encode($forvas35Data);
	}

	$monthName = $meses[ ( $month * 1 ) - 1 ];

	?>

	<script>
		var daysMonth = <?php echo $daysMonth; ?>;
		var hoursData = <?php echo $hoursData; ?>;
		var forvas07Data = <?php echo $forvas07Data; ?>;
		var forvas33Data = <?php echo $forvas33Data; ?>;
		var forvas34Data = <?php echo $forvas34Data; ?>;
		var forvas35Data = <?php echo $forvas35Data; ?>;
	</script>

	<div class="ctrl-dashboard-main">
		<h2>Registro de actividad - <?php echo $monthName; ?></h2>

		<div><?php echo ucwords( mb_strtolower( $trainerName ) ) ?></div>

		<h3>Horas de entrenamiento por día</h3>
		<div id="chart-time" style="margin-top: 10px; height: 250px;"></div>

		<h3>Formatos diligenciados</h3>
		<div id="chart-forms" style="margin-top: 10px; height: 250px;"></div>
	</div>
<?php } ?>