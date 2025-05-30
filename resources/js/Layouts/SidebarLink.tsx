import {Link} from '@inertiajs/react';

const SidebarLink = (props: LinkProps) => {
    return <Link className={`${props.active? 'text-blue-300 border-r-2': ''} 
        group transition-all ease-in-out hover:text-blue-300 hover:border-r-2 py-1 ps-4 pe-4`
    } href={props.location}>
        <div className={`flex flex-row justify-between items-center group-hover:scale-105 transition-all ease-in-out ${props.activeAlarm ? 'animate-pulse text-red-400' : ''}`}>
            <div className={'w-4/5 text-start'}>{props.label} </div>
            <div> {props.icon} </div>
        </div>
    </Link>
}

export default SidebarLink;