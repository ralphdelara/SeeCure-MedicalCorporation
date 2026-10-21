import { useEffect } from 'react';
import { echo } from '@/components/echo';
import { usePage } from '@inertiajs/react';
import { frontDesk } from '@/routes';

const NotifyFrontDesk = ({ updateList }: { updateList: () => Promise<void> }) => {
    const { url } = usePage();

    useEffect(() => {
        // Listening to your Laravel Echo channel
        echo.channel('front-desk').listen(
            'NotifyFrontDesk',
            (e: { name: string; message: string; count: number }) => {
                if (url === frontDesk().url) {
                    //router.get(frontDesk().url);
                    updateList();
                }
            },
        );

        return () => {
            echo.leaveChannel('front-desk');
        };
    }, []);

    return <></>;
};

export default NotifyFrontDesk;
