<?php

/*
Plugin Name: Tigotrainers Control
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: A brief description of the Plugin.
Version: 1.0
Author: Juan Felipe Tobon Gutierrez
Author URI: http://URI_Of_The_Plugin_Author
License: GPLv2
*/

if (!defined('ABSPATH')) {
    die();
}

if (!class_exists('tigotrainersControl')) {

    final class tigotrainersControl
    {

        private static $instance;

        public static function get_instance()
        {

            if (!isset(self::$instance) && !(self::$instance instanceof tigotrainersControl)) {
                self::$instance = new self;
                self::$instance->hooks();
            }

            return self::$instance;
        }

        private function __construct()
        {
            self::$instance = $this;
        }

        function hooks()
        {

            add_shortcode('ttr-control-interface', function () {
                ob_start();
                $this->main_interface();
                $outputString = ob_get_contents();
                ob_end_clean();

                return $outputString;
            });

            add_shortcode('ttr-control-reports-interface', function () {
                ob_start();
                $this->dashboard_interface();
                $outputString = ob_get_contents();
                ob_end_clean();

                return $outputString;
            });

            add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'), 15);

            if (defined('DOING_AJAX') && DOING_AJAX) {
                add_action('wp_ajax_control_ajax_handler', array(
                    $this,
                    'control_ajax_handler'
                ));
                add_action('wp_ajax_nopriv_control_ajax_handler', array(
                    $this,
                    'control_ajax_handler'
                ));
            }
        }

        public static function install()
        {

            global $wpdb;

            $tableThemes = $wpdb->prefix . "control_training_themes";
            $tableForms = $wpdb->prefix . "control_forms";
            $tableFormsMeta = $wpdb->prefix . "control_forms_meta";
            $tableUsers = $wpdb->prefix . "control_structure";
            $charsetCollate = $wpdb->get_charset_collate();
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

            $sql = "CREATE TABLE IF NOT EXISTS $tableThemes(
            id INT AUTO_INCREMENT NOT NULL,
            title varchar(140) DEFAULT '' NOT NULL,
            variations TEXT DEFAULT '' NOT NULL,
            channels TEXT DEFAULT '' NOT NULL,
            date_begin DATE,
            date_end DATE,
            PRIMARY KEY id (id)
            )$charsetCollate;";
            dbDelta($sql);

            $sql = "CREATE TABLE IF NOT EXISTS $tableForms(
            id INT AUTO_INCREMENT NOT NULL,
            user_id varchar(140) DEFAULT '' NOT NULL,
            timestamp TIMESTAMP,
            form varchar(140) DEFAULT '' NOT NULL,
            PRIMARY KEY id (id)
            )$charsetCollate;";
            dbDelta($sql);

            $sql = "CREATE TABLE IF NOT EXISTS $tableFormsMeta(
            id INT AUTO_INCREMENT NOT NULL,
            form_id INT NOT NULL,
            meta varchar(140) DEFAULT '' NOT NULL,
            value TEXT DEFAULT '' NOT NULL,
            PRIMARY KEY id (id)
            )$charsetCollate;";
            dbDelta($sql);

            $sql = "CREATE TABLE IF NOT EXISTS $tableUsers(
            id INT NOT NULL,
            user_name varchar(140) DEFAULT '' NOT NULL,
            user_role varchar(140) DEFAULT '' NOT NULL,
            user_regional varchar(64) DEFAULT '' NOT NULL,
            user_channel varchar(64) DEFAULT '' NOT NULL,
            PRIMARY KEY id (id)
            )$charsetCollate;";
            dbDelta($sql);
        }

        function enqueue_scripts()
        {

            global $post;

            if (is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'ttr-control-interface')) {
                wp_enqueue_script('modernizr', plugins_url('js/vendor/modernizr.js', __FILE__));
                wp_enqueue_script('prefixfree', plugins_url('js/vendor/prefixfree.min.js', __FILE__));
                wp_enqueue_script('jquery-ui-datepicker', 'jquery', true);
                wp_enqueue_script('hammer', plugins_url('js/vendor/jquery.hammer.min.js', __FILE__), array('jquery'), '1.0', true);
                wp_enqueue_script('ttr-control-slidepane', plugins_url('js/slidepane.js', __FILE__), array('jquery', 'hammer'), '1.0', true);
                wp_enqueue_script('ttr-control-sidepane', plugins_url('js/sidepane.js', __FILE__), array('jquery', 'hammer'), '1.0', true);
                // wp_enqueue_script('ttr-control-charts', plugins_url('js/vendor/highcharts.js', __FILE__), array('jquery', 'hammer'), '1.0', true);
                // wp_enqueue_script('ttr-control-charts-more', plugins_url('js/vendor/highcharts-more.js', __FILE__), array('ttr-control-charts'), '1.0', true);
                wp_enqueue_script('ttr-control-main', plugins_url('js/control-main.js', __FILE__), array('jquery', 'hammer'), '1.0', true);


                wp_enqueue_style('ttr-normalize-css', plugins_url('css/normalize.css', __FILE__));
                wp_enqueue_style('ttr-control-main-style', plugins_url('css/style.css', __FILE__));
                wp_enqueue_style('ttr-control-icons', plugins_url('assets/tigotrainers_icons/styles.css', __FILE__));

                wp_localize_script('ttr-control-sidepane', 'ajax_control', array(
                    'ajaxurl' => admin_url('admin-ajax.php'),
                    'action' => 'control_ajax_handler',
                    'nonce' => wp_create_nonce('control_ajax_handler')
                ));
            }

            if (is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'ttr-control-reports-interface')) {
                wp_enqueue_script('modernizr', plugins_url('js/vendor/modernizr.js', __FILE__));
                wp_enqueue_script('prefixfree', plugins_url('js/vendor/prefixfree.min.js', __FILE__));
                wp_enqueue_script('jquery-ui-datepicker', 'jquery', true);

                //wp_enqueue_script('ttr-control-charts', plugins_url('js/vendor/highcharts.js', __FILE__), array('jquery'), '1.0', true);
                //wp_enqueue_script('ttr-control-charts-more', plugins_url('js/vendor/highcharts-more.js', __FILE__), array('ttr-control-charts'), '1.0', true);
                wp_enqueue_script('ctrl-dashboard-main', plugins_url('dashboard/js/dashboard_main.js', __FILE__), array('jquery'), '1.0', true);

                wp_enqueue_style('ttr-normalize-css', plugins_url('css/normalize.css', __FILE__));
                wp_enqueue_style('ttr-dashboard-css', plugins_url('dashboard/css/dashboard_style.css', __FILE__));
                wp_enqueue_style('ttr-control-icons', plugins_url('assets/tigotrainers_icons/styles.css', __FILE__));
            }
        }

        function control_ajax_handler()
        {

            if (isset($_POST['directive'])) {

                switch ($_POST['directive']) {
                    case 'get_forms':
                        if (isset($_POST['form'])) {
                            $this->load_form($_POST['form']);
                        }
                        break;
                    case 'get_form_items':
                        if (isset($_POST['form'], $_POST['initItem'])) {
                            $this->load_form_items($_POST['form'], $_POST['initItem']);
                        }
                        break;
                    case 'submit_form_items':
                        if (isset($_POST['form'])) {
                            $this->submit_form($_POST['form']);
                        }
                        break;
                    case 'get_last_reg':
                        $this->get_last_registry();
                        break;
                    default:
                        break;
                }
            }
        }

        private function load_form($formName)
        {
            $jsonFormData = json_decode(file_get_contents(plugins_url('forms/' . $formName . '.json', __FILE__)));

            echo $this->form_builder($jsonFormData, $formName);
            die;
        }

        private function load_form_items($formName, $initItem)
        {
            $jsonFormData = json_decode(file_get_contents(plugins_url('forms/' . $formName . '.json', __FILE__)));
            echo $this->form_items_builder($jsonFormData->items, $initItem, $formName);
            die;
        }

        private function form_builder($jsonForm, $formName)
        {
            $formHtml = '<form id="' . $formName . '" class="control-form" ' . $this->form_properties($jsonForm->properties) . '>';
            $formHtml .= '<input type="hidden" name="form_name" value="' . $formName . '">';
            $formHtml .= $this->form_items_builder($jsonForm->items, 'init', $formName);
            $formHtml .= '</form>';

            return $formHtml;
        }

        private function form_properties($prop)
        {
            $propString = '';
            foreach ($prop as $key => $value) {
                $propString .= 'data-' . $key . '="' . $value . '" ';
            }

            return $propString;
        }

        private function get_bu($formName)
        {
           /* global $wpdb;
            $user_id = get_current_user_id();
            $user_info = get_userdata($user_id);
            if ($results = $wpdb->get_row("SELECT * FROM " . $wpdb->prefix . "control_structure WHERE id = '$user_info->user_login'")) {
                return $results->business_unit;
            } else {
                return false;
            }*/
           $bu = false;

           switch($formName){
               case 'for_vas_34_movil':
                   $bu=  'MOVIL';
                   break;
               case 'for_vas_34_empresas':
                   $bu=  'EMPRESAS';
                   break;
               case 'for_vas_34_hogares':
                   $bu=  'HOGARES';
                   break;
               case 'for_vas_34_tecnicos':
                   $bu=  'TECNICOS';
                   break;
               case 'for_vas_34_union':
                   $bu=  'UNION';
                   break;               
               default:
                   break;
           }

           return $bu;
        }

        private function form_items_builder($form, $init, $formName)
        {

            include_once('inc/form_html_builder.php');

            if ($init == '_submit') {
                $itemsHtml = '<div class="control-form-block">';
                $itemsHtml .= '<div class="control-form-item "><input type="submit" id="submit" value="Enviar">';
                $itemsHtml .= '<div id="control-form-submit" data-icon="&#xe000;">Enviar</div></div>';
                $itemsHtml .= '</div>';

                return $itemsHtml;
            }

            if ($init == 'init') {
                $itemInit = $form[0];
            } else {
                $itemInit = $this->get_form_item_by_id($init, $form);
            }

            $formItems = array();

            $this->form_flow($itemInit, $form, $formItems);
            $itemsHtml = '<div class="control-form-block">';
            
            if (count($formItems) > 0) {
                
                foreach ($formItems as $item) {

                    if (isset($item->options) && isset($item->properties->db_table_name) && $item->options == "_db_table_data") {

                        global $wpdb;

                        $item->options = array();
                        date_default_timezone_set('America/Bogota');
                        $month = date('m');
                        $year = date('Y');

                        $bu = $this->get_bu($formName);

                        
                        if ($bu){
                            $tableName = $wpdb->prefix . $item->properties->db_table_name;
                            $sql = "SELECT * FROM $tableName 
                                    WHERE MONTH($tableName.date_begin) = '$month'
                                    AND YEAR($tableName.date_begin) = '$year'
                                    AND $tableName.business_unit = '$bu'
                                    ORDER BY $tableName.orden";

                            $result = $wpdb->get_results($sql, ARRAY_A);

                            foreach ($result as $row) {

                                $args = (object)array(
                                    "option_key" => $row['title'],
                                    "option_value" => $row['id']
                                );

                                array_push($item->options, $args);
                            }
                        }
                    }
                    
                    switch ($item->type) {
                        case 'text':
                            $itemsHtml .= gen_text_input($item);
                            break;
                        case 'number':
                            $itemsHtml .= gen_number_input($item);
                            break;
                        case 'date':
                            $itemsHtml .= gen_date_input($item);
                            break;
                        case 'unique_option':
                            $itemsHtml .= gen_unique_option($item);
                            break;
                        case 'multiple_option':
                            $itemsHtml .= gen_multiple_option($item);
                            break;
                        case 'boolean_option':
                            $itemsHtml .= gen_boolean_option($item);
                            break;
                        case 'range_option':
                            $itemsHtml .= gen_range($item);
                            break;
                        case 'textarea':
                            $itemsHtml .= gen_textarea($item);
                            break;
                        case 'hidden':
                            $itemsHtml .= gen_hidden($item);
                            break;
                        case 'title_group':
                            $itemsHtml .= gen_title($item);
                            break;
                        default:
                            break;
                    }
                    if ($item->flow == '_submit') {
                        $itemsHtml .= '<div class="control-form-item "><input type="submit" id="submit" value="Enviar">';
                        $itemsHtml .= '<div id="control-form-submit" data-icon="&#xe000;">Enviar</div></div>';
                    }
                }
            }

            $itemsHtml .= '</div>';

            return $itemsHtml;
        }

        private function form_flow($item, $form, &$formItems)
        {

            $flowStatus = ['_conditional', '_submit'];

            if ($item->flow) {
                if (!in_array($item->flow, $flowStatus)) {
                    $nextItem = $this->get_form_item_by_id($item->flow, $form);
                    $this->form_flow($nextItem, $form, $formItems);
                }
                array_unshift($formItems, $item);

                return $formItems;
            }

            return false;
        }

        private function get_form_item_by_id($id, $form)
        {

            foreach ($form as $formItem) {
                if ($formItem->id == $id) {
                    return $formItem;
                }
            }

            return false;
        }

        private function get_form_item_by_slug($slug, $form)
        {

            foreach ($form as $formItem) {
                if ($formItem->slug == $slug) {
                    return $formItem;
                }
            }

            return false;
        }

        private function isAssoc($arr)
        {
            if (is_array($arr)) {
                foreach (array_keys($arr) as $key) {
                    if (!is_int($key)) {
                        return true;
                    }
                }
            }

            return false;
        }

        private function submit_form($formData)
        {
            global $wpdb;

            if (!is_user_logged_in()) {
                echo json_encode('reg_error');
                die();
            }


            $tableForms = $wpdb->prefix . "control_forms";
            $tableFormsMeta = $wpdb->prefix . "control_forms_meta";

            $formName = $formData['form_name'];
            $jsonData = json_decode(file_get_contents(plugins_url('forms/' . $formName . '.json', __FILE__)));

            if (!$this->validate_form($formData, $jsonData->items)) {
                die;
            }

            date_default_timezone_set('America/Bogota');
            $current_user = wp_get_current_user();

            $wpdb->insert($tableForms, array(
                'form' => $formName,
                'user_id' => $current_user->user_login,
            ), array('%s', '%s'));

            $formID = $wpdb->insert_id;

            foreach ($formData as $key => $value) {
                if ($key == 'form_name') {
                    continue;
                }

                $formItem = $this->get_form_item_by_id($key, $jsonData->items);

                if (!$formItem) {
                    $slug = $key;
                } else {
                    $slug = $formItem->slug;
                }

                if ($this->isAssoc($value)) {
                    foreach ($value as $h => $i) {
                        $wpdb->insert($tableFormsMeta, array(
                            'form_id' => $formID,
                            'meta' => $h,
                            'value' => $i
                        ), array('%d', '%s', '%s'));
                    }
                } else if (is_array($value)) {
                    foreach ($value as $i) {
                        $wpdb->insert($tableFormsMeta, array(
                            'form_id' => $formID,
                            'meta' => $slug,
                            'value' => $i
                        ), array('%d', '%s', '%s'));
                    }
                } else {
                    $wpdb->insert($tableFormsMeta, array(
                        'form_id' => $formID,
                        'meta' => $slug,
                        'value' => $value
                    ), array('%d', '%s', '%s'));
                }
            }

            if ($formID!=false){
                echo json_encode(array("status"=>"ok"));
            } else {
                echo json_encode($formData);
            }
            
            die;
        }

        private function validate_form(&$formData, $form)
        {
            $formErrors = [];

            foreach ($formData as $key => $value) {
                $key = sanitize_key($key);
                $formItem = $this->get_form_item_by_id($key, $form);
                if ($formItem) {

                    /** @noinspection PhpUndefinedFieldInspection */
                    $validate = $formItem->properties->validate;

                    switch ($validate) {

                        case 'text':
                            if (is_array($value)) {
                                $arr = [];
                                foreach ($value as $i) {
                                    $arr[] = sanitize_text_field($i);
                                }
                                $value = $arr;
                            } else {
                                $value = sanitize_text_field($value);
                            }
                            $formData[$key] = $value;
                            break;

                        case 'number':
                            if (is_array($value)) {
                                $arr = [];
                                foreach ($value as $i) {
                                    $arr[] = floatval($i);
                                }
                                $value = $arr;
                            } else {
                                $value = floatval($value);
                            }
                            $formData[$key] = $value;
                            break;

                        case 'date':
                            if (is_array($value)) {
                                $arr = [];
                                foreach ($value as $i) {
                                    $arr[] = sanitize_text_field(preg_replace("([^0-9/])", "", $i));
                                }
                                $formData[$key] = $value;

                            } else {
                                $value = sanitize_text_field(preg_replace("([^0-9/])", "", $value));
                                $date = explode("/", $value);

                                if (checkdate(intval($date[1]), intval($date[0]), intval($date[2]))) {
                                    $formData[$key] = $value;
                                } else {
                                    $formErrors[] = array('id' => $key, 'error_code' => '002');
                                }
                            }
                            break;

                        case 'cc_id':
                            if (is_array($value)) {
                                $arr = [];
                                foreach ($value as $i) {
                                    $arr[] = sanitize_text_field(preg_replace("([^0-9])", "", $i));
                                }
                                $formData[$key] = $value;
                            } else {
                                $value = sanitize_text_field(preg_replace("([^0-9])", "", $value));
                                if (strlen($value) <= 10) {
                                    $formData[$key] = $value;
                                } else {
                                    $formErrors[] = array('id' => $key, 'error_code' => '003');
                                }
                            }
                            break;

                        case 'cellphone_number':
                            if (is_array($value)) {
                                $arr = [];
                                foreach ($value as $i) {
                                    $i = sanitize_text_field(preg_replace("([^0-9])", "", $i));
                                    $arr[] = $i;
                                }
                                $formData[$key] = $value;
                            } else {
                                $value = sanitize_text_field(preg_replace("([^0-9])", "", $value));
                                $prefix = substr($value, 0, 3);
                                if (strlen($value) == 10 && $prefix >= '300' && $prefix <= '350') {
                                    $formData[$key] = $value;
                                } else {
                                    $formErrors[] = array('id' => $key, 'error_code' => '004');
                                }
                            }
                            break;
                        default:
                            break;
                    }

                    if ($formItem->slug == 'activity_date') {
                        date_default_timezone_set('America/Bogota');
                        $timestamp = date('d-m-Y');
                        $data = str_replace("/", "-", $value);
                        $trainingTime = $this->get_form_item_by_slug('training_time', $form);

                       /* if (strtotime($timestamp) !== strtotime($data)) {
                            $formData[$trainingTime->id] = 0;
                            $formData['status'] = 'not_approved';
                        }*/
                    }
                }
            }

            if (!empty($formErrors)) {
                $data = ['status' => 'error_fields'];
                array_push($data, $formErrors);
                echo json_encode($data);

                return false;
            } else {
                return true;
            }
        }

        private function get_last_registry()
        {
            global $wpdb;
            $currentUser = wp_get_current_user();
            $userID = $currentUser->user_login;

            $tableForms = $wpdb->prefix . "control_forms";
            $tableFormsMeta = $wpdb->prefix . "control_forms_meta";

            $sql = "SELECT DATE_FORMAT((CONVERT_TZ(b.timestamp, '-00:00', '-05:00')),'%d/%m/%y') as timestamp,
            b.id,
			b.form,
			a.value AS training_time

			FROM $tableFormsMeta a JOIN $tableForms b
            
			ON a.form_id = b.id
			WHERE b.user_id = '$userID'
            AND a.meta = 'training_time'
            ORDER BY b.timestamp DESC
            LIMIT 20";
            $result = $wpdb->get_results($sql);

            foreach ($result as $form) {
                switch($form->form) {
                    case 'for_vas_mark_movil':
                    case 'for_vas_mark_empresas':
                    case 'for_vas_mark_hogares':
                        $form->form = "Marcación";
                        break;
                    case 'for_vas_07_movil':
                    case 'for_vas_07_empresas':
                    case 'for_vas_07_hogares':
                    case 'for_vas_07_nuevo':
                    case 'for_vas_07_tecnicos':
                        $form->form = "Acompañamiento";
                        break;
                    case 'for_vas_34_movil':
                    case 'for_vas_34_empresas':
                    case 'for_vas_34_hogares':
                    case 'for_vas_34_tecnicos':
                    case 'for_vas_34_union':
                        $form->form = "Entrenamiento";
                        break;
                    case 'for_vas_33_movil':
                    case 'for_vas_33_empresas':
                    case 'for_vas_33_hogares':
                    case 'for_vas_33_tecnicos':
                        $form->form= "Inducción";
                        break;
                    case 'for_vas_10_asistencia':
                        $form->form= "Asistencia";
                        break;
                    default:
                        break;
                }
            }

            echo json_encode($result);
            die;
        }

        private function main_interface()
        { ?>
            <div id="slidepane-container">
                <ul id="slidepane-nav">
                    <li class="nav-item">FORMS</li>
                    <li class="nav-item">PLANNER</li>
                    <li class="nav-item">PERFORM</li>
                    <li id="nav-line"></li>
                </ul>
                <div id="slidepane">
                    <ul>
                        <li id="pane-1">
                            <div id="gps-check">GPS<i class="icon"></i></div>
                            <?php include_once('inc/section-forms.php'); ?>
                        </li>
                        <li id="pane-2">
                            <?php include_once('inc/section-planner.php'); ?>
                        </li>
                        <li id="pane-3">
                            <?php /*include_once( 'inc/section-performance.php' );*/ ?>
                        </li>
                    </ul>

                </div>
            </div>
            <?php
        }

        private function dashboard_interface()
        {
            include_once('dashboard/section-dashboard.php');
        }
    }
}

function load_tigotrainersControl()
{
    tigotrainersControl::get_instance();
}

add_action('init', 'load_tigotrainersControl');

register_activation_hook(__FILE__, array('tigotrainersControl', 'install'));