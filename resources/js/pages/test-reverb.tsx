import { useEffect } from 'react';
import { echo } from '@/components/echo'; // Adjust path based on your vite aliases

export default function Dashboard() {
    useEffect(() => {
        echo.channel('consultation')
            .listen('NotifyDoctor', (e: { message: string, username: string }) => {
                console.log(e.message, e.username);
            });

        return () => {
            echo.leaveChannel('consultation');
        };
    }, []);
}