$(function () {
    $('#diag_numb').change(function(){
        $('#d-pescado-box').html('');
        var strHtml = '';
        var cantidad = $(this).val();


        for(var i = 0; i < cantidad ; i++)
            strHtml += '<img src="'+imgDiagramaPescado+'" alt="" class="img-responsive"/>';

        $('#d-pescado-box').html(strHtml);
    });

    $('#area_ut').highcharts({
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
            text: areaName +  ', Tendencia UPTIME'
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
        colors: ['#7cb5ec', '#0A5', '#FF4040'],
        series: [{

            data: arrUpTimeArea
        }, {
            type: 'spline',

            data: [[0, arrUpTimeArea[0]], [arrUpTimeArea.length - 1, arrUpTimeArea[arrUpTimeArea.length - 1]]],
            marker: {enabled: false }
        }, {
            type: 'spline',

            data: [[0, metaMetrico], [arrUpTimeArea.length - 1, metaMetrico]],
            marker: {enabled: false }
        }]
    });

    $('#sub_area_ut').highcharts({
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
            text: subAreaName +  ', Tendencia UPTIME'
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
        colors: ['#7cb5ec', '#0A5', '#FF4040'],
        series: [{

            data: arrUpTimeSubArea
        }, {
            type: 'spline',

            data: [[0, arrUpTimeSubArea[0]], [arrUpTimeSubArea.length - 1, arrUpTimeSubArea[arrUpTimeSubArea.length - 1]]],
            marker: {enabled: false }
        }, {
            type: 'spline',

            data: [[0, metaMetrico], [arrUpTimeSubArea.length - 1, metaMetrico]],
            marker: {enabled: false }
        }]
    });

    $('#machines_sa_ut').highcharts({
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
            text: subAreaName + ', UPTIME por máquina (YTD)'
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
                format: '{value} %',
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


            data: arrUpTimeSubAreaMachines,

            dataLabels: {
                format: '{point.y:.2f}%',
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

    $('#dtg_sa_ytd').highcharts({
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
            text: subAreaName +' DT POR CLASIFICACION (YTD)'
        },
        subtitle: {
            text: ''
        },
        xAxis: [{
            categories: arrDtgSaYtdName,
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
            data: arrDtgSaYtdSum,
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
            data: arrDtgSaYtdPercSum,
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

    //Paso 5. DT 2 maquinas con menor UPTIME

    if(arrSubAreaMachineDt[0] != undefined) {
        $('#sa_dtg_machine_1').highcharts({
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
                text: arrSubAreaMachinesDtName[0] + ', DT POR CLASIFICACION (YTD)'
            },
            subtitle: {
                text: ''
            },
            xAxis: [{
                categories: arrSubAreaMachineDt[0].dcg_name,
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
                        color: '#000'
                    }
                },

                labels: {

                    format: '{value} % ',
                    style: {
                        color: '#000'
                    }
                },
                opposite: true

            }, { // Secondary yAxis
                gridLineWidth: 0,
                title: {
                    text: '',
                    style: {
                        color: '#000'
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
                data: arrSubAreaMachineDt[0].perc,
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
            }, {

                type: 'spline',
                data: arrSubAreaMachineDt[0].perc_acum,
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
    }

    if(arrSubAreaMachineDt[1] != undefined) {
        $('#sa_dtg_machine_2').highcharts({
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
                text: arrSubAreaMachinesDtName[1] + ', DT POR CLASIFICACION (YTD)'
            },
            subtitle: {
                text: ''
            },
            xAxis: [{
                categories: arrSubAreaMachineDt[1].dcg_name,
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
                        color: '#000'
                    }
                },

                labels: {

                    format: '{value} % ',
                    style: {
                        color: '#000'
                    }
                },
                opposite: true

            }, { // Secondary yAxis
                gridLineWidth: 0,
                title: {
                    text: '',
                    style: {
                        color: '#000'
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
                data: arrSubAreaMachineDt[1].perc,
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
            }, {

                type: 'spline',
                data: arrSubAreaMachineDt[1].perc_acum,
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
    }

    if(arrMaquinaGrupoDT[0] != undefined && arrMaquinaGrupoDT[0][0] != undefined) {
        $('#sa_dt_1_machine_1').highcharts({
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
                text: arrSubAreaMachinesDtName[0] + ', DT POR '+ arrMaquinaGrupoDT[0][0].dcg_name + ' (YTD)'
            },
            subtitle: {
                text: ''
            },
            xAxis: [{
                categories: arrMaquinaGrupoDT[0][0].dc_name,
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
                        color: '#000'
                    }
                },

                labels: {

                    format: '{value} % ',
                    style: {
                        color: '#000'
                    }
                },
                opposite: true

            }, { // Secondary yAxis
                gridLineWidth: 0,
                title: {
                    text: '',
                    style: {
                        color: '#000'
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
                data: arrMaquinaGrupoDT[0][0].perc,
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
            }, {

                type: 'spline',
                data: arrMaquinaGrupoDT[0][0].perc_acum,
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
    }

    if(arrMaquinaGrupoDT[0] != undefined && arrMaquinaGrupoDT[0][1] != undefined) {
        $('#sa_dt_2_machine_1').highcharts({
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
                text: arrSubAreaMachinesDtName[0] + ', DT POR '+ arrMaquinaGrupoDT[0][1].dcg_name + ' (YTD)'
            },
            subtitle: {
                text: ''
            },
            xAxis: [{
                categories: arrMaquinaGrupoDT[0][1].dc_name,
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
                        color: '#000'
                    }
                },

                labels: {

                    format: '{value} % ',
                    style: {
                        color: '#000'
                    }
                },
                opposite: true

            }, { // Secondary yAxis
                gridLineWidth: 0,
                title: {
                    text: '',
                    style: {
                        color: '#000'
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
                data: arrMaquinaGrupoDT[0][1].perc,
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
            }, {

                type: 'spline',
                data: arrMaquinaGrupoDT[0][1].perc_acum,
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
    }

    if(arrMaquinaGrupoDT[1] != undefined && arrMaquinaGrupoDT[1][0] != undefined) {
        $('#sa_dt_1_machine_2').highcharts({
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
                text: arrSubAreaMachinesDtName[1] + ', DT POR '+ arrMaquinaGrupoDT[1][0].dcg_name + ' (YTD)'
            },
            subtitle: {
                text: ''
            },
            xAxis: [{
                categories: arrMaquinaGrupoDT[1][0].dc_name,
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
                        color: '#000'
                    }
                },

                labels: {

                    format: '{value} % ',
                    style: {
                        color: '#000'
                    }
                },
                opposite: true

            }, { // Secondary yAxis
                gridLineWidth: 0,
                title: {
                    text: '',
                    style: {
                        color: '#000'
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
                data: arrMaquinaGrupoDT[1][0].perc,
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
            }, {

                type: 'spline',
                data: arrMaquinaGrupoDT[1][0].perc_acum,
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
    }

    if(arrMaquinaGrupoDT[1] != undefined && arrMaquinaGrupoDT[1][1] != undefined) {
        $('#sa_dt_2_machine_2').highcharts({
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
                text: arrSubAreaMachinesDtName[1] + ', DT POR '+ arrMaquinaGrupoDT[1][1].dcg_name + ' (YTD)'
            },
            subtitle: {
                text: ''
            },
            xAxis: [{
                categories: arrMaquinaGrupoDT[1][1].dc_name,
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
                        color: '#000'
                    }
                },

                labels: {

                    format: '{value} % ',
                    style: {
                        color: '#000'
                    }
                },
                opposite: true

            }, { // Secondary yAxis
                gridLineWidth: 0,
                title: {
                    text: '',
                    style: {
                        color: '#000'
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
                data: arrMaquinaGrupoDT[1][1].perc,
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
            }, {

                type: 'spline',
                data: arrMaquinaGrupoDT[1][1].perc_acum,
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
    }



});