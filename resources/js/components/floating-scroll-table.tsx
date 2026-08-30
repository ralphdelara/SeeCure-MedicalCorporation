import React, { useRef, useEffect, useState } from 'react';

interface FloatingScrollTableProps {
    children: React.ReactNode;
    float?: boolean;
}

export const FloatingScrollTable: React.FC<FloatingScrollTableProps> = ({
    children,
    float = true,
}) => {
    const containerRef = useRef<HTMLDivElement>(null);
    const tableResponsiveRef = useRef<HTMLDivElement>(null);
    const dummyScrollRef = useRef<HTMLDivElement>(null);
    const dummyContentRef = useRef<HTMLDivElement>(null);

    const [isVisible, setIsVisible] = useState(false);
    const [widths, setWidths] = useState({ scrollWidth: 0, clientWidth: 0 });

    useEffect(() => {
        const tableEl = tableResponsiveRef.current;
        const dummyEl = dummyScrollRef.current;
        if (!tableEl || !dummyEl) return;

        let isSyncingTable = false;
        let isSyncingDummy = false;

        const handleTableScroll = () => {
            if (isSyncingDummy) {
                isSyncingDummy = false;
                return;
            }
            isSyncingTable = true;
            dummyEl.scrollLeft = tableEl.scrollLeft;
        };

        const handleDummyScroll = () => {
            if (isSyncingTable) {
                isSyncingTable = false;
                return;
            }
            isSyncingDummy = true;
            tableEl.scrollLeft = dummyEl.scrollLeft;
        };

        tableEl.addEventListener('scroll', handleTableScroll, { passive: true });
        dummyEl.addEventListener('scroll', handleDummyScroll, { passive: true });

        return () => {
            tableEl.removeEventListener('scroll', handleTableScroll);
            dummyEl.removeEventListener('scroll', handleDummyScroll);
        };
    }, []);

    useEffect(() => {
        const tableEl = tableResponsiveRef.current;
        if (!tableEl) return;

        const updateSizes = () => {
            setWidths({
                scrollWidth: tableEl.scrollWidth,
                clientWidth: tableEl.clientWidth,
            });
        };

        const resizeObserver = new ResizeObserver(updateSizes);
        resizeObserver.observe(tableEl);
        updateSizes();

        const intersectionObserver = new IntersectionObserver(
            ([entry]) => {
                setIsVisible(entry.isIntersecting);
            },
            { rootMargin: '0px 0px -20px 0px' },
        );
        intersectionObserver.observe(tableEl);

        return () => {
            resizeObserver.disconnect();
            intersectionObserver.disconnect();
        };
    }, []);

    const isScrollable = widths.scrollWidth > widths.clientWidth;

    return (
        <>
            {!float && <div className="table-responsive" style={{overflowY: 'auto', height: '350px'}}>{children}</div>}
            {float && (
                <div ref={containerRef} style={{ position: 'relative', width: '100%' }}>
                    {/* Floating Dummy Scrollbar with wide custom track classes */}
                    <div
                        ref={dummyScrollRef}
                        className="floating-scrollbar-track"
                        style={{
                            position: 'fixed',
                            bottom: 40,
                            left: tableResponsiveRef.current?.getBoundingClientRect().left || 0,
                            width: `${widths.clientWidth}px`,
                            overflowX: 'auto',
                            overflowY: 'hidden',
                            zIndex: 99,
                            display: isVisible && isScrollable ? 'block' : 'none',

                            backgroundColor: '#fff', // Light gray solid bar fill
                            borderTop: '1px solid #dee2e6', // Crisp separation line from the table
                            boxShadow: '0 -4px 10px rgba(0,0,0,0.05)', // Subtle lift shadow off the background
                        }}
                    >
                        <div
                            ref={dummyContentRef}
                            style={{
                                width: `${widths.scrollWidth}px`,
                                height: '100%',
                            }}
                        />
                    </div>

                    {/* Standard Bootstrap Native Wrapper */}
                    <div
                        ref={tableResponsiveRef}
                        className="table-responsive table-responsive-hidden-scroll"
                        style={{ overflowX: 'auto', width: '100%' }}
                    >
                        {children}
                    </div>
                </div>
            )}
        </>
    );
};
