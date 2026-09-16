'use strict';

const CACHE_NAME = 'offline-cache-v1';
const OFFLINE_URL = '/offline.html';

const filesToCache = [OFFLINE_URL, '/logo_text.png'];

self.addEventListener('install', (event) => {
    event.waitUntil(caches.open(CACHE_NAME).then((cache) => cache.addAll(filesToCache)));
});

self.addEventListener('fetch', (event) => {
    // 1. Detect if it's an Inertia JSON request via its custom header
    const isInertiaRequest = event.request.headers.get('X-Inertia') === 'true';

    // 2. Handle standard page navigations
    if (event.request.mode === 'navigate') {
        event.respondWith(fetch(event.request).catch(() => caches.match(OFFLINE_URL)));
    }
    // 3. Handle Inertia AJAX transitions if the server is unreachable
    else if (isInertiaRequest) {
        event.respondWith(
            fetch(event.request).catch(() => {
                // Tell Inertia to perform a hard native window location reload to /offline.html
                // A 409 Conflict status with the X-Inertia-Location header triggers a hard redirect.
                return new Response('', {
                    status: 409,
                    headers: {
                        'X-Inertia-Location': OFFLINE_URL,
                    },
                });
            }),
        );
    }
    // 4. Handle standard assets (CSS, JS, Images)
    else {
        event.respondWith(
            caches.match(event.request).then((response) => response || fetch(event.request)),
        );
    }
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cacheName) => {
                    if (cacheName !== CACHE_NAME) {
                        return caches.delete(cacheName);
                    }
                }),
            );
        }),
    );
});
