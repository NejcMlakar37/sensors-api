import MeasurementsFilterComponent from "./MeasurementsFilterComponent";
import DateFilterComponent from "./DateFilterComponent";

const FiltersComponent = (props: FiltersProps ) => {
    return(
        <div>
            <MeasurementsFilterComponent 
                measurement={props.measurement} 
                isTemperature={props.isTemperature}
                isHumidity={props.isHumidity}
                handleClicked={props.handleClickedMeasurement}
            />
            <DateFilterComponent dateFilters={props.dateFilters} callback={props.callbackDate}/>
        </div>
    );
}

export default FiltersComponent;