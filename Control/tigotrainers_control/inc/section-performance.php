<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! is_user_logged_in() ) {
	exit;
}

$holidays = [
	"2016-01-01",
	"2016-01-11",
	"2016-03-21",
	"2016-03-24",
	"2016-03-25",
	"2016-05-09",
	"2016-05-30",
	"2016-06-36",
];

$meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

$year  = date( 'Y' );
$month = date( 'm' );
$day   = date( 'd' );

function countDays( $year, $month, $ignore, $holidays ) {

	$count   = 0;
	$counter = mktime( 0, 0, 0, $month, 1, $year );

	while ( date( "n", $counter ) == $month ) {
		if ( in_array( date( "w", $counter ), $ignore ) == false ) {
			if ( in_array( date( "Y-m-d", $counter ), $holidays ) == false ) {
				$count ++;
			}
		}
		$counter = strtotime( "+1 day", $counter );
	}

	return $count;
}

function countCurrentDays( $year, $month, $day, $ignore, $holidays ) {

	$count   = 0;
	$counter = mktime( 0, 0, 0, $month, 1, $year );

	while ( ( date( "n", $counter ) == $month ) && ( ( date( "d", $counter ) <= $day ) ) ) {
		if ( in_array( date( "w", $counter ), $ignore ) == false ) {
			if ( in_array( date( "Y-m-d", $counter ), $holidays ) == false ) {
				$count ++;
			}
		}
		$counter = strtotime( "+1 day", $counter );
	}

	return $count;
}

$countdays   = countDays( $year, $month, array( 0, 6 ), $holidays );
$currentdays = countCurrentDays( $year, $month, $day, array( 0, 6 ), $holidays );

global $wpdb;
global $current_user;
get_currentuserinfo();
$user_id = $current_user->user_login;

$sql = "CREATE TEMPORARY TABLE IF NOT EXISTS form_time AS
(SELECT
user_id,
activity_date,
IF (DATE_FORMAT(CONVERT_TZ(timestamp, '-00:00', '-05:00'), '%Y-%m-%d') != activity_date, 0, training_time) AS training_time

FROM ttr_control_forms

INNER JOIN

(SELECT
 ttr_control_forms_meta.form_id AS form_id,
 MAX(CASE WHEN ttr_control_forms_meta.meta = 'activity_date' THEN STR_TO_DATE(ttr_control_forms_meta.value, '%d/%m/%Y') END) AS activity_date,
 MAX(CASE WHEN ttr_control_forms_meta.meta = 'training_time' THEN ttr_control_forms_meta.value END) AS training_time
 FROM ttr_control_forms_meta
 GROUP BY ttr_control_forms_meta.form_id) AS form_data

ON id = form_id
AND user_id = '$user_id'
AND form != 'for_vas_mark'
AND activity_date BETWEEN '$year-$month-01' AND '$year-$month-$day');";


$wpdb->query($sql);

$sql = "SELECT
IFNULL(ROUND(SUM(form_time_day.time),1), 0) AS time,
IFNULL(novelties.novelty, 0) AS novelty,
ROUND(((IFNULL(SUM(form_time_day.time), 0))/(120 - IFNULL(novelties.novelty, 0)))*100, 1) AS cumplimiento,
ROUND(((((IFNULL(SUM(form_time_day.time), 0))/(120 - IFNULL(novelties.novelty, 0)))*$countdays)/$currentdays)*100, 1) AS proyectado

FROM

(SELECT
user_id,
activity_date,
IF (DAYOFWEEK(activity_date) IN (1,7) OR activity_date IN ('2016-01-01', '2016-01-11'),
     0,
     IF(SUM(training_time)/60 > 8,
        8,
        SUM(training_time)/60)) AS time

FROM

form_time

GROUP BY user_id, activity_date) AS form_time_day

LEFT JOIN

(SELECT
ttr_control_forms.user_id AS id,
SUM(form_data.novelty)/60 AS novelty

FROM ttr_control_forms

INNER JOIN

(SELECT
 ttr_control_forms_meta.form_id AS id,
 MAX(CASE WHEN ttr_control_forms_meta.meta = 'novelty_time' THEN ttr_control_forms_meta.value END) novelty
 FROM ttr_control_forms_meta
 GROUP BY ttr_control_forms_meta.form_id) AS form_data

ON form_data.id = ttr_control_forms.id
AND ttr_control_forms.user_id = '$user_id'
AND ttr_control_forms.timestamp BETWEEN CONVERT_TZ('$year-$month-01 00:00:00', '-05:00', '+00:00') AND CONVERT_TZ('$year-$month-$day 23:59:59', '-05:00', '+00:00')

GROUP BY ttr_control_forms.user_id) AS novelties

ON novelties.id = form_time_day.user_id

GROUP BY form_time_day.user_id";

$result = $wpdb->get_row($sql, ARRAY_A);
?>

<div class="control-section-container">
	<div class="control-section">
		<h2>Productividad (<?php echo $meses[($month*1)-1];?> de <?php echo $year; ?>)</h2>

		<div id="control-gauge" style="height: 150px; margin-bottom: 10px;"></div>

		<div class="item-kpi proyectado">
			<span>Proyectado:</span>
			<span id="val-proyectado" data-value="<?php echo $result['proyectado']; ?>"><?php echo $result['proyectado']; ?>%</span>
		</div>

		<div class="item-kpi cumplimiento">
			<span>Cumplimiento:</span>
			<span id="val-cumplimiento" data-value="<?php echo $result['cumplimiento']; ?>"><?php echo $result['cumplimiento']; ?>%</span>
		</div>

		<div class="item-kpi">
			<span>Días del mes:</span>
			<span><?php echo $countdays; ?> días</span>
		</div>
		<div class="item-kpi">
			<span>Días transcurridos:</span>
			<span><?php echo $currentdays; ?> días</span>
		</div>
		<div class="item-kpi">
			<span>Horas de entrenamiento:</span>
			<span><?php echo $result['time']; ?> horas</span>
		</div>
		<div class="item-kpi">
			<span>Horas de novedad:</span>
			<span><?php echo $result['novelty']; ?> horas</span>
		</div>
	</div>
</div>