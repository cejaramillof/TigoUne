<?php get_header(); ?>

    <section id="ttr-single-ayuda">
        <h1><?php the_title(); ?></h1>
        <p>Selecciona un cargo básico y descubre las ventajas que obtienes en Tigo frente a otros operadores. Debajo de cada comparación
            verás un instructivo para armar cada combinación del guante respectivo.</p>
        <div class="content">
            <select id="pospago-selection">
                <option class="placeholder" selected disabled>Selecciona un cargo básico</option>
                <option value="36900">$36.900</option>
                <option value="41900">$41.900</option>
                <option value="51900">$51.900</option>
                <option value="61900">$61.900</option>
                <option value="71900">$71.900</option>
                <option value="81900">$81.900</option>
                <option value="141900">$141.900</option>
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
                    case '36900':
                        results.empty();
                        results.html(addImage('36900'));
                        break;
                    case '41900':
                        results.empty();
                        results.html(addImage('41900'));
                        break;
                    case '51900':
                        results.empty();
                        results.html(addImage('51900'));
                        break;
                    case '61900':
                        results.empty();
                        results.html(addImage('61900'));
                        break;
                    case '71900':
                        results.empty();
                        results.html(addImage('71900'));
                        break;
                    case '81900':
                        results.empty();
                        results.html(addImage('81900'));
                        break;
                    case '141900':
                        results.empty();
                        results.html(addImage('141900'));
                        break;
                    default:
                        break;
                }
            });

            function addImage(img) {
                return '<img src="'+ '<?php echo get_template_directory_uri(); ?>' + '/foco-pospago/' + img +'.png" alt="">';
            }
        })(jQuery);
    </script>
<?php get_footer(); ?>