import PageLayout from '../Layouts/PageLayout';
import {getChartData} from '../Services/chart-utils';
import {useState} from 'react';
import TabBarButton from '../Components/Buttons/TabBarButton';
import {Unit} from '../Services/Enums';
import AlertBadge from '../Components/Icons/AlertBadge';
import LineChart from '../Components/Charts/LineChart';
import IncidentsView from './IncidentsView';
import SettingsView from './SettingsView';
import useReload from '../Hooks/useReload';

const SingleSensorView = ({sensor, measurements, incidents, limit, recipients}: {sensor: Sensor, measurements: Measurement[], incidents: Incident[], limit: SensorLimit, recipients: Recipient[] }) => {
    const [activeTab, setActiveTab] = useState<number>(1);
    useReload();

    const tabs = [
        {
            id: 1,
            button: <TabBarButton key={1} index={1} title={'Temperatura'} active={1 === activeTab}
                                  onClick={setActiveTab}/>,
            content: <LineChart
                id='temp-line-chart'
                label={'Temperatura'}
                min={0}
                max={50}
                series={getChartData(measurements, 'temperature')}
                unit={Unit.DegreesCelsius}
                strokeColor={'#3E4C59'}
                gradientColor={['#F86A6A']}
            />
        },
        {
            id: 2,
            button: <TabBarButton key={2} index={2} title={'Vlaga'} active={2 === activeTab}
                                  onClick={setActiveTab}/>,
            content: <LineChart
                id='humidity-line-chart'
                label={'Vlaga'}
                min={0}
                max={100}
                series={getChartData(measurements, 'humidity')}
                unit={Unit.Percent}
                strokeColor={'#2BB0ED'}
                gradientColor={['#5ED0FA']}
            />
        },
        {
            id: 3,
            button: <TabBarButton key={3} index={3} title={
                <div className={"relative z-10"}>
                    Incidenti
                    {(sensor?.active_humid_alert || sensor?.active_temp_alert) &&
                        <AlertBadge isTemp={sensor.active_temp_alert ?? false}/>
                    }
                </div>
            } active={3 === activeTab} onClick={setActiveTab}/>,
            content: <IncidentsView incidents={incidents} />
        },
        {
            id: 4,
            button: <TabBarButton key={4} index={4} title={'Nastavitve'} active={4 === activeTab}
                                  onClick={setActiveTab}/>,
            content: <SettingsView sensor={sensor} limit={limit} recipients={recipients} />
        }
    ];

    return (
        <div className='flex flex-row'>
            <div className='flex flex-col w-full space-y-8'>
                {/*<div className='flex flex-row justify-between items-center'>*/}
                {/*    <div className={'flex flex-row items-center justify-center space-x-5'}>*/}
                {/*        <MeasurementsFilterComponent*/}
                {/*            sensorId={sensorId}*/}
                {/*            isTemperature={isTemperature}*/}
                {/*            isHumidity={isHumidity}*/}
                {/*            handleClicked={handleCheckedChange}*/}
                {/*        />*/}
                {/*    </div>*/}
                {/*    <DateFilterComponent dateFilters={dateFilters} callback={handleDateFilterChange}/>*/}
                {/*</div>*/}

                <div
                    className="flex flex-row w-full items-center justify-between space-x-5 text-lg font-medium border-b-2 pb-4 border-black-100/25">
                    <div className={'flex flex-row items-center justify-center space-x-5'}>
                        {tabs.map(tab => (tab.button))}
                    </div>
                    {/*<div className={'flex flex-row items-center justify-center space-x-5'}>*/}
                    {/*    <div className='flex justify-center m-auto hover:scale-125 transition-all ease-in-out'>*/}
                    {/*        <Link to={`/sensors/full-screen/${sensorId}`}*/}
                    {/*              className={'text-black-100 hover:text-blue-300'}>*/}
                    {/*            <ExtendIcon size={"xl"}/>*/}
                    {/*        </Link>*/}
                    {/*    </div>*/}
                    {/*    <div className='flex justify-center m-auto hover:scale-125 transition-all ease-in-out'>*/}
                    {/*        <Link*/}
                    {/*            to={`${import.meta.env.VITE_API_BASE_URL}measurement/export?filter[sensor_id]=${sensorId}&filter[timestamp]=${dateFilters[0].value},${dateFilters[1].value}`}*/}
                    {/*            target={'_blank'}*/}
                    {/*            className={'text-black-100 hover:text-teal-600'}>*/}
                    {/*            <ExcelIcon size={"xl"}/>*/}
                    {/*        </Link>*/}
                    {/*    </div>*/}
                    {/*</div>*/}
                </div>

                <div className='flex'>
                    {tabs.find(tab => tab.id === activeTab)?.content}
                </div>
            </div>
        </div>
    );
}

SingleSensorView.layout = page => <PageLayout>{page}</PageLayout>;

export default SingleSensorView;