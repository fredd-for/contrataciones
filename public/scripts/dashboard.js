    $(function () {

        var options = {
            chart: {
                renderTo: 'container4',
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: 'Web Sales & Marketing Efforts'
            },
            tooltip: {
                formatter: function() {
                    return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: '#000000',
                        connectorColor: '#000000',
                        formatter: function() {
                            return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
                        }
                    }
                }
            },
            series: [{
                type: 'pie',
                name: 'Browser share',
                data: []
            }]
        }
            
            $.getJSON("/estaciones/pruebaarray", function(json) {
                options.series[0].data = json;
                chart = new Highcharts.Chart(options);
            });


    $('#container').highcharts({
        data: {
            table: 'datatable',
        },
        chart: {
            type: 'column'
        },
        title: {
            text: 'Contratos Firmados por Meses'
        },
        subtitle: {
            text: 'Nro de contratos firmados'
        },
        xAxis: {
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Nro Contratos'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.0f}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
    });



/*Columna */
var options = {
        chart: {
            renderTo: 'container1',
            type: 'column',
            marginRight: 130,
            marginBottom: 25
        },
        title: {
            text: 'Project Requests',
            x: -20 //center
        },
        subtitle: {
            text: '',
            x: -20
        },
        xAxis: {
            categories: []
        },
        yAxis: {
            title: {
                text: 'Requests'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            formatter: function() {
                    return '<b>'+ this.series.name +'</b><br/>'+
                    this.x +': '+ this.y;
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -10,
            y: 100,
            borderWidth: 0
        },
        series: []
    }
   
    $.getJSON("/dasboard/solicitudes", function(json) {
        options.xAxis.categories = json[0]['data'];
        options.series[0] = json[1];
        options.series[1] = json[2];
        options.series[2] = json[3];
        chart = new Highcharts.Chart(options);
    });


// Create the chart
    // $('#container3').highcharts({
    //     chart: {
    //         type: 'pie'
    //     },
    //     title: {
    //         text: 'Recaudaciones en Bs. de Ene, 2015 a Dic, 2015'
    //     },
    //     subtitle: {
    //         text: 'Haga clic en las rebanadas para ver los clientes con mayor recaudación'
    //     },
    //     plotOptions: {
    //         series: {
    //             dataLabels: {
    //                 enabled: true,
    //                 format: '{point.name}: {point.y:.1f}%'
    //             }
    //         }
    //     },

    //     tooltip: {
    //         headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
    //         pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
    //     },
    //     series: [{
    //         name: "Brands",
    //         colorByPoint: true,
    //         data: [{
    //             name: "Microsoft Internet Explorercc",
    //             y: 56.33,
    //             drilldown: "Microsoft Internet Explorerxx"
    //         }, {
    //             name: "Chrome",
    //             y: 24.03,
    //             drilldown: "Chrome"
    //         }, {
    //             name: "Firefox",
    //             y: 10.38,
    //             drilldown: "Firefox"
    //         }, {
    //             name: "Safari",
    //             y: 4.77,
    //             drilldown: "Safari"
    //         }, {
    //             name: "Opera",
    //             y: 0.91,
    //             drilldown: "Opera"
    //         }, {
    //             name: "Proprietary or Undetectable",
    //             y: 0.2,
    //             drilldown: null
    //         }]
    //     }],
    //     drilldown: {
    //         series: [{
    //             name: "Microsoft Internet Explorer",
    //             id: "Microsoft Internet Explorer",
    //             data: [
    //                 ["v11.0", 24.13],
    //                 ["v8.0", 17.2],
    //                 ["v9.0", 8.11],
    //                 ["v10.0", 5.33],
    //                 ["v6.0", 1.06],
    //                 ["v7.0", 0.5]
    //             ]
    //         }, {
    //             name: "Chrome",
    //             id: "Chrome",
    //             data: [
    //                 ["v40.0", 5],
    //                 ["v41.0", 4.32],
    //                 ["v42.0", 3.68],
    //                 ["v39.0", 2.96],
    //                 ["v36.0", 2.53],
    //                 ["v43.0", 1.45],
    //                 ["v31.0", 1.24],
    //                 ["v35.0", 0.85],
    //                 ["v38.0", 0.6],
    //                 ["v32.0", 0.55],
    //                 ["v37.0", 0.38],
    //                 ["v33.0", 0.19],
    //                 ["v34.0", 0.14],
    //                 ["v30.0", 0.14]
    //             ]
    //         }, {
    //             name: "Firefox",
    //             id: "Firefox",
    //             data: [
    //                 ["v35", 2.76],
    //                 ["v36", 2.32],
    //                 ["v37", 2.31],
    //                 ["v34", 1.27],
    //                 ["v38", 1.02],
    //                 ["v31", 0.33],
    //                 ["v33", 0.22],
    //                 ["v32", 0.15]
    //             ]
    //         }, {
    //             name: "Safari",
    //             id: "Safari",
    //             data: [
    //                 ["v8.0", 2.56],
    //                 ["v7.1", 0.77],
    //                 ["v5.1", 0.42],
    //                 ["v5.0", 0.3],
    //                 ["v6.1", 0.29],
    //                 ["v7.0", 0.26],
    //                 ["v6.2", 0.17]
    //             ]
    //         }, {
    //             name: "Opera",
    //             id: "Opera",
    //             data: [
    //                 ["v12.x", 0.34],
    //                 ["v28", 0.24],
    //                 ["v27", 0.17],
    //                 ["v29", 0.16]
    //             ]
    //         }]
    //     }
    // });


    var options2 = {
        chart: {
            renderTo: 'container3',
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type:'pie'

        },
       title: {
            text: 'Recaudaciones en Bs. de Ene, 2015 a Dic, 2015'
        },
        subtitle: {
            text: 'Haga clic en las rebanadas para ver los clientes con mayor recaudación'
        },
        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.percentage:.2f}%</b> el total<br/>'
        },
        // plotOptions: {
        //     series: {
        //         dataLabels: {
        //             enabled: true,
        //             format: '{point.name}:<br> {point.y:.2f} Bs.'
        //         }
        //     }
        // },
         plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>:<br> {point.y:.1f} Bs.',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    },
                },
                point: {
                    events: {
                        click: function () {
                            // alert(this.x);
                            var responsable_id=this.x;
                            $("#titulo").text(this.name);
                         $.getJSON("/dasboard/container4/"+responsable_id, function(json) {
                            options3.series[0].data = json;
                            chart = new Highcharts.Chart(options3);
                        });
                         $('#myModal').modal('show');
                     }
                    }
                },
            }
        },

        series: [{
            type: 'pie',
            name: 'Contratos',
            data: [],
        }],


    }

    $.getJSON("/dasboard/container3", function(json) {
        options2.series[0].data = json;
        chart = new Highcharts.Chart(options2);
    });


    var options3 = {
        chart: {
            renderTo: 'container4',
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type:'pie'

        },
       title: {
            text: 'Monto del Contratos por Clientes. de Ene, 2015 a Dic, 2015'
        },
        // subtitle: {
        //     text: 'Haga clic en las rebanadas para ver los clientes con mayor recaudación'
        // },
        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.percentage:.2f}%</b> el total<br/>'
        },
        // plotOptions: {
        //     series: {
        //         dataLabels: {
        //             enabled: true,
        //             format: '{point.name}:<br> {point.y:.2f} Bs.'
        //         }
        //     }
        // },
         plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>:<br> {point.y:.1f} Bs.',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    },
                },
            }
        },

        series: [{
            type: 'pie',
            name: 'Cliente',
            data: [],
        }],


    }

});


