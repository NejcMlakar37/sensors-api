import {useCallback, useMemo, useState} from 'react';
import {getDefaultDates} from '../Services/chart-utils';

const useFilter = (dates: DateFilter[]) => {
    const [dateFilters, setDateFilters] = useState<DateFilter[]>(dates);

    const handleFiltersChange = useCallback((name: string, value: string) => {
        setDateFilters(prev => prev.map(prevValue => (prevValue.name === name) ? {...prevValue, value: value} : prevValue));
    }, []);

    const queryString = useMemo(() => {
        if (dateFilters[0].value === '' || dateFilters[1].value === '') {
            const nonEmptyDate = dateFilters.find((date: DateFilter) => date.value !== '');
            if (nonEmptyDate) {
                return `filter[timestamp]=${nonEmptyDate.value} 00:00:00,${nonEmptyDate.value} 24:00:00`;
            } else {
                const defaultDates = getDefaultDates(new Date());
                return `filter[timestamp]=${defaultDates.start},${defaultDates.end}`;
            }
        } else {
            return `filter[timestamp]=${dateFilters[0].value},${dateFilters[1].value}`;
        }
    }, [dateFilters]);

    return [dateFilters, queryString, handleFiltersChange] as const;
}

export default useFilter;