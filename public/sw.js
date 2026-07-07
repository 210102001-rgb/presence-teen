const CACHE_NAME = 'presence-teen-v1';
const PRECACHE_URLS = [
    '/',
    '/dashboard',
];

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.addAll(PRECACHE_URLS);
        })
    );
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames
                    .filter((name) => name !== CACHE_NAME)
                    .map((name) => caches.delete(name))
            );
        })
    );
});

self.addEventListener('fetch', (event) => {
    const { request } = event;
    const url = new URL(request.url);

    if (url.pathname.startsWith('/api/')) {
        event.respondWith(networkFirst(request));
    } else if (request.mode === 'navigate') {
        event.respondWith(cacheFirst(request));
    } else {
        event.respondWith(cacheFirst(request));
    }
});

self.addEventListener('push', (event) => {
    const data = event.data ? event.data.json() : {};
    const title = data.title || 'PRESENCE-TEEN';
    const options = {
        body: data.body || 'Notifikasi baru',
        icon: '/icons/icon-192.png',
        badge: '/icons/icon-192.png',
    };

    event.waitUntil(self.registration.showNotification(title, options));
});

async function cacheFirst(request) {
    const cached = await caches.match(request);
    if (cached) {
        return cached;
    }
    try {
        const response = await fetch(request);
        if (response.ok) {
            const cache = await caches.open(CACHE_NAME);
            cache.put(request, response.clone());
        }
        return response;
    } catch (error) {
        if (request.mode === 'navigate') {
            const fallback = await caches.match('/');
            if (fallback) return fallback;
        }
        throw error;
    }
}

async function networkFirst(request) {
    try {
        const response = await fetch(request);
        if (response.ok) {
            const cache = await caches.open(CACHE_NAME);
            cache.put(request, response.clone());
        }
        return response;
    } catch (error) {
        const cached = await caches.match(request);
        if (cached) {
            return cached;
        }
        throw error;
    }
}
