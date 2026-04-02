import './bootstrap';
import '../css/app.css';
import { createInertiaApp } from '@inertiajs/svelte';
import { mount } from 'svelte';

createInertiaApp({
	resolve: (name) => {
		const pages = import.meta.glob('./Pages/**/*.svelte');
		return pages[`./Pages/${name}.svelte`]();
	},
	setup({ el, App, props }) {
		mount(App, { target: el, props });
	},
	progress: {
		color: '#552583',
	},
});
