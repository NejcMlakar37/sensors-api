import {FormEvent, useCallback, useEffect, useState} from 'react';
import {emptyLimit} from '../Services/empty-objects';
import ComponentsContainer from '../Components/Containers/ComponentsContainer';
import Icons from '../Components/Icons/Icons';
import PrimaryButton from '../Components/Buttons/PrimaryButton';
import NumberInputField from '../Components/Form/NumberInputField';
import SectionTitle from '../Components/Titles/SectionTitle';
import {router} from '@inertiajs/react';
import SaveButtonSpinner from '../Components/Icons/SaveButtonSpinner';

const LimitsView = ({sensor, sensorLimit}: {sensor: Sensor, sensorLimit: SensorLimit}) => {
    const [limit, setLimit] = useState<SensorLimit>(sensorLimit?? { ...emptyLimit, sensor: sensor });
    const [isLoading, setIsLoading] = useState<boolean>(false);

    useEffect((): void => {
        setLimit(sensorLimit?? { ...emptyLimit, sensor: sensor });
    }, [sensorLimit, setLimit]);

    const saveLimit = useCallback((e: FormEvent): void => {
        e.preventDefault();
        if (limit.id === -1) {
            router.post('/measurement-limit', {
                    sensor_id: sensor.id,
                    min_temp: limit.min_temp,
                    max_temp: limit.max_temp,
                    min_humidity: limit.min_humidity,
                    max_humidity: limit.max_humidity
                },
                {
                    only: ['limit', 'flash'],
                    onStart: () => setIsLoading(true),
                    onFinish: () => {
                        setIsLoading(false);
                    },
                    preserveState: true,
                    preserveScroll: true,
                });
        } else {
            router.put(`/measurement-limit/${limit.id}`,
                {
                    sensor_id: sensor.id,
                    min_temp: limit.min_temp,
                    max_temp: limit.max_temp,
                    min_humidity: limit.min_humidity,
                    max_humidity: limit.max_humidity
                },
                {
                    only: ['limit', 'flash'],
                    onStart: () => setIsLoading(true),
                    onFinish: () => {
                        setIsLoading(false);
                    },
                    preserveState: true,
                    preserveScroll: true,
                });
        }
    }, [limit, setIsLoading]);

    const inputHandler = useCallback((fieldName: string, value: number ): void => {
        setLimit(prevState => ({
            ...prevState, [fieldName]: value
        }));
    }, [setLimit]);

    return <ComponentsContainer>
        <div className="flex flex-col items-center w-full">
            <div className="flex flex-col items-start w-full space-y-5">
                <SectionTitle label={"Meje za opozorila"} />
                <form id={'limits-form'} className="flex flex-row justify-start items-start w-full" onSubmit={saveLimit}>
                    <NumberInputField props={{
                        fieldName: "min_temp",
                        label: "Spodnja meja temperature",
                        value: limit.min_temp,
                        min: 0,
                        max: 100,
                        step: 0.1,
                        required: true,
                        defaultValue: limit.min_temp,
                        disabled: false,
                        onChange: inputHandler
                    }}/>
                    <NumberInputField props={{
                        fieldName: "max_temp",
                        label: "Zgornja meja temperature",
                        value: limit.max_temp,
                        min: 0,
                        max: 100,
                        step: 0.1,
                        required: true,
                        defaultValue: limit.max_temp,
                        disabled: false,
                        onChange: inputHandler
                    }}/>
                    <NumberInputField props={{
                        fieldName: "min_humidity",
                        label: "Spodnja meja vlage",
                        value: limit.min_humidity,
                        min: 0,
                        max: 100,
                        step: 0.1,
                        required: true,
                        defaultValue: limit.min_humidity,
                        disabled: false,
                        onChange: inputHandler
                    }}/>
                    <NumberInputField props={{
                        fieldName: "max_humidity",
                        label: "Zgornja meja vlage",
                        value: limit.max_humidity,
                        min: 0,
                        max: 100,
                        step: 0.1,
                        required: true,
                        defaultValue: limit.max_humidity,
                        disabled: false,
                        onChange: inputHandler
                    }}/>
                    <PrimaryButton props={{
                        label: 'Shrani',
                        color: 'bg-blue-500 text-black-100',
                        activeColor: 'hover:bg-blue-400',
                        direction: 'flex-row-reverse space-x-reverse',
                        icon: isLoading? <SaveButtonSpinner /> : <Icons.Save size={'1x'}/>,
                        type: 'submit',
                        form: 'limits-form'
                    }}/>
                </form>
            </div>
        </div>
    </ComponentsContainer>
}

export default LimitsView;