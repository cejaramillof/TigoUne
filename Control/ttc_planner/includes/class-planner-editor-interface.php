<?php


class Planner_Editor_Interface {

	public function __construct() {
		$this->hooks();
	}

	private function hooks() {
		add_shortcode( 'plnr-editor-ui', array( $this, 'editor_ui' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	public function register_scripts() {
		wp_register_style( 'plnr-styles', PLANNER_DIR . 'css/planner-style.css' );
		wp_register_script( 'plnr-editor-js', PLANNER_DIR . 'js/planner-editor.js', 'underscore', '', true );
		wp_register_script( 'plnr-viewer-js', PLANNER_DIR . 'js/planner-viewer.js', 'underscore', '', true );
	}

	public static function enqueue_scripts() {
		global $post;
		if ( is_a( $post, 'WP_Post' ) && ( has_shortcode( $post->post_content, 'plnr-editor-ui' ) || has_shortcode( $post->post_content, 'ttr-control-interface' ) ) ) {
			wp_enqueue_style( 'plnr-styles' );
			wp_enqueue_script( 'jquery-ui-datepicker', 'jquery', true );
			wp_enqueue_script( 'underscore', 'jquery-ui-datepicker', true );

			if ( has_shortcode( $post->post_content, 'ttr-control-interface' ) ) {
				wp_enqueue_script( 'plnr-viewer-js' );
			}

			if ( has_shortcode( $post->post_content, 'plnr-editor-ui' ) ) {
				wp_enqueue_script( 'plnr-editor-js' );
			}
		}
	}

	public function editor_ui() {

		$currentUser = wp_get_current_user();
		?>
		<div id="plnr-wrapper">
			<div id="plnr-datepicker">
				<h1><img src="<?php echo PLANNER_DIR . '/assets/planner_logo.svg' ?>" alt="Planner" height="30"></h1>

				<div id="plnr-datepicker-container"></div>
				<div id="plnr-info-wrapper">
				</div>
				<div class="plnr-metabox plnr-special-codes">
					<h2>Códigos Especiales</h2>
					<ul>
						<li>1 - Reunión/entrenamiento Comercial</li>
						<li>2 - Entrenamiento/Reunión Retail</li>
						<li>3 - Entrenamiento/Reunión Dealers</li>
						<li>4 - Entrenamiento/Reunión FVD</li>
						<li>5 - Entrenamiento/Reunión CDE</li>
						<li>6 - Entrenamiento/Reunión Otros</li>
						<li>7 - Reunión / Lanzamiento</li>
						<li>8 - Train the Trainers</li>
						<li>9 - Informes</li>
						<li>10 - Planeación</li>
						<li>11 - Entrenamiento/Reunión Puntos Fijos</li>
						<li>12 - Entrenamiento/Reunión Canal Complementario</li>
						<li>13 - Entrenamiento/Reunión PAP</li>
						<li>14 - Entrenamiento/Reunión CDVS</li>
						<li>15 - Entrenamiento/Reunión Contact Center S.A.C</li>
						<li>16 - Entrenamiento/Reunión Contact Center S.T</li>
						<li>17 - Entrenamiento/Reunión Contact Entrada</li>
						<li>18 - Entrenamiento/Reunión Contact Salida</li>
						<li>19 - Entrenamiento/Reunión Contact Edatel</li>
						<li>20 - Inducción Nuevos</li>
						<li>21 - Reunión / Unidad Estratégica de Negocio (UEN)</li>
						<li>22 - Entrenamiento/Reunión AUR</li>
						<li>23 - CNV</li>
						<li>24 - Reunión Equipo Regional</li>
						<li>25 - Socialización Temas/GP Ventas</li>
						<li>26 - Entrenamiento/ Reunión  FV PYME</li>
						<li>27 - Entrenamiento/Reunión  Servicio</li>
						<li>28 - Entrenamiento/Reunión  Ingeniería</li>
						<li>30 - Entrenamiento / Reunión VP B2B</li>
						<li>31 - Planeando mi gestión</li>
					</ul>
				</div>
			</div>
			<div id="plnr-datelist">
				<div class="plnr-title-bar">
					<h2>Actividades</h2>
					<a id="plnr-download-events" href="<?php echo PLANNER_DIR.'includes/download-events.php'; ?>"  data-user="<?php echo $currentUser->user_login; ?>" data-year="" data-month="" title="Exportar"></a>
				</div>
				<div id="plnr-event-list" class="plnr-event-list">
				</div>
			</div>
		</div>
		<?php
		include( 'templates.php' );
	}

	public function events_ui( $args ) {

		$year        = $args['year'];
		$month       = $args['month'];
		$events      = $args['events'];
		$userCanEdit = $args['user_can_edit'];
		$monthToEdit = $args['month_to_edit'];

		$numDays  = cal_days_in_month( 1, $month, $year );
		$weekdays = [ 'Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado' ];
		$dayItems = array();

		for ( $i = 0; $i < $numDays; $i ++ ) {
			$day         = $i + 1;
			$date        = date( 'Y-n-j', strtotime( $year . '-' . $month . '-' . $day ) );
			$weekDay     = date( 'w', strtotime( $date ) );
			$weekDayName = $weekdays[ $weekDay ];
			$dayEvents   = array();

			if ( $weekDay != 0 && array_search( $date, unserialize( PLANNER_HOLIDAYS ) ) === false ) {
				$enabled = true;
			} else {
				$enabled = false;
			}

			if ( $events && sizeof( $events ) > 0 ) {
				foreach ( $events as $event ) {
					if ( $date == $event['date'] ) {
						array_push( $dayEvents, $event );
					}
				}
			}

			if ( sizeof( $dayEvents ) == 0 ) {
				$dayEvents = false;
			}

			$args = array(
				'day'     => $day,
				'date'    => $date,
				'weekday' => $weekDay,
				'dayname' => $weekDayName,
				'enabled' => $enabled,
				'events'  => $dayEvents
			);

			array_push( $dayItems, $args );
		}

		$html = '';
		foreach ( $dayItems as $item ) {

			if ( $item['enabled'] == true ) {
				$html .= '<div class="plnr-day-item" data-day="' . $item['day'] . '" data-date="' . $item['date'] . '">';
			} else {
				$html .= '<div class="plnr-day-item plnr-day-item-disabled" data-day="' . $item['day'] . '" data-date="' . $item['date'] . '">';
			}

			$html .= '<div class="plnr-day-item-title">';
			$html .= '<span class="plnr-day-item-title-number">' . $item['day'] . '</span>';
			$html .= '<span class="plnr-day-item-title-name">' . $item['dayname'] . '</span>';
			$html .= '</div>';

			if ( $item['enabled'] == true ) {
				$html .= '<div class="plnr-day-item-events">';

				if ( $item['events'] !== false ) {
					foreach ( $item['events'] as $ev ) {
						if ( $userCanEdit && $month == $monthToEdit ) {
							$html .= $this->render_event_item_edit( $ev );
						} else {
							$html .= $this->render_event_item( $ev );
						}
					}
				}

				$html .= '</div>';

				if ( $userCanEdit && $month == $monthToEdit ) {
					$html .= '<div class="plnr-day-item-add-event pnlr-event-focus">+ Nueva actividad</div>';
				}
			}

			$html .= '</div>';
		}

		return $html;
	}


	public function events_ui_no_edit( $args ) {

		$year   = $args['year'];
		$month  = $args['month'];
		$events = $args['events'];

		$numDays  = cal_days_in_month( 1, $month, $year );
		$weekdays = [ 'Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado' ];
		$dayItems = array();

		for ( $i = 0; $i < $numDays; $i ++ ) {
			$day         = $i + 1;
			$date        = date( 'Y-n-j', strtotime( $year . '-' . $month . '-' . $day ) );
			$weekDay     = date( 'w', strtotime( $date ) );
			$weekDayName = $weekdays[ $weekDay ];
			$dayEvents   = array();

			if ( $weekDay != 0 && array_search( $date, unserialize( PLANNER_HOLIDAYS ) ) === false ) {
				$enabled = true;
			} else {
				$enabled = false;
			}

			if ( $events && sizeof( $events ) > 0 ) {
				foreach ( $events as $event ) {
					if ( $date == $event['date'] ) {
						array_push( $dayEvents, $event );
					}
				}
			}

			if ( sizeof( $dayEvents ) == 0 ) {
				$dayEvents = false;
			}

			$args = array(
				'day'     => $day,
				'date'    => $date,
				'weekday' => $weekDay,
				'dayname' => $weekDayName,
				'enabled' => $enabled,
				'events'  => $dayEvents
			);

			array_push( $dayItems, $args );
		}

		$html = '';
		foreach ( $dayItems as $item ) {

			if ( $item['enabled'] == true ) {
				$html .= '<div class="plnr-day-item" data-day="' . $item['day'] . '" data-date="' . $item['date'] . '">';
			} else {
				$html .= '<div class="plnr-day-item plnr-day-item-disabled" data-day="' . $item['day'] . '" data-date="' . $item['date'] . '">';
			}

			$html .= '<div class="plnr-day-item-title">';
			$html .= '<span class="plnr-day-item-title-number">' . $item['day'] . '</span>';
			$html .= '<span class="plnr-day-item-title-name">' . $item['dayname'] . '</span>';
			$html .= '</div>';

			if ( $item['enabled'] == true ) {
				$html .= '<div class="plnr-day-item-events">';

				if ( $item['events'] !== false ) {
					foreach ( $item['events'] as $ev ) {
						$html .= $this->render_event_item( $ev );
					}
				}

				$html .= '</div>';
			}

			$html .= '</div>';
		}

		return $html;
	}

	public function render_event_item_edit( $ev ) {
		$html = '<div class="plnr-event-item" data-id="' . $ev['id'] . '">';

		if ( isset ( $ev['poscode'] ) ) {
			$html .= '<div class="plnr-event-item-title"><span class="plnr-event-item-title-code">' . $ev['poscode'] . '</span>';
			if ( isset ( $ev['poscode_name'] ) ) {
				$html .= '<span class="plnr-event-item-title-name">' . $ev['poscode_name'] . '</span>';
			}
			$html .= '</div>'; /*close item title*/
		}

		$html .= '<div class="plnr-event-item-details">';

		if ( isset ( $ev['channel'] ) ) {
			$html .= strtoupper( $ev['channel'] );
		}

		if ( isset ( $ev['city'] ) ) {
			$html .= ', ' . $ev['city'];
		}

		if ( isset ( $ev['department'] ) ) {
			$html .= ' (' . $ev['department'] . ')';
		}

		if ( isset ( $ev['regional'] ) ) {
			$html .= ' - ' . $ev['regional'];
		}

		$html .= '</div>'; /*close item details*/
		$html .= '<div class="plnr-event-item-actions">';
		$html .= '<span class="plnr-event-item-discard pnlr-event-focus" title="Eliminar"></span>';
		$html .= '</div>'; /*close item actions*/
		$html .= '</div>'; /*close item*/

		return $html;
	}

	public function render_event_item( $ev ) {
		$html = '<div class="plnr-event-item" data-id="' . $ev['id'] . '">';

		if ( isset ( $ev['poscode'] ) ) {
			$html .= '<div class="plnr-event-item-title"><span class="plnr-event-item-title-code">' . $ev['poscode'] . '</span>';
			if ( isset ( $ev['poscode_name'] ) ) {
				$html .= '<span class="plnr-event-item-title-name">' . $ev['poscode_name'] . '</span>';
			}
			$html .= '</div>'; /*close item title*/
		}

		$html .= '<div class="plnr-event-item-details">';

		if ( isset ( $ev['channel'] ) ) {
			$html .= strtoupper( $ev['channel'] );
		}

		if ( isset ( $ev['city'] ) ) {
			$html .= ', ' . $ev['city'];
		}

		if ( isset ( $ev['department'] ) ) {
			$html .= ' (' . $ev['department'] . ')';
		}

		if ( isset ( $ev['regional'] ) ) {
			$html .= ' - ' . $ev['regional'];
		}

		$html .= '</div>'; /*close item details*/
		$html .= '<div class="plnr-event-item-actions">';
		$html .= '</div>'; /*close item actions*/
		$html .= '</div>'; /*close item*/

		return $html;
	}
}