import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import {TabulatorFull as Tabulator} from 'tabulator-tables';
import * as bootstrap from 'bootstrap'
import Alert from 'bootstrap/js/dist/alert';
import { Tooltip, Toast, Popover } from 'bootstrap';


const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, app, props, plugin, TabulatorFull  }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(TabulatorFull )
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
