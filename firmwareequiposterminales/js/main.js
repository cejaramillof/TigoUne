/**
 * Created by cperezgo1 on 25/01/17.
 */

(function ($) {

var tablaTemplate = _.template($('#tabla').html());
var itemTemplate = _.template($('#itemTabla').html());
var codeItemTemplate = _.template($('#codeLi').html());
var codeItemListTemplate = _.template($('#codeUL').html());

var codesJSON = "CODES.json";
//var codesJSON = "https://www.tigounetrainers.com/wp-content/uploads/2018/01/firmwareequiposterminales/CODES.json";
var codesProcess;
var html = '';
var tablaHtml = '';


$.getJSON(codesJSON, function (data) {


    codesProcess = data;
    console.log(codesProcess);
    tableBorn();

});


function tableBorn () {



$.each(codesProcess, function (index, item) {

    html += itemTemplate({

        codeMark: item.Brand,
        codeReference: item.Brand2
    })

});

if(html != ''){

    tablaHtml += tablaTemplate({

        codeItem: html

    })

    $('.wrapper').html(tablaHtml);
    pag();
}



}


// When document is ready: this gets fired before body onload 🙂



    $(document).ready(function(){

        // Write on keyup event of keyword input element

        $("#kwd_search").keyup(function(){

            var table = $("#my-table");

            // When value of the input is not blank

            if( $(this).val() != "")
            {
                // Show only matching TR, hide rest of them

                table.find("tbody>tr").hide();
                table.find("td:contains-ci('" + $(this).val() + "')").parent("tr").show();

            }
            else
            {
                // When there is no input or clean again, show everything back

                $("#my-table tbody>tr").show();
            }
        });
    });


// jQuery expression for case-insensitive filter


    $.extend($.expr[":"],
        {
            "contains-ci": function(elem, i, match, array)
            {
                return (elem.textContent || elem.innerText || $(elem).text() || "").toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
            }
        });



//
//
//

// pagination

    function pag () {


        $('table.paginated').each(function() {
        var currentPage = 0;
        var numPerPage = 90;
        var $table = $(this);
        $table.bind('repaginate', function() {
            $table.find('tbody tr').hide().slice(currentPage * numPerPage, (currentPage + 1) * numPerPage).show();
        });
        $table.trigger('repaginate');
        var numRows = $table.find('tbody tr').length;
        var numPages = Math.ceil(numRows / numPerPage);
        var $pager = $('<div class="pager"></div>');
        for (var page = 0; page < numPages; page++) {
            $('<span class="page-number"></span>').text(page + 1).bind('click', {
                newPage: page
            }, function(event) {
                currentPage = event.data['newPage'];
                $table.trigger('repaginate');
                $(this).addClass('active').siblings().removeClass('active');
            }).appendTo($pager).addClass('clickable');
        }
        $pager.insertBefore($table).find('span.page-number:first').addClass('active');
    });


    }

// end pagination

    $(document).on('click', '.imgCode', function () {



  var value =  $(this).data('valor');
  var codeText;
  var HTMLUL = '';
  var HTMLCODES = '';

    $.each(codesProcess, function (index, item) {

        if(item.Brand == value){


            for(var i = 1; i <= 31; i ++){

                codeText = 'code'+i;

                if(item[codeText] != null){

                HTMLUL += codeItemTemplate ({

                   code: item[codeText]

                });

                }
            }

            HTMLCODES += codeItemListTemplate({

               items: HTMLUL,
                brand: item.Brand,
                brand2: item.Brand2

            });

            $('.descriptionGroup').html(HTMLCODES);
            $('#lightbox-1').attr('checked', true);

        }


    });





    });


    $(document).on('click', '.back', function () {


        $('#lightbox-1').attr('checked', false);


    });


})(jQuery);
