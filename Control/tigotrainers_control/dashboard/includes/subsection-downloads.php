<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

?>

<div class="ctrl-dashboard-main">

	<h2>Descarga de Formularios</h2>

	<form id="control-download-form" method="post" action="<?php echo plugin_dir_url(__FILE__).'includes/download_forms.php';?>">
		<div class="form-item">
			<label>
				<span>Formato*</span>
				<select name="form">
					<?php if( $role != 'SUPERVISOR' ): ?>
						<option value="" selected disabled>Selecciona...</option>
						<option value="for_vas_mark">Marcación</option>
						<option value="for_vas_novelty">Novedades</option>
						<option value="for_vas_07">Acompañamiento</option>
						<option value="for_vas_33">Inducción</option>
						<option value="for_vas_34">Entrenamiento</option>
						<option value="for_vas_35">FOR_VAS_35</option>
					<?php else: ?>
						<option value="" selected disabled>Selecciona...</option>
						<option value="for_vas_07">Acompañamiento</option>
					<?php endif; ?>
				</select>
			</label>
		</div>
		<div class="form-item">
			<label>
				<span>Fecha inicial*</span>
				<input class="date-picker" name="init-date" type="text" value="">
			</label>
		</div>
		<div class="form-item">
			<label>
				<span>Fecha final*</span>
				<input class="date-picker" name="end-date" type="text" value="">
			</label>
		</div>
		<div class="form-item">
			<input type="submit" value="Enviar">

			<div id="download-submit" class="form-submit">Descargar</div>
		</div>
	</form>
</div>