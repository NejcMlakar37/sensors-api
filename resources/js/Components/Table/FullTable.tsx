import {ReactNode} from 'react';

const FullTable = ({children}: {children: ReactNode}) => {
    return <table className="w-full justify-center items-center">
        {children}
    </table>
}

export default FullTable;