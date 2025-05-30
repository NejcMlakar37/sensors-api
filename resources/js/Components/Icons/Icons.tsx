import {FontAwesomeIcon} from '@fortawesome/react-fontawesome';
import React, {memo} from 'react';
import {
    faArrowRightFromBracket,
    faArrowRotateLeft,
    faArrowUpRightFromSquare,
    faBook,
    faBuilding,
    faCalendarDays,
    faCar,
    faCheck,
    faChevronDown,
    faChevronLeft,
    faChevronRight,
    faChevronUp,
    faCircleCheck,
    faCodeBranch,
    faCoins,
    faDroplet,
    faEdit,
    faExclamation,
    faFileLines,
    faFilePdf,
    faFilter,
    faGears,
    faHouse,
    faImage,
    faLocationDot,
    faLock,
    faMagnifyingGlass,
    faMoneyCheckDollar,
    faPaperclip,
    faPlus,
    faRoute,
    faSpinner,
    faTemperatureLow,
    faUser,
    faWrench,
} from '@fortawesome/free-solid-svg-icons';
import {faCircleQuestion, faCircleXmark, faClock, faFloppyDisk} from '@fortawesome/free-regular-svg-icons';

const Icons = {
    Add: memo(({ color, size }: IconProps) => {
        return <FontAwesomeIcon icon={faPlus} color={color} size={size}/>;
    }),

    Calendar: memo(({ color, size }: IconProps) => {
        return <FontAwesomeIcon icon={faCalendarDays} color={color} size={size}/>;
    }),

    Car: memo(({ color, size }: IconProps) => {
        return <FontAwesomeIcon icon={faCar} color={color} size={size}/>;
    }),

    Check: memo(({ color, size }: IconProps) => {
        return <FontAwesomeIcon icon={faCheck} color={color} size={size}/>;
    }),

    CircleCheck: memo(({ color, size }: IconProps) => {
        return <FontAwesomeIcon icon={faCircleCheck} color={color} size={size}/>;
    }),

    ChevronUp: memo(({ color, size }: IconProps) => {
        return <FontAwesomeIcon icon={faChevronUp} color={color} size={size}/>;
    }),

    ChevronDown: memo(({ color, size }: IconProps) => {
        return <FontAwesomeIcon icon={faChevronDown} color={color} size={size}/>;
    }),

    ChevronLeft: memo(({ color, size }: IconProps) => {
        return <FontAwesomeIcon icon={faChevronLeft} color={color} size={size}/>;
    }),

    ChevronRight: memo(({ color, size }: IconProps) => {
        return <FontAwesomeIcon icon={faChevronRight} color={color} size={size}/>;
    }),

    Delete: memo(({ color, size }: IconProps) => {
        return <FontAwesomeIcon icon={faCircleXmark} size={size} color={color} className="self-center"/>;
    }),

    Edit: memo(({ color, size }: IconProps) => {
        return <FontAwesomeIcon icon={faEdit} color={color} size={size}/>;
    }),

    Exclamation: memo(({ color, size }: IconProps) => {
        return <FontAwesomeIcon icon={faExclamation} color={color} size={size}/>;
    }),

    Gear: memo(({ color, size }: IconProps) => {
        return <FontAwesomeIcon icon={faGears} color={color} size={size}/>;
    }),

    House: memo(({ color, size }: IconProps) => {
        return <FontAwesomeIcon icon={faHouse} color={color} size={size}/>;
    }),

    Lock: memo(({ color, size }: IconProps) => {
        return <FontAwesomeIcon icon={faLock} color={color} size={size}/>;
    }),

    Notebook: memo(({ color, size }: IconProps) => {
        return <FontAwesomeIcon icon={faBook} color={color} size={size}/>;
    }),

    Building: memo(({ color, size }: IconProps) => {
        return <FontAwesomeIcon icon={faBuilding} color={color} size={size}/>;
    }),

    Code: memo(({ color, size }: IconProps) => {
        return <FontAwesomeIcon icon={faCodeBranch} color={color} size={size}/>;
    }),

    Paperclip: memo(({ color, size }: IconProps) => {
        return <FontAwesomeIcon icon={faPaperclip} color={color} size={size}/>;
    }),

    Print: memo(({ color, size }: IconProps) => {
        return <FontAwesomeIcon icon={faFilePdf} color={color} size={size}/>;
    }),

    Search: memo(({ color, size }: IconProps) => {
        return <FontAwesomeIcon icon={faMagnifyingGlass} color={color} size={size}/>;
    }),

    Filter: memo(({ color, size }: IconProps) => {
        return <FontAwesomeIcon icon={faFilter} color={color} size={size}/>;

    }),

    User: memo(({ color, size }: IconProps) => {
        return <FontAwesomeIcon icon={faUser} color={color} size={size}/>;
    }),

    Location: memo(({ color, size }: IconProps) => {
        return <FontAwesomeIcon icon={faLocationDot} color={color} size={size}/>;
    }),

    Document: memo(({ color, size }: IconProps) => {
        return <FontAwesomeIcon icon={faFileLines} color={color} size={size}/>;
    }),

    Reset: memo(({ color, size }: IconProps) => {
        return <FontAwesomeIcon icon={faArrowRotateLeft} color={color} size={size}/>;
    }),

    Info: memo(({ color, size }: IconProps) => {
        return <FontAwesomeIcon icon={faCircleQuestion} color={color} size={size}/>;
    }),

    Exit: memo(({ color, size }: IconProps) => {
        return <FontAwesomeIcon icon={faArrowRightFromBracket} color={color} size={size}/>;
    }),

    Money: memo(({ color, size }: IconProps) => {
        return <FontAwesomeIcon icon={faCoins} color={color} size={size}/>;
    }),

    PriceList: memo(({ color, size }: IconProps) => {
        return <FontAwesomeIcon icon={faMoneyCheckDollar} color={color} size={size}/>;
    }),

    Wrench: memo(({ color, size }: IconProps) => {
        return <FontAwesomeIcon icon={faWrench} color={color} size={size}/>;
    }),

    Route: memo(({ color, size }: IconProps) => {
        return <FontAwesomeIcon icon={faRoute} color={color} size={size}/>;
    }),

    Status: memo(({ color, size }: IconProps) => {
        return <FontAwesomeIcon icon={faSpinner} color={color} size={size}/>;
    }),

    Image: memo(({ color, size }: IconProps) => {
        return <FontAwesomeIcon icon={faImage} color={color} size={size}/>;
    }),

    Time: memo(({ color, size }: IconProps) => {
        return <FontAwesomeIcon icon={faClock} color={color} size={size}/>;
    }),

    Save: memo(({ color, size }: IconProps) => {
        return <FontAwesomeIcon icon={faFloppyDisk} color={color} size={size}/>;
    }),

    Extend: memo(({ color, size }: IconProps) => {
        return <FontAwesomeIcon icon={faArrowUpRightFromSquare} color={color} size={size}/>;
    }),

    Temperature: memo(({ color, size }: IconProps) => {
        return <FontAwesomeIcon icon={faTemperatureLow} color={color} size={size}/>;
    }),

    Humidity: memo(({ color, size }: IconProps) => {
        return <FontAwesomeIcon icon={faDroplet} color={color} size={size}/>;
    }),
};

export default Icons;
