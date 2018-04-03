/**
 * Created by cperezgo1 on 25/01/17.
 */

(function ($) {


    var jsonURL = "DB/POS.json";
    //var jsonURL = "https://www.tigounetrainers.com/wp-content/uploads/2017/03/BENCHPOS/DB/POS.json";
    var jsonProcess;

    var itemList = _.template($('#item').html());
    var list = _.template($('#list').html());

    var col2Template = _.template($('#table-2col').html());
    var col3Template = _.template($('#table-3col').html());
    var col4Template = _.template($('#table-4col').html());

    var tigoTemplate = _.template($('#tigoTemplate').html());
    var claroTemplate = _.template($('#claroTemplate').html());
    var movistarTemplate = _.template($('#movistarTemplate').html());
    var avantelTemplate = _.template($('#avantelTemplate').html());



    $(document).on('click', '.indice', function (event) {

        event.preventDefault();
        $(this).next('.topics').slideToggle(300).end().parent('li').toggleClass('content-visible');
        $(this).find('.span-arrow').toggleClass('open');
    });

    $(document).on('click', '.select', function () {

        var that = $(event.target);
        event.preventDefault();
        that.closest('.topics').slideToggle(300).end().parent('li').toggleClass('content-visible');
        that.closest('.selectContainer').find('.span-arrow').toggleClass('open');
        $(this).parents('.selectContainer').find('.in').html($(this).data("valor"));


    });

    $(document).on('click', '.button-call-action', function() {


        $('#lightbox-1').attr('checked', true);

    });

    $(document).on('click', '.back', function() {


        $('#lightbox-1').attr('checked', false);

    });


    function swiper() {



    var mySwiper = new Swiper('.swiper-container', {
        // Optional parameters
        direction: 'horizontal',
       // loop: true,
        //initialSlide: activeGlobal,

        // If we need pagination
        // pagination: '.swiper-pagination',

        // Navigation arrows
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev',

        //onInit: loadCookie,
        //onSlideChangeEnd: filter
        // And if we need scrollbar
        // scrollbar: '.swiper-scrollbar',
    });

    }



    $.getJSON(jsonURL, function (data) {


        jsonProcess = data;
        console.log(jsonProcess);


        initBase();

    });


    function initBase() {

        var htmlListItem = '';
        var htmlList = '';

        $.each(jsonProcess, function (index, item) {


            if (item.brand == 'tigo') {


                htmlListItem += itemList({

                    productName: item.basico,
                    id: item.id,
                    tipo: item.brand

                });
            }
        });


        htmlList += list({

            className: 'selectContainer fullWidth',
            Name: 'TigoUne',
            sel: 'un Plan',
            items: htmlListItem

        });


        $('.wrapper-plan').html(htmlList);


    }

    $(document).on('click', '.select', function () {

        var data = $(this).data('valor');
        var id = $(this).data('id');
        var movistar;
        var claro;
        var tigo;
        var avantel;
        var count = 0;

        $.each(jsonProcess, function (index, item) {


            if( item['id'] === id && item.brand === 'movistar'){

                movistar = item;

                count = count + 1;


            }

            if( item['id'] === id && item.brand === 'claro'){

                claro = item;

                count = count + 1;


            }

            if( item['id'] === id && item.brand === 'avantel'){

                avantel = item;

                count = count + 1;


            }

            if( item['id'] === id && item.brand === 'tigo'){

                tigo = item;

            }

        });


        switch (count){

            case 1:
                Draw2Col(tigo, claro);
                break;

            case 2:
                Draw3Col(tigo, claro, movistar);
                break;
            case 3:
                Draw4Col(tigo, claro, movistar, avantel);
                break;
        }

    });



function Draw2Col (tigo, claro) {


    var appsTigo;
    var appsClaro;
    var claroInternacional;
    var tigoInternacional = '<img src="img/um.svg"><img src="img/ca.svg"><img src="img/pr.svg">';
    var swipeHTML1, swipeHTML2;

    switch (tigo.apps){

        case 'WAFA' :

            appsTigo = '<img src="img/facebook.svg"><img src="img/whatsapp.svg">';

            break;

    }


    switch (claro.apps){

        case 'WAFATW':

            appsClaro = '<img src="img/facebook.svg"><img src="img/whatsapp.svg"><img src="img/twitter.svg">';

            break;


    }


    if(claro.internacional !== '' ){

        claroInternacional = '<img src="img/um.svg"><img src="img/ca.svg"><img src="img/pr.svg">';

    }else{

        claroInternacional = '';

    }

    var html = col2Template({

    col1:tigo.basico,
    col11:claro.basico,
    col2:tigo.datos,
    col21:claro.datos,
    col3:tigo.minutostd,
    col31:claro.minutostd,
    col4:tigo.minutoson,
    col41:claro.minutoson,
    col5:tigoInternacional,
    col51:claroInternacional,
    col6:tigo.beneficios,
    col61:claro.beneficios,
    col7:appsTigo,
    col71:appsClaro,
    col8:tigo.comunidad,
    col81:claro.comunidad,
    col9:tigo.promes,
    col91:claro.promes,

    });


    $('.wrapper-compare').html(html);


    swipeHTML1 = tigoTemplate({

        col1:tigo.basico,
        col2:tigo.datos,
        col3:tigo.minutostd,
        col4:tigo.minutoson,
        col5:tigoInternacional,
        col6:tigo.beneficios,
        col7:appsTigo,
        col8:tigo.comunidad,
        col9:tigo.promes

    });

    $('.tigo').html(swipeHTML1);

    swipeHTML2 = claroTemplate({

        col1:claro.basico,
        col2:claro.datos,
        col3:claro.minutostd,
        col4:claro.minutoson,
        col5:claroInternacional,
        col6:claro.beneficios,
        col7:appsClaro,
        col8:claro.comunidad,
        col9:claro.promes

    });

    $('.claro').html(swipeHTML2);

    $('.movistar').css("display", "none");

    swiper();
}

function Draw3Col (tigo, claro, movistar) {

    var appsTigo;
    var appsClaro;
    var appsMovistar;
    var claroInternacional;
    var tigoInternacional = '<img src="img/um.svg"><img src="img/ca.svg"><img src="img/pr.svg">';
    var movistarInternacional;
    var benefits;

    var swiperHTML1, swiperHTML2;

    var swiperHTML3;

    switch (tigo.apps){

        case 'WAFA' :

            appsTigo = '<img src="img/facebook.svg"><img src="img/whatsapp.svg">';

            break;

    }


    switch (claro.apps){

        case 'WAFATW':

            appsClaro = '<img src="img/facebook.svg"><img src="img/whatsapp.svg"><img src="img/twitter.svg">';

            break;


    }


    switch (movistar.apps){

        case 'WAFATWLI':

            appsMovistar = '<img src="img/facebook.svg"><img src="img/whatsapp.svg"><img src="img/twitter.svg"><img src="img/line.png">';

            break;
		 case 'WAFATWLIWZ':

            appsMovistar = '<img src="img/facebook.svg"><img src="img/whatsapp.svg"><img src="img/twitter.svg"><img src="img/line.png"><img src="img/waze.png">';

            break;



    }


    if(claro.internacional !== '' ){

        claroInternacional = '<img src="img/um.svg"><img src="img/ca.svg"><img src="img/pr.svg">';

    }else{

        claroInternacional = '';

    }


    if(movistar.internacional !== '' ){

        movistarInternacional = '<img src="img/um.svg"><img src="img/ca.svg"><img src="img/pr.svg">';

    }else{

        movistarInternacional = '';

    }


    if(tigo.beneficios === 'code1'){

        benefits = '<img src="img/sports.png"><img src="img/music.png">';


    }else{

        benefits = '2 Apps';


    }

    var html = col3Template({

        col1:tigo.basico,
        col11:claro.basico,
        col12:movistar.basico,
        col2:tigo.datos,
        col21:claro.datos,
        col22:movistar.datos,
        col3:tigo.minutostd,
        col31:claro.minutostd,
        col32:movistar.minutostd,
        col4:tigo.minutoson,
        col41:claro.minutoson,
        col42:movistar.minutoson,
        col5:tigoInternacional,
        col51:claroInternacional,
        col52:movistarInternacional,
        col6:benefits,
        col61:claro.beneficios,
        col62:movistar.beneficios,
        col7:appsTigo,
        col71:appsClaro,
        col72:appsMovistar,
        col8:tigo.comunidad,
        col81:claro.comunidad,
        col82:movistar.comunidad,
        col9:tigo.promes,
        col91:claro.promes,
        col92:movistar.promes,

    });


    $('.wrapper-compare').html(html);

    swiperHTML1 = tigoTemplate({

        col1:tigo.basico,
        col2:tigo.datos,
        col3:tigo.minutostd,
        col4:tigo.minutoson,
        col5:tigoInternacional,
        col6:benefits,
        col7:appsTigo,
        col8:tigo.comunidad,
        col9:tigo.promes

    });

    $('.tigo').html(swiperHTML1);

    swiperHTML2 = claroTemplate({

        col1:claro.basico,
        col2:claro.datos,
        col3:claro.minutostd,
        col4:claro.minutoson,
        col5:claroInternacional,
        col6:claro.beneficios,
        col7:appsClaro,
        col8:promoClaro,
        col9:claro.comunidad,
        col10:claro.promes

    });

    $('.claro').html(swiperHTML2);

    swiperHTML3 = movistarTemplate({

        col1:movistar.basico,
        col2:movistar.datos,
        col3:movistar.minutostd,
        col4:movistar.minutoson,
        col5:movistarInternacional,
        col6:movistar.beneficios,
        col7:appsMovistar,
        col8:movistar.comunidad,
        col9:movistar.promes

    });

    $('.movistar').html(swiperHTML3);

    $('.movistar').css("display", "block");

    swiper();



}

function Draw4Col (tigo, claro, movistar, avantel) {

    var appsTigo;
    var appsClaro;
    var appsMovistar;
    var appsAvantel;
    var claroInternacional;
    var tigoInternacional = '<img src="img/um.svg"><img src="img/ca.svg"><img src="img/pr.svg">';
    var avantelInternacional = '<img src="img/es.svg"><img src="img/mx.svg"><img src="img/um.svg"><img src="img/ca.svg"><img src="img/pr.svg"><img src="img/vi.svg"><img src="img/ch.svg"><img src="img/bz.svg">';
    var movistarInternacional;
    var avantelInternacional;
    var benefits;

    var swiperHTML1, swiperHTML2;

    var swiperHTML3, swiperHTML4;

    switch (tigo.apps){

        case 'WAFA' :

            appsTigo = '<img src="img/facebook.svg"><img src="img/whatsapp.svg">';

            break;

    }


    switch (claro.apps){

        case 'WAFATW':

            appsClaro = '<img src="img/facebook.svg"><img src="img/whatsapp.svg"><img src="img/twitter.svg">';

            break;


    }

    switch (avantel.apps){

        case 'WAFAWZ':

            appsClaro = '<img src="img/whatsapp.svg"><img src="img/facebook.svg"><img src="img/waze.svg">';

            break;


    }

    switch (movistar.apps){

        case 'WAFATWLI':

            appsMovistar = '<img src="img/facebook.svg"><img src="img/whatsapp.svg"><img src="img/twitter.svg"><img src="img/line.png">';

            break;
		 case 'WAFATWLIWZ':

            appsMovistar = '<img src="img/facebook.svg"><img src="img/whatsapp.svg"><img src="img/twitter.svg"><img src="img/line.png"><img src="img/waze.png">';

            break;



    }


    if(claro.internacional !== '' ){

        claroInternacional = '<img src="img/um.svg"><img src="img/ca.svg"><img src="img/pr.svg">';

    }else{

        claroInternacional = '';

    }


    if(movistar.internacional !== '' ){

        movistarInternacional = '<img src="img/um.svg"><img src="img/ca.svg"><img src="img/pr.svg">';

    }else{

        movistarInternacional = '';

    }

    if(movistar.internacional !== '' ){

        movistarInternacional = '<img src="img/um.svg"><img src="img/ca.svg"><img src="img/pr.svg">';

    }else{

        movistarInternacional = '';

    }


    if(tigo.beneficios === 'code1'){

        benefits = '<img src="img/sports.png"><img src="img/music.png">';


    }else{

        benefits = '2 Apps';


    }

    var html = col4Template({

        col1:tigo.basico,
        col11:claro.basico,
        col12:movistar.basico,
        col13:avantel.basico,
        col2:tigo.datos,
        col21:claro.datos,
        col22:movistar.datos,
        col23:avantel.datos,
        col3:tigo.minutostd,
        col31:claro.minutostd,
        col32:movistar.minutostd,
        col33:avantel.minutostd,
        col4:tigo.minutoson,
        col41:claro.minutoson,
        col42:movistar.minutoson,
        col43:avantel.minutoson,
        col5:tigoInternacional,
        col51:claroInternacional,
        col52:movistarInternacional,
        col53:avantelInternacional,
        col6:benefits,
        col61:claro.beneficios,
        col62:movistar.beneficios,
        col63:avantel.beneficios,
        col7:appsTigo,
        col71:appsClaro,
        col72:appsMovistar,
        col73:appsAvantel,
        col8:tigo.comunidad,
        col81:claro.comunidad,
        col82:movistar.comunidad,
        col82:avantel.comunidad,
        col9:tigo.promes,
        col91:claro.promes,
        col92:movistar.promes,
        col92:avantel.promes,

    });


    $('.wrapper-compare').html(html);

    swiperHTML1 = tigoTemplate({

        col1:tigo.basico,
        col2:tigo.datos,
        col3:tigo.minutostd,
        col4:tigo.minutoson,
        col5:tigoInternacional,
        col6:benefits,
        col7:appsTigo,
        col8:tigo.comunidad,
        col9:tigo.promes

    });

    $('.tigo').html(swiperHTML1);

    swiperHTML2 = claroTemplate({

        col1:claro.basico,
        col2:claro.datos,
        col3:claro.minutostd,
        col4:claro.minutoson,
        col5:claroInternacional,
        col6:claro.beneficios,
        col7:appsClaro,
        col8:promoClaro,
        col9:claro.comunidad,
        col10:claro.promes

    });

    $('.claro').html(swiperHTML2);

    swiperHTML3 = movistarTemplate({

        col1:movistar.basico,
        col2:movistar.datos,
        col3:movistar.minutostd,
        col4:movistar.minutoson,
        col5:movistarInternacional,
        col6:movistar.beneficios,
        col7:appsMovistar,
        col8:movistar.comunidad,
        col9:movistar.promes

    });

    $('.movistar').html(swiperHTML3);

    swiperHTML4 = avantelTemplate({

        col1:avantel.basico,
        col2:avantel.datos,
        col3:avantel.minutostd,
        col4:avantel.minutoson,
        col5:avantelInternacional,
        col6:avantel.beneficios,
        col7:appsAvantel,
        col8:avantel.comunidad,
        col9:avantel.promes

    });

    $('.avantel').html(swiperHTML4);

    $('.movistar').css("display", "block");

    swiper();



}





})(jQuery);
