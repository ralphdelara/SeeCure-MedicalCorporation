import { Link, usePage } from '@inertiajs/react';
import AppLogoIcon from '@/components/app-logo-icon';
import { home } from '@/routes';
import type { AuthLayoutProps } from '@/types';
import logoText from '@/assets/images/logos/logo_text.png';
import sideImage1 from '@/assets/images/backgrounds/side-image1.png';
import sideImage2 from '@/assets/images/backgrounds/side-image2.png';
import sideImage3 from '@/assets/images/backgrounds/side-image3.png';

export default function AuthSplitLayout({
    children,
    title,
    description,
}: AuthLayoutProps) {
    const { name } = usePage().props;

    return (
        <>
            <div id="main-wrapper" className="auth-customizer-none">
                <div className="position-relative overflow-hidden radial-gradient min-vh-100 w-100">
                    <div className="position-relative z-index-5">
                        <a href="../main/index.html" className="text-nowrap logo-img d-block px-4 py-9 w-100 position-absolute top-0 z-3">
                            <img src={logoText} className="dark-logo" alt="Logo-Dark" width="200" />
                        </a>
                        <div className="row light-green-bg">
                            <div className="d-none d-lg-block col-lg-6 col-xl-6 my-15">
                                <div className="mb-13 text-center">
                                    <h1 className="fw-bolder">Where Healthcare Meets<br/>Convenience</h1>
                                </div>
                                <div className="d-none d-lg-flex align-items-center justify-content-center h-n50">
                                    <div className="row g-4">
                                        <div className="col-md-4">
                                            <img src={sideImage1} width="150" className="shadow float-end" />
                                        </div>
                                        <div className="col-md-4">
                                            <img src={sideImage2} width="150" className="shadow" />
                                        </div>
                                        <div className="col-md-4">
                                            <img src={sideImage3} width="150" className="shadow float-start" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div className="col-lg-6 col-xl-6">
                                {children}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}
