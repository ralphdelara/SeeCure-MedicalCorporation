import { useState, useEffect } from 'react';

// Define the shape of the returned state
interface WindowSizeFlags {
    isLg: boolean;
    isXl: boolean;
}

// Standard Tailwind CSS breakpoints
const BREAKPOINTS = {
    lg: 1024, // lg: 1024px up to 1279px
    xl: 1280, // xl: 1280px and above
} as const;

export function useWindowSize(): WindowSizeFlags {
    const [sizeFlags, setSizeFlags] = useState<WindowSizeFlags>({
        isLg: false,
        isXl: false,
    });

    useEffect(() => {
        // Prevent errors during Server-Side Rendering (SSR)
        if (typeof window === 'undefined') return;

        function handleResize(): void {
            const width = window.innerWidth;

            setSizeFlags({
                isLg: width >= BREAKPOINTS.lg && width < BREAKPOINTS.xl,
                isXl: width >= BREAKPOINTS.xl,
            });
        }

        // Initialize on first mount
        handleResize();

        window.addEventListener('resize', handleResize);

        // Clean up event listener on unmount
        return () => window.removeEventListener('resize', handleResize);
    }, []);

    return sizeFlags;
}
