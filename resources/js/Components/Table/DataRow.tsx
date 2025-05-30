import {ReactNode} from 'react';

const DataRow = ({children}: {children: ReactNode}) => {
    return <tr className="even:bg-black-200/20 justify-center items-center text-center hover:scale-[0.97] transition-all ease-in-out hover:bg-blue-200/20 hover:cursor-default">
        {children}
    </tr>
}

export default DataRow;