<?php get_header(); ?>

<? /*if(is_category(4)){ ?>
    <? echo do_shortcode('[metaslider id=135]') ?>
<? }else if(is_category(10)){ ?>
    <? echo do_shortcode('[metaslider id=136]') ?>
<? }else{ ?> <? } */?>

<?
$categoria = get_the_category();
$parent = get_cat_name($categoria[0]->category_parent);
?>

<? /*if (!empty($parent)) {

        if($parent == 'Movil'){

            echo do_shortcode('[metaslider id=135]');

        }else if($parent == 'Hogares'){

            echo do_shortcode('[metaslider id=136]');

        }else{

            echo '';

        }
}*/

?>

<?php $category = get_category( get_query_var( 'cat' ) ); ?>

<div class="trnrs-title-primary">
    <div class="container">
    <div class="trnrs-category-breadcrumb">
        <?php
        echo '<a href="' . home_url() . '">Inicio</a> / ';
        if ( $category->parent != 0 ) {
            $parents = get_category_parents( $category->cat_ID, true, '|||' );
            $parents = explode( '|||', $parents );
            $parents = array_slice( $parents, 0, - 1 );
            foreach ( $parents as $parent ) {
                echo $parent . ' / ';
            }
        } ?>
        <? echo $category->name;  ?>
    </div>
    <h1></h1>
</div>
</div>

<div class="container" style="margin-top: 60px">
    <div class="row">
        <?php if ( have_posts() ) : ?>
            <?php while ( have_posts() ) : the_post(); ?>

                <div class="col s6 m3 l3 item_sub">
                    <img class="hvr-float" src="https://www.tigounetrainers.com/wp-content/themes/tigounetrainers/img/news/smartphone.png" width="80px">
                    <a href="<? the_permalink() ?>"><span><? the_title() ?></span></a>
                </div>

            <? endwhile; ?>
        <? endif; ?>
    </div>
</div>
<?php get_footer(); ?>
