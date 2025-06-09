import {memo, useId} from 'react';
import InputFieldContainer from '../Containers/InputFieldContainer';
import InputFieldLabel from './InputFieldLabel';

const NumberInputField = memo(({props}: { props: NumberInputProps }) => {
    const inputId: string = useId();

    return <InputFieldContainer>
        {props.label !== undefined &&
            <InputFieldLabel label={props.label} labelFor={props.fieldName}/>
        }
        <input
            className="bg-white rounded border border-gray-200 py-2 px-1 text-center text-md text-black-600 focus:border-primary-600 focus:outline-none"
            id={inputId}
            name={props.fieldName}
            required={props.required}
            max={props.max ?? 999}
            min={props.min ?? 1}
            step={props.step ?? 0.01}
            type={'number'}
            value={props.value as string}
            onChange={(e) => props.onChange?.(props.fieldName, Number(e.target.value))}
            disabled={props.disabled}
        />
    </InputFieldContainer>;
});

export default NumberInputField;