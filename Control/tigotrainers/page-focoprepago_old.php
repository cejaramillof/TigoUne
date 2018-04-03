<?php get_header(); ?>

    <section id="ttr-single-ayuda">
        <h1><?php the_title(); ?></h1>
        <p>Descubre las ventajas que obtienes con los productos Prepago Tigo frente a otros operadores. Verás por cada paquete un speech
            y un argumento de venta para que asesores de la mejor manera a tu cliente.</p>
        <div class="content">
            <div id="selection-boxes">
            <label for="channel-selection" style="display: none">Seleccionar Canal</label>
            <select id="channel-selection">
                <option class="placeholder" selected disabled>Selecciona un canal</option>
                <option value="fvd">Fuerza de Venta Directa</option>
                <option value="retail">Retail</option>
                <option value="dealer">Dealer</option>
                <option value="cde">Centro de Experiencia</option>
            </select>
            <label for="item-selection" class="ttr-selection" style="display: none">Seleccionar Canal</label>
            <select id="item-selection" class="ttr-selection" style="display: none">

            </select>
            </div>
            <div id="foco-prepago-results">

            </div>
        </div>
    </section>
    <script>
        (function ( $) {

            var options = [];
            var results = $('#foco-prepago-results');

            $('#channel-selection').change(function(){
                var data= $(this).val();
                results.empty();
                switch (data){
                    case 'fvd':
                        options = [
                            {name: "Chip Basico", value:"$5.000 ", image:"02", sp: false},
                            {name: "Chip Conectate", value:"$15.000 ", image:"03", sp: false},
                            {name: "Foco Paquete 60 Min + 60 SMS", value:"$9.000 ", image:"04", sp: false},
                            {name: "Foco Paquete 600 MB", value:"$13.000 ", image:"05", sp: false},
                            {name: "Foco Paquete 500MB + 50 Min TD + 50 SMS ", value:"$17.900 ", image:"06", sp: false},
                            {name: "Chip Smartpack", value:"$35.000 ", image:"07", sp: true},
                            {name: "Chip Básico", value:"$5.000 ", image:"08", sp: true},
                            {name: "Chip Smartpack", value:"$42.000 ", image:"09", sp: true},
                            {name: "Chip Smartpack", value:"$59.900 ", image:"10", sp: true},
                            {name: "Chip Prepagado", value:"3 X $49.900 ", image:"11", sp: true},
                            {name: "Chip Prepagado (1)", value:"6 X $49.900 ", image:"12", sp: true},
                            {name: "Chip Prepagado (2)", value:"6 X $49.900", image:"13", sp: true}
                        ];
                        createPriceRanges(options);
                        break;
                    case 'retail':
                        options = [
                            {name: "Chip Básico", value:"$5.000 ", image:"08", sp: false},
                            {name: "Chip Smartpack", value:"$42.000 ", image:"09", sp: false},
                            {name: "Chip Smartpack", value:"$59.900 ", image:"10", sp: false},
                            {name: "Chip Prepagado", value:"3 X $49.900 ", image:"11", sp: false},
                            {name: "Chip Prepagado (1)", value:"6 X $49.900 ", image:"12", sp: false},
                            {name: "Chip Prepagado (2)", value:"6 X $49.900", image:"13", sp: false}
                        ];
                        createPriceRanges(options);
                        break;
                    case 'dealer':
                        options = [
                            {name: "Chip Basico", value:"$5.000 ", image:"02", sp: false},
                            {name: "Chip Conectate", value:" $15.000 ", image:"03", sp: false},
                            {name: "Foco Paquete 60 Min + 60 Sms", value:" $9.000 ", image:"04", sp: false},
                            {name: "Foco Paquete 600 Mb", value:" $13.000 ", image:"05", sp: false},
                            {name: "Foco Paquete 500mb + 50 Min Td + 50 Sms ", value:" $17.900 ", image:"06", sp: false},
                            {name: "Chip Smartpack", value:" $35.000 ", image:"07", sp: false},
                            {name: "Chip Smartpack", value:"$42.000 ", image:"09", sp: true},
                            {name: "Chip Smartpack", value:" $59.900 ", image:"10", sp: true},
                            {name: "Chip Prepagado", value:" 3 X $49.900 ", image:"11", sp: true},
                            {name: "Chip Prepagado (1)", value:" 6 X $49.900 ", image:"12", sp: true},
                            {name: "Chip Prepagado (2)", value:" 6 X $49.900", image:"13", sp: true}
                        ];
                        createPriceRanges(options);
                        break;
                    case 'cde':
                        options = [
                            {name: "Chip Smartpack", value:"$42.000 ", image:"09", sp: true},
                            {name: "Chip Smartpack", value:" $59.900 ", image:"10", sp: true},
                            {name: "Chip Prepagado", value:" 3 X $49.900 ", image:"11", sp: true},
                            {name: "Chip Prepagado (1)", value:" 6 X $49.900 ", image:"12", sp: true},
                            {name: "Chip Prepagado (2)", value:" 6 X $49.900 ", image:"13", sp: true},
                            {name: "Chip Smartpack", value:" $42.000 ", image:"14", sp: true},
                            {name: "Chip Smartpack", value:" $59.900 ", image:"15", sp: true},
                            {name: "Chip Prepagado", value:" 3 X $59.900 ", image:"16", sp: true},
                            {name: "Chip Prepagado [1)", value:" 6 X $49.900 ", image:"17", sp: true},
                            {name: "Chip Prepagado (2)", value:" 6 X $49.900", image:"01", sp: true}
                        ];
                        createPriceRanges(options);
                        break;
                    default:
                        break;
                }
            });

            function createPriceRanges(info){
                var i;
                var item ='';
                var items = $('#item-selection');
                for (i = 0; i < info.length; i++){
                    item += '<option value="'+info[i].image+'" data-sp="'+ info[i].sp +'">'+ info[i].name + " por " + info[i].value + '</option>';
                }
                var placeholder = '<option class="placeholder" selected disabled>Selecciona un paquete</option>';
                items.html(placeholder + item);
                items.css('display', 'block');
            }

            $('#item-selection').change(function(){
                var img= $(this).val();
                var sp = $('option:selected', this).attr('data-sp');
                var image = '';
                console.log(sp);
                if ( sp == "true" ) image += "<p class='ttr-prepado-emphasis'>Aplica sólo para venta con Smartphone:</p>";
                image += '<img src="'+ '<?php echo get_template_directory_uri(); ?>' + '/foco-prepago/' + img +'.png" alt="">';
                results.html(image);
            });

        })(jQuery);
    </script>
<?php get_footer(); ?>