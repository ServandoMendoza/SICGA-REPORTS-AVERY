/**
 * Created by servandomendoza on 4/17/15.
 */
$(function () {
    $('#diag_numb').change(function(){
        $('#d-pescado-box').html('');
        var strHtml = '';
        var cantidad = $(this).val();


        for(var i = 0; i < cantidad ; i++)
            strHtml += '<img src="'+imgDiagramaPescado+'" alt="Diagrama Pescado" class="img-responsive"/>';

        $('#d-pescado-box').html(strHtml);
    });


    if(arrAreaWeek.length > 0)
        $('#year_weekly').highcharts({
            credits: {
                enabled: false
            },
            legend: {
                enabled: false
            },
            chart: {
                type: 'line'
            },
            title: {
                text: areaName + ', WEEKLY SCRAP ' + selectedYear
            },

            xAxis: {
                categories: arrAreaWeek
            },
            yAxis: {
                title: {
                    text: ''
                },
                labels: {
                    format: '{value} %',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:.2f}%'
                    },
                    enableMouseTracking: false
                }
            },
            colors: ['#7cb5ec', '#FF4040'],
            series: [{

                data: arrScrapAreaYear
            }, {
                type: 'spline',

                data: [[0, metricGoal], [arrScrapAreaYear.length - 1, metricGoal]],
                marker: {enabled: false}
            }]
        });

    if(saScrapPerSaName.length > 0)
        $('#sa_scrap_per').highcharts({
            credits: {
                enabled: false
            },
            legend: {
                enabled: false
            },
            title: {
                text: areaName + ' % de Scrap de Proceso por Area <br/>' + monthRange + ' ' + selectedYear
            },

            xAxis: [{
                categories: saScrapPerSaName

            }],
            yAxis: [{ // Primary yAxis
                labels: {
                    format: '{value}',
                    color:'#000'
                },
                title: {
                    text: '',
                    color:'#000'
                }
            }, { // Secondary yAxis
                title: {
                    text: '',
                    color:'#000'
                },
                labels: {
                    format: '{value} %',
                    color:'#000'
                },
                opposite: true
            }],

            colors: ['#B13B3C', '#7cb5ec'],
            series: [{

                type: 'column',
                yAxis: 1,
                data: saScrapPerPerc,
                dataLabels: {
                    format: '{y}%',
                    enabled: true,
                    color: '#ff0000',
                    align: 'center',
                    x: 0,
                    y: 0,
                    style: {
                        fontSize: '12px',
                        fontFamily: 'Verdana, sans-serif',
                        fontWeight: 'bold'
                    }
                },
                tooltip: {
                    valueSuffix: ' %'
                }

            }, {

                type: 'line',
                data: saScrapPerQty,
                dataLabels: {
                    enabled: true,
                    color: '#000',
                    align: 'right',
                    x: 20,
                    y: 0,
                    style: {
                        fontSize: '9px',
                        fontFamily: 'Verdana, sans-serif',
                        fontWeight: 'bold'
                    }
                }

            }],
            navigation: {
                buttonOptions: {
                    enabled: false
                }
            }
        });

    if(saScrapTotal.length > 0)
        $('#sa_scrap').highcharts({
        credits: {
            enabled: false
        },
        legend: {
            enabled: false
        },
        chart: {
            type: 'column'
        },
        title: {
            text: areaName + ' - Amount, de Scrap de Proceso <br/>' + monthRange + ' ' + selectedYear
        },

        xAxis: {
            type: 'category',
            labels: {
                rotation: -75,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: ''
            },
            labels: {
                format: '{value}',
                style: {
                    color: Highcharts.getOptions().colors[1]
                }
            }
        },
        legend: {
            enabled: false
        },

        series: [{
            name: '',
            data: saScrapTotal,
            dataLabels: {
                format: '{point.y:.2f}',
                enabled: true,
                color: '#000',
                align: 'center',
                x: 0,
                y: 0,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        }]
    });

    if(saMachScrapSaName[0] != undefined && saMachScrapSaName[0].length > 0)
        $('#sa_machine1_scrap').highcharts({
            credits: {
                enabled: false
            },
            legend: {
                enabled: false
            },
            title: {
                text: saMachScrapSaName[0] + ' % de Scrap ' + monthRange + ' ' + selectedYear
            },

            xAxis: [{
                categories: saMachScrapName[0]

            }],
            yAxis: [{ // Primary yAxis
                labels: {
                    format: '{value}',
                    color:'#000'
                },
                title: {
                    text: '',
                    color:'#000'
                }
            }, { // Secondary yAxis
                title: {
                    text: '',
                    color:'#000'
                },
                labels: {
                    format: '{value} %',
                    color:'#000'
                },
                opposite: true
            }],

            colors: ['#AD0C10', '#7cb5ec'],
            series: [{

                type: 'column',
                yAxis: 1,
                data: saMachScrapPerc[0],
                dataLabels: {
                    format: '{y}%',
                    enabled: true,
                    color: '#ff0000',
                    align: 'center',
                    x: 0,
                    y: 30,
                    style: {
                        fontSize: '12px',
                        fontFamily: 'Verdana, sans-serif',
                        fontWeight: 'bold'
                    }
                },
                tooltip: {
                    valueSuffix: ' %'
                }

            }, {

                type: 'line',
                data: saMachScrapQty[0],
                dataLabels: {
                    enabled: true,
                    color: '#000',
                    align: 'right',
                    x: 20,
                    y: 0,
                    style: {
                        fontSize: '9px',
                        fontFamily: 'Verdana, sans-serif',
                        fontWeight: 'bold'
                    }
                }

            }],
            navigation: {
                buttonOptions: {
                    enabled: false
                }
            }
        });

    if(saMachScrapSaName[1] != undefined && saMachScrapSaName[1].length > 0)
        $('#sa_machine2_scrap').highcharts({
            credits: {
                enabled: false
            },
            legend: {
                enabled: false
            },
            title: {
                text: saMachScrapSaName[1] + ' % de Scrap ' + monthRange + ' ' + selectedYear
            },

            xAxis: [{
                categories: saMachScrapName[1]

            }],
            yAxis: [{ // Primary yAxis
                labels: {
                    format: '{value}',
                    color:'#000'
                },
                title: {
                    text: '',
                    color:'#000'
                }
            }, { // Secondary yAxis
                title: {
                    text: '',
                    color:'#000'
                },
                labels: {
                    format: '{value} %',
                    color:'#000'
                },
                opposite: true
            }],

            colors: ['#B13B3C', '#7cb5ec'],
            series: [{

                type: 'column',
                yAxis: 1,
                data: saMachScrapPerc[1],
                dataLabels: {
                    format: '{y}%',
                    enabled: true,
                    color: '#ff0000',
                    align: 'center',
                    x: 0,
                    y: 30,
                    style: {
                        fontSize: '12px',
                        fontFamily: 'Verdana, sans-serif',
                        fontWeight: 'bold'
                    }
                },
                tooltip: {
                    valueSuffix: ' %'
                }

            }, {

                type: 'line',
                data: saMachScrapQty[1],
                dataLabels: {
                    enabled: true,
                    color: '#000',
                    align: 'right',
                    x: 20,
                    y: 0,
                    style: {
                        fontSize: '9px',
                        fontFamily: 'Verdana, sans-serif',
                        fontWeight: 'bold'
                    }
                }

            }],
            navigation: {
                buttonOptions: {
                    enabled: false
                }
            }
        });

    if(saScrapProc[0] != undefined && saScrapProc[0].length > 0)
        $('#sa_machine1_scrap_proc').highcharts({
        credits: {
            enabled: false
        },
        legend: {
            enabled: false
        },
        chart: {
            type: 'column'
        },
        title: {
            text: saMachScrapSaName[0] + ' - Amount de Scrap Proceso <br/>' + monthRange + ' ' + selectedYear
        },

        xAxis: {
            type: 'category',
            labels: {
                rotation: -75,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: ''
            },
            labels: {
                format: '{value}',
                style: {
                    color: Highcharts.getOptions().colors[1]
                }
            }
        },
        legend: {
            enabled: false
        },

        series: [{
            name: '',
            data: saScrapProc[0],
            dataLabels: {
                format: '{point.y:.2f}',
                enabled: true,
                color: '#000',
                align: 'center',
                x: 0,
                y: 0,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        }]
    });

    if(saScrapProc[1] != undefined && saScrapProc[1].length > 0)
        $('#sa_machine2_scrap_proc').highcharts({
        credits: {
            enabled: false
        },
        legend: {
            enabled: false
        },
        chart: {
            type: 'column'
        },
        title: {
            text: saMachScrapSaName[1] + ' - Amount de Scrap Proceso <br/>' + monthRange + ' ' + selectedYear
        },

        xAxis: {
            type: 'category',
            labels: {
                rotation: -75,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: ''
            },
            labels: {
                format: '{value}',
                style: {
                    color: Highcharts.getOptions().colors[1]
                }
            }
        },
        legend: {
            enabled: false
        },

        series: [{
            name: '',
            data: saScrapProc[1],
            dataLabels: {
                format: '{point.y:.2f}',
                enabled: true,
                color: '#000',
                align: 'center',
                x: 0,
                y: 0,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        }]
    });

    if(saCodeScrap.length > 0)
        $('#sa_code_scrap').highcharts({
        credits: {
            enabled: false
        },
        legend: {
            enabled: false
        },
        chart: {
            zoomType: 'xy'
        },
        title: {
            text: 'Amount por código por Area ' + saCodeScraSaName + '<br/>'+ monthRange + ' ' + selectedYear
        },
        subtitle: {
            text: ''
        },
        xAxis: [{
            categories: saCodeScrap,
            labels: {
                rotation: -75,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }

        }],
        yAxis: [{ // Primary yAxis

            title: {

                text: '',
                style: {
                    color:'#000'
                }
            },

            labels: {

                format: '{value} % ',
                style: {
                    color:'#000'
                }
            },
            opposite: true

        }, { // Secondary yAxis
            gridLineWidth: 0,
            title: {
                text: '',
                style: {
                    color:'#000'
                }
            },
            labels: {
                format: '{value} ',
                style: {
                    color: '#000'
                }
            }

        }],

        colors: ['#7cb5ec', '#FF4040'],
        series: [{
            type: 'column',
            yAxis: 1,
            data: saCodeScrapQty,
            dataLabels: {
                enabled: true,
                color: '#666',
                align: 'center',
                x: 0,
                y: 0,
                style: {
                    fontSize: '11px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        },  {

            type: 'spline',
            data: saCodeScraPerc,
            dataLabels: {
                format: '{y}%',
                enabled: true,
                color: '#AD0C10',
                align: 'center',
                x: 0,
                y: 20,
                style: {
                    fontSize: '11px',
                    fontFamily: 'Verdana, sans-serif',
                    fontWeight: 'bold'
                }
            },
            tooltip: {
                valueSuffix: ' %'
            }
        }]
    });

    if(saMaReasonName[0] != undefined && saMaReasonName[0].length > 0)
        $('#sa_m_reason_1').highcharts({
        credits: {
            enabled: false
        },
        legend: {
            enabled: false
        },
        chart: {
            zoomType: 'xy'
        },
        title: {
            text: saMaNameReason[0] + ' ' + lessSAreaName + ': Amount de scrap por Códigos de Defectos'
        },
        subtitle: {
            text: ''
        },
        xAxis: [{
            categories: saMaReasonName[0],
            labels: {
                rotation: -75,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }

        }],
        yAxis: [{ // Primary yAxis

            title: {

                text: '',
                style: {
                    color:'#000'
                }
            },

            labels: {

                format: '{value} % ',
                style: {
                    color:'#000'
                }
            },
            opposite: true

        }, { // Secondary yAxis
            gridLineWidth: 0,
            title: {
                text: '',
                style: {
                    color:'#000'
                }
            },
            labels: {
                format: '{value} ',
                style: {
                    color: '#000'
                }
            }

        }],

        colors: ['#7cb5ec', '#FF4040'],
        series: [{
            type: 'column',
            yAxis: 1,
            data: saMaReasonScrapQty[0],
            dataLabels: {
                enabled: true,
                color: '#666',
                align: 'center',
                x: 0,
                y: 0,
                style: {
                    fontSize: '11px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        },  {

            type: 'spline',
            data: saMaReasonPerc[0],
            dataLabels: {
                format: '{y}%',
                enabled: true,
                color: '#AD0C10',
                align: 'center',
                x: 0,
                y: 20,
                style: {
                    fontSize: '11px',
                    fontFamily: 'Verdana, sans-serif',
                    fontWeight: 'bold'
                }
            },
            tooltip: {
                valueSuffix: ' %'
            }
        }]
    });

    if(saMaReasonName[1] != undefined && saMaReasonName[1].length > 0)
        $('#sa_m_reason_2').highcharts({
        credits: {
            enabled: false
        },
        legend: {
            enabled: false
        },
        chart: {
            zoomType: 'xy'
        },
        title: {
            text: saMaNameReason[1] + ' ' + lessSAreaName + ': Amount de scrap por Códigos de Defectos'
        },
        subtitle: {
            text: ''
        },
        xAxis: [{
            categories: saMaReasonName[1],
            labels: {
                rotation: -75,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }

        }],
        yAxis: [{ // Primary yAxis

            title: {

                text: '',
                style: {
                    color:'#000'
                }
            },

            labels: {

                format: '{value} % ',
                style: {
                    color:'#000'
                }
            },
            opposite: true

        }, { // Secondary yAxis
            gridLineWidth: 0,
            title: {
                text: '',
                style: {
                    color:'#000'
                }
            },
            labels: {
                format: '{value} ',
                style: {
                    color: '#000'
                }
            }

        }],

        colors: ['#7cb5ec', '#FF4040'],
        series: [{
            type: 'column',
            yAxis: 1,
            data: saMaReasonScrapQty[1],
            dataLabels: {
                enabled: true,
                color: '#666',
                align: 'center',
                x: 0,
                y: 0,
                style: {
                    fontSize: '11px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        },  {

            type: 'spline',
            data: saMaReasonPerc[1],
            dataLabels: {
                format: '{y}%',
                enabled: true,
                color: '#AD0C10',
                align: 'center',
                x: 0,
                y: 20,
                style: {
                    fontSize: '11px',
                    fontFamily: 'Verdana, sans-serif',
                    fontWeight: 'bold'
                }
            },
            tooltip: {
                valueSuffix: ' %'
            }
        }]
    });

    if(saMaReasonName[2] != undefined && saMaReasonName[2].length > 0)
        $('#sa_m_reason_3').highcharts({
        credits: {
            enabled: false
        },
        legend: {
            enabled: false
        },
        chart: {
            zoomType: 'xy'
        },
        title: {
            text: saMaNameReason[2] + ' ' + lessSAreaName + ': Amount de scrap por Códigos de Defectos'
        },
        subtitle: {
            text: ''
        },
        xAxis: [{
            categories: saMaReasonName[2],
            labels: {
                rotation: -75,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }

        }],
        yAxis: [{ // Primary yAxis

            title: {

                text: '',
                style: {
                    color:'#000'
                }
            },

            labels: {

                format: '{value} % ',
                style: {
                    color:'#000'
                }
            },
            opposite: true

        }, { // Secondary yAxis
            gridLineWidth: 0,
            title: {
                text: '',
                style: {
                    color:'#000'
                }
            },
            labels: {
                format: '{value} ',
                style: {
                    color: '#000'
                }
            }

        }],

        colors: ['#7cb5ec', '#FF4040'],
        series: [{
            type: 'column',
            yAxis: 1,
            data: saMaReasonScrapQty[2],
            dataLabels: {
                enabled: true,
                color: '#666',
                align: 'center',
                x: 0,
                y: 0,
                style: {
                    fontSize: '11px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        },  {

            type: 'spline',
            data: saMaReasonPerc[2],
            dataLabels: {
                format: '{y}%',
                enabled: true,
                color: '#AD0C10',
                align: 'center',
                x: 0,
                y: 20,
                style: {
                    fontSize: '11px',
                    fontFamily: 'Verdana, sans-serif',
                    fontWeight: 'bold'
                }
            },
            tooltip: {
                valueSuffix: ' %'
            }
        }]
    });

    if(saMaReasonName[3] != undefined && saMaReasonName[3].length > 0)
        $('#sa_m_reason_4').highcharts({
        credits: {
            enabled: false
        },
        legend: {
            enabled: false
        },
        chart: {
            zoomType: 'xy'
        },
        title: {
            text: saMaNameReason[3] + ' ' + lessSAreaName + ': Amount de scrap por Códigos de Defectos'
        },
        subtitle: {
            text: ''
        },
        xAxis: [{
            categories: saMaReasonName[3],
            labels: {
                rotation: -75,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }

        }],
        yAxis: [{ // Primary yAxis

            title: {

                text: '',
                style: {
                    color:'#000'
                }
            },

            labels: {

                format: '{value} % ',
                style: {
                    color:'#000'
                }
            },
            opposite: true

        }, { // Secondary yAxis
            gridLineWidth: 0,
            title: {
                text: '',
                style: {
                    color:'#000'
                }
            },
            labels: {
                format: '{value} ',
                style: {
                    color: '#000'
                }
            }

        }],

        colors: ['#7cb5ec', '#FF4040'],
        series: [{
            type: 'column',
            yAxis: 1,
            data: saMaReasonScrapQty[3],
            dataLabels: {
                enabled: true,
                color: '#666',
                align: 'center',
                x: 0,
                y: 0,
                style: {
                    fontSize: '11px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        },  {

            type: 'spline',
            data: saMaReasonPerc[3],
            dataLabels: {
                format: '{y}%',
                enabled: true,
                color: '#AD0C10',
                align: 'center',
                x: 0,
                y: 20,
                style: {
                    fontSize: '11px',
                    fontFamily: 'Verdana, sans-serif',
                    fontWeight: 'bold'
                }
            },
            tooltip: {
                valueSuffix: ' %'
            }
        }]
    });
});