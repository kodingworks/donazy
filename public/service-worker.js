self.addEventListener("install", function (event) {
    event.waitUntil(
        caches.open("static-v1").then(function (cache) {
            return cache.addAll([
                "/offline.html",
                "/css/app.css",
                "/js/app.js",
                "/images/logo.png",
                "/images/donazy.png",
            ]);
        })
    );
});

self.addEventListener("fetch", function (event) {
    event.respondWith(
        caches
            .match(event.request)
            .then(function (response) {
                return response || fetch(event.request);
            })
            .catch(function () {
                if (event.request.mode == "navigate") {
                    return caches.match("/offline.html");
                }
            })
    );
});

self.addEventListener("push", function (event) {
    try {
        const data = event.data.json();

        event.waitUntil(
            self.registration.showNotification(data.title, {
                body: data.body,
                icon: data.icon,
                data: data.data,
            })
        );
    } catch (error) {
        self.registration.showNotification(event.data.text());
    }
});

self.addEventListener("notificationclick", function (event) {
    event.notification.close();
    event.waitUntil(clients.openWindow(event.notification.data));
});
