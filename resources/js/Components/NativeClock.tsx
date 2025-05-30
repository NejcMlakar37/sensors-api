import {useState} from 'react';

const NativeClock = () => {
    let time  = new Date().toLocaleTimeString()
    const [ctime, setCtime] = useState<string>(time)

    const UpdateTime = ()=> {
        time = new Date().toLocaleTimeString()
        setCtime(time)
    }

    setInterval(UpdateTime)

    return <div className={'text-blue-400 font-semibold text-9xl grow'}>
        {ctime}
    </div>
}

export default NativeClock;