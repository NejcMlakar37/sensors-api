import ComponentsContainer from '../Components/Containers/ComponentsContainer';
import FullTable from '../Components/Table/FullTable';
import HeaderRow from '../Components/Table/HeaderRow';
import TableData from '../Components/Table/TableData';
import DataRow from '../Components/Table/DataRow';
import Icons from '../Components/Icons/Icons';
import {displayMeasurement} from '../Services/formatter-service';

const IncidentsView = ({incidents}: {incidents: Incident[]}) => {
    const renderIncidentTypeIcon = (type: string) => {
        return type === "temp" ? (
            <span className="text-yellow-500"><Icons.Temperature size="1x" /></span>
        ) : (
            <span className="text-blue-500"><Icons.Humidity size="1x" /></span>
        );
    };

    return <ComponentsContainer>
        <FullTable>
            <HeaderRow columns={['Tip Incidenta', 'Spodnja meja', 'Vrednost', 'Zgornja meja', 'Datum']}/>
            <tbody>
            {incidents.map((incident: Incident) => {
                return <DataRow key={incident.id}>
                    <TableData>{renderIncidentTypeIcon(incident.type)}</TableData>
                    <TableData>{displayMeasurement(`${incident.min}`, incident.type === "temp")}</TableData>
                    <TableData>{displayMeasurement(`${incident.value}`, incident.type === "temp")}</TableData>
                    <TableData>{displayMeasurement(`${incident.max}`, incident.type === "temp")}</TableData>
                    <TableData>{incident.created_at}</TableData>
                </DataRow>
            })}
            </tbody>
        </FullTable>
    </ComponentsContainer>;
}

export default IncidentsView;