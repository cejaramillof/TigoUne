<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}
?>

<div class="ctrl-dashboard-main">

	<?php
	if ( isset( $_POST['form_name'] ) ) {
		$emptyFields = [ ];
		if ( ! isset( $_POST['activity_date'] ) || empty( $_POST['activity_date'] ) ) {
			array_push( $emptyFields, '"Fecha de inicio de la novedad" es campo obligatorio.' );
		}
		if ( ! isset( $_POST['user_id'] ) || empty( $_POST['user_id'] ) ) {
			array_push( $emptyFields, '"Cédula del entrenador" es campo obligatorio.' );
		}
		if ( ! isset( $_POST['novelty_time'] ) || empty( $_POST['novelty_time'] ) ) {
			array_push( $emptyFields, '"Duración de la novedad" es campo obligatorio.' );
		}
		if ( ! isset( $_POST['novelty_type'] ) || empty( $_POST['novelty_type'] ) ) {
			array_push( $emptyFields, '"Tipo de novedad" es campo obligatorio.' );
		}
		if ( ! isset( $_POST['novelty_description'] ) || empty( $_POST['novelty_description'] ) ) {
			array_push( $emptyFields, '"Descripción de la novedad" es campo obligatorio.' );
		}

		if ( sizeof( $emptyFields ) > 0 ) {
			echo '<div class="message error"><span>ERROR: No se ha registrado la novedad por los siguientes errores:</span><ul>';
			foreach ( $emptyFields as $field ) {
				echo '<li>' . $field . '</li>';
			}
			echo '</ul><span>Ingresa la novedad nuevamente.</span></div>';
		} else {

			global $wpdb;
			$tableForms     = $wpdb->prefix . "control_forms";
			$tableFormsMeta = $wpdb->prefix . "control_forms_meta";

			$formName = 'for_vas_novelty_movil';

			date_default_timezone_set( 'America/Bogota' );
			$current_user = wp_get_current_user();

			$wpdb->insert( $tableForms, array(
				'form'    => $formName,
				'user_id' => $_POST['user_id']
			), array( '%s', '%s' ) );

			$formID = $wpdb->insert_id;

			$wpdb->insert( $tableFormsMeta, array(
				'form_id' => $formID,
				'meta'    => 'activity_date',
				'value'   => $_POST['activity_date']
			), array( '%d', '%s', '%s' ) );

			$wpdb->insert( $tableFormsMeta, array(
				'form_id' => $formID,
				'meta'    => 'user_registrar',
				'value'   => $current_user->user_login
			), array( '%d', '%s', '%s' ) );

			$wpdb->insert( $tableFormsMeta, array(
				'form_id' => $formID,
				'meta'    => 'novelty_time',
				'value'   => $_POST['novelty_time']
			), array( '%d', '%s', '%s' ) );

			$wpdb->insert( $tableFormsMeta, array(
				'form_id' => $formID,
				'meta'    => 'novelty_type',
				'value'   => $_POST['novelty_type']
			), array( '%d', '%s', '%s' ) );

			$wpdb->insert( $tableFormsMeta, array(
				'form_id' => $formID,
				'meta'    => 'novelty_description',
				'value'   => $_POST['novelty_description']
			), array( '%d', '%s', '%s' ) );

			echo '<div class="message success"><span>¡Novedad registrada con éxito!</span></div>';
		}
	}
	?>

	<h2>Registro de Novedades</h2>


	<form id="form-novelty" method="post" action="?page=news">
		<input type="hidden" name="page" value="news">
		<input type="hidden" name="form_name" value="for_vas_novelty">

		<div class="form-item">
			<label><span>Fecha de inicio de la novedad</span><input class="date-picker" type="text" name="activity_date" required></label>
		</div>

		<div class="form-item">
			<label><span>Cédula del entrenador</span><input type="number" min="1" max="9999999999" name="user_id"></label>
		</div>

		<div class="form-item">
			<label><span>Duración de la novedad</span>
				<select name="novelty_time">
					<option selected disabled>Selecciona...</option>
					<option value="180">Medio día</option>
					<option value="360">1 día</option>
					<option value="540">1 día y medio</option>
					<option value="720">2 días</option>
					<option value="1080">3 días</option>
					<option value="1440">4 días</option>
					<option value="1800">5 días</option>
					<option value="2160">6 días</option>
					<option value="2520">7 días</option>
					<option value="2880">8 días</option>
					<option value="3240">9 días</option>
					<option value="3600">10 días</option>
					<option value="3960">11 días</option>
					<option value="4320">12 días</option>
					<option value="4680">13 días</option>
					<option value="5040">14 días</option>
					<option value="5400">15 días</option>
					<option value="5760">16 días</option>
					<option value="6120">17 días</option>
					<option value="6480">18 días</option>
					<option value="6840">19 días</option>
					<option value="7200">20 días</option>
					<option value="7560">21 días</option>
					<option value="7920">22 días</option>
					<option value="8280">23 días</option>
				</select>
			</label>
		</div>

		<div class="form-item">
			<label><span>Tipo de novedad</span>
				<select name="novelty_type">
					<option selected disabled>Selecciona...</option>
					<option value="Incapacidad">Incapacidad</option>
					<option value="Calamidad">Calamidad</option>
					<option value="Permiso">Permiso</option>
					<option value="Entrenamiento">Entrenamiento</option>
					<option value="Líder de Entrenamiento">Líder de Entrenamiento</option>
					<option value="Reunion">Reunion</option>
					<option value="Vacaciones">Vacaciones</option>
					<option value="Maternidad">Maternidad</option>
					<option value="Terminación de contrato">Terminación de contrato</option>
                    <option value="Inducción servicio tienda">Inducción servicio tienda</option>
					<option value="Otro">Otro</option>
				</select>
			</label>
		</div>

		<div class="form-item">
			<label><span>Descripción de la novedad</span>
				<textarea name="novelty_description" rows="4"></textarea>
			</label>
		</div>

		<div class="form-item">
			<input type="submit" value="Enviar">

			<div id="form-submit">Enviar</div>
		</div>
</div>
