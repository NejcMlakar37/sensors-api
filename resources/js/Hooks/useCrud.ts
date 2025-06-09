import {useState} from 'react';
import {router} from '@inertiajs/react';

const useCrud = <T, >(path: string) => {
    const [ isCreating, setIsCreating ] = useState<boolean>(false);
    const [ isUpdating, setIsUpdating ] = useState<boolean>(false);
    const [ isConfirming, setIsConfirming ] = useState<boolean>(false);
    const [ isDeleting, setIsDeleting ] = useState<boolean>(false);
    const [ identifier, setIdentifier ] = useState<number>(-1);

    const createHandler = (object: T | any, onFinish?: () => void) => {
        router.post(`${path}/`, { ...object }, {
            onStart: () => {
                setIsCreating(true);
            },
            onFinish: () => {
                onFinish?.();
                setIsCreating(false);
            },
            replace: true,
            preserveState: true,
        });
    };

    const updateHandler = (id: number, object: T | any, onFinish?: () => void): void => {
        setIdentifier(id);
        router.put(`${path}/${id}`, { ...object }, {
            onStart: () => setIsUpdating(true),
            onFinish: () => {
                onFinish?.();
                setIsUpdating(false);
            },
            replace: true,
            preserveState: true,
            preserveScroll: true,
        });
    };

    const deleteHandler = (id: number, confirmMsg?: string, onFinish?: () => void): void => {
        setIdentifier(id);
        router.delete(`${path}/${id}`, {
            onBefore: () => confirmMsg ? confirm(confirmMsg) : true,
            onStart: () => setIsDeleting(true),
            onFinish: () => {
                onFinish?.();
                setIsDeleting(false);
            },
        });
    };

    return {
        storeMutation: {
            mutate: createHandler,
            isLoading: isCreating,
        } as CreateMutation<T>,
        updateMutation: {
            mutate: updateHandler,
            isLoading: isUpdating,
            identifier: identifier,
        } as UpdateMutation<T>,
        deleteMutation: {
            mutate: deleteHandler,
            isLoading: isDeleting,
            identifier: identifier,
        } as DeleteMutation<T>
    };
}

export default useCrud;