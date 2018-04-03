(function ($) {

    var eventsDates = [];

    $(document).ready(function () {
        generate_datepicker($("#plnr-datepicker-container"));
        load_event_list_html();
        load_planner_info();
    });

    $(document).on('click', '#plnr-download-events', function(e){
        e.preventDefault();
        var args = {
            "year" : $(this).data('year'),
            "month" : $(this).data('month'),
            "user_id": $(this).data('user')
        };

        var recursiveEncoded = $.param( args );
        var href = $(this).attr('href');
        href += "?"+recursiveEncoded;
        window.location = href;
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

    $(document).on('click', '.plnr-day-item-add-event', function () {

        var editForm = $('.plnr-event-edit');
        var editingItem = editForm.closest('.plnr-day-item');

        if (editForm.length > 0) {
            var r = confirm("Tienes una actividad sin guardar. ¿Deseas eliminarla?");

            if (r == true) {
                editForm.remove();
            } else {
                scroll_to_day(editingItem, true);
                return;
            }
        }

        editingItem = $(this).closest('.plnr-day-item');
        var template = $('#tmpl-edit-event');
        var compTemplate = _.template(template.html());
        var html = compTemplate({date: $(editingItem).data('date')});
        $(this).before(html);

    });

    $(document).on('change', '#plnr-event-edit-poscode', _.debounce(function () {
        var txt = $(this).val();
        load_poscode_info(txt);
    }, 500));

    $(document).on('click', '.form-submit', function () {
        var form = $(this).closest('form');
        var eventEdit = $(this).closest('.plnr-event-edit');
        var disabledItems = $(':disabled', form);

        disabledItems.prop('disabled', false);
        var formData = form.serialize();
        disabledItems.prop('disabled', true);

        save_event(formData, eventEdit);
    });

    $(document).on('click', '.plnr-event-item-discard', function () {
        var r = confirm("¿Deseas eliminar esta actividad?");
        var event = $(this).closest('.plnr-event-item');
        if (r == true) {
            delete_event(event);
        }
    });

    $(document).on('click', '.form-discard', function () {
        var item = $(this).closest('.plnr-day-item');
        $(this).closest('.plnr-event-edit').remove();
        scroll_to_day(item, true);

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

    function new_date(dateString){
        var date = dateString.split('-');
        return new Date(date[0],date[1]-1,date[2]);
    }

    function load_event_list_html(year, month) {

        eventsDates = []; /*reset events*/

        preloader_in($('#plnr-event-list'));

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
                directive: 'get_events_ui',
                year: year,
                month: month
            },

            success: function (response) {
                var dateList = $('#plnr-event-list');
                dateList.html(response.html);
                dateList.scrollTop(0);
                preloader_out(dateList);
                var today = get_item_of_date(new Date(response.today));
                scroll_to_day(today, false);
                get_events_dates(response.events);
                set_query_data(year, month);
            },

            error: function (xhr, status, error) {
                console.log(error);
                preloader_out($('#plnr-event-list'));
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

    function load_planner_info() {
        $.ajax({
            type: 'POST',
            dataType: 'html',
            url: ajax_planner.ajaxurl,
            data: {
                action: ajax_planner.action,
                nonce: ajax_planner.nonce,
                directive: 'get_planner_info'
            },

            success: function (response) {
                $('#plnr-info-wrapper').html(response);
            },

            error: function (xhr, status, error) {
                console.log(error);
            }
        });
    }

    function load_poscode_info(val) {

        $('#plnr-event-edit-poscode_name').prop('disabled', true);
        $('#plnr-event-edit-channel').prop('disabled', true);
        $('#plnr-event-edit-regional').prop('disabled', true);
        $('#plnr-event-edit-department').prop('disabled', true);
        $('#plnr-event-edit-city').prop('disabled', true);

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_planner.ajaxurl,
            data: {
                action: ajax_planner.action,
                nonce: ajax_planner.nonce,
                directive: 'get_poscode_info',
                data: val
            },

            success: function (response) {
                if (response == false) {
                    $('#plnr-event-edit-poscode_name').prop('disabled', false).val('');
                    $('#plnr-event-edit-channel').prop('disabled', false).val('');
                    $('#plnr-event-edit-regional').prop('disabled', false).val('');
                    $('#plnr-event-edit-department').prop('disabled', false).val('');
                    $('#plnr-event-edit-city').prop('disabled', false).val('');
                } else {
                	console.log(response);
                    $('#plnr-event-edit-poscode_name').val(response.poscode_name);
                    $('#plnr-event-edit-channel').val(response.channel);
                    $('#plnr-event-edit-regional').val(response.regional);
                    $('#plnr-event-edit-department').val(response.department);
                    $('#plnr-event-edit-city').val(response.city);
                }
            },

            error: function (xhr, status, error) {
                console.log(error);
            }
        });
    }

    function save_event(data, evEdit) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_planner.ajaxurl,
            data: {
                action: ajax_planner.action,
                nonce: ajax_planner.nonce,
                directive: 'save_event',
                data: data
            },

            success: function (response) {
                if (response == "Empty parameters") {
                    window.alert('¡Debes diligenciar todos los campos!');
                    return;
                }

                if (response == false) {
                    window.alert('Hubo un error al guardar el registro. Intenta nevamente.')
                }

                var dayItemEvents = evEdit.closest('.plnr-day-item').find('.plnr-day-item-events');
                dayItemEvents.append(response.html);
                get_events_dates(response.event);
                evEdit.remove();
            },

            error: function (xhr, status, error) {
                console.log(error);
            }
        });
    }

    function delete_event(event) {

        var id = event.data('id');

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_planner.ajaxurl,
            data: {
                action: ajax_planner.action,
                nonce: ajax_planner.nonce,
                directive: 'delete_event',
                data: id
            },

            success: function (response) {

                if (response == false) {
                    window.alert('Hubo un error al eliminar el registro. Intenta nevamente.')
                }

                var date = event.closest('.plnr-day-item').data('date');

                if (eventsDates.indexOf(date) > -1) {
                    var index = eventsDates.indexOf(date);
                    eventsDates.splice(index, 1);
                    $("#plnr-datepicker-container").datepicker("refresh");
                }

                event.remove();
            },

            error: function (xhr, status, error) {
                console.log(error);
            }
        });
    }

    function set_query_data(year, month){
        var downloadButton = $('#plnr-download-events');
        downloadButton.data('year', year);
        downloadButton.data('month', month);
    }

})(jQuery);