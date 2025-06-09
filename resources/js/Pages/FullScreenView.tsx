import TempHumidityChart from '../Components/Charts/TempHumidityChart';
import NativeClock from '../Components/NativeClock';
import useReload from '../Hooks/useReload';

const SensorCurrentView = ({sensor}: {sensor : SensorWithLatest}) => {
    useReload();

    return <div className={'flex h-screen bg-black-700 text-black-900 font-roboto'} >
        <div className='flex md:flex-row justify-between my-auto w-screen flex-col'>
            <div className={'text-center justify-center flex flex-col m-auto space-y-8'}>
                <span className={'text-black-100 text-6xl'}>{sensor.name}</span>
                <NativeClock/>
                <div className={'text-center justify-center flex flex-col m-auto space-y-2'}>
                    <span className={'text-black-100 font-semibold text-6xl grow'}>
                        {new Date().toLocaleDateString()}
                    </span>
                </div>
                <div className="text-black-50 text-3xl">
                    Zadnja posodobitev { sensor.latest_measurement.timestamp }
                </div>
            </div>

            <div className='flex w-1/2 justify-center'>
                <TempHumidityChart size={850} temperature={sensor.latest_measurement.temperature} humidity={sensor.latest_measurement.humidity} fontSize={'text-5xl'}/>
            </div>
        </div>
    </div>
}

export default SensorCurrentView;
