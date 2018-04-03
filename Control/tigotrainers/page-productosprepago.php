
<?php get_header(); ?>

<?php

$args = array(
    'category_name' => 'prod-prepago',
    'post_type' => array( 'post', 'page')
);
$query1 = new WP_Query( $args );?>
<section class="ttr-productos">
	<h1>Productos Tigo Prepago</h1>
	<?php if ( $query1->have_posts() ) { ?>
    <ul>
        <?php while ( $query1->have_posts() ) { $query1->the_post();?>
            <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
        <?php } ?>
    </ul>
<?php } ?>
</section>

<?php wp_reset_postdata(); ?>
<?php get_footer(); ?>