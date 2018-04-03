<?php

class Planner {

	public function __construct() {
	}

	public function user_can_edit() {

		$today   = date( 'Y-n-j' );
		$maxDate = date( 'Y-n-t' );
		$minDate = date( 'Y-n-j', strtotime( $maxDate . ' 15 days ago' ) );
		$userCan = true;

		if ( $userCan && $today >= $minDate && $today <= $maxDate ) {
			return true;
		} else {
			return true;
		}
	}

	public static function get_trainers() {
		global $wpdb;
		$result = $wpdb->get_results( "SELECT * FROM ttr_control_structure WHERE user_role IN('TRAINER','TRAINER_LEADER') ORDER BY user_name", ARRAY_A );

		return $result;
	}

	public static function user_can_admin() {
		$allowed_roles = [ 'MANAGER', 'TRAINER_LEADER', 'UBERMANAGER' ];

		global $wpdb;

		$currentUser = wp_get_current_user();

		if ( ! current_user_can( 'manage_options' ) ) {

			$result = $wpdb->get_row( "SELECT * FROM ttr_control_structure WHERE id = '$currentUser->user_login'" );

			if ( ! $result || ! in_array( $result->user_role, $allowed_roles ) ) {
				return false;
			}
		}

		return true;
	}

	public function open_month() {
		$month = date( 'n', strtotime( date( 'Y-n-j' ) ) ) + 0;
		if ( $month > 12 ){
			return 1;
		} else {
			return $month;
		}
	}

	public function get_poscode_info( $data ) {
		global $wpdb;

		$sql = "SELECT * FROM " . PLANNER_TB_CODES . " WHERE poscode = '$data';";

		$result = $wpdb->get_row( $sql, 'ARRAY_A' );

		if ( $result ) {
			$result['poscode_name'] = strtolower( $result['poscode_name'] );
			$result['poscode_name'] = ucwords( $result['poscode_name'] );

			$result['city'] = strtolower( $result['city'] );
			$result['city'] = ucwords( $result['city'] );

			return $result;
		}

		return false;
	}

	public function get_events( $year, $month, $userID ) {
		global $wpdb;

		$dateBegin = $year . '-' . $month . '-01';
		$dateEnd   = date( 'Y-m-t', strtotime( $dateBegin ) );


		$sql = "SELECT * FROM " . PLANNER_TB_DATA . " ";
		$sql .= "WHERE user_id = '$userID' AND date BETWEEN '$dateBegin' AND '$dateEnd'";
		$sql .= " ORDER BY ttr_planner_registry.date ASC";

		$results = $wpdb->get_results( $sql, ARRAY_A );

		if ( $results ) {

			$data = array();

			foreach ( $results as $result ) {
				$result['date'] = date( 'Y-n-j', strtotime( $result['date'] ) );

				/*$result['poscode_name'] = mb_strtolower( $result['poscode_name'] );
				$result['poscode_name'] = ucwords( $result['poscode_name'] );

				$result['regional'] = mb_strtolower( $result['regional'] );
				$result['regional'] = ucwords( $result['regional'] );

				$result['department'] = mb_strtolower( $result['department'] );
				$result['department'] = ucwords( $result['department'] );

				$result['city'] = mb_strtolower( $result['city'] );
				$result['city'] = ucwords( $result['city'] );*/

				switch ( $result['channel'] ) {
					case 'TIENDAS_PROPIAS':
						$result['channel'] = 'CDE';
						break;
					case 'FUERZA_VD':
						$result['channel'] = 'FVD';
						break;
					case 'DEALERS':
						$result['channel'] = 'DEALER';
						break;
					default:
						break;
				}

				array_push( $data, $result );
			}

			return $data;

		} else {
			return false;
		}

	}

	public function get_events_by_regional( $year, $month, $bu, $regional ) {
		global $wpdb;

		$dateBegin = $year . '-' . $month . '-01';
		$dateEnd   = date( 'Y-m-t', strtotime( $dateBegin ) );


		$sql = "SELECT *
		FROM ttr_planner_registry

		INNER JOIN ttr_control_structure

		ON ttr_control_structure.id = ttr_planner_registry.user_id
		AND ttr_planner_registry.date BETWEEN '$dateBegin' AND '$dateEnd'
		";
      
		if ( $bu != "ALL" ) {
			$sql .= " AND ttr_control_structure.business_unit = '$bu'";
		}
      
		if ( $regional != "ALL" ) {
			$sql .= " AND ttr_control_structure.user_regional = '$regional'";
		}

		$sql .= " ORDER BY ttr_control_structure.id, ttr_planner_registry.date ASC";

		$results = $wpdb->get_results( $sql, ARRAY_A );

		if ( $results ) {

			$data = array();

			foreach ( $results as $result ) {
				$result['date'] = date( 'Y-n-j', strtotime( $result['date'] ) );

				/*$result['poscode_name'] = mb_strtolower( $result['poscode_name'] );
				$result['poscode_name'] = ucwords( $result['poscode_name'] );

				$result['regional'] = mb_strtolower( $result['regional'] );
				$result['regional'] = ucwords( $result['regional'] );

				$result['department'] = mb_strtolower( $result['department'] );
				$result['department'] = ucwords( $result['department'] );

				$result['city'] = mb_strtolower( $result['city'] );
				$result['city'] = ucwords( $result['city'] );*/

				switch ( $result['channel'] ) {
					case 'TIENDAS_PROPIAS':
						$result['channel'] = 'CDE';
						break;
					case 'FUERZA_VD':
						$result['channel'] = 'FVD';
						break;
					case 'DEALERS':
						$result['channel'] = 'DEALER';
						break;
					default:
						break;
				}

				array_push( $data, $result );
			}

			return $data;

		} else {
			return false;
		}

	}

	public function save_event( $args ) {

		if ( ! is_user_logged_in() ) {
			return false;
		}

		global $current_user;
		get_currentuserinfo();
		$userID = $current_user->user_login;

		global $wpdb;

		$wpdb->insert( PLANNER_TB_DATA, array(
			'user_id'      => $userID,
			'date'         => $args['date'],
			'poscode'      => $args['poscode'],
			'poscode_name' => strtoupper( $args['poscode_name'] ),
			'channel'      => strtoupper( $args['channel'] ),
			'regional'     => strtoupper( $args['regional'] ),
			'department'   => strtoupper( $args['department'] ),
			'city'         => strtoupper( $args['city'] ),
			'activity'     => sanitize_text_field( implode( ",", $args['activity'] ) ),
			'notes'        => sanitize_text_field( $args['observaciones'] ),
		), array( '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s' ) );

		$registerID = $wpdb->insert_id;

		$sql = "SELECT * FROM " . PLANNER_TB_DATA . " WHERE id = $registerID";

		$result = $wpdb->get_row( $sql, "ARRAY_A" );

		if ( $result ) {

			$result['date'] = date( 'Y-n-j', strtotime( $result['date'] ) );

			/*$result['poscode_name'] = mb_strtolower( $result['poscode_name'] );
			$result['poscode_name'] = ucwords( $result['poscode_name'] );

			$result['regional'] = mb_strtolower( $result['regional'] );
			$result['regional'] = ucwords( $result['regional'] );

			$result['department'] = mb_strtolower( $result['department'] );
			$result['department'] = ucwords( $result['department'] );

			$result['city'] = mb_strtolower( $result['city'] );
			$result['city'] = ucwords( $result['city'] );*/

			switch ( $result['channel'] ) {
				case 'TIENDAS_PROPIAS':
					$result['channel'] = 'CDE';
					break;
				case 'FUERZA_VD':
					$result['channel'] = 'FVD';
					break;
				case 'DEALERS':
					$result['channel'] = 'DEALER';
					break;
				default:
					break;
			}

			return $result;
		}

		return $result;
	}

	public function delete_event( $id ) {
		if ( ! is_user_logged_in() ) {
			return false;
		}

		global $wpdb;

		$wpdb->delete( PLANNER_TB_DATA, array( 'id' => $id ), array( '%d' ) );

		return $id;
	}
}
