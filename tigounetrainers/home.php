<?php get_header(); ?>

<?php
$args       = array(
        'orderby'    => 'name',
        'parent'     => 0,
        'hide_empty' => 0
);
$categories = get_categories( $args ); ?>

<?php
echo do_shortcode("[metaslider id=134]");
?>



    <div class="row movil">
        <?php foreach ( $categories as $cat ) { if ( $cat->slug == 'movil' ) { ?>
        
        <div class="col s12 b_movil"><img src="https://www.tigounetrainers.com/wp-content/themes/tigounetrainers/img/news/banner_m.jpg" width="100%"></div>
        
        <div class="col s4 m4 l4 b_home"><img src="https://www.tigounetrainers.com/wp-content/themes/tigounetrainers/img/news/img_movil.jpg" width="100%" style="    margin-bottom: -6px;">
            <h3><a href="<?php echo get_category_link($cat->cat_ID); ?>"><?php echo $cat->name; ?></a></h3>
        </div>
        <div class="col s12 m8 l8">
            <ul class="trnrs-menu-list">
              <li>
                <div class="trnrs-main-inner">
                    <?php
                        $args     = array(
                            'orderby'    => 'name',
                            'parent'     => $cat->cat_ID,
                            'hide_empty' => 0
                        );
                        $children = get_categories( $args ); ?>
                            <ul class="trnrs-item-list">
                                <? $cont = 0; 
                                    include_once 'imagenes_items.php';
                                    $imagen_gen = new Img_Items();                                         
                                                                              
                                    foreach ( $children as $child ) {
                                    $cont++;
                                    $img = $imagen_gen->mostrar_imagen($cont);
                                ?>
                                
                                    <li class="hvr-float item <? echo $cont ?>">
                                        <a href="<?php echo get_category_link( $child->cat_ID ); ?>"><img class="item_img" src="<? echo $img ?>"></a>
                                        <a href="<?php echo get_category_link( $child->cat_ID ); ?>"><?php echo $child->name; ?></a>
                                        
                                    </li>
                                 <? } ?>
                            </ul>
                    </div>
                </li>
            </ul>
        </div>
        <? } } ?>
    </div>

    <div class="row home">
        <?php foreach ( $categories as $cat ) { if ( $cat->slug == 'hogares' ) { ?>
        
        <div class="col s12 b_movil"><img src="https://www.tigounetrainers.com/wp-content/themes/tigounetrainers/img/news/banner_h.jpg" width="100%"></div>
        
        
        <div class="col s12 m8 l8">
            <ul class="trnrs-menu-list">
              <li>
                <div class="trnrs-main-inner">
                    <?php
                        $args     = array(
                            'orderby'    => 'name',
                            'parent'     => $cat->cat_ID,
                            'hide_empty' => 0
                        );
                        $children = get_categories( $args ); ?>
                            <ul class="trnrs-item-list">
                                <? $cont = 6; 
                                    include_once 'imagenes_items.php';
                                    $imagen_gen = new Img_Items();                                         
                                                                              
                                    foreach ( $children as $child ) {
                                    $cont++;
                                    $img = $imagen_gen->mostrar_imagen($cont);
                                ?>
                                
                                    <li class="hvr-float item <? echo $cont ?>">
                                        <a href="<?php echo get_category_link( $child->cat_ID ); ?>"><img class="item_img" src="<? echo $img ?>"></a>
                                        <a href="<?php echo get_category_link( $child->cat_ID ); ?>"><?php echo $child->name; ?></a>
                                        
                                    </li>
                                 <? } ?>
                            </ul>
                    </div>
                </li>
            </ul>
        </div>
        
        <div class="col s4 m4 l4 b_home"><img src="https://www.tigounetrainers.com/wp-content/themes/tigounetrainers/img/news/img_home.jpg" width="100%" style="    margin-bottom: -6px;">
            <h3><a href="<?php echo get_category_link($cat->cat_ID); ?>"><?php echo $cat->name; ?></a></h3>
        </div>
        <? } } ?>
    </div>

    <div class="row empresas">
        <?php foreach ( $categories as $cat ) { if ( $cat->slug == 'empresas-y-gobierno' ) { ?>
        
        <div class="col s12 b_movil"><img src="https://www.tigounetrainers.com/wp-content/themes/tigounetrainers/img/news/banner_e.jpg" width="100%"></div>
        
        <div class="col s4 m4 l4 b_home"><img src="https://www.tigounetrainers.com/wp-content/themes/tigounetrainers/img/news/img_empresas.jpg" width="100%" style="    margin-bottom: -6px;">
            <h3><a href="<?php echo get_category_link($cat->cat_ID); ?>"><?php echo $cat->name; ?></a></h3>
        </div>
        
        <div class="col s12 m8 l8">
            <ul class="trnrs-menu-list">
              <li>
                <div class="trnrs-main-inner">
                    <?php
                        $args     = array(
                            'orderby'    => 'name',
                            'parent'     => $cat->cat_ID,
                            'hide_empty' => 0
                        );
                        $children = get_categories( $args ); ?>
                            <ul class="trnrs-item-list">
                                <? $cont = 12; 
                                    include_once 'imagenes_items.php';
                                    $imagen_gen = new Img_Items();                                         
                                                                              
                                    foreach ( $children as $child ) {
                                    $cont++;
                                    $img = $imagen_gen->mostrar_imagen($cont);
                                ?>
                                
                                    <li class="hvr-float item <? echo $cont ?>">
                                        <a href="<?php echo get_category_link( $child->cat_ID ); ?>"><img class="item_img" src="<? echo $img ?>"></a>
                                        <a href="<?php echo get_category_link( $child->cat_ID ); ?>"><?php echo $child->name; ?></a>
                                        
                                    </li>
                                 <? } ?>
                            </ul>
                    </div>
                </li>
            </ul>
        </div>
        
        
        <? } } ?>
    </div>

