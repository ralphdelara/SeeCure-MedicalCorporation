import sideImage1 from '@/assets/images/backgrounds/side-image1.png';
import sideImage2 from '@/assets/images/backgrounds/side-image2.png';
import sideImage3 from '@/assets/images/backgrounds/side-image3.png';
import logoText from '@/assets/images/logos/logo_text.png';
import type { AuthLayoutProps } from '@/types';

export default function AuthSplitLayout({ children }: AuthLayoutProps) {
    return (
        <>
            <div id="main-wrapper" className="auth-customizer-none">
                <div className="position-relative radial-gradient min-vh-100 w-100 overflow-hidden">
                    <div className="position-relative z-index-5">
                        <a
                            href="../main/index.html"
                            className="logo-img d-block position-absolute top-0 z-3 w-100 px-4 py-9 text-nowrap"
                        >
                            <img src={logoText} className="dark-logo" alt="Logo-Dark" width="200" />
                        </a>
                        <div className="row light-green-bg">
                            <div className="d-none d-lg-block col-lg-6 col-xl-6 my-15">
                                <div className="mb-13 text-center">
                                    <h1 className="fw-bolder">
                                        Where Healthcare Meets
                                        <br />
                                        Convenience
                                    </h1>
                                </div>
                                <div className="d-none d-lg-flex align-items-center justify-content-center h-n50">
                                    <div className="row g-4">
                                        <div className="col-md-4">
                                            <img
                                                src={sideImage1}
                                                width="150"
                                                className="float-end shadow"
                                            />
                                        </div>
                                        <div className="col-md-4">
                                            <img src={sideImage2} width="150" className="shadow" />
                                        </div>
                                        <div className="col-md-4">
                                            <img
                                                src={sideImage3}
                                                width="150"
                                                className="float-start shadow"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div className="col-lg-6 col-xl-6">{children}</div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}
