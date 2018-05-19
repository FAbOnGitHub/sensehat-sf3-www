/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


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
    var sDataURL = 'http://sensors.localdomain/app_dev.php/api/datalines/';


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

    $.ajax({
            method: "GET",
            dataType: 'json',
            url: sDataURL
        }
    ).done(function (data) {
        var len = data.length;
        $('#count').html(len);

        var temperature = [];
        var humidity = [];
        var pressure = [];
        for (var idx in data) {
            var line = data[idx]
            var d = Date.parse(line['datetime']);
            var t = line['temperature'];
            var h = line['humidity'];
            var p = line['pressure'];
            //console.log("<> " + t + "; " + h + "; " + p);
            temperature.push([d, t]);
            humidity.push([d, h]);
            pressure.push([d, p]);
        }

        draw_data('graph-temperature', 'temperature', temperature, '�C');
        draw_data_humidity('graph-humidity', 'humidity', humidity, '%');
        draw_data('graph-pressure', 'pressure', pressure, 'P');

        console.log("success ");
    }).fail(function () {
        alert("error");
    });

    console.log("Graph.js ready! " + sDataURL);
});


function draw_data(divGraph, label, data, Xunit) {

    $('<div class="chart">').appendTo('#graph-container').prop('id', divGraph);

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

function draw_data_humidity(divGraph, label, data, Xunit) {

    $('<div class="chart">').appendTo('#graph-container').prop('id', divGraph);

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
            plotBands: [
                {
                    from: 0,
                    to: 20,
                    color: '#FFEFFF'
                },
                {
                    from: 20,
                    to: 60,
                    color: '#FFFFEF'
                },
                {
                    from: 60,
                    to: 100,
                    color: '#FFEFFF'
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

