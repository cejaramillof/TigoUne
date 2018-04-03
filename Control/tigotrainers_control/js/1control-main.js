(function ($) {

    $(document).ready(function () {
        refreshRegList();
        checkGPS();
    });

    function refreshRegList() {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_control.ajaxurl,
            data: {
                action: ajax_control.action,
                nonce: ajax_control.nonce,
                directive: 'get_last_reg'
            },

            success: function (respond) {
                if (respond.length == 0) {
                    return;
                }
                var regList = $('#main-reg-list-container');
                var table = '<table><thead><tr><th>Fecha</th><th>ID</th><th>Formulario</th><th>Duración</th></tr></thead><tbody>';
                for (var i = 0; i < respond.length; i++) {
                    var date = respond[i].timestamp.split('/');
                    var inputDate = new Date(date[2], date[1] - 1, date[0]).toDateString();
                    var todaysDate = new Date().toDateString();
                    if (inputDate == todaysDate) {
                        thedate = "Hoy";
                    } else {
                        thedate = date.join('/');
                    }
                    table += '<tr><td>' + respond[i].timestamp + '</td><td>' + respond[i].id + '</td><td>' + respond[i].form + '</td><td>' + respond[i].training_time.toUpperCase() + '</td></tr>';
                }
                table += '<tbody>';
                regList.html(table);
            },

            error: function (xhr, status, error) {
                console.log(error);
            }
        });
    }

    $(document).on('click', '.control-open-form', function (e) {
        e.preventDefault();
        var that = $(this);

        setTimeout(function () {
            var pane = renderFullScreenPane();
            var pane_header = pane.find('.fullscreen-pane-header');
            var title = that.clone().children().remove().end().text();

            pane_header.prepend('<span class="control-form-title">' + title + '</span>');
            loadForm(that.data('form'), pane);
        }, 300);
    });

    $(document).on('click', 'input[type="radio"]', function () {
        if ($(this).data('flow')) {
            loadFormItems($(this), $('input[name="form_name"]').val());
        }
    });

    $(document).on('click', '#control-form-submit', function (e) {
        e.preventDefault();
        if ($(this).hasClass('sending')) return;
        $(this).addClass('sending');
        $(this).text('Enviando...');
        submitForm($(this));
    });

    $(document).on('input', '.control-form-item input[type=range]', function () {
        var label = $(this).next();
        label.html($(this).val())
    });

    $(document).on('click', '.control-form-datepicker', function (e) {
        e.preventDefault();
        renderDatePicker($(this));
    });

    $(document).on('click', '.control-form-item-multidata-add-data', function (e) {
        e.preventDefault();
        renderMultiData($(this));
    });

    $(document).on('click', '.control-form-item-multidata-delete-data', function () {
        $(this).closest('.control-form-item-multidata-staked-value').remove();
    });

    $(document).on("keypress", ":input:not(textarea)", function (event) {
        if (event.keyCode == 13) {
            event.preventDefault();
        }
    });

    $(document).on('click', '.item-description-info', function(e){
        e.preventDefault();
        var title = 'Ayuda';
        var content = $(this).find('.item-description-content').html();
        renderModalBox(title, content);
    });

    function loadForm(form, pane) {
        pane.find('.fullscreen-pane-content').html('Cargando ' + form + '...');
        $.ajax({
            type: 'POST',
            dataType: 'html',
            url: ajax_control.ajaxurl,
            data: {
                action: ajax_control.action,
                nonce: ajax_control.nonce,
                directive: 'get_forms',
                form: form
            },

            success: function (respond) {
                renderForm(respond, pane);
            },

            error: function (xhr, status, error) {
                console.log(error);
            }
        });
    }

    function renderForm(respond, pane) {
        var pane_content = pane.find('.fullscreen-pane-content');
        pane_content.html(respond);
        var form = pane_content.find('form');
        renderFormUI(form);
    }

    function loadFormItems(trigger, form) {
        var initItem = trigger.data('flow');

        $.ajax({
            type: 'POST',
            dataType: 'html',
            url: ajax_control.ajaxurl,
            data: {
                action: ajax_control.action,
                nonce: ajax_control.nonce,
                directive: 'get_form_items',
                form: form,
                initItem: initItem
            },

            success: function (respond) {
                renderFormItems(trigger, respond);
            },

            error: function (xhr, status, error) {
                console.log(error);
            }
        });
    }

    function renderFormItems(trigger, html) {
        var control_block = trigger.closest('.control-form-block');
        var form = control_block.closest('form');
        if (control_block.next('.control-form-block').length == 0) {
            form.append(html);
        } else {
            control_block.nextAll().remove();
            form.append(html);
        }
        renderFormUI(form);
    }

    function renderFormUI(form) {
        var ranges = form.find('input[type=range]');
        var multidatas = form.find('[data-multidata]');

        multidatas.each(function () {
            var container = '<div class="control-form-item-multidata"></div>';
            var stackContainer = '<div class="control-form-item-multidata-stacked-container"></div>';
            $(this).wrap(container);
            $(this).closest('label').before(stackContainer);
            $(this).css({'width': '85%', 'float': 'left'});
            $(this).after('<a class="control-form-item-multidata-add-data ttr-icon-plus-circled" href="#"></a>')
        });

        $('input[type=range], input[type=radio], input[type=checkbox], [data-multidata]').closest('.control-form-item').css({
            'border-bottom': '1px solid #eaeaea'
        });

        ranges.each(function (i, r) {
            var range = $(r);
            var max = range.attr('max');
            var min = range.attr('min');
            var step = range.attr('step');
            var label = $('<div class="control-form-range-value"</div>');
            var rangeValue = range.val();
            range.after(label);

            label.css({
                'font-size': '1.2rem',
                'margin-top': '8px'
            });

            label.html(rangeValue);
        });

        $('.item-boolean label:first-child span').text('Si');
        $('.item-boolean label:last-child span').text('No');
    }

    function submitForm(s) {
        var form = s.closest('form');
        if (!form.is('form')) {
            return;
        }

        clearErrorMessages();

        var formItems = form.find('input, textarea, select').not('input[type="submit"]');
        var emptyFields = [];

        formItems.each(function () {

            var fieldVal = '';
            var fieldName = $(this).attr('name');
            var item = $(this).closest('.control-form-item');
            var required = item.is('[data-required]');

            switch ($(this).attr('type')) {
                case 'radio':
                case 'checkbox':
                    fieldVal = $('input[name="' + fieldName + '"]:checked').val();
                    if (!fieldVal && required) {
                        var optionalVal = $('[data-optional]', item);
                        if (optionalVal.length == 0) {
                            emptyFields.push({"id": fieldName, "error_code": '001'})
                        } else if ($('[data-optional]', item).val() === '') {
                            emptyFields.push({"id": fieldName, "error_code": '001'});
                        }
                    }
                    break;

                default:
                    fieldVal = $(this).val();

                    if ($(this).is('[data-multidata]')) {
                        var items = $(this).closest('.control-form-item').find('.control-form-item-multidata-staked-value');
                        if (items.length == 0) {
                            emptyFields.push({"id": fieldName, "error_code": '001'});
                        }
                        break;
                    }

                    if (!fieldVal && required) {
                        if (!$(this).is('[data-optional]')) {
                            emptyFields.push({"id": fieldName, "error_code": '001'});
                        }
                    }
                    break;
            }
        });

        if (emptyFields.length > 0) {

            emptyFields.sort(function (a, b) {
                return a.id - b.id;
            });

            for (var i = 0; i < emptyFields.length - 1; i++) {
                if (emptyFields[i].id == emptyFields[i + 1].id) {
                    delete emptyFields[i];
                }
            }
            emptyFields = emptyFields.filter(function (el) {
                return (typeof el !== "undefined");
            });

            renderErrorMessages(emptyFields);
            s.removeClass('sending');
            s.text('Enviar');
            return;
        }

        var formData = form.find('input, textarea, select').not('[data-multidata]').serializeArray();
        var formObj = {};
        var multidata = $('[data-multidata]');

        multidata.each(function () {
            var items = $(this).closest('.control-form-item').find('.control-form-item-multidata-staked-value span');
            items.each(function () {
                var data = {
                    name: $(this).attr('data-name'),
                    value: $(this).text()
                };
                formData.push(data);
            })
        });

        $.each(formData, function (i, obj) {
            if (obj.value == '') {
                return;
            }
            if (formObj[obj.name]) {
                if (typeof formObj[obj.name] == 'string') {
                    formObj[obj.name] = [formObj[obj.name]];
                    formObj[obj.name].push(obj.value);
                } else {
                    formObj[obj.name].push(obj.value);
                }
            } else {
                formObj[obj.name] = obj.value;
            }
        });

        sendForm(formObj, s);
    }

    function sendForm(formObj, s) {

        if (!navigator.geolocation) {
            alert('Geolocation is not supported for this Browser/OS version yet.');
        }

        else {

            var geoOptions = {
                enableHighAccuracy: true,
                timeout: 30000,
                maximumAge: 3000
            };
            var geoSuccess = function (position) {
                formObj.coordinates = {
                    latitude: position.coords.latitude,
                    longitude: position.coords.longitude
                };

                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: ajax_control.ajaxurl,
                    data: {
                        action: ajax_control.action,
                        nonce: ajax_control.nonce,
                        directive: 'submit_form_items',
                        form: formObj
                    },
                    success: function (respond) {
                    	console.log(respond.status);
                        switch (respond.status) {
                        	case 'reg_error':
                                renderModalBox('Error de sesión', 'Estás desconectado. Cierra sesión en Tigotrainers e ingresa nuevamente.');
                                closeFullScreenPane(s);
                                refreshRegList();
                                break;
                            case 'error_fields':
                                renderErrorMessages(respond[0]);
                                s.removeClass('sending');
                                s.text('Enviar');
                                return;
                                break;
                            case 'not_approved':
                                renderModalBox('OK', 'Formulario registrado con éxito. No se tendrán en cuenta horas de productividad generadas por registro extemporáneo.');
                                closeFullScreenPane(s);
                                refreshRegList();
                                break;
                            case 'ok':
                                renderModalBox('OK', 'Has registrado tu formulario con éxito.');
                                closeFullScreenPane(s);
                                refreshRegList();
                                break;
                            default:
                                renderModalBox('Oops!', 'Hubo un error enviando el formulario, inténtalo nuevamente.');
                                s.removeClass('sending');
                                s.text('Enviar');
                                break;
                        }

                    },
                    error: function (xhr, status, error) {
                        console.log(error);
                    }
                });
            };

            var geoError = function (error) {
                switch (error.code) {
                    case 0:
                        renderModalBox('Error de GPS', 'Error Desconocido. Debes tener el sensor GPS de tu equipo encendido y aceptar los permisos de localización para enviar el formulario.');
                        s.removeClass('sending');
                        s.text('Enviar');
                        break;
                    case 1:
                        renderModalBox('Error de GPS', 'Permiso Denegado. Debes tener el sensor GPS de tu equipo encendido y aceptar los permisos de localización para enviar el formulario.');
                        s.removeClass('sending');
                        s.text('Enviar');
                        break;
                    case 2:
                        renderModalBox('Error de GPS', 'Posición no disponible. Debes tener el sensor GPS de tu equipo encendido y aceptar los permisos de localización para enviar el formulario.');
                        s.removeClass('sending');
                        s.text('Enviar');
                        break;
                    case 3:
                        renderModalBox('Error de GPS', 'Tiempo de espera agotado. Debes tener el sensor GPS de tu equipo encendido y aceptar los permisos de localización para enviar el formulario.');
                        s.removeClass('sending');
                        s.text('Enviar');
                        break;
                    default:
                        renderModalBox('Error de GPS', 'Debes tener el sensor GPS de tu equipo encendido y aceptar los permisos de localización para enviar el formulario.');
                        s.removeClass('sending');
                        s.text('Enviar');
                        break;
                }
            };
            return navigator.geolocation.getCurrentPosition(geoSuccess, geoError, geoOptions);
        }

    }

    function renderDatePicker(input) {

        var modal = renderModalBox('Selecciona una fecha', '<div id="control-form-datepicker"></div>');

        modal.css('max-width', '300px');

        $('#control-form-datepicker').datepicker({
            nextText: '<i class="ttr-icon-angle-right"></i>',
            prevText: '<i class="ttr-icon-angle-left"></i>',
            dateFormat: "dd/mm/yy",
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
            dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
            onSelect: function (date) {
                input.val(date);
                setTimeout(function () {
                    closeModalBox(modal);
                }, 300);
                $('#control-form-datepicker').datepicker("option", "disabled", true);
            }
        });
    }

    function renderMultiData(a) {
        var input = a.prev();
        if (input.val() == '') {
            return;
        }

        var value = input.val();
        var name = input.attr('name');
        var stackedVal = '<div class="control-form-item-multidata-staked-value"><span data-name="' + name + '">' + value + '</span><i class="control-form-item-multidata-delete-data ttr-icon-close-round"></i></div>';
        var stackedContainer = input.closest('.control-form-item').find('.control-form-item-multidata-stacked-container');

        stackedContainer.append(stackedVal);
        input.val('');
        input.focus();
    }

    function clearErrorMessages() {
        $('.control-form-bubble-message-container').remove();
    }

    function renderErrorMessages(items) {
        var errorCodes = {
            '001': 'Campo obligatorio',
            '002': 'Formato de fecha inválido.',
            '003': 'Cédula inválida',
            '004': 'Número móvil inválido.'
        };

        if (Object.prototype.toString.call(items) === '[object Object]') {
            renderErrorBubble(items);
        } else if (Object.prototype.toString.call(items) === '[object Array]') {
            $.each(items, function (i, el) {
                renderErrorBubble(el);
            });
        }

        var firstError = $('.control-form-bubble-message-container').first().closest('.control-form-item');
        var firstErrorPos = firstError.offset();
        var scrollParent = firstError.scrollParent();
        var scroll = scrollParent.scrollTop() - (firstErrorPos.top * -1) - 50;
        scrollParent.animate({scrollTop: scroll}, 600, 'swing');

        function renderErrorBubble(el) {
            var empty = $('[data-id="' + el.id + '"]');
            var message = '<div class="control-form-bubble-message-container"><div class="control-form-bubble-message">' + errorCodes[el.error_code] + '</div></div>';
            empty.append(message);
        }
    }

    function checkGPS() {
        var gps = $('#gps-check');
        if (!navigator.geolocation) {
            alert('Geolocation is not supported for this Browser/OS version yet.');
            return;
        }

        var geoOptions = {
            enableHighAccuracy: true,
            timeout: 30000,
            maximumAge: 3000
        };

        var geoSuccess = function (position) {
            gps.removeClass('error');
        };

        var geoError = function (error) {
            gps.addClass('error');
        };
        return navigator.geolocation.getCurrentPosition(geoSuccess, geoError, geoOptions);
    }


    /*$(function () {

        var proyectado = Number($("#val-proyectado").attr('data-value'));
        var cumplimiento = Number($("#val-cumplimiento").attr('data-value'));

        console.log(proyectado, cumplimiento);

        Highcharts.chart('control-gauge', {

            chart: {
                type: 'solidgauge',
                marginTop: 0
            },

            title: false,

            credits: false,

            pane: {
                center: ['50%', '100%'],
                size: '160%',
                startAngle: -90,
                endAngle: 90,
                background: {
                    backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || '#EEE',
                    innerRadius: '50%',
                    outerRadius: '100%',
                    shape: 'arc'
                }
            },

            yAxis: {
                min: 0,
                max: 120,
                stops: [
                    [0.6, '#DF5353'], // red
                    [0.7, '#DDDF0D'], // yellow
                    [0.9, '#55BF3B'] // green
                ],
                labels:{
                    enabled:true,
                    distance: 16
                },
                lineWidth: 2,
                minorTickInterval: null,
                tickPixelInterval: 40,
                tickWidth: 1
            },

            series: [
                {
                    name: 'Proyectado',
                    data: [proyectado],
                    dataLabels: false,
                    radius: 90,
                    innerRadius: 76
                },
                {
                    name: 'Cumplimiento',
                    data: [cumplimiento],
                    dataLabels: false,
                    radius: 70,
                    innerRadius: 56
                }
            ],

            tooltip: false
        });


    });*/


})(jQuery);


