<?php

add_action('wp_enqueue_scripts', 'trnrs_theme_enqueue_scripts');

function trnrs_theme_enqueue_scripts(){
	wp_enqueue_script('jquery');
	wp_register_style('trnrs-theme', get_template_directory_uri().'/style.css', array(), '1.0');
	wp_enqueue_style('trnrs-theme');
	wp_enqueue_style('dashicons');
}

function get_cat_hierchy($parent,$args){
	$cats = get_categories($args);
	$ret = new stdClass;

	foreach($cats as $cat){
		if($cat->parent==$parent){
			$id = $cat->cat_ID;
			$ret->$id = $cat;
			$ret->$id->children = get_cat_hierchy($id,$args);
		}
	}

	return $ret;
}

remove_filter( 'the_content', 'wpautop' );
remove_filter( 'the_excerpt', 'wpautop' );


function oz_login_head() {
	function oz_username_label( $translated_text, $text, $domain ) {
		if ( 'Username or Email Address' === $text ) {
			$translated_text = 'Usuario';
		}
		return $translated_text;
	}
	add_filter( 'gettext', 'oz_username_label', 20, 3 );
}
add_action( 'login_head', 'oz_login_head' );

function blog_css() {?>
	   
	   <!-- CSS -->
<link rel="stylesheet" type="text/css" href="<? echo get_bloginfo('stylesheet_directory');?>/css/globales.css">
<link rel="stylesheet" type="text/css" href="<? echo get_bloginfo('stylesheet_directory');?>/css/hover-min.css">
<link rel="stylesheet" type="text/css" href="<? echo get_bloginfo('stylesheet_directory');?>/css/materialize.min.css"/>
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
        <!-- CSS -->
	   
<? }
add_action('wp_head', 'blog_css');


/**
	***integracion de JS*******
**/

function blog_js(){?>

	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->
    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    	<!--[if lt IE 9]>
         	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
        
	<!-- js  --> 
		

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="<? echo get_bloginfo('stylesheet_directory');?>/js/materialize.min.js"></script>


	<!-- js -->
<? } 

add_action('wp_head', 'blog_js');