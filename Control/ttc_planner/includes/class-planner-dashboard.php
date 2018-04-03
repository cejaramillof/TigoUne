<?php

class Planner_Dashboard {

	/** @var Planner */
	protected $planner;

	/** @var Planner_Editor_Interface */
	protected $editor;

	public function __construct( $p, $e ) {
		$this->planner = $p;
		$this->editor  = $e;
		$this->hooks();
	}

	private function hooks() {
		add_shortcode( 'plnr-dashboard-ui', array( $this, 'dashboard_ui' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	public function register_scripts() {
		wp_register_style( 'plnr-styles', PLANNER_DIR . 'css/planner-style.css' );
		wp_register_script( 'plnr-dashboard-js', PLANNER_DIR . 'js/planner-dashboard.js', 'underscore', '', true );
	}

	public static function enqueue_scripts() {
		global $post;
		if ( is_a( $post, 'WP_Post' ) && ( has_shortcode( $post->post_content, 'plnr-dashboard-ui' ) ) ) {
			wp_enqueue_style( 'plnr-styles' );
			wp_enqueue_script( 'jquery-ui-datepicker', 'jquery', true );
			wp_enqueue_script( 'underscore', 'jquery-ui-datepicker', true );
			wp_enqueue_script( 'plnr-dashboard-js' );
		}
	}

	public function dashboard_ui() {

		if ( ! $this->planner->user_can_admin() ) {
			echo '<p>No tienes acceso a esta sección</p>';
			die();
		}

		$currentUser = wp_get_current_user();
		?>
		<div id="plnr-wrapper" class="plnr-dashboard">
			<div id="plnr-dashboard-panel">

				<div id="plnr-user-picker">
					<h2>Planeación por entrenador</h2>

					<?php
					$trainers = $this->planner->get_trainers();
					if ( $trainers ) {
						?>

                        <label for="plnr-admin-bu"></label>
                        <select id="plnr-admin-bu" class="plnr-load-users">
                            <option value="" selected disabled>Unidad de Negocio</option>
                            <option value="MOVIL">MOVIL</option>
                            <option value="HOGARES">HOGARES</option>
                            <option value="EMPRESAS">B2B</option>
                        </select>

                        <label for="plnr-admin-regional"></label>
						<select id="plnr-admin-regional" class="plnr-load-users">
							<option value="" selected disabled>Regional</option>
							<option value="CENTRO">CENTRO</option>
							<option value="COSTA">COSTA</option>
                            <option value="EJE_CAFETERO">EJE CAFETERO</option>
							<option value="NOROCCIDENTE">NOROCCIDENTE</option>
							<option value="ORIENTE">ORIENTE</option>
							<option value="SUROCCIDENTE">SUROCCIDENTE</option>
						</select>

						<label for="plnr-admin-trainers"></label>
						<select id="plnr-admin-trainers">
							<option value="" selected disabled>Entrenador</option>
							<?php
							foreach ( $trainers as $trainer ) {
								echo '<option value="' . $trainer['id'] . '" data-regional="' . $trainer['user_regional'] . '" data-bu="' . $trainer['business_unit'] . '">' . ucwords( mb_strtolower( $trainer['user_name'] ) ) . '</option>';
							}
							?>
						</select>
					<?php } ?>
					<a id="plnr-download-trainer-events" class="plnr-button" href="<?php echo PLANNER_DIR . 'includes/download-events.php'; ?>">Descargar</a>
				</div>

				<div id="plnr-datepicker">
					<div id="plnr-datepicker-container"></div>
				</div>

				<div id="plnr-dashboard-downloads-wrapper">
					<div id="plnr-dashboard-downloads">
						<h2>Descarga por regional</h2>
                        <label for="plnr-dashboard-regional-download-bu"></label>
                        <select id="plnr-dashboard-regional-download-bu">
                            <option value="ALL">TODAS</option>
                            <option value="MOVIL">MOVIL</option>
                            <option value="HOGARES">HOGARES</option>
                            <option value="EMPRESAS">B2B</option>
                        </select>

						<label for="plnr-dashboard-regional-download"></label>
						<select id="plnr-dashboard-regional-download">
                            <option value="ALL">TODAS</option>
							<option value="CENTRO">CENTRO</option>
							<option value="COSTA">COSTA</option>
                            <option value="EJE_CAFETERO">EJE CAFETERO</option>
							<option value="NOROCCIDENTE">NOROCCIDENTE</option>
							<option value="ORIENTE">ORIENTE</option>
							<option value="SUROCCIDENTE">SUROCCIDENTE</option>
						</select>

						<label for="plnr-dashboard-regional-download-year"></label>
						<select id="plnr-dashboard-regional-download-year">
                            <option value="2018">2018</option>
                            <option value="2017">2017</option>
                            <option value="2016">2016</option>
						</select>

						<label for="plnr-dashboard-regional-download-month"></label>
						<select id="plnr-dashboard-regional-download-month">
							<option value="1">Enero</option>
							<option value="2">Febrero</option>
							<option value="3">Marzo</option>
							<option value="4">Abril</option>
							<option value="5">Mayo</option>
							<option value="6">Junio</option>
							<option value="7">Julio</option>
							<option value="8">Agosto</option>
							<option value="9">Septiembre</option>
							<option value="10">Octubre</option>
							<option value="11">Noviembre</option>
							<option value="12">Diciembre</option>
						</select>

						<a id="plnr-download-regional-events" class="plnr-button" href="<?php echo PLANNER_DIR . 'includes/download-events-dashboard.php'; ?>">Descargar</a>
					</div>
				</div>
			</div>

			<div id="plnr-datelist">
				<div class="plnr-title-bar">
					<h2>Actividades</h2>
				</div>
				<div id="plnr-event-list" class="plnr-event-list">
				</div>
			</div>
		</div>
		<?php
		include( 'templates.php' );
	}
}