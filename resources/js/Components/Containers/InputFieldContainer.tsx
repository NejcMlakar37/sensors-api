import {memo, ReactNode} from 'react';

const InputFieldContainer = memo(({ children }: {children: ReactNode}) => {
    return <div className="flex flex-row grow align-middle justify-start items-center text-start space-x-4 focus-within:shadow-lg">
        {children}
    </div>;
});

export default InputFieldContainer;