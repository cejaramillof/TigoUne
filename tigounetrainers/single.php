<?php get_header(); ?>

<?php
if ( have_posts() ) {
    while ( have_posts() ) {
        the_post(); ?>

        <article id="post-<?php the_ID(); ?>" class="trnrs-article">
            <div class="trnrs-title-primary">
                <a class="trnrs-go-back" href="javascript:history.back()">< Volver </a>
                <h1><?php the_title(); ?></h1>
            </div>
            <div class="trnrs-content"><?php the_content(); ?></div>
        </article>
    <?php 
	    if (is_user_logged_in()) {
	        include_once "RastreoConsultasMultimedias.php";
	        $r = new RastreoConsultas();
	        $usuarioActual = wp_get_current_user();
	        $r->agregarRastroConsulta($usuarioActual->user_login, $_SERVER["REQUEST_URI"]);
    	}
	}
     
}
?>
<?php get_footer(); ?>