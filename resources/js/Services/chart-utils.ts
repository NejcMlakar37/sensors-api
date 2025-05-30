export const getChartData = (measurements: Measurement[], key: string) => {
    const data = measurements.map(item => [new Date(item.timestamp).getTime(), item[key]]);
    return [{ name: key, data: data }];
}

export const getDefaultDates = (date: Date) => {
    const start = formatDateToString(date) + ' 00:00:00';
    const end = formatDateToString(date) + ' 24:00:00';
    return {start, end};
}

export const formatDateToString = (date: Date): string => {
    return date.toISOString().split('T')[0];
}

export const valueToPercentage = (value: number) => {
    const min = 16;
    const max = 38;
    if (value > 32) value = 32;
    return ((value - min) * 100) / (max - min);
}