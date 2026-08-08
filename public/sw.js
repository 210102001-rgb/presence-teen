const CACHE_NAME = "presence-v3";

const ASSETS_TO_CACHE = [
    "/offline.html",
    "/manifest.json",
    "/icons/icon-192.png",
    "/icons/icon-512.png",
];

// Install
self.addEventListener("install", (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.addAll(ASSETS_TO_CACHE);
        })
    );

    self.skipWaiting();
});

// Activate
self.addEventListener("activate", (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cache) => {
                    if (cache !== CACHE_NAME) {
                        return caches.delete(cache);
                    }
                })
            );
        })
    );

    self.clients.claim();
});

// Fetch
self.addEventListener("fetch", (event) => {

    if (event.request.method !== "GET") return;

    const url = new URL(event.request.url);
    const isSameOrigin = url.origin === self.location.origin;

    if (!isSameOrigin) return;

    // Halaman HTML (navigation) — NETWORK FIRST, jangan pernah di-cache.
    // Halaman authenticated tidak boleh dikembalikan dari cache setelah logout.
    if (event.request.mode === "navigate") {
        event.respondWith(
            fetch(event.request)
                .then((networkResponse) => networkResponse)
                .catch(() => caches.match("/offline.html"))
        );
        return;
    }

    // Asset statis saja yang di-cache (cache-first + runtime caching).
    const isStaticAsset = /\.(css|js|png|jpe?g|svg|gif|ico|woff2?|ttf|eot|webp)$/i.test(url.pathname);

    if (!isStaticAsset) return;

    event.respondWith(
        caches.match(event.request).then((cachedResponse) => {
            if (cachedResponse) {
                return cachedResponse;
            }

            return fetch(event.request)
                .then((networkResponse) => {
                    const responseClone = networkResponse.clone();
                    caches.open(CACHE_NAME).then((cache) => {
                        cache.put(event.request, responseClone);
                    });
                    return networkResponse;
                })
                .catch(() => cachedResponse);
        })
    );
});

self.addEventListener('message', (event) => {
    if (event.data === 'SKIP_WAITING') {
        self.skipWaiting();
    }
});
