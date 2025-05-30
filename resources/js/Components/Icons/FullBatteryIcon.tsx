import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {faBatteryFull} from "@fortawesome/free-solid-svg-icons";

const FullBatteryIcon = ({ color, size }: IconProps) => {
    return <FontAwesomeIcon color={color} size={size} icon={faBatteryFull}/>;
};

export default FullBatteryIcon;