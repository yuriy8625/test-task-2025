function startCountdown(elementId) {
    const el = document.getElementById(elementId);

    const target = new Date();
    target.setHours(23, 59, 59, 999);

    function update() {
        const current = new Date();
        let diff = target - current;

        if (diff <= 0) {
            el.textContent = "00:00:00";
            clearInterval(timer);
            return;
        }

        const hours = String(Math.floor(diff / (1000 * 60 * 60))).padStart(2, '0');
        diff %= 1000 * 60 * 60;
        const minutes = String(Math.floor(diff / (1000 * 60))).padStart(2, '0');
        diff %= 1000 * 60;
        const seconds = String(Math.floor(diff / 1000)).padStart(2, '0');

        el.textContent = `${hours}:${minutes}:${seconds}`;
    }

    update();
    const timer = setInterval(update, 1000);
}

/**
 * @param {number} totalItems
 * @param {number} itemsPerPage
 * @param {number} currentPage
 * @param {Function} fetchProducts
 */
