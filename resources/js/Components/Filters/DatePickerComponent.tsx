const DatePickerComponent = ({title, value, fieldName, handleChange}: {
    title: string,
    value: string,
    fieldName: string,
    handleChange: (name: string, value: string) => void
}) => {
    return (
        <div className={'relative'}>
            <div className="absolute left-0 ml-1 text-black-50 -translate-y-4 px-1 text-lg bg-black-700">
                <label htmlFor={fieldName}>
                    {title}
                </label>
            </div>
            <input
                className='bg-black-700 text-lg text-black-50 peer w-full placeholder:text-transparent focus:border-blue-300 focus:outline-none border-2 border-solid rounded-md px-4 py-2'
                   type='date' required
                   value={value}
                   name={fieldName}
                   onChange={(e) => handleChange(e.target.name, e.target.value)}
            />
        </div>
    );
}

export default DatePickerComponent;