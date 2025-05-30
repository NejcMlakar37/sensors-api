import {ReactNode} from 'react';

const HeaderCell = ({children}: {children: ReactNode}) => {
    return <th className="p-2">{children}</th>
}

export default HeaderCell;