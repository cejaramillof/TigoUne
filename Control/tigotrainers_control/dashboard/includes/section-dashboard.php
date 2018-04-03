<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

$allowed_roles = [ 'MANAGER', 'TRAINER_LEADER', 'UBERMANAGER', 'SUPERVISOR' ];

global $wpdb;

$currentUser = wp_get_current_user();
$role = '';

if ( ! current_user_can( 'manage_options' ) ) {

	$result = $wpdb->get_row( "SELECT * FROM ttr_control_structure WHERE id = '$currentUser->user_login'" );
	$role = $result->user_role;

	if ( ! $result || ! in_array( $result->user_role, $allowed_roles ) ) {
		echo 'No tienes permiso para acceder a esta sección';
		die();
	}
}

if( $role == 'SUPERVISOR' ):
	$menu = array("descargas" => "?page=downloads" );
else:
	$menu = array(
		"reportes"  => "?page=reports",
		"novedades" => "?page=news",
		"descargas" => "?page=downloads",
		"planner"   => home_url( '/planner/planner-dashboard' )
	);
endif;

if ( ! isset( $_GET['page'] ) && $role != 'SUPERVISOR' )
	$_GET['page'] = 'downloads';
if ( ! isset( $_GET['page'] ) && $role == 'SUPERVISOR' )
	$_GET['page'] = 'downloads';


function dash_is_active_page( $h ) {
	$class       = 'lala';
	$actual_link = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

	if ( strpos( $actual_link, $h ) !== false ) {
		$class = 'current';
	}

	return $class;
}

?>
<div style="display:none"><?php echo $role; ?></div>

<div class="ctrl-dashboard-container">
	<div class="ctrl-dashboard-header">
		<ul>
			<?php
			foreach ( $menu as $link => $href ) {
				$class = dash_is_active_page( $href );
				echo '<li><a href="' . $href . '" class="' . $class . '">' . $link . '</a></li>';
			}
			?>
		</ul>
	</div>
	<div class="ctrl-dashboard-inner-container">
		<?php
		switch ( $_GET['page'] ) {
			case 'reports':
				if ( isset( $_GET['trainerView'] ) && $_GET['trainerID'] ) {
					include_once 'subsection-trainer-reports.php';
				} else {
					include_once 'subsection-global-reports.php';
				}
				break;
			case 'news':
				include_once 'subsection-news.php';
				break;
			case 'downloads':
				include_once 'subsection-downloads.php';
				break;
			default:
				break;
		}
		?>
	</div>
</div>

