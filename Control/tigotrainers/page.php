<?php 

if(is_page('tigotrainers')){
	wp_redirect(home_url());
	exit;
}

get_header(); ?>

<?php

if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();
		the_content();
	}
}
?>

<?php get_footer(); ?>