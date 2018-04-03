(function ($) {
    $(document).ready(function () {
        generate_datepicker($(".date-picker"));
    });

    function generate_datepicker(elem) {
        if (elem.length) {
            elem.datepicker({
                nextText: '<i class="ttr-icon-angle-right"></i>',
                prevText: '<i class="ttr-icon-angle-left"></i>',
                dateFormat: "dd/mm/yy",
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
                dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S']
            });
            var datepicker = $('#ui-datepicker-div');
            datepicker.wrap('<div class="hasDatepicker"></div>');
            datepicker.attr('data-role', 'none');
        }
    }

    $(document).on('click', '#form-submit', function (e) {
        e.preventDefault();
        $('#form-novelty').submit();
    });

    $(document).on('click', '#download-submit', function (e) {
        e.preventDefault();
        $('#control-download-form').submit();
    });

    $(document).on('change', '#select-regional', function () {
        var table = $('#control-trainer-results-trainer');
        var tableBody = $('tbody', table);
        var rows = $('tr td:first-child', tableBody);
        var selected = $(this).val();

        if (selected == "ALL") {
            tableBody.find('tr').css('display', 'table-row');
            return;
        }

        tableBody.find('tr').css('display', 'none');
        for (var i = 0; i < rows.length; i++) {
            var rowText = $(rows[i]).text();
            if (rowText.indexOf(selected) != -1) {
                $(rows[i]).closest('tr').css('display', 'table-row');
            }
        }
    });

    $(document).ready(function () {
        var kpiData = $('.kpi-data');
        for (var i = 0; i < kpiData.length; i++) {
            var el = $(kpiData[i]);
            var kpi = parseFloat(el.text());
            if (kpi < 80) {
                el.addClass('kpi-danger');
            } else if (kpi > 80 && kpi < 100) {
                el.addClass('kpi-caution');
            } else {
                el.addClass('kpi-ok');
            }
        }
    });


    $(function () {

        var days = [];
        var hours = [];
        var forvas07 = [];
        var forvas33 = [];
        var forvas34 = [];
        var forvas35 = [];

        for (var i = 0; i < daysMonth; i++) {
            days[i] = i + 1;
        }

        for (var j = 0; j < daysMonth; j++) {
            var index = (j + 1) + '';

            if (hoursData[index] == null) {
                hours[j] = 0;
            } else {
                hours[j] = parseFloat(hoursData[index]);
            }

            if (forvas07Data[index] == null) {
                forvas07[j] = 0;
            } else {
                forvas07[j] = Number(forvas07Data[index]);
            }

            if (forvas33Data[index] == null) {
                forvas33[j] = 0;
            } else {
                forvas33[j] = Number(forvas33Data[index]);
            }

            if (forvas34Data[index] == null) {
                forvas34[j] = 0;
            } else {
                forvas34[j] = Number(forvas34Data[index]);
            }

            if (forvas35Data[index] == null) {
                forvas35[j] = 0;
            } else {
                forvas35[j] = Number(forvas35Data[index]);
            }

        }

        $('#chart-time').highcharts({
            chart: {
                type: 'column'
            },
            legend: {
                enabled: false
            },

            title: {
                text: '',
                style: {
                    display: 'none'
                }
            },

            credits: false,

            xAxis: {
                categories: days,
                title: {
                    text: 'Días del mes'
                }
            },

            yAxis: {
                title: {
                    text: 'Horas'
                },
                tickInterval: 1,
                gridLineColor: '#eaeaea'
            },

            plotOptions: {
                column: {
                    dataLabels: {
                        useHMTL: true,
                        enabled: true,
                        formatter: function () {
                            var color = this.y == 0 ? '#dadada' : '#666';
                            return '<span style="color: ' + color + '">' + this.y + '</span>';
                        },
                        crop: false,
                        overflow: 'none'
                    },
                    enableMouseTracking: false,
                    pointWidth: 10,
                    color: '#002e6e'
                }
            },

            series: [{
                name: 'Horas',
                data: hours
            }]
        });


        $('#chart-forms').highcharts({
            chart: {
                type: 'line'
            },
            legend: {
                align: 'right',
                verticalAlign: 'top',
                layout: 'vertical',
                x: 0,
                y: 100
            },

            title: {
                text: '',
                style: {
                    display: 'none'
                }
            },

            tooltip: {
                formatter: function () {
                    var s = '<b>' + this.x + '</b>';

                    $.each(this.points, function () {
                        if (this.y != 0){
                            s += '<br/>' + this.series.name + ': ' + this.y;
                        }
                    });

                    return s;
                },
                backgroundColor: '#fafafa',
                borderColor: '#dadada',
                shared: true
            },

            credits: false,

            xAxis: {
                categories: days,
                title: {
                    text: 'Días del mes'
                }
            },

            yAxis: {
                title: {
                    text: 'Cantidad'
                },
                tickInterval: 1,
                gridLineColor: '#eaeaea'
            },

            plotOptions: {
                series: {
                    dataLabels: {
                        enabled: false
                    }
                },
                line: {
                    marker:{
                        enabled: false,
                        radius: 2
                    }
                }
            },

            series: [
                {
                    name: 'FOR_VAS_07',
                    data: forvas07,
                    color: '#FD3D11'
                },
                {
                    name: 'FOR_VAS_33',
                    data: forvas33,
                    color: '#F99212'
                },
                {
                    name: 'FOR_VAS_34',
                    data: forvas34,
                    color: '#20A1CE'
                },
                {
                    name: 'FOR_VAS_35',
                    data: forvas35,
                    color: '#002e6e'
                }]
        });
    });


})(jQuery);


