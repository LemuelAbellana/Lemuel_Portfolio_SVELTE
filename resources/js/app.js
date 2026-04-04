import './bootstrap';
import '../css/app.css';
import { createInertiaApp } from '@inertiajs/svelte';
import { mount } from 'svelte';

const GRID_ZOOM_DURATION_MS = 5000;
const gridPhaseMs = Date.now() % GRID_ZOOM_DURATION_MS;

document.documentElement.style.setProperty('--grid-zoom-duration', `${GRID_ZOOM_DURATION_MS}ms`);
document.documentElement.style.setProperty('--grid-sync-delay', `-${gridPhaseMs}ms`);

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
