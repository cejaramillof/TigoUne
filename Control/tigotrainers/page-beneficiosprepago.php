<?php get_header(); ?>



    <section id="ttr-single-ayuda">
        <h1><?php the_title(); ?></h1>
        <p>Conoce los beneficios de los productos prepago Tigo específicos de tu canal.</p>
        <div class="content">
            <select id="pospago-selection">
                <option class="placeholder" selected disabled>Selecciona un Canal</option>
                <option value="fvd">Fuerza de Venta Directa</option>
                <option value="retail">Retail</option>
                <option value="cde">Centros de Experiencia</option>
                <option value="dealer">Dealer</option>
            </select>
            <div id="foco-pospago-results">

            </div>
        </div>
    </section>
    <script>
        (function ( $ ) {
            $('#pospago-selection').change(function(){
                var data= $(this).val();
                var results = $('#foco-pospago-results');
                switch (data){
                    case 'fvd':
                        results.empty();
                        results.html(createIframe('fvd'));
                        break;
                    case 'dealer':
                        results.empty();
                        results.html(createIframe('dealer'));
                        break;
                    default:
                        results.empty();
                        results.html('Información no disponible, intenta más tarde.');
                        break;
                }
            });

            function addImage(img) {
                return '<img src="'+ '<?php echo get_template_directory_uri(); ?>' + '/foco-pospago/' + img +'.png" alt="">'+
                '<img src="'+ '<?php echo get_template_directory_uri(); ?>' + '/foco-pospago/' + img +'s.png" alt="">'
                    ;
            }

            function createIframe(channel){
                return '<iframe src="http://docs.google.com/gview?url=http://www.googledrive.com/host/0BxN3Cfl2glHQfjNyUG52eU9HWU5rQ2FqOHNBQlRGbVJSRDB3VzIwWmZmVHhFMWhvd0NnUGc/beneficios_prepago_'+ channel +'.pptx&embedded=true" frameborder="0"></iframe>';
            }
        })(jQuery);
    </script>
<?php get_footer(); ?>