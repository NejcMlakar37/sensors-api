import {leftSlideAnimation} from '../../Services/animation-config';
import {motion} from 'framer-motion';
import Chart from 'react-apexcharts';
import halfRadialChartOptions from '../../Services/half-radial-chart-config';

const HalfRadialBarChart = ( { value, unit, chartColor, chartGradientColor, size, offset }: { value: number|string, unit: string, chartColor: string, chartGradientColor: string, size: number, offset: {top: number, bottom: number} }) => {
    return <motion.div layout {...leftSlideAnimation} id='chart' className={'w-fit m-auto'}>
        <Chart
            height={size}
            width={size}
            type="radialBar"
            series={[Number(value)]}
            options={halfRadialChartOptions(unit, chartColor, chartGradientColor, offset)}
        />
    </motion.div>;
}

export default HalfRadialBarChart;