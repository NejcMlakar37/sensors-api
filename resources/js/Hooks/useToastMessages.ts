import {usePage} from '@inertiajs/react';
import {useEffect} from 'react';
import {SendErrorToast, SendSuccessfulToast} from '../Services/toast-service';

const useToastMessages = () => {
    const { flash } = usePage<PageProps>().props;
    const { errors } = usePage().props

    useEffect(() => {
        if(flash.success !== null) {
            if(flash.success) {
                SendSuccessfulToast(flash.message ?? '');
            } else {
                SendErrorToast(flash.message ?? '');
            }
        }
    }, [flash]);

    useEffect(() => {
        if(Object.values(errors).length > 0) {
            const allErrorMessages = Object.values(errors).join(', ');
            SendErrorToast(allErrorMessages);
        }
    }, [errors]);
}

export default useToastMessages;