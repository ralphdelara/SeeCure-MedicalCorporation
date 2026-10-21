import { Dispatch, SetStateAction, useEffect } from 'react';
import { echo } from '@/components/echo';
import { router, usePage } from '@inertiajs/react';
import { frontDesk } from '@/routes';
import { fetchUrl } from '@/lib/utils';
import { getQueueList } from '@/actions/App/Http/Controllers/FrontDeskController';

const NotifyFrontDesk = ({ setQueueList }: { setQueueList: Dispatch<SetStateAction<any[]>> }) => {
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

    const updateList = async () => {
        const listResponse = await fetchUrl(getQueueList().url, 'get', {});
        console.log(listResponse);
        setQueueList(listResponse);
    };

    useEffect(() => {
        updateList();
    },[]);

    return <></>;
};

export default NotifyFrontDesk;
