import {ApexOptions} from 'apexcharts';

export const lineChartOptions = (id: string, unit: string, strokeColor: string, gradientColor: string[], label: string, min: number, max: number): ApexOptions => ({
    chart: {
        id: id,
        zoom: {
            type: 'x',
            enabled: true,
            autoScaleYaxis: true
        },
        toolbar: {
            autoSelected: 'zoom',
            // tools: {
            //     pan: ReactDomServer.renderToString(PanningIcon({size: 'xl'})),
            //     reset: ReactDomServer.renderToString(ResetIcon({size: 'lg'}))
            // }
        },
        fontFamily: 'Roboto',
        dropShadow: {
            enabled: true,
            color: '#000',
            top: 18,
            left: 7,
            blur: 10,
            opacity: 0.2
        },
    },
    noData: {
        text: 'No data'
    },
    theme: {
        monochrome: {
            enabled: true,
            color: strokeColor
        }
    },
    dataLabels: {
        enabled: false
    },
    grid: {
        borderColor: '#e7e7e7',
        row: {
            colors: ['#52606D', 'transparent'],
            opacity: 0.5
        },
    },
    plotOptions: {
        area: {
            fillTo: 'end'
        }
    },
    markers: {
        size: 0
    },
    xaxis: {
        type: "datetime",
        tickAmount: 15,
        tickPlacement: "on",
        labels: {
            rotateAlways: true,
            show: true,
            maxHeight: 200,
            offsetY: 10,
            style: {
                cssClass: 'font-bold',
                colors: "#F5F7FA",
                fontFamily: 'Roboto'
            },
            formatter: (value: string) => new Date(value).toLocaleString()
        },
        axisBorder: {
            show: true
        },
        axisTicks: {
            show: true
        }
    },
    yaxis: {
        min: min,
        max: max,
        labels: {
            style: {
                cssClass: 'font-bold',
                colors: ['#F5F7FA'],
                fontFamily: 'Roboto'
            },
            formatter: (val: number) => String(val.toFixed(2) + unit)
        }
    },
    tooltip: {
        x: {
            format: 'dd/MM HH:mm'
        }
    },
    stroke: {
        width: 5,
        curve: 'straight',
        lineCap: 'round',
        colors: [...gradientColor],
    },
    title: {
        text: label,
        align: 'left',
        style: {
            fontSize: "20px",
            color: '#F5F7FA'
        }
    },
    fill: {
        type: 'gradient',
        gradient: {
            shade: 'dark',
            gradientToColors: [ '#FCE588', '#81DEFD' ],
            shadeIntensity: 1,
            type: 'vertical',
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 100]
        },
    },
});