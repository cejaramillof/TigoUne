<?php get_header(); ?>



    <section id="ttr-single-ayuda">
        <h1><?php the_title(); ?></h1>
        <img src="">
        <p>Conoce la nueva forma de hablar, mensajear, navegar, escuchar tu música y llamar a números internacionales con las rutas cortas del menú *111#</p>
        <div class="content">
            <select id="pospago-selection">
                <option class="placeholder" selected disabled>¿Qué quieres hacer?</option>
                <option value="navega">Navegar</option>
                <option value="navega_music">Navegar + Música</option>
                <option value="habla_sms">Hablar y Mensajear</option>
                <option value="combo">Navegar, Hablar y Mensajear</option>
                <option value="sms">Mensajear</option>
                <option value="ldi">Llamar a Larga Distancia Internacional</option>
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
                    case 'navega':
                        results.empty();
                        results.html(addImage('navega'));
                        break;
                    case 'navega_music':
                        results.empty();
                        results.html(addImage('navega_music'));
                        break;
                    case 'habla_sms':
                        results.empty();
                        results.html(addImage('habla_sms'));
                        break;
                    case 'sms':
                        results.empty();
                        results.html(addImage('sms'));
                        break;
                    case 'ldi':
                        results.empty();
                        results.html(addImage('ldi'));
                        break;
                    case 'combo':
                        results.empty();
                        results.html(addImage('combo'));
                        break;
                    default:
                        break;
                }
            });

            function addImage(img) {
                return  '<img src="'+ '<?php echo get_template_directory_uri(); ?>' + '/ruta111/head.jpg" alt="">'
                        + '<img src="'+ '<?php echo get_template_directory_uri(); ?>' + '/ruta111/' + img +'.png" alt="">'
                        + '<img src="'+ '<?php echo get_template_directory_uri(); ?>' + '/ruta111/foot.jpg" alt="">';
            }
        })(jQuery);
    </script>
<?php get_footer(); ?>