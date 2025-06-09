import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {faBatteryHalf} from "@fortawesome/free-solid-svg-icons";

const HalfEmptyBatteryIcon = ({ color, size }: IconProps) => {
    return <FontAwesomeIcon color={color} size={size} icon={faBatteryHalf}/>;
};

export default HalfEmptyBatteryIcon;