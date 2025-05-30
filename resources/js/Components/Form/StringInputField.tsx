import InputFieldContainer from '../Containers/InputFieldContainer';
import InputFieldLabel from './InputFieldLabel';
import {memo, useId} from 'react';

const StringInputField = memo(({props}: { props: StringInputProps }) => {
    const inputId: string = useId();

    return <InputFieldContainer>
        {props.label !== undefined &&
            <InputFieldLabel label={props.label} labelFor={inputId}/>
        }
        <input
            className="bg-white rounded border border-gray-200 p-2.5 text-gray-500 focus:border-primary-600 focus:outline-none"
            id={inputId}
            name={props.fieldName}
            required={props.required}
            maxLength={(props.maxLength ? props.maxLength : 524288)}
            type={props.type}
            minLength={(props.minLength ? props.minLength : 4)}
            placeholder={props.defaultValue as string}
            value={props.value as string}
            onChange={(e) => props.onChange?.(props.fieldName, e.target.value)}
            disabled={props.disabled}
        />
    </InputFieldContainer>;
});

export default StringInputField;