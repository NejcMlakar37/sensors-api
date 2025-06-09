import {Link} from '@inertiajs/react';
import Icons from '../Icons/Icons';
import {CardBody, CardContainer, CardItem} from '../ui/3d-card';
import TempHumidityChart from '../Charts/TempHumidityChart';

const SensorCard = ({props}: { props: SensorWithLatest }) => {
    return (
        <CardContainer key={props.id} className="inter-var">
            <CardBody
                className="bg-gradient-to-t from-black-900 to-black-800 relative group/card dark:hover:shadow-2xl dark:hover:shadow-emerald-500/[0.1] dark:bg-black dark:border-white/[0.2] border-black/[0.1] w-auto h-auto rounded-xl p-6 border border-blue-900">
                <div className="flex flex-row justify-between items-center">
                    <div></div>
                    <CardItem translateZ="50" className="flex justify-center text-2xl font-semibold text-black-100">
                        {props.location}
                    </CardItem>
                    <CardItem className='flex justify-end'>
                        <Link href={`/sensors/full-screen/${props.id}`}
                              className={'text-black-100 hover:text-blue-200'}>
                            <Icons.Extend size={"lg"}/>
                        </Link>
                    </CardItem>
                </div>
                <CardItem translateZ="100" className="w-full mt-4">
                    <TempHumidityChart size={300}
                                       temperature={props.latest_measurement.temperature ?? 0}
                                       humidity={props.latest_measurement?.humidity ?? 0}
                                       fontSize={'text-base'}
                    />
                </CardItem>
            </CardBody>
        </CardContainer>
    );
}

export default SensorCard;