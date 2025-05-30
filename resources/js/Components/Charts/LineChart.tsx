import {dropAnimation} from '../../Services/animation-config';
import {motion} from 'framer-motion';
import Chart from 'react-apexcharts';
import {lineChartOptions} from '../../Services/line-chart-config';

const LineChart = ({ id, label, series, unit, strokeColor, gradientColor, min, max }: LineChartProps) => {
    return(
        <motion.div layout {...dropAnimation} className='w-full drop-shadow-lg rounded-lg h-fit'>
            <Chart
                className='bg-black-800 rounded-2xl py-2 px-2'
                series={series}
                height={500}
                type='line'
                options={lineChartOptions(id, unit, strokeColor, gradientColor, label, min, max)}
            />
        </motion.div>
    );
}

export default LineChart;