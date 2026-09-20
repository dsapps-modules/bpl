import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        tailwindcss(),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/js/crm.js', 'resources/js/contacts.js', 'resources/js/companies.js', 'resources/js/pipeline.js', 'resources/js/tasks.js', 'resources/js/calendar.js', 'resources/js/reports.js', 'resources/js/inbox.js', 'resources/js/resource.js', 'resources/js/settings.js'],
            refresh: true,
        }),
    ],
});
