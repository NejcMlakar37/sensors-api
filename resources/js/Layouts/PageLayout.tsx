import {ReactElement} from 'react';
import Sidebar from './Sidebar';
import {ToastContainer} from 'react-toastify';
import useToastMessages from '../Hooks/useToastMessages';

const PageLayout = ({children}: {children: ReactElement}) => {
    useToastMessages();

    return <div className="flex flex-row min-h-screen min-w-screen bg-black-700 text-black-900 font-roboto">
        <Sidebar />
        <div className="flex-row w-full justify-center align-middle">
                {children}
        </div>
        <ToastContainer
            position="bottom-center"
            autoClose={1000}
            hideProgressBar={false}
            newestOnTop={false}
            closeOnClick
            rtl={false}
            pauseOnFocusLoss={false}
            draggable={false}
            pauseOnHover={false}
            theme="light"
        />
    </div>
}

export default PageLayout;