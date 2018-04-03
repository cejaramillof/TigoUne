<?php

// Enqueue scripts and styles to theme

remove_filter( 'the_content', 'wpautop' );


function ttr_enqueue_scripts()

{

    /*wp_deregister_script( 'jquery' );

    wp_register_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js', '', '2.1.3', true );*/

    wp_register_script('ttr-mainjs', get_template_directory_uri() . '/js/main.js', array('jquery', 'underscore'), '1.0', true);



    wp_enqueue_script('jquery');

    wp_enqueue_script('ttr-mainjs');

    wp_enqueue_style('ttr-normalize', get_template_directory_uri() . '/css/normalize.css', '1.0');

    wp_enqueue_style('ttr-style', get_stylesheet_uri(), '1.0');

}



add_action('wp_enqueue_scripts', 'ttr_enqueue_scripts');



// Setup theme core features

function ttr_theme_setup()

{



    // Theme Support

    add_theme_support('title-tag');

    add_theme_support('post-thumbnails');



    // Add categories and tags to pages

    register_taxonomy_for_object_type('post_tag', 'page');

    register_taxonomy_for_object_type('category', 'page');



    // Register menus

    register_nav_menu('sidebar-menu-1', __('Sidebar Menu 1'));

    register_nav_menu('sidebar-menu-2', __('Sidebar Menu 2'));

    register_nav_menu('sidebar-menu-3', __('Sidebar Menu 3'));



    // Remove head metatags

    remove_action('wp_head', 'wp_generator');

    remove_action('wp_head', 'wlwmanifest_link');

    remove_action('wp_head', 'rsd_link');



    // Remove admin bar on front-end

    show_admin_bar(false);

}



add_action('init', 'ttr_theme_setup');



//Get template for single post of specific category

add_filter('single_template', create_function('$the_template',

        'foreach( (array) get_the_category() as $cat ) {

		if ( file_exists(TEMPLATEPATH . "/single-{$cat->slug}.php") )

		return TEMPLATEPATH . "/single-{$cat->slug}.php";

	}

	return $the_template;')

);



// Include blog functions

include('inc/blog-functions.php');



// Include menu walkers

include('inc/menu-walkers.php');



function remove_scripts() {

    if ( !is_page('cobertura') ) {

        wp_dequeue_script('tmnt_mainjs');

        wp_dequeue_style('tmnt_style');

    }

    if ( !is_page('asistenteprepago') ) {

        wp_dequeue_script('ppacks_mainjs');

        wp_dequeue_style('ppacks_style');

    }



    if ( is_page('focopospago')) {

        wp_dequeue_script('offer_infinite_mainjs');

        wp_dequeue_style('offer_infinite_style');

    } 

    

    if ( !is_page('focoprepago') ) {

        wp_dequeue_script('focus_prepaid_mainjs');

        wp_dequeue_style('focus_prepaid_style');

    }

    if ( !is_page('focopospago') ) {

        wp_dequeue_script('focus_postpaid_mainjs');

        wp_dequeue_style('focus_postpaid_style');

    }

	if ( !is_page('gross') ) {

		wp_dequeue_script('gross_automatico_mainjs');

		wp_dequeue_style('gross_automatico_style');

	}

}

add_action( 'wp_enqueue_scripts', 'remove_scripts', 99 );







function my_login_logo() { ?>

    <style type="text/css">

        .login h1 a {

            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/img/tigotrainers_logo_white.svg) !important;

        }

    </style>

<?php }

add_action( 'login_enqueue_scripts', 'my_login_logo' );





/**

 * Custom Login fuctions

 */



// Custom login stylesheet and scripts

function my_login_stylesheet() {

    wp_enqueue_style( 'custom-login-css', get_template_directory_uri() . '/css/style-login.css' );

    wp_enqueue_script( 'custom-login-js', get_template_directory_uri() . '/js/style-login.js', array('jquery') );

}

add_action( 'login_enqueue_scripts', 'my_login_stylesheet' );



// Setup logo URL

function my_login_logo_url() {

    return home_url();

}

add_filter( 'login_headerurl', 'my_login_logo_url' );



// Setup logo URL title

function my_login_logo_url_title() {

    return 'Tigotrainers';

}

add_filter( 'login_headertitle', 'my_login_logo_url_title' );



// Setup default checked "Remember me"

function login_checked_remember_me() {

    add_filter( 'login_footer', 'rememberme_checked' );

}

add_action( 'init', 'login_checked_remember_me' );



function rememberme_checked() {

    echo "<script>document.getElementById('rememberme').checked = true;</script>";

}



function is_login_page() {

    return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));

}



if(is_login_page()){

    //this is a login page

}



// Change login error message

add_filter('login_errors',create_function('$a', "return 'Tu nombre de usuario y/o contraseña son incorrectos. Intenta nuevamente.';"));



// Remove login shake

function my_login_head() {

    remove_action('login_head', 'wp_shake_js', 12);

}

add_action('login_head', 'my_login_head');



// Prevent non administrators to acces profile page and redirect

//add_action('login_form', 'redirect_after_login');



function redirect_after_login() {

    global $redirect_to;

    if (!isset($_GET['redirect_to']) && !current_user_can('manage_options')) {

        $redirect_to = home_url();

    }

}



// Hide wordpress dashboard to users

add_action( 'init', 'blockusers_init' );

function blockusers_init() {

    if ( is_admin() && !current_user_can( 'edit_others_pages' ) && !( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {

        wp_redirect( home_url() );

        exit;

    }

}



/*

 * Let Editors manage users, and run this only once.

 */

function isa_editor_manage_users() {



	if ( get_option( 'isa_add_cap_editor_once' ) != 'done' ) {



		// let editor manage users



		$edit_editor = get_role('editor'); // Get the user role

		$edit_editor->add_cap('edit_users');

		$edit_editor->add_cap('list_users');

		$edit_editor->add_cap('promote_users');

		$edit_editor->add_cap('create_users');

		$edit_editor->add_cap('add_users');

		$edit_editor->add_cap('delete_users');



		update_option( 'isa_add_cap_editor_once', 'done' );

	}



}

add_action( 'init', 'isa_editor_manage_users' );



//prevent editor from deleting, editing, or creating an administrator

// only needed if the editor was given right to edit users

/*

class ISA_User_Caps {



	// Add our filters

	function ISA_User_Caps(){

		add_filter( 'editable_roles', array(&$this, 'editable_roles'));

		add_filter( 'map_meta_cap', array(&$this, 'map_meta_cap'),10,4);

	}

	// Remove 'Administrator' from the list of roles if the current user is not an admin

	function editable_roles( $roles ){

		if( isset( $roles['administrator'] ) && !current_user_can('administrator') ){

			unset( $roles['administrator']);

		}

		return $roles;

	}

	// If someone is trying to edit or delete an

	// admin and that user isn't an admin, don't allow it

	function map_meta_cap( $caps, $cap, $user_id, $args ){

		switch( $cap ){

			case 'edit_user':

			case 'remove_user':

			case 'promote_user':

				if( isset($args[0]) && $args[0] == $user_id )

					break;

				elseif( !isset($args[0]) )

					$caps[] = 'do_not_allow';

				$other = new WP_User( absint($args[0]) );

				if( $other->has_cap( 'administrator' ) ){

					if(!current_user_can('administrator')){

						$caps[] = 'do_not_allow';

					}

				}

				break;

			case 'delete_user':

			case 'delete_users':

				if( !isset($args[0]) )

					break;

				$other = new WP_User( absint($args[0]) );

				if( $other->has_cap( 'administrator' ) ){

					if(!current_user_can('administrator')){

						$caps[] = 'do_not_allow';

					}

				}

				break;

			default:

				break;

		}

		return $caps;

	}



}

$isa_user_caps = new ISA_User_Caps();

*/



/*add_action('wp_login_failed', 'my_front_end_login_fail'); 

 

function my_front_end_login_fail($username){

    // Get the reffering page, where did the post submission come from?

    $referrer = $_SERVER['HTTP_REFERER'];

 

    // if there's a valid referrer, and it's not the default log-in screen

    if(!empty($referrer)){

        // let's append some information (login=failed) to the URL for the theme to use

        wp_redirect($referrer.'/?login=failed'); 

    exit;

    }

}*/



//add_filter( 'login_redirect', create_function( '$url,$query,$user', 'return home_url();' ), 10, 3 );


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

function guias(){
	global $wpdb;
	$p=$wpdb->get_row($wpdb->prepare("select * from userstemp where cedula='$_POST[p]'"));	
	$html= "<span>".$p->p."</span>";	
  //$response['user'] = $p;
  header('Content-Type: application/json');
  echo json_encode($p);
die();	
}
add_action('wp_ajax_guias', 'guias');
add_action('wp_ajax_nopriv_guias', 'guias'); 