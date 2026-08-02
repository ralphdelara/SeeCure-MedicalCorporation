import { createInertiaApp } from '@inertiajs/react';
import { Toaster } from '@/components/ui/sonner';
import { TooltipProvider } from '@/components/ui/tooltip';
import { initializeTheme } from '@/hooks/use-appearance';
import AppLayout from '@/layouts/app-layout';
import AuthLayout from '@/layouts/auth-layout';
import SettingsLayout from '@/layouts/settings/layout';
import '@/assets/css/styles.css';
import '@/assets/css/custom.css';
import '@/assets/css/tooltip.css';
import '@/assets/libs/simplebar/dist/simplebar.min.js';
import '@/assets/js/theme/app.min.js';
import '@/assets/js/theme/theme.js';
//favicon
import '@/assets/images/logos/favicon.ico';
import '@/assets/images/logos/android-chrome-192x192.png';
import '@/assets/images/logos/apple-touch-icon.png';
import '@/assets/images/logos/site.webmanifest';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    layout: (name) => {
        switch (true) {
            case name === 'welcome':
                return null;
            case name.startsWith('auth/'):
                return AuthLayout;
            case name.startsWith('settings/'):
                return [AppLayout, SettingsLayout];
            default:
                return AppLayout;
        }
    },
    strictMode: true,
    withApp(app) {
        return (
            <TooltipProvider delayDuration={0}>
                {app}
                <Toaster />
            </TooltipProvider>
        );
    },
    progress: {
        color: '#4B5563',
    },
});

// This will set light / dark mode on load...
initializeTheme();
