import { useEffect } from 'react';
import { echo } from '@/components/echo';
import { usePage } from '@inertiajs/react';
import toast, { Toaster } from 'react-hot-toast';
import notificationSound from '@/assets/sounds/ding-dong.mp3';
import { IconBellRinging } from '@tabler/icons-react';

interface User {
    id: string;
}

const Notification = ({}) => {
    const { auth } = usePage().props as unknown as {
        auth: { user: User };
    };
    const { user } = auth;

    const dismissNotification = (id: string) => {
        toast.dismiss(id);
    };

    const playSound = async () => {
        const audio = new Audio(notificationSound);
        try {
            audio?.play();
        } catch (e) {
            if (e instanceof Error) {
                console.error(e.message);
                console.error(e.stack);
            } else {
                console.error('An unexpected error occurred:', e);
            }
        }
    };

    useEffect(() => {
        // Listening to your Laravel Echo channel
        echo.channel('call-out').listen(
            'CallOut',
            (e: { name: string; message: string; count: number; doctorId: string }) => {
                // Fire the audio sound effect
                playSound();
            },
        );

        return () => {
            echo.leaveChannel('call-out');
        };
    }, []);

    return (
        <>
            <Toaster position="top-center" reverseOrder={false} />
        </>
    );
};

export default Notification;
