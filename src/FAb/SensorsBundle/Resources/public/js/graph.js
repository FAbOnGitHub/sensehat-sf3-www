/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * URL des données
 * @type {string}
 */
//var sDataURL = 'http://sensors.localdomain/app.php/api/datalines/';
//var sDataURL = '{{api-url}}/datalines/';

/**
 *
 * @type {number} nombre de data reçues
 */
var ihm_waitingbox_max = 0;


/**
 * Avancement de la progress bar de conversion
 */
var ihm_waitingbox_pb_milestone = 20;

/**
 * Synchronize zooming through the setExtremes event handler.
 */
function syncExtremes(e) {
    var thisChart = this.chart;

    if (e.trigger !== 'syncExtremes') { // Prevent feedback loop
        Highcharts.each(Highcharts.charts, function (chart) {
            if (chart !== thisChart) {
                if (chart.xAxis[0].setExtremes) { // It is null while updating
                    chart.xAxis[0].setExtremes(
                        e.min,
                        e.max,
                        undefined,
                        false,
                        {trigger: 'syncExtremes'}
                    );
                }
            }
        });
    }
}


$(document).ready(function () {

    /**
     * In order to synchronize tooltips and crosshairs, override the
     * built-in events with handlers defined on the parent element.
     */
    $('#graph-container').bind('mousemove touchmove touchstart', function (e) {
        var chart,
            point,
            i,
            event;

        for (i = 0; i < Highcharts.charts.length; i = i + 1) {
            chart = Highcharts.charts[i];
            // Find coordinates within the chart
            event = chart.pointer.normalize(e.originalEvent);
            // Get the hovered point
            point = chart.series[0].searchPoint(event, true);

            if (point) {
                point.highlight(e);
            }
        }
    });
    /**
     * Override the reset function, we don't need to hide the tooltips and
     * crosshairs.
     */
    Highcharts.Pointer.prototype.reset = function () {
        return undefined;
    };

    /**
     * Highlight a point by showing tooltip, setting hover state and draw crosshair
     */
    Highcharts.Point.prototype.highlight = function (event) {
        event = this.series.chart.pointer.normalize(event);
        this.onMouseOver(); // Show the hover marker
        this.series.chart.tooltip.refresh(this); // Show the tooltip
        this.series.chart.xAxis[0].drawCrosshair(event, this); // Show the crosshair
    };

    ihm_waitingbox_init();

    setTimeout(main_action, 400);
    console.log("Graph.js ready! " + sDataURL);
});

function sleep(milliseconds) {
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
}

function main_action() {
    ihm_waitingbox_msg('Connexion au serveur');
    $.ajax({
            method: "GET",
            dataType: 'json',
            url: sDataURL
        }
    ).done(function (data) {
        var len = data.length;
        ihm_waitingbox_received(len)

        var temperature = [];
        var temperature_cpu = [];
        var humidity = [];
        var pressure = [];

        for (var idx in data) {
            var line = data[idx]
            var d = Date.parse(line['datetime']);
            var t = line['temperature'];
            var h = line['humidity'];
            var p = line['pressure'];
            var tc = line['temperature_cpu'];

            temperature.push([d, t]);
            humidity.push([d, h]);
            pressure.push([d, p]);
            temperature_cpu.push([d, tc]);

            ihm_waitingbox_update_conversion(idx);
        }
        ihm_waitingbox_msg("Conversion terminée");
        ihm_waitingbox_stop_conversion();

        draw_data_temperatures('graph-temperature', 'temperature', temperature, 'temperature_cpu', temperature_cpu, '°C');
        box_graph_on('waiting-graph-temperature');
        ihm_waitingbox_msg("Température OK");

        draw_data_humidity('graph-humidity', 'humidity', humidity, '%');
        box_graph_on('waiting-graph-humidity');
        ihm_waitingbox_msg("Humidité OK");

        draw_data_pressure('graph-pressure', 'pressure', pressure, 'P');
        box_graph_on('waiting-graph-pression');
        ihm_waitingbox_msg("Pression OK");

        setTimeout(ihm_waitingbox_end, 500);

        console.log("success ");
    }).fail(function () {
        alert("error");
    });

}

function ihm_waitingbox_msg(sMsg) {
    var p = $('<span />');
    p.addClass('msg-small');
    p.html('| ' + sMsg);
    $('#waiting-message').append(p);
    console.log("msg=" + sMsg);
}

function ihm_waitingbox_init() {
    $('#box-global-count').hide();
    $('#graph-container').hide();

    $('#waiting-box').show();
    // $("#waiting-progress-box").hide();
    $('#msg-dl').hide();
    box_graph_off('waiting-graph-temperature');
    box_graph_off('waiting-graph-humidity');
    box_graph_off('waiting-graph-pression');
}

function ihm_waitingbox_received(len) {
    ihm_waitingbox_max = len;
    var current_progress = 0;
    $('#msg-dl').show();
    $('#recieved-count').html(len);
    $('#box-global-count').show();
    $('#span-count').html(len);

    ihm_waitingbox_msg(len + " données reçues");

    $("#waiting-progress-box").show();
    $("#waiting-progress-bar")
        .css("width", current_progress + "%")
        .attr("aria-valuenow", current_progress)
        .text(current_progress + "% Complete");

    //console.log("ihm_waitingbox_init len=" + len + "/" + ihm_waitingbox_max);
}

function ihm_waitingbox_update_conversion(val) {
    // console.log(">> val = " + val);
    var ppc = val * 100 / ihm_waitingbox_max;
    var milestone = Math.floor(ppc / ihm_waitingbox_pb_milestone) * ihm_waitingbox_pb_milestone;
    var epsilon = 0.005;
    var delta = Math.abs(ppc - milestone);

    if (delta < epsilon) {
        ppc = 40;
        $("#waiting-progress-bar")
            .css("width", ppc + "%")
            .attr("aria-valuenow", ppc)
            .text(ppc + "% Complete");
       // console.log("ihm_waitingbox_update  val=" + val + " -%-> " + ppc + " | " + milestone + " " + delta);
    }

}

function ihm_waitingbox_stop_conversion() {
    var current_progress = 100;
    $("#waiting-progress-bar")
        .css("width", current_progress + "%")
        .attr("aria-valuenow", current_progress)
        .text(current_progress + "% Complete");
    // console.log("ihm_waitingbox_stop val=" + current_progress);
}


function ihm_waitingbox_end() {
    $('#waiting-box').hide();
    $('#graph-container').show();
}

function box_graph_off(id) {
    $('#' + id).addClass('img-grayable');
}

function box_graph_on(id) {
    $('#' + id).addClass('img-ungray');
}

function draw_data_pressure(divGraph, label, data, Xunit) {

    // $('<div class="chart">').appendTo('#graph-container').prop('id', divGraph);

    Highcharts.chart(divGraph, {
        chart: {
            zoomType: 'x',
            marginLeft: 40, // Keep all charts left aligned
            spacingTop: 20,
            spacingBottom: 20
        },
        title: {
            text: label,
            align: 'left',
            margin: 0,
            x: 30
        },
        credits: {
            enabled: false
        },
        legend: {
            enabled: false
        },
        subtitle: {
            text: document.ontouchstart === undefined ?
                'Click and drag in the plot area to zoom in' : 'Pinch the chart to zoom in'
        },
        xAxis: {
            type: 'datetime',
            crosshair: true,
            events: {
                setExtremes: syncExtremes
            },
            // labels: {
            //     format: '{value} ' + Xunit
            // }
        },
        yAxis: {
            title: {
                text: label
            },
            min: 960,
            max: 1050,
        },
        legend: {
            enabled: false
        },
        plotOptions: {
            area: {
                fillColor: {
                    linearGradient: {
                        x1: 0,
                        y1: 0,
                        x2: 0,
                        y2: 1
                    },
                    stops: [
                        [0, Highcharts.getOptions().colors[0]],
                        [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                    ]
                },
                marker: {
                    radius: 2
                },
                lineWidth: 1,
                states: {
                    hover: {
                        lineWidth: 1
                    }
                },
                threshold: null
            }
        },
        tooltip: {
            positioner: function () {
                return {
                    // right aligned
                    x: this.chart.chartWidth - this.label.width - 30,
                    y: 10 // align to title
                };
            },
            borderWidth: 0,
            backgroundColor: 'none',
            pointFormat: '{point.y}',
            headerFormat: '',
            shadow: false,
            style: {
                fontSize: '18px'
            },
            valueDecimals: data.valueDecimals
        },
        series: [{
            type: 'area',
            name: label,
            data: data,
            fillOpacity: 0.3,
            tooltip: {
                valueSuffix: ' ' + Xunit
            }
        }]
    });

}

function draw_data_temperatures(divGraph, label1, data1, label2, data2, Xunit) {

    // $('<div class="chart">').appendTo('#graph-container').prop('id', divGraph);

    Highcharts.chart(divGraph, {
        chart: {
            zoomType: 'x',
            marginLeft: 40, // Keep all charts left aligned
            spacingTop: 20,
            spacingBottom: 20
        },
        title: {
            text: label1,
            align: 'left',
            margin: 0,
            x: 30
        },
        credits: {
            enabled: false
        },
        legend: {
            enabled: false
        },
        subtitle: {
            text: document.ontouchstart === undefined ?
                'Click and drag in the plot area to zoom in' : 'Pinch the chart to zoom in'
        },
        xAxis: {
            type: 'datetime',
            crosshair: true,
            events: {
                setExtremes: syncExtremes
            },
            // labels: {
            //     format: '{value} ' + Xunit
            // }
        },
        yAxis: {
            title: {
                text: label1
            },
            min: 0,
            max: 60,
        },

        plotOptions: {
            area: {
                fillColor: {
                    linearGradient: {
                        x1: 0,
                        y1: 0,
                        x2: 0,
                        y2: 1
                    },
                    stops: [
                        [0, Highcharts.getOptions().colors[0]],
                        [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                    ]
                },
                marker: {
                    radius: 2
                },
                lineWidth: 1,
                states: {
                    hover: {
                        lineWidth: 1
                    }
                },
                threshold: null
            }
        },
        tooltip: {
            positioner: function () {
                return {
                    // right aligned
                    x: this.chart.chartWidth - this.label.width - 30,
                    y: 10 // align to title
                };
            },
            borderWidth: 0,
            backgroundColor: 'none',
            pointFormat: '{point.y}',
            headerFormat: '',
            shadow: false,
            style: {
                fontSize: '18px'
            },
            valueDecimals: data1.valueDecimals
        },
        series: [
            {
                type: 'area',
                name: label1,
                data: data1,
                fillOpacity: 0.9,
                tooltip: {
                    valueSuffix: ' ' + Xunit
                }
            },
            {
                type: 'line',
                name: label2,
                data: data2,
                color: 'rgba(30, 30, 30, 0.1)',
                fillOpacity: 0.05,
                tooltip: {
                    valueSuffix: ' ' + Xunit
                }
            }
        ]
    });

}


function draw_data_humidity(divGraph, label, data, Xunit) {

    // $('<div class="chart">').appendTo('#graph-container').prop('id', divGraph);

    Highcharts.chart(divGraph, {
        chart: {
            zoomType: 'x'
        },
        title: {
            text: label,
            align: 'left',
            margin: 0,
            x: 30
        },
        credits: {
            enabled: false
        },
        legend: {
            enabled: false
        },
        subtitle: {
            text: document.ontouchstart === undefined ?
                'Click and drag in the plot area to zoom in' : 'Pinch the chart to zoom in'
        },
        xAxis: {
            type: 'datetime'
        },
        yAxis: {
            title: {
                text: label
            },
            min: 0,
            max: 70,
            plotBands: [
                {
                    from: 0,
                    to: 20,
                    color: 'rgba(255, 0, 0, 0.05)'
                },
                {
                    from: 20,
                    to: 60,
                    color: 'rgba(0, 255, 0, 0.05)'
                },
                {
                    from: 60,
                    to: 100,
                    color: 'rgba(255, 0, 0, 0.05)'
                }

            ]
        },
        legend: {
            enabled: false
        },
        plotOptions: {
            area: {
                fillColor: {
                    linearGradient: {
                        x1: 0,
                        y1: 0,
                        x2: 0,
                        y2: 1
                    },
                    stops: [
                        [0, Highcharts.getOptions().colors[0]],
                        [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                    ]
                },
                marker: {
                    radius: 2
                },
                lineWidth: 1,
                states: {
                    hover: {
                        lineWidth: 1
                    }
                },
                threshold: null
            },
            column: {
                zones: [{
                    value: 20, // Values up to 10 (not including) ...
                    color: 'blue' // ... have the color blue.
                }, {
                    color: 'red' // Values from 10 (including) and up have the color red
                }]
            }
        },
        tooltip: {
            positioner: function () {
                return {
                    // right aligned
                    x: this.chart.chartWidth - this.label.width - 30,
                    y: 10 // align to title
                };
            },
            borderWidth: 0,
            backgroundColor: 'none',
            pointFormat: '{point.y}',
            headerFormat: '',
            shadow: false,
            style: {
                fontSize: '18px'
            },
            valueDecimals: data.valueDecimals
        },
        series: [{
            type: 'area',
            name: label,
            data: data,
            fillOpacity: 0.3,
            tooltip: {
                valueSuffix: ' ' + Xunit
            }
        }]
    });

}

$(function() {
    var current_progress22 = 0;
    var interval = setInterval(function() {
        current_progress22 += 10;
        $("#dynamic")
            .css("width", current_progress22 + "%")
            .attr("aria-valuenow", current_progress22)
            .text(current_progress22 + "% Complete");
        if (current_progress22 >= 100)
            clearInterval(interval);
    }, 200);
});