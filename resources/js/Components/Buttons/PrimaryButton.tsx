const PrimaryButton = ({props}: {props: ButtonProps}) => {
    return <button className={`flex ${props.styling} align-middle justify-center space-x-4 rounded py-2 hover:cursor-pointer px-8 text-primary-100 ${props.color} ${props.direction} 
                            ${props.activeColor}`}
                   onClick={props.onClick} type={props.type} form={props.form}>
        {props.icon !== undefined &&
            <div>{props.icon}</div>
        }
        <div>{props.label}</div>
    </button>
}

export default PrimaryButton