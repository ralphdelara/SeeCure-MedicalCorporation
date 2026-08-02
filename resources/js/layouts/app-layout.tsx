import NavSidebar from '@/layouts/app/app-sidebar-layout';
import NavHeader from '@/layouts/app/app-header-layout';
import type { BreadcrumbItem } from '@/types';
import { useState } from 'react';

export default function AppLayout({
    breadcrumbs = [],
    children,
}: {
    breadcrumbs?: BreadcrumbItem[];
    children: React.ReactNode;
}) {
    const sidebarType = (): string | undefined => {
        return document.body.dataset.sidebartype;
    }

    const toggleSidebar = () => {
        if (sidebarType() === 'full') {
            document.body.dataset.sidebartype = 'mini-sidebar';
            document.getElementById('main-wrapper')?.classList.remove('show-sidebar');
        } else {
            document.body.dataset.sidebartype = 'full';
            document.getElementById('main-wrapper')?.classList.add('show-sidebar');
        }
    }

    return (
        <>
            <div id="main-wrapper">
                <NavSidebar toggleSidebar={toggleSidebar} />

                <div className="page-wrapper">
                    <NavHeader toggleSidebar={toggleSidebar} />

                    <div className="body-wrapper">
                        <div className="container-fluid">
                            { children }
                        </div>
                    </div>
                </div>
            </div>

            <div onClick={() => toggleSidebar()} className="dark-transparent sidebartoggler"></div>
        </>
    );
}
