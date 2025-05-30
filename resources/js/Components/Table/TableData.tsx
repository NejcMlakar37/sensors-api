import {ReactNode} from 'react';

const TableData = ({children}: {children: ReactNode}) => {
    return <td className="p-2">
        {children}
    </td>
};


export default TableData;