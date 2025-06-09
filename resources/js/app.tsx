import {createInertiaApp} from '@inertiajs/react';
import {createRoot} from 'react-dom/client';
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers';
import {ReactNode} from 'react';

createInertiaApp({
    resolve: (name) => {
        return resolvePageComponent(`./Pages/${name}.tsx`, import.meta.glob('./Pages/**/*.tsx'))
    },
    progress: {
        color: '#E9B949',
        showSpinner: false,
    },
    setup({ el, App, props }) {
        const root = createRoot(el);
        root.render(<App {...props} /> as ReactNode);
    },
})
