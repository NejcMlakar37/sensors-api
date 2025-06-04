import DatePickerComponent from "./DatePickerComponent";

const DateFilterComponent = ({dateFilters, callback}: {
    dateFilters: DateFilter[],
    callback: (name: string, value: string) => void
}) => {
    return <div className='flex flex-row space-x-5'>
        {dateFilters.map(date => <DatePickerComponent key={date.name} value={date.value} title={date.title}
                                                      fieldName={date.name} handleChange={callback}/>)}
    </div>;
}

export default DateFilterComponent;