import {usePage} from '@inertiajs/react';
import PageLayout from '../Layouts/PageLayout';
import SensorCard from '../Components/Cards/SensorCard';

const Home = () =>  {
    const { sensorsWithLatest } = usePage<{sensorsWithLatest: SensorWithLatest[] }>().props;

    return <div className={'grid grid-cols-2 lg:grid-cols-4 gap-y-12'}>
        {sensorsWithLatest.map((sensor: SensorWithLatest) => (
          <SensorCard props={sensor} />
        ))}
    </div>;
}

Home.layout = page => <PageLayout>{page}</PageLayout>;

export default Home;
