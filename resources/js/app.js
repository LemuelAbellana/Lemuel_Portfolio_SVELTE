import './bootstrap';
import '../css/app.css';
import { createInertiaApp } from '@inertiajs/svelte';
import { mount } from 'svelte';

const GRID_ZOOM_DURATION_MS = 5000;
const GRID_ZOOM_AMPLITUDE = 0.12;

document.documentElement.style.setProperty('--grid-zoom-duration', `${GRID_ZOOM_DURATION_MS}ms`);

const updateGridZoomScale = () => {
	const phase = (Date.now() % GRID_ZOOM_DURATION_MS) / GRID_ZOOM_DURATION_MS;
	const scale = 1 + GRID_ZOOM_AMPLITUDE * (0.5 - 0.5 * Math.cos(phase * Math.PI * 2));
	document.documentElement.style.setProperty('--grid-zoom-scale', scale.toFixed(4));
	requestAnimationFrame(updateGridZoomScale);
};

requestAnimationFrame(updateGridZoomScale);

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
