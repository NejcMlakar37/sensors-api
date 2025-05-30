import Icons from './Icons';

const AlertBadge = ({isTemp}: {isTemp: boolean}) => {
    return <div className={"absolute top-[-15px] right-[-35px] -z-50 border-transparent bg-red-400/90 px-3 py-[0.5px] rounded-full text-white animate-pulse "}>
        {isTemp ?
            <Icons.Temperature size={'2xs'} color={'white'} /> :
            <Icons.Humidity size={'2xs'} color={'white'} />
        }
    </div>
};

export default AlertBadge;