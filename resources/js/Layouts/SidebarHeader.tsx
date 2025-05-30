import {router} from '@inertiajs/react';

const SidebarHeader = () => {
    const clickHandler = () => {
        router.get('/');
    }

    return <div className='flex flex-row justify-between py-3'>
        <button className='flex flex-row hover:bg-black-800 justify-center space-x-2 grow p-3 text-2xl hover:text-3xl hover:cursor-pointer transition-all ease-in-out'
                onClick={clickHandler}>
            {/*<div><HomeIcon size={"lg"} /></div>*/}
            <div>Home</div>
        </button>
        {/*<button className='text rounded-lg hover:bg-teal-900 p-1.5'>*/}
        {/*    <ExtendIcon size='lg'/>*/}
        {/*</button>*/}
    </div>
}

export default SidebarHeader;