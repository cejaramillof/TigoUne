<?php
if (!defined('ABSPATH')) {
    die();
}

function get_bu()
{
    global $wpdb;
    $user_id = get_current_user_id();
    $user_info = get_userdata($user_id);

    if (!$user_info) {
        return 'Sin formularios asociados';
    }
    if ($results = $wpdb->get_row("SELECT * FROM " . $wpdb->prefix . "control_structure WHERE id = '$user_info->user_login'")) {
        return $results;
    } else {
        return 'Sin formularios asociados';
    }
}

?>

<div class="control-section-container">
    <ul class="control-form-list">
        <?php 
        $user_data = get_bu();

        $piloto = array(80796459,1030602773,1012355915,1022334118,1013610324);
        $test = array();

        if (current_user_can('administrator') || in_array($user_data->id, $test)){ ?>
            <li class="control-open-form" data-form="for_vas_trainers">Acompañamiento a Entrenadores</li>
            <!-- <li class="control-open-form" data-form="for_vas_trainers_bb">Acompañamiento a Entrenadores B2B</li>  -->
            <li class="control-open-form" data-form="for_vas_mark_movil">Marcación de Punto</li>
            <!-- <li class="control-open-form" data-form="for_vas_07_nuevo">Acompañamiento Móvil/Hogares</li> -->
            <li class="control-open-form" data-form="for_vas_07_empresas">Acompañamiento B2B</li>
            <li class="control-open-form" data-form="for_vas_33_movil">Inducción Móvil</li>
            <li class="control-open-form" data-form="for_vas_33_movil_piloto">Inducción Móvil - Piloto Bogotá</li>
            <li class="control-open-form" data-form="for_vas_33_hogares">Inducción Hogares</li>
            <li class="control-open-form" data-form="for_vas_33_empresas">Inducción B2B</li>
            <li class="control-open-form" data-form="for_vas_34_movil">Entrenamiento Móvil</li>
            <li class="control-open-form" data-form="for_vas_34_hogares">Entrenamiento Hogares</li>
            <li class="control-open-form" data-form="for_vas_34_empresas">Entrenamiento B2B</li>
        <?php }

        elseif (in_array($user_data->id, $piloto)){ ?>
        	<li class="control-open-form" data-form="for_vas_trainers">Acompañamiento a Entrenadores</li>
            <li class="control-open-form" data-form="for_vas_mark_movil">Marcación de Punto</li>
            <li class="control-open-form" data-form="for_vas_07_nuevo">Acompañamiento Móvil/Hogares</li>
            <li class="control-open-form" data-form="for_vas_07_empresas">Acompañamiento B2B</li>
            <li class="control-open-form" data-form="for_vas_33_movil_piloto">Inducción Móvil - Piloto Bogotá</li>
            <li class="control-open-form" data-form="for_vas_33_hogares">Inducción Hogares</li>
            <li class="control-open-form" data-form="for_vas_33_empresas">Inducción B2B</li>
            <li class="control-open-form" data-form="for_vas_34_movil">Entrenamiento Móvil</li>
            <li class="control-open-form" data-form="for_vas_34_hogares">Entrenamiento Hogares</li>
            <li class="control-open-form" data-form="for_vas_34_empresas">Entrenamiento B2B</li>
        <?php }
        
        elseif (isset($user_data->business_unit)){ 
        
	        switch ($user_data->business_unit) {
	            default:
	             ?>
	                <li class="control-open-form" data-form="for_vas_mark_movil">Marcación de Punto</li>
	                <!-- <li class="control-open-form" data-form="for_vas_trainers">Acompañamiento a Entrenadores</li> -->
	                <!-- <li class="control-open-form" data-form="for_vas_trainers_bb">Acompañamiento a Entrenadores B2B</li> -->
	                <!-- <li class="control-open-form" data-form="for_vas_07_nuevo">Acompañamiento Móvil/Hogares</li> -->
	                <li class="control-open-form" data-form="for_vas_07_empresas">Acompañamiento B2B</li>
	                <li class="control-open-form" data-form="for_vas_33_movil">Inducción Móvil</li>
	                <li class="control-open-form" data-form="for_vas_33_hogares">Inducción Hogares</li>
	                <li class="control-open-form" data-form="for_vas_33_empresas">Inducción B2B</li>
	                <li class="control-open-form" data-form="for_vas_34_movil">Entrenamiento Móvil</li>
	                <li class="control-open-form" data-form="for_vas_34_hogares">Entrenamiento Hogares</li>
	                <li class="control-open-form" data-form="for_vas_34_empresas">Entrenamiento B2B</li>
	                <?php break;
	            case 'TECNICOS':
	            case 'EDATEL': ?>
	            	<li class="control-open-form" data-form="for_vas_trainers_tecnicos">Acompañamiento a Entrenadores</li>
	                <li class="control-open-form" data-form="for_vas_07_tecnicos">Acompañamiento</li>
                    <li class="control-open-form" data-form="for_vas_07_tecnicos_supervisores">Acompañamiento Supervisores</li>
	                <li class="control-open-form" data-form="for_vas_33_tecnicos">Inducción</li>
	                <li class="control-open-form" data-form="for_vas_34_tecnicos">Entrenamiento</li>
	                <?php break;
	        } 

        }
        ?>
    </ul>
</div>
<div class="control-section-container main-reg-list">
    <h2>Últimos registros</h2>

    <div id="main-reg-list-container">
        <span>No hay registros</span>
    </div>
</div>