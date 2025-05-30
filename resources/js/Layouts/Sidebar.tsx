import SidebarHeader from './SidebarHeader';
import Icons from '../Components/Icons/Icons';
import {router, usePage} from '@inertiajs/react';
import PrimaryButton from '../Components/Buttons/PrimaryButton';
import SidebarLink from './SidebarLink';
import React from 'react';
import BatteryIconController from '../Components/Icons/BatteryIconController';

const Sidebar = () => {
    const { auth, sensors } = usePage<PageProps>().props;

    console.log(sensors);

    const logoutHandler = () => {
        router.post('/logout');
    };

    return(
        <aside className='w-64 bg-black-900 text-black-100 flex flex-col justify-between'>
            <div className='flex flex-col py-3 space-y-6 justify-center'>
                <SidebarHeader/>
                {sensors.map((sensor: Sensor) => (
                    <SidebarLink key={sensor.id} location={`/sensors/${sensor.id}`}
                                 label={`${sensor.location} (${sensor.name})`}
                                 active={false}
                                 activeAlarm={sensor.active_humid_alert || sensor.active_temp_alert}
                                 icon={<BatteryIconController value={sensor.battery} /> }
                    />
                ))}
                <SidebarLink location={`/floor-plan`} label={`Floor plan`} active={false} activeAlarm={false} />
            </div>
            <div>
                <div className="flex flex-col space-y-2 my-4 justify-center">
                    <div className="flex flex-row justify-center align-middle space-x-2">
                        <div><Icons.User size={"1x"}/></div>
                        <span>{ auth.user?.email ?? '/' }</span>
                    </div>
                    <div className="flex flex-row justify-center align-middle space-x-2">
                        <div><Icons.Building size={"1x"}/></div>
                        <span>{ auth.user?.company.name ?? '/'}</span>
                    </div>
                    <div className="flex flex-row justify-center align-middle space-x-2 text-sm">
                        <div><Icons.Code size={"xs"}/></div>
                        <div>{APP_VERSION}</div>
                    </div>
                </div>
                <PrimaryButton props={{
                    label: 'Izpis',
                    color: 'bg-red-500 text-black-100 w-full',
                    activeColor: 'hover:bg-red-400',
                    direction: 'flex-row-reverse space-x-reverse',
                    icon: <Icons.Edit size={'1x'}/>,
                    onClick: logoutHandler,
                    type: 'button'
                }}/>
            </div>
        </aside>
    );
}

export default Sidebar;