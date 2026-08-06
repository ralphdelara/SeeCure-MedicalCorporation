import { router } from '@inertiajs/react';
import { useEffect, useState } from 'react';
import appLogo from '@/assets/images/logos/logo.png';
import NavHeader from '@/layouts/app/app-header-layout';
import NavSidebar from '@/layouts/app/app-sidebar-layout';
import type { BreadcrumbItem } from '@/types';

export default function AppLayout({
    children,
}: {
    breadcrumbs?: BreadcrumbItem[];
    children: React.ReactNode;
}) {
    const sidebarType = (): string | undefined => {
        return document.body.dataset.sidebartype;
    };

    const toggleSidebar = () => {
        if (sidebarType() === 'full') {
            document.body.dataset.sidebartype = 'mini-sidebar';
            document.getElementById('main-wrapper')?.classList.remove('show-sidebar');
        } else {
            document.body.dataset.sidebartype = 'full';
            document.getElementById('main-wrapper')?.classList.add('show-sidebar');
        }
    };

    const [loading, setLoading] = useState(false);

    useEffect(() => {
        const startListener = router.on('start', () => setLoading(true));
        const finishListener = router.on('finish', () => setLoading(false));

        return () => {
            startListener();
            finishListener();
        };
    }, []);

    return (
        <>
            {loading && (
                <div className="preloader" style={{ opacity: '0.3' }}>
                    <img
                        src={appLogo}
                        className="lds-ripple img-fluid spinning-image"
                        alt="See Cure loader"
                    />
                </div>
            )}
            <div id="main-wrapper">
                <NavSidebar toggleSidebar={toggleSidebar} />

                <div className="page-wrapper">
                    <NavHeader toggleSidebar={toggleSidebar} />

                    <div className="body-wrapper">{children}</div>
                </div>
            </div>

            <div onClick={() => toggleSidebar()} className="dark-transparent sidebartoggler"></div>
        </>
    );
}
