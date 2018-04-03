<?php

if (!defined('ABSPATH')) {
    die();
}

function has_conditional_flow($item, $option) {
    $data = '';
    if ($item->flow == '_conditional') {
        $data = 'data-flow="' . esc_attr($option->flow) . '"';
    }
    return $data;
}

function get_description($item){
	$description = '';
	if ($item->description && $item->description != ''){
		$description = '<a  href="#" class="item-description-info">?<span class="item-description-content" style="display: none;"><div class="item-description-content-inner">'.$item->description.'</div></span></a>';
	}
	return $description;
}

function item_is_required($item) {
    $data = '';
    if ($item->properties->required == true) {
        $data = 'data-required';
    }
    return $data;
}

function item_is_multidata($item){
    if (isset($item->properties->multidata)){
        return 'data-multidata';
    } else {
        return '';
    }
}

function item_add_container($item, $html) {
    $open = '<div class="control-form-item" data-id="' . esc_attr($item->id) . '" ' . esc_attr(item_is_required($item)) . '>';
    $close = '</div>';
    return $open . $html . $close;
}

function gen_text_input($item) {
    $html = '<span class="item-title">' . esc_html($item->title) . get_description($item).'</span><label><input type="text" name="' . esc_attr($item->id) . '" data-flow="' . esc_attr($item->flow) . '" '.item_is_multidata($item).'></label>';
    return item_add_container($item, $html);
}

function gen_hidden($item) {
	$html = '<input type="text" name="' . esc_attr($item->id) . '" data-flow="' . esc_attr($item->flow) . '" value="'.$item->properties->default_value.'" hidden>';
	return $html;
}

function gen_number_input($item) {
    $html = '<span class="item-title">' . esc_html($item->title) .  get_description($item).'</span><label><input type="number" name="' . esc_attr($item->id) . '" data-flow="' . esc_attr($item->flow) . '" '.item_is_multidata($item).'></label>';
    return item_add_container($item, $html);
}

function gen_date_input($item) {

    $date = new DateTime('now', new DateTimeZone('UTC'));
    $date->setTimezone(new DateTimeZone('America/Bogota'));
    $today = $date->format('d/m/Y');

    $html = '<label><span class="item-title">' . esc_html($item->title) .  get_description($item).'</span><input class="control-form-datepicker" type="text" name="' . esc_attr($item->id) . '" data-flow="' . esc_attr($item->flow) . '" value="'.$today.'" readonly></label>';
    return item_add_container($item, $html);
}

function gen_unique_option($item) {
    $html = '<span class="item-title">' . esc_html($item->title) .  get_description($item).'</span>';
    $i = 1;

    $status_title_b2b = true;
    $status_title_hogares = true;
    foreach ($item->options as $option)
    {
        $title_b2b = explode( '[B2B]',  htmlentities($option->option_key) );
        if( isset( $title_b2b[1] ) && $status_title_b2b ):
            $html .= '<h4 style="margin:10px 0;padding:0;">Entrenamiento B2B</h4>';
            $status_title_b2b = false;
        endif;
        
        $title_hogares = explode( '[HOGARES]',  htmlentities($option->option_key) );
        if( isset( $title_hogares[1] ) && $status_title_hogares ):
            $html .= '<h4 style="margin:10px 0;padding:0;">Entrenamiento Hogares</h4>';
            $status_title_hogares = false;
        endif;
        
        $html .= '<label class="item-radio"><input type="radio" name="' . esc_attr($item->id) . '" value="' . esc_attr($option->option_value) . '" ' . has_conditional_flow($item, $option) . '><span>' . esc_html($option->option_key) . '</span></label>';
        $i++;
    }

    if (isset($item->properties->free_option)) {
        $html .= '<label><span>Otro: </span><input type="text" name="' . esc_attr($item->id) . '" data-flow="' . esc_attr($item->flow) . '" data-optional></label></div>';
    }

    return item_add_container($item, $html);
}

function gen_multiple_option($item) {
    $html = '<span class="item-title">' . esc_html($item->title) .  get_description($item).'</span>';
    $status_title_otros = true;
    $status_title_servicios = true;
    $status_title_otros_servicios = true;
    $status_title_convergencia_retail = true;
    $status_title_comercial = true;
    
    $i = 1;

    foreach ($item->options as $option) {
        
        ///////////////////// CAMBIO 02-05-2017 ADICION TITULOS - EDISON
        $titulo_otros = explode( '[OTROS]',  htmlentities($option->option_key) );
        if( isset( $titulo_otros[1] ) && $status_title_otros ):
            $html .= '<h4 style="margin:10px 0;padding:0;">OTROS</h4>';
            $status_title_otros = false;
        endif;
        
        $titulo_servicios = explode( '[SERVICIOS]',  htmlentities($option->option_key) );
        if( isset( $titulo_servicios[1] ) && $status_title_servicios ):
            $html .= '<h4 style="margin:10px 0;padding:0;">MATRIZ SERVICIOS</h4>';
            $status_title_servicios = false;
        endif;
        
        $titulo_otros_servicios = explode( '[OTROS SERVICIOS]',  htmlentities($option->option_key) );
        if( isset( $titulo_otros_servicios[1] ) && $status_title_otros_servicios ):
            $html .= '<h4 style="margin:10px 0;padding:0;">OTROS SERVICIOS</h4>';
            $status_title_otros_servicios = false;
        endif;
        
        $titulo_convergencia_retail = explode( '[CONVERGENCIA RETAIL]',  htmlentities($option->option_key) );
        if( isset( $titulo_convergencia_retail[1] ) && $status_title_convergencia_retail ):
            $html .= '<h4 style="margin:10px 0;padding:0;">CONVERGENCIA RETAIL</h4>';
            $status_title_convergencia_retail = false;
        endif;
        
        if( !isset( $titulo_otros[1] ) && !isset( $titulo_servicios[1] ) && !isset( $titulo_otros_servicios[1] ) && !isset( $titulo_convergencia_retail[1] ) && $status_title_comercial ):
            $html .= '<h4 style="margin:10px 0;padding:0;">MATRIZ COMERCIAL</h4>';
            $status_title_comercial = false;
        endif;
        
        ///////////////////// FIN, CAMBIO 05-05-2017 ADICION TITULOS - EDISON
        
        $pregunta = explode( '[CONVERGENCIA RETAIL]',  esc_html($option->option_key) );
        if( isset($pregunta[1]) )
            $html .= '<label class="item-checkbox"><input type="checkbox" name="' . esc_attr($item->id) . '" value="' . esc_attr($option->option_value) . '"><span>' . $pregunta[1] . '</span></label>';
        else
            $html .= '<label class="item-checkbox"><input type="checkbox" name="' . esc_attr($item->id) . '" value="' . esc_attr($option->option_value) . '"><span>' . esc_html($option->option_key) . '</span></label>';
        $i++;
    }

    if (isset($item->properties->free_option)) {
        $html .= '<label><span>Otro: </span><input type="text" name="' . esc_attr($item->id) . '" data-flow="' . esc_attr($item->flow) . '" data-optional></label></div>';
    }

    return item_add_container($item, $html);
}

function gen_boolean_option($item) {
    $html = '<span class="item-title">' . esc_html($item->title) . get_description($item).'</span>';
    $html .= '<div class="item-boolean">';
    $html .= '<label><input type="radio" name="' . esc_attr($item->id) . '" value="' . esc_attr($item->options->true) . '"><span>Yes</span></label>';
    $html .= '<label><input type="radio" name="' . esc_attr($item->id) . '" value="' . esc_attr($item->options->false) . '"><span>No</span></label>';
    $html .= '</div>';
    return item_add_container($item, $html);
}

function gen_textarea($item) {
    $html = '<label for="' . esc_attr($item->slug) . '" class="item-title">' . esc_html($item->title) . '</label>';
    $html .= '<textarea name="' . esc_attr($item->id) . '" id="' . esc_attr($item->slug) . '" rows="4" data-flow="' . esc_attr($item->flow) . '"></textarea>';

    return item_add_container($item, $html);
}

function gen_range($item) {

    $html = '<label for="' . esc_attr($item->slug) . '" class="item-title">' . esc_html($item->title) . get_description($item). '</label>';
    $html .= '<input type="range" min="' . esc_attr($item->options->min_value) . '" max="' . esc_attr($item->options->max_value) . '" step="' . esc_attr($item->options->steps) . '" name="' . esc_attr($item->id) . '" id="' . esc_attr($item->slug) . '" value="1" data-flow="' . esc_attr($item->flow) . '">';

    return item_add_container($item, $html);
}

function gen_title($item){
	$html = '<h3>'.$item->title. get_description($item).'</h3>';
	return item_add_container($item, $html);
}