const CACHE_NAME = "presence-v2";

const ASSETS_TO_CACHE = [
    "/",
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

                .catch(() => {

                    if (event.request.mode === "navigate") {
                        return caches.match("/offline.html");
                    }

                });

        })

    );

});
self.addEventListener('message', (event) => {
    if (event.data === 'SKIP_WAITING') {
        self.skipWaiting();
    }
});