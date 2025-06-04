import PageLayout from '../Layouts/PageLayout';
import {getChartData, getDatesFromURL, getDefaultDates} from '../Services/chart-utils';
import {useCallback, useState} from 'react';
import TabBarButton from '../Components/Buttons/TabBarButton';
import {Type, Unit} from '../Services/Enums';
import AlertBadge from '../Components/Icons/AlertBadge';
import LineChart from '../Components/Charts/LineChart';
import IncidentsView from './IncidentsView';
import SettingsView from './SettingsView';
import useReload from '../Hooks/useReload';
import MeasurementsFilterComponent from '../Components/Filters/MeasurementsFilterComponent';
import DateFilterComponent from '../Components/Filters/DateFilterComponent';
import {Link, router} from '@inertiajs/react';
import Icons from '../Components/Icons/Icons';

const SingleSensorView = ({sensor, measurements, incidents, limit, recipients}: {sensor: SensorWithLatest, measurements: Measurement[], incidents: Incident[], limit: SensorLimit, recipients: Recipient[] }) => {
    const [activeTab, setActiveTab] = useState<number>(1);
    const [isTemperature, setIsTemperature] = useState<boolean>(true);
    const [isHumidity, setIsHumidity] = useState<boolean>(true);
    const [dateFilters, setDateFilters] = useState<DateFilter[]>(getDatesFromURL());
    useReload();

    const getQueryString = useCallback((dateFilters: DateFilter[]) => {
        if (dateFilters[0].value === '' || dateFilters[1].value === '') {
            const nonEmptyDate = dateFilters.find((date: DateFilter) => date.value !== '');
            if (nonEmptyDate) {
                return `filter[timestamp]=${nonEmptyDate.value} 00:00:00,${nonEmptyDate.value} 24:00:00`;
            } else {
                const defaultDates = getDefaultDates(new Date());
                return `filter[timestamp]=${defaultDates.start},${defaultDates.end}`;
            }
        } else {
            return `filter[timestamp]=${dateFilters[0].value},${dateFilters[1].value}`;
        }
    }, [])

    const handleFiltersChange = useCallback((name: string, value: string) => {
        const filters: DateFilter[] = dateFilters.map((dateFilter: DateFilter): DateFilter => dateFilter.name === name? {...dateFilter, value: value} : dateFilter );
        router.get(`/sensors/${sensor.id}?${getQueryString(filters)}`, {
            only: ['measurements'],
            replace: true,
            preserveState: true,
            preserveScroll: true
        })
    }, []);

    const handleCheckedChange = (type: Type) => {
        if (type === Type.Temperature) {
            setIsTemperature(!isTemperature);
        } else {
            setIsHumidity(!isHumidity);
        }
    }

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
        <div className='flex flex-row p-4'>
            <div className='flex flex-col w-full space-y-8'>
                <div className='flex flex-row justify-between items-center'>
                    <div className={'flex flex-row items-center justify-center space-x-5'}>
                        <MeasurementsFilterComponent
                            sensor={sensor}
                            isTemperature={isTemperature}
                            isHumidity={isHumidity}
                            handleClicked={handleCheckedChange}
                        />
                    </div>
                    <DateFilterComponent dateFilters={dateFilters} callback={handleFiltersChange}/>
                </div>

                <div
                    className="flex flex-row w-full items-center justify-between text-lg font-medium border-b-2 pb-4 border-black-100/25">
                    <div className={'flex flex-row items-center justify-center space-x-5'}>
                        {tabs.map(tab => (tab.button))}
                    </div>
                    <div className={'flex flex-row items-center justify-center space-x-5'}>
                        <div className='flex justify-center hover:scale-125 transition-all ease-in-out'>
                            <Link href={`/sensors/full-screen/${sensor.id}`}
                                  className={'text-black-100 hover:text-blue-300'}>
                                <Icons.Extend size={"xl"}/>
                            </Link>
                        </div>
                        <div className='flex justify-center hover:scale-125 transition-all ease-in-out'>
                            <Link
                                href={`${import.meta.env.VITE_API_BASE_URL}measurement/export?filter[sensor_id]=${sensor.id}&filter[timestamp]=${dateFilters[0].value},${dateFilters[1].value}`}
                                target={'_blank'}
                                className={'text-black-100 hover:text-teal-600'}>
                                <Icons.Excel size={"xl"}/>
                            </Link>
                        </div>
                    </div>
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