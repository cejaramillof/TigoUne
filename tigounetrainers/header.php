<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php wp_head(); ?>

    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo home_url() ?>/wp-content/themes/tigounetrainers/icon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo home_url() ?>/wp-content/themes/tigounetrainers/icon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo home_url() ?>/wp-content/themes/tigounetrainers/icon/favicon-16x16.png">
    <link rel="manifest" href="<?php echo home_url() ?>/wp-content/themes/tigounetrainers/icon/manifest.json">
    <link rel="mask-icon" href="<?php echo home_url() ?>/wp-content/themes/tigounetrainers/icon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="theme-color" content="#ffffff">
    
</head>

<body>
<div id="page">
    <header class="trnrs-header">
        <div class="trnrs-header-row">
            <a class="trnrs-logo trnrs-header-button" href="<?php echo home_url(); ?>">
                <img src="<?php echo get_template_directory_uri(); ?>/img/tigoune_trainers_logo.svg" alt="TigoUNE | Trainers">
            </a>

            <a class="trnrs-logout trnrs-header-button" href="<?php echo wp_logout_url(); ?> ">
                <img src="<?php echo get_template_directory_uri(); ?>/img/logout.svg" alt="Cerrar sesión">
            </a>
        </div>
    </header>
    <main class="trnrs-main">