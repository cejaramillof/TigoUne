<?php get_header(); ?>

<section id="ttr-single-productos">
    <?php if ( have_posts() ) {
        while ( have_posts() ) {
            the_post();?>
            <?php the_content(); ?>
        <?php } ?>
    <?php } ?>
</section>


<?php get_footer(); ?>