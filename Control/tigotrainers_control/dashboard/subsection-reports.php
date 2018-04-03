<?php


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

$cYear  = date( 'Y' );
$cMonth = date( 'm' );
$cDay   = date( 'd' );

if ( isset( $_GET['year'] ) ) {
	$year = $_GET['year'];
} else {
	$year = $cYear;
}

if ( isset( $_GET['month'] ) ) {
	$month = $_GET['month'];
} else {
	$month = $cMonth;
}

if ($cMonth != $month || $cYear != $year){
	$day = cal_days_in_month(CAL_GREGORIAN, $month, $year);
} else {
	$day   = $cDay;
}

$tzone = '-05:00';
$countdays   = countDays( $year, $month, array( 0, 6 ), $holidays );
$currentdays = countCurrentDays( $year, $month, $day, array( 0, 6 ), $holidays );

$sql_tempforms = "CREATE TEMPORARY TABLE IF NOT EXISTS form_time AS
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
AND user_id != ''
AND form != 'for_vas_mark'
AND activity_date BETWEEN '$year-$month-01' AND '$year-$month-$day');
";

$wpdb->query($sql_tempforms);

$sql_temptable = "CREATE TEMPORARY TABLE IF NOT EXISTS all_time AS
(SELECT
structure.user_regional AS regional,
structure.id AS usuario,
structure.user_name AS nombre,
IFNULL(ROUND(SUM(form_time_day.time),1), 0) AS tiempo,
IFNULL(novelties.novelty, 0) AS novedad,
ROUND(((IFNULL(SUM(form_time_day.time), 0))/(120 - IFNULL(novelties.novelty, 0)))*100, 1) AS cumplimiento,
ROUND(((((IFNULL(SUM(form_time_day.time), 0))/(120 - IFNULL(novelties.novelty, 0)))*$countdays)/$currentdays)*100, 1) AS proyectado

FROM

(SELECT user_regional, id, user_name, user_role
 FROM ttr_control_structure
 WHERE user_role NOT IN ('MANAGER', 'UBERMANAGER')) AS structure

LEFT JOIN

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

ON user_id = id

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
AND ttr_control_forms.user_id != ''
AND ttr_control_forms.timestamp BETWEEN CONVERT_TZ('$year-$month-01 00:00:00', '-05:00', '+00:00') AND CONVERT_TZ('$year-$month-$day 23:59:59', '-05:00', '+00:00')

GROUP BY ttr_control_forms.user_id) AS novelties

ON novelties.id = structure.id

GROUP BY structure.id
ORDER BY structure.user_regional, structure.user_name);
";
$wpdb->query($sql_temptable);

$sql_sel_temptable = "SELECT * FROM all_time";

$sql_regional = "SELECT regional,
ROUND(AVG(NULLIF(all_time.tiempo ,0)),1) AS tiempo,
ROUND(AVG(NULLIF(all_time.cumplimiento ,0)),1) AS cumplimiento,
ROUND(AVG(NULLIF(all_time.proyectado ,0)),1) AS proyectado

FROM

all_time

GROUP BY all_time.regional
ORDER BY all_time.regional";

$result = $wpdb->get_results( $sql_regional );

$result2 = $wpdb->get_results( $sql_sel_temptable );
?>

<div class="ctrl-dashboard-main">

	<h2>Tablero de Productividad - <?php echo $meses[($month*1)-1];?></h2>

	<div class="main-table-settings">
		<div>Dias del mes: <span><?php echo $countdays; ?></span></div>
		<div>Dias transcurridos: <span><?php echo $currentdays; ?></span></div>
		<form id="date-range" method="get" action="?page=reports">
			<label><span>Año</span>
				<select title="year" name="year">
					<option value="" disabled selected>Selecciona...</option>
					<option value="2016">2016</option>
				</select>
			</label>

			<label><span>Mes</span>
				<select title="month" name="month">
					<option value="" disabled selected>Selecciona...</option>
					<option value="01">Enero</option>
					<option value="02">Febrero</option>
				</select>
			</label>

			<input type="submit" value="Actualizar">
		</form>
	</div>

	<table id="control-trainer-results-regional" class="control-trainer-results">
		<thead>
		<tr>
			<th>Regional</th>
			<th>Tiempo Promedio</th>
			<th>Cumplimiento</th>
			<th>Proyectado</th>
		</tr>
		</thead>

		<?php
		foreach ( $result as $trainer ) { ?>
			<tr>
				<td><?php echo $trainer->regional; ?></td>
				<td><?php echo $trainer->tiempo; ?></td>
				<td class="kpi-data"><?php echo $trainer->cumplimiento; ?>%</td>
				<td class="kpi-data"><?php echo $trainer->proyectado; ?>%</td>
			</tr>
		<?php } ?>
	</table>

	<table id="control-trainer-results-trainer" class="control-trainer-results">
		<thead>
		<tr>
			<th>
				<select id="select-regional" title="Selecciona la regional">
					<option value="ALL" selected>Regional</option>
					<option value="CENTRO">Centro</option>
					<option value="COSTA">Costa</option>
					<option value="NOROCCIDENTE">Noroccidente</option>
					<option value="EJE_CAFETERO">Eje Cafetero</option>
					<option value="ORIENTE">Oriente</option>
					<option value="SUROCCIDENTE">Suroccidente</option>
				</select>
			</th>
			<th>Usuario</th>
			<th>Nombre</th>
			<th>Tiempo</th>
			<th>Novedades</th>
			<th>Cumplimiento</th>
			<th>Proyectado</th>
		</tr>
		</thead>
		<tbody>
		<?php
		foreach ( $result2 as $trainer ) { ?>
			<tr>
				<td><?php echo ucwords($trainer->regional); ?></td>
				<td><?php echo $trainer->usuario; ?></td>
				<td><?php echo ucwords($trainer->nombre); ?></td>
				<td><?php echo $trainer->tiempo; ?></td>
				<td><?php echo $trainer->novedad; ?></td>
				<td class="kpi-data"><?php echo $trainer->cumplimiento; ?>%</td>
				<td class="kpi-data"><?php echo $trainer->proyectado; ?>%</td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
</div>