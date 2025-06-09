const CheckboxMeasurement = ({children, checked, handleClicked, activeColor, hoverColor}: CheckBoxProps) => {
    return( 
        <div className={`text-black-50 rounded-md border-2 hover:scale-110 transition-all ease-in-out
        bg-gradient-to-r border-black-50 select-none cursor-pointer ${hoverColor} 
        px-6 py-2 ${checked? 'bg-black-700 drop-shadow-2x l' : activeColor}`} onClick={handleClicked}>
            {children}
        </div>
    );
}

export default CheckboxMeasurement;