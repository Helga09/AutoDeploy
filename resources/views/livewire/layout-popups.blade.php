<div x-data="{
    popups: {
        sponsorship: true,
        notification: true,
        realtime: false,
    },
    isDevelopment: {{ isDev() ? 'true' : 'false' }},
    init() {
        this.popups.sponsorship = this.shouldShowMonthlyPopup('popupSponsorship');
        this.popups.notification = this.shouldShowMonthlyPopup('popupNotification');
        this.popups.realtime = localStorage.getItem('popupRealtime');

        let checkNumber = 1;
        let checkPusherInterval = null;
        let checkReconnectInterval = null;

        if (!this.popups.realtime) {
            checkPusherInterval = setInterval(() => {
                if (window.Echo) {
                    if (window.Echo.connector.pusher.connection.state === 'connected') {
                        this.popups.realtime = false;
                    } else {
                        checkNumber++;
                        if (checkNumber > 5) {
                            this.popups.realtime = true;
                            console.error(
                                'AutoDeploy не вдалося підключитися до сервісу реального часу. Це спричинить незвичайні проблеми в інтерфейсі, якщо їх не виправити!)'
                            );
                        }

                    }
                }
            }, 2000);
        }
    },
    shouldShowMonthlyPopup(storageKey) {
        const disabledTimestamp = localStorage.getItem(storageKey);

        // If never disabled, show the popup
        if (!disabledTimestamp || disabledTimestamp === 'false') {
            return true;
        }

        // If disabled timestamp is not a valid number, show the popup
        const disabledTime = parseInt(disabledTimestamp);
        if (isNaN(disabledTime)) {
            return true;
        }

        const now = new Date();
        const disabledDate = new Date(disabledTime);

        {{-- if (this.isDevelopment) {
            // In development: check if 10 seconds have passed
            const timeDifference = now.getTime() - disabledDate.getTime();
            const tenSecondsInMs = 10 * 1000;
            return timeDifference >= tenSecondsInMs;
        } else { --}}
        // In production: check if we're in a different month or year
        const isDifferentMonth = now.getMonth() !== disabledDate.getMonth() ||
            now.getFullYear() !== disabledDate.getFullYear();
        return isDifferentMonth;
        {{-- } --}}
    }
}">
</div>