import {ApexOptions} from 'apexcharts';

const halfRadialChartOptions = (unit: string, chartColor: string, chartGradientColor: string, offset: {top: number, bottom :number}): ApexOptions => ({
    chart: {
        toolbar: {
            show: false
        },
        sparkline: {
            enabled: true
        },
        fontFamily: 'Roboto',
    },
    plotOptions: {
        radialBar: {
            dataLabels: {
                show: true,
                value: {
                    show: false,
                    color: '#E4E7EB',
                    offsetY: offset.bottom,
                    fontFamily: 'Roboto',
                    fontSize: '1rem',
                    fontWeight: 'semi-bold',
                    formatter: (val: number): string => (isNaN(val)) ? '/' : `${val} ${unit}`,
                },
                name: {
                    offsetY: offset.top,
                    show: true,
                    color: '#E4E7EB',
                    fontFamily: 'Roboto',
                    fontSize: '1rem',
                    fontWeight: 'semi-bold',
                },
            },
            track: {
                background: '#323F4BFF',
                strokeWidth: '120%',
                dropShadow: {
                    enabled: true,
                    top: 4,
                    left: 2,
                    blur: 4,
                    opacity: 0.4
                }
            },
            startAngle: -130,
            endAngle: 230,
            hollow: {
                margin: 0,
                size: '50%',
                background: 'transparent',
                image: undefined,
                imageOffsetX: 0,
                imageOffsetY: 0,
                position: 'front',
                dropShadow: {
                    enabled: true,
                    top: 3,
                    left: 0,
                    blur: 4,
                    opacity: 0.24
                }
            }
        },
    },
    fill: {
        colors: [chartColor],
        type: 'gradient',
        gradient: {
            type: 'horizontal',
            shade: 'dark',
            shadeIntensity: 0.4,
            inverseColors: false,
            gradientToColors: [chartGradientColor],
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 100]
        },
    },
    labels: [''],
});

export default halfRadialChartOptions;
