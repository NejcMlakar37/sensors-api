const SideBarLoadingShimmer = ({ rows }: { rows: number }) => {
    return <div className='flex flex-col p-4 space-y-3'>
        {Array(rows).map((row) => (
            <div key={row} className='bg-teal-900 bg-opacity-75 rounded-lg h-8 animate-pulse'></div>
        ))}
    </div>
}

export default SideBarLoadingShimmer;