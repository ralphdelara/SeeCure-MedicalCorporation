import { Head } from '@inertiajs/react';
import { PlaceholderPattern } from '@/components/ui/placeholder-pattern';
import { notes } from '@/routes';
import { Breadcrumbs } from '@/components/breadcrumbs';
import { IconList } from '@tabler/icons-react';

export default function Notes() {
    const breadcrumbs = {};
    return (
        <>
            <Head title="Notes" />
            <Breadcrumbs breadcrumbs={breadcrumbs} title={'Notes'} />
            <ul className="nav nav-pills p-3 mb-3 rounded align-items-center card flex-row">
                <li className="nav-item">
                    <a href="javascript:void(0)" className="nav-link gap-6 note-link d-flex align-items-center justify-content-center px-3 px-md-3 active" id="all-category">
                        <IconList fill="white"/>
                        <span className="d-none d-md-block fw-medium">All Notes</span>
                    </a>
                </li>
                <li className="nav-item">
                    <a href="javascript:void(0)" className="nav-link gap-6 note-link d-flex align-items-center justify-content-center px-3 px-md-3" id="note-business">
                        <i className="ti ti-alert-triangle fill-white"></i>
                        <span className="d-none d-md-block fw-medium">Emergency</span>
                    </a>
                </li>
                <li className="nav-item">
                    <a href="javascript:void(0)" className="nav-link gap-6 note-link d-flex align-items-center justify-content-center px-3 px-md-3" id="note-social">
                        <i className="ti ti-user fill-white"></i>
                        <span className="d-none d-md-block fw-medium">Personal</span>
                    </a>
                </li>
                <li className="nav-item">
                    <a href="javascript:void(0)" className="nav-link gap-6 note-link d-flex align-items-center justify-content-center px-3 px-md-3" id="note-important">
                        <i className="ti ti-dots fill-white"></i>
                        <span className="d-none d-md-block fw-medium">Others</span>
                    </a>
                </li>
                <li className="nav-item ms-auto">
                    <a href="javascript:void(0)" className="btn btn-success d-flex align-items-center px-3 gap-6" id="add-notes">
                        <i className="ti ti-file fs-4"></i>
                        <span className="d-none d-md-block fw-medium fs-3">Add Notes</span>
                    </a>
                </li>
            </ul>
            <div className="tab-content">
                <div id="note-full-container" className="note-has-grid row">
                    <div className="col-md-4 single-note-item all-category">
                        <div className="card card-body">
                            <span className="side-stick"></span>
                            <h6 className="note-title text-truncate w-75 mb-0" data-noteheading="Book a Ticket for Movie"> Book a
                                Ticket for Movie </h6>
                            <p className="note-date fs-2">11 March 2009</p>
                            <div className="note-content">
                                <p className="note-inner-content" data-notecontent="Blandit tempus porttitor aasfs. Integer posuere erat a ante venenatis."> Blandit
                                    tempus porttitor aasfs. Integer posuere erat a ante venenatis. </p>
                            </div>
                            <div className="d-flex align-items-center">
                                <a href="javascript:void(0)" className="link me-1">
                                    <i className="ti ti-star fs-4 favourite-note"></i>
                                </a>
                                <a href="javascript:void(0)" className="link text-danger ms-2">
                                    <i className="ti ti-trash fs-4 remove-note"></i>
                                </a>
                                <div className="ms-auto">
                                    <div className="category-selector btn-group">
                                        <a className="nav-link category-dropdown label-group p-0" data-bs-toggle="dropdown" href="javascript:void(0)" role="button" aria-haspopup="true" aria-expanded="true">
                                            <div className="category">
                                                <div className="category-business"></div>
                                                <div className="category-social"></div>
                                                <div className="category-important"></div>
                                                <span className="more-options text-dark">
                                                    <i className="ti ti-dots-vertical fs-5"></i>
                                                </span>
                                            </div>
                                        </a>
                                        <div className="dropdown-menu dropdown-menu-right category-menu">
                                            <a className="
                                  note-business
                                  badge-group-item badge-business
                                  dropdown-item
                                  position-relative
                                  category-business
                                  d-flex
                                  align-items-center
                                " href="javascript:void(0);">Business</a>
                                            <a className="
                                  note-social
                                  badge-group-item badge-social
                                  dropdown-item
                                  position-relative
                                  category-social
                                  d-flex
                                  align-items-center
                                " href="javascript:void(0);"> Social</a>
                                            <a className="
                                  note-important
                                  badge-group-item badge-important
                                  dropdown-item
                                  position-relative
                                  category-important
                                  d-flex
                                  align-items-center
                                " href="javascript:void(0);"> Important</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="col-md-4 single-note-item all-category note-important">
                        <div className="card card-body">
                            <span className="side-stick"></span>
                            <h6 className="note-title text-truncate w-75 mb-0" data-noteheading="Go for lunch"> Go for lunch </h6>
                            <p className="note-date fs-2">01 April 2002</p>
                            <div className="note-content">
                                <p className="note-inner-content" data-notecontent="Blandit tempus porttitor aasfs. Integer posuere erat a ante venenatis."> Blandit
                                    tempus porttitor aasfs. Integer posuere erat a ante venenatis. </p>
                            </div>
                            <div className="d-flex align-items-center">
                                <a href="javascript:void(0)" className="link me-1">
                                    <i className="ti ti-star fs-4 favourite-note"></i>
                                </a>
                                <a href="javascript:void(0)" className="link text-danger ms-2">
                                    <i className="ti ti-trash fs-4 remove-note"></i>
                                </a>
                                <div className="ms-auto">
                                    <div className="category-selector btn-group">
                                        <a className="nav-link category-dropdown label-group p-0" data-bs-toggle="dropdown" href="javascript:void(0)" role="button" aria-haspopup="true" aria-expanded="true">
                                            <div className="category">
                                                <div className="category-business"></div>
                                                <div className="category-social"></div>
                                                <div className="category-important"></div>
                                                <span className="more-options text-dark">
                                                    <i className="ti ti-dots-vertical fs-5"></i>
                                                </span>
                                            </div>
                                        </a>
                                        <div className="dropdown-menu dropdown-menu-right category-menu">
                                            <a className="
                                  note-business
                                  badge-group-item badge-business
                                  dropdown-item
                                  position-relative
                                  category-business
                                  d-flex
                                  align-items-center
                                " href="javascript:void(0);">Business</a>
                                            <a className="
                                  note-social
                                  badge-group-item badge-social
                                  dropdown-item
                                  position-relative
                                  category-social
                                  d-flex
                                  align-items-center
                                " href="javascript:void(0);"> Social</a>
                                            <a className="
                                  note-important
                                  badge-group-item badge-important
                                  dropdown-item
                                  position-relative
                                  category-important
                                  d-flex
                                  align-items-center
                                " href="javascript:void(0);"> Important</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="col-md-4 single-note-item all-category note-social">
                        <div className="card card-body">
                            <span className="side-stick"></span>
                            <h6 className="note-title text-truncate w-75 mb-0" data-noteheading="Meeting with Mr.Jojo"> Meeting with
                                Mr.Jojo </h6>
                            <p className="note-date fs-2">19 October 2021</p>
                            <div className="note-content">
                                <p className="note-inner-content" data-notecontent="Blandit tempus porttitor aasfs. Integer posuere erat a ante venenatis."> Blandit
                                    tempus porttitor aasfs. Integer posuere erat a ante venenatis. </p>
                            </div>
                            <div className="d-flex align-items-center">
                                <a href="javascript:void(0)" className="link me-1">
                                    <i className="ti ti-star fs-4 favourite-note"></i>
                                </a>
                                <a href="javascript:void(0)" className="link text-danger ms-2">
                                    <i className="ti ti-trash fs-4 remove-note"></i>
                                </a>
                                <div className="ms-auto">
                                    <div className="category-selector btn-group">
                                        <a className="nav-link category-dropdown label-group p-0" data-bs-toggle="dropdown" href="javascript:void(0)" role="button" aria-haspopup="true" aria-expanded="true">
                                            <div className="category">
                                                <div className="category-business"></div>
                                                <div className="category-social"></div>
                                                <div className="category-important"></div>
                                                <span className="more-options text-dark">
                                                    <i className="ti ti-dots-vertical fs-5"></i>
                                                </span>
                                            </div>
                                        </a>
                                        <div className="dropdown-menu dropdown-menu-right category-menu">
                                            <a className="
                                  note-business
                                  badge-group-item badge-business
                                  dropdown-item
                                  position-relative
                                  category-business
                                  d-flex
                                  align-items-center
                                " href="javascript:void(0);">Business</a>
                                            <a className="
                                  note-social
                                  badge-group-item badge-social
                                  dropdown-item
                                  position-relative
                                  category-social
                                  d-flex
                                  align-items-center
                                " href="javascript:void(0);"> Social</a>
                                            <a className="
                                  note-important
                                  badge-group-item badge-important
                                  dropdown-item
                                  position-relative
                                  category-important
                                  d-flex
                                  align-items-center
                                " href="javascript:void(0);"> Important</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="col-md-4 single-note-item all-category note-business">
                        <div className="card card-body">
                            <span className="side-stick"></span>
                            <h6 className="note-title text-truncate w-75 mb-0" data-noteheading="Give Review for design"> Give Review
                                for design </h6>
                            <p className="note-date fs-2">02 January 2000</p>
                            <div className="note-content">
                                <p className="note-inner-content" data-notecontent="Blandit tempus porttitor aasfs. Integer posuere erat a ante venenatis."> Blandit
                                    tempus porttitor aasfs. Integer posuere erat a ante venenatis. </p>
                            </div>
                            <div className="d-flex align-items-center">
                                <a href="javascript:void(0)" className="link me-1">
                                    <i className="ti ti-star fs-4 favourite-note"></i>
                                </a>
                                <a href="javascript:void(0)" className="link text-danger ms-2">
                                    <i className="ti ti-trash fs-4 remove-note"></i>
                                </a>
                                <div className="ms-auto">
                                    <div className="category-selector btn-group">
                                        <a className="nav-link category-dropdown label-group p-0" data-bs-toggle="dropdown" href="javascript:void(0)" role="button" aria-haspopup="true" aria-expanded="true">
                                            <div className="category">
                                                <div className="category-business"></div>
                                                <div className="category-social"></div>
                                                <div className="category-important"></div>
                                                <span className="more-options text-dark">
                                                    <i className="ti ti-dots-vertical fs-5"></i>
                                                </span>
                                            </div>
                                        </a>
                                        <div className="dropdown-menu dropdown-menu-right category-menu">
                                            <a className="
                                  note-business
                                  badge-group-item badge-business
                                  dropdown-item
                                  position-relative
                                  category-business
                                  d-flex
                                  align-items-center
                                " href="javascript:void(0);">Business</a>
                                            <a className="
                                  note-social
                                  badge-group-item badge-social
                                  dropdown-item
                                  position-relative
                                  category-social
                                  d-flex
                                  align-items-center
                                " href="javascript:void(0);"> Social</a>
                                            <a className="
                                  note-important
                                  badge-group-item badge-important
                                  dropdown-item
                                  position-relative
                                  category-important
                                  d-flex
                                  align-items-center
                                " href="javascript:void(0);"> Important</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="col-md-4 single-note-item all-category note-social">
                        <div className="card card-body">
                            <span className="side-stick"></span>
                            <h6 className="note-title text-truncate w-75 mb-0" data-noteheading="Nightout with friends"> Nightout with
                                friends </h6>
                            <p className="note-date fs-2">01 August 1999</p>
                            <div className="note-content">
                                <p className="note-inner-content" data-notecontent="Blandit tempus porttitor aasfs. Integer posuere erat a ante venenatis."> Blandit
                                    tempus porttitor aasfs. Integer posuere erat a ante venenatis. </p>
                            </div>
                            <div className="d-flex align-items-center">
                                <a href="javascript:void(0)" className="link me-1">
                                    <i className="ti ti-star fs-4 favourite-note"></i>
                                </a>
                                <a href="javascript:void(0)" className="link text-danger ms-2">
                                    <i className="ti ti-trash fs-4 remove-note"></i>
                                </a>
                                <div className="ms-auto">
                                    <div className="category-selector btn-group">
                                        <a className="nav-link category-dropdown label-group p-0" data-bs-toggle="dropdown" href="javascript:void(0)" role="button" aria-haspopup="true" aria-expanded="true">
                                            <div className="category">
                                                <div className="category-business"></div>
                                                <div className="category-social"></div>
                                                <div className="category-important"></div>
                                                <span className="more-options text-dark">
                                                    <i className="ti ti-dots-vertical fs-5"></i>
                                                </span>
                                            </div>
                                        </a>
                                        <div className="dropdown-menu dropdown-menu-right category-menu">
                                            <a className="
                                  note-business
                                  badge-group-item badge-business
                                  dropdown-item
                                  position-relative
                                  category-business
                                  d-flex
                                  align-items-center
                                " href="javascript:void(0);">Business</a>
                                            <a className="
                                  note-social
                                  badge-group-item badge-social
                                  dropdown-item
                                  position-relative
                                  category-social
                                  d-flex
                                  align-items-center
                                " href="javascript:void(0);"> Social</a>
                                            <a className="
                                  note-important
                                  badge-group-item badge-important
                                  dropdown-item
                                  position-relative
                                  category-important
                                  d-flex
                                  align-items-center
                                " href="javascript:void(0);"> Important</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="col-md-4 single-note-item all-category note-important">
                        <div className="card card-body">
                            <span className="side-stick"></span>
                            <h6 className="note-title text-truncate w-75 mb-0" data-noteheading="Launch new template"> Launch new
                                template </h6>
                            <p className="note-date fs-2">21 January 2015</p>
                            <div className="note-content">
                                <p className="note-inner-content" data-notecontent="Blandit tempus porttitor aasfs. Integer posuere erat a ante venenatis."> Blandit
                                    tempus porttitor aasfs. Integer posuere erat a ante venenatis. </p>
                            </div>
                            <div className="d-flex align-items-center">
                                <a href="javascript:void(0)" className="link me-1">
                                    <i className="ti ti-star fs-4 favourite-note"></i>
                                </a>
                                <a href="javascript:void(0)" className="link text-danger ms-2">
                                    <i className="ti ti-trash fs-4 remove-note"></i>
                                </a>
                                <div className="ms-auto">
                                    <div className="category-selector btn-group">
                                        <a className="nav-link category-dropdown label-group p-0" data-bs-toggle="dropdown" href="javascript:void(0)" role="button" aria-haspopup="true" aria-expanded="true">
                                            <div className="category">
                                                <div className="category-business"></div>
                                                <div className="category-social"></div>
                                                <div className="category-important"></div>
                                                <span className="more-options text-dark">
                                                    <i className="ti ti-dots-vertical fs-5"></i>
                                                </span>
                                            </div>
                                        </a>
                                        <div className="dropdown-menu dropdown-menu-right category-menu">
                                            <a className="
                                  note-business
                                  badge-group-item badge-business
                                  dropdown-item
                                  position-relative
                                  category-business
                                  d-flex
                                  align-items-center
                                " href="javascript:void(0);">Business</a>
                                            <a className="
                                  note-social
                                  badge-group-item badge-social
                                  dropdown-item
                                  position-relative
                                  category-social
                                  d-flex
                                  align-items-center
                                " href="javascript:void(0);"> Social</a>
                                            <a className="
                                  note-important
                                  badge-group-item badge-important
                                  dropdown-item
                                  position-relative
                                  category-important
                                  d-flex
                                  align-items-center
                                " href="javascript:void(0);"> Important</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="col-md-4 single-note-item all-category note-social">
                        <div className="card card-body">
                            <span className="side-stick"></span>
                            <h6 className="note-title text-truncate w-75 mb-0" data-noteheading="Change a Design"> Change a Design
                            </h6>
                            <p className="note-date fs-2">25 December 2016</p>
                            <div className="note-content">
                                <p className="note-inner-content" data-notecontent="Blandit tempus porttitor aasfs. Integer posuere erat a ante venenatis."> Blandit
                                    tempus porttitor aasfs. Integer posuere erat a ante venenatis. </p>
                            </div>
                            <div className="d-flex align-items-center">
                                <a href="javascript:void(0)" className="link me-1">
                                    <i className="ti ti-star fs-4 favourite-note"></i>
                                </a>
                                <a href="javascript:void(0)" className="link text-danger ms-2">
                                    <i className="ti ti-trash fs-4 remove-note"></i>
                                </a>
                                <div className="ms-auto">
                                    <div className="category-selector btn-group">
                                        <a className="nav-link category-dropdown label-group p-0" data-bs-toggle="dropdown" href="javascript:void(0)" role="button" aria-haspopup="true" aria-expanded="true">
                                            <div className="category">
                                                <div className="category-business"></div>
                                                <div className="category-social"></div>
                                                <div className="category-important"></div>
                                                <span className="more-options text-dark">
                                                    <i className="ti ti-dots-vertical fs-5"></i>
                                                </span>
                                            </div>
                                        </a>
                                        <div className="dropdown-menu dropdown-menu-right category-menu">
                                            <a className="
                                  note-business
                                  badge-group-item badge-business
                                  dropdown-item
                                  position-relative
                                  category-business
                                  d-flex
                                  align-items-center
                                " href="javascript:void(0);">Business</a>
                                            <a className="
                                  note-social
                                  badge-group-item badge-social
                                  dropdown-item
                                  position-relative
                                  category-social
                                  d-flex
                                  align-items-center
                                " href="javascript:void(0);"> Social</a>
                                            <a className="
                                  note-important
                                  badge-group-item badge-important
                                  dropdown-item
                                  position-relative
                                  category-important
                                  d-flex
                                  align-items-center
                                " href="javascript:void(0);"> Important</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="col-md-4 single-note-item all-category note-business">
                        <div className="card card-body">
                            <span className="side-stick"></span>
                            <h6 className="note-title text-truncate w-75 mb-0" data-noteheading="Give review for foods"> Give review
                                for foods </h6>
                            <p className="note-date fs-2">18 December 2021</p>
                            <div className="note-content">
                                <p className="note-inner-content" data-notecontent="Blandit tempus porttitor aasfs. Integer posuere erat a ante venenatis."> Blandit
                                    tempus porttitor aasfs. Integer posuere erat a ante venenatis. </p>
                            </div>
                            <div className="d-flex align-items-center">
                                <a href="javascript:void(0)" className="link me-1">
                                    <i className="ti ti-star fs-4 favourite-note"></i>
                                </a>
                                <a href="javascript:void(0)" className="link text-danger ms-2">
                                    <i className="ti ti-trash fs-4 remove-note"></i>
                                </a>
                                <div className="ms-auto">
                                    <div className="category-selector btn-group">
                                        <a className="nav-link category-dropdown label-group p-0" data-bs-toggle="dropdown" href="javascript:void(0)" role="button" aria-haspopup="true" aria-expanded="true">
                                            <div className="category">
                                                <div className="category-business"></div>
                                                <div className="category-social"></div>
                                                <div className="category-important"></div>
                                                <span className="more-options text-dark">
                                                    <i className="ti ti-dots-vertical fs-5"></i>
                                                </span>
                                            </div>
                                        </a>
                                        <div className="dropdown-menu dropdown-menu-right category-menu">
                                            <a className="
                                  note-business
                                  badge-group-item badge-business
                                  dropdown-item
                                  position-relative
                                  category-business
                                  d-flex
                                  align-items-center
                                " href="javascript:void(0);">Business</a>
                                            <a className="
                                  note-social
                                  badge-group-item badge-social
                                  dropdown-item
                                  position-relative
                                  category-social
                                  d-flex
                                  align-items-center
                                " href="javascript:void(0);"> Social</a>
                                            <a className="
                                  note-important
                                  badge-group-item badge-important
                                  dropdown-item
                                  position-relative
                                  category-important
                                  d-flex
                                  align-items-center
                                " href="javascript:void(0);"> Important</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="col-md-4 single-note-item all-category note-important">
                        <div className="card card-body">
                            <span className="side-stick"></span>
                            <h6 className="note-title text-truncate w-75 mb-0" data-noteheading="Give salary to employee"> Give salary
                                to employee </h6>
                            <p className="note-date fs-2">15 Fabruary 2021</p>
                            <div className="note-content">
                                <p className="note-inner-content" data-notecontent="Blandit tempus porttitor aasfs. Integer posuere erat a ante venenatis."> Blandit
                                    tempus porttitor aasfs. Integer posuere erat a ante venenatis. </p>
                            </div>
                            <div className="d-flex align-items-center">
                                <a href="javascript:void(0)" className="link me-1">
                                    <i className="ti ti-star fs-4 favourite-note"></i>
                                </a>
                                <a href="javascript:void(0)" className="link text-danger ms-2">
                                    <i className="ti ti-trash fs-4 remove-note"></i>
                                </a>
                                <div className="ms-auto">
                                    <div className="category-selector btn-group">
                                        <a className="nav-link category-dropdown label-group p-0" data-bs-toggle="dropdown" href="javascript:void(0)" role="button" aria-haspopup="true" aria-expanded="true">
                                            <div className="category">
                                                <div className="category-business"></div>
                                                <div className="category-social"></div>
                                                <div className="category-important"></div>
                                                <span className="more-options text-dark">
                                                    <i className="ti ti-dots-vertical fs-5"></i>
                                                </span>
                                            </div>
                                        </a>
                                        <div className="dropdown-menu dropdown-menu-right category-menu">
                                            <a className="
                                  note-business
                                  badge-group-item badge-business
                                  dropdown-item
                                  position-relative
                                  category-business
                                  d-flex
                                  align-items-center
                                " href="javascript:void(0);">Business</a>
                                            <a className="
                                  note-social
                                  badge-group-item badge-social
                                  dropdown-item
                                  position-relative
                                  category-social
                                  d-flex
                                  align-items-center
                                " href="javascript:void(0);"> Social</a>
                                            <a className="
                                  note-important
                                  badge-group-item badge-important
                                  dropdown-item
                                  position-relative
                                  category-important
                                  d-flex
                                  align-items-center
                                " href="javascript:void(0);"> Important</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div className="modal fade" id="addnotesmodal" tabIndex={-1} aria-labelledby="addnotesmodalTitle" style={{ display: "none" }} aria-hidden="true">
                <div className="modal-dialog modal-dialog-centered" role="document">
                    <div className="modal-content border-0">
                        <div className="modal-header text-bg-success">
                            <h6 className="modal-title text-white">Add Notes</h6>
                            <button type="button" className="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div className="modal-body">
                            <div className="notes-box">
                                <div className="notes-content">
                                    <form action="javascript:void(0);" id="addnotesmodalTitle">
                                        <div className="row">
                                            <div className="col-md-12 mb-3">
                                                <div className="note-title">
                                                    <label className="form-label">Note Title</label>
                                                    <input type="text" id="note-has-title" className="form-control" minLength={25} placeholder="Title" />
                                                </div>
                                            </div>
                                            <div className="col-md-12">
                                                <div className="note-description">
                                                    <label className="form-label">Note Description</label>
                                                    <textarea id="note-has-description" className="form-control" minLength={60} placeholder="Description" rows={3}></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div className="modal-footer">
                            <div className="d-flex gap-6">
                                <button className="btn bg-danger-subtle text-danger" data-bs-dismiss="modal">Discard</button>
                                <button id="btn-n-add" className="btn btn-success" disabled={true}>Add</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}