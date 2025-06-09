import CheckboxMeasurement from './CheckboxMeasurement';
import {Type, Unit} from '../../Services/Enums';
import Icons from '../Icons/Icons';

const MeasurementsFilterComponent = ({ sensor, isTemperature, isHumidity, handleClicked }: MeasurementsFilterComponentProps ) => {
    return <div className='flex flex-row text-2xl space-x-5 justify-center m-auto'>
        <CheckboxMeasurement
            checked={isTemperature}
            activeColor={'bg-red-300'}
            hoverColor={'hover:from-red-300 hover:to-yellow-200'}
            handleClicked={() => handleClicked(Type.Temperature)}>
            {sensor.latest_measurement.temperature}{Unit.DegreesCelsius}&nbsp;<Icons.Temperature size={"xs"} />
        </CheckboxMeasurement>
        <CheckboxMeasurement
            checked={isHumidity}
            handleClicked={() => handleClicked(Type.Humidity)}
            activeColor={'bg-blue-300'}
            hoverColor={'hover:from-blue-300 hover:to-teal-200'}>
            {sensor.latest_measurement.humidity}{Unit.Percent}&nbsp;<Icons.Humidity size={"xs"}/>
        </CheckboxMeasurement>
    </div>;
}

export default MeasurementsFilterComponent;