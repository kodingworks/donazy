if ("serviceWorker" in navigator) {
    window.addEventListener("load", async () => {
        try {
            const vapidKey = document
                .querySelector('[name="vapid-key"]')
                .getAttribute("content");
            const register = await navigator.serviceWorker.register(
                "/service-worker.js"
            );

            await navigator.serviceWorker.ready;

            if (!("Notification" in window)) {
                console.log("Notification not supported");
                return;
            }

            const notificationPermission =
                await Notification.requestPermission();

            if (notificationPermission !== "granted") {
                console.log("Notification permission denied.");
                return;
            }

            const subscription = await register.pushManager.subscribe({
                userVisibleOnly: true,
                applicationServerKey: urlBase64ToUint8Array(vapidKey),
            });

            document
                .querySelector('meta[name="subscription"]')
                .setAttribute("content", JSON.stringify(subscription));
        } catch (error) {
            console.log(error);
        }
    });

    function urlBase64ToUint8Array(base64String) {
        const padding = "=".repeat((4 - (base64String.length % 4)) % 4);
        const base64 = (base64String + padding)
            .replace(/\-/g, "+")
            .replace(/_/g, "/");

        const rawData = window.atob(base64);
        const outputArray = new Uint8Array(rawData.length);

        for (let i = 0; i < rawData.length; ++i) {
            outputArray[i] = rawData.charCodeAt(i);
        }
        return outputArray;
    }
}
