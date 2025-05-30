import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {faBatteryEmpty} from "@fortawesome/free-solid-svg-icons";

const EmptyBatteryIcon = ({ color, size }: IconProps) => {
    return <FontAwesomeIcon color={color} size={size} icon={faBatteryEmpty}/>;
};

export default EmptyBatteryIcon;