<div class="row home">
        <?php foreach ( $categories as $cat ) { if ( $cat->slug == 'tecnicos' ) { ?>
        
        <div class="col s12 b_movil"><img src="https://www.tigounetrainers.com/wp-content/themes/tigounetrainers/img/news/banner_t.jpg" width="100%"></div>
        
        <div class="col s12 m8 l8">
            <ul class="trnrs-menu-list">
              <li>
                <div class="trnrs-main-inner">
                    <?php
                        $args     = array(
                            'orderby'    => 'name',
                            'parent'     => $cat->cat_ID,
                            'hide_empty' => 0
                        );
                        $children = get_categories( $args ); ?>
                            <ul class="trnrs-item-list">
                                <? $cont = 15; 
                                    include_once 'imagenes_items.php';
                                    $imagen_gen = new Img_Items();                                         
                                                                              
                                    foreach ( $children as $child ) {
                                    $cont++;
                                    $img = $imagen_gen->mostrar_imagen($cont);
                                ?>
                                
                                    <li class="hvr-float item <? echo $cont ?>">
                                        <a href="<?php echo get_category_link( $child->cat_ID ); ?>"><img class="item_img" src="<? echo $img ?>"></a>
                                        <a href="<?php echo get_category_link( $child->cat_ID ); ?>"><?php echo $child->name; ?></a>
                                        
                                    </li>
                                 <? } ?>
                            </ul>
                    </div>
                </li>
            </ul>
        </div>
        
    <div class="col s4 m4 l4 b_home"><img src="https://www.tigounetrainers.com/wp-content/themes/tigounetrainers/img/news/img_tecnicos.jpg" width="100%" style="    margin-bottom: -6px;">
            <h3><a href="<?php echo get_category_link($cat->cat_ID); ?>"><?php echo $cat->name; ?></a></h3>
        </div>
        
        <? } } ?>
    </div>





<?php get_footer(); ?>
