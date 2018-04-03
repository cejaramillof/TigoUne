<?php get_header(); ?>

<div class="container">
    <div class="row">
        <?

        $cont = 0;
        include_once 'imagenes_items.php';
        $imagen_gen = new Img_Items();

        $cats = get_categories(array( 'child_of' => 25 ));

            // loop through the categries
            foreach ($cats as $cat) {

                $cont++;
                $img = $imagen_gen->mostrar_imagen($cont);
                // setup the cateogory ID
                $cat_id= $cat->term_id;

                echo '<div class="item_subcat">';
                echo '<img class="img_subcat_item" src="' .$img. '">';
                echo '<h2>'.$cat->name.'</h2>';
                echo '</div>';


                // create a custom wordpress query
                query_posts("cat=$cat_id&posts_per_page=100");
                // start the wordpress loop!
                if (have_posts()) : while (have_posts()) : the_post(); ?>


                    <div class="col s6 m3 l3 item_sub">
                        <img class="hvr-float" src="https://www.tigounetrainers.com/wp-content/themes/tigounetrainers/img/news/smartphone.png" width="80px">
                        <a href="<? the_permalink() ?>"><span><? the_title() ?></span></a>
                    </div>



                <?php endwhile; endif; // done our wordpress loop. Will start again for each category ?>
            <?php } // done the foreach statement ?>

        </div><!-- #content -->
    </div><!-- #container -->


<?php get_footer(); ?>
