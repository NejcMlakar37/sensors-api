import EmptyBatteryIcon from './EmptyBatteryIcon';
import FullBatteryIcon from './FullBatteryIcon';
import HalfEmptyBatteryIcon from './HalfEmptyBatteryIcon';

const BatteryIconController = ({value}: {value: string | number}) => {
    console.log(value);

    if(value === '/') {
        return <EmptyBatteryIcon color={'#323F4B'} size={'lg'} />;
    }

    if(Number(value) > 25) {
        return <FullBatteryIcon color={'#27AB83'} size={'lg'} />;
    } else if(Number(value) > 8) {
        return <HalfEmptyBatteryIcon color={'#F0B429'} size={'lg'} />;
    } else {
        return <EmptyBatteryIcon color={'#E12D39'} size={'lg'} />;
    }
}

export default BatteryIconController;