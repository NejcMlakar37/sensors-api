const IconButton = ({props}: { props: IconButtonProps }) => {
    return <button className={`rounded px-4 rounded-xl ${props.color} ${props.activeColor}`}
                   onClick={props.onClick} type="button" title={props.title}>
        {props.icon}
    </button>
}

export default IconButton;