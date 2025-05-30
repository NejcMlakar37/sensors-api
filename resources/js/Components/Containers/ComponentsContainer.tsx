import {ReactNode} from 'react';
import {motion} from 'framer-motion';
import {dropAnimation} from '../../Services/animation-config';

const ComponentsContainer = ({children}: {children: ReactNode})  => {
    return <motion.div layout {...dropAnimation}
        className="flex justify-center w-full items-center rounded-md bg-black-800 border border-black-200/20 drop-shadow-2x text-black-200 p-8">
        {children}
    </motion.div>
}

export default ComponentsContainer;