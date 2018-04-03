<?php
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );

if ( ! is_user_logged_in() ) {
	die( 'Not logged in' );
}

if ( ! isset( $_GET['year'], $_GET['month'], $_GET['user_id'] ) ) {
	die( 'Wrong parameters passed' );
}

$allowed_roles = [ 'MANAGER', 'TRAINER_LEADER', 'UBERMANAGER', 'TRAINER' ];
$year          = sanitize_text_field( $_GET['year'] );
$month         = sanitize_text_field( $_GET['month'] );
$userID        = sanitize_text_field( $_GET['user_id'] );

global $wpdb;

$currentUser = wp_get_current_user();

if ( ! current_user_can( 'manage_options' ) ) {
	$thisUser = $wpdb->get_row( "SELECT * FROM ttr_control_structure WHERE id = '$currentUser->user_login'" );

	if ( ! $thisUser || ! in_array( $thisUser->user_role, $allowed_roles ) ) {
		echo 'No tienes permiso para descargar';
		die();
	}
}

if ( $year == 0 || $month == 0 ) {
	$year  = date( 'Y' );
	$month = date( 'n' );
}

$months = array(
	'enero',
	'febrero',
	'marzo',
	'abril',
	'mayo',
	'junio',
	'julio',
	'agosto',
	'septiembre',
	'octubre',
	'noviembre',
	'diciembre'
);

$regional = '';

if ( ! isset( $_GET['regional'] ) || ! isset( $_GET['bu'] ) ) {
	die( 'Wrong parameters passed' );
}

$regional = $_GET['regional'];
$bu       = $_GET['bu'];

$planner = new Planner();

$resultEvents = $planner->get_events_by_regional( $year, $month, $bu, $regional );

require_once( 'phpexcel/Classes/PHPExcel.php' );

$objPHPExcel = new PHPExcel();

$objDrawing  = new PHPExcel_Worksheet_Drawing();
$plannerLogo = "../assets/planner_logo.png";
$objDrawing->setPath( $plannerLogo );
$objDrawing->setCoordinates( 'B1' );
$objDrawing->setHeight( 75 ); // logo height
$objDrawing->setWorksheet( $objPHPExcel->getActiveSheet() );

$styleTitle = array(
	'font'      => array(
		'bold'  => false,
		'color' => array( 'rgb' => 'FFFFFF' ),
		'size'  => 12,
		'name'  => 'Calibri'
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
	),
	'fill'      => array(
		'type'  => PHPExcel_Style_Fill::FILL_SOLID,
		'color' => array( 'rgb' => '002E6E' )
	)
);

$styleSubtitle = array(
	'font'      => array(
		'bold' => true,
		'size' => 14,
		'name' => 'Calibri'
	),
	'alignment' => array(
		'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
	),
);

$styleDescription = array(
	'font' => array(
		'bold' => true,
		'name' => 'Calibri'
	)
);

$styleDetails = array(
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
	)
);

$objPHPExcel->getActiveSheet()->getStyle( 'A1:M7' )->getFill()->setFillType( PHPExcel_Style_Fill::FILL_SOLID )->getStartColor()->setARGB( 'FFFFFF' );


$objPHPExcel->getActiveSheet()->getStyle( 'B3' )->applyFromArray( $styleSubtitle );
$objPHPExcel->getActiveSheet()->getStyle( 'B8:M8' )->applyFromArray( $styleTitle );
$objPHPExcel->getActiveSheet()->getStyle( 'B4:B6' )->applyFromArray( $styleDescription );
$objPHPExcel->getActiveSheet()->getStyle( 'B3:E6' )->applyFromArray( $styleDetails );

$objPHPExcel->getActiveSheet()->getRowDimension( 1 )->setRowHeight( 50 );
$objPHPExcel->getActiveSheet()->getRowDimension( 3 )->setRowHeight( 20 );
$objPHPExcel->getActiveSheet()->getRowDimension( 8 )->setRowHeight( 20 );

$objPHPExcel->getActiveSheet()->getColumnDimension( 'A' )->setWidth( 5 );
$objPHPExcel->getActiveSheet()->getColumnDimension( 'B' )->setWidth( 12 );
$objPHPExcel->getActiveSheet()->getColumnDimension( 'C' )->setWidth( 11 );
$objPHPExcel->getActiveSheet()->getColumnDimension( 'D' )->setWidth( 20 );
$objPHPExcel->getActiveSheet()->getColumnDimension( 'E' )->setWidth( 10 );
$objPHPExcel->getActiveSheet()->getColumnDimension( 'F' )->setWidth( 20 );
$objPHPExcel->getActiveSheet()->getColumnDimension( 'G' )->setWidth( 30 );
$objPHPExcel->getActiveSheet()->getColumnDimension( 'H' )->setWidth( 30 );
$objPHPExcel->getActiveSheet()->getColumnDimension( 'I' )->setWidth( 10 );
$objPHPExcel->getActiveSheet()->getColumnDimension( 'J' )->setWidth( 10 );
$objPHPExcel->getActiveSheet()->getColumnDimension( 'K' )->setWidth( 10 );
$objPHPExcel->getActiveSheet()->getColumnDimension( 'L' )->setWidth( 10 );
$objPHPExcel->getActiveSheet()->getColumnDimension( 'M' )->setWidth( 10 );

$title = "Planeación de Entrenamiento - " . ucfirst( $months[ $month - 1 ] ) . " " . $year . " - " . $userID;

$objPHPExcel->getProperties()->setCreator( "Juan Felipe Tobon" )
            ->setLastModifiedBy( "Juan Felipe Tobon" )
            ->setTitle( $title )
            ->setSubject( "" )
            ->setDescription( "" )
            ->setKeywords( "" )
            ->setCategory( "" );


$objPHPExcel->setActiveSheetIndex( 0 )
            ->setCellValue( 'B3', 'Planeación de Entrenamiento - ' . ucfirst( $months[ $month - 1 ] ) . ' de ' . $year )
            ->setCellValue( 'B4', 'Regional:' )
            ->setCellValue( 'D4', $regional )
            ->setCellValue( 'B5', 'Unidad de Negocio:' )
            ->setCellValue( 'D5', $bu )
            ->setCellValue( 'B8', 'Fecha' )
            ->setCellValue( 'C8', 'Cédula' )
            ->setCellValue( 'D8', 'Nombre de usuario' )
            ->setCellValue( 'E8', 'Código' )
            ->setCellValue( 'F8', 'Nombre del punto' )
            ->setCellValue( 'G8', 'Actividad' )
            ->setCellValue( 'H8', 'Observaciones' )
            ->setCellValue( 'I8', 'Regional' )
            ->setCellValue( 'J8', 'Canal' )
            ->setCellValue( 'K8', 'Departamento' )
            ->setCellValue( 'L8', 'Ciudad' )
            ->setCellValue( 'M8', 'Unidad' );

if ( $resultEvents == false ) {

	$objPHPExcel->setActiveSheetIndex( 0 )
	            ->setCellValue( 'B9', 'No hay actividades programadas' );

} else {

	$i = 9;

	foreach ( $resultEvents as $event ) {
		$objPHPExcel->setActiveSheetIndex( 0 )
		            ->setCellValue( 'B' . $i, PHPExcel_Shared_Date::PHPToExcel( strtotime( $event['date'] ) ) )
		            ->setCellValue( 'C' . $i, $event['user_id'] )
		            ->setCellValue( 'D' . $i, $event['user_name'] )
		            ->setCellValue( 'E' . $i, $event['poscode'] )
		            ->setCellValue( 'F' . $i, $event['poscode_name'] )
		            ->setCellValue( 'G' . $i, $event['activity'] )
		            ->setCellValue( 'H' . $i, $event['notes'] )
		            ->setCellValue( 'I' . $i, $event['regional'] )
		            ->setCellValue( 'J' . $i, $event['channel'] )
		            ->setCellValue( 'K' . $i, $event['department'] )
		            ->setCellValue( 'L' . $i, $event['city'] )
                    ->setCellValue( 'M' . $i, $event['business_unit'] );


		$objPHPExcel->getActiveSheet()->getStyle( 'B' . $i )->getNumberFormat()->setFormatCode( 'dd/mm/yyyy' );
		$objPHPExcel->getActiveSheet()->getStyle( 'A' . $i . ':M' . $i )->getFill()->setFillType( PHPExcel_Style_Fill::FILL_SOLID )->getStartColor()->setARGB( 'FFFFFF' );
		$objPHPExcel->getActiveSheet()->getStyle( 'B' . $i . ':M' . $i )->applyFromArray( array(
			'borders' => array(
				'bottom' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array( 'rgb' => 'DDDDDD' )
				)
			)
		) );
		$i ++;
	}
}


header( 'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' );
header( 'Content-Disposition: attachment;filename="' . $title . '.xlsx"' );
header( 'Cache-Control: max-age=0' );
// If you're serving to IE 9, then the following may be needed
header( 'Cache-Control: max-age=1' );

// If you're serving to IE over SSL, then the following may be needed
header( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' ); // Date in the past
header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' ); // always modified
header( 'Cache-Control: cache, must-revalidate' ); // HTTP/1.1
header( 'Pragma: public' ); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter( $objPHPExcel, 'Excel2007' );
$objWriter->save( 'php://output' );
exit;