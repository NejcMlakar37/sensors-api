export function displayMeasurement(value: string, isTemperature: boolean) {
    return `${value}${isTemperature ? '°C' : '%'}`;
}