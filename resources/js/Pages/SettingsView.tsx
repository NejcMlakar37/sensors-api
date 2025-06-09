import LimitsView from './LimitsView';
import RecipientsView from './RecipientsView';

const SettingsView = ({sensor, limit, recipients}: {sensor: Sensor, limit: SensorLimit, recipients: Recipient[]}) => {
    return <div
        className="flex flex-col items-center space-y-10 w-full">
            <LimitsView sensor={sensor} sensorLimit={limit}/>
            <RecipientsView sensor={sensor} recipients={recipients}/>
    </div>;
};

export default SettingsView;