import {toast} from 'react-toastify';

export const SendSuccessfulToast = (title: string, duration: number = 1500) => {
    if (!toast.isActive(title)) {
        toast.success(title, {
                position: 'bottom-center',
                autoClose: duration,
                hideProgressBar: false,
                closeOnClick: true,
                pauseOnHover: false,
                draggable: false,
                progress: undefined,
                theme: 'light',
                toastId: title,
                style: {
                    textAlign: 'center',
                },
            },
        );
    }
};

export const SendErrorToast = (title: string, duration: number = 2500) => {
    if (!toast.isActive(title)) {
        toast.error(title, {
            position: 'bottom-center',
            autoClose: duration,
            hideProgressBar: false,
            closeOnClick: true,
            pauseOnHover: false,
            draggable: false,
            progress: undefined,
            theme: 'light',
            toastId: title,
            style: {
                textAlign: 'center',
            },
        });
    }
};