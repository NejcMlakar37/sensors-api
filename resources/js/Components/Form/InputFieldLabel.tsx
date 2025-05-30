const InputFieldLabel = ({ label, labelFor }: {label: string, labelFor: string}) => {
    return <label htmlFor={labelFor} className="text-gray-500 text-md ">
        {label}:
    </label>;
};

export default InputFieldLabel;