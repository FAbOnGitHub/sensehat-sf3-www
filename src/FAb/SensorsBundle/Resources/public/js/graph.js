/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {
    var sDataURL = 'http://sensors.localdomain/app_dev.php/api/datalines/';

    $.ajax({
            method: "GET",
            dataType: 'json',
            url: sDataURL
        }
    ).done(function (data) {
        var temperature = [];
        var humidity = [];
        var pressure = [];
        for (var idx in data) {
            var line = data[idx]
            var d = Date.parse(line['datetime']);
            var t = line['temperature'];
            var h = line['humidity'];
            var p = line['pressure'];
            console.log("<> " + t + "; " + h + "; " + p);
            temperature.push([d, t]);
            humidity.push([d, h]);
            pressure.push([d, p]);
        }
        draw_data('graph-temperature', 'temperature', temperature);
        draw_data_humidity('graph-humidity', 'humidity', humidity);
        draw_data('graph-pressure', 'pressure', pressure);
        console.log("success ");
    }).fail(function () {
        alert("error");
    });

    console.log("Graph.js ready! " + sDataURL);
});


function draw_data(divGraph, label, data) {

    Highcharts.chart(divGraph, {
        chart: {
            zoomType: 'x'
        },
        title: {
            text: label
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
            }
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

        series: [{
            type: 'area',
            name: label,
            data: data
        }]
    });

}
function draw_data_humidity(divGraph, label, data) {

    Highcharts.chart(divGraph, {
        chart: {
            zoomType: 'x'
        },
        title: {
            text: label
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
            }
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

        series: [{
            type: 'area',
            name: label,
            data: data
        }]
    });

}

