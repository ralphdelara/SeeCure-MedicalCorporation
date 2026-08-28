import { createInertiaApp } from '@inertiajs/react';
import { TooltipProvider } from '@/components/ui/tooltip';
import { initializeTheme } from '@/hooks/use-appearance';
import AppLayout from '@/layouts/app-layout';
import AuthLayout from '@/layouts/auth-layout';
import '@/assets/css/styles.css';
import '@/assets/css/custom.css';
import '@/assets/css/tooltip.css';
import '@/assets/js/theme/app.min.js';
import '@/assets/libs/simplebar/dist/simplebar.min.js';
//favicon
import '@/assets/images/logos/favicon.ico';
import '@/assets/images/logos/android-chrome-192x192.png';
import '@/assets/images/logos/apple-touch-icon.png';
import '@/assets/images/logos/site.webmanifest';
import { configureEcho } from '@laravel/echo-react';

configureEcho({
    broadcaster: 'reverb',
});

configureEcho({
    broadcaster: 'reverb',
});

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    layout: (name) => {
        switch (true) {
            case name === 'welcome':
                return null;
            case name.startsWith('auth/'):
                return AuthLayout;
            default:
                return AppLayout;
        }
    },
    strictMode: true,
    withApp(app) {
        return <TooltipProvider delayDuration={0}>{app}</TooltipProvider>;
    },
    progress: false,
});

// This will set light / dark mode on load...
initializeTheme();
