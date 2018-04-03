(function ($) {

    var eventsDates = [];

    $(document).ready(function () {
        generate_datepicker($("#plnr-datepicker-container"));
        load_event_list_html();
    });

    $(document).on('click', '.pnlr-event-focus', function (e) {
        var trigger = e.target;
        var dayItem = $(trigger).closest('.plnr-day-item');

        if (dayItem.hasClass('highlight')) {
            return;
        }

        highlight_day(dayItem);
        var date = new_date(dayItem.data('date'));
        datepicker_set_date(date);
    });


    $('.plnr-load-users').on('change', function () {
        var trainerList = $('#plnr-admin-trainers');
        var trainers = $('option', trainerList);

        trainers.show();
        trainerList.prop('selectedIndex', 0);

        $('.plnr-title-bar h2').text("Actividades");
        eventsDates = [];
        $("#plnr-datepicker-container").datepicker("refresh");

        var downloadButton = $('#plnr-download-trainer-events');

        downloadButton.data('year', '');
        downloadButton.data('month', '');
        downloadButton.data('user', '');

        load_event_list_html();

        var bu = $('#plnr-admin-bu').val();
        var regional = $('#plnr-admin-regional').val();
        var i;

        if (bu != null && regional == null){
            for (i = 0; i < trainers.length; i++) {
                if ($(trainers[i]).data('bu') != bu){
                    $(trainers[i]).hide();
                }
            }
        } else if (bu == null && regional != null){
            for (i = 0; i < trainers.length; i++) {
                if ($(trainers[i]).data('regional') != regional){
                    $(trainers[i]).hide();
                }
            }
        } else if (bu != null && regional != null){
            for (i = 0; i < trainers.length; i++) {
                if ($(trainers[i]).data('regional') != regional || $(trainers[i]).data('bu') != bu){
                    $(trainers[i]).hide();
                }
            }
        }


    });

    $('#plnr-admin-trainers').on('change', function () {
        if ($(this).val() == null || $(this).val() == '') {
            return;
        }
        load_event_list_html();
    });

    $(document).on('click', '#plnr-download-trainer-events', function (e) {
        e.preventDefault();
        console.log($(this).data());
        if (!$(this).data('year') || !$(this).data('month') || !$(this).data('user')) {
            window.alert('Selecciona un entrenador');
            return;
        }

        var args = {
            "year": $(this).data('year'),
            "month": $(this).data('month'),
            "user_id": $(this).data('user')
        };

        var recursiveEncoded = $.param(args);
        var href = $(this).attr('href');
        href += "?" + recursiveEncoded;
        window.location = href;
    });

    $(document).on('click', '#plnr-download-regional-events', function (e) {
        e.preventDefault();
        var bu = $('#plnr-dashboard-regional-download-bu').val();
        var regional = $('#plnr-dashboard-regional-download').val();
        var year = $('#plnr-dashboard-regional-download-year').val();
        var month = $('#plnr-dashboard-regional-download-month').val();

        var args = {
            "year": year,
            "month": month,
            "user_id": "ALL",
            "regional": regional,
            "bu": bu
        };

        var recursiveEncoded = $.param(args);
        var href = $(this).attr('href');
        href += "?" + recursiveEncoded;
        window.location = href;
    });

    function generate_datepicker(elem) {

        if (elem.length == 0) {
            return;
        }

        elem.datepicker({
            nextText: '<span class="icon-angle-right"></span>',
            prevText: '<span class="icon-angle-left"></span>',
            dateFormat: "yy/mm/dd",
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
            dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
            minDate: new Date(2016, 3 - 1, 1),

            onChangeMonthYear: _.debounce(function (year, month) {
                load_event_list_html(year, month);
            }, 300),

            onSelect: function (date) {
                var item = get_item_of_date(new Date(date));
                scroll_to_day(item, true);
            },

            beforeShowDay: function (date) {

                var holidays = [
                    '2016-1-1',
                    '2016-1-11',
                    '2016-3-21',
                    '2016-3-24',
                    '2016-3-25',
                    '2016-5-9',
                    '2016-5-30',
                    '2016-6-6',
                    '2016-7-4',
                    '2016-7-20',
                    '2016-8-15',
                    '2016-10-17',
                    '2016-11-07',
                    '2016-11-14',
                    '2016-12-8'
                ];

                var formated = date_format_to_standard(new Date(date));

                if (date.getDay() == 0 || holidays.indexOf(formated) != -1) {
                    return [false, ''];
                }

                if (eventsDates != false && eventsDates.indexOf(formated) != -1) {
                    return [true, 'has-events'];
                }

                return [true, ''];
            }
        });
    }

    function get_item_of_date(date) {
        return $('[data-date="' + date_format_to_standard(date) + '"]');
    }

    function date_format_to_standard(date) {
        return date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate();
    }

    function new_date(dateString) {
        var date = dateString.split('-');
        return new Date(date[0], date[1] - 1, date[2]);
    }

    function load_event_list_html(year, month) {

        var dateList = $('#plnr-event-list');

        dateList.html('');

        var selecTrainerEl = $('#plnr-admin-trainers');
        var selecTrainer = selecTrainerEl.val();

        if (selecTrainer == null || selecTrainer == '') {
            dateList.html("<div>Selecciona un entrenador</div>");
            return;
        }

        preloader_in(dateList);

        if (typeof year == 'undefined' || typeof month == 'undefined') {
            year = 0;
            month = 0;
        }

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_planner.ajaxurl,
            data: {
                action: ajax_planner.action,
                nonce: ajax_planner.nonce,
                directive: 'get_events_ui_no_edit',
                year: year,
                month: month,
                user: selecTrainer
            },

            success: function (response) {
                dateList.html(response.html);
                dateList.scrollTop(0);
                preloader_out(dateList);

                var today = get_item_of_date(new Date(response.today));
                scroll_to_day(today, false);
                get_events_dates(response.events);

                var selectTrainerName = $('option:selected', selecTrainerEl).text();
                var EventBrowserTitle = $('.plnr-title-bar h2');
                EventBrowserTitle.html('Actividades - ' + selectTrainerName);

                if (year == 0 || month == 0) {
                    year = new_date(response.today).getFullYear();
                    month = new_date(response.today).getMonth();
                    month = month + 1;
                }

                set_trainer_query_data(year, month, selecTrainer);
            },

            error: function (xhr, status, error) {
                console.log(error);
                preloader_out(dateList);
            }
        });
    }

    function get_events_dates(events) {

        if (Array.isArray(events) && events.length > 0) {
            var dates = [];

            for (var i = 0; i < events.length; i++) {
                dates.push(events[i].date);
            }
            eventsDates = dates;

        } else if (typeof events === 'object') {
            eventsDates.push(events.date);
        }
        $("#plnr-datepicker-container").datepicker("refresh");
    }

    function scroll_to_day(item, animate) {

        if (item.length > 0) {

            highlight_day(item);
            var date = new_date(item.data('date'));
            datepicker_set_date(date);

            var dateList = $('#plnr-event-list');
            var scrollPos = dateList.scrollTop() + item.position().top;

            if (animate) {
                dateList.animate({
                    scrollTop: scrollPos
                }, 'fast');
            } else {
                dateList.scrollTop(scrollPos);
            }
            return item;
        }
        return false;
    }

    function highlight_day(item) {
        $('.plnr-day-item').removeClass('highlight');
        $(item).addClass('highlight');
    }

    function datepicker_set_date(date) {
        $("#plnr-datepicker-container").datepicker("setDate", date)
    }

    function preloader_in(container) {
        container.prepend('<div id="plnr-loader-shadow">' +
            '<div class="plnr-spinner-wrapper">' +
            '<svg class="spinner" width="40px" height="40px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg"> ' +
            '<circle class="path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle>' +
            '</svg></div></div>');
    }

    function preloader_out(container) {
        container.find('#plnr-loader-shadow').remove();
    }

    function set_trainer_query_data(year, month, user) {
        var downloadButton = $('#plnr-download-trainer-events');

        downloadButton.data('year', year);
        downloadButton.data('month', month);
        downloadButton.data('user', user);
    }

})(jQuery);