import { Link } from '@inertiajs/react';
import { IconChevronLeft, IconChevronRight } from '@tabler/icons-react';
import type { PageLinks } from '@/types/pagination';

interface PageProps {
    pageData: {
        from: number;
        to: number;
        total: number;
        links: PageLinks[];
        first_page_url: string;
        last_page_url: string;
        current_page: number;
    };
    showTotal?: boolean;
    bottom?: boolean;
}
const Pagination = ({ pageData, showTotal = true, bottom = false }: PageProps) => {
    const prevBtnName = '&laquo; Previous';
    const nextBtnName = 'Next &raquo;';

    return (
        <div className={'d-lg-flex justify-content-between mt-3' + (bottom ? ' mb-4' : '')}>
            {showTotal && (
                <div style={{ letterSpacing: '0.05em', position: 'relative' }} className="mt-3">
                    <h5>
                        From <span className="text-danger fw-bolder">{pageData.from ?? 0}</span>
                        &nbsp;to <span className="text-danger fw-bolder">{pageData.to ?? 0}</span>
                        &nbsp;out of <span className="text-danger fw-bolder">
                            {pageData.total}
                        </span>{' '}
                        records
                    </h5>
                </div>
            )}
            <nav aria-label="...">
                <ul className="pagination">
                    <li className="page-item">
                        <Link className="page-link" href={pageData.first_page_url}>
                            First
                        </Link>
                    </li>
                    {pageData.links.map((item, index) => {
                        return (
                            <li
                                className={'page-item' + (item.active ? ' active' : '')}
                                key={'page-link-' + index}
                            >
                                <Link
                                    className="page-link"
                                    href={
                                        item.url ??
                                        (item.label === prevBtnName
                                            ? pageData.first_page_url
                                            : item.label === nextBtnName
                                              ? pageData.last_page_url
                                              : '#')
                                    }
                                >
                                    {item.label === prevBtnName ? (
                                        <IconChevronLeft size={18} />
                                    ) : item.label === nextBtnName ? (
                                        <IconChevronRight size={18} />
                                    ) : (
                                        item.label
                                    )}
                                </Link>
                            </li>
                        );
                    })}
                    <li className="page-item">
                        <Link className="page-link" href={pageData.last_page_url}>
                            Last
                        </Link>
                    </li>
                </ul>
            </nav>
        </div>
    );
};

export default Pagination;
