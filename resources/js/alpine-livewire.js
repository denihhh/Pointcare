/**
 * Livewire v4 bundles Alpine inside livewire.esm.js.
 * bootstrap.js also imports Alpine from the 'alpinejs' npm package and calls Alpine.start().
 *
 * This bridge file is aliased as 'alpinejs' in vite.config.js so bootstrap.js
 * gets Livewire's Alpine. We wrap Alpine.start() so that when bootstrap.js calls it,
 * it actually calls Livewire.start() instead — which registers all plugins then starts Alpine.
 * The second call to Alpine.start() from within Livewire.start() is guarded internally.
 */
import { Alpine, Livewire } from '../../vendor/livewire/livewire/dist/livewire.esm';

// Save the original Alpine.start
const originalStart = Alpine.start.bind(Alpine);

// Override Alpine.start so that when bootstrap.js calls it,
// we call Livewire.start() instead (which registers plugins + starts Alpine).
Alpine.start = () => {
    // Restore original start so Livewire can use it internally
    Alpine.start = originalStart;
    // Livewire.start() registers all its Alpine plugins, then calls Alpine.start()
    Livewire.start();
};

export default Alpine;
