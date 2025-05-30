const SectionTitleRow = (props: PageTitleProps) => {
    return <div className="align-middle justify-between flex flex-row mb-8 text-black-600">
        {props.icon ?
                (<div className="flex flex-row space-x-3 justify-between align-middle">
                    <div className="self-center text-gray-500 text-sm">
                        {props.icon ?? null}
                    </div>
                    <span className={`${props.titleSize} self-center text-gray-500 font-medium capitalize`}>
                        {props.titleLabel}
                    </span>
                </div>) :
                <span className={`${props.titleSize} self-center text-gray-500 font-medium capitalize`}>
                    {props.titleLabel}
                </span>
        }
        {props.children}
    </div>;
};

export default SectionTitleRow;