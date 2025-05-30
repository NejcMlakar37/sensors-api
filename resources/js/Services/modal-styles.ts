const defaultOverlay = {
    backgroundColor: 'rgba(0, 0, 0, 0.75)',
};

const defaultContentPos = {
    top: '33%',
    left: '50%',
    right: 'auto',
    bottom: 'auto',
    marginRight: '-50%',
    transform: 'translate(-50%, -50%)',
    maxHeight: '90%',
    backgroundColor: '#F5F7FA',
};

export const fullModalStyle = {
    overlay: { ...defaultOverlay },
    content: {
        ...defaultContentPos,
        width: '25%',
    },
};