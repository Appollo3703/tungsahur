import './bootstrap'; // File bootstrap.js Laravel

import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap; // Opsional, tapi bisa membantu jika ada script inline

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();