const TabBarButton = ({index, title, active, onClick}: TabButtonProps) => {
    return <div key={index} onClick={() => onClick(index)}
                className={'flex items-center justify-center h-full py-1 px-2 rounded-lg ' +
                    `hover:rounded-md hover:bg-black-50 hover:text-black-800 hover:cursor-pointer ${active? ' text-black-800 bg-black-100' : ' text-black-300 '} `}>
        {title}
    </div>
};

export default TabBarButton;