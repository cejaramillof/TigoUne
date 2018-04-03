<?php
if (!defined('ABSPATH')) {
    exit;
}


//if (get_bu() == 'MOVIL') {
    
    $plannerUI = new Planner_Viewer_Interface();
    ?>

    <div id="ctrl-planner">
        <?php $plannerUI->editor_ui(); ?>
    </div>

<?php //} ?>