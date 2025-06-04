const IconButton = ({props}: { props: IconButtonProps }) => {
    return <button className={`px-4 rounded-xl hover:cursor-pointer ${props.color} ${props.activeColor}`}
                   onClick={props.onClick} type="button" title={props.title}>
        {props.icon}
    </button>
}

export default IconButton;