import {ReactNode} from 'react';
import HeaderCell from './HeaderCell';

const HeaderRow = ({columns}: {columns: ReactNode[]}) => {
    return <thead className="border-b border-black-100">
    <tr>
        {columns.map((child, index) => <HeaderCell key={index}>{child}</HeaderCell>)}
    </tr>
    </thead>;
};

export default HeaderRow;