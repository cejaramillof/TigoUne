<?php

class Planner_AJAX_Interface {

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
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			add_action( 'wp_ajax_ajax_handler', array( $this, 'ajax_handler' ) );
			add_action( 'wp_ajax_nopriv_ajax_handler', array( $this, 'ajax_handler' ) );
		}
	}

	public function enqueue_scripts() {
		wp_localize_script( 'plnr-editor-js', 'ajax_planner', array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'action'  => 'ajax_handler',
			'nonce'   => wp_create_nonce( 'ajax_handler' )
		) );

		wp_localize_script( 'plnr-viewer-js', 'ajax_planner', array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'action'  => 'ajax_handler',
			'nonce'   => wp_create_nonce( 'ajax_handler' )
		) );

		wp_localize_script( 'plnr-dashboard-js', 'ajax_planner', array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'action'  => 'ajax_handler',
			'nonce'   => wp_create_nonce( 'ajax_handler' )
		) );
	}

	public function ajax_handler() {
		if ( ! check_ajax_referer( 'ajax_handler', 'nonce' ) || ! is_user_logged_in() || ! isset( $_POST['directive'] ) ) {
			die;
		};

		$directive = esc_textarea( $_POST['directive'] );

		switch ( $directive ) {
			case 'get_events_ui':
				if ( ! isset( $_POST['year'], $_POST['month'] ) ) {
					echo 'Error: Wrong parameters passed';
					die;
				}

				$response = $this->get_events_ui();
				echo json_encode( $response );
				break;

			case 'get_events_ui_no_edit':
				if ( ! isset( $_POST['year'], $_POST['month'] ) ) {
					echo 'Error: Wrong parameters passed';
					die;
				}

				$response = $this->get_events_ui_no_edit();
				echo json_encode( $response );
				break;

			case 'get_planner_info':
				$response = $this->get_planner_info();
				echo $response;
				break;

			case 'get_poscode_info':
				if ( ! isset( $_POST['data'] ) ) {
					echo 'Error: Wrong parameters passed';
					die;
				}
				$data     = sanitize_text_field( $_POST['data'] );
				$response = $this->planner->get_poscode_info( $data );
				echo json_encode( $response );
				break;

			case 'save_event':
				if ( ! isset( $_POST['data'] ) ) {
					echo 'Error: Wrong parameters passed';
					die;
				}
				$data = array();
				parse_str( $_POST['data'], $data );

				foreach ( $data as $key => $value ) {
					if ( $value == "" ) {
						echo json_encode( "Empty parameters" );
						die;
					}
				}

				$event             = $this->planner->save_event( $data );
				$html              = $this->editor->render_event_item_edit( $event );
				$response['event'] = $event;
				$response['html']  = $html;
				echo json_encode( $response );
				break;

			case 'delete_event':
				if ( ! isset( $_POST['data'] ) ) {
					echo false;
					die;
				}
				$id    = sanitize_text_field( $_POST['data'] );
				$event = $this->planner->delete_event( $id );
				echo json_encode( $event );
				break;

			default:
				break;
		}

		die;
	}

	function get_events_ui() {
		$year  = esc_textarea( $_POST['year'] );
		$month = esc_textarea( $_POST['month'] );

		if ( $year == 0 || $month == 0 ) {
			$year  = date( 'Y' );
			$month = date( 'n' );
		}

		$edit = $this->planner->user_can_edit();

		global $current_user;
		get_currentuserinfo();
		$userID = $current_user->user_login;

		$response['today']  = date( 'Y-n-j' );
		$response['events'] = $this->planner->get_events( $year, $month, $userID );

		$args = array(
			'year'          => $year,
			'month'         => $month,
			'events'        => $response['events'],
			'user_can_edit' => $edit,
			'month_to_edit' => $this->planner->open_month(),
		);

		$response['html'] = $this->editor->events_ui( $args );
		$response['edit'] = $edit;

		return $response;
	}

	function get_events_ui_no_edit() {
		$year  = esc_textarea( $_POST['year'] );
		$month = esc_textarea( $_POST['month'] );

		if ( $year == 0 || $month == 0 ) {
			$year  = date( 'Y' );
			$month = date( 'n' );
		}

		$edit = $this->planner->user_can_edit();

		if ( isset( $_POST['user'] ) ) {
			$userID = esc_textarea( $_POST['user'] );
		} else {
			global $current_user;
			get_currentuserinfo();
			$userID = $current_user->user_login;
		}

		$response['today']  = date( 'Y-n-j' );
		$response['events'] = $this->planner->get_events( $year, $month, $userID );

		$args = array(
			'year'   => $year,
			'month'  => $month,
			'events' => $response['events'],
		);

		$response['html'] = $this->editor->events_ui_no_edit( $args );
		$response['edit'] = $edit;

		return $response;
	}

	function get_planner_info() {

		$date       = date( 'n' );
		$months     = unserialize( PLANNER_MONTHS );
		$month_name = $months[ $date ];

		$maxDate = date( 'Y/m/t' );
		$date    = strtotime( $maxDate . ' 10 days ago' );
		$minDate = date( 'Y/m/j', $date );

		$maxDate = date( 'd/m/Y', strtotime( $maxDate ) );
		$minDate = date( 'd/m/Y', strtotime( $minDate ) );

		if ( $this->planner->user_can_edit() ) {
			$html = '<div id="plnr-info" class="open-edit">';
			$html .= '<div><h2>Planeación abierta</h2><div>';
			$html .= '<div><h3>Planeación del mes de ' . $month_name . ':</h3><div>';
			$html .= '<div>Apertura: ' . $minDate . ' 12:00am</div>';
			$html .= '<div>Cierre: ' . $maxDate . ' 11:59pm</div>';

		} else {
			$html = '<div id="plnr-info" class="close-edit">';
			$html .= '<div><h2>Planeación cerrada</h2><div>';
			$html .= '<div><h3>Planeación del mes de ' . $month_name . ':</h3><div>';
			$html .= '<div>Apertura: <span>' . $minDate . ' 12:00am</span></div>';
			$html .= '<div>Cierre: <span>' . $maxDate . ' 11:59pm</span></div>';
		}

		$html .= '</div>';

		return $html;
	}
}