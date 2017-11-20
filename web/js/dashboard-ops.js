
function drawMASRequestsChart(masRequestsByGeo){
    dataArray  = [];
    for(key in masRequestsByGeo){
        dataArray[key] = parseInt(masRequestsByGeo[key].requests);
    }

    Highcharts.chart('requests1', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'MAS Requests Received By GeoZones'
        },
        lang: {
            noData: 'No data to display'
        },
        noData: {
            style: {
                fontWeight: 'normal',
                fontSize: '15px',
                textDecoration: 'underline',
                color: '#363636'
            }
        },
        subtitle: {
            //text: 'Source: <a href=\"https://en.wikipedia.org/wiki/World_population\">Wikipedia.org</a>'
        },
        xAxis: {
            categories:  Object.keys(dataArray),
            title: {
                text: 'Geographic Locations',
                align: 'middle',
                offset: 70,
                style: {'fontWeight': 'bold',  'color': '#363636'}
            }
        },
        yAxis: {
            min: 0,
            lineWidth: 1,
            tickWidth: 1,
            title: {
                text: 'Number of MAS Requests',
                align: 'middle',
                offset: 60,
                style: {'fontWeight': 'bold', 'color': '#363636'}
            },
            labels: {
                overflow: 'justify'
            },
            tickAmount: 5
        },
        tooltip: {
            valueSuffix: ' requests',
            formatter: function (){
                return this.x + ': ' + '<strong>' + this.y + (this.y==1? ' request':' requests')+ '</strong>';
            }
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -40,
            y: 80,
            floating: true,
            borderWidth: 1,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            shadow: true,
            enabled: false
        },
        credits: {
            enabled: false
        },
        series: [{ data: Object.values(dataArray) }]
    });
}


function drawProductBatchesChart(productBatches){
    dataArray  = [];
    for(key in productBatches){
        dataArray[key] = parseInt(productBatches[key].batchCount);
    }

    Highcharts.chart('requests2', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Batches registered per product'
        },
        lang: {
            noData: 'No data to display'
        },
        noData: {
            style: {
                fontWeight: 'normal',
                fontSize: '15px',
                textDecoration: 'underline',
                color: '#363636'
            }
        },
        subtitle: {
            //text: 'Source: <a href=\"https://en.wikipedia.org/wiki/World_population\">Wikipedia.org</a>'
        },
        xAxis: {
            categories:  Object.keys(dataArray),
            title: {
                text: 'Products',
                align: 'middle',
                offset: 70,
                style: {'fontWeight': 'bold',  'color': '#363636'}
            }
        },
        yAxis: {
            min: 0,
            lineWidth: 1,
            tickWidth: 1,
            title: {
                text: 'Number of Batches',
                align: 'middle',
                offset: 60,
                style: {'fontWeight': 'bold', 'color': '#363636'}
            },
            labels: {
                overflow: 'justify'
            },
            tickAmount: 5
        },
        tooltip: {
            valueSuffix: ' requests',
            formatter: function (){
                return this.x + ': ' + '<strong>' + this.y + (this.y==1? ' batch':' batches')+ '</strong>';
            }
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -40,
            y: 80,
            floating: true,
            borderWidth: 1,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            shadow: true,
            enabled: false
        },
        credits: {
            enabled: false
        },
        series: [{ data: Object.values(dataArray) }]
    });
}


function drawConfirmedCounterfeitsChart(usageData){
    //log(usageData);

    Highcharts.chart('counterfeits1', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Confirmed negative responses'
        },
        lang: {
            noData: 'No data to display'
        },
        noData: {
            style: {
                fontWeight: 'normal',
                fontSize: '15px',
                textDecoration: 'underline',
                color: '#363636'
            }
        },
        subtitle: {
            //text: 'Source: <a href=\"https://en.wikipedia.org/wiki/World_population\">Wikipedia.org</a>'
        },
        xAxis: {
            categories:  Object.keys(usageData),
            title: {
                text: 'Geographic Locations',
                align: 'middle',
                offset: 40,
                style: {'fontWeight': 'bold',  'color': '#363636'}
            }
        },
        yAxis: {
            min: 0,
            max: 100,
            lineWidth: 1,
            tickWidth: 1,
            title: {
                text: 'Percentage MAS requests <br/>confirmed negative responses',
                align: 'middle',
                offset: 60,
                style: {'fontWeight': 'bold', 'color': '#363636'}
            },
            labels: {
                format: '{value}%',
                overflow: 'justify'
            },
        },
        tooltip: {
            valueSuffix: ' requests',
            formatter: function (){
                return this.x + ': ' + '<strong>' + this.y + '%' + '</strong>';
            }
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -40,
            y: 80,
            floating: true,
            borderWidth: 1,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            shadow: true,
            enabled: false
        },
        credits: {
            enabled: false
        },
        series: [{ data: Object.values(usageData)}]
    });
}

function drawCounterfeitsCountByProductChart(usageData){
    log(usageData);
    dataArray  = [];
    for(key in usageData){
        dataArray[key] = parseInt(usageData[key].fakesCount);
    }

    Highcharts.chart('counterfeits2', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Confirmed negative responses per product'
        },
        lang: {
            noData: 'No data to display'
        },
        noData: {
            style: {
                fontWeight: 'normal',
                fontSize: '15px',
                textDecoration: 'underline',
                color: '#363636'
            }
        },
        subtitle: {
            //text: 'Source: <a href=\"https://en.wikipedia.org/wiki/World_population\">Wikipedia.org</a>'
        },
        xAxis: {
            categories:  Object.keys(dataArray),
            title: {
                text: 'Products',
                align: 'middle',
                offset: 70,
                style: {'fontWeight': 'bold',  'color': '#363636'}
            }
        },
        yAxis: {
            min: 0,
            lineWidth: 1,
            tickWidth: 1,
            title: {
                text: 'Number of negative responses',
                align: 'middle',
                offset: 60,
                style: {'fontWeight': 'bold', 'color': '#363636'}
            },
            labels: {
                overflow: 'justify'
            },
            tickAmount: 5
        },
        tooltip: {
            valueSuffix: ' requests',
            formatter: function (){
                return this.x + ': ' + '<strong>' + this.y + '</strong>';
            }
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -40,
            y: 80,
            floating: true,
            borderWidth: 1,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            shadow: true,
            enabled: false
        },
        credits: {
            enabled: false
        },
        series: [{ data: Object.values(dataArray) }]
    });
}