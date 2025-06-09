import {useEffect} from 'react';
import {router} from '@inertiajs/react';

const intervalMinutes = parseInt(import.meta.env.VITE_AUTO_REFRESH_INTERVAL || '10');

const useReload = () => {
    useEffect(() => {
        const interval = setInterval(() => {
            router.reload({
                preserveState: false,
                preserveScroll: true
            });
        }, intervalMinutes * 30 * 1000);

        return () => clearInterval(interval);
    }, []);
}

export default useReload;