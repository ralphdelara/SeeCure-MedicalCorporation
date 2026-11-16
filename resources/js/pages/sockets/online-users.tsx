import { useEffect, useState } from 'react';
import { echo } from '@/components/echo';
import { usePage } from '@inertiajs/react';

interface OnlineUser {
    id: number;
    name: string;
}

export default function OnlineUsers({ setOnlineUsers }: {setOnlineUsers: any}) {
    useEffect(() => {
        const channel = echo.join('online-users')
            .here((users: OnlineUser[]) => {
                // Initial list of users already in the channel
                setOnlineUsers(users);
            })
            .joining((user: OnlineUser) => {
                // Add user when they connect
                setOnlineUsers((prev: any) =>
                    prev.some((u: any) => u.id === user.id) ? prev : [...prev, user]
                );
            })
            .leaving((user: OnlineUser) => {
                // Remove user when they disconnect
                setOnlineUsers((prev: any) => prev.filter((u: any) => u.id !== user.id));
            });

        return () => {
            echo.leave('online-users');
        };
    }, []);

    return null;
}