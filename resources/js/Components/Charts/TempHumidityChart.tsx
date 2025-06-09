import {Unit} from '../../Services/Enums';
import {valueToPercentage} from '../../Services/chart-utils';
import HalfRadialBarChart from './HalfRadialBarChart';
import Wave from 'react-wavify';

const TempHumidityChart = ({ size, temperature, humidity, fontSize }: { size: number, temperature: number, humidity: number, fontSize: string }) => {
    return <div className='grid w-fit' >
        <div className="col-start-1 row-start-1 z-10">
            <HalfRadialBarChart
                unit={Unit.Percent}
                chartColor={"#1992D4"}
                chartGradientColor={temperature > 23? "#CB6E17" : ''}
                offset={{ top: 7, bottom: -7}}
                value={valueToPercentage(temperature)}
                size={size}
            />
        </div>
        <div
            className={`flex flex-col col-start-1 row-start-1 justify-center items-center z-10 text-black-50 ${fontSize}`}>
            <div>{`${temperature} ${Unit.DegreesCelsius}`}</div>
            <div className='w-1/3 h-0.5 bg-black-50 rounded my-2'></div>
            <div>{`${humidity} %`}</div>
        </div>
        <div className='col-start-1 row-start-1 flex justify-center items-center'>
            <div className='relative h-1/2 w-1/2 rounded-full'>
                <Wave
                    fill={'#127FBF'}
                    options={{
                        amplitude: 10,
                        speed: 0.15,
                        points: 3
                    }}
                    style={{ height: `${humidity}%` }}
                    className='absolute bottom-0 left-0'
                />
            </div>
        </div>
    </div>
}

export default TempHumidityChart